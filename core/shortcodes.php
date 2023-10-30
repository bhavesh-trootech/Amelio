<?php   
/**
 * shortcode for listing therapist
 */
add_shortcode('ajaxloadmoretherapist','ajaxloadmoretherapist');
function ajaxloadmoretherapist($atts, $content = null){
 ob_start();
 $atts = shortcode_atts(
        array(
 'role' => 'Therapist',
 'initial_posts' => '4',
 'loadmore_posts' => '4',
 ), $atts, $tag
    );
 $additonalArr = array();
 $additonalArr['appendBtn'] = true;
 $additonalArr["offset"] = 0; ?>
 <div class="dcsAllPostsWrapper"> 
 <input type="hidden" name="dcsPostType" value="<?=$atts['role']?>">
     <input type="hidden" name="offset" value="0">
     <input type="hidden" name="dcsloadMorePosts" value="<?=$atts['loadmore_posts']?>">
     <div class="dcsDemoWrapper ast-row">
 <?php dcsGetTherapistPostsFtn($atts, $additonalArr); ?>
 </div>
 </div>
 <div class="appendLoadMore"></div>
 <?php
    return ob_get_clean();
}

/****/
function dcsGetTherapistPostsFtn($atts, $additonalArr=array()){ 
   $args = array(
     'role' => 'Therapist',
     'number' => $atts['initial_posts'],
     'offset' => $additonalArr["offset"],
     'meta_query' => array(
        array(
            'key' => 'display_therapist_in_listing_page', 
            'value' => 1,
            'compare' => '='
        ),
)
 );

   $argsAllTherapistUser = array(
     'role' => 'Therapist',
     'meta_query' => array(
        array(
            'key' => 'display_therapist_in_listing_page', 
            'value' => 1,
            'compare' => '='
        ),
)
 );

 $user_query = new WP_User_Query( $args );
 $therapistAuthors = $user_query->get_results();

$alluser_query = new WP_User_Query( $argsAllTherapistUser );
$allTherapistAuthors = $alluser_query->get_results();

$total_users = count($allTherapistAuthors);
$total_pages = ceil($total_users / 12);

 $max_pages = $total_pages;
 $havePosts = true;
 if ( !empty( $therapistAuthors) ) {
     
     foreach ($therapistAuthors as $author) {
          $author_id = $author->ID;
          $author_info = get_userdata($author->ID);
          $userFieldId = 'user_'.$author_id;
      ?>

         <div class="loadMoreRepeat blogLoop">
         	<div class="ast-post-format- blog-layout-1">
						<div class="post-content ast-grid-common-col">
							<div class="ast-blog-featured-section post-thumb ast-grid-common-col ast-float">
								<div class="post-thumb-img-content post-thumb">
									<a href="<?php echo get_author_posts_url($author_id); ?>">
                                        <img src="<?php echo get_field('user_profile_picture', $userFieldId); ?>" width="350" height="350" class="avatar" alt="<?php echo the_author_meta( 'display_name' , $author_id ); ?>" />
                                    </a>
								</div>
							</div>	

                            <div class="authorExcerpt">
                                <h3><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $author_info->first_name." ".$author_info->last_name; ?></a></h3>
                                <div class="shortBio">
                                <?php $contentBio = get_field('add_bio', $userFieldId); ?>
                                <p><?php echo wp_trim_words( $contentBio, 20, '...' ); ?></p>
                                </div>

                                <a href="<?php echo get_author_posts_url($author_id); ?>" class="findOutMoreBtn">Find out more</a>

                            </div>
							
						</div><!-- .post-content -->
					</div> <!-- .blog-layout-1 -->
         </div>
         <?php
     }
     
 } else {
    $havePosts = false; 
 }
 wp_reset_postdata();
   if($havePosts && $additonalArr['appendBtn'] ){ ?>
   	<div class="loadMoreSection">
    
    <!-- loader for ajax -->
    <div class="dcsLoaderImg therapistPageLoder" style="display: none;">
     <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
     color: #ff7361;">
     <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
       <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
           </path>
         </svg>
         </div>

    <div class="btnLoadmoreWrapper" data-maxp="<?php echo $max_pages; ?>">
    <a href="javascript:void(0);" class="btn btn-primary dcsLoadMorePostsbtnTherapist">View More</a> 
    </div>
          </div>
		
 
    <!-- <p class="noMorePostsFound" style="display: none;">No More Posts Found</p> -->
    <?php
 }
}
/****/

add_action("wp_ajax_dcsAjaxLoadMoreTherapist","dcsAjaxLoadMoreTherapist");
add_action("wp_ajax_nopriv_dcsAjaxLoadMoreTherapist","dcsAjaxLoadMoreTherapist");
function dcsAjaxLoadMoreTherapist(){
	extract($_POST);
	$additonalArr = array();
	$additonalArr['appendBtn'] = false;
	$additonalArr["offset"] = $offset;
	$atts["initial_posts"] = $dcsloadMorePosts;
	$atts["role"] = 'Therapist';
	dcsGetTherapistPostsFtn($atts, $additonalArr);
	die();
}

/*****/
add_shortcode('aboutAutherTitle','aboutauthertitle');
function aboutauthertitle(){
 ob_start();
global $wp_query;
$page_object = $wp_query->get_queried_object();
$author_id = $page_object->ID;
$user_info = get_userdata($author_id);
$userfirstname = $user_info->first_name;
?>
<div class="elementor-widget-container authorTitleAbout">
    <h2 class="elementor-heading-title elementor-size-default">About <?php echo ucfirst($userfirstname); ?></h2>  
</div>
 <?php
    return ob_get_clean();
}
/****/
add_shortcode('titleareaofspecialismauthor','titleareaofspecialismauthor');
function titleareaofspecialismauthor(){
 ob_start();
global $wp_query;
$page_object = $wp_query->get_queried_object();
$author_id = $page_object->ID;
$user_info = get_userdata($author_id);
$userfirstnm = $user_info->first_name;
?>
<div class="elementor-widget-container areaofspecialismTitle">
    <h2 class="elementor-heading-title elementor-size-default"><?php echo ucfirst($userfirstnm); ?>’s area of specialism</h2>  
</div>
 <?php
    return ob_get_clean();
}
/****/
add_shortcode('therapistMessageBtn','therapistMessageBtn');
function therapistMessageBtn($atts){
$atts = shortcode_atts(
    array(
        'link' => '#',
    ), $atts, 'messageBtn' );
 ob_start();
global $wp_query;
$page_object = $wp_query->get_queried_object();
$author_id = $page_object->ID;
$user_info = get_userdata($author_id);
$userfirstnme = $user_info->first_name;
?>
<a href="<?php echo esc_attr($atts['link']); ?>" class="elementor-button-link elementor-button elementor-size-sm customMessageBtn" role="button">
    <span class="elementor-button-content-wrapper">
        <span class="elementor-button-text">Message <?php echo ucfirst($userfirstnme); ?></span>
    </span>
</a>
 <?php
    return ob_get_clean();
}

/*****/
//client signup form shortcode
add_shortcode('clientSignUp','clientSignUp');
function clientSignUp(){
 ob_start();
 $clientEmailCheck = base64_url_decode($_GET["email"]);
 $existsEmail = email_exists( $clientEmailCheck );
?>
<?php if ( $existsEmail ) { ?>
   <div class="userAlreadyExistMsg expireLinksec">
      <p>The link you followed has expired.</p>
   </div>
<?php } else { ?>
<style>
    .error {color: red;}
</style>

<div class="clientSignupform <?php if ( $existsEmail ) { echo "userExits"; } ?>" data-redirecturl="<?php echo home_url("/login"); ?>" data-therapistId="<?php echo base64_url_decode($_GET["therapist"]); ?>">
    <div class="clientSignupInner">

    <div class="register-message" style="display:none"></div>
    <form action="#" method="POST" name="register-form" class="register-form">
      <fieldset> 
          <div class="drop-down">
          <p>Your Name</p>
          <p><input type="text"  name="new_user_name" id="new-username"></p>
          <span class="error" id="nameError"></span>
          </div>

          <div class="drop-down">
          <p>Your Email</p>
          <p><input type="email"  name="new_user_email" id="new-useremail" value="<?php echo base64_url_decode($_GET["email"]); ?>" readonly></p>
          <span class="error" id="emailError"></span>
          </div>

          <div class="drop-down">
          <p>Your Password</p>
          <p><input type="password"  name="new_user_password" id="new-userpassword"></p>
          <span class="error" id="passwordError"></span>
          </div>

          <div class="drop-down">
          <p>Confirm Password</p>
          <p><input type="password"  name="conf_user_password" id="conf-userpassword"></p>
          <span class="error" id="confPasswordError"></span>
          </div>

          <div class="drop-down-btn">
          <button type="submit"  class="button" id="register-button">Sign Up <img src="/wp-content/uploads/2022/11/arrow-right-1.svg"></button>
          <div class="dcsLoaderImg" style="display: none;">
             <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
             color: #ff7361;">
             <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
               <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                   </path>
         </svg>
         </div>
          </div>

      </fieldset>
    </form> 
    </div>
</div>
<?php } ?>

    <script type="text/javascript">
  /**done typing js**/
  (function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);
/****/

        function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) {
            return false;
          }else{
            return true;
          }
        }

        jQuery(document).ready(function(){
              var $regexname=/^[a-zA-Z ]*$/;

              jQuery('#new-username').donetyping(function(){
                var newUserName = jQuery('#new-username').val();
                  if(newUserName == ""){
                      jQuery('#nameError').text("Please enter your name.");
                      return false;
                    }else{
                      jQuery('#nameError').text("");
                      return true;
                    }
                });

              jQuery('#new-userpassword').donetyping(function(){
                var newUserPassword = jQuery('#new-userpassword').val();
               if(newUserPassword == ""){
                  jQuery('#passwordError').text("Please enter your password.");
                  return false;
                } else if(( newUserPassword.length < 8 ) || ( !newUserPassword.match(/[A-z]/) ) || ( !newUserPassword.match(/[A-Z]/) ) || ( !newUserPassword.match(/\d/) ) || (!newUserPassword.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) ){
                   jQuery('#passwordError').text("Please enter atleast 8 character with one special character and capital letter and number.");
                    return false; 
                }
                 else{
                  jQuery('#passwordError').text("");
                  return true;
                }
              });

              jQuery('#conf-userpassword').donetyping(function(){
                var ConfUserPassword = jQuery('#conf-userpassword').val();
                var newUserPassword = jQuery('#new-userpassword').val();
               if(ConfUserPassword == ""){
                  jQuery('#conf-userpassword').text("Please enter confirm password.");
                  return false;
                } else if(( ConfUserPassword !== newUserPassword ) ){
                   jQuery('#confPasswordError').text("Password not match.");
                    return false; 
                }
                else{
                  jQuery('#confPasswordError').text("");
                  return true;
                }
              });

        });
    
    jQuery( 'form[name="register-form"]' ).on( 'submit', function(e) {
      //jQuery('#register-button').on('click',function(e){
        e.preventDefault();
        var redirectUrl = jQuery(".clientSignupform").data("redirecturl");
        var therapistId = jQuery(".clientSignupform").data("therapistid");

         var $regexname=/^[a-zA-Z ]*$/;

        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        var ConfUserPassword = jQuery('#conf-userpassword').val();

        var validationErr=false;
        var passwordValdError =false;
        var NameValdError =false;

         if(newUserName == ""){
          jQuery('#nameError').text("Please enter your name.");
          var validationErr =true;
          var NameValdError =true;
        }else{
          jQuery('#nameError').text("");
          var validationErr=false;
          var NameValdError =false;
        }

        if(newUserEmail == ""){
          jQuery('#emailError').text("Please enter your email.");
          var validationErr =true;
        } else if(IsEmail(newUserEmail)==false){
          jQuery('#emailError').text("Please enter a valid email.");
        } else{
          jQuery('#emailError').text("");
         var validationErr=false;
        }

       if(newUserPassword == ""){
          jQuery('#passwordError').text("Please enter your password.");
          validationErr =true;
          var passwordValdError =true;
        } else if(( newUserPassword.length < 8 ) || ( !newUserPassword.match(/[A-z]/) ) || ( !newUserPassword.match(/[A-Z]/) ) || ( !newUserPassword.match(/\d/) ) || (!newUserPassword.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) ){
           jQuery('#passwordError').text("Please enter atleast 8 character with one special character and capital letter and number.");
            var validationErr =true;
            var passwordValdError =true;
        }
         else{
          jQuery('#passwordError').text("");
          var validationErr =false;
          var passwordValdError =false;
        }
      
       if(ConfUserPassword == ""){
          jQuery('#confPasswordError').text("Please enter confirm password.");
          var validationErr =true;
        } else if(( ConfUserPassword !== newUserPassword ) ){
           jQuery('#confPasswordError').text("Password not match.");
           var validationErr =true; 
        }
        else{
          jQuery('#confPasswordError').text("");
         var validationErr =false;
        }

        if(validationErr==true){  
        return false;
        }

    if(passwordValdError==false && NameValdError==false){
         jQuery(".dcsLoaderImg").show();

            jQuery.ajax({
              type:"POST",
              url:"<?php echo admin_url('admin-ajax.php'); ?>",
              data: {
                action: "register_user_front_end",
                new_user_name : newUserName,
                new_user_email : newUserEmail,
                new_user_password : newUserPassword,
                therapistId : therapistId
              },
              dataType:"JSON",
              success: function(results){
                //console.log(results.msg);
                //console.log(results.type);
                
                jQuery(".dcsLoaderImg").hide();
                jQuery('.register-message').html(results.msg).show();

                if(results.type == 'success'){
                  //window.location.href = redirectUrl;
                  jQuery(".client-signup-section").addClass("fullviewPort");
                  jQuery('form.register-form').remove();
                  jQuery('div.hidetextAjax').remove();
                  jQuery('.register-message').html(results.successMsg).show();
                }
              },
              error: function(results) {

              }
            });
        }
        else{
            return false;
        }

      });
    </script>


 <?php
    return ob_get_clean();
}

/****/
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
      $new_user_name = stripcslashes($_POST['new_user_name']);
      $new_user_email = stripcslashes($_POST['new_user_email']);
      $new_user_password = $_POST['new_user_password'];
      $user_nice_name = strtolower($_POST['new_user_email']);
      $therapistId = $_POST['therapistId'];

      global $wpdb;
      $invitedusersTable = 'invitedusers';
      $checktherapistId = $wpdb->get_var("SELECT therapistUserId FROM $invitedusersTable WHERE invitationEmailId='".$new_user_email."'");
      $existsEmailReg = email_exists( $new_user_email );

      $user_data = array(
          'user_login' => $new_user_email,
          'user_email' => $new_user_email,
          'user_pass' => $new_user_password,
          'user_nicename' => $user_nice_name,
          'display_name' => $new_user_name,
          'role' => 'customer'
        );

      if($therapistId ==""){
        $result['msg'] = '<p class="errorMsg">You can\'t register without therapist register link.</p>';
        $result['type'] = "error";
      }elseif ($therapistId !== $checktherapistId) {
        $result['type'] = "error";
        $result['msg'] = '<p class="errorMsg">This email ID not associated with therapist.</p>';
      }elseif ($existsEmailReg) {
        $result['type'] = "error";
        $result['msg'] = '<p class="errorMsg">Email already registered.</p>';
      }elseif ($therapistId == $checktherapistId) {
        $sessions = WP_Session_Tokens::get_instance(get_current_user_id());
        $sessions->destroy_all();

          $user_id = wp_insert_user($user_data);
          if (!is_wp_error($user_id)) {
          update_user_meta( $user_id, 'first_name', $new_user_name );
          $result['successMsg'] = '<p class="successMsg">Thanks for signing up.</p>';
          $result['type'] = "success";
          $wpdb->query($wpdb->prepare("UPDATE $invitedusersTable SET status='active client' WHERE invitationEmailId='".$new_user_email."'"));
          $wpdb->query($wpdb->prepare("UPDATE $invitedusersTable SET clientNames='".$new_user_name."' WHERE invitationEmailId='".$new_user_email."'"));
          update_user_meta( $user_id, 'client_therapist_id', $therapistId );
          update_user_meta( $user_id, 'client_status', "active client" );
        }
      }else {
              $result['msg'] = '<p class="errorMsg">Error Occured please fill up the sign up form carefully.</p>';
            }

        echo json_encode($result);
    die;
}

/****/
//Login form shortcode
add_shortcode('loginForm','loginForm');
function loginForm(){
 ob_start();
?>
<style>
    .error {color: red;}
</style>
<div class="woocommerce">
<form id="loginForm" method="post" class="woocommerce-form woocommerce-form-login login">

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="username">Email Address&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username">
    <span class="error" id="emailError"></span>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="password">Password&nbsp;<span class="required">*</span></label>
    <span class="password-input">
        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password">
    </span>
   <span class="error" id="passwordError"></span>
    </p>
    <p class="login-message"></p>
    <p class="form-row"></p>
    <div class="lost-password-wrap">
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>Keep me logged in</span>
    </label>
    <p class="woocommerce-LostPassword lost_password">
        <a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
    </p>
    </div>

    <button class="woocommerce-button button" id="loginBtnSubmit" value="Log in">Log in</button>
     

    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
    function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) {
            return false;
          }else{
            return true;
          }
        }

        $('body').on('click', '#loginBtnSubmit', function(e) {
        e.preventDefault();

        var validationErr=false;

        var $form = $("form#loginForm");
        var loginEmail = $form.find('#username').val();
        var loginPassword = $form.find('#password').val();

        if(loginEmail == ""){
          jQuery('#emailError').text("Please enter email address.");
          validationErr = true;
        } /*else if(IsEmail(loginEmail)==false){
          jQuery('#emailError').text("Please enter a valid email address.");
        }*/ else{
          jQuery('#emailError').text("");
          validationErr= false;
        }

        if(loginPassword == ""){
          jQuery('#passwordError').text("Please enter password.");
          validationErr = true;
        }
         else{
          jQuery('#passwordError').text("");
          validationErr = false;
        }
        
        var data = {
            'action'    : 'login_check',
            'loginEmail'  : loginEmail,
            'password'  : loginPassword,
            'rememberme': $form.find('#rememberme').is( ':checked' ) ? true : false,
            'security'  : $form.find('#security').val()
        };

        if(validationErr==false){
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // your ajax url
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function(jqXHR, settings) { $('.login-message').html(''); },
            success : function( response ) {
                console.log(response.redirectUrl);
                if (typeof response.message !== 'undefined' && response.error === true){
                    $('.login-message').html(response.message);
                }

            // reload on success
            if (typeof response.success !== 'undefined' && response.success === true) {
                window.location.href = response.redirectUrl; 
            }
        },
            //success: function(data, textStatus, xhr) { loginBtn.onAjaxSuccess(data); },
            error: function(jqXHR, textStatus, errorThrown) {  $('.login-message').html('There was an unexpected error'); }
        });
    }

     });

});
</script>

 <?php
    return ob_get_clean();
}


/****/