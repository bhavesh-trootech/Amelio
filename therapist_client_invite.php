<?php /* Template Name: Therapist clients invite */

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
<!-- <link href="<?php //echo get_stylesheet_directory_uri(); ?>/css/select2.min.css" rel="stylesheet" /> -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css' media='all' />
<link rel='stylesheet' href='https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css' media='all' />
<link rel='stylesheet' id='dashicons-css' href='<?php echo home_url(); ?>/wp-includes/css/dashicons.min.css?ver=6.1.1' media='all' />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


    <div class="dashboard-main">

        <!-- amelio-sidebar start -->

        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>

        <?php include get_stylesheet_directory().'/inc/notification-section.php'; ?>

        
        <!-- amelio-sidebar end -->

        <!-- clients invite page start -->

        <div class="amelio-new-client-page">
            <div class="new-client-link">
                <a href="/clients/"><img src="<?=get_stylesheet_directory_uri()?>/image/arrow-right.svg" alt="">Back to Clients</a>

                <!-- <h5>Back to Clients</h5> -->
            </div>

            <div class="new-client-heading">
                <h1><?php echo get_field("invite_new_clients_text"); ?></h1>
            </div>

            <div class="new-client-invite">
                <div class="client-invite-details">
                    <h2><?php echo get_field("invite_via_email_text"); ?></h2>
                    <?php echo get_field("invite_description"); ?>

                    <div class="formWrap">
                    <form class="inviteClientForm" id="inviteClientForm">
                        <input id="invitationEmail" type="email" placeholder="Add an Email Address....">
                        <input id="therapistUserId" value="<?php echo get_current_user_id(); ?>" type="hidden">
                        <button id="sendInvitationBtn" class="sendInvitationBtn">Send invitation</button>
                    </form>
                    <div class="dcsLoaderImg" style="display: none;">
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
                         color: #ff7361;">
                         <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                           <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                               </path>
                        </svg>
                    </div>
                    <span class="error" id="emailError"></span>
                    <div class="display-message" style="display:none"></div>
                    </div>

                </div>
            </div>

    
            <div class="resentInviteLoader">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
                 color: #ff7361;">
                 <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                   <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                       </path>
                </svg>
            </div>

<div class="clientListMain">
 <div class="clientListInner">  

<?php 
global $wpdb;
$currentUserId = get_current_user_id();
$invitedusersTable = 'invitedusers'; 
$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $invitedusersTable WHERE therapistUserId='".$currentUserId."' AND status = 'invited'");
if($rowcount == 0){ 
    $invitationcountcls = 'style="display: none;"';
    } elseif($rowcount > 0){
    $invitationcountcls = 'style="display: block;"';
    }
?> 
<div class="totalInvitesSection" <?php echo $invitationcountcls; ?>>
<h3 class="preInvitedClient">Previously invited clients</h3>
<h4 class="countInvitedClient"><span><?php echo $rowcount; ?></span> Invites sent</h4>
</div>


        <table>
        <thead>
          <tr>
            <th class="all">Name <img src="/wp-content/uploads/2023/02/arrow-narrow-down.svg"></th>
            <th class="tablet-p tablet-l desktop">Email Address <img src="/wp-content/uploads/2023/02/arrow-narrow-down.svg"></th>
            <th class="tablet-p tablet-l desktop">Invite Method</th>
            <th class="tablet-p tablet-l desktop">Signup <img src="/wp-content/uploads/2023/02/arrow-narrow-down.svg"></th>
            <th class="min-tablet">Date Invited <img src="/wp-content/uploads/2023/02/arrow-narrow-down.svg"></th>
            <th class="min-tablet">Action</th>
          </tr>
        </thead>
        <tbody>
   
  <tr>
    <td class="tabletd clientName"></td>
    <td class="tabletd clientEmail"></td>
    <td class="tabletd clientMethod"></td>
    <td class="tabletd clientSignUp"><span><span></td>
    <td class="tabletd clientdate"></td>
    <td class="tabletd clientaction"></td>
  </tr>
  </tbody>
</table>

        <!-- <div class="pagination-custom"> -->
<?php
    // $total_recs = $wpdb->get_var( "select COUNT(*) from $invitedusersTable ");
    
    //   //  $total_recs = mysql_num_rows($res); //count number of records
    //     $total_pages = ceil($total_recs / $rec_page); 
 
    //     echo "<a href='?paging=1'>". '|< '. "</a> "; // For 1st page 
 
    //      for ($i=1; $i<=$total_pages; $i++) 
    //      { 
    //       if ($_GET['paging'] == $i) { $cls = "active"; } else { $cls = ""; }
    //           echo "<a class='".$cls."' href='?paging=".$i."'>". $i. "</a> "; 
    //      }; 
    //     echo "<a href='?paging=$total_pages'>". '>| '."</a> "; // For last page
?>
<!-- </div> -->


 </div>  
</div>

        </div>
       
        <!-- clients invite page end -->
    </div>

    



<!-- </body>

</html> -->


<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready( function () {

/*  setTimeout(function() {
 jQuery('#DataTables_Table_0_length select').select2({
         minimumResultsForSearch: -1,
         dropdownParent: jQuery('#DataTables_Table_0_length')
      });
      jQuery('#DataTables_Table_0_length select').on('select2:open', function (e) {
        const evt = "scroll.select2";
        jQuery(e.target).parents().off(evt);
        jQuery(window).off(evt);
      });

}, 100);*/

        var hostUrl = window.location.protocol + "//" + window.location.host;

      if (jQuery(window).width() > 991)
    {
        jQuery('.clientListMain table').DataTable({
            pagingType: 'full_numbers',
            language: {
                paginate: {
                  next: '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="black"/></svg>',
                  previous: '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.06 12L11 11.06L7.94667 8L11 4.94L10.06 4L6.06 8L10.06 12Z" fill="black"/></svg>',
                  "first": '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.7265 12L12.6665 11.06L9.61317 8L12.6665 4.94L11.7265 4L7.7265 8L11.7265 12Z" fill="#333333"/><path d="M7.33344 12L8.27344 11.06L5.2201 8L8.27344 4.94L7.33344 4L3.33344 8L7.33344 12Z" fill="#333333"/></svg>',
                  "last": '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.2735 4L3.3335 4.94L6.38683 8L3.3335 11.06L4.2735 12L8.2735 8L4.2735 4Z" fill="black"/><path d="M8.66656 4L7.72656 4.94L10.7799 8L7.72656 11.06L8.66656 12L12.6666 8L8.66656 4Z" fill="black"/></svg>'
                }
            },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': hostUrl+'/invitedusers_ajaxfile.php'
            },
            'columns': [
                { class: 'tabletd clientName', data: 'clientNames' },
                { class: 'tabletd clientEmail', data: 'invitationEmailId' },
                { class: 'tabletd clientMethod', data: 'inviteMethod' },
                { class: 'tabletd clientSignUp', data: 'status' },
                { class: 'tabletd clientdate', data: 'date' },
                { class: 'tabletd clientaction', data: 'action' },
            ],
            
        });
    }else{
        console.log("uytu");
         jQuery('.clientListMain table').dataTable().fnDestroy();

         jQuery('.clientListMain table').DataTable({
            pagingType: 'full_numbers',
            language: {
                paginate: {
                  next: '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="black"/></svg>',
                  previous: '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.06 12L11 11.06L7.94667 8L11 4.94L10.06 4L6.06 8L10.06 12Z" fill="black"/></svg>',
                  "first": '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.7265 12L12.6665 11.06L9.61317 8L12.6665 4.94L11.7265 4L7.7265 8L11.7265 12Z" fill="#333333"/><path d="M7.33344 12L8.27344 11.06L5.2201 8L8.27344 4.94L7.33344 4L3.33344 8L7.33344 12Z" fill="#333333"/></svg>',
                  "last": '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.2735 4L3.3335 4.94L6.38683 8L3.3335 11.06L4.2735 12L8.2735 8L4.2735 4Z" fill="black"/><path d="M8.66656 4L7.72656 4.94L10.7799 8L7.72656 11.06L8.66656 12L12.6666 8L8.66656 4Z" fill="black"/></svg>'
                }
            },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': hostUrl+'/invitedusers_ajaxfile.php'
            },
            'columns': [
                { class: 'tabletd clientName', data: 'clientNames' },
                { class: 'tabletd clientEmail', data: 'invitationEmailId' },
                { class: 'tabletd clientMethod', data: 'inviteMethod' },
                { class: 'tabletd clientSignUp', data: 'status' },
                { class: 'tabletd clientdate', data: 'date' },
                { class: 'tabletd clientaction', data: 'action' },
            ],
            order: [ [ 0, "asc" ] ],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            
        });

    }

    });
    
</script>
<?php

get_footer();

?>
