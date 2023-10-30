    <div class="amelio-sidebar">
            <div class="amelio-sidebar-img">
                <a href="/client-dashboard/"><img src="<?=get_stylesheet_directory_uri()?>/image/full.svg" alt="amelio-logo"></a>
                <a class="mobile-logo" href="/client-dashboard/"><img src="<?=get_stylesheet_directory_uri()?>/image/mobile-logo.svg" alt="amelio-logo"></a>

                <div class="hamburger-notification">
                    <!-- <div class="notification">
                        <a href="#"><img src="<?=get_stylesheet_directory_uri()?>/image/notification-mobile.png" alt="notification-mobile"></a>
                    </div> -->
                    <div class="hamburger-menu">
                        <span class="menu-icon"></span>
                        <span class="menu-icon"></span>
                        <span class="menu-icon"></span>
                    </div>
                </div>

            </div>

            <div class="mobile">
                <?php global $wp;
                $current_url = $wp->request;
                $post_id = url_to_postid($current_url);
                $pageslug = get_post_field( 'post_name', $post_id );
                ?>
                <div class="amelio-bar">
                    <ul>
                        <li class="<?php if($pageslug =="client-dashboard") { echo "active"; }?>">
                            <a href="/client-dashboard/">
                                <img src="<?=get_stylesheet_directory_uri()?>/image/home-dash.svg" alt="">
                                Dashboard
                            </a>

                            <a href="/client-dashboard/" class="white-arrow"><img src="<?=get_stylesheet_directory_uri()?>/image/Right-White-Arrow.svg" alt=""></a>
                        </li>

                        <!-- <li class="<?php if($pageslug =="clients") { echo "active"; }?>">
                            <a href="/clients/">
                                <img src="<?=get_stylesheet_directory_uri()?>/image/cont.png" alt="">
                                Clients
                            </a>
                            
                            <a href="/clients/" class="white-arrow"><img src="<?=get_stylesheet_directory_uri()?>/image/Right-White-Arrow.svg" alt=""></a>
                        </li> -->

                        <!-- <li class="<?php if($pageslug =="message") { echo "active"; }?>">
                            <a href="#">
                                <img src="<?=get_stylesheet_directory_uri()?>/image/mess.png" alt="">
                                Messages <span class="message-new">1 new</span>
                            </a>
                            <a href="#" class="white-arrow"><img src="<?=get_stylesheet_directory_uri()?>/image/Right-White-Arrow.svg" alt=""></a>
                        </li>
                        <li class="<?php if($pageslug =="calendar") { echo "active"; }?>">
                            <a href="#">
                                <img src="<?=get_stylesheet_directory_uri()?>/image/bag.png" alt="">
                                Calendar
                            </a>
                            <a href="#" class="white-arrow"><img src="<?=get_stylesheet_directory_uri()?>/image/Right-White-Arrow.svg" alt=""></a>
                        </li>
                        <li class="buy-leads-mob-show <?php if($pageslug =="buy-leads") { echo "active"; }?>">
                            <a href="#">
                                <img src="<?=get_stylesheet_directory_uri()?>/image/Layer 2.png" alt="">
                                Buy Leads
                            </a>
                            <a href="#" class="white-arrow"><img src="<?=get_stylesheet_directory_uri()?>/image/Right-White-Arrow.svg" alt=""></a>
                        </li> -->
                    </ul>
                </div>
            
                <div class="amelio-lead-wrap">
                    <!-- <div class="amelio-leads">
                        <img src="<?=get_stylesheet_directory_uri()?>/image/Layer 2.png" alt="leads">
                        <p>Reach more clients who are waiting for your expert help.</p>
                        <a href="/therapist-buy-leads/">Buy leads <img src="<?=get_stylesheet_directory_uri()?>/image/arr.svg" alt=""></a>
                    </div> -->
                    <div class="amelio-logout test">
                        <a href="<?php echo wp_logout_url(); ?>"><img src="<?=get_stylesheet_directory_uri()?>/image/logout.svg" alt="logout"> Log out</a>
                    </div>
                </div>

            </div>
    </div>