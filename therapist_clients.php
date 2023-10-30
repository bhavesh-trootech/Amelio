<?php /* Template Name: Therapist clients */
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

    <div class="dashboard-main">

        <?php include get_stylesheet_directory().'/inc/notification-section.php'; ?>
        <!-- amelio-sidebar start -->

        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>
        
        <!-- amelio-sidebar end -->

        <!-- clients main page start -->
 
        <div class="amelio-client-page">
            <div class="client-page-title">
                <h1>Clients</h1>

                <div class="client-page-buttons">
                    <form>
                        
                        <div class="searchbox-icon">
                            <a href="#" class="search-box"><img src="<?=get_stylesheet_directory_uri()?>/image/search.svg" alt=""></a>
                            
                            <input type="search" placeholder="Search" class="searchbox-input" id="MobClientSearchInput">
                        </div>

                        <input type="search" placeholder="Search for a client..." class="searchbox" id="clientSearchInput">

                    </form>
                    
                    <a href="/therapist-client-invite/" class="green-button">Invite new clients</a>
                </div>
            </div>


<?php 
$currentUser = get_current_user_id();

if(isset($_SESSION['NameOrderFilter'])) {
    $order = $_SESSION["NameOrderFilter"];
    $orderBy = 'meta_value';
} elseif(isset($_SESSION['dateOrderFilter'])){
    $order = $_SESSION["dateOrderFilter"];
    $orderBy = 'registered';
}else{
    $order = "ASC";
    $orderBy = 'meta_value';
}

$clientArgs = array (
    'role' => 'customer',
    'meta_key' => 'first_name',
    'orderby'  => $orderBy,
    'order' => $order,
    'number' => 6,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'client_therapist_id',
            'value'   => $currentUser,
            'compare' => '='
        ),
        array(
            'key'     => 'client_status',
            'value'   => 'active client',
            'compare' => '='
        )
    )
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($clientArgs);
$totalUsers = $wp_user_query->get_total(); 
$rec_page = 6;
$total_pages = ceil($totalUsers / $rec_page); 
// Get the results
$clients = $wp_user_query->get_results();

?>

    <?php if($totalUsers != 0) { ?>
    <div class="client-page-popup">
                <div class="client-popup-text">
                    <p><span class="countClients"><?php echo $totalUsers; ?></span> Clients</p>
                </div>

                <div class="client-popup-icon">

                    <div class="filterBox">
                    <p>Filter by <img src="<?=get_stylesheet_directory_uri()?>/image/chevron-down.svg" alt=""></p>
                    </div>

                    <ul class="filterClientList">
                        <li class="filterName filterInnerLi"><span>Name</span>
                        
                            <ul>
                                <li data-selected="ASC" class="filterByNameASC clickNameFilter <?php if($_SESSION["NameOrderFilter"] == "ASC"){echo "selectedActive"; } ?>">Ascending</li>
                                <li data-selected="DESC" class="filterByNameDesc clickNameFilter <?php if($_SESSION["NameOrderFilter"] == "DESC"){echo "selectedActive"; } ?>">Descending</li>
                            </ul>
                        </li>
                        <li class="filterDate filterInnerLi"><span>Date</span>
                            <ul>
                                <li data-selected="DESC" class="filterByDateLatest clickDateFilter <?php if($_SESSION["dateOrderFilter"] == "DESC"){echo "selectedActive"; } ?>">Latest</li>
                                <li data-selected="ASC" class="filterByNameOld clickDateFilter <?php if($_SESSION["dateOrderFilter"] == "ASC"){echo "selectedActive"; } ?>">Previous</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>

        
<?php 
// Check for results
if (!empty($clients)) {
    echo '<div class="client-page-columns">';
    // loop through each author
    foreach ($clients as $client)
    { 
        // get all the user's data
        $author_info = get_userdata($client->ID);
        $clientFirstname = $author_info->first_name;
        $clientLastname = $author_info->last_name;
        if($clientLastname == ""){
            $explodeStr = explode(" ",$clientFirstname);
            $clientLastnamestr = $explodeStr[1];
        }

        $clientEmail = $author_info->user_email;
        global $wpdb;
        $invitedusersTable = 'invitedusers';
        $clientdate = $wpdb->get_var("SELECT `date` FROM $invitedusersTable WHERE invitationEmailId='".$clientEmail."'");
        $clientdate = date("d F Y", strtotime($clientdate));
        /*$datearr = explode("-",$clientdate);
        $dateNum= $datearr[0];
        $monthNum= $datearr[1];
        $yearNum= $datearr[2];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March*/
        ?>
        <div class="client-white-columns" data-id="<?php echo $client->ID; ?>">
                    <div class="column-heading">
                        <h3 class=""><?php echo substr($clientFirstname, 0, 1); ?><?php if(!empty($clientLastname)) { echo substr($clientLastname, 0, 1); } else { echo substr($clientLastnamestr, 0, 1); } ?></h3>
                    </div>

                    <div class="client-name">
                        <div class="client-name-details">
                            <p><?php echo $clientFirstname." ".$clientLastname; ?></p>
                            <h6>Client since: <?php echo $clientdate; ?></h6>
                        </div>

                        <div class="right-arrow-image">
                            <img src="<?=get_stylesheet_directory_uri()?>/image/chevron-right.svg" alt="logout">
                        </div>

                    </div>
                </div>
            <?php
    }
    echo '</div>';
} else {
    echo '<p class="noClientDiv">No clients found.</p>';
}
?>
    <div class="more clientListMore blog-section4">
        <!-- <div class="dcsLoaderImg" style="display: none;">
             <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
             color: #ff7361;">
             <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
               <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
               </path>
             </svg>
        </div> -->
        <?php if($total_pages > 1): ?>
        <div class="more_link load_clients_btn btnLoadmoreWrapper" data-maxpclients="<?php echo $total_pages; ?>" data-page="1"><a>Load More</a></div>
       <?php endif; ?>

    </div>

    <div class="dcsLoaderNotFoundRec">
             <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
             color: #ff7361;">
             <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
               <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
               </path>
             </svg>
    </div>

            
        </div>

        <!-- clients main page end -->
    </div>
<script type="text/javascript">
 function create_note_session(){
        var clientUserId = jQuery(".create-session-notes-btn").attr('data-client-id');
        var session_title = jQuery("#session-title").val();
        var session_note = jQuery("#session-note").val();

        var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/,
        error = 0,
        parameters;
        jQuery(".input-error").removeClass('input-error');
        
        if(!blank_reg_exp.test(jQuery("#session-title").val())) {
            jQuery("#session-title").addClass('input-error');
            error = 1;
        }
        if(!blank_reg_exp.test(jQuery("#session-note").val())){
            jQuery("#session-note").addClass('input-error');
            error = 1;
        }

        if(error == 1)
            return false;


        jQuery(".loader-div .loaderOnload, .loader-div .dcsLoaderImg").show();
        // jQuery(".loader-div").addClass("loaderDispaly");
        jQuery.ajax({
            type:"POST",
            url:dcs_frontend_ajax_object.ajaxurl,
            data: {
                action: "create_client_session_note",
                clientUserId : clientUserId,
                session_title : session_title,
                session_note : session_note
            },
            success: function (response) {
                var res = JSON.parse(response);
                $("#create_form_note_id")[0].reset();
                jQuery(".loader-div .loaderOnload, .loader-div .dcsLoaderImg").hide();
                // jQuery(".loader-div").removeClass("loaderDispaly");

                jQuery("#create_session_note_popup").hide();
                Swal.fire(res.messages);
            },
            error: function(err){
                Swal.fire(response.messages);
            }
        });
    }

               // jQuery(document).ready(function(){
                function DisplayUpcomingEventDetails(selector){
                    var selected_event_id = jQuery(selector).attr('data-event');
                    var selected_clientid = jQuery(selector).data('clientid');
                    
                    if(selected_event_id){
                      jQuery(".loader-div .loaderOnload, .loader-div .dcsLoaderImg").show();;        
                      jQuery.ajax({
                        type: 'POST',
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "get_upcoming_event_details", event_id: selected_event_id, clientid:selected_clientid},
                        dataType: 'json',
                        success: function(response) {
                        // console.log(response.data);
                         jQuery(".loader-div .loaderOnload, .loader-div .dcsLoaderImg").hide();
                          var event_date_l = moment(response.data.start_Date+' '+response.data.start_Time).format('YYYY-MM-DD HH:mm:ss');
                          var event_date = moment.utc(event_date_l).local().format('D MMMM YYYY');
                          var start_Time = moment.utc(event_date_l).local().format('hh:mm a');     
                          
                          
                          var zoom_api_data = JSON.parse(response.data.zoom_api_data);
                          if(zoom_api_data.hasOwnProperty("hostRoomUrl") )    
                            var host_url = zoom_api_data.hostRoomUrl;
                          else
                            var host_url = '#';
                          
                         var custom_disable = "";
                        var end = moment.utc(response.data.start_datetime).local().format('YYYY-MM-DD HH:mm');
                        var start = moment(new Date()).local().format("YYYY-MM-DD HH:mm");
                        var diff = moment(end).unix() - moment(start).unix();   

                        //var current_date = moment(new Date()).local().format("YYYY-MM-DD HH:mm");
                        var ed = moment.utc(response.data.end_datetime).local().format('YYYY-MM-DD HH:mm');
                        var custom_disable = "";
                        if(start > ed || diff >= 300 ){
                          custom_disable = "pointer-events: none;opacity: 0.4;";
                        }
                        if(diff > 0){
                          diff = "Your session is taking place in "+moment.duration(diff, "seconds").humanize();
                        }else{
                          diff = "Your client session has already been started just before "+moment.duration(diff, "seconds").humanize()+" ago";
                        }
                        var message_diff = '';
                        if(start > ed){
                          diff = "Your client session has already ended";
                        }

                        var d_start = moment.utc(response.data.start_datetime).local().format('YYYY-MM-DD HH:mm');
                        var d_end = moment.utc(response.data.end_datetime).local().format('YYYY-MM-DD HH:mm');
                        var duration = moment(d_end).unix() - moment(d_start).unix();
                        duration = moment.duration(duration, "seconds");
                        // console.log("duration", duration);
                        var d_hours = duration._data.hours;
                        var d_minutes = duration._data.minutes;
                        duration = "";
                        if(d_hours > 0){
                          duration = (d_hours > 1)?d_hours+" hrs ":d_hours+"hrs ";
                        }
                        if(d_minutes > 0){
                          duration+= (d_minutes > 1)?d_minutes+" min":d_minutes+"min";
                        }
                          
                          if(response.status == 'done'){
                            jQuery("#custome_overlay").fadeOut(300);

                            Swal.fire({
                              title: response.data.summary,
                              //icon: 'info',
                              html: '<div class="main-event-popup"><div class="event-view-popup event-title"><img src="/wp-content/uploads/2023/02/003-user.svg"><h2>'+response.client_name+'</h2></div><div class="event-view-popup event-date"><img src="/wp-content/uploads/2023/02/calendar.svg"><h2>'+event_date+'</h2></div><div class="event-view-popup event-time"><img src="/wp-content/uploads/2023/02/clock.svg"><h2>'+start_Time+' ('+duration+')</h2></div><div class="event-view-popup event-repeat"><img src="/wp-content/uploads/2023/02/refresh-cw.svg"><h2>Repeat '+response.recurrence+'</h2></div><div class="call-session" style="'+custom_disable+'"><h3>'+diff+'</h3><div class="call-session-btn"><a href="'+host_url+'"><img src="/wp-content/uploads/2023/02/020-video-camera.svg">Go to call</a></div></div></div>',
                              showConfirmButton : false,
                              showCloseButton: true,
                              showCancelButton: false,
                              focusConfirm: false,
                              customClass: {
                                 popup: 'client_upcoming_event',
                              }
                            });
                          }
                        }
                      });
                    }
                }
               // });


    function DisplayClientNoteDetails(selector) {
        var selected_note_id = jQuery(selector).attr('data-client-popup');
        if(selected_note_id){
            // jQuery('.loaderOnload, .dcsLoaderImg').show();
            // jQuery('.loaderOnload, .dcsLoaderImg').css('z-index', '11');
            jQuery(".loader-div .dcsLoaderImg").show();
            jQuery(".loader-div").addClass("loaderDispaly");
            jQuery("#edit_session_note_popup").show();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: "get_session_note_details", note_edit_id: selected_note_id},
                dataType: 'json',
                success: function(response) {
                    // jQuery('.loaderOnload, .dcsLoaderImg').hide();
                    // jQuery('.loaderOnload, .dcsLoaderImg').css('z-index', '');
                    jQuery(".loader-div .dcsLoaderImg").hide();
                    jQuery(".loader-div").removeClass("loaderDispaly");
                    jQuery('#edit-session-title').val(response.data.session_title);
                    jQuery('#edit-session-note').val(response.data.session_note);
                    jQuery('#edit_client_detail_id').val(response.data.id);
                },
                error: function(response) {

                }

            });
        }
    }
jQuery(document).ready(function(){
    jQuery(document).on("click","#edit-session",function(e) {
        e.preventDefault();
        var id = jQuery("#edit_client_detail_id").val();
        var session_title = jQuery("#edit-session-title").val();
        var session_note = jQuery("#edit-session-note").val();

        var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/,
        error = 0,
        parameters;
        jQuery(".input-error").removeClass('input-error');
        
        if(!blank_reg_exp.test(jQuery("#edit-session-title").val())) {
            jQuery("#edit-session-title").addClass('input-error');
            error = 1;
        }
        if(!blank_reg_exp.test(jQuery("#edit-session-note").val())){
            jQuery("#edit-session-note").addClass('input-error');
            error = 1;
        }

        if(error == 1)
            return false;

        if(id != '' && session_title != ''){
            jQuery(".loader-div .dcsLoaderImg").show();
            jQuery(".loader-div").addClass("loaderDispaly");

            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: "edit_session_note", note_id: id, session_title: session_title, session_note: session_note},
                dataType: 'json',
                success: function(response) {
                    jQuery(".loader-div .dcsLoaderImg").hide();
                    jQuery(".loader-div").removeClass("loaderDispaly");
                    Swal.fire(response.message);
                    jQuery('.session_note_main').html(response.data);
                    jQuery("#edit_session_note_popup").hide();
                },
                error: function(response) {

                }
            });
        }
    });
})

jQuery(document).ready(function(){
    jQuery(document).on("click",".note-delete",function() {
        var note_id = jQuery(this).attr('data-client');

        if(note_id != ''){
            jQuery(".loader-div .dcsLoaderImg").show();
            jQuery(".loader-div").addClass("loaderDispaly");

            Swal.fire({
              title: '',
              text: "Are you sure. you want to delete this note!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                    jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {action: "delete_session_note", note_id: note_id},
                    dataType: 'json',
                        success: function(response) {
                            Swal.fire(response.message);
                            jQuery('.session_note_main').html(response.data);
                        },
                        error: function(response) {
                  
                        }
                  });
              }
            });

        }
    });
});


</script>
    <!-- therapist user detail start  -->
        <div class="user-detail-page" id= "user-detail-page-section">
            <div class="loader-div">
                <div class="dcsLoaderImg" style="display: none;">
                 <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
                 color: #ff7361;">
                 <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                   <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                       </path>
                     </svg>
             </div>
            </div>
            <div class="user-detail-inner">
            </div>
        </div>  

<!-- session note popup start-->
    <div id="create_session_note_popup" class="session_note_popup">
      <div class="session-note-inner">
        <form id="create_form_note_id" action="javascript:;" onsubmit="create_note_session()" name="create_note_name">
         <div id="session-container">
            <div class="popup-title">
               <h2>Session Notes</h2>
               <button class="close"><img src="/wp-content/uploads/2023/02/1544641784-1.svg"></button>
            </div>
            <div class="session-title">
               <label class="field-title">Session Title*
                  <input type="text" id="session-title" class="session-title" placeholder="Session Title" autocomplete="off">
               </label>
               <span class="error_msg"></span>
            </div>   
            <div class="session-area">
               <label class="field-title">Session Note*
                <textarea id="session-note" name="session-note" rows="4" cols="50"></textarea>
               </label>
               <span class="error_msg"></span>
            </div>
            <!-- <button class="btn" id="create-session">Submit</button> -->
            <input type="submit" class="btn" name="create-session" id="create-session" value="Submit">
         </div>
     </form>
      </div>

   </div>
 <!-- session note popup end-->  

 <!-- session note edit popup start-->
    <div id="edit_session_note_popup" class="session_note_popup">
      <div class="session-note-inner">
         <form id="edit_form_note_id" name="edit_form_note_name">
         <div id="session-container">
            <div class="popup-title">
               <h2>Edit Session Notes</h2>
               <button class="close"><img src="/wp-content/uploads/2023/02/1544641784-1.svg"></button>
            </div>
            <div class="session-title">
               <label class="field-title">Session Title*
                  <input type="text" id="edit-session-title" name="edit-session-title" class="session-title" placeholder="Session Title" autocomplete="off">
               </label>
               <span class="error_msg"></span>
            </div>   
            <div class="session-area">
               <label class="field-title">Session Note*
                <textarea id="edit-session-note" name="edit-session-note" rows="4" cols="50"></textarea>
               </label>
               <span class="error_msg"></span>
            </div>
            <button class="btn" id="edit-session">update</button>
            <input type="hidden" name="edit_client_detail_id" id="edit_client_detail_id">
         </div>
      </div>
   </div>
 <!-- session note edit popup end-->  


<!-- </body>

</html> -->

<?php

get_footer();

?>
<script>

  /**done typing js**/
  (function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);
/****/

    jQuery(document).ready(function($){
    jQuery(document).on("click",".client-white-columns",function() {
    jQuery(".user-detail-page").addClass("demo_class");
    jQuery('body').css('overflow', 'hidden');   
    jQuery(".loader-div .dcsLoaderImg").show();
    jQuery(".loader-div").addClass("loaderDispaly");

    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    // alert(timezone);
    var clientUserId = jQuery(this).data('id');
    jQuery.ajax({
              type:"POST",
              url:dcs_frontend_ajax_object.ajaxurl,
              data: {
                action: "client_details_popup",
                clientUserId : clientUserId,
                timezone:timezone
              },
              success: function (result) {
                jQuery(".loader-div .dcsLoaderImg").hide();
                jQuery(".loader-div").removeClass("loaderDispaly");
                $(".user-detail-inner").html(result);
                  },
                  error: function(err){
                      console.log(err);
                  }
            });
  });

  jQuery(document).on("click",".user-close-arrow",function() {
    jQuery(".user-detail-page").removeClass("demo_class");
    jQuery('body').css('overflow', 'auto');   
  });
  

  jQuery(document).on("click",".user-detail-text-image",function() {
    jQuery(".user-detail-page").removeClass("demo_class"); 
    jQuery('body').css('overflow', 'auto');   
  });

  /****/
  //client list search client input
//var pageClientSearch = 2;
jQuery('#clientSearchInput, #MobClientSearchInput').donetyping(function(){
  var searchVal = jQuery(this).val();
  jQuery(".dcsLoaderImg").show();

  jQuery.ajax({
          type:"POST",
          url:dcs_frontend_ajax_object.ajaxurl,
          data: {
            action: "clientlist_search_input_data",
            searchVal : searchVal,
            //page: pageClientSearch,
          },
          dataType:"JSON",
          success: function (results) {
            jQuery(".countClients").text(results.totalUsers);
            var total_pages = results.total_pages;
            //console.log(results.responsehtml);
            console.log("totalPage: "+results.total_pages);
            //jQuery(".loader-div .dcsLoaderImg").hide();
            //jQuery(".loader-div").removeClass("loaderDispaly");
            jQuery(".client-page-columns").html(results.responsehtml);
            jQuery(".clientListMore .load_clients_btn").attr('data-maxpclients', total_pages );
            jQuery(".clientListMore .load_clients_btn").attr('data-page', 1 );
            jQuery(".dcsLoaderImg").hide();
            if(searchVal == ""){
                jQuery('.clientListMore').show();
            }
            //jQuery('.clientListMore').hide();
            if(total_pages > 1){
             jQuery('.clientListMore').show();
            }else{
                jQuery('.clientListMore').hide();
            }
              },
              error: function(err){
                  console.log(err);
              }
        });

});

    

    // jQuery(document).on("submit",".session_note_popup #create-session",function() {
   


      
    // });



    jQuery(document).on("click",".session_note_popup",function() {
        jQuery("#user-detail-page-section").addClass("demo_class");
    });


 
});

jQuery(document).ready(function(){

  jQuery(document).on("click",".search-box",function() {
    jQuery(".searchbox-input").toggleClass("searchbox-output");
    });

});


function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}

</script>
