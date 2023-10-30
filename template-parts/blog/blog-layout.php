<?php
/**
 * Template for Blog
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

?>
<div <?php astra_blog_layout_class( 'blog-layout-1' ); ?>>
	<div class="post-content <?php echo astra_attr( 'ast-grid-common-col' ); ?>" >
		<?php //astra_blog_post_thumbnail_and_title_order(); ?>
		<div class="ast-blog-featured-section post-thumb ast-grid-common-col ast-float">
			<div class="post-thumb-img-content post-thumb">
				<a href="<?php echo the_permalink(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			    </a>
			</div>
		</div>
		<header class="entry-header">
			<h2 class="entry-title" itemprop="headline">
				<a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php $categoriesPosts = get_the_category();
			if ( ! empty( $categoriesPosts ) ) { ?>
				<div class="entry-meta">
					<span class="cat-links">
						<a href="<?php echo get_category_link($categoriesPosts[0]->term_id); ?>" rel="category tag"><?php echo esc_html( $categoriesPosts[0]->name ); ?></a>
					</span>
                    <?php 
	                $readTime = get_field( "article_read_time", $postId );
					    	  if(!empty($readTime)){ ?>
	                 <span class="readTime"><?php echo $readTime; ?></span>
				    	  <?php } ?>
				</div>
				<?php } ?>						
		</header>

		<div class="entry-content clear test56"
		<?php
				echo astra_attr(
					'article-entry-content-blog-layout',
					array(
						'class' => '',
					)
				);
				?>
		>
			<?php
				astra_entry_content_before();
				astra_the_excerpt();
				astra_entry_content_after();

				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_html( astra_default_strings( 'string-blog-page-links-before', false ) ),
						'after'       => '</div>',
						'link_before' => '<span class="page-link">',
						'link_after'  => '</span>',
					)
				);
				?>
		</div><!-- .entry-content .clear -->
	</div><!-- .post-content -->
</div> <!-- .blog-layout-1 -->