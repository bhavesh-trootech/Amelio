<?php 
function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
    $times = array();

    if ( empty( $format ) ) {
        $format = 'g:i a';
    }

    foreach ( range( $lower, $upper, $step ) as $increment ) {
        $increment = gmdate( 'H:i:s', $increment );

        list( $hour, $minutes ) = explode( ':', $increment );

        $date = new DateTime( $hour . ':' . $minutes );

        $times[(string) $increment] = $date->format( $format );
    }

    return $times;
}


function wcsfen_plugin_create_db22() {
	
	global $wpdb;
	$tblname = 'clcevent_custom';
    $wp_track_table = $wpdb->prefix."$tblname";
    $tblname2 = 'clcevent_custgooglesync';
    $wp_track_table2 = $wpdb->prefix."$tblname2";
	$charset_collate = $wpdb->get_charset_collate();
	#Check to see if the table exists already, if not, then create it
	  if($wpdb->get_var( "show tables like '".$wp_track_table."'" ) != $wp_track_table) 
    {

		$sql = "CREATE TABLE $wp_track_table (
		  id bigint(9) NOT NULL AUTO_INCREMENT,
          therapistid bigint(9) NOT NULL, 
		  eventtitle tinytext NOT NULL,
		  clientemail tinytext NOT NULL,
          eventdate tinytext NOT NULL,
          eventfromtime tinytext NOT NULL,
          eventtotime tinytext NOT NULL,
          flag tinytext NOT NULL,
          status tinytext NOT NULL,
		  creatdatetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";
        
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
    }
    if($wpdb->get_var( "show tables like '".$wp_track_table2."'" ) != $wp_track_table2) 
    {
        $sql2 = "CREATE TABLE $wp_track_table2 (
            id bigint(9) NOT NULL AUTO_INCREMENT,
            ccid bigint(9) NOT NULL, 
            therapistid bigint(9) NOT NULL, 
            eventtitle tinytext NOT NULL,
            clientemail tinytext NOT NULL,
            eventdate tinytext NOT NULL,
            eventfromtime tinytext NOT NULL,
            eventtotime tinytext NOT NULL,
            meetinglink tinytext NOT NULL,
            statusapprove tinytext NOT NULL,
            creatdatetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate;";
          
          require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
          dbDelta( $sql2 );
			
    }
	
}

//add_action( 'init', 'wcsfen_plugin_create_db22');
add_action('wp_ajax_nopriv_deleteventcust', 'deleteventcust');
add_action('wp_ajax_deleteventcust', 'deleteventcust');
function deleteventcust(){
    global $wpdb;
	$id=$_POST['id'];
    $table = $wpdb->base_prefix.'clcevent_custom';
    $wpdb->delete( $table, array( 'id' => $id ) );
    $current_user = wp_get_current_user();
    $userid=$current_user->ID;
    $eventlist = $wpdb->get_results("SELECT * FROM " . $table . " where `therapistid`='" .$userid. "'");
    if(!empty($eventlist)){
        $arryevent=array();
        foreach($eventlist as $elist){
            $sessionname=$elist->eventtitle;
            $startd=$elist->eventdate.'T'.$elist->eventfromtime;
            $endtd=$elist->eventdate.'T'.$elist->eventtotime;
            $desc=$elist->clientemail;
            $arryevent[]=array('id'=>$elist->id,'title'=>$sessionname,'start'=>$startd,'end'=>$endtd,'description'=>$desc);

        }

      
        $eventd=json_encode($arryevent);
        wp_send_json( array( 'success' => 1,'message' => 'successful.','arraydata'=>$eventd));
    }
    exit();
}

add_action('wp_ajax_nopriv_ameliosyncgooglecalender', 'ameliosyncgooglecalender');
add_action('wp_ajax_ameliosyncgooglecalender', 'ameliosyncgooglecalender');
function ameliosyncgooglecalender(){
    global $wpdb;
	$sessionname=$_POST['text'];
    $editformtime=$_POST['editformtime'];
    $edittotime=$_POST['edittotime'];
    $clientemail=$_POST['clientemaiol'];
    $date=$_POST['date'];
    $custevid=$_POST['custevid'];
    $current_user = wp_get_current_user();
    $therapistid=$current_user->ID;
	$table_name2 = $wpdb->base_prefix.'clcevent_custgooglesync';

    $eventlist = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `ccid`='" .$custevid. "'");
    if(!empty($eventlist)){

        wp_send_json( array( 'success' => 0,'message' => 'Already sync google and also meeting.','meetinglink'=>$eventlist[0]->meetinglink));
    }
    else{
        $resultc = substr($clientemail, 0, 9);
        $d=$date.'T'.$editformtime;
        $data = array("topic" => $sessionname,"type"=>'2',"start_time"=>$d,"duration"=>'30',"password"=>$resultc);
        // And then encoded as a json string
        $data_string = json_encode($data);




        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.zoom.us/v2/users/me/meetings',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data_string,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU1VHh3c3BRU1NPdE0tbG9DLV9abmciLCJleHAiOjE2NzQxMTIxMTAsImlhdCI6MTY3MzUwNzMxNH0.USjcJE3FWyMbdGdKZAOPe4X6hYe3JgxQrvIAnMMo-Fg',
            'Content-Type: application/json',
            'Cookie: TS018dd1ba=014ccb3c7bb9f24276207cb01889a26675e8a495dda27bed58db886752ec8e8a7a42fd730b065a16e306337e81d8dd5225e1bddeb8; __cf_bm=kiZGPT36mvDrpBoev91_yYj62rVl7UOJudtHCiiNVPo-1673509218-0-ASrU3ryJwaTV/mt6lTyumfh8oLJLctAIfFOdlJfTR0T5TaLfZ/gQnTEU4Ise20UzwCHs0XC8yYdAz3fNO+5lTDA=; _zm_bu=https%3A%2F%2Fzoom.us%2Foauth%2Fauthorize%3Fclient_id%3DLRtpZ8fdT8eMgNku3hTiw%26response_type%3Dcode%26redirect_uri%3Dhttp%253A%252F%252Flocalhost%252Fevent_cal%252F; _zm_csp_script_nonce=EEmzuJBOQUKSrAmvkRnhUA; _zm_currency=INR; _zm_mtk_guid=950b7b6d5ef24e6eae1bd4e6204e2574; _zm_o2nd=b234360ed77adf26774e36cacfc4d868; _zm_page_auth=us05_c_H-MZXRpMTsu0apJE7OXeqQ; _zm_ssid=aw1_c_9Mqm_X2BQoeVtREj2KtO7g; _zm_visitor_guid=950b7b6d5ef24e6eae1bd4e6204e2574; TS01f92dc5=014ccb3c7bb9f24276207cb01889a26675e8a495dda27bed58db886752ec8e8a7a42fd730b065a16e306337e81d8dd5225e1bddeb8; cred=1D3AE37A4BF9E417D168DB57A483605A'
          ),
        ));
        
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        
        if($response === false)
        {
            echo 'Curl error: ' . curl_error($curl);
        }else{
            $da= json_decode($response);
            $meetingg=$da->join_url;
              $wpdb->insert($table_name2, array(
            "ccid"=> $custevid,
            "therapistid" => $therapistid,
            "eventtitle" => $sessionname,
            "clientemail" => $clientemail,
            "eventdate" => $date,
            "eventfromtime" => $editformtime,
            "eventtotime" =>$edittotime,
            "meetinglink" => $meetingg,
            "statusapprove" => 'syncgoogle',
            "creatdatetime" => date('Y-m-d H:i:s'),
            ));
            $usee = $wpdb->insert_id;
           
            $fromt = str_replace(':', '', $editformtime);
            $tot = str_replace(':', '', $edittotime);
            $ceddate = str_replace('-', '', $date);

            $udate= $ceddate.'T'.$fromt;
            $udatec= $ceddate.'T'.$tot;
            if(!empty($usee)){
                $url=get_site_url();
                $goourl='https://calendar.google.com/calendar/event?action=TEMPLATE&text='.$sessionname.'&dates='.$udate.'/'.$udatec.'&add='.$clientemail.'&details=Amelio Therapist schedual set  Zoom meeting url:'.$meetingg.'<a href="'.$meetingg.'"> Meeting Url</a>&trp=true&sprop='.$url.'&sf=true';
                
                wp_send_json( array( 'success' => 1,'message' => 'successful.','googleurl'=>$goourl,'meetinglink'=>$meetingg));
            }

        }
        curl_close($curl);
        
       
    }

exit();
}

add_action('wp_ajax_nopriv_amelio_caladdevent_ajax', 'amelio_caladdevent_ajax');
add_action('wp_ajax_amelio_caladdevent_ajax', 'amelio_caladdevent_ajax');

function amelio_caladdevent_ajax(){
	global $wpdb;
	$sessionname=$_POST['sessionname'];
	$therapistid=$_POST['therapistid'];
    $clientemail=$_POST['clientemail'];
    $selectdatet=$_POST['selectdatet'];
    $formtime=$_POST['formtime'];
    $totime=$_POST['totime'];


	$table_name2 = $wpdb->base_prefix.'clcevent_custom';

    $wpdb->insert($table_name2, array(
        "therapistid" => $therapistid,
        "eventtitle" => $sessionname,
        "clientemail" => $clientemail,
        "eventdate" => $selectdatet,
        "eventfromtime" => $formtime,
        "eventtotime" =>$totime,
        "flag" => '0',
        "status" => 'nosyncgoogle',
        "creatdatetime" => date('Y-m-d H:i:s'),
    ));
    $userlog = $wpdb->insert_id;

    if(!empty($userlog)){
        $eventlist = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `therapistid`='" .$therapistid. "'");
        if(!empty($eventlist)){
            $arryevent=array();
            foreach($eventlist as $elist){
                $sessionname=$elist->eventtitle;
                $startd=$elist->eventdate.'T'.$elist->eventfromtime;
                $endtd=$elist->eventdate.'T'.$elist->eventtotime;
                $desc=$elist->clientemail;
                $arryevent[]=array('id'=>$elist->id,'title'=>$sessionname,'start'=>$startd,'end'=>$endtd,'description'=>$desc);

            }

          
            $eventd=json_encode($arryevent);
            wp_send_json( array( 'success' => 1,'message' => 'successful.','arraydata'=>$eventd,'id'=>$userlog));
        }
        
        
    }
    exit();

}    
?>
