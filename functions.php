<?php
/*$user = wp_get_current_user();
$roles = ( array ) $user->roles;
print_r($roles);*/
include 'custom.php';
include 'custfunction.php';
add_action( 'wp_enqueue_scripts', 'astra_theme_enqueue_styles' );
function astra_theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom-style.css' );
wp_enqueue_style( 'footer-style', get_stylesheet_directory_uri() . '/footer.css' );
wp_enqueue_style( 'How-its-work', get_stylesheet_directory_uri() . '/How-its-work.css' );
wp_enqueue_style( 'therapist', get_stylesheet_directory_uri() . '/therapist.css' );
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

wp_enqueue_style( 'custom-sweetalert2-style', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css');
wp_enqueue_script( 'custom-sweetalert2-script', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js', array('jquery'), (string) time(), true );
wp_enqueue_script( 'slick-min-js', get_stylesheet_directory_uri() . '/js/slick.min.js', array('jquery'), (string) time(), true );
//wp_enqueue_script( 'range-slider.js', get_stylesheet_directory_uri() . '/js/range-slider.js', array('jquery'), (string) time(), true );

wp_enqueue_script( 'ajaxscript_js', get_stylesheet_directory_uri() . '/js/ajaxscript.js', array('jquery'), (string) time(), true );
wp_localize_script('ajaxscript_js', 'clientsData', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'security' => wp_create_nonce( 'load_more_clients_users' )
));
wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/custom.js', array('jquery'), (string) time(), true );

/****/
wp_enqueue_style( 'privacy-policy-page', get_stylesheet_directory_uri() . '/css/privacy-policy.css');
wp_enqueue_style( 'blog-main-page', get_stylesheet_directory_uri() . '/css/blog-main-page.css');
wp_enqueue_style( 'fonts-page', get_stylesheet_directory_uri() . '/font/stylesheet.css');
wp_enqueue_style( 'find-therapist', get_stylesheet_directory_uri() . '/find-therapist.css' );
wp_enqueue_style( 'client-signup', get_stylesheet_directory_uri() . '/client-signup.css');
wp_enqueue_style( 'therapist-detail-page', get_stylesheet_directory_uri() . '/therapist-detail-page.css' );
wp_enqueue_style( 'buy-leads', get_stylesheet_directory_uri() . '/css/buy-leads.css');
wp_enqueue_style( 'dashboard-css', get_stylesheet_directory_uri() . '/css/dashboard.css');
wp_enqueue_style( 'therapist_clients-css', get_stylesheet_directory_uri() . '/css/therapist_clients.css');
wp_enqueue_style( 'purchase-css', get_stylesheet_directory_uri() . '/css/purchase-complete.css');
wp_enqueue_style( 'client-dashboard', get_stylesheet_directory_uri() . '/css/client-dashboard.css');
wp_enqueue_style( 'therapist_client_invite', get_stylesheet_directory_uri() . '/css/therapist_client_invite.css');
if(is_page('therapist-calendar')):
wp_enqueue_style( 'therapist_calendar', get_stylesheet_directory_uri() . '/css/therapist_calendar.css');
endif;
wp_enqueue_script( 'dcsLoadMorePostsScript', get_stylesheet_directory_uri() . '/js/loadmoreposts.js', array( 'jquery' ), (string) time(), true );
	wp_localize_script( 'dcsLoadMorePostsScript', 'dcs_frontend_ajax_object',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		)
	);

wp_enqueue_script( 'dcsLoadMoreTherapistPostsScript', get_stylesheet_directory_uri() . '/js/loadmoretherapistposts.js', array( 'jquery' ), (string) time(), true );
	wp_localize_script( 'dcsLoadMoreTherapistPostsScript', 'dcs_frontend_ajax_object_therapist',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		)
	);
/****/
}

require get_stylesheet_directory() . '/core/post-types.php';
require get_stylesheet_directory() . '/core/shortcodes.php';
require get_stylesheet_directory() . '/core/ajax-functions.php';

 function footerscript(){
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
<script>


ScrollTrigger.matchMedia({
  "(min-width: 1281px )": () => {
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
	"(min-width: 1025px) and (max-width: 1280px)": () => {
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
				end:'=+650',
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
				end:'=+10',
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

  wp_redirect( home_url('/login') );
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
	  $user = wp_get_current_user();
    $roles = ( array ) $user->roles;

      if( (is_page(10605) && is_user_logged_in() && (!in_array('therapist',$roles)) && (in_array('customer',$roles)) ) || (is_page(10104) && is_user_logged_in() && (!in_array('therapist',$roles)) && (in_array('customer',$roles)) ) || (is_page(9933) && is_user_logged_in() && (!in_array('therapist',$roles)) && (in_array('customer',$roles))) || (is_page(10999) && is_user_logged_in() && (!in_array('therapist',$roles)) && (in_array('customer',$roles))) || (is_page(10113) && is_user_logged_in() && (!in_array('therapist',$roles)) && (in_array('customer',$roles))) ) {
			$url = home_url( '/client-dashboard' );
    	wp_redirect( $url ); 
    	exit;
  }

	if ( is_page(7217) && !is_user_logged_in() ) { 

		    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         				$current_url = "https://";   
		    else  
		         $current_url = "http://";   
		    
			    // Append the host(domain name, ip) to the URL.   
		    $current_url.= $_SERVER['HTTP_HOST'];   
		    
		    // Append the requested resource location to the URL   
		    $current_url.= $_SERVER['REQUEST_URI'];    
		    $current_url = str_replace(strtok($_SERVER["REQUEST_URI"], '?'),'/login/',$current_url) ;
		      
		    //echo $current_url; 


			//	$url = home_url( '/login' );
			if(strtok($_SERVER["REQUEST_URI"], '?') == "/my-account/"){

				wp_redirect( $current_url ); 
				exit;
			}
		
	}
  if ( is_page(7217) ) { 
	// print_r($_SERVER['REQUEST_URI'] );
  	//     if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
     //     $current_url = "https://";   
	// 	    else  
	// 	         $current_url = "http://";   
	// 	    // Append the host(domain name, ip) to the URL.   
	// 	    $current_url.= $_SERVER['HTTP_HOST'];   
		    
	// 	    // Append the requested resource location to the URL   
	// 	    //$current_url.= $_SERVER['REQUEST_URI'];    
	// 	    $current_url.= strtok($_SERVER["REQUEST_URI"], '?');
		      
	// 	    //echo $current_url;  

		    if($_SERVER['REQUEST_URI'] == "/my-account/therapistaccount-leads/"){
				$url = home_url( '/therapist-dashboard/' );
				wp_redirect( $url ); 
				exit;
		    }
		    if($_SERVER['REQUEST_URI'] == "/my-account/"){
				$url = home_url( '/therapist-dashboard/' );
				wp_redirect( $url ); 
				exit;
		    }

	    
  }

  if(is_page(10841 ) && (!in_array('customer',$roles))) {
   wp_redirect( home_url( '/login' ) );
  }
  if(is_page(9933) && (!in_array('therapist',$roles))) {
   wp_redirect( home_url( '/login' ) );
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

  if ( (is_page(10605) && !is_user_logged_in()) || (is_page(10104) && !is_user_logged_in()) ) { 
			$url = home_url( '/login' );
    	wp_redirect( $url ); 
    	exit;
  }

  if ( is_page('10113') && !is_user_logged_in() ) { 
			$url = home_url( '/login' );
    	wp_redirect( $url ); 
    	exit;
  }
//if user login redirect to homepage client signup page
  if ( (is_page('client-signup') && ($_GET['therapist'] == "")) || (is_page('client-signup') && ($_GET['email'] == "") ) ) { 
    	wp_redirect( home_url() ); 
    	exit;
  }
/****/

}
/****/
add_filter( 'body_class', 'client_signup_page_class' );
function client_signup_page_class( $classes ) {
	if ( is_page('client-signup') &&  ($_GET['email'] !== "")) {
		$clientEmailCheck = base64_url_decode($_GET["email"]);
    $existsEmail = email_exists( $clientEmailCheck );
     if ( $existsEmail ) {
			 $classes[] = 'clientAlreadyLogged';
			}
		}
	return $classes;
}


/**
 * Create charge for buy leads
 */
add_action( 'wp_ajax_create_charge_for_buy_leads', 'create_charge_for_buy_leads' );  
add_action( 'wp_ajax_nopriv_create_charge_for_buy_leads', 'create_charge_for_buy_leads'); 

function create_charge_for_buy_leads()
{
	global $wpdb;

	// echo "<pre>";

	// DO NOT DELETE
	$table_name = $wpdb->base_prefix."transactions_logs";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
 
	   $charset_collate = $wpdb->get_charset_collate();
 
	   $sql = "CREATE TABLE $table_name (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  user_id bigint(20) UNSIGNED NOT NULL,
		  buy_lead int(10) NULL,
		  lead_price decimal(10,0) NULL,
		  total decimal(10,0) NULL,
		  transaction_id varchar(100) NULL,
		  status tinyint(1) NOT NULL,
		  /* created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, */
		  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY  (id)
	   ) $charset_collate;";
 
	   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	   dbDelta( $sql );
 
	   echo $table_name. " is created!";
	} 

	require 'stripe/Stripe.php';
// testing key
	// $publishable_key 	= "pk_test_51MmEKhSInswd5qCDXGjNIFwMDto9Jujphl4HVRZ1p3buZPHes0UQZvhHR3dARpagM9I8D0ViMbtzIH2ZvFSd7Kiu00TRdHd0ZQ";
	// $secret_key	 = "sk_test_51MmEKhSInswd5qCDLeOcOUILSIFoeG7QX3XLpLv12ClmO22HEABTJHWnN30qzQcWIhUCpH2zwZ68k3S63RyWhgYt00B3f9CxOX";
		
		$publishable_key 	= "pk_test_51KGrvYLhm9Ob8mhVaNc9EbtK8DxjshZbESZBCygcgBa07XdBinz9TYG5nbL07Wo8qoM714Ez8Hu7VAZ2kXp9shXV00GlXWllgs";
		$secret_key			= "sk_test_51KGrvYLhm9Ob8mhVcAgoZ0vJu49z2u0YXhEJCZk94iPwWfofM5C2EQRPninTglnqdVQ0evGqBt8jTmzzGZiCw6nI00oRRx9AAd";

	if (isset($_POST['stripeToken'])) {

		Stripe::setApiKey($secret_key);
		$description 	= "Lead Purchase Order ID #".rand(9999, 9999999);
		$amount_cents 	= $_POST['price']*100;
		$tokenid		= $_POST['stripeToken'];
		$buylead		= $_POST['buylead'];
		$user			= get_current_user_id();		
			
		$amount = intval($amount_cents);
		try {
			//currency => EUR, USD, INR

			$tr_create = array( 
				"amount" 		=> $amount_cents,
				"currency" 		=> "GBP",
				// 'source' => 'tok_mastercard', 
				"source" 		=> $tokenid,
				"description" 	=> $description
			);
			$charge 		= Stripe_Charge::create($tr_create);

			$id			= $charge['id'];
			$amount 	= $charge['amount'];
			$balance_transaction = $charge['balance_transaction'];
			$currency 	= $charge['currency'];
			$status 	= $charge['status'];
			$date 	= date("Y-m-d H:i:s");

		global $wpdb;
		$table_name = $wpdb->prefix . "transactions_logs";
			$wpdb->insert( $table_name, array(
				'user_id' => get_current_user_id(), 
				'buy_lead' =>  $_POST['buylead'],
				'lead_price' => $_POST['price'], 
				'total' => 7,
				'transaction_id' => $id, 
				'status' => 1
				),
				array( '%d', '%d', '%s', '%s', '%s', '%d') 
			);

			// echo $wpdb->last_query;
			// // Print last SQL query result
			// echo $wpdb->last_result;
			// // Print last SQL query Error
			// echo $wpdb->last_error;

			$user = get_user_by('ID', get_current_user_id());

			if( $user ) {

				$from = 'amelioweb@amelio.com'; // Set whatever you want like mail@yourdomain.com
	
				// if(!(isset($from) && is_email($from))) {
				// 	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
				// 	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				// 		$sitename = substr( $sitename, 4 );
				// 	}
				// 	$from = 'admin@'.$sitename;
				// }

				$to = $user->data->user_email;
				$subject = 'Purchase leads';
				$sender = 'From: <wordpress@amelio.stagingtraction.com>' . "\r\n";
				$message = 'Hello '.$user->first_name . ' ' . $user->last_name.',<br><br>';
				$message .= "You have successfully purchased ".$buylead." leads and it's credited to your account. <br><br>";
				$message .= "Thanks";
								
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;
	
				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail ) {
					$message = 'Email sent.';
				} else {
					$message = 'Email failed.';
				}
			}

			
			$result = array('id'=> $id, 'lead' => $buylead, 'email' => $to, 'status' => 1, 'email-status'=> $message);
			$result = json_encode($result);
			echo $result;
			exit;
	
			}catch(Stripe_CardError $e) {

				$error = $e->getMessage();
				$result = $wpdb->query(
					$wpdb->prepare(
					   "INSERT INTO cps_transactions_logs
					   ( user_id, buy_lead, lead_price, total, transaction_id, status)
					   VALUES ( %d, %s, %s, %s, %s, %s, %s )",
					   $user_id,
					   $buylead,
					   $price,
					   $amount,
					   $id,
					   0
					)
				);
				$result = "declined";
				echo $result;
				exit;
			}
	}
	
}

/****/
function login_with_email_address( &$username ) {
    $user = get_user_by( 'email', $username );
    if ( !empty( $user->user_login ) )
        $username = $user->user_login;
    return $username;
}
add_action( 'wp_authenticate','login_with_email_address' );
/****/
//change password min length
add_filter('rtcl_password_min_length', function() {
	return 8;
});

function amelio_change_password_hint( $hint_text ) {
  return 'Hint: The password should be at least eight characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).';
}
add_filter( 'password_hint', 'amelio_change_password_hint', 10, 1 );
/****/

add_filter( 'woocommerce_registration_error_email_exists', function( $html ) {
    $url =  wc_get_page_permalink( 'myaccount' );
    //$url = add_query_arg( 'redirect_checkout', 1, $url );
    $html = str_replace( 'An account is already registered with your email address.', 'An account is already registered with your email address. <a href="'.$url.'">Please log in.</a>', $html );
    return $html;
} );

/****/
function wpfooterscriptAmelio(){
?>
<script>
// JQuery code to detect browser
jQuery(document).ready(function() {
    var browser;
  
    if(navigator.userAgent.indexOf("MSIE")!=-1 || navigator.userAgent.indexOf("rv:11.0")!=-1) name = "msie";
    else if(navigator.userAgent.indexOf("Edge")!=-1) name = "microsoft-edge";
    else if(navigator.userAgent.indexOf("Firefox")!=-1) name = "firefox";
    else if(navigator.userAgent.indexOf("Opera")!=-1) name = "opera";
    else if(navigator.userAgent.indexOf("Chrome") != -1) name = "chrome";
    else if(navigator.userAgent.indexOf("Safari")!=-1) name = "safari";

		var OSName="unknown-os";
		if (navigator.appVersion.indexOf("Win")!=-1) OSName="windows";
		if (navigator.appVersion.indexOf("Mac")!=-1) OSName="mac-os";
		if (navigator.appVersion.indexOf("X11")!=-1) OSName="unix";
		if (navigator.appVersion.indexOf("Linux")!=-1) OSName="linux";

		var IEVersion="not-ie";
		if(navigator.userAgent.indexOf("rv:11.0")!=-1) IEVersion = "ie ie-11";
		else if(navigator.userAgent.indexOf("MSIE 10.0")!=-1) IEVersion = "ie ie-10";
		else if(navigator.userAgent.indexOf("MSIE 9.0")!=-1) IEVersion = "ie ie-9";
		else if(navigator.userAgent.indexOf("MSIE 8.0")!=-1) IEVersion = "ie ie-8";
		else if(navigator.userAgent.indexOf("MSIE 7.0")!=-1) IEVersion = "ie ie-7";

		var windowsVersion='not-windows';
		if(navigator.userAgent.indexOf("Windows NT 5.0")!=-1) windowsVersion = "windows-2000";
		else if (navigator.userAgent.indexOf("Windows NT 5.1")!=-1) windowsVersion="windows-xp";
		else if(navigator.userAgent.indexOf("Windows NT 6.0")!=-1) windowsVersion = "windows-vista";
		else if(navigator.userAgent.indexOf("Windows NT 6.1")!=-1) windowsVersion = "windows-7";
		else if(navigator.userAgent.indexOf("Windows NT 6.2")!=-1) windowsVersion = "windows-8";
		else if(navigator.userAgent.indexOf("Windows NT 6.3")!=-1) windowsVersion = "windows-8-1";
		else if(navigator.userAgent.indexOf("Windows NT 10.0")!=-1) windowsVersion = "windows-10";

		var device="not-mobile"
		if (navigator.userAgent.match(/Android|BlackBerry|Kindle|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) device="mobile";

		var isKindle="not-kindle"
		if (navigator.userAgent.match(/Kindle|KFTHWI/i)) isKindle="kindle";
  jQuery('body').addClass(name);
		jQuery('body').addClass(OSName);
		jQuery('body').addClass(device);
		jQuery('body').addClass(IEVersion);
		jQuery('body').addClass(windowsVersion);
		jQuery('body').addClass(isKindle);


    // jQuery('.calendar-page-title h1').click(function() {
    //   var custom_email = 'ramnik.chavda@trooinbound.com';
    //   var therapist_id = "<?php //echo get_current_user_id(); ?>";
    //   jQuery(".dcsLoaderImg").show();
    //   // console.log('therapist_id',therapist_id);
    //   jQuery.ajax({
    //     type: 'POST',
    //     url: "<?php //echo admin_url('admin-ajax.php'); ?>",
    //     data: {action: "delete_client_event", client_email: custom_email, therapist_id:therapist_id },
    //     dataType: 'json',
    //     success: function(response) {
    //     	jQuery('#calendar').fullCalendar('refetchEvents');
    //     	jQuery(".dcsLoaderImg").hide();
    //       Swal.fire(response.message);
    //     }
    //   });

    // });
});



jQuery(document).ready(function() {
	var now_date = new Date();
  var start_date = moment(now_date).local().format("YYYY-MM-DD hh:mm:ss");
	var next30days = new Date(now_date.setDate(now_date.getDate() + 30))
	// console.log('Today: ' + moment(now_date).utc().format("YYYY-MM-DD hh:mm:ss"))
	// console.log('Next 30th day: ' + moment(next30days).utc().format("YYYY-MM-DD hh:mm:ss"))
  var end_date = moment(next30days).local().format("YYYY-MM-DD hh:mm:ss");
  console.log('start_date', start_date);
  console.log('end_date', end_date);
    jQuery.ajax({
      type: 'POST',
      url: "<?php echo admin_url('admin-ajax.php'); ?>",
      data: {action: "page_load_event_rendar", start: start_date, end:end_date  },
      dataType: 'json',
      success: function(response) {
      	recorde_count = response.data.length;
      	var s = jQuery('.day-look-box .client-sessions .client-content .monthly_events_count p').text(recorde_count);
      	// alert(s);
      	// console.log('recorde_count', recorde_count);
      }
  });
});



</script>
	<?php
}
add_action('wp_footer','wpfooterscriptAmelio');

/****/
add_filter( 'wp_mail_from_name', function ( $original_email_from ) {
    return 'Amelio';
} );


add_action( 'woocommerce_order_status_completed', 'wc_send_order_to_mypage' );
function wc_send_order_to_mypage( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$items = $order->get_items();

	foreach ($items as $order_value) {
		$product_id = $order_value->get_product_id();
		$price = $order_value->get_total();
	}
	$transaction_id = $order_data['transaction_id'];
	$product_lead = get_post_meta( $product_id, 'therapistleadno', true );

	global $wpdb;
	$table_name = $wpdb->prefix . "transactions_logs";
		$wpdb->insert( $table_name, array(
			'user_id' => get_current_user_id(), 
			'buy_lead' =>  $product_lead,
			'lead_price' => $price, 
			'total' => 7,
			'transaction_id' => $transaction_id, 
			'status' => 1
			),
			array( '%d', '%d', '%s', '%s', '%s', '%d') 
		);
}


function disable_filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    unset( $value->response['advanced-custom-fields/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_filter_plugin_updates' );