<?php 
add_filter('add_to_cart_redirect', 'amelieo_add_to_cart_redirect');
function amelieo_add_to_cart_redirect() {
 global $woocommerce;
 $lw_redirect_checkout = $woocommerce->cart->get_checkout_url();
 return $lw_redirect_checkout;
}

function wpc_shop_url_redirect() {
    ob_clean();
    ob_start();
    if(is_shop()){
        wp_redirect( home_url( '/pricing/' ) );
        exit();
    }
    if(is_cart()){
        wp_redirect( home_url( '/pricing/' ) );
        exit();
    }
}
//add_action( 'template_redirect', 'wpc_shop_url_redirect' );
add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes');
function smashing_add_post_meta_boxes() {

    add_meta_box(
      'smashing-post-class',      // Unique ID
      esc_html__( 'Lead', 'example' ),    // Title
      'smashing_post_class_meta_box',   // Callback function
      'product',         // Admin page (or post type)
      'side',         // Context
      'default'         // Priority
    );
  }
  function smashing_post_class_meta_box( $post ) { 
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );

    $troo_course_time = get_post_meta( $post->ID, 'therapistleadno', true ); ?>
  
    <p>
      <label for="smashing-post-class"><?php _e( "Add the Lead.", 'example' ); ?></label>
      <br />
      <input class="widefat" type="text" name="therapistleadno" id="therapistleadno" value="<?php echo $troo_course_time; ?>" size="30" />
    </p>
  <?php }

add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );
/* Save the meta box’s post metadata. */
function smashing_save_post_class_meta( $post_id, $post ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    return;

   if ( !isset( $_POST['dynamicMeta_noncename'] ) )
   return;



   if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
   return;

   if ( isset( $_REQUEST['therapistleadno'] ) ) {

           update_post_meta( $post_id, 'therapistleadno', sanitize_text_field( $_POST['therapistleadno'] ) );

   }
}
add_role(
    'therapist', 
    __( 'Therapist'  ), 
    array(
        'read'  => true,
        'delete_posts'  => false,
        'delete_published_posts' => false,
        'edit_posts'   => true,
        'publish_posts' => true,
        'upload_files'  => true,
        'edit_pages'  => true,
        'edit_published_pages'  =>  true,
        'publish_pages'  => true,
        'delete_published_pages' => false, 
    )
);

function change_role_on_purchase( $order_id ) {

    $order = new WC_Order( $order_id );
    $items = $order->get_items();
    $sum=0;
    foreach ( $items as $item ) {
        $product_name = $item['name'];
        $product_id = $item['product_id'];
        $product_variation_id = $item['variation_id'];
        $therapistleadno = get_post_meta( $product_id, 'therapistleadno', true );
        if ( $order->user_id > 0 ) {
            $sum+= $therapistleadno;
        }
       
    }

    if ( $order->user_id > 0 ) {
       
        $user_leads = get_user_meta( $order->user_id, 'therapist_leads', true ); 
        if(!empty($user_leads)){
            $newtherapist=$user_leads + $sum;
            update_user_meta( $order->user_id, 'therapist_leads',  $newtherapist );
        }else{
            update_user_meta( $order->user_id, 'therapist_leads', $sum );
        }
       
        $user = new WP_User( $order->user_id );
        $user->remove_role( 'customer' ); 
        $user->add_role( 'therapist' );

    }

    
    $order->update_status('completed'); 
}

add_action( 'woocommerce_order_status_processing', 'change_role_on_purchase' );

add_action('show_user_profile', 'my_user_profile_edit_action');
add_action('edit_user_profile', 'my_user_profile_edit_action');
function my_user_profile_edit_action($user) {

    $user_leads = get_user_meta( $user->ID, 'therapist_leads', true ); 
    $user_meta = get_userdata($user->ID);
    $user_roles = $user_meta->roles;
    if ( in_array( 'therapist', $user_roles, true ) ) {
     
?>

  <h3 class="heading">Therapist Lead</h3>
  <table class="form-table">
    <tbody><tr>
        <th><label for="contact">Lead</label></th>
        <td><input type="text" class="input-text form-control" readonly value="<?php echo $user_leads; ?>" name="therapistleadno" id="therapistleadno" style="width:25em"></td>
    </tr>
    </tbody></table>
  <br/>
<?php 
    }
}

add_action('personal_options_update', 'my_user_profile_update_action');
add_action('edit_user_profile_update', 'my_user_profile_update_action');
function my_user_profile_update_action($user_id) {
  update_user_meta($user_id, 'therapist_leads', isset($_POST['therapistleadno']));
}


function althemist_add_therapistaccount_leads_endpoint() {
    add_rewrite_endpoint( 'therapistaccount-leads', EP_ROOT | EP_PAGES );
}
   
add_action( 'init', 'althemist_add_therapistaccount_leads_endpoint' );
  

function althemist_therapistaccount_leads_query_vars( $vars ) {
    $vars[] = 'therapistaccount-leads';
    return $vars;
}
   
add_filter( 'query_vars', 'althemist_therapistaccount_leads_query_vars', 0 );

function add_therapistaccount_leads_tab( $items ) {
    $items['therapistaccount-leads'] = 'My Leads';
    return $items;
}
   
add_filter( 'woocommerce_account_menu_items', 'add_therapistaccount_leads_tab' );
   

function add_therapistaccount_leads_content() {
    echo '<h3 style="text-align:left;">My Leads</h3>';
    $userid=get_current_user_id();
    $user_leads = get_user_meta( $userid, 'therapist_leads', true );
    ?>
    <table class="form-table" style="width:50%;">
    <tbody><tr>
        <td><label for="contact"><b>Total Leads:</b></label></th>
        <?php if(!empty( $user_leads)) { ?>
        <td><b><?php echo  $user_leads; ?></b></td>
        <?php } else { ?>
        <td>0</td>
        <?php } ?>
    </tr>
    </tbody></table>
    <?php

}
add_action( 'woocommerce_account_therapistaccount-leads_endpoint', 'add_therapistaccount_leads_content' );

add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');
  
function bbloomer_redirectcustom( $order_id ){
    $order = wc_get_order( $order_id );
    $url = get_site_url().'/sign-up-as-a-professional/';
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
}

add_filter('woocommerce_account_menu_items', 'remove_my_account_tabs', 999);

 function remove_my_account_tabs($items) {
    unset($items['dashboard']);
    unset($items['downloads']);
    unset($items['payment-methods']);
    unset($items['edit-address']);
    return $items;
}

function iso_reorder_my_account_menu() {
    $newtaborder = array(
        'therapistaccount-leads'  => __( ' My Leads', 'woocommerce' ),
        'orders'             => __( ' Orders', 'woocommerce' ),
        'edit-account'       => __( 'Account Details', 'woocommerce' ),
        'customer-logout'    => __( 'Logout', 'woocommerce' ),
    );
    return $newtaborder;
}
add_filter ( 'woocommerce_account_menu_items', 'iso_reorder_my_account_menu' );


function my_render_wc_login_form( $atts ) { 
  if ( ! is_user_logged_in() ) {  
    if ( function_exists( 'woocommerce_login_form' ) && 
        function_exists( 'woocommerce_output_all_notices' ) ) {
      //render the WooCommerce login form   
      ob_start();
      woocommerce_output_all_notices();
      woocommerce_login_form();
      return ob_get_clean();
    } else { 
      //render the WordPress login form
      return wp_login_form( array( 'echo' => false ));
    }
  } else {
    return "Hello there! Welcome back.";
  }
}
add_shortcode( 'my_wc_login_form', 'my_render_wc_login_form' );


function user_has_role($user_id, $role_name)
{
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    return in_array($role_name, $user_roles);
}

//add_filter( 'woocommerce_login_redirect', 'bbloomer_customer_login_redirect', 9999, 2 );
function bbloomer_customer_login_redirect( $redirect, $user ) {
     
    // if ( wc_user_has_role( $user, 'customer' ) ) {
    //     $redirect = get_home_url(); // homepage
    // }
    $redirect = get_home_url().'/my-account/therapistaccount-leads/';
  
    return $redirect;
}
 
add_shortcode( 'join_professional_therapists_from_html', 'join_professional_therapists_from_html' );
function join_professional_therapists_from_html(){

 ob_start();

 ?>
<div class="joinprofessionhtmlfromdiv" id="joinprofessionhtmlfrom" >
	<form class="joinprofessionhtml" method="post" id="joinprofessionhtml">
		<?php 
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$userid=$current_user->ID;
			$useremail=$current_user->user_email;
			$userfirstname =$current_user->user_firstname;
			$userlastname  =$current_user->user_lastname;
			$user_is_therapist = user_has_role(get_current_user_id(), 'therapist');
			$phone= get_user_meta( get_current_user_id(), 'billing_phone', 'true' );
			$interestedVal = get_user_meta( $current_user->ID, 'interestedinamelio' , true );
			$intendClientVal  = get_user_meta( $current_user->ID, 'amelioclientintend' , true );
		}

		global $wpdb;
		$table_name2 = $wpdb->base_prefix . 'amelio_joinprofession';
		if(!empty($user_is_therapist)){
			$userlogresult = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `user_id`='" . $userid . "' and `email`='" . $useremail."'");
			if ($userlogresult) {
			
			$fname=$userlogresult[0]->fname;
			$lname=$userlogresult[0]->lname;
			$interes=$userlogresult[0]->interes;
			$amelioc=$userlogresult[0]->amelioc;
			$whatlicenc=$userlogresult[0]->whatlicenc;
			 $yourexperience=$userlogresult[0]->yourexperience;
			 $dd=json_decode($yourexperience);

			

			}
		}
	
		if(!empty($user_is_therapist)){ ?>
			<input type="hidden" name="therapistusrid" id="therapistusrid" value="<?php echo $userid; ?>">
		<?php } ?>

		 <?php if(!empty($whatlicenc)){ 
		 	$whatlicenc = $whatlicenc;
		 }else{
		 	$whatlicenc = "";
		 } ?>

		<div class="drop-down">
			  <p>What License Type Do You Currently Hold?</p>
			<p>
				<span class="fdgfd">
					<input size="40" class="whatlicense field" value="<?php echo $whatlicenc; ?>" type="text" name="whatlicense" id="whatlicense">
				</span>
			</p>
			<span class="error" id="licenerror"></span>
		</div>
	
	<div class="two-name-fields">
		<div class="name-field">
			<p>Your First Name</p>
			<div>
				<?php if(!empty($user_is_therapist)){ ?>
				<p><input size="40" class="fname field" value="<?php echo $userfirstname; ?>" readonly  type="text" name="fname" id="fname"></p>
				<?php } else { ?>
				<p><input size="40" class="fname field" value="" type="text" name="fname" id="fname"></p>
				<?php } ?>
				<span class="error" id="fnameerror"></span>
			</div>
		</div>
		<div class="name-field">
			<p>Your Last Name</p>
			<div>
				<?php if(!empty($user_is_therapist)){ ?>
				<p><input size="40" class="lname field" value="<?php echo $userlastname; ?>" type="text" readonly name="lname" id="lname"></p>
				<?php } else { ?>
				<p><input size="40" class="lname field" value="" type="text" name="lname" id="lname"></p>
				<?php } ?>
				<span class="error" id="lnameerror"></span>
			</div>
		</div>
	</div>
	
	<div class="drop-down">
		<p>Your Work Phone Number</p>
		<div>
			<?php if(!empty($user_is_therapist)){
			 ?>
				<p><input size="40" class="telephone field" value="<?php echo $phone; ?>"  type="tel" name="phonenumber" id="phonenumber" /></p>
			<?php } else { ?>
				<p><input size="40" class="telephone field" value="+" type="tel" name="phonenumber" id="phonenumber" /></p>
			<?php } ?>
			
			<span class="error" id="telerror"></span>
		</div>
	</div>
	
	<div class="drop-down">
		<p>Your Work Email Address</p>
		<div>
			<?php if(!empty($user_is_therapist)){ ?>
				<p><input size="40" class="email-address field"  value="<?php echo $useremail; ?>"  readonly id="emailid" type="email" name="emailid" /></p>
			<?php } else { ?>
				<p><input size="40" class="email-address field"  value="" id="emailid" type="email" name="emailid" /></p>
			<?php } ?>
			
			<span class="error" id="mailerror"></span>
		</div>
		
	</div>
	
	<div class="drop-down">
		<p>What Makes You Interested In Amelio?</p>
		<div>
			<p>
				<select class="interestedinamelio field" name="interestedinamelio" id="interestedinamelio">
					<option value="">Select one</option>
					<option value="Maintaining work/life balance" <?php if(!empty($interes)){  if($interes == 'Maintaining work/life balance'){ echo 'selected'; }   }?>>Maintaining work/life balance</option>
					<option value="Dedicated support team" <?php if(!empty($interes)){  if($interes == 'Dedicated support team'){ echo 'selected'; }   }?>>Dedicated support team</option>
					<option value="Dedicated platform" <?php if(!empty($interes)){  if($interes == 'Dedicated platform'){ echo 'selected'; }   }?>>Dedicated platform</option>
					<option value="No need for advertising" <?php if(!empty($interes)){  if($interes == 'No need for advertising'){ echo 'selected'; }   }?>>No need for advertising</option>
					<option value="Manage my clients all in one place" <?php if(!empty($interes)){  if($interes == 'Manage my clients all in one place'){ echo 'selected'; }   }?>>Manage my clients all in one place</option>
					<option value="All of the above" <?php if(!empty($interes)){  if($interes == 'All of the above'){ echo 'selected'; }   }?>>All of the above</option>
				</select>
			</p>
			<span class="error" id="droperror"></span>
		</div>
		
	</div>
	
	<div class="drop-down">
		<p>How Much Time Do You Intend To Spend With Amelio Clients?</p>
		<div>
			<p>
				<select class="howmuch field" name="amelioclientintend" id="amelioclientintend">
					<option value="">Select one</option>
					<option value="1-5 hours per week" <?php if(!empty($amelioc)){  if($amelioc == '1-5 hours per week'){ echo 'selected'; }   }?>>1-5 hours per week</option>
					<option value="5-10 hours per week" <?php if(!empty($amelioc)){  if($amelioc == '5-10 hours per week'){ echo 'selected'; }   }?>>5-10 hours per week</option>
					<option value="10-15 hours per week" <?php if(!empty($amelioc)){  if($amelioc == '10-15 hours per week'){ echo 'selected'; }   }?>>10-15 hours per week</option>
					<option value="15-20 hours per week" <?php if(!empty($amelioc)){  if($amelioc == '15-20 hours per week'){ echo 'selected'; }   }?>>15-20 hours per week</option>
					<option value="20 hours + per week" <?php if(!empty($amelioc)){  if($amelioc == '20 hours + per week'){ echo 'selected'; }   }?>>20 hours + per week</option>
				</select>
			</p>
			<span class="error" id="howmuch"></span>
		</div>
		
	</div>
	
	<div class="drop-down">
		<p class="experience">Do you have experience in the following? (select any that apply)</p>
	</div>
	<div class="checkbox-columns">
		<div class="first-column-checkbox">
			<p>
				<span class="wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required field">
				<span class="first">
					<label>
						<input type="checkbox" name="your-experience[]" value="Anxiety/Depression/Other Emotional issues"
						<?php  if(!empty($dd)){  if (in_array("Anxiety/Depression/Other Emotional issues", $dd)){ echo 'checked'; } }?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Anxiety/Depression/Other Emotional issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Fears/Phobias"
						<?php  if(!empty($dd)){ if (in_array("Fears/Phobias", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Fears/Phobias</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Compulsive or Habitual Behaviours"
						<?php if(!empty($dd)){ if (in_array("Compulsive or Habitual Behaviours", $dd)){ echo 'checked'; } }?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Compulsive or Habitual Behaviours</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Coping with Addictions"
						<?php  if(!empty($dd)){ if (in_array("Coping with Addictions", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck"/>
						<span class="wpcf7-list-item-label">Coping with Addictions</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Sleep Disorders"
						<?php  if(!empty($dd)){ if (in_array("Sleep Disorders", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Sleep Disorders</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Eating Disorders"
						<?php  if(!empty($dd)){ if (in_array("Eating Disorders", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Eating Disorders</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Pain Management" 
						<?php  if(!empty($dd)){ if (in_array("Pain Management", $dd)){ echo 'checked'; } }?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Pain Management</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Weight Loss"
						<?php if(!empty($dd)){ if (in_array("Weight Loss", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Weight Loss</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Smoking" 
						<?php  if(!empty($dd)){ if (in_array("Smoking", $dd)){ echo 'checked'; } }?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Smoking</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Coping with Grief/Loss"
						<?php  if(!empty($dd)){ if (in_array("Coping with Grief/Loss", $dd)){ echo 'checked'; }} ?> 
						class="your_experiencecheck"/>
						<span class="wpcf7-list-item-label">Coping with Grief/Loss</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Trauma/Abuse"
						<?php if(!empty($dd)){ if (in_array("Trauma/Abuse", $dd)){ echo 'checked'; }} ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Trauma/Abuse</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Relationships/Dating" 
						<?php  if(!empty($dd)){ if (in_array("Relationships/Dating", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Relationships/Dating</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Intimacy-Related Issues"
						<?php if(!empty($dd)){ if (in_array("Intimacy-Related Issues", $dd)){ echo 'checked'; } }?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Intimacy-Related Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" value="Confidence/Communication Issues"
						<?php if(!empty($dd)){ if (in_array("Confidence/Communication Issues", $dd)){ echo 'checked'; } } ?> 
						class="your_experiencecheck" />
						<span class="wpcf7-list-item-label">Confidence/Communication Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck" 
						<?php if(!empty($dd)){ if (in_array("Motivation/Procrastination Issues", $dd)){ echo 'checked'; } }?> 
						value="Motivation/Procrastination Issues"/>
						<span class="wpcf7-list-item-label">Motivation/Procrastination Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck" 
						<?php if(!empty($dd)){ if (in_array("Careers/Work Relationships", $dd)){ echo 'checked'; } } ?>
						value="Careers/Work Relationships" />
						<span class="wpcf7-list-item-label">Careers/Work Relationships</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck" 
						<?php  if(!empty($dd)){ if (in_array("Remote Energy Balancing/Healing", $dd)){ echo 'checked'; } }?>
						 value="Remote Energy Balancing/Healing" />
						<span class="wpcf7-list-item-label">Remote Energy Balancing/Healing</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck" 
						<?php  if(!empty($dd)){ if (in_array("Life Coaching/Personal Development", $dd)){ echo 'checked'; } } ?>
						value="Life Coaching/Personal Development"  />
						<span class="wpcf7-list-item-label">Life Coaching/Personal Development</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"  
						<?php if(!empty($dd)){ if (in_array("Executive/Professional Coaching", $dd)){ echo 'checked'; } }?>
						 value="Executive/Professional Coaching"  />
						<span class="wpcf7-list-item-label">Executive/Professional Coaching</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Nutrition/Dietary Issues", $dd)){ echo 'checked'; } } ?> value="Nutrition/Dietary Issues"  />
						<span class="wpcf7-list-item-label">Nutrition/Dietary Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("IBS/Allergies/Skin Issues", $dd)){ echo 'checked'; } } ?> value="IBS/Allergies/Skin Issues"  />
						<span class="wpcf7-list-item-label">IBS/Allergies/Skin Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Women’s Health/Wellbeing", $dd)){ echo 'checked'; } } ?> value="Women’s Health/Wellbeing"  />
						<span class="wpcf7-list-item-label">Women’s Health/Wellbeing</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Men’s Health/Wellbeing", $dd)){ echo 'checked'; } } ?> value="Men’s Health/Wellbeing"  />
						<span class="wpcf7-list-item-label">Men’s Health/Wellbeing</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Spiritual/Intuitive Guidance/Protection", $dd)){ echo 'checked'; } } ?> value="Spiritual/Intuitive Guidance/Protection"  />
						<span class="wpcf7-list-item-label">Spiritual/Intuitive Guidance/Protection</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Age-Related Issues", $dd)){ echo 'checked'; } } ?> value="Age-Related Issues"/>
						<span class="wpcf7-list-item-label">Age-Related Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Stress Management/Relaxation", $dd)){ echo 'checked'; } } ?> value="Stress Management/Relaxation"  />
						<span class="wpcf7-list-item-label">Stress Management/Relaxation</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Parenting Issues", $dd)){ echo 'checked'; } } ?> value="Parenting Issues"  />
						<span class="wpcf7-list-item-label">Parenting Issues</span>
					</label>
				</span>
				<span class="wpcf7-list-item">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Holistic Health", $dd)){ echo 'checked'; } } ?> value="Holistic Health"  />
						<span class="wpcf7-list-item-label">Holistic Health</span>
					</label>
				</span>
				<span class="wpcf7-list-item last">
					<label>
						<input type="checkbox" name="your-experience[]" class="your_experiencecheck"
						 <?php if(!empty($dd)){ if (in_array("Mindfulness Practices", $dd)){ echo 'checked'; } } ?> value="Mindfulness Practices"/>
						<span class="wpcf7-list-item-label">Mindfulness Practices</span>
					</label>
				</span>
			</span>	
			</p>
			<span class="error" id="experience"></span>
		</div>
	</div>

	 
	
	<div class="last-check">
		<p>
			<span class="first last">
				<label>
					<input type="checkbox" name="privacy_policy" id="privacy_policy" <?php if ($userlogresult) { echo 'checked'; } ?> value="I have read and agree to amelio’s Privacy Policy"  />
					<span class="wpcf7-list-item-label">I have read and agree to amelio’s <a class="amelio-privacy" href="/privacy-policy/">Privacy Policy</a>.</span>
				</label>
			</span>
		</p>
		<span class="error" id="privacycheck"></span>
	</div>
	
	<button class="submitbtjointherapist register-btn" type="button" id="submitbtjointherapist">Sign up now<span class="loadx loading"></span></button>
	</form>
	<div id="response"></div> 
	</div>
	<style>
		
		button#submitbtjointherapist {position: relative;}

		.loadx {position: absolute;
left:120px;
top: 0px;
width: 100%;
height: 100%;
background: inherit;
display: flex;
align-items: center;
justify-content: center;
border-radius: inherit
}
p.alert.alert-danger {
    COLOR: RED;
    FONT-WEIGHT: 500;
}
.loadx::after {

content: '';

position: absolute;

border-radius: 50%;

border: 3px solid #165342;

width: 30px;

height: 30px;

border-left: 3px solid transparent;

border-bottom: 3px solid transparent;

animation: loading1 1s ease infinite;

z-index: 10

}.loadx::before {

content: '';

position: absolute;

border-radius: 50%;

border: 3px dashed #165342;

width: 30px;

height: 30px;

border-left: 3px solid transparent;

border-bottom: 3px solid transparent;

animation: loading1 2s linear infinite;

z-index: 5

}@keyframes loading1 {0% {transform: rotate(0deg)}100% {transform: rotate(360deg)}}

#submitbtjointherapist.active {transform: scale(.85)}
#submitbtjointherapist.activeLoading .loading {visibility: visible;opacity: 1}
#submitbtjointherapist .loading {opacity: 0;visibility: hidden}

	</style>

<?php
    $html=ob_get_clean();

    return $html;


}

function jointherapistscript(){
?>
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

/*	jQuery(document).ready(function () {    
            jQuery('#phonenumber').keypress(function (e) {    
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)){   
                    return false;
                }
                if(jQuery(this).val().length >12){
                	return false;
                }
            });
        });*/   

        jQuery(document).ready(function () {
        var regExp = /[a-z]/i;
		  jQuery('#phonenumber').on('keypress', function(e) {
		    var valuePhone = String.fromCharCode(e.which) || e.key;

		    // No letters
		    if (regExp.test(valuePhone)) {
		      e.preventDefault();
		      return false;
		    }
		  }); 
        });

	function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) {
            return false;
          }else{
            return true;
          }
        }


        var $regexname=/^[a-zA-Z ]*$/;
        var $phoneRegex = /^[- +()]*[0-9][- +()0-9]*$/;

        jQuery('#whatlicense').donetyping(function(){
        var whatlicense = jQuery('#whatlicense').val();
          if(whatlicense == ""){
              jQuery('#licenerror').text("Please Enter License Type Do You Currently Hold.");
              return false;
            }else{
              jQuery('#licenerror').text("");
              return true;
            }
        });

      jQuery('#fname').donetyping(function(){
        var fname = jQuery('#fname').val();
          if(fname == ""){
              jQuery('#fnameerror').text("Please enter your name.");
              return false;
            }else{
              jQuery('#fnameerror').text("");
              return true;
            }
        });

       jQuery('#lname').donetyping(function(){
        var lname = jQuery('#lname').val();
          if(lname == ""){
              jQuery('#lnameerror').text("Please enter your name.");
              return false;
            }else{
              jQuery('#lnameerror').text("");
              return true;
            }
        });

       jQuery('#emailid').donetyping(function(){
       	var newUserEmail = jQuery(this).val();
       	 if(newUserEmail == ""){
          jQuery('#mailerror').text("Please enter your email.");
          return false;
        } else if(IsEmail(newUserEmail)==false){
	          jQuery('#mailerror').text("Please enter a valid email.");
	      return false;
        } else{
          jQuery('#mailerror').text("");
          return true; 
        }
       });
       
       jQuery('#phonenumber').donetyping(function(){
       	var phoneNum = jQuery(this).val();
       	 if(phoneNum == ""){
          jQuery('#telerror').text("Please enter your phone number.");
          return false;
        }
        else if(!phoneNum.match($phoneRegex)){
        	jQuery('#telerror').text("Please enter a valid number.");
	        return false;
        }
         else if(phoneNum.length < 11){
	          jQuery('#telerror').text("Please enter a valid number.");
	      return false;
        } else{
          jQuery('#telerror').text("");
          return true; 
        }
       });


    function validateForm() {

var validCard = 0;

var valid = false;
var whatlicense = jQuery('#whatlicense').val();
var fname = jQuery('#fname').val();
var lname = jQuery('#lname').val();
var phonenumber = jQuery('#phonenumber').val();
var emailid = jQuery('#emailid').val();
var interestedinamelio = jQuery('#interestedinamelio').val();
var amelioclientintend = jQuery('#amelioclientintend').val();
var privacy_policy = jQuery('#privacy_policy').val();
var your_experiencecheck = jQuery('.your_experiencecheck').val();

var $phoneRegex = /^[- +()]*[0-9][- +()0-9]*$/;

var validateName = /^[a-z ,.'-]+$/i;
//var validateEmail = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
var validateEmail =  /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

//var validphone =/([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/;
// var arr = [];
// jQuery.each($("input[name='language']:checked"), function(){
//                   arr.push($(this).val());
// });

var experienceChecked = jQuery(".checkbox-columns input[type=checkbox]:checked").length;
var isValidExperience = experienceChecked > 0;

 if(!phonenumber.match($phoneRegex)) {
	jQuery('#fname').removeClass('require');
    jQuery('#fnameerror').text('');
    jQuery('#lname').removeClass('require');
    jQuery('#lnameerror').text('');
    jQuery('#phonenumber').addClass('require');
    jQuery('#telerror').text('Please enter valid Phone Number');
    jQuery("#phonenumber").focus();
    valid = false;

 }else if(IsEmail(emailid)==false) {
	jQuery('#fname').removeClass('require');
    jQuery('#fnameerror').text('');
    jQuery('#lname').removeClass('require');
    jQuery('#lnameerror').text('');
	jQuery('#phonenumber').removeClass('require');
    jQuery('#telerror').text('');
    jQuery('#emailid').addClass('require');
    jQuery('#mailerror').text('Invalid Email Address');
    jQuery('#emailid').focus();
    valid = false;

 }else if (jQuery('#interestedinamelio').val() === '') {
	jQuery('#fname').removeClass('require');
    jQuery('#fnameerror').text('');
    jQuery('#lname').removeClass('require');
    jQuery('#lnameerror').text('');
	jQuery('#phonenumber').removeClass('require');
    jQuery('#telerror').text('');
	jQuery('#emailid').removeClass('require');
	jQuery('#mailerror').text('');
	jQuery('#interestedinamelio').addClass('require');
	jQuery('#droperror').text('Please select  You Interested In Amelio');
    jQuery('#interestedinamelio').focus();
    valid = false;
 
 }
	else if (jQuery('#amelioclientintend').val() === '') {
		jQuery('#fname').removeClass('require');
		jQuery('#fnameerror').text('');
		jQuery('#lname').removeClass('require');
		jQuery('#lnameerror').text('');
		jQuery('#phonenumber').removeClass('require');
		jQuery('#telerror').text('');
		jQuery('#emailid').removeClass('require');
		jQuery('#mailerror').text('');
		jQuery('#interestedinamelio').removeClass('require');
		jQuery('#droperror').text('');
		jQuery('#amelioclientintend').addClass('require');
		jQuery('#howmuch').text('Please select How Much Time Do You Intend To Spend With Amelio Clients');
		jQuery('#amelioclientintend').focus();
		valid = false;
	
	}
	else if (jQuery('#whatlicense').val() === '') {

		jQuery('#fname').removeClass('require');
		jQuery('#fnameerror').text('');
		jQuery('#lname').removeClass('require');
		jQuery('#lnameerror').text('');
		jQuery('#phonenumber').removeClass('require');
		jQuery('#telerror').text('');
		jQuery('#emailid').removeClass('require');
		jQuery('#mailerror').text('');
		jQuery('#interestedinamelio').removeClass('require');
		jQuery('#droperror').text('');
		jQuery('#amelioclientintend').removeClass('require');
		jQuery('#howmuch').text('');
		jQuery('#whatlicense').addClass('require');
		jQuery('#licenerror').text('Please Enter License Type Do You Currently Hold.');
		jQuery('#whatlicense').focus();
		valid = false;
	}
	else if(!isValidExperience){
	jQuery('#fname').removeClass('require');
	jQuery('#fnameerror').text('');
	jQuery('#lname').removeClass('require');
	jQuery('#lnameerror').text('');
	jQuery('#phonenumber').removeClass('require');
	jQuery('#telerror').text('');
	jQuery('#emailid').removeClass('require');
	jQuery('#mailerror').text('');
	jQuery('#interestedinamelio').removeClass('require');
	jQuery('#droperror').text('');
	jQuery('#amelioclientintend').removeClass('require');
	jQuery('#howmuch').text('');
	jQuery('#whatlicense').removeClass('require');
	jQuery('#licenerror').text('');
    jQuery('#experience').text('Please select atleast one experience.');
	valid = false;
	}
	else if(jQuery('#privacy_policy').not(':checked').length){
		jQuery('#fname').removeClass('require');
		jQuery('#fnameerror').text('');
		jQuery('#lname').removeClass('require');
		jQuery('#lnameerror').text('');
		jQuery('#phonenumber').removeClass('require');
		jQuery('#telerror').text('');
		jQuery('#emailid').removeClass('require');
		jQuery('#mailerror').text('');
		jQuery('#interestedinamelio').removeClass('require');
		jQuery('#droperror').text('');
		jQuery('#amelioclientintend').removeClass('require');
		jQuery('#howmuch').text('');
		jQuery('#whatlicense').removeClass('require');
		jQuery('#licenerror').text('');
		jQuery('#experience').text('');
		jQuery('#privacy_policy').addClass('require');
		jQuery('#privacycheck').text('Please check Privacy policy.');
		valid = false;
   }
 else{
	    jQuery('#fname').removeClass('require');
		jQuery('#fnameerror').text('');
		jQuery('#lname').removeClass('require');
		jQuery('#lnameerror').text('');
		jQuery('#phonenumber').removeClass('require');
		jQuery('#telerror').text('');
		jQuery('#emailid').removeClass('require');
		jQuery('#mailerror').text('');
		jQuery('#interestedinamelio').removeClass('require');
		jQuery('#droperror').text('');
		jQuery('#amelioclientintend').removeClass('require');
		jQuery('#howmuch').text('');
		jQuery('#whatlicense').removeClass('require');
		jQuery('#licenerror').text('');
		jQuery('#privacy_policy').removeClass('require');
		jQuery('#privacycheck').text('');
		jQuery('#experience').text('');
    valid = true;
}


return valid;

}

jQuery(document).ready(function(){  
	jQuery('#submitbtjointherapist').click(function(){ 
		console.log(validateForm());
		if(validateForm() == true) {
			var formData = new FormData(jQuery('#joinprofessionhtml')[0]);
            formData.append('action', 'amelio_joinprofession_ajax');
			var ajaxURL = "<?php echo admin_url('admin-ajax.php')?>";
			jQuery('#response').html('');
			jQuery.ajax({
				type: 'POST',
				url: ajaxURL,
				data: formData,
				processData: false,
				contentType: false,
				beforeSend:function(){  
					jQuery('#submitbtjointherapist').addClass("activeLoading"); 
				},
				success: function(response){
						jQuery('#submitbtjointherapist').removeClass("activeLoading");
						if(response.success == 1){
							var trooresdata=response.trooresdata;
							var datare= trooresdata.split("#");
							window.location.href = response.trooresdata;
							jQuery('#joinprofessionhtml')[0].reset();
						}else{
							//jQuery('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
							jQuery('#mailerror').text(response.message);
							jQuery('#emailid').focus();
	                            jQuery([document.documentElement, document.body]).animate({
						        scrollTop: jQuery("#phonenumber").offset().top
						    }, 1500);
						}
				}
			})

		}

	});
});

</script>

<?php
}
add_action('wp_footer','jointherapistscript');

function amelio_joinprofession_ajax(){
	global $wpdb;
	$therapistusrid=$_POST['therapistusrid'];
	$whatlicense=$_POST['whatlicense'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$phonenumber=$_POST['phonenumber'];
	$emailid=$_POST['emailid'];
	$interestedinamelio=$_POST['interestedinamelio'];
	$amelioclientintend=$_POST['amelioclientintend'];
	$yourexperience=$_POST['your-experience'];
	$privacy_policy=$_POST['privacy_policy'];
	$table_name2 = $wpdb->base_prefix . 'amelio_joinprofession';
	if(!empty($therapistusrid)){
		$userlogresult = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `user_id`='" .$therapistusrid. "' and `email`='".$emailid."'");
 
		
		if ($userlogresult) {
			$yourences=json_encode($yourexperience);
			update_user_meta( $therapistusrid, 'interestedinamelio', $interestedinamelio );
			update_user_meta( $therapistusrid, 'amelioclientintend', $amelioclientintend );
			update_user_meta( $therapistusrid, 'yourexperience', $yourences );
			update_user_meta( $therapistusrid, 'whatlicense', $whatlicense );
			update_user_meta( $therapistusrid, 'billing_phone', $phonenumber );
	
			$wpdb->update($table_name2, 
			array(
			'fname'=>$fname, 
			'lname'=> $lname,
			'phone'=> $phonenumber,
			"interes" =>$interestedinamelio,
			"amelioc" => $amelioclientintend,
			"yourexperience" => $yourences,
			"whatlicenc" => $whatlicense,
			"creatdatetime" => date('Y-m-d H:i:s')
			),
			array('email' => $emailid));
			
			$urlf=get_site_url().'/therapist-dashboard/';
			wp_send_json( array( 'success' => 1,'message' => 'successful.','trooresdata'=>$urlf));
		}
		else{

			update_user_meta( $therapistusrid, 'interestedinamelio', $interestedinamelio );
			update_user_meta( $therapistusrid, 'amelioclientintend', $amelioclientintend );
			update_user_meta( $therapistusrid, 'yourexperience', $yourences );
			update_user_meta( $therapistusrid, 'whatlicense', $whatlicense );
			update_user_meta( $therapistusrid, 'billing_phone', $phonenumber );

			$yourences=json_encode($yourexperience);
			$wpdb->insert($table_name2, array(
				"user_id" => $therapistusrid,
				"fname" => $fname,
				"lname" => $lname,
				"email" => $emailid,
				"phone" => $phonenumber,
				"interes" =>$interestedinamelio,
				"amelioc" => $amelioclientintend,
				"yourexperience" => $yourences,
				"whatlicenc" => $whatlicense,
				"creatdatetime" => date('Y-m-d H:i:s'),
			));
			$userlog = $wpdb->insert_id;

			if(!empty($userlog)){
				$urlf=get_site_url().'/therapist-dashboard/';
				wp_send_json( array( 'success' => 1,'message' => 'successful.','trooresdata'=>$urlf));
			}

			

		}
	}else{

		$exists = email_exists( $emailid );
		if ( $exists ) {
			wp_send_json( array( 'success' => 0,'message' => "That E-mail is exits please use another email id."));
			
		} else {
			
			$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
			//$user_id = wp_create_user( $emailid, $random_password, $emailid );
			$userdata = array(
				'user_login' =>  $emailid,
				'user_nicename'   =>  $fname,
				'user_pass'  =>  $random_password,
				'user_email' =>  $emailid,
				'first_name' =>  $fname,
				'last_name' =>   $lname,
				'role' =>  'therapist',
			);

			
			 $user_id = wp_insert_user( $userdata ) ;
			if ( ! is_wp_error( $user_id ) ) {
				$yourences=json_encode($yourexperience);	
			update_user_meta( $user_id, 'interestedinamelio', $interestedinamelio );
			update_user_meta( $user_id, 'amelioclientintend', $amelioclientintend );
			update_user_meta( $user_id, 'yourexperience', $yourences );
			update_user_meta( $user_id, 'whatlicense', $whatlicense );
			update_user_meta( $user_id, 'billing_phone', $phonenumber );

			
			$wpdb->insert($table_name2, array(
				"user_id" => $user_id,
				"fname" => $fname,
				"lname" => $lname,
				"email" => $emailid,
				"phone" => $phonenumber,
				"interes" =>$interestedinamelio,
				"amelioc" => $amelioclientintend,
				"yourexperience" => $yourences,
				"whatlicenc" => $whatlicense,
				"creatdatetime" => date('Y-m-d H:i:s'),
			));
			$userlog = $wpdb->insert_id;

			if(!empty($userlog)){

				$to = $emailid;
				$subject = 'Amelio Therapist Login Details';
				$body =' <p>Hi '.$fname.' '.$lname.'!</p>';
				$body .='<p>You’ve successfully created your Amelio account. Please find your login details below:</p>';
				$body .='<p>Username: '.$emailid.'</p>';
				$body .='<p>Password: '.$random_password.'</p>';
				$body .='Thank you.';
			    $headers = array('Content-Type: text/html; charset=UTF-8');
				wp_mail( $to, $subject, $body, $headers );
	
				//$user = wp_authenticate($emailid, $random_password);

				wp_clear_auth_cookie();
				wp_set_current_user ( $user_id );
				wp_set_auth_cookie  ( $user_id );
				
					$urlf=get_site_url().'/therapist-dashboard/';
					wp_send_json( array( 'success' => 1,'message' => 'successful.','trooresdata'=>$urlf));
				

				
			}


			}




			
		}

	}



	exit();	
}
add_action('wp_ajax_nopriv_amelio_joinprofession_ajax', 'amelio_joinprofession_ajax');
add_action('wp_ajax_amelio_joinprofession_ajax', 'amelio_joinprofession_ajax');



function wcsfen_plugin_create_db() {
	
	global $wpdb;
	$tblname = 'amelio_joinprofession';
    $wp_track_table = $wpdb->prefix."$tblname";
	$charset_collate = $wpdb->get_charset_collate();
	#Check to see if the table exists already, if not, then create it
	  if($wpdb->get_var( "show tables like '".$wp_track_table."'" ) != $wp_track_table) 
    {

		$sql = "CREATE TABLE $wp_track_table (
		  id bigint(9) NOT NULL AUTO_INCREMENT,
		  user_id bigint(20),
		  fname tinytext NOT NULL,
		  lname tinytext NOT NULL,
		  email tinytext NOT NULL,
		  phone tinytext NOT NULL,
		  interes tinytext NOT NULL,
		  amelioc tinytext NOT NULL,
		  yourexperience tinytext  NULL,
		  whatlicenc tinytext NOT NULL,
		  creatdatetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";
        
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
			
    }
	
}
//add_action( 'init', 'wcsfen_plugin_create_db');




function create_custom_client_session_notes_table() {
    
    global $wpdb;
    $tblname = 'client_session_notes';
    $wp_track_table = $wpdb->prefix."$tblname";
    $charset_collate = $wpdb->get_charset_collate();
    #Check to see if the table exists already, if not, then create it
    if($wpdb->get_var( "show tables like '".$wp_track_table."'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE $wp_track_table (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          client_id varchar(255),
          session_title varchar(255),
          session_note varchar(255),
          creatdatetime datetime NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
            
    }
    
}
add_action( 'init', 'create_custom_client_session_notes_table');