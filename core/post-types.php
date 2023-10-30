<?php 
function careers_post_type() {
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Career Opportunity', 'Career Opportunity', 'astra-child' ),
        'singular_name'       => _x( 'Career Opportunity', 'Career Opportunity', 'astra-child' ),
        'menu_name'           => __( 'Career Opportunity', 'astra-child' ),
        'parent_item_colon'   => __( 'Parent Career Opportunity', 'astra-child' ),
        'all_items'           => __( 'All Career Opportunity', 'astra-child' ),
        'view_item'           => __( 'View Career Opportunity', 'astra-child' ),
        'add_new_item'        => __( 'Add New Career Opportunity', 'astra-child' ),
        'add_new'             => __( 'Add New', 'astra-child' ),
        'edit_item'           => __( 'Edit Career Opportunity', 'astra-child' ),
        'update_item'         => __( 'Update Career Opportunity', 'astra-child' ),
        'search_items'        => __( 'Search Career Opportunity', 'astra-child' ),
        'not_found'           => __( 'Not Found', 'astra-child' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'astra-child' ),
    );
      
// Set other options for Custom Post Type
      
    $carrersArgs = array(
        'label'               => __( 'Career Opportunities', 'astra-child' ),
        'description'         => __( 'Career Opportunity news and reviews', 'astra-child' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ), 
        //'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
  
    );
      
    // Registering your Custom Post Type
    register_post_type( 'career-opportunity', $carrersArgs );
  
}
add_action( 'init', 'careers_post_type', 0 );