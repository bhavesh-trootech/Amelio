<?php get_header(); ?>

<div class="therapistSectionMain">

<div class="backtotherapist">
    <a href="<?php echo home_url('/find-a-therapist'); ?>">Back to Therapists</a>
</div>
<?php 
$author_id = $author;
$userFIeld = 'user_'.$author_id; 
?>
<div class="therapistDetails">

    <div class="leftcolumn">
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
 
    <div class="authorTitle">
    <h1><?php echo $curauth->display_name; ?></h1>
    </div>

    <div class="authorBioFull">
    <?php echo get_field('add_bio', $userFIeld); ?>
    </div>

  </div>

  <div class="rightcolumn">
    <div class="authorImage">
       <img src="<?php echo get_field('user_profile_picture', $userFIeld); ?>" width="300" height="300" class="avatar" alt="<?php echo the_author_meta( 'display_name' , $author_id ); ?>" />
    </div>
  </div>

</div>

</div>
<?php get_footer(); ?>