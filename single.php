<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<?php 
while ( have_posts() ) :
the_post();

the_content();
endwhile;
	//astra_content_loop(); ?>





<?php get_footer(); ?>
