jQuery(document).ready(function(){

jQuery(".filterBox").click(function(){
jQuery('.filterClientList').slideToggle();
});

jQuery("li.filterName.filterInnerLi").click(function(){
  jQuery("li.filterDate.filterInnerLi").find('ul').slideUp();
  jQuery(this).find('ul').slideToggle();
});

jQuery("li.filterDate.filterInnerLi").click(function(){
  jQuery("li.filterName.filterInnerLi").find('ul').slideUp();
  jQuery(this).find('ul').slideToggle();
});
/****/

//sign-up-as-a-professional go back button
jQuery('#professionSignUpGoBackBtn a').on('click',function(e){
        e.preventDefault();

        var referralUrl = jQuery("div#content").data('referralurl');

            jQuery.ajax({
              type:"POST",
              url:dcs_frontend_ajax_object.ajaxurl,
              data: {
                action: "profession_signup_goback",
                referralUrl : referralUrl
              },
              dataType:"JSON",
              success: function(results){
                console.log(results.type);
                if(results.type == 'success'){
                  window.location.href = results.redirectUrl;
                }
              },
              error: function(results) {

              }
            });
        
  });

/****/
  function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) {
            return false;
          }else{
            return true;
          }
        }
/****/
  jQuery('#sendInvitationBtn').on('click',function(e){
        e.preventDefault();

        var invitationEmail = jQuery('#invitationEmail').val();
        var therapistUserId = jQuery('#therapistUserId').val();

        var validationErr=false;
         if(invitationEmail == ""){
          //jQuery( '#inviteClientForm' ).attr('style', 'border: 0.06944444444444445vw solid red !important');
          jQuery('#emailError').text("Please enter client email.");
          validationErr =true;
        } else if(IsEmail(invitationEmail)==false){
          //jQuery( '#inviteClientForm' ).attr('style', 'border: 0.06944444444444445vw solid red !important');
          jQuery('#emailError').text("Please enter a valid client email.");
          validationErr =true;
        } else{
          //jQuery( '#inviteClientForm' ).attr('style', 'border: 0.06944444444444445vw solid rgba(24, 24, 24, 0.3) !important');
          jQuery('#emailError').text("");
          validationErr==false;
        }

        if(validationErr==false){
         jQuery(".dcsLoaderImg").show();

            jQuery.ajax({
              type:"POST",
              url:dcs_frontend_ajax_object.ajaxurl,
              data: {
                action: "invited_user_front_end",
                invitationEmail : invitationEmail,
                therapistUserId : therapistUserId
              },
              dataType:"JSON",
              success: function(results){
                //console.log(results.msg);
                //console.log(results.type);
                jQuery('.display-message').html(results.msg).show();
                jQuery(".dcsLoaderImg").hide();
                setTimeout(function() { jQuery(".display-message").hide(); }, 5000);

                if(results.type == 'success'){
                  jQuery("input#invitationEmail").val('');
                  //location.reload();
                  //window.location.href = redirectUrl;
                  if(results.invitedCount > 0){
                     jQuery('.totalInvitesSection').show();
                  }
                  jQuery('.countInvitedClient span').text(results.invitedCount);

                  jQuery('.clientListMain table').DataTable().ajax.reload();

                }
              },
              error: function(results) {

              }
            });
        }

  });
  /****/
//delete client
    jQuery( "body" ).on( "click", "span.threedotsDropdown", function(e) {
      if(jQuery(this).hasClass("triggerActionsPop")){
       jQuery(this).parents("td.tabletd.clientaction").find("ul.actionList").slideUp();
       jQuery(".threedotsDropdown").removeClass("triggerActionsPop");
      } else{
    jQuery("ul.actionList").slideUp();
    jQuery(".threedotsDropdown").removeClass("triggerActionsPop");
    jQuery(this).parents("td.tabletd.clientaction").find("ul.actionList").slideToggle();
    jQuery(this).addClass("triggerActionsPop");
    }
});

jQuery( "body" ).on( "click", ".dtr-data span.threedotsDropdown", function(e) {
     jQuery(this).parents("li.tabletd.clientaction").find("ul.actionList").slideToggle();
});



/***/
  jQuery( "body" ).on( "click", "#deleteClient", function(e) {
        e.preventDefault();

        var invitedClientId = jQuery(this).parents("tr").data("id");
        var dataStatus = jQuery(this).parents("tr").data("status");
        var invitationEmail = jQuery(this).data('clientemail');
        var therapistUserId = jQuery(this).data('therapistuserid');

        Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Ok',
        denyButtonText: `Don't delete`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          if(invitationEmail!= ""){
         jQuery(".resentInviteLoader").show();

            jQuery.ajax({
              type:"POST",
              url:dcs_frontend_ajax_object.ajaxurl,
              data: {
                action: "delete_invited_user_front_end",
                invitationEmail : invitationEmail,
                therapistUserId : therapistUserId,
                dataStatus : dataStatus
              },
              dataType:"JSON",
              success: function(results){
                jQuery(".resentInviteLoader").hide();
                console.log(results);
                if(results.type == 'success'){

                  jQuery('[data-clientemail="'+invitationEmail+'"]').parents("tr").remove();
                  Swal.fire('Client deleted successfully!', '', 'success');
                  jQuery('#calendar').fullCalendar('refetchEvents');
                  jQuery('.countInvitedClient span').text(results.invitedCount);
                  
                  if(results.invitedCount == 0){
                     jQuery('.totalInvitesSection').hide();
                  }
                  
                  jQuery('.clientListMain table').DataTable().ajax.reload();
                  //location.reload();
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                  });
                }
              },
              error: function(results) {
              }
            });
        }

        } 
      });
        
  });
 /****/ 
//resent invitation
jQuery( "body" ).on( "click", "#resentInvitation", function(e) {
        e.preventDefault();

        var invitationEmail = jQuery(this).data('clientemail');
        var therapistUserId = jQuery(this).data('therapistuserid');
        var userEmlName = invitationEmail.substring(0, invitationEmail.indexOf("@"));
        const userEml = userEmlName.replace(/\./g,'_');

       if(invitationEmail != ""){
        //alert(invitationEmail);
         jQuery(".resentInviteLoader").show();

            jQuery.ajax({
              type:"POST",
              url:dcs_frontend_ajax_object.ajaxurl,
              data: {
                action: "resent_invitation_user_front_end",
                invitationEmail : invitationEmail,
                therapistUserId : therapistUserId
              },
              dataType:"JSON",
              success: function(results){
               var userId = results.userId;

                if(results.type == 'success'){
                  jQuery(".resentInviteLoader").hide();
                  jQuery("ul#dataRes_"+userEml).slideUp();
                  jQuery("ul#dataRes_"+userEml).parents("td.tabletd.clientaction").find(".threedotsDropdown").removeClass("triggerActionsPop");
                  //window.location.href = redirectUrl;

                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your invitation email has been sent!!',
                    showConfirmButton: false,
                    timer: 3000
                  });

                }
              },
              error: function(results) {

              }
            });
        }

  });
 /****/

//client list page load more Ajax script
var pageCurent = jQuery(".clientListMore .load_clients_btn").data('page');
var pageClient = pageCurent+1;
jQuery(function($) {
    $('body').on('click', '.load_clients_btn', function() {
      var clientPage = jQuery(this).attr("data-page");
      var clientMaxPage = jQuery(this).attr("data-maxpclients");
      if(clientPage == 1){
        pageClient = 2;
      }

      if( jQuery( window ).width() > 767 ) {
        var searchVal = jQuery('#clientSearchInput').val();
      }else{
        var searchVal = jQuery('#MobClientSearchInput').val();
      }

      var pageCurent = jQuery(".clientListMore .load_clients_btn").data('page');
      //var selectedFilterVal = jQuery('.selectedActive').data('selected');

      jQuery(".dcsLoaderImg").show();
        var data = {
            'action': 'load_clients_user_by_ajax',
            'page': pageClient,
            'security': clientsData.security,
            'searchVal' : searchVal,
            //'selectedFilterVal' : selectedFilterVal,
        };

       var maxp = $(".load_clients_btn").data('maxpclients');
        $.post(clientsData.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
              jQuery(".dcsLoaderImg").hide();
              console.log("clientMaxPageR:"+ clientMaxPage);
              console.log("pageClientR:"+ pageClient);
                $('.client-page-columns').append(response);
                if(clientMaxPage == pageClient)  {
                  $('.clientListMore').hide();
               }

               jQuery(".clientListMore .load_clients_btn").attr('data-page', pageClient );
                pageClient++;
            } 
        });
    });
});
/****/
//filter by name asending desending
jQuery('body').on('click', '.clickNameFilter', function() {
      var selectedFilter = jQuery(this).data('selected');
      jQuery(".dcsLoaderNotFoundRec").show();

      jQuery(".clickNameFilter").removeClass('selectedActive');
      jQuery(this).addClass('selectedActive');

       jQuery.ajax({
          type:"POST",
          url:dcs_frontend_ajax_object.ajaxurl,
          data: {
            action: "filter_client_data_by_name",
            selectedFilter : selectedFilter,
          },
          success: function (result) {
          location.reload();
          setTimeout(function() {
          jQuery(".dcsLoaderNotFoundRec").hide();
          }, 1000);
              },
              error: function(err){
                  console.log(err);
              }
        });

    });
/****/
//client list filter by date ASC DESC
jQuery('body').on('click', '.clickDateFilter', function() {
      var selectedFilter = jQuery(this).data('selected');
      jQuery(".dcsLoaderNotFoundRec").show();

      jQuery(".clickDateFilter").removeClass('selectedActive');
      jQuery(this).addClass('selectedActive');

       jQuery.ajax({
          type:"POST",
          url:dcs_frontend_ajax_object.ajaxurl,
          data: {
            action: "filter_client_data_by_date",
            selectedFilter : selectedFilter,
          },
          success: function (result) {
          location.reload();
          setTimeout(function() {
          jQuery(".dcsLoaderNotFoundRec").hide();
          }, 1000);
              },
              error: function(err){
                  console.log(err);
              }
        });

    });

 /****/

});