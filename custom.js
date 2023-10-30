
jQuery(".loaderOnload").show();
jQuery(".loaderOnload .dcsLoaderImg").show();
jQuery(window).on('load', function() {
//  jQuery(".loaderOnload").hide();
jQuery(".loaderOnload").show(0).delay(5000).hide(0);
// jQuery(".safari.mac-os .amelio-client-page, .safari.mac-os .amelio-welcome, .safari.mac-os .buy-lead-main , .safari.mac-os .amelio-new-client-page").css({marginLeft:'auto'});
 jQuery(".loaderOnload .dcsLoaderImg").css('display', 'none');
 });


//  jQuery(".header-sec .elementor-menu-toggle").click(function(){
//     // alert("click");
//     jQuery('body').css('overflow', 'hidden');
//   });
//   jQuery(".header-sec i.elementor-menu-toggle__icon--close.eicon-close").click(function(){
//     alert("remove it");
//     jQuery('body').css('overflow', 'visible');
    

//   }); 

jQuery(document).on("click",".header-sec .elementor-menu-toggle.elementor-active",function() {
  console.log("open");
	jQuery('body').css('overflow', 'hidden');
});

jQuery(document).on("click",".header-sec .elementor-menu-toggle .elementor-menu-toggle__icon--close",function() {
	console.log("close");
  jQuery('body').css('overflow', 'visible');
});

jQuery(document).ready(function(){

/**calender page event display**/
/*  jQuery(document).on("click",".fc-content-col .fc-event-container section",function(e) {
    e.preventDefault();
    console.log("testClick");
    jQuery(".fc-content-col .fc-event-container section").removeClass("activeEvent");
    jQuery(this).addClass("activeEvent");
  });*/
  /****/

  if (jQuery(".userAlreadyExistMsg").hasClass("expireLinksec")) {
    jQuery(".client-signup-section").addClass("fullviewPort");
  }

  jQuery(document).on("click",".user-detail-button-2",function(e) {
    e.preventDefault();
    jQuery("#create_session_note_popup").show();
    // jQuery(".session_note_popup").show();
    
  });

  jQuery(document).on("click","#create_session_note_popup button.close",function(e) {
      e.preventDefault();
      // jQuery(".session_note_popup").hide();
      jQuery("#create_session_note_popup").hide();
  });
/****/
// Edit Popup Start
  jQuery(document).on("click",".edit.edit-detail-button",function(e) {
    e.preventDefault();
    jQuery("#edit_session_note_popup").show();
  });

  jQuery(document).on("click","#edit_session_note_popup button.close",function(e) {
      e.preventDefault();
      jQuery("#edit_session_note_popup").hide();
  });
// Edit Popup End





  jQuery(".title-btn a, .notification a").click(function(){
  jQuery(".notification-section").toggleClass("active");
  });

 jQuery(document).mouseup(function (e) {
  jQuery('body').css('overflow', 'auto');
  var containerNoti = jQuery(".notification-section, .title-btn, .notification");
  var containerNotification = jQuery(".notification-section");

  if (!containerNoti.is(e.target) 
      && containerNoti.has(e.target).length === 0)
  {
    containerNotification.removeClass("active");
  }
});

 jQuery(document).mouseup(function (e) {
  var threeDotsContainerNoti = jQuery(".threedotsDropdown, .actionList");
  var actionContainerUl = jQuery(".actionList");

  if (!threeDotsContainerNoti.is(e.target) 
      && threeDotsContainerNoti.has(e.target).length === 0)
  {
    actionContainerUl.slideUp();
    jQuery(".threedotsDropdown").removeClass("triggerActionsPop");
  }
});

/****/
  jQuery(document).mouseup(function (e) {
    jQuery('body').css('overflow', 'auto');
  var userdetailPop = jQuery(".user-detail-page");
  var userdetailPopNew = jQuery(".demo_class");

  if (!userdetailPop.is(e.target) 
      && userdetailPop.has(e.target).length === 0)
  {
    userdetailPop.removeClass("demo_class");
    // jQuery('.amelio-client-page').css('overflow', 'unset');
  }
});
/****/
//calender event outer click
/*jQuery(document).mouseup(function (e) {
  var eventContainerBox = jQuery(".fc-content-col .fc-event-container section");

  if (!eventContainerBox.is(e.target) 
      && eventContainerBox.has(e.target).length === 0)
  {
    jQuery(".fc-content-col .fc-event-container section").removeClass("activeEvent");
  }
});*/
/***/

// redirect to careers page from about page 
if(location.hash == "#openvacancies"){
   
      jQuery('html, body').animate({
        scrollTop: jQuery(".Open-opportunities-sec").offset().top - 250
      }, 2000);
}
 

  //faq Page
   jQuery(".parentFaqsCol2 .elementor-accordion-item .elementor-tab-title").click(function(){
     if (!jQuery(this).hasClass('elementor-active')){
    jQuery(".parentFaqsCol1 .elementor-accordion-item .elementor-tab-title").removeClass("elementor-active");
    jQuery(".parentFaqsCol1 .elementor-accordion-item .elementor-tab-content").removeClass("elementor-active");
    jQuery(".parentFaqsCol1 .elementor-accordion-item .elementor-tab-content").slideUp();
    }
  });

 jQuery(".parentFaqsCol1 .elementor-accordion-item .elementor-tab-title").click(function(){
  if (!jQuery(this).hasClass('elementor-active')){
    jQuery(".parentFaqsCol2 .elementor-accordion-item .elementor-tab-title").removeClass("elementor-active");
    jQuery(".parentFaqsCol2 .elementor-accordion-item .elementor-tab-content").removeClass("elementor-active");
    jQuery(".parentFaqsCol2 .elementor-accordion-item .elementor-tab-content").slideUp();
  }
  });

 jQuery(".parentFaqsCol3 .elementor-accordion-item .elementor-tab-title").click(function(){
     if (!jQuery(this).hasClass('elementor-active')){
    jQuery(".parentFaqsCol4 .elementor-accordion-item .elementor-tab-title").removeClass("elementor-active");
    jQuery(".parentFaqsCol4 .elementor-accordion-item .elementor-tab-content").removeClass("elementor-active");
    jQuery(".parentFaqsCol4 .elementor-accordion-item .elementor-tab-content").slideUp();
    }
  });

 jQuery(".parentFaqsCol4 .elementor-accordion-item .elementor-tab-title").click(function(){
  if (!jQuery(this).hasClass('elementor-active')){
    jQuery(".parentFaqsCol3 .elementor-accordion-item .elementor-tab-title").removeClass("elementor-active");
    jQuery(".parentFaqsCol3 .elementor-accordion-item .elementor-tab-content").removeClass("elementor-active");
    jQuery(".parentFaqsCol3 .elementor-accordion-item .elementor-tab-content").slideUp();
  }
  });
    
    jQuery(document).on("click",".click_monthly_btn",function() {
            
            jQuery(".yearly_class").css("display", "none");
            jQuery(".monthly_class").css("display", "block");
          });


          jQuery(document).on("click",".click_yearly_btn",function() {
           
            jQuery(".yearly_class").css("display", "block");
            jQuery(".monthly_class").css("display", "none");
          });

          jQuery(".click_yearly_btn a").click(function(){
            jQuery(this).css("background-color", "#165342");
            jQuery(".click_monthly_btn a").css("background-color", "#E2DFD6");
            jQuery(".click_monthly_btn a").css("color", "#18181899");
            jQuery(".click_yearly_btn a").css("color", "#ffffff");
           
          });

          jQuery(".click_monthly_btn a").click(function(){
            jQuery(this).css("background-color", "#165342");
            jQuery(".click_yearly_btn a").css("background-color", "#E2DFD6");
            jQuery(".click_yearly_btn a").css("color", "#18181899");
            jQuery(".click_monthly_btn a").css("color", "#ffffff");
          });
          
          // about page slider
          
           jQuery('.about-press-slider .elementor-column-gap-no').slick({
 	
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
		centerMode:true, responsive: [
    {
      breakpoint: 1025,
      settings: {       
        slidesToShow: 3
      }
    },
     {
      breakpoint: 769,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 481,
      settings: {
        slidesToShow: 1
      }
    }
  ]
    });
          
     

          // about page slider btn

	    jQuery('.prev').click(function (e) {
        jQuery('.about-press-slider .elementor-column-gap-no').slick('slickPrev');
    });
    jQuery('.next').click(function (e) {
        jQuery('.about-press-slider .elementor-column-gap-no').slick('slickNext');
    });


   
     
 
});


// hamburger-menu

const hamburger = document.querySelector(".hamburger-menu");
const menu = document.querySelector(".mobile");
const mainmenu = document.querySelector(".dashboard-main");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    menu.classList.toggle("active");
    mainmenu.classList.toggle("active-height");
})


// notification-section on click

const notification_btn = document.querySelector(".title-btn a");
const noti_section = document.querySelector(".notification-section");



// notification_btn.addEventListener("click", () => {
//   notification_btn.classList.toggle("active");
//   noti_section.classList.toggle("active");

// })




