<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

get_header(); ?>

  <div id="primary" <?php astra_primary_class(); ?>>

        <!-- category name displaying here -->
        <div class="topicTag">Topics</div>
        <?php
        $obj = get_queried_object();
        //print_r($obj);
        ?>
        <div class="titleCategory">
          <h1><?php echo $obj->name; ?></h1>
        </div>

    
        <!-- Posts loops here -->
    <?php astra_content_loop(); ?>
    
        <!-- This is pagination-->
    <?php //astra_pagination(); ?>
        <div class="postPagination">
        <?php 
       $pagingNumber = get_query_var( 'paged' );
       if( $pagingNumber == 0){ ?>
         <div class="previousArrow disabledArrow"><img src="/wp-content/uploads/2022/12/Group-6549.svg"></div>
       <?php }

        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( '<div class="previousArrow"><img src="/wp-content/uploads/2022/12/Group-6549.svg"></div>', 'amelio' ),
            'next_text' => __( '<div class="nextArrow"><img src="/wp-content/uploads/2022/12/Group-1-2.svg"></div>', 'amelio' ),
        ) ); ?>

        <div class="nextDisabled">
            <?php 
            $maxPagiNumber = $wp_query->max_num_pages;
            if($maxPagiNumber == $pagingNumber)
            {
              echo '<div class="nextArrow disabledArrow"><img src="/wp-content/uploads/2022/12/Group-1-2.svg"></div>';
            }
              ?>
            
        </div>
       </div>

  </div><!-- #primary -->

<?php get_footer(); ?>