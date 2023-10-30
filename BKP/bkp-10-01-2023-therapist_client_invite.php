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
 
 <?php
               $rec_page=5; // Number of records to be displayed on a page
  
               if (isset($_GET["paging"]))
               {
                    $paging = $_GET["paging"]; 
               } 
               else
               { 
                       $paging=1;  
               }; 
  
               $start = ($paging-1) * $rec_page; 
         
         
         global $wpdb;   
         $invitedusersTable = 'invitedusers'; 
      $resultRows = $wpdb->get_results( "SELECT * FROM $invitedusersTable LIMIT $start, $rec_page");

      $customer_count = $wpdb->get_var("SELECT COUNT(*) FROM $invitedusersTable");
    if($customer_count > 0) : ?>
        <table>
          <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Invite Method</th>
            <th>Signup</th>
            <th>Date Invited</th>
            <th>Action</th>
          </tr>
       
   <?php foreach( $resultRows as $rowdata ) {
   $invitedusersid = $rowdata->invitedusersid;
   $invitationEmailId = $rowdata->invitationEmailId;
   $therapistUserId = $rowdata->therapistUserId;
   $status = $rowdata->status;
   $date = $rowdata->date;

   $user = get_user_by( 'email', $invitationEmailId );
   $userId = $user->ID;
   $userNameTitle = get_user_meta( $userId, 'first_name' , true );
   $userLastNameTitle = get_user_meta( $userId, 'last_name' , true );
   $nameArr = explode("@",$invitationEmailId);
   if(!empty($userName)){
    $nameClient = $userNameTitle." ".$userLastNameTitle;
   }else{
     $nameClient = $nameArr[0];
   }

   ?>
  <tr>
    <td class="tabletd clientName"><?php echo $nameClient; ?></td>
    <td class="tabletd clientEmail"><?php echo $invitationEmailId; ?></td>
    <td class="tabletd clientMethod">Referal Code</td>
    <td class="tabletd clientStatus"><?php echo $status; ?></td>
    <td class="tabletd clientStatus">22 September 2022</td>
    <td class="tabletd clientStatus"><span class="threedotsDropdown"></span></td>
  </tr>
  <?php } ?>
  
</table>
   <?php endif; ?>

        <div class="pagination-custom">
<?php
    $total_recs = $wpdb->get_var( "select COUNT(*) from $invitedusersTable ");
    
      //  $total_recs = mysql_num_rows($res); //count number of records
        $total_pages = ceil($total_recs / $rec_page); 
 
        echo "<a href='?paging=1'>". '|< '. "</a> "; // For 1st page 
 
         for ($i=1; $i<=$total_pages; $i++) 
         { 
          if ($_GET['paging'] == $i) { $cls = "active"; } else { $cls = ""; }
              echo "<a class='".$cls."' href='?paging=".$i."'>". $i. "</a> "; 
         }; 
        echo "<a href='?paging=$total_pages'>". '>| '."</a> "; // For last page
?>
</div>


 </div>  
</div>

        </div>
       
        <!-- clients invite page end -->
    </div>

    



<!-- </body>

</html> -->

<?php

get_footer();

?>
