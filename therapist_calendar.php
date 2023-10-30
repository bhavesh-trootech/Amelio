<?php /* Template Name: Therapist calendar */

get_header();

?>
<div class="loaderOnload">
<div class="dcsLoaderImg">
    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
     color: #ff7361;">
     <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
       <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
       </path>
    </svg>
</div>
</div>
  <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>

    <!-- calendar start -->
    <style type="text/css">
        .calendar-main-section {padding: 20px;}
        .calendars_row{display: flex;}
        .calendars_row_1{display: block;max-width: 25%;padding: 10px;}
        .calendars_row_2{padding: 10px;}
        .calendar-main-section{width: 100%;}
        
#custome_overlay{position: fixed;top: 0;z-index: 100;width: 100%;height:100%;display: none;background: rgba(0,0,0,0.6);}
#custome_overlay .cv-spinner {height: 100%;display: flex;justify-content: center;align-items: center;}
#custome_overlay .spinner {width: 40px;height: 40px;border: 4px #ddd solid;border-top: 4px #165342 solid;border-radius: 50%;animation: sp-anime 0.8s infinite linear;}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{display:none;}
    </style>
    <!-- <div class="custom-loader"></div> -->
<div class="main-calendar">
    <div class="calendar-main-section">
        <div class="row">
            <div class="col-12">
                <div class="calendar-client-page">
                    <div class="calendar-page-title">
                        <h1>Calendar</h1>
                        <div class="calendar-page-buttons">
                            <button class="calendar-page-buttons-dialog-box"><img src="/wp-content/themes/astra-child/image/calendar-dash.svg">Schedule Session</button>
                        </div>
                        <script type="text/javascript">
                            jQuery(document).ready(function() {

                                jQuery('.fc-row .fc-bg td.fc-today').addClass("active");

                                jQuery(".calendar-page-buttons-dialog-box").click(function (){
                                    jQuery('body').addClass("amelio-popup-add");
                                    jQuery(".recurrence-sec").slideUp();                                   
                                    jQuery(".calendar_day_popup.pop-outer").fadeIn("slow");
                                    jQuery("#event-start-time").val( moment(new Date()).local().format("YYYY-MM-DD HH:mm"));
                                    jQuery("#event-end-time").val( moment(new Date()).local().format("YYYY-MM-DD HH:mm"));
                                    jQuery("#is_recurrence").prop('checked', false);
                                    jQuery('#recurrence').val("");
                                });
                                jQuery(".calendar_day_popup .close").click(function (){
                                    jQuery('body').removeClass("amelio-popup-add");
                                    jQuery(".calendar_day_popup.pop-outer").fadeOut("slow");
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="row calendars_row">
            <?php 
            $user_id = get_current_user_id();
            $current_user = wp_get_current_user();
            $user_role = $current_user->roles[0];
            if(is_user_logged_in() && in_array($user_role, array('therapist')) ){

                 $login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(site_url().'/access-token-save/') . '&response_type=code&client_id='.CLIENT_ID.'&access_type=offline&prompt=consent';
                $refresh_token = get_user_meta( $user_id, 'refresh_token' , true );
                $access_token = get_user_meta( $user_id, 'access_token' , true );
                // echo $access_token;

                if(empty($refresh_token) && empty($access_token)){

                    echo '<a id="logo" href="'.$login_url.'">Login With Google</a>';

                }else{ 
            ?>
            <div class="col-4 calendars_row_1">
                <div class="mini-calendar-main-div">                    
                    <script type="text/javascript">
                           jQuery(document).ready(function() {
                              var now = new Date();
                              var date = new Date(now.getFullYear(), now.getMonth() + 1, 1);

                              // jQuery("td[data-date=" + date.format('YYYY-MM-DD') + "]").addClass("active"); 
                              var d = date.getDate(),
                                  m = date.getMonth(),
                                  y = date.getFullYear();
                              jQuery('#calendarmini').fullCalendar({
                                displayEventTime: false,
                                header: {
                                  left: 'title',
                                  center: '',
                                  right: 'prev,next'
                                },
                                buttonText: {
                                  prev: "",
                                  next: "",
                                  today: 'Today',
                                  month: 'Month',
                                  week: 'Week',
                                  day: 'Day'
                                },
                                dayClick: function(date, allDay, jsEvent, view) {
                                    // alert(1);
                                    jQuery(this).addClass("active");
                                    if (date) {
                                        //jQuery('#calendar').fullCalendar('refresh');
                                        // Clicked on the entire day
                                        jQuery('#calendar').fullCalendar('changeView', 'agendaDay',date);
                                        jQuery("#calendarmini td").removeClass("active");
                                        jQuery("td[data-date=" + date.format('YYYY-MM-DD') + "]").addClass("active"); 
                                        // jQuery('#calendar').fullCalendar('changeView', 'agendaDay',date);
                                    }                                    
                                },
                                editable: true,
                                eventLimit: false,
                                droppable: false
                              });
                            });
                    </script>
            
                    <div id="calendarmini"></div>
                   
                </div>
            </div>
            <div class="col-8 calendars_row_2">
                <div class="full-calendar-main-div">
                    <?php echo do_shortcode( '[wpgc-calendar]' ); ?>
                    <div></div>
                    <div></div>
                </div>
            </div>
        <?php  
                }
            } else { ?>

            <div class="col-12 therapist_user_login">
                <a href="/login/">Login</a>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
<?php
get_footer();
?>
