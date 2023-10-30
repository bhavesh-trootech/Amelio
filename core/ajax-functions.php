<?php
//set session
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

//redirect therapist to homepage
add_action('template_redirect', 'redirect_therapist_role_amelio');
function redirect_therapist_role_amelio() {
    $user = wp_get_current_user();
    if ( (!in_array( 'therapist', (array) $user->roles )) || (!is_user_logged_in()) ) {
        if(is_page( 'clients' ) || is_page( 'therapist-client-invite' ) || is_page( 'therapist-buy-leads' ) || is_page( 'therapist-calendar' ) ){
            wp_redirect(home_url( '/login' ));
            exit();
        }
    }
}
/****/
//login form login page ajax func
add_action( 'wp_ajax_nopriv_login_check', 'loginCheck' );
add_action( 'wp_ajax_login_check', 'loginCheck' );

/**
* login check
*/
function loginCheck() {

    if ( is_user_logged_in() ) {

        echo json_encode( array( 'error' => true, 'message' => 'You are already logged in.' ) );
        die;
    }

    // check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    
   $usernameget = $_POST['loginEmail'];
   $userData = get_user_by( 'email', $usernameget );
   $usernamelogin = $userData->user_login;
   $userLogId = $userData->ID;

    // get the POSTed credentials
    $creds = array();
    $creds['user_login']    = !empty( $usernamelogin ) ? $usernamelogin : null;
    $creds['user_password'] = !empty( $_POST['password'] ) ? $_POST['password'] : null;
    $creds['remember']      = !empty( $_POST['rememberme'] ) ? $_POST['rememberme'] : null;

/*    // check for empty fields
    if( empty( $creds['user_login'] ) || empty( $creds['user_password'] ) ) {

        echo json_encode( array( 'error' => true, 'message' => 'The email or password is cannot be empty' ) );
        die;
    }*/

    // check login
    $userLogged = wp_signon( $creds, false );

    if ( is_wp_error( $userLogged ) ) {

        if ( $userLogged->get_error_code() == "invalid_username" || $userLogged->get_error_code() == "incorrect_password" ) {

            echo json_encode( array( 'error' => true, 'message' => 'The email or password is incorrect.' ) );
            die;

        } else {
            echo json_encode( array( 'error' => true, 'message' => 'The email or password is incorrect.') );
            die;
        }
    }else{
           $user_meta = get_userdata($userLogId);
            $user_roles = $user_meta->roles;
            if(in_array('customer', $user_roles)){
              $redirectUrl = home_url('client-dashboard');
            }
            elseif(in_array('therapist', $user_roles)){
              $redirectUrl = home_url('therapist-dashboard');
            }else{
                $redirectUrl = home_url();
            }
        echo json_encode( array( 'success' => true, 'message' => 'Login successful.', 'redirectUrl' => $redirectUrl ) );
        die;
    }

    echo json_encode( $return );
    die;
}
/****/

//delete user delete custom table record
function amelio_delete_user( $user_id ) 
{
    global $wpdb;
    $user = get_user_by( 'id', $user_id );
    $clientEmailId = $user->user_email;
    
     $table_name = "invitedusers";
     $sessionNotesTable = "cps_client_session_notes";
     $wpdb->query("DELETE FROM $table_name WHERE invitationEmailId='".$clientEmailId."'");
     $wpdb->query($wpdb->prepare("DELETE FROM $sessionNotesTable WHERE client_id = '".$user_id."' "));
}
add_action( 'delete_user', 'amelio_delete_user' );

/****/
function base64_url_encode($input)
{
return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input)
{
return base64_decode(strtr($input, '-_,', '+/='));
}

//therapist client invitation by email
add_action('wp_ajax_invited_user_front_end', 'invited_user_front_end', 0);
add_action('wp_ajax_nopriv_invited_user_front_end', 'invited_user_front_end');
function invited_user_front_end() {
    global $wpdb;
    $invitedusersTable = 'invitedusers';

      $invitationEmail = stripcslashes($_POST['invitationEmail']);
      $therapistUserId = stripcslashes($_POST['therapistUserId']);
      preg_match('/\b\w+\b/i', $invitationEmail, $nameResult);

      $invitationnameArr = explode('@',$invitationEmail);
      $invitationname = $invitationnameArr[0];
      
      $park = $wpdb->get_row("SELECT * FROM $invitedusersTable WHERE invitationEmailId='".$invitationEmail."'");
        
        $todayDate = date("Y-m-d H:i:s"); //date('d F Y');
        $exists = email_exists( $invitationEmail );
        
        if ($park) {
        $result['msg'] = '<p class="error errorMsg">This email has already been invited.</p>'; 
        $result['type'] = "error";
       } elseif ( $exists ) {
            $result['msg'] = '<p class="error errorMsg">User already exists.</p>'; 
            $result['type'] = "error";
        } else{
        $wpdb->insert( $invitedusersTable, array(
            'invitationEmailId' => $_POST['invitationEmail'], 
            'therapistUserId' => $_POST['therapistUserId'],
            'inviteMethod' => 'Email Invite',
            'status' => "invited", 
            'date' => $todayDate,
            'clientNames' => $invitationname
             ),
            array( '%s', '%d', '%s', '%s', '%s' ) 
        );
        $invitedInsertedId = $wpdb->insert_id;
      }

      //$user_id = wp_insert_user($user_data);
        if (!empty($invitedInsertedId)) { 
            //update_user_meta( $user_id, 'first_name', $new_user_name );
          $result['msg'] = '<p class="successMsg">Email sent successfully.</p>';
          $result['type'] = "success";
          
          $current_userInfo = wp_get_current_user();
          $therapistName = $current_userInfo->display_name;
          $currentUserId = get_current_user_id();
          $invitedRowcount = $wpdb->get_var("SELECT COUNT(*) FROM $invitedusersTable WHERE therapistUserId='".$currentUserId."' AND status = 'invited'");
          $result['invitedCount'] = $invitedRowcount;

          $signupClientLink = home_url().'/client-signup/?therapist='.base64_url_encode($therapistUserId).'&email='.base64_url_encode($invitationEmail);

  //to client
      $to = $invitationEmail; //sendto@example.com
      $subject = 'You received an invitation to join Amelio';
      $body = '<html>
<body>
<center>
    <table width="685" style="border:10px solid #165342; padding:0; text-align:left; font-family:Verdana, Geneva, sans-serif; font-size:12px;" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr style="background-color:#165342;">
            <td align="left" valign="middle" style="border-bottom:3px solid #165342;padding:10px;text-align:center;">
                <a href="'.home_url().'">
                    <img src="'.home_url().'/wp-content/themes/astra-child/image/amelio-icon.png" alt="Amelio" title="Amelio" border="0" />
                </a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" style="padding:25px; font-family:Verdana, Geneva, sans-serif;">
                <br>
                Hi!<br><br>
                You were invited by '.ucfirst($therapistName).' to join Amelio.<br><br>
                Please click the link below and sign up.<br>
                <p><a href="'.$signupClientLink.'">'.$signupClientLink.'</a></p>
                <p>Thank you.</p>
                <br />

            </td>
        </tr>
    </table>
</center>
</body>
</html>';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail( $to, $subject, $body, $headers );


        }
        echo json_encode($result);
    die;
}

/*****/
//delete client 
add_action('wp_ajax_delete_invited_user_front_end', 'delete_invited_user_front_end', 0);
add_action('wp_ajax_nopriv_delete_invited_user_front_end', 'delete_invited_user_front_end');
function delete_invited_user_front_end() {
    global $wpdb;
    $invitedusersTable = 'invitedusers';
    $sessionNoteTable = 'cps_client_session_notes';

      $invitationEmail = stripcslashes($_POST['invitationEmail']);
      $therapistUserId = stripcslashes($_POST['therapistUserId']);
      $dataStatus = $_POST['dataStatus'];
      
      $deletePark = $wpdb->delete( $invitedusersTable, array( 'invitationEmailId' => $invitationEmail ) );
        $result = array();
        if ($deletePark) {
        // $result['msg'] = '<p class="successMsg">Client deleted successfully.</p>';
        // $result['type'] = "success";

            $userDeleteObj = get_user_by( 'email', $invitationEmail );
            $userDeleteId = $userDeleteObj->ID;
            wp_delete_user($userDeleteId);

            $currentUserId = get_current_user_id();
            $invitedRowcount = $wpdb->get_var("SELECT COUNT(*) FROM $invitedusersTable WHERE therapistUserId='".$currentUserId."' AND status = 'invited'");
            $result['invitedCount'] = $invitedRowcount;

            $wpdb->query($wpdb->prepare("DELETE FROM $sessionNoteTable WHERE client_id = '".$userDeleteId."' AND therapist_id = '".$currentUserId."' "));

            // Event delete start

            $table_name = $wpdb->prefix . "events";

            $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$invitationEmail."' AND therapist_id = '" . $therapistUserId . "'");
            
                // echo count($events);


            if(count($events) > 0){
                $refresh_token = get_user_meta($therapistUserId, "refresh_token", true);
                $access_token_string = get_user_meta($therapistUserId, "access_token", true);
                $access_token = generateAccessToken($access_token_string, $refresh_token);
                foreach ($events as $event_result) {
                    $event_id = $event_result->id;
                    $calendar_id = 'primary';
                    $url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events/'.$event_id;
                    $ch = curl_init();      
                    curl_setopt($ch, CURLOPT_URL, $url_events);     
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');      
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
                    $data = json_decode(curl_exec($ch), true);
                    $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
                    if($http_code == 204){
                        // echo 'test--';
                        $delete_event = $wpdb->delete($table_name, ["id" => $event_id]);
                    }
                }
                $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$invitationEmail."' AND therapist_id = '" . $therapistUserId . "'");
                // echo "----";
                //  print_r($events);
                // echo "<<---->> ";

                // echo "Count -> ".count($events);
                if(count($events) == 0){
                    $result["type"] = "success";
                    $result["msg"] = "This email all events deleted";
                }else{
                    $result["type"] = "error";
                    $result["msg"] = "Something went wrong!";
                }
            }
            else{
                // $result["type"] = "error";
                // $result["msg"] = "data not found!";
                    $result["type"] = "success";
                    $result["msg"] = "Client Deleted";
            }
       }else{
            $result['msg'] = '<p class="error errorMsg">Something went wrong.</p>'; 
            $result['type'] = "error";
        }
        // print_r($result);
        echo json_encode($result);
    exit();
}
/****/

add_action('wp_ajax_resent_invitation_user_front_end', 'resent_invitation_user_front_end', 0);
add_action('wp_ajax_nopriv_resent_invitation_user_front_end', 'resent_invitation_user_front_end');
function resent_invitation_user_front_end() {
    global $wpdb;
    $invitedusersTable = 'invitedusers';

      $invitationEmail = stripcslashes($_POST['invitationEmail']);
      $therapistUserId = stripcslashes($_POST['therapistUserId']);
      preg_match('/\b\w+\b/i', $invitationEmail, $nameResult);
      $userEml = get_user_by( 'email', $invitationEmail );
      $userIdEmail = $userEml->ID;
      $nameArry = explode("@",$invitationEmail);
      $nameArr = str_replace(".","_",$nameArry[0]);

      //$user_id = wp_insert_user($user_data);
        if (!empty($invitationEmail)) {
            //update_user_meta( $user_id, 'first_name', $new_user_name );
          $result['msg'] = '<p class="successMsg">Email sent successfully.</p>';
          $result['type'] = "success";
          $result['userEml'] = $nameArr;

          $signupClientLink = home_url().'/client-signup/?therapist='.base64_url_encode($therapistUserId).'&email='.base64_url_encode($invitationEmail);
          

  //to client
      $to = $invitationEmail; //sendto@example.com
      $subject = 'You have received a new invitation from Amelio';
      $body = '<html>
<body>
<center>
    <table width="685" style="border:10px solid #165342; padding:0; text-align:left; font-family:Verdana, Geneva, sans-serif; font-size:12px;" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr style="background-color:#165342;">
            <td align="left" valign="middle" style="border-bottom:3px solid #165342;padding:10px;text-align:center;">
                <a href="'.home_url().'">
                    <img src="'.home_url().'/wp-content/themes/astra-child/image/amelio-icon.png" alt="Amelio" title="Amelio" border="0" />
                </a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" style="padding:25px; font-family:Verdana, Geneva, sans-serif;">
                <br>
                Dear <b>'.ucfirst($nameResult[0]).',</b><br><br>
                You have received a new email from Amelio for invitation to join.<br><br>
                Please click below link and Sign up:<br>
                <p><a href="'.$signupClientLink.'">Click here for Sign up</a></p> 
                <br>

                <b>Thank You,</b> <br>
                <a href="'.home_url().'">Amelio</a>
                <br />

            </td>
        </tr>
    </table>
</center>
</body>
</html>';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail( $to, $subject, $body, $headers );
        }
        echo json_encode($result);
    die;
}

/***/
//client list load more
add_action('wp_ajax_load_clients_user_by_ajax', 'load_clients_user_by_ajax_callback');
add_action('wp_ajax_nopriv_load_clients_user_by_ajax', 'load_clients_user_by_ajax_callback');
function load_clients_user_by_ajax_callback() {
    check_ajax_referer('load_more_clients_users', 'security');
   
    $paged = $_POST['page'];
    $searchVal = $_POST['searchVal'];

    if(isset($_SESSION['NameOrderFilter'])) {
    $order = $_SESSION["NameOrderFilter"];
    $orderBy = 'meta_value';
    } elseif(isset($_SESSION['dateOrderFilter'])){
        $order = $_SESSION["dateOrderFilter"];
        $orderBy = 'registered';
    }else{
        $order = "ASC";
        $orderBy = 'meta_value';
    }

$currentUser = get_current_user_id();
$clientArgs = array (
    'role' => 'customer',
    'meta_key' => 'first_name',
    'orderby'  => $orderBy,
    'order' => $order,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'client_therapist_id',
            'value'   => $currentUser,
            'compare' => '='
        ),
        array(
            'key'     => 'client_status',
            'value'   => 'active client',
            'compare' => '='
        ),
        array(
            'relation' => 'OR',
        array(
            'key'     => 'first_name',
            'value'   => $searchVal,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'last_name',
            'value'   => $searchVal,
            'compare' => 'LIKE'
        )
        )
    ),
    'number' => 6,
    'paged' => $paged,
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($clientArgs); 

$clients = $wp_user_query->get_results();
    ?>
    <?php if (!empty($clients)) {
    foreach ($clients as $client)
    { 
        // get all the user's data
        $author_info = get_userdata($client->ID);
        $clientFirstname = $author_info->first_name;
        $clientLastname = $author_info->last_name;
        if($clientLastname == ""){
            $explodeStr = explode(" ",$clientFirstname);
            $clientLastnamestr = $explodeStr[1];
        }
        $clientEmail = $author_info->user_email;
        global $wpdb;
        $invitedusersTable = 'invitedusers';
        $clientdate = $wpdb->get_var("SELECT `date` FROM $invitedusersTable WHERE invitationEmailId='".$clientEmail."'");
        $clientdate = date("d F Y", strtotime($clientdate));
        /*$datearr = explode("-",$clientdate);
        $dateNum= $datearr[0];
        $monthNum= $datearr[1];
        $yearNum= $datearr[2];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March*/
        ?>
        <div class="client-white-columns" data-id="<?php echo $client->ID; ?>">
                    <div class="column-heading">
                        <h3 class=""><?php echo substr($clientFirstname, 0, 1); ?><?php if(!empty($clientLastname)) { echo substr($clientLastname, 0, 1); } else { echo substr($clientLastnamestr, 0, 1); } ?></h3>
                    </div>

                    <div class="client-name">
                        <div class="client-name-details">
                            <p><?php echo $clientFirstname." ".$clientLastname; ?></p>
                            <h6>Client since: <?php echo $clientdate; ?></h6>
                        </div>

                        <div class="right-arrow-image">
                            <img src="<?=get_stylesheet_directory_uri()?>/image/chevron-right.svg" alt="logout">
                        </div>

                    </div>
                </div>
            <?php
    }
} ?>
        <?php
 
    wp_die();
}
/****/

//client list filter by name, date
add_action('wp_ajax_filter_client_data_by_name', 'filter_client_data_by_name');
add_action('wp_ajax_nopriv_filter_client_data_by_name', 'filter_client_data_by_name');
function filter_client_data_by_name() {
    
    unset($_SESSION['dateFilterActive']);
    unset($_SESSION['dateOrderFilter']);
    unset($_SESSION['NameOrderFilter']);
    $selectedFilter = $_POST['selectedFilter'];
    if(!empty($selectedFilter)){
        session_start();
        $_SESSION["NameOrderFilter"] = $selectedFilter;
        $_SESSION["nameFilterActive"] = "nameFilterActive";
    }
 
    wp_die();
}

//client list filter by name, date
add_action('wp_ajax_filter_client_data_by_date', 'filter_client_data_by_date');
add_action('wp_ajax_nopriv_filter_client_data_by_date', 'filter_client_data_by_date');
function filter_client_data_by_date() {
    
    unset($_SESSION['nameFilterActive']);
    unset($_SESSION['NameOrderFilter']);
    unset($_SESSION['dateOrderFilter']);
    $selectedFilter = $_POST['selectedFilter'];
    if(!empty($selectedFilter)){
        session_start();
        $_SESSION["dateOrderFilter"] = $selectedFilter;
        $_SESSION["dateFilterActive"] = "dateFilterActive";
    }
 
    wp_die();
}

/****/
//client list page search input
add_action('wp_ajax_clientlist_search_input_data', 'clientlist_search_input_data_callback');
add_action('wp_ajax_nopriv_clientlist_search_input_data', 'clientlist_search_input_data_callback');
function clientlist_search_input_data_callback() {
   
    //$paged = $_POST['page'];
    $searchVal = $_POST['searchVal'];

$currentUser = get_current_user_id();
if(isset($_SESSION['NameOrderFilter'])) {
    $order = $_SESSION["NameOrderFilter"];
    $orderBy = 'meta_value';
    } elseif(isset($_SESSION['dateOrderFilter'])){
        $order = $_SESSION["dateOrderFilter"];
        $orderBy = 'registered';
    }else{
        $order = "ASC";
        $orderBy = 'meta_value';
    }

if($searchVal !=""){
$clientArgs = array (
    'role' => 'customer',
    'meta_key' => 'first_name',
    'orderby'  => $orderBy,
    'order' => $order,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'client_therapist_id',
            'value'   => $currentUser,
            'compare' => '='
        ),
        array(
            'key'     => 'client_status',
            'value'   => 'active client',
            'compare' => '='
        ),
        array(
            'relation' => 'OR',
        array(
            'key'     => 'first_name',
            'value'   => $searchVal,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'last_name',
            'value'   => $searchVal,
            'compare' => 'LIKE'
        ),
        )
    ),
    'number' => 6,
    //'paged' => $paged,
);

} else{
   $clientArgs = array (
    'role' => 'customer',
    'meta_key' => 'first_name',
    'orderby'  => $orderBy,
    'order' => $order,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'client_therapist_id',
            'value'   => $currentUser,
            'compare' => '='
        ),
        array(
            'key'     => 'client_status',
            'value'   => 'active client',
            'compare' => '='
        )
    ),
    'number' => 6,
    //'paged' => $paged,
); 
}

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($clientArgs); 
$totalUsers = $wp_user_query->get_total(); 
$rec_page = 6;
$total_pages = ceil($totalUsers / $rec_page);
$clients = $wp_user_query->get_results();

    ?>
    <?php if (!empty($clients)) {
    foreach ($clients as $client)
    { 
        // get all the user's data
        $author_info = get_userdata($client->ID);
        $clientFirstname = $author_info->first_name;
        $clientLastname = $author_info->last_name;
        if($clientLastname == ""){
            $explodeStr = explode(" ",$clientFirstname);
            $clientLastnamestr = $explodeStr[1];
        }
        $clientEmail = $author_info->user_email;
        global $wpdb;
        $invitedusersTable = 'invitedusers';
        $clientdate = $wpdb->get_var("SELECT `date` FROM $invitedusersTable WHERE invitationEmailId='".$clientEmail."'");
        $clientdate = date("d F Y", strtotime($clientdate));
        /*$datearr = explode("-",$clientdate);
        $dateNum= $datearr[0];
        $monthNum= $datearr[1];
        $yearNum= $datearr[2];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March*/
        if(!empty($clientLastname)) { $clientLastnameLet = substr($clientLastname, 0, 1); } else { $clientLastnameLet = substr($clientLastnamestr, 0, 1); }
        ?>
        <?php $html[] = '<div class="client-white-columns" data-id="'.$client->ID.'">
                    <div class="column-heading">
                        <h3 class="">'.substr($clientFirstname, 0, 1).$clientLastnameLet.'</h3>
                    </div>

                    <div class="client-name">
                        <div class="client-name-details">
                            <p>'.$clientFirstname." ".$clientLastname.'</p>
                            <h6>Client since: '.$clientdate.'</h6>
                        </div>

                        <div class="right-arrow-image">
                            <img src="'.get_stylesheet_directory_uri().'/image/chevron-right.svg" alt="">
                        </div>

                    </div>
                </div>'; ?>
            <?php
    }
    $results['responsehtml'] = $html;
    $results['total_pages'] = $total_pages;
    $results['page'] = 1;
    $results['type'] = "success";

    } else{
        $results['responsehtml'] = "<p class='searchNoClientDiv'>No client found.</p>";
    }
    $results['totalUsers'] = $totalUsers;

 ?>
        <?php

    echo json_encode($results);
    die;
}

/****/
//client detail popup
add_action('wp_ajax_client_details_popup', 'client_details_popup', 0);
add_action('wp_ajax_nopriv_client_details_popup', 'client_details_popup');
function client_details_popup() {

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

    $timezone = $_POST['timezone'];
    $clientUserId = $_POST['clientUserId'];
    $author_info = get_userdata($clientUserId);
    $userdata = get_user_meta($clientUserId);
    $clientFirstname = $author_info->first_name;
    $clientLastname = $author_info->last_name;
    if($clientLastname == ""){
        $explodeStr = explode(" ",$clientFirstname);
        $clientLastnamestr = $explodeStr[1];
    }
    $clientEmail = $author_info->user_email;
    
    global $wpdb;
    $invitedusersTable = 'invitedusers';
    $clientdate = $wpdb->get_var("SELECT `date` FROM $invitedusersTable WHERE invitationEmailId='".$clientEmail."'");
    $clientdate = date("d F Y", strtotime($clientdate));
    /*$datearr = explode("-",$clientdate);
    $dateNum= $datearr[0];
    $monthNum= $datearr[1];
    $yearNum= $datearr[2];
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March*/
    ?>
    <div class="user-detail-navbar">

                    <div class="user-detail-text-image">
                        <a href="javascript:void(0)"><img src="<?=get_stylesheet_directory_uri()?>/image/arrow-right.svg" alt=""></a>
                        <h5>Client Details</h5>
                    </div>

                    <a href="#"><img src="<?=get_stylesheet_directory_uri()?>/image/more.svg" alt=""></a>
            </div>
            <div class="user-close-arrow">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img src="<?=get_stylesheet_directory_uri()?>/image/close-arrow.svg" alt="send"></a>
            </div>
            <div class="user-wrapper-detail">

            <div class="user-wrapper-inner">

            
            <div class="userdetail-name">
                    <!-- <div class="user-close-arrow">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img src="<?=get_stylesheet_directory_uri()?>/image/close-arrow.svg" alt="send"></a>
                    </div> -->
                    <h3 class="client-white-heading"><?php echo substr($clientFirstname, 0, 1); ?><?php if(!empty($clientLastname)) { echo substr($clientLastname, 0, 1); } else { echo substr($clientLastnamestr, 0, 1); } ?></h3>
                    <h2><?php echo $clientFirstname." ".$clientLastname; ?></h2>
                    
            </div>

            <p>Client since: <?php echo $clientdate; ?></p>
            <?php 
            global $wpdb;
            $therapist_id = get_current_user_id();
            $table_name = $wpdb->prefix . "events";

            $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$clientEmail."' AND therapist_id = '" . $therapist_id . "' AND start_datetime > NOW() ORDER BY start_datetime ASC LIMIT 1");
            if(count($events) > 0){
                foreach ($events as $fetch_event) {
                    $start_time = new DateTime($fetch_event->start_datetime, new DateTimeZone('UTC'));
                    $start_time->setTimezone(new DateTimeZone($_POST['timezone']));
                    $start_time->format('Y-m-d H:i:s');
                    $c_date = json_decode(json_encode($start_time), true);
                    $creatdatetime = $c_date['date'].'<br/>';
                    $newdate = explode(".",$creatdatetime);         
                    $creatdatetime = date('d M Y, h:i A', strtotime($newdate[0])); 
                    echo '<p class="next-session">Next session: '.$creatdatetime.'</p>';

                }
            }
            ?>

            <?php if(!empty($userdata['description'][0])): ?>
            <h6><span>About <?php echo $clientFirstname; ?>:</span> <?php echo $userdata['description'][0]; ?> </h6>
            <?php endif; ?>

            <!-- <button onclick="myFunction()" id="myBtn"> -->
            <button onclick="myFunction()" id="myBtn" class="moreless-button">
                    Read more
            </button>
            
            <div class="user-detail-button">
                    <a href="/therapist-calendar" class="user-detail-button-1"><img src="<?=get_stylesheet_directory_uri()?>/image/calendar-green.svg" alt="schedule">Schedule Session</a>
                    <a href="" class="user-detail-button-2 create-session-notes-btn" data-client-id="<?=$clientUserId?>"><img src="/wp-content/uploads/2023/02/Group-13150.svg" alt="create">Create Notes</a>
                </div>
                
           </div>

            <div class="user-detail-page-2">
                    <h4>Upcoming Session</h4>
<?php
                /*    <div class="upcoming-session">
                        <div class="upcoming-session-left">
                            <h5>John Darling</h5>
                            <div class="upcoming-session-date">
                                <img src="<?php get_stylesheet_directory_uri(); ?>/image/date-bag.svg" alt="logout">
                                <h6>22 Sept 2022, 1:00PM</h6>
                            </div>
                        </div>
                        <div class="upcoming-session-right">
                            <img src="<?php get_stylesheet_directory_uri(); ?>/image/chevron-right.svg" alt="logout">
                        </div>
                    </div> */
                    ?>
<?php

                    global $wpdb;
                    $therapist_id = get_current_user_id();
                    $table_name = $wpdb->prefix . "events";

                    $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$clientEmail."' AND therapist_id = '" . $therapist_id . "' AND start_datetime > NOW() ORDER BY start_datetime ASC LIMIT 1");
                    // start_datetime > NOW() OR 

                    if(count($events) > 0){
                        foreach ($events as $fetch_event) {
                    
                            // print_r($fetch_event);exit();
                            $start_time = new DateTime($fetch_event->start_datetime, new DateTimeZone('UTC'));
                            $start_time->setTimezone(new DateTimeZone($_POST['timezone']));
                            $start_time->format('Y-m-d H:i:s');
                            $c_date = json_decode(json_encode($start_time), true);
                            $creatdatetime = $c_date['date'].'<br/>';
                            $newdate = explode(".",$creatdatetime);         
                            $creatdatetime = date('d M Y, h:i A', strtotime($newdate[0])); 

                            echo '<div class="upcoming-session" data-clientId="'.$clientUserId.'" data-event="'.$fetch_event->id.'" onclick="DisplayUpcomingEventDetails(this);">
                                <div class="upcoming-session-left">
                                    <h5>'.$fetch_event->summary.'</h5>
                                    <div class="upcoming-session-date">
                                        <img src="'.get_stylesheet_directory_uri().'/image/date-bag.svg" alt="logout">
                                        <h6>'.$creatdatetime.'</h6>
                                    </div>
                                </div>
                                <div class="upcoming-session-right">
                                    <img src="'.get_stylesheet_directory_uri().'/image/chevron-right.svg" alt="logout">
                                </div>
                            </div>';
                            }
                    }else{
                        echo '<div class="no_record">No Sessions Found!</div>';
                    }

                    ?>


                    <?php
                    global $wpdb;
                    $tblname = 'client_session_notes';
                    $wp_track_table = $wpdb->prefix."$tblname";

                    $result_session_notes = $wpdb->get_results( "SELECT * FROM $wp_track_table WHERE client_id = $clientUserId ORDER BY creatdatetime DESC");

                    if(count($result_session_notes) > 0){ 
                    ?>
                    <div class="session-notes">
                        <h4>Session Notes</h4>
                    </div>
                 <?php
                  }
                    ?>

                    <div class="session_note_main">
                    <?php
                        foreach($result_session_notes as $note){
                            $start_time = new DateTime($note->creatdatetime, new DateTimeZone('UTC'));
                            $start_time->setTimezone(new DateTimeZone($_POST['timezone']));
                            $start_time->format('Y-m-d H:i:s');
                            $c_date = json_decode(json_encode($start_time), true);
                            $client_popup = $note->id;
                            $client_id = $note->client_id;
                            $session_title = $note->session_title.'<br/>';
                            $session_note = $note->session_note.'<br/>';
                            $creatdatetime = $c_date['date'].'<br/>';
                            $newdate = explode(".",$creatdatetime);         
                            $creatdatetime = date('d M Y, h:i A', strtotime($newdate[0]));  
                                
                            ?>
                            
                            <div class="session-note-content">
                                <div class="edit-actions">
                                   <p><?php echo $creatdatetime; ?></p>
                                   <span> <a class="edit edit-detail-button" onClick="DisplayClientNoteDetails(this);" data-client-popup="<?php echo $client_popup._.$client_id; ?> " data-client-id="<?php echo $client_id; ?> " href="#">Edit</a> /
                                    <a class="delete note-delete" data-client="<?php echo $client_popup._.$client_id; ?> " data-client-id="<?=$client_id?>" href="#">Delete</a></span>
                                </div>
                                <div class="note-content-wrap">
                                    <h2 class="note-title"><?=$session_title?></h2>
                                    <h6 class="session-note"><?=$session_note?></h6>
                                </div>
                                
                            </div>
                           
                        <?php
                        }
                        ?>
                    </div>
<!--                     <div class="session-note-content">
                        <div class="edit-actions">
                           <p>22 Sept, 22. 1:00PM</p>
                           <span> <a class="edit" href="#">Edit</a> /
                            <a class="delete" href="#">Delete</a></span>
                        </div>
                        <div class="note-content-wrap">
                            <h2 class="note-title">note title</h2>
                            <h6 class="session-note">Lorem ipsum dolor sit amet consectetur. Auctor dui semper in vitae lectus volutpat pellentesque. Et libero porttitor volutpat amet risus.</h6>
                        </div>
                        
                    </div> -->

                    <!-- <div class="session-note">
                        <h4>Recent Messages</h4>
                        <a href="">View in chat</a>
                    </div>

                    <div class="session-note-content">
                        <p>5MIN AGO</p>
                        <h6>Lorem ipsum dolor sit amet consectetur. Auctor dui semper in vitae lectus volutpat pellentesque. Et libero porttitor volutpat amet risus.</h6>
                    </div> -->
            </div> 
            </div>
            <?php
      
     wp_die();
}

/****/
//sign-up-as-a-professional go back button
add_action('wp_ajax_profession_signup_goback', 'profession_signup_goback', 0);
add_action('wp_ajax_nopriv_profession_signup_goback', 'profession_signup_goback');
function profession_signup_goback() {

 $user = wp_get_current_user();
 $roles = ( array ) $user->roles;

    $referralUrl = esc_url($_POST['referralUrl']);
    $checkoutUrl = home_url('/checkout/');

    if( is_user_logged_in() && (in_array( 'therapist', $roles)) && ($referralUrl == $checkoutUrl) ) {
    $httpReferer = home_url('/therapist-dashboard/');
    }else if( is_user_logged_in() && (in_array( 'customer', $roles)) && ($referralUrl == $checkoutUrl) ){
     $httpReferer = home_url('/client-dashboard/');
    }else if(!empty($referralUrl) && (!is_user_logged_in()) ) {
        $httpReferer = $referralUrl;
    }else if(!empty($referralUrl) && (is_user_logged_in()) && (in_array( 'administrator', $roles)) ) {
        $httpReferer = $referralUrl;
    } else {
        $httpReferer = home_url('/login/');
    }
          $result['redirectUrl'] = $httpReferer;
          $result['type'] = "success";

        echo json_encode($result);
    die;
}



/****/
//create_client_session_note
add_action('wp_ajax_create_client_session_note', 'client_session_note', 0);
add_action('wp_ajax_nopriv_create_client_session_note', 'client_session_note');
function client_session_note() {

    global $wpdb;

    $html = '';
    $tblname = 'client_session_notes';
    $res = array();
    $wp_track_table = $wpdb->prefix."$tblname";


    $clientUserId = $_POST['clientUserId'];
    $session_title = $_POST['session_title'];
    $session_note = $_POST['session_note'];
    $therapist_id = get_current_user_id();
    $wpdb->insert($wp_track_table, array(
        'client_id' => $clientUserId,
        'session_title' => $session_title,
        'session_note' => $session_note,
        'creatdatetime' => current_time('mysql', 1),
        'therapist_id' => $therapist_id
    ));

    $insert_id = $wpdb->insert_id;

    // if ($insert_id != '0' && $insert_id != '') {

        $fetch_data = $wpdb->get_results("SELECT * FROM $wp_track_table WHERE client_id='".$clientUserId."'");
        // print_r($fetch_data);
        if(!empty($fetch_data) && $fetch_data != ''){

            foreach ($fetch_data as $results) {
                // print_r($results->creatdatetime);
                $html .= '<div class="session-note-content">
                                <div class="edit-actions">
                                   <p>'.$results->creatdatetime.'</p>
                                   <span> <a class="edit edit-detail-button" onclick="DisplayClientNoteDetails(this);" data-client-popup="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Edit</a> /
                                    <a class="delete note-delete" data-client="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Delete</a></span>
                                </div>
                                <div class="note-content-wrap">
                                    <h2 class="note-title">'.$results->session_title.'</h2>
                                    <h6 class="session-note">'.$results->session_note.'</h6>
                                </div>
                            </div>';
            }
        }
    // }
    // echo "dsfdsfdsf----->>>>".$insert_id;
    if($insert_id > 0){
        $res['status'] = 'done';
        $res['messages'] = 'Session note has been created successfully


';
        $res['data'] = $html;
    }
    else{
        $res['status'] = 'error';
        $res['messages'] = 'Something went wrong! Please try again later.';
    }

    echo json_encode($res);
    exit();
}


/****/
//get client note detail
add_action('wp_ajax_get_session_note_details', 'client_session_note_details', 0);
add_action('wp_ajax_nopriv_get_session_note_details', 'client_session_note_details');
function client_session_note_details(){
    global $wpdb;
    $tblname = 'client_session_notes';
    $wp_track_table = $wpdb->prefix."$tblname";
    $detail_array = array();
    $res = array();
    $note_id = $_POST['note_edit_id'];
    $explode_id = explode("_",$note_id);
    $detail_id = $explode_id[0];
    $client_id = $explode_id[1];

    $data = $wpdb->get_results("SELECT * FROM $wp_track_table WHERE id='".$detail_id."' AND client_id='".$client_id."' ORDER BY creatdatetime DESC");

    if(!empty($data)){
        foreach ($data as  $result) {
            $detail_array['session_title'] = $result->session_title;
            $detail_array['session_note'] = $result->session_note;
            $detail_array['id'] = $note_id;
            $detail_array['creatdatetime'] = $result->creatdatetime;
        }    
    }

    if(!empty($detail_array['session_title']) && $detail_array['session_title'] != ''){

            $res['status'] = 'done';
            $res['message'] = 'detail found';
            $res['data'] = $detail_array;
        }else{
            $res['status'] = 'error';
            $res['message'] = 'Session detail not found';
        }
    echo json_encode($res);
    exit();

}

/****/
//Edit Session Note
add_action('wp_ajax_edit_session_note', 'edit_client_session_note', 0);
add_action('wp_ajax_nopriv_edit_session_note', 'edit_client_session_note');
function edit_client_session_note(){
    global $wpdb;
    $tblname = 'client_session_notes';
    $wp_track_table = $wpdb->prefix."$tblname";
    $detail_array = array();
    $res = array();
    $note_id = $_POST['note_id'];
    $explode_id = explode("_",$note_id);
    $noteid = $explode_id[0];
    $client_id = $explode_id[1];
    $session_title = $_POST['session_title'];
    $session_note = $_POST['session_note'];

    $result = $wpdb->update($wp_track_table, array('session_title' => $session_title,
    'session_note' => $session_note), array('id' => $noteid), array('%s', '%s'),
     array('%d'));

    $fetch_data = $wpdb->get_results("SELECT * FROM $wp_track_table WHERE client_id='".$client_id."' ORDER BY creatdatetime DESC");
    // print_r($fetch_data);
    if(!empty($fetch_data) && $fetch_data != ''){

        foreach ($fetch_data as $results) {
            
            $html .= '<div class="session-note-content">
                            <div class="edit-actions">
                               <p>'.$results->creatdatetime.'</p>
                               <span> <a class="edit edit-detail-button" onclick="DisplayClientNoteDetails(this);" data-client-popup="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Edit</a> /
                                <a class="delete note-delete" data-client="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Delete</a></span>
                            </div>
                            <div class="note-content-wrap">
                                <h2 class="note-title">'.$results->session_title.'</h2>
                                <h6 class="session-note">'.$results->session_note.'</h6>
                            </div>
                        </div>';
        }

    }

    if($result > 0){
        $res['status'] = 'done';
        $res['message'] = 'Session note has been updated successfully';
        $res['data'] = $html;
    }
    else{
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong! Please try again later.';
    }

    echo json_encode($res);
    exit();
}

/****/
//Delete Session Note
add_action('wp_ajax_delete_session_note', 'delete_client_session_note', 0);
add_action('wp_ajax_nopriv_delete_session_note', 'delete_client_session_note');
function delete_client_session_note(){
    global $wpdb;
    $tblname = 'client_session_notes';
    $wp_track_table = $wpdb->prefix."$tblname";
    $note_id = $_POST['note_id'];
    $explode_id = explode("_",$note_id);
    $noteid = $explode_id[0];
    $client_id = $explode_id[1];
    $html = '';
    $rec = $wpdb->delete( $wp_track_table, array( 'id' => $noteid ) );

    $fetch_data = $wpdb->get_results("SELECT * FROM $wp_track_table WHERE client_id='".$client_id."' ORDER BY creatdatetime DESC");
    // print_r($fetch_data);
    if(!empty($fetch_data) && $fetch_data != ''){

        foreach ($fetch_data as $results) {
            
            $html .= '<div class="session-note-content">
                            <div class="edit-actions">
                               <p>'.$results->creatdatetime.'</p>
                               <span> <a class="edit edit-detail-button" onclick="DisplayClientNoteDetails(this);" data-client-popup="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Edit</a> /
                                <a class="delete note-delete" data-client="'.$results->id.'_'.$results->client_id.'" data-client-id="'.$results->client_id.'" href="#">Delete</a></span>
                            </div>
                            <div class="note-content-wrap">
                                <h2 class="note-title">'.$results->session_title.'</h2>
                                <h6 class="session-note">'.$results->session_note.'</h6>
                            </div>
                        </div>';
        }

    }else{
        $html .= '<span class="no_record">No Records</span>';
    }
    if(!empty($html) && $html != ''){
            $res['status'] = 'done';
            $res['message'] = 'Session note has been deleted successfully.';
            $res['data'] = $html;
        }else{
            $res['status'] = 'error';
            $res['message'] = 'Something went wrong! Please try again later.';
        }
    echo json_encode($res);
    exit();
}


add_action("wp_ajax_day_click_event_rendar", "day_click_event_rendar_func");
add_action("wp_ajax_nopriv_day_click_event_rendar", "day_click_event_rendar_func");
function day_click_event_rendar_func()
{
    global $wpdb;
    $therapist_id = get_current_user_id();
    $table_name = $wpdb->prefix . "events";
    $s_datetime = $_POST['start'];
    // print_r($s_datetime);exit();
    $events = $wpdb->get_results("select * from " . $table_name . ' where therapist_id = "' . $therapist_id . '" AND start_Date = "' . date($s_datetime) . '" ORDER BY start_datetime ASC');

     foreach ($events as $event) {
        $jsonArray = json_decode($event->zoom_api_data,true);
        // echo "<pre>";print_r($jsonArray['hostRoomUrl']);echo "</pre>";
        // $key = "hostRoomUrl";
        // $firstName = $jsonArray[$key];
        // // Option 2: through the use of an object.
        // $jsonObj = json_decode($contents);
        // $firstName = $jsonObj->$key;
        // echo "sadsadsad";
        // print_r($firstName);



        $eventid = $event->id;
        if ($event->start_Date != "0000-00-00") {
            if ($event->start_Time != null && $event->end_Time != null) {
             
                $s_combined_date_and_time = $event->start_Date . ' ' . $event->start_Time;
                $start_date = strtotime($s_combined_date_and_time);
                $e_combined_date_and_time = $event->end_Date . ' ' . $event->end_Time;
                $end_date = strtotime($e_combined_date_and_time);
                // $get_meet = $wpdb->get_results("select * from ". $table_name . " where id='".$event->id."' ");
                
                $ev[] = [
                    "hostRoomUrl" =>$jsonArray['hostRoomUrl'],
                    "eventid" => $eventid,
                    'attendees' => $event->attendees,
                    "title" => $event->summary,
                    "start" => date("Y-m-d H:i:s", $start_date),
                    "end" => date("Y-m-d H:i:s", $end_date)
                ];
            }
        }
    }
    $e = json_encode($ev, JSON_HEX_APOS);
    $data = array(
        'message'  => 'success',
        'data' => $e
    );
    echo wp_send_json($data);
}




add_action("wp_ajax_get_upcoming_event_details", "upcoming_event_details_func");
add_action("wp_ajax_nopriv_get_upcoming_event_details", "upcoming_event_details_func");

function upcoming_event_details_func(){
     global $wpdb;
    $event_id = $_POST['event_id'];
    $clientid = $_POST['clientid'];
    
    $result = array();
    if($event_id){
        $table_name = $wpdb->prefix . "events";

        $event_row = $wpdb->get_row(
            "select * from " .
                $table_name .
                ' where id = "'.$event_id.'"'
        );
        // echo "<pre>";print_r($event_row);echo "</pre>";
        $event_date = $event_row->start_datetime;
        // echo "<<<<<<----->>>>>>";
        // $evt_date = human_difference_new_custome($event_date);
        // echo "<pre>";print_r($event_row->recurrence);echo "</pre>";
        if($event_row->recurrence != ''){
            $recurrence_view = strtolower($event_row->recurrence);
        }else{
            $recurrence_view = 'No';

        }


        $client_info = get_userdata($clientid);
        
        if($event_row){
            $result['status'] = 'done';
            $result['message'] = 'Event details found';
            $result['data'] = $event_row;
            // $result['human_date'] = $evt_date;
            $result['client_name'] = $client_info->display_name;
            $result['recurrence'] = $recurrence_view;
        }else{
            $result['status'] = 'error';
            $result['message'] = 'Event details not found';
        }
    }else{
        $result['status'] = 'error';
        $result['message'] = 'Event ID not found';
    }
    echo json_encode($result);
    exit;
}

function human_difference_new_custome($post_date) {
    $seconds_hours = 60*60;
    $hours_days = $seconds_hours*24;
    $today = date("Y-m-d");
    $timestamp = $today.' '.date("H:i:s");

    $difference = strtotime($post_date) - strtotime($timestamp);
    
        if ($difference > $hours_days) {
            $date1 = new DateTime(substr($post_date,0,10));
            $date2 = new DateTime($today);
            $since = $date2->diff($date1)->format("%d");
            if ($since==1) { $since .= ' day'; }
            else { $since .= ' days'; }
        } else if ($difference > $seconds_hours) {
            $since = floor($difference/$seconds_hours).' hours';
        } else {
            $since = floor($difference/60).' mins';//mins
        }
    
    return $since;
}


// add_action("wp_ajax_delete_client_event", "delete_client_event_func");
// add_action("wp_ajax_nopriv_delete_client_event", "delete_client_event_func");

function delete_client_event_func(){
    global $wpdb;
    
    $client_email = $_POST['client_email'];
    $therapist_id = $_POST['therapist_id'];

    $table_name = $wpdb->prefix . "events";

    $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$client_email."' AND therapist_id = '" . $therapist_id . "'");
    $result = array();
    if(count($events) > 0){
        $refresh_token = get_user_meta($therapist_id, "refresh_token", true);
        $access_token_string = get_user_meta($therapist_id, "access_token", true);
        $access_token = generateAccessToken($access_token_string, $refresh_token);
        foreach ($events as $result) {
            $event_id = $result->id;
            $calendar_id = 'primary';
            $url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events/'.$event_id;
            $ch = curl_init();      
            curl_setopt($ch, CURLOPT_URL, $url_events);     
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');      
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
            $data = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            if($http_code == 204){
                $event_result = $wpdb->delete($table_name, ["id" => $event_id]);
            }
        }
        $events = $wpdb->get_results("select * from ". $table_name . " where json_extract(attendees, '$[0].email') ='".$client_email."' AND therapist_id = '" . $therapist_id . "'");
        if(count($events) == 0){
            $res_array["status"] = "success";
            $res_array["message"] = "This email all events deleted";
        }else{
            $res_array["status"] = "error";
            $res_array["message"] = "Something went wrong!";
        }
    }else{
        $res_array["status"] = "error";
        $res_array["message"] = "data not found!";
    }
    echo json_encode($res_array);
    exit();
}