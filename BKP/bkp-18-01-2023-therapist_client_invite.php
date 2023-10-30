<?php /* Template Name: Therapist clients invite */

get_header();

?>

    <div class="dashboard-main">

        <!-- amelio-sidebar start -->

        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>

        
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


            <div class="clientListMain">
             <div class="clientListInner">   

                    <table id='empTable' class='display dataTable'>
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Invite Method</th>
                            <th>Signup</th>
                            <th>Date Invited</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        
                    </table>
             
             </div>  
            </div>

        </div>
       
        <!-- clients invite page end -->
    </div>

    



<!-- </body>

</html> -->
<style type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript">
    jQuery(document).ready( function () {
        jQuery('.clientListMain table').DataTable({
            pagingType: 'full_numbers',
            // language: {
            //     paginate: {
            //       next: '<i class="fa fa-arrow-right">',
            //       previous: '<i class="fa fa-arrow-left">'  
            //     }
            // }
        });
    });
    
</script> -->

<script>
jQuery(document).ready(function(){
    jQuery('#empTable').DataTable({
        pagingType: 'full_numbers',
        language: {
            paginate: {
              next: '<i class="fa fa-chevron-right">',
              previous: '<i class="fa fa-chevron-left">'
            }
        },
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'https://amelio.stagingtraction.com/invitedusers_ajaxfile.php'
        },
        'columns': [
            { class: 'tabletd clientName', data: 'invitedusersid' },
            { class: 'tabletd clientEmail', data: 'invitationEmailId' },
            { class: 'tabletd clientMethod', data: 'inviteMethod' },
            { class: 'tabletd clientSignUp', data: 'status' },
            { class: 'tabletd clientdate', data: 'date' },
            { class: 'tabletd clientaction', data: 'action' },
        ]
    });
});
</script>
<style type="text/css">
    #empTable thead th.tabletd.clientaction {pointer-events: none;}
</style>
<?php

get_footer();

?>
