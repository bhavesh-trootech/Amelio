<?php
/* Template Name: purchase complete */
get_header();
?>
<div class="purchaseMain">
    <div class="sidebar-dashboard-main">
        <!-- amelio-sidebar start -->
        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>
        <!-- amelio-sidebar end -->
    </div>
</div>
<section class="purchase-sec">   
    <div class="leads-purchase">
        <img src="/wp-content/uploads/2023/01/Mask-group-7.svg" alt="">
        <h1 class="heading-purchase">Your purchase is complete</h1>
        <p class="leads-message">Your 12 leads will be sent to your email at: email@email.com, good luck!</p>
        <button class="btn-dashboard"><a href="#">Return to Dashboard</a></button>
    </div>      
</section>
<?php
get_footer();
?>