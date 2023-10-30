<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
<?php if(!is_singular( 'post' )): ?>
	</div> <!-- ast-container -->
	<?php endif; ?>
	</div><!-- #content -->
<?php 
	astra_content_after();
		
	astra_footer_before();
		
	astra_footer();
		
	astra_footer_after(); 
?>
	</div><!-- #page -->
<?php 
	astra_body_bottom(); ?>  

<script>

	const [entry] = performance.getEntriesByType("navigation");

// Show it in a nice table in the developer console
//console.table(entry.toJSON());
//console.log("debugging");

if (entry["type"] === "back_forward"){
	const elementCls = document.querySelector("body");
if( (elementCls.classList.contains("page-id-9933")) || (elementCls.classList.contains("page-id-10104")) || (elementCls.classList.contains("page-id-10605")) || (elementCls.classList.contains("page-id-10999")) || (elementCls.classList.contains("page-id-10113")) ){
    location.reload();
}
}

</script>


<?php	wp_footer(); 
?>
	</body>
</html>
