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
?>