<?php
include 'custom.php';
add_action( 'wp_enqueue_scripts', 'astra_theme_enqueue_styles' );
function astra_theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom-style.css' );
wp_enqueue_style( 'footer-style', get_stylesheet_directory_uri() . '/footer.css' );
wp_enqueue_style( 'How-its-work', get_stylesheet_directory_uri() . '/How-its-work.css' );
wp_enqueue_style( 'reviews', get_stylesheet_directory_uri() . '/reviews.css' );
wp_enqueue_style( 'pricing', get_stylesheet_directory_uri() . '/pricing.css' );
wp_enqueue_style( 'careers', get_stylesheet_directory_uri() . '/careers.css' );
wp_enqueue_style( 'faq', get_stylesheet_directory_uri() . '/faq.css' );
wp_enqueue_style( 'faq_detail', get_stylesheet_directory_uri() . '/faq_detail.css' );
wp_enqueue_style( 'contact', get_stylesheet_directory_uri() . '/contact.css' );
wp_enqueue_style( 'aboutpage', get_stylesheet_directory_uri() . '/aboutpage.css' );
wp_enqueue_style( 'joinus', get_stylesheet_directory_uri() . '/joinus.css' );
wp_enqueue_style( 'signup-professional', get_stylesheet_directory_uri() . '/signup-professional.css' );
wp_enqueue_style( 'category-page', get_stylesheet_directory_uri() . '/category-page.css');
wp_enqueue_style( 'blog-page', get_stylesheet_directory_uri() . '/blog-page.css');
wp_enqueue_style( 'login-page', get_stylesheet_directory_uri() . '/login-page.css');
wp_enqueue_script( 'slick-min-js', get_stylesheet_directory_uri() . '/js/slick.min.js', array('jquery'), (string) time(), true );
wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/custom.js', array('jquery'), (string) time(), true );

/****/
wp_enqueue_style( 'blog-main-page', get_stylesheet_directory_uri() . '/css/blog-main-page.css');
wp_enqueue_style( 'font-main-page', get_stylesheet_directory_uri() . '/font/stylesheet.css');
wp_enqueue_script( 'dcsLoadMorePostsScript', get_stylesheet_directory_uri() . '/js/loadmoreposts.js', array( 'jquery' ), (string) time(), true );
	wp_localize_script( 'dcsLoadMorePostsScript', 'dcs_frontend_ajax_object',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		)
	);
/****/
}

require get_stylesheet_directory() . '/core/post-types.php';

 function footerscript(){
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
<script>





ScrollTrigger.matchMedia({
  "(min-width: 1025px )": () => {
		const t1= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-1',
				// markers: true,
				start:'top 90%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-1',1,{opacity:0},{opacity:1})
		.fromTo('.animate-1',0.2,{opacity:1},{opacity:0})


		const t2= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-2',
				// markers: true,
				start:'top 90%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-2',1,{opacity:0},{opacity:1})
		.fromTo('.animate-2',0.2,{opacity:1},{opacity:0})

		const t3= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-3',
				// markers: true,
				start:'top 90%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-3',1,{opacity:0},{opacity:1})
		.fromTo('.animate-3',0.2,{opacity:1},{opacity:0})


		const i0= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-1',
				markers: false,
				start:'top 80%',
				pin: false,
				pinSpacing:false,
				end:'=+100',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-1',1,{opacity:0},{opacity:1})



		const i1= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-1',
				markers: false,
				start:'top 20%',
				pin: true,
				pinSpacing:false,
				end:'=+1000',
				scrub: true,
			}


		}) 
		// .fromTo('.mo-animate-1',0.2,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-1',1,{opacity:1},{opacity:1})
		.fromTo('.mo-animate-1',1,{opacity:1},{opacity:1})
		.fromTo('.mo-animate-1',0.2,{opacity:1},{opacity:0})

		const i2= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-2',
				markers: false,
				start:'top 20%',
				pin: true,
				pinSpacing:false,
				end:'=+1000',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-2',0.2,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-2',1,{opacity:1},{opacity:1})
		.fromTo('.mo-animate-2',1,{opacity:1},{opacity:1})
		.fromTo('.mo-animate-2',0.1,{opacity:1},{opacity:0})

		const i3= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-3',
				markers: false,
				start:'top 20%',
				pin: true,
				pinSpacing:false,
				end:'=+100',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-3',0.1,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-3',1,{opacity:1},{opacity:1})
		// .fromTo('.mo-animate-3',1,{opacity:1},{opacity:1})
		// .fromTo('.mo-animate-3',0.2,{opacity:1},{opacity:0})

}
})

ScrollTrigger.matchMedia({
  "(min-width: 769px) and (max-width: 1024px)": () => {
		const t1= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-1',
				// markers: true,
				start:'top 50%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-1',1,{opacity:0},{opacity:1})
		.fromTo('.animate-1',1,{opacity:1},{opacity:0})


		const t2= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-2',
				// markers: true,
				start:'top 50%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-2',1,{opacity:0},{opacity:1})
		.fromTo('.animate-2',1,{opacity:1},{opacity:0})

		const t3= gsap.timeline({
			scrollTrigger:{
				trigger: '.animate-3',
				// markers: true,
				start:'top 50%',
				pin: false,
				end:'=+200',
				scrub: true,
			}


		}) 
		.fromTo('.animate-3',1,{opacity:0},{opacity:1})
		.fromTo('.animate-3',1,{opacity:1},{opacity:0})


		const i1= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-1',
				// markers: true,
				start:'top 50%',
				pin: false,
				pinSpacing:false,
				end:'=+100',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-1',1,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-1',1,{opacity:1},{opacity:0})

		const i2= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-2',
				// markers: true,
				start:'top 50%',
				pin: false,
				pinSpacing:false,
				end:'=+100',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-2',1,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-2',1,{opacity:1},{opacity:0})

		const i3= gsap.timeline({
			scrollTrigger:{
				trigger: '.mo-animate-3',
				// markers: true,
				start:'top 50%',
				pin: false,
				pinSpacing:false,
				end:'=+100',
				scrub: true,
			}


		}) 
		.fromTo('.mo-animate-3',1,{opacity:0},{opacity:1})
		.fromTo('.mo-animate-3',1,{opacity:1},{opacity:0})

}
})


 </script>



<?php
 }
 add_action('wp_footer','footerscript');

/******/
//testimonial slider shortcode
function testimonial_slider() { 
  ob_start();
    ?> 

<?php 
$testimonialaArgs = array( 
  'post_type' => 'testimonials',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'order' =>'DESC'
);

 $the_query = new WP_Query( $testimonialaArgs );
    if ( $the_query->have_posts() ) : ?>
			<div class="testimonial-slider">
			  <div class="slider testimonial-slider">
			    <?php  while ( $the_query->have_posts() ) : $the_query->the_post(); 
            $postId = get_the_ID();
            $testimonial_image = get_field( "testimonial_image", $postId );
            $testimonial_text = get_field( "testimonial_text", $postId );
            $position = get_field( "position", $postId );
			    	?>
			    <div class="testimonial-box">

			    	<div class="left-col">
			    	  <div class="bubble-testi-img">
			    	  	<img src="<?php echo $testimonial_image; ?>">
			    	  </div>
			      </div>

			      <div class="right-col">
			      	<div class="testiContent">
			    	  	<p><?php echo $testimonial_text; ?></p>
			    	  </div>
              
              <div class="testimonialBtmInfo">
			    	  	<p class="testi-name"><strong><?php echo get_the_title($postId); ?></strong></p>
			    	  	<p class="testi-positions"><?php echo $position; ?></p>
			    	  </div>

			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>

			<script>
			jQuery(document).ready(function(){
			   jQuery('.testimonial-slider').slick({
				   arrows: true,
				   slidesToShow: 1,
				   dots: false,
				   infinite: false,
				   autoplay: false
           
				 });
			});
			</script>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('testimonial-slider', 'testimonial_slider');
/*****/
//Career opportunity toggle shortcode
function career_opportunity_toggle() { 
  ob_start();
    ?> 

<?php 
$careeraArgs = array( 
  'post_type' => 'career-opportunity',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'order' =>'DESC'
);

 $career_query = new WP_Query( $careeraArgs );
    if ( $career_query->have_posts() ) : ?>
			<div class="careerSection">
			  <div class="careerSectionInner">
			    <?php $i=1; while ( $career_query->have_posts() ) : $career_query->the_post(); 
            $postId = get_the_ID();
            $work_location = get_field( "work_location", $postId );
            $job_time = get_field( "job_time", $postId );
			    	?>
			    <div class="carrer-box <?php if($i ==1) { echo "active"; } ?>">

			    	<div class="carrer-header">
			    	  
			    	  <div class="carrer-work">
			    	  	<div class="carrer-title">
			    	  	<?php echo get_the_title( $postId); ?>
			    	  </div>
			    	  <div class="careerTitleInner">
			    	  	<div class="work-location"><img src="<?php echo home_url(); ?>/wp-content/uploads/2022/12/Remote.svg"><h4><?php echo $work_location; ?></h4></div>
			    	  	<div class="work-time"><img src="<?php echo home_url(); ?>/wp-content/uploads/2022/12/Fulltime.svg"><h4><?php echo $job_time; ?></h4></div>
			    	  </div>
			    	  </div>
			    	  <div class="carrer-toggle <?php if($i ==1) { echo "activeToggle"; } ?>">
			    	  	<img class="plusToggle" src="<?php echo home_url(); ?>/wp-content/uploads/2022/12/plus.svg">
			    	  	<img class="minusToggle" src="<?php echo home_url(); ?>/wp-content/uploads/2022/12/minus.svg">
			    	  </div>
			      </div>

			      <div class="carrer-content">
				      	<div class="careerContent">
				    	  	<p><?php echo get_the_content($postId) ?></p>
				    	  </div>
				    	  <div class="careerLink">
				    	  	<a href="<?php echo get_the_permalink($postId); ?>">Apply now</a>
			    	  </div>
			      </div>

			    </div>
			  <?php $i++; endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>

			<script>
			jQuery(document).ready(function(){
				   jQuery(".carrer-toggle").click(function(){
				   	if(jQuery(this).hasClass('activeToggle')){
				   		jQuery(this).removeClass("activeToggle");
				   		jQuery(this).parents(".carrer-box").find(".carrer-content").slideUp();
				   		jQuery(this).parents(".carrer-box").removeClass("active");  
				   }else{
				   	 jQuery(".carrer-box .carrer-content").slideUp();
				   	 jQuery(".carrer-box").removeClass("active");
				   	 jQuery(".carrer-toggle").removeClass("activeToggle");
				   	 jQuery(this).addClass("activeToggle");
				   	 jQuery(this).parents(".carrer-box").find(".carrer-content").slideDown();
				   	 jQuery(this).parents(".carrer-box").addClass("active");
				   }
				  });
			});
			</script>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('career-opportunities', 'career_opportunity_toggle');
/****/

//Blog sidebar shortcode
function blog_sidebar_posts() { 
  ob_start();
    ?> 

<?php 
$postaArgs = array( 
  'post_type' => 'post',
  'posts_per_page' => 3,
  'post_status' => 'publish',
  'order' =>'DESC'
);

 $post_query = new WP_Query( $postaArgs );
    if ( $post_query->have_posts() ) : ?>
			<div class="postSidebar">
            <h3 class="recentArticlesSidebar">Recent Articles</h3>
			  <div class="postSidebarInner">
			    <?php  while ( $post_query->have_posts() ) : $post_query->the_post(); 
            $postId = get_the_ID();
			    	?>
			    <div class="post-box">

			    	<div class="post-image">
			    	 <?php the_post_thumbnail( 'medium_large' ); ?>
			      </div>

			      <div class="post-content">
				      	<div class="post-category">
				    	  	<p><?php $categoriesPosts = get_the_category();
									if ( ! empty( $categoriesPosts ) ) { ?>
										<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
										<?php
									}
									?>
									</p>
									<?php 
                $readTime = get_field( "article_read_time", $postId );
				    	  if(!empty($readTime)){ ?>
                 <div class="readTime"><p><?php echo $readTime; ?></p></div>
				    	  <?php } ?>
				    	  </div>
				    	  
				    	  <div class="postTitle">
				    	  	<a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a>
			    	    </div>
			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('blog-sidebar-posts', 'blog_sidebar_posts');
/****/

//Blog inner you might also posts
function blog_bottom_posts() { 
  ob_start();
    ?> 

<?php 
$postRandomaArgs = array( 
  'post_type' => 'post',
  'posts_per_page' => 3,
  'post_status' => 'publish',
  'order' =>'DESC',
  'orderby'=> 'rand'
);

 $post_random_query = new WP_Query( $postRandomaArgs );
    if ( $post_random_query->have_posts() ) : ?>
			<div class="postBottomSection">
			  <div class="postBottomInner">
			    <?php  while ( $post_random_query->have_posts() ) : $post_random_query->the_post(); 
            $postId = get_the_ID();
			    	?>
			    <div class="post-box">

			    	<div class="post-image">
			    	 <?php the_post_thumbnail( 'medium_large' ); ?>
			      </div>

			      <div class="post-content">
				      	<div class="post-category">
				    	  	<p><?php $categoriesPosts = get_the_category();
									if ( ! empty( $categoriesPosts ) ) { ?>
										<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
										<?php
									}
									?>
									</p>
									<?php 
                $readTime = get_field( "article_read_time", $postId );
				    	  if(!empty($readTime)){ ?>
                 <div class="readTime"><p><?php echo $readTime; ?></p></div>
				    	  <?php } ?>
				    	  </div>
				    	  
				    	  <div class="postTitle">
				    	  	<a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a>
			    	    </div>
			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('blog-random-posts', 'blog_bottom_posts');
/*****/
//user custom fields
add_action( 'show_user_profile', 'amelio_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'amelio_custom_user_profile_fields' );
function amelio_custom_user_profile_fields( $user )
{
	$designation = get_the_author_meta( 'designation', $user->ID );
    echo '<h3 class="heading">Extra Information</h3>';
    ?>
    <table class="form-table">
    <tr>
        <th><label for="contact">Designation</label></th>
        <td><input type="text" class="input-text form-control" value="<?php echo $designation; ?>" name="designation" id="designation" style="width:25em"/></td>
    </tr>
    </table>
    <?php
}

add_action( 'personal_options_update', 'amelio_update_profile_fields' );
add_action( 'edit_user_profile_update', 'amelio_update_profile_fields' );
function amelio_update_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( ! empty( $_POST['designation'] )) {
		update_user_meta( $user_id, 'designation', $_POST['designation'] );
	}
}
/****/
//Blog author display
function blog_author() { 
  ob_start();
  global $post;
  $author_id=$post->post_author;
  $blogDesignation = get_the_author_meta( 'designation', $author_id );
    ?> 
<div class="blogAuthorSection">
<div class="blog-author-img">
<?php $userFIeld = 'user_'.$author_id; ?>
<img src="<?php echo get_field('user_profile_picture', $userFIeld); ?>" width="140" height="140" class="avatar" alt="<?php echo the_author_meta( 'display_name' , $author_id ); ?>" />
</div>
<div class="blog-author-name">
	<p>Written by <?php the_author_meta( 'user_nicename' , $author_id ); ?> </p>
  <p class="authorDesigntion"><?php echo $blogDesignation; ?></p>
</div>
</div>
    <?php
    return ob_get_clean();
}
add_shortcode('blog-author', 'blog_author');
/****/
add_filter( 'use_widgets_block_editor', '__return_false' );
/****/
//register sidebar
function amelio_widgets_init() {

    register_sidebar( array(
        'name' => __( 'Addtoany Social', 'amelio' ),
        'id' => 'add_to_any_social',
        'description' => __( '', 'amelio' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s addtoanycustom">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ) );
}
add_action( 'widgets_init', 'amelio_widgets_init' );
/****/
function add_to_any_social_share() { 
  ob_start();
    ?> 
    <?php if ( is_active_sidebar( 'add_to_any_social' ) ) { ?>
	<div class="social-share">
		<?php dynamic_sidebar('add_to_any_social'); ?>
	</div>
   <?php } ?>
    <?php
    return ob_get_clean();
}
add_shortcode('social-share', 'add_to_any_social_share');
/****/
function custom_category_query( $query ){
    if(is_category()){
        $query->set( 'post_type', array( 'post' ) );
        $query->set( 'posts_per_page', '24' );
    }
}
//add_action('pre_get_posts', 'custom_category_query');
/****/
//blog page start
//Blog big page
function blog_big_featured() { 
  ob_start();
    ?> 

<?php 
$postSmallFeaturedaArgs = array( 
  'post_type' => 'post',
  'posts_per_page' => 1,
  'post_status' => 'publish',
  'order' =>'DESC',
  'tax_query'      => array(
            array(
                'taxonomy'  => 'post_tag',
                'field'     => 'slug',
                'terms'     => 'big-featured'
            )
        )

);

 $big_fetured_query = new WP_Query( $postSmallFeaturedaArgs );
    if ( $big_fetured_query->have_posts() ) : ?>
			<div class="postBlogSection blogBigFeatured">
			  <div class="postBlogSectionInner">
			    <?php  while ( $big_fetured_query->have_posts() ) : $big_fetured_query->the_post(); 
            $postId = get_the_ID();
			    	?>
			    <div class="post-box">

			    	<div class="post-image">
			    	 <?php the_post_thumbnail( 'medium_large' ); ?>
			      </div>

			      <div class="post-content">
				      	<div class="post-category">
				    	  	<p><?php $categoriesPosts = get_the_category($postId);
									if ( ! empty( $categoriesPosts ) ) { ?>
										<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
										<?php
									}
									?>
									</p>
									<?php 
                $readTime = get_field( "article_read_time", $postId );
				    	  if(!empty($readTime)){ ?>
                 <div class="readTime"><p><?php echo $readTime; ?></p></div>
				    	  <?php } ?>
				    	  </div>
				    	  
				    	  <div class="postTitle">
				    	  	<h2><a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a></h2>
			    	    </div>
			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('blog-big-featured', 'blog_big_featured');
/****/

//Blog small page
function blog_small_featured() { 
  ob_start();
    ?> 

<?php 
$postSmallFeaturedaArgs = array( 
  'post_type' => 'post',
  'posts_per_page' => 3,
  'post_status' => 'publish',
  'order' =>'DESC',
  'tax_query'      => array(
            array(
                'taxonomy'  => 'post_tag',
                'field'     => 'slug',
                'terms'     => 'small-featured'
            )
        )

);

 $small_fetured_query = new WP_Query( $postSmallFeaturedaArgs );
    if ( $small_fetured_query->have_posts() ) : ?>
			<div class="postBlogSection blogSmallFeatured">
			  <div class="postBIgFeaturedInner">
			    <?php  while ( $small_fetured_query->have_posts() ) : $small_fetured_query->the_post(); 
            $postId = get_the_ID();
			    	?>
			    <div class="post-box">

			    	<div class="post-image">
			    	 <?php the_post_thumbnail( 'medium_large' ); ?>
			      </div>

			      <div class="post-content">
				      	<div class="post-category">
				    	  	<p><?php $categoriesPosts = get_the_category($postId);
									if ( ! empty( $categoriesPosts ) ) { ?>
										<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
										<?php
									}
									?>
									</p>
									<?php 
                $readTime = get_field( "article_read_time", $postId );
				    	  if(!empty($readTime)){ ?>
                 <div class="readTime"><p><?php echo $readTime; ?></p></div>
				    	  <?php } ?>
				    	  </div>
				    	  
				    	  <div class="postTitle">
				    	  	<h2><a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a></h2>
			    	    </div>
			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('blog-small-featured', 'blog_small_featured');
/****/
//category list blog page
function blog_category_list() { 
  ob_start();
  $categoryArgs = array(
			'hide_empty'      => true,
			'orderby' => 'name',
	    'order'   => 'ASC'
		);
		$categoryObj = get_categories($categoryArgs);
		if(!empty($categoryObj)){
			echo '<div class="categoryList">';
     foreach($categoryObj as $categorylist) { ?>
		  <div class="catBlock"><a href="<?php echo get_category_link($categorylist->term_id); ?>"><?php echo $categorylist->name; ?></a></div>
		<?php }
		echo '</div>';
	}

    return ob_get_clean();
}
add_shortcode('blog-category-list', 'blog_category_list');
/****/
//Blog the Latest section
function blog_latest_post() { 
  ob_start();
    ?> 

<?php 
$postLatestdaArgs = array( 
  'post_type' => 'post',
  'posts_per_page' => 3,
  'post_status' => 'publish',
  'order' =>'DESC',
);

 $blog_latest_query = new WP_Query( $postLatestdaArgs );
    if ( $blog_latest_query->have_posts() ) : ?>
			<div class="postBlogSection blogLatest">
			  <div class="postBIgFeaturedInner">
			    <?php  while ( $blog_latest_query->have_posts() ) : $blog_latest_query->the_post(); 
            $postId = get_the_ID();
			    	?>
			    <div class="post-box">

			    	<div class="post-image">
			    	 <?php the_post_thumbnail( 'medium_large' ); ?>
			      </div>

			      <div class="post-content">
				      	<div class="post-category">
				    	  	<p><?php $categoriesPosts = get_the_category($postId);
									if ( ! empty( $categoriesPosts ) ) { ?>
										<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
										<?php
									}
									?>
									</p>
									<?php 
                $readTime = get_field( "article_read_time", $postId );
				    	  if(!empty($readTime)){ ?>
                 <div class="readTime"><p><?php echo $readTime; ?></p></div>
				    	  <?php } ?>
				    	  </div>
				    	  
				    	  <div class="postTitle">
				    	  	<h2><a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a></h2>
			    	    </div>
			      </div>

			    </div>
			  <?php endwhile; wp_reset_postdata(); ?>

			  </div>
			</div>
<?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('blog-latest-post', 'blog_latest_post');
/****/
/**
 * shortcode for listing blog posts
 */
add_shortcode('ajaxloadmoreblogdemo','ajaxloadmoreblogdemo');
function ajaxloadmoreblogdemo($atts, $content = null){
 ob_start();
 $atts = shortcode_atts(
        array(
 'post_type' => 'post',
 'initial_posts' => '4',
 'loadmore_posts' => '4',
 ), $atts, $tag
    );
 $additonalArr = array();
 $additonalArr['appendBtn'] = true;
 $additonalArr["offset"] = 0; ?>
 <div class="dcsAllPostsWrapper"> 
 <input type="hidden" name="dcsPostType" value="<?=$atts['post_type']?>">
     <input type="hidden" name="offset" value="0">
     <input type="hidden" name="dcsloadMorePosts" value="<?=$atts['loadmore_posts']?>">
     <div class="dcsDemoWrapper ast-row">
 <?php dcsGetPostsFtn($atts, $additonalArr); ?>
 </div>
 </div>
 <div class="appendLoadMore"></div>
 <?php
    return ob_get_clean();
}

/****/
function dcsGetPostsFtn($atts, $additonalArr=array()){ 
   $args = array(
     'post_type' => $atts['post_type'],
     'posts_per_page' => $atts['initial_posts'],
     'offset' => $additonalArr["offset"]
 );
 $the_query = new WP_Query( $args );
 $max_pages = $the_query->max_num_pages;
 $havePosts = true;
 if ( $the_query->have_posts() ) {
     
     while ( $the_query->have_posts() ) {
         $the_query->the_post(); ?>

         <div class="loadMoreRepeat blogLoop">
         	<div class="ast-post-format- blog-layout-1">
						<div class="post-content ast-grid-common-col">
							<div class="ast-blog-featured-section post-thumb ast-grid-common-col ast-float">
								<div class="post-thumb-img-content post-thumb">
									<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'large' ); ?>
								  </a>
								</div>
							</div>		
							 <?php 
							$categoriesPosts = get_the_category();
							if ( ! empty( $categoriesPosts ) ) { ?>
							<header class="entry-header">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?=get_the_title()?></a></h2>		
								<div class="entry-meta">
									<span class="cat-links">
									<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>" rel="category tag"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
								  </span>
                                  <?php 
	                $readTime = get_field( "article_read_time", get_the_ID() );
					    	  if(!empty($readTime)){ ?>
	                 <span class="readTime"><?php echo $readTime; ?></span>
				    	  <?php } ?>
							  </div>
							</header>
							<?php } ?>
							
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
    <div class="btnLoadmoreWrapper" data-maxp="<?php echo $max_pages; ?>">
    <a href="javascript:void(0);" class="btn btn-primary dcsLoadMorePostsbtn">View all Articles</a> 
    </div>
    
    <!-- loader for ajax -->
    <div class="dcsLoaderImg" style="display: none;">
     <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
     color: #ff7361;">
     <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
       <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
		   </path>
		 </svg>
		 </div>
          </div>
		
 
    <!-- <p class="noMorePostsFound" style="display: none;">No More Posts Found</p> -->
    <?php
 }
}
/****/

add_action("wp_ajax_dcsAjaxLoadMorePostsAjaxReq","dcsAjaxLoadMorePostsAjaxReq");
add_action("wp_ajax_nopriv_dcsAjaxLoadMorePostsAjaxReq","dcsAjaxLoadMorePostsAjaxReq");
function dcsAjaxLoadMorePostsAjaxReq(){
	extract($_POST);
	$additonalArr = array();
	$additonalArr['appendBtn'] = false;
	$additonalArr["offset"] = $offset;
	$atts["initial_posts"] = $dcsloadMorePosts;
	$atts["post_type"] = $postType;
	dcsGetPostsFtn($atts, $additonalArr);
	die();
}

//Blog sinle get read time
function blog_read_time() { 
  ob_start();
  global $post;
  $post_id = $post->ID;
    ?> 
    <div class="post-category">
    	<?php 
				$categoriesPosts = get_the_category();
				if ( ! empty( $categoriesPosts ) ) { ?>
		  	<p>										
		  		<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
				</p>
				<?php } ?>
        <?php 
	      $readTime = get_field( "article_read_time", $post_id );
	  	  if(!empty($readTime)){ ?>
         <div class="readTime">
         	<p><?php echo $readTime; ?></p>
         </div>
         <?php } ?>
		  </div>
    <?php
    return ob_get_clean();
}
add_shortcode('blog-read-time', 'blog_read_time');




/**
 * Before addto cart, only allow 1 item in a cart
 */
add_filter( 'woocommerce_add_to_cart_validation', 'woo_custom_add_to_cart_before' );
 
function woo_custom_add_to_cart_before( $cart_item_data ) {
 
    global $woocommerce;
    $woocommerce->cart->empty_cart();
 
	return true;
}


/**
 * unset columnd on order list of myaccount
 */
function filter_woocommerce_account_orders_columns( $columns ) {
    // $columns['order-number'] = __( 'New name 1', 'woocommerce' );
    // $columns['order-date'] = __( 'New name 2', 'woocommerce' );
    // $columns['order-status'] = __( 'New name 3', 'woocommerce' );
    // $columns['order-total'] = __( 'New name 4', 'woocommerce' );
    // $columns['order-actions'] = __( 'New name 5', 'woocommerce' );

	unset($columns['order-actions']);

    return $columns;
}
add_filter( 'woocommerce_account_orders_columns', 'filter_woocommerce_account_orders_columns', 10, 1 );

/**
 * Redirect homepage when user loged out
 */
add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){

  wp_redirect( home_url() );
  exit();

}

/**
 * Disable admin bar for user(User role not have ('administrator' and 'admin'))
 */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_action( 'template_redirect', 'wc_custom_user_redirect' );

function wc_custom_user_redirect() {

  if ( is_page(7217) ) { 
    $url = home_url( '/therapist-dashboard' );
    wp_redirect( $url ); 
    exit;
  }

  if ( is_page(9445) && is_user_logged_in() ) { 
			$url = home_url( '/therapist-dashboard' );
    	wp_redirect( $url ); 
    	exit;
  }

  if ( is_page(9933) && !is_user_logged_in() ) { 
			$url = home_url( '/login' );
    	wp_redirect( $url ); 
    	exit;
  }
}