<?php /* Template Name: Therapist Dashboard */

get_header();


global $wpdb;
    $therapist_id = get_current_user_id();
    $table_name = $wpdb->prefix . "events";

    // $events = $wpdb->get_results(
    //     "select * from " .
    //         $table_name .
    //         ' where start_Date >= "' .
    //         date("Y-m-d") .
    //         '" or end_Date >= "' .
    //         date("Y-m-d") .
    //         '" ORDER BY start_Date ASC'
    // );

    $events = $wpdb->get_results(
        "select * from " . $table_name . ' where therapist_id = "' . $therapist_id . '" AND start_Date >= "' . date("Y-m-d") . '" AND end_Date >= "' . date("Y-m-d") . '" ORDER BY start_Date ASC');


    $ev = [];

    foreach ($events as $event) {
        // echo "<pre>";print_r($event->attendees);echo "</pre>";
        // $event->htmlLink
        $event_explode = explode("eid=", $event->htmlLink);
        //$eventid = $event_explode[1];
        $eventid = $event->id;
        $tooltip = '';
        if ($event->start_Date != "0000-00-00") {
                $s_combined_date_and_time = $event->start_Date . ' ' . $event->start_Time;
                $start_date = strtotime($s_combined_date_and_time);
                $e_combined_date_and_time = $event->end_Date . ' ' . $event->end_Time;
                $end_date = strtotime($e_combined_date_and_time);
                $ev[] = [
                    "eventid" => $eventid,

                    'attendees' => $event->attendees,

                    "title" => $event->summary,

                    "start" => date("Y-m-d H:i:s", $start_date),

                    "end" => date("Y-m-d H:i:s", $end_date),

                    "allDay" => false,

                    // "tooltip" => $tooltip,
                ];
        }
    }
    $e = json_encode($ev, JSON_HEX_APOS);

?>
<div style="display:none" class="eventJson" defaultDate="<?php echo date('Y-m-d'); ?>" data='<?php echo $e; ?>' lang="<?php //echo $lang; ?>"></div>
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

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>amelio-dashboard</title>
    <link rel="stylesheet" href="<?=get_stylesheet_directory_uri()?>/css/dashboard.css">
</head> -->

<!-- <body> -->

    <div class="dashboard-main">


    <!-- notification-section -->

    <?php include get_stylesheet_directory().'/inc/notification-section.php'; ?>

<!-- notification-section END -->


        <!-- amelio-sidebar -->

        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>
        <!-- amelio-welcome -->


        <div class="amelio-welcome">
            <div class="amelio-welcome-inner">

            <div class="title-section">
                <?php $current_user = wp_get_current_user(); ?>
                <h1>Welcome back,<span> <?php echo $current_user->display_name; ?></span></h1>

                <div class="title-btn">
                    <a href="#"> <img src="<?=get_stylesheet_directory_uri()?>/image/notification-dash.svg" alt="notification"> </a>
                    <!-- <a href="#"> <img src="<?=get_stylesheet_directory_uri()?>/image/filter.png" alt="filter"></a> -->

                </div>
            </div>

            <hr>

            <!-- day-look -->

            <div class="day-look">

                <h2>How does your day look?</h2>

                <div class="day-look-box">
                    <div class="client-sessions">
                        <div class="client-img">
                            <img src="<?=get_stylesheet_directory_uri()?>/image/box1.png" alt="box1">
                        </div>

                        <div class="client-content">
                        <?php
                        global $wpdb;
                        // $therapist_id = get_current_user_id();
                        // $table_name = $wpdb->prefix . "events";

                        // $events = $wpdb->get_results("select * from ". $table_name . " where  therapist_id = '" . $therapist_id . "' AND start_datetime > NOW() ORDER BY start_datetime ASC");
                        
                        // $google_events_rs = get_google_calendar_list("20-03-2023T00:00:00Z", "20-04-2023T23:59:59Z");
                        // echo "<pre>";print_r($google_events_rs);echo "</pre>";
                        echo "<div class='monthly_events_count'><p>0</p></div>";
                        ?>
                        <div class="client-content-wrap">
                            <p>Client Sessions</p>
                            <a href="/therapist-calendar/">View in calendar <img src="<?=get_stylesheet_directory_uri()?>/image/arrow.png" alt="arrow"></a>
                        </div>
                        </div>
                    </div>

                    <div class="unread-message">

                        <div class="client-img">
                            <img src="<?=get_stylesheet_directory_uri()?>/image/box2.png" alt="box2">
                        </div>

                        <div class="client-content">
                            <?php
                            $table_name = $wpdb->prefix . "transactions_logs";
                            $count_leads = '';
                            // echo $table_name;
                            $leads_data = $wpdb->get_results("SELECT SUM(`buy_lead`) as 'buy_lead' FROM  ". $table_name . " WHERE  user_id = '" . get_current_user_id() . "'");
                            
                            if($leads_data[0]->buy_lead != '' && $leads_data[0]->buy_lead > 0){
                                $count_leads = $leads_data[0]->buy_lead;
                            }else{
                                $count_leads = 0;
                            }

                            ?>
                            <p><?php echo $count_leads; ?></p>

                        <div class="client-content-wrap">
                            <p>Total leads</p>
                            <a href="/therapist-buy-leads/">Buy leads<img src="<?=get_stylesheet_directory_uri()?>/image/arrow.png" alt="arrow"></a>
                        </div>
                        </div>

                    </div>

                    <div class="buy-leads">

                        <div class="client-img">
                            <img src="<?=get_stylesheet_directory_uri()?>/image/box3.png" alt="box3">
                        </div>

                        <div class="client-content-buy-leads">
                            <a href="#"><img src="<?=get_stylesheet_directory_uri()?>/image/buyleads-dash.svg" alt="man"></a>
                            <p>Reach more clients who are waiting for your expert help</p>
                            <a href="/therapist-client-invite/">Invite client<img src="<?=get_stylesheet_directory_uri()?>/image/arrow.png" alt="arrow"></a>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Upcoming sessions -->

            <div class="upcoming-section">

                <div class="upcoming-title-btn">
                    <h2>Upcoming sessions</h2>
                    <a href="/therapist-calendar/">View Calendar</a>
                </div>
                <div class="dashboard-upcoming-event-main">
                    <div class="dashboard-upcoming-loaderOnload">
                        <div class="dashboard-upcoming-dcsLoaderImg">
                            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
                 color: #ff7361;">
                                <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite">
                                    </animateTransform>
                                </path>
                            </svg>
                        </div>
                    </div>
                        <script type="text/javascript">

                             function daysFromString(dateString)
                            {
                                // split strings at / and return array
                                var splittedString = dateString.split("/");
                                // make a new date. Caveat: Months are 0-based in JS
                                var newDate = new Date(parseInt(splittedString[2], 10), parseInt(splittedString[0], 10)-1, parseInt(splittedString[1], 10));
                                // returns days since jan 1 1970
                                return Math.round(newDate.getTime() / (24*3600*1000));
                            }

                           
                            function DisplayEventDetails(event_id){
                                var event_data =  JSON.parse(jQuery("#"+event_id).val());
                                var event_date = moment(event_data.start).format('D MMMM YYYY');
                                var start_Time = moment(event_data.start).format('hh:mm a');
                                var meeting_url = ""; 
                                var custom_disable ="";
                                // console.log('event_data',event_data);
                                var end = moment(event_data.start).format('YYYY-MM-DD HH:mm:ss');
                                var start = moment(new Date()).local().format("YYYY-MM-DD HH:mm");
                                var diff = moment(end).unix() - moment(start).unix();

                                if(event_data.meeting_url != "" && event_data.meeting_url != undefined){
                                  meeting_url = '<div class="call-session-btn"><a href="'+event_data.meeting_url+'"><img src="/wp-content/uploads/2023/02/020-video-camera.svg">Go to call</a></div>';
                                }
                                // conole.log("diff",diff, "start", start, "ed", ed);
                                var ed = moment(event_data.end).format('YYYY-MM-DD HH:mm');                                
                                if(start > ed || diff >= 350 ){
                                    meeting_url = "";
                                }
                                if(diff > 0){
                                  diff = "Your client session will be taking place in "+moment.duration(diff, "seconds").humanize();
                                }else{
                                  diff = "Your client session has already been started just before "+moment.duration(diff, "seconds").humanize()+" ago";
                                }

                                if(start > event_data.end){
                                  diff = "Your client session has already ended";
                                } 
                                var displayName = "";
                                if(event_data.hasOwnProperty("attendees")){
                                  var attendees = JSON.parse(event_data.attendees);
                                  if(attendees.length >0 && attendees[0].hasOwnProperty("displayName")){
                                    displayName = attendees[0].displayName;
                                  }
                                }
                                var recurrence = (event_data.hasOwnProperty("recurrence") && event_data.recurrence != "")?event_data.recurrence.toLowerCase():"No";
                                
                                var duration = moment(event_data.end).unix() - moment(event_data.start).unix();
                                duration = moment.duration(duration, "seconds");
                                var d_hours = duration._data.hours;
                                var d_minutes = duration._data.minutes;
                                duration = "";
                                if(d_hours > 0){
                                  duration = (d_hours > 1)?d_hours+" hrs ":d_hours+"hrs ";
                                }
                                if(d_minutes > 0){
                                  duration+= (d_minutes > 1)?d_minutes+" min":d_minutes+"min";
                                }
                                Swal.fire({
                                  title: event_data.title,
                                  //icon: 'info',
                                  html: '<div class="main-event-popup"><div class="event-view-popup event-title"><img src="/wp-content/uploads/2023/02/003-user.svg"><h2>'+displayName+'</h2></div><div class="event-view-popup event-date"><img src="/wp-content/uploads/2023/02/calendar.svg"><h2>'+event_date+'</h2></div><div class="event-view-popup event-time"><img src="/wp-content/uploads/2023/02/clock.svg"><h2>'+start_Time+'('+duration+')</h2></div><div class="event-view-popup event-repeat"><img src="/wp-content/uploads/2023/02/refresh-cw.svg"><h2>Repeat '+recurrence+'</h2></div><div class="call-session" style="'+custom_disable+'"><h3>'+diff+'</h3>'+meeting_url+'</div></div>',
                                  showConfirmButton : false,
                                  showCloseButton: true,
                                  showCancelButton: false,
                                  focusConfirm: false,
                                });
                              }
                           jQuery(document).ready(function() {

                           
                            /**
                              * Get Event Details while click on sepecific events
                              **/
                              

                                var now = new Date();
                                var date = new Date(now.getFullYear(), now.getMonth() + 1, 1);
                                var d = date.getDate(),
                                m = date.getMonth(),
                                y = date.getFullYear();
                                var ev = eval(jQuery("div.eventJson").attr("data"));
                                var defaultDate = jQuery("div.eventJson").attr("defaultDate");

                                // var load_current_date = moment(now).utc().format("YYYY-MM-DD");
 
                                // jQuery.ajax({
                                //     type: 'POST',
                                //     url: "<?php //echo admin_url('admin-ajax.php'); ?>",
                                //     data: {action: "day_click_event_rendar", start: load_current_date },
                                //     dataType: 'json',
                                //     success: function(response) {
                                //         jQuery('#custome_overlay').hide();
                                //         var obj = JSON.parse(response.data);

                                //         var time_arr = new Array();
                                //         jQuery('#dashboard-upcoming-session').html('');
                                //         jQuery.each(obj, function(key,value) {
                                //             var s_start = moment.utc(value.start).local().format('YYYY-MM-DD HH:mm:ss');
                                //             var e_end = moment.utc(value.end).local().format('YYYY-MM-DD HH:mm:ss');
                                //             value.start = s_start;
                                //             value.end = e_end;
                                //             time_arr.push(value);
                                //             jQuery('#dashboard-upcoming-session').append('<div class="amelio-messages-columns"><div class="session-columns"><div class="profile-image"><h3>He</h3></div><div class="text-message"><div class="text-message-heading"><p>'+value.title+'</p><h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'+value.start+'</span></h6></div></div></div><div class="user-btn"><button><img src="/wp-content/uploads/2023/02/020-video-camera.svg"> Go to call</button></div><hr class="separator"></div>');
                                //         });
                                //     },
                                //     error: function(response) {
                                //     }
                                // });
                                var st = moment(now).utc().format("YYYY-MM-DD hh:mm:ss");
                                function daily_upcoming_events(st){
                                    jQuery('.dashboard-upcoming-loaderOnload , .dashboard-upcoming-dcsLoaderImg').show();

                                    jQuery.ajax({
                                        type: 'POST',
                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                        data: {action: "page_load_event_rendar", start: st, end:st },
                                        dataType: 'json',
                                        success: function(response) {
                                            
                                            jQuery('.dashboard-upcoming-loaderOnload , .dashboard-upcoming-dcsLoaderImg').hide();
                                            // var obj = JSON.parse(response.data);
                                            var obj = response.data;
                                            //console.log("before", obj);
                                            function sortResults(prop, asc) {
                                                obj.sort(function(a, b) {
                                                    if (asc) {
                                                        return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
                                                    } else {
                                                        return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
                                                    }
                                                });
                                                // renderResults();
                                            }                                             
                                            if(obj != undefined){
                                                sortResults('start', true);

                                            }
                                           // console.log("after", obj);
                                            var time_arr = new Array();
                                            jQuery('#dashboard-upcoming-session').html('');
                                            var count = 0

                                            jQuery.each(obj, function(key,value) {
                                                var s_start = moment.utc(value.start).local().format('YYYY-MM-DD HH:mm');
                                                var e_end = moment.utc(value.end).local().format('YYYY-MM-DD HH:mm');
                                                value.start = s_start;
                                                value.end = e_end;
                                                time_arr.push(value);

                                                var str = value.title;
                                                var matches = str.match(/\b(\w)/g); // ['J','S','O','N']
                                                var acronym = matches.join(''); // JSON
                                                
                                                if(acronym[1] == undefined){
                                                     var sec_ltr = '';
                                                }else{
                                                    var sec_ltr = acronym[1]
                                                }
                                                var sort = acronym[0]+''+sec_ltr;
                                                var current = moment(now).format('YYYY-MM-DD HH:mm');

                                                // obj = obj.sort((a, b) => {
                                                //   if (a.end < b.end) {
                                                //     return -1;
                                                //   }
                                                // });
                                                var client_name = JSON.parse(value.attendees)
                                                // console.log('---->>>>>',client_name[0].displayName);
                                                if(e_end >= current){
                                                    var meeting_url = ""; 

                                                    var custom_disable = "";
                                                    var end = moment(value.start).format('YYYY-MM-DD HH:mm');
                                                    var start = moment(new Date()).local().format("YYYY-MM-DD HH:mm");
                                                    var diff = moment(end).unix() - moment(start).unix();   

                                                    //var current_date = moment(new Date()).local().format("YYYY-MM-DD HH:mm");
                                                    var ed = moment(value.end).format('YYYY-MM-DD HH:mm');
                                                    // D MMMM YYYY
                                                    var custom_disable = "";
                                                    // if(start > ed || diff >= 300 ){
                                                    //   custom_disable = "pointer-events: none;opacity: 0.4;";
                                                    // }
                                                    
                                                    // var message_diff = '';
                                                    // if(start > ed){
                                                    //   message_diff = "Your client session has already ended";
                                                    // }                                                                                                   
                                            

                                                    if(value.meeting_url != "" && value.meeting_url != undefined){
                                                      meeting_url = '<div class="user-btn"><a href="'+value.meeting_url+'" style="'+custom_disable+'" target="_blank"><img src="/wp-content/uploads/2023/02/020-video-camera.svg">Go to call</a></div>';
                                                    }
                                                    // console.log(value.title, "diff",diff, "local time", start, "event time", ed);
                                                    if(start > ed || diff >= 350 ){
                                                        meeting_url = "";
                                                      custom_disable = "pointer-events: none;opacity: 0.4;";
                                                    }
                                                    var display_data = '';
                                                    var datetime_view = '';
                                                      if(jQuery(window).width() <= 820)
                                                    {  
                                                        display_data = "DisplayEventDetails('"+value.eventid+"');";
                                                    }

                                                    if(jQuery(window).width() <= 1024)
                                                    {
                                                        datetime_view = '<h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'+moment(value.start).format('D MMM, YYYY')+'</span></h6><h6><span><img src="/wp-content/uploads/2023/02/clock.svg">'+moment(value.start).format('hh:mm a')+'</span></h6>';
                                                    }else{
                                                        datetime_view = '<h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'+moment(value.start).format('D MMM, YYYY hh:mm a')+'</span></h6>';
                                                    }
                                                    
                                                    var c_date = moment(new Date()).local().format("YYYY-MM-DD");
                                                    var cs_date = moment(value.start).format('YYYY-MM-DD');
                                                    jQuery('#dashboard-upcoming-session').append('<div class="amelio-messages-columns" ><div class="session-columns" onClick="'+display_data+'"><div class="profile-image"><h3>'+sort+'</h3></div><div class="text-message"><div class="text-message-heading"><p>'+value.title+'</p><h6>'+client_name[0].displayName+'</h6>'+datetime_view+'</div></div></div>'+meeting_url+'<hr class="separator"><input type="hidden" name="event_data" id="'+value.eventid+'" class="event_data" value=\''+JSON.stringify(value)+'\'></div>');
                                                        // if(c_date == cs_date){}
                                                    /*if(value != '' && count == 0 && c_date == cs_date){

                                                        jQuery('#dashboard-upcoming-session').append('<div class="amelio-messages-columns" ><div class="session-columns" onClick="'+display_data+'"><div class="profile-image"><h3>'+sort+'</h3></div><div class="text-message"><div class="text-message-heading"><p>'+value.title+'</p><h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'+moment(value.start).format('YYYY-MM-DD hh:mm a')+'</span></h6></div></div></div><div class="user-btn">'+meeting_url+'</div><hr class="separator"><input type="hidden" name="event_data" id="'+value.eventid+'" class="event_data" value=\''+JSON.stringify(value)+'\'></div>');

                                                       
                                                    }else{
                                                        jQuery('#dashboard-upcoming-session').append('<div class="amelio-messages-columns" ><div class="session-columns" onClick="'+display_data+'"><div class="profile-image"><h3>'+sort+'</h3></div><div class="text-message"><div class="text-message-heading"><p>'+value.title+'</p><h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'+moment(value.start).format('YYYY-MM-DD hh:mm a')+'</span></h6></div></div></div><hr class="separator"><input type="hidden" name="event_data" id="'+value.eventid+'" class="event_data" value=\''+JSON.stringify(value)+'\'></div>');
                                                    }*/

                                                    count++;
                                               
                                                 }
                                            });
                                          
                                            // time_arr.length
                                            if (count == 0) {
                                                    jQuery('#dashboard-upcoming-session').append('<div class="no_record"><img src="/wp-content/uploads/2023/03/no_note_session.svg"><p>No Upcoming Sessions Found!</p></div>');
                                                }
                                            
                                        },
                                        error: function(response) {
                                        }
                                    });
                                }
                                daily_upcoming_events(st);
                                jQuery('#dashboard-mini-calendar').fullCalendar({
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
                                    events: function(start, end, timezone, callback) {
                                            // jQuery('#custome_overlay').show();
                                            // var st = moment(start).utc().format("YYYY-MM-DD hh:mm:ss");
                                            // var et = moment(end).utc().format("YYYY-MM-DD hh:mm:ss");

                                            // jQuery.ajax({
                                            //     type: 'POST',
                                            //     url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                            //     data: {action: "page_load_event_rendar", start: st, end:et  },
                                            //     dataType: 'json',
                                            //     success: function(response) {
                                            //         jQuery('#custome_overlay').hide();
                                            //         var obj = JSON.parse(response.data);
                                            //         var time_arr = new Array();
                                            //         jQuery.each(obj, function(key,value) {
                                            //             var s_start = moment.utc(value.start).local().format('YYYY-MM-DD HH:mm:ss');
                                            //             var e_end = moment.utc(value.end).local().format('YYYY-MM-DD HH:mm:ss');
                                            //             value.start = s_start;
                                            //             value.end = e_end;
                                            //             time_arr.push(value);


                                            //         });
                                            //         callback(time_arr);
                                            //     },
                                            //     error: function(response) {
                                            //     }
                                            // });
                                    },
                                    eventClick: function(event) {
                                    },
                                    dayClick: function(start, end, timezone, callback) {
                                            var st = moment(start).utc().format("YYYY-MM-DD");
                                            jQuery("#dashboard-mini-calendar .fc-day-top").removeClass("active");
                                            jQuery("td[data-date="+st+"]").addClass("active");
                                            // var et = moment(end).utc().format("YYYY-MM-DD hh:mm:ss");
                                            daily_upcoming_events(st);
                                    },

                                    editable: true,
                                    eventLimit: false,
                                    droppable: false
                                });


                            });

                    </script>
                    <div class="dashboard-calendar">
                        <div id="dashboard-mini-calendar"></div>
                        <div id="dashboard-upcoming-session">
                            <?php

                                // global $wpdb;
                                // $therapist_id = get_current_user_id();
                                // $table_name = $wpdb->prefix . "events";
                                // $events = $wpdb->get_results("select * from " . $table_name . ' where therapist_id = "' . $therapist_id . '" AND start_datetime > NOW() ORDER BY start_datetime ASC');
                                // if(count($events) > 0){
                                //     foreach ($events as $event) {
                                //         $eventname = explode(' ', $event->summary);
                                //         $f_event_name = $eventname[0];
                                //         $f_letter = substr($f_event_name,0,1);
                                //             $l_event_name = $eventname[1];
                                //             $l_letter = substr($l_event_name,0,1);

                                //         echo '<div class="amelio-messages-columns">
                                //                 <div class="session-columns">
                                //                     <div class="profile-image">
                                //                         <h3>'.$f_letter.''.$l_letter.'</h3>
                                //                     </div>

                                //                     <div class="text-message">
                                //                         <div class="text-message-heading">
                                //                             <p>'.$event->summary.'</p>
                                //                             <h6><span><img src="/wp-content/uploads/2023/02/calendar.svg">'.$event->start_datetime.'</span></h6>
                                //                         </div>
                                //                     </div>
                                //                 </div>   
                                //                 <div class="user-btn"><button><img src="/wp-content/uploads/2023/02/020-video-camera.svg"> Go to call</button></div>
                                //                 <hr class="separator"> 
                                //             </div>';
                                //     }
                                // }else{
                                //     echo '<div class="no_record">No Sessions Found!</div>';
                                // }
                            ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        </div>


        <!-- amelio-messages -->

        <div class="amelio-messages">

            <div class="amelio-message-row">
                <!-- <div class="message-heading"> -->
                    <h2>Session Notes</h2>
                <!-- </div> -->

                <!-- <div class="message-link"> -->
                    <!-- <a href="#">View Messages</a> -->
                <!-- </div> -->
            </div>

            <div class="amelio-messages-wrap">
        <?php

            function human_difference_new($post_date) {
                $seconds_hours = 60*60;
                $hours_days = $seconds_hours*24;

                $today = date("Y-m-d");
                $timestamp = $today.' '.date("H:i:s");

                $difference = strtotime($timestamp)-strtotime($post_date);
                if ($difference>$hours_days) {
                    $date1 = new DateTime(substr($post_date,0,10));
                    $date2 = new DateTime($today);
                    $since = $date2->diff($date1)->format("%d");
                    if ($since==1) { $since .= ' day'; }
                    else { $since .= ' days'; }
                } else if ($difference>$seconds_hours) {
                    $since = floor($difference/$seconds_hours).' hours';
                } else {
                    $since = floor($difference/60).' mins';//mins
                }

                return $since;
            }

            global $wpdb;
            $tblname = 'client_session_notes';
            $wp_track_table = $wpdb->prefix."$tblname";
            $therapist_id = get_current_user_id();
            $fetch_data = $wpdb->get_results("SELECT * FROM $wp_track_table WHERE therapist_id='".$therapist_id."' ORDER BY creatdatetime DESC");
            if(!empty($fetch_data) && $fetch_data != '' && count($fetch_data) > 0){

                foreach ($fetch_data as $results) {
                    $name = explode(' ', $results->session_title);
                    $fname = $name[0];
                    $lname = $name[1];
                    $f_letter = substr($fname,0,1);
                    $l_letter = substr($lname,0,1);
                    $client_info = get_userdata($results->client_id);
                    $client_name = $client_info->first_name;

                    // echo human_difference_new($results->creatdatetime).' ago';
                    echo '<div class="amelio-messages-columns ">
                                    <div class="profile-image">
                                        <h3>'.$f_letter.''.$l_letter.'</h3>
                                    </div>

                                    <div class="text-message">
                                        <div class="text-message-heading ">
                                            <h6>'.$client_name.'</h6>
                                            <h6>'.human_difference_new($results->creatdatetime).' ago'.'</h6>
                                        </div>
                                        <div class="text-message-heading">
                                            <p>'.$results->session_title.'</p>
                                        </div>
                                        <div class="text-message-description">
                                            <p>'.$results->session_note.'</p>
                                        </div>
                                    </div>
                                </div>';
                }
            }else{
                echo '<div class="no_record"><img src="/wp-content/uploads/2023/03/no_session.svg"><p>No Session Notes Found!</p></div>';
            }
            
            ?>
 
               <!-- <div class="amelio-messages-columns">
                    <div class="profile-image">
                        <h3>JD</h3>
                    </div>

                    <div class="text-message">
                        <div class="text-message-heading">
                            <p>John Darling</p>
                            <h6>5MIN AGO</h6>
                        </div>

                        <div class="text-message-description">
                            <p>Lorem ipsum dolor sit amet consectetur. Auctor dui semper in vitae lectus volutpat pellentesque. Et libero porttitor volutpat amet risus.</p>
                        </div>
                    </div>
                </div> -->
            </div>

        </div>

    </div>



<!-- </body>

</html> -->

<?php

get_footer();

?>