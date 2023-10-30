<?php
/* Template Name: Therapist buy leads */

get_header();
 require 'stripe/Stripe.php';

 $options         = get_option('woocommerce_stripe_settings');
 

 $testmode=$options['testmode'];
 if($testmode == 'yes'){
    $publishable_key    = $options['test_publishable_key'];
    $secret_key         = $options['test_secret_key'];

 }
 else{
    $publishable_key    = $options['publishable_key'];
    $secret_key         = $options['secret_key'];
 }




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

<style>
    .error {color: red;}
    .dcsLoaderImg{display: none;}

/*************************/
/* Slider specific rules */
/*************************/

.relationship-status-slider{
    position: relative !important;
    height: 0;
}
#relationship-status-slider {
  -webkit-appearance: none;
  width: 100%;
}
#relationship-status-slider:focus {
  outline: none;
}
  
    #relationship-status-slider::-webkit-slider-runnable-track {
        width: 100%;
        height: 9px !important;
        cursor: pointer;
        background: linear-gradient(90deg, #165342 var(--range-progress), rgba(24, 24, 24, 0.12) var(--range-progress)) !important;
      } 


#relationship-status-slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  cursor: pointer;
  height: 43px;
  width: 43px;
  transform: translateY(calc(-50% + 10px));
  background-image: url('/wp-content/uploads/2023/02/Group-6789.svg');
  -webkit-background-size: 102%;
  -webkit-background-repeat: no-repeat;
  border: 1px solid #165342;
   border-radius: 50%; 
   background-color: #165342;
}
#relationship-status-slider::-webkit-slider-thumb:after {
  content: "";
  width: 2px;
  height: 2px;
  background: transparent;
  display: block;
  position: absolute;
  background-color: #165342;
}

input[type="range"]::-webkit-slider-runnable-track {
  box-shadow: unset;
}

#tooltip {
  position: absolute;
  top: -2.25rem;
  font-size: 0;
  display: none;

}
#tooltip span {
  position: absolute;
  text-align: center;
  display: block;
  line-height: 1;
  padding: 0.125rem 0.25rem;
  color: #fff;
  border-radius: 0.125rem;
  background: #165342;
  font-size: 1.25rem;
  left: 50%;
  transform: translate(-50%, 0);
}
#tooltip span:before {
  position: absolute;
  content: "";
  left: 50%;
  bottom: -8px;
  transform: translateX(-50%);
  width: 0;
  height: 0;
  border: 4px solid transparent;
  border-top-color: #165342;
}

</style>
<div class="dashboard-main">
      <!-- amelio-sidebar start -->
    <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>
    <?php include get_stylesheet_directory().'/inc/notification-section.php'; ?>
        <!-- amelio-sidebar end -->
<!-- amelio-buy-leads -->
<section class="buy-lead-main" >
    <div class="buy-leads-purchase" style="display: none;">
        <!-- <div class="back"><span id="backtoLead" class="backtoLead">Back to Leads</span></div> -->
        <div class="new-client-link">
                <a href="/therapist-buy-leads/"><img src="/wp-content/themes/astra-child/image/arrow-left.svg" alt="">Back to Leads</a>
                <!-- <h5>Back to Clients</h5> -->
        </div>
        <div class="review-leads-main">
            <div class="review-leads-left">
                <h2>Review & Pay</h2>
                <h3>Your Total</h3>
                <div class="review-leads-left-content leadsandprice">
                    <p><span>1</span> Leads</p>
                    <h6>£<span>2.00</span></h6>
                </div>
            </div>
            <!-- <div class="review-leads-section">
                <div class="leads-review">
                </div>
            </div> -->
            <div class="main-div review-heading">
                <h3>Pay by card</h3>
                <div class="leads-buy">
                    <div class="login-form-box-3">
                        <div class="form-wrapper"> 
                            <form action="" method="post" name="cardpayment" id="payment-form">
                                <?php 
                                if($_GET['id']!=""){
                                ?>
                                <div class="form-group">
                                    <div class="payment-success">Thanks for your payment. <br/> Your Transaction Id: <?php print $_GET['id']?></div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="form-label" for="name">Cardholder Name</label>
                                    <input name="holdername" id="name" class="form-input" type="text"  required />
                                    <span class="error" id="holderError"></span>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input name="email" id="email" class="form-input" type="email" required />
                                </div> -->
                                <div class="form-group">
                                    <label class="form-label" for="card">Card Number</label>
                                    <input name="cardnumber" id="card" class="form-input" type="text" maxlength="16" data-stripe="number" required />
                                    <span class="error" id="cardNumError"></span>
                                </div>
                                <div class="expiryCvv">
                                    <div class="form-group2">
                                        <label class="form-label" for="password">Expiry Date</label>
                                        <select name="month" id="month" class="form-input2" data-stripe="exp_month">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <select name="year" id="year" class="form-input2" data-stripe="exp_year">
                                            <option value="23">2023</option>
                                            <option value="24">2024</option>
                                            <option value="25">2025</option>
                                            <option value="26">2026</option>
                                            <option value="27">2027</option>
                                            <option value="28">2028</option>
                                            <option value="29">2029</option>
                                            <option value="31">2031</option>
                                            <option value="32">2032</option>
                                            <option value="33">2033</option>
                                            <option value="34">2034</option>
                                            <option value="35">2035</option>
                                            <option value="36">2036</option>
                                            <option value="37">2037</option>
                                            <option value="38">2038</option>
                                            <option value="39">2039</option>
                                            <option value="40">2040</option>
                                        </select>
                                    </div>
                                    <div class="form-group2">
                                        <label class="form-label" for="password">CVV</label>                            
                                        <input name="cvv" id="cvv" class="form-input2" type="text" placeholder="CVV" data-stripe="cvc" max="3" required />
                                        <span class="error" id="cvvError"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="tacbox">
                                      <input id="leadTermscheck" type="checkbox" /><label for="leadTermscheck"> I accept the <a href="/terms-conditions/">terms and conditions</a>.</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="payment-errors"></div>
                                </div>
                                <input name="price" id="price" class="form-input2" type="hidden" placeholder="price" value="2" required />
                                <input name="user" id="user" class="form-input2" type="hidden" value="<?php echo get_current_user_id(); ?>" required />
                                <input name="buylead" id="buylead" class="form-input2" type="hidden" value="1" required />
                                <div class="button-style">
                                    <button class="button login submit" disabled='disabled' id="leadSubmitBtn">
                                        Pay now <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </div>  
                                <div class="dcsLoaderImg" style="display: none;">
                                 <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="
                                 color: #ff7361;">
                                 <path fill="#ff7361" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                   <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                   </path>
                                 </svg>
                            </div>                      
                            </form>
                        </div>
                    </div>  
                    
                </div>
            </div>
        </div>
    </div>
    <div class="buy-leads-inner">
        <h1>Buy Leads</h1>
        <div class="want-to-buy">
            <div class="want-to-buy-col">
                <h3>How many leads do you want to buy?</h3>
                <div class="want-to-buy-counter">
                    <label class="fontZero">number value<span id="infoN"></span>
                    <input type="number" id="relationship-status-output" min="1" max="50" step="1" value="1" oninput="setInfoValues(this);" class="relationship-status-output color-default">
                    <!-- <input type="number" id="relationship-status-output" value="1" max="50" class="relationship-status-output color-default"> -->
                </div>
            </div>
               <!--  <input type="range" id="relationship-status-slider" class="relationship-status-slider" value="1" min="1"
                max="50" step="1"> -->
                <label class="fontZero">value [1 - 50]<span id="infoR"></span>
                <div id="tooltip"></div>
                <input type="range" id="relationship-status-slider" min="1" max="50" step="1" value="1" oninput="setInfoValues(this);" class="relationship-status-slider">
               <div class="grid-number">
                    <p class="rangeno1">1</p>
                    <p class="rangeno2">25</p>
                    <p class="rangeno3">50</p>
               </div>
            <div class="total-pay-content">
                <div class="total-pay-text">
                    <h5>Total to pay:</h5>
                </div>
                <div class="total-pay-dollor">
                    <h4>£<span class="totalPrice">2</span><span class= "totalPrice-0">.00</span></h4>
                </div>
                <div class="purchase-leads">
                <!-- <a class="purchaseLeadsBtn" href="<?php echo wp_logout_url( '/login/' ); ?>">Purchase Leads<img src="<?=get_stylesheet_directory_uri()?>/image/arrow-right-1.svg" alt="purchase"></a> -->
                <a class="purchaseLeadsBtn" href="javascript:void(0)">Purchase Leads<img src="<?=get_stylesheet_directory_uri()?>/image/arrow-right-1.svg" alt="purchase"></a>
                </div>

            </div>

        </div>
    </div>
    <div class="buy-lead-content">
        <div class="buy-lead-content-1">
            <h3><?=get_field('faqs_title')?></h3>
            <p><?=get_field('faqs_sub_content')?></p>
        </div>
        <div class="buy-lead-content-2">
            <?php
                // Check rows exists.
                if( have_rows('faqs') ):
                    ?>
                    <div class="faqs-list-wrap">
                        <?php
                        // Loop through rows.
                        while( have_rows('faqs') ) : the_row();

                           $faq_title = get_sub_field('faq_title');
                           $faq_content = get_sub_field('faq_content');

                           ?>
                            <div class="faq">
                               <div class="faq-content-wrap">
                                    <h5><?=$faq_title?></h5>
                                    <p><?=$faq_content?></p>
                               </div> 
                            </div>
                           <?php

                        endwhile;
                        ?>
                    </div>
                    <?php
                endif;
            ?>
        </div>
    </div>
    <div class="lead-purchase-sec" style="display:none">
        <div class="leads-purchase">
            <img src="/wp-content/uploads/2023/01/Mask-group-7.svg" alt="">
            <h1 class="heading-purchase">Your purchase is complete</h1>
            <p class="leads-message">Your <span class="purchasedLead">12</span> leads are credited to your account successfully.</p>
            <button class="btn-dashboard"><a href="<?php echo site_url() ?>/therapist-dashboard/">Return to Dashboard</a></button>
        </div>
    </div>
    
</section>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
        const
        range = document.getElementById('relationship-status-slider'),
        tooltip = document.getElementById('tooltip'),
        setValue = ()=>{
            const
                newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
                newPosition = 16 - (newValue * 0.32);
            tooltip.innerHTML = `<span>${range.value}</span>`;
            tooltip.style.left = `calc(${newValue}% + (${newPosition}px))`;
            document.documentElement.style.setProperty("--range-progress", `calc(${newValue}% + (${newPosition}px))`);
        };
    document.addEventListener("DOMContentLoaded", setValue);
    range.addEventListener('input', setValue);

   </script>

<script>
jQuery(document).ready(function(){
     jQuery('#relationship-status-output').on('input', function() {
     
          valueNum = jQuery(this).val();
          if(valueNum ==""){
               jQuery("#relationship-status-output").val(1);
          }
  });

     /****/
     rangeNew = document.getElementById('relationship-status-slider');
      var $rangeslider = jQuery('#relationship-status-slider');
            var $leadCount = jQuery('#relationship-status-output');
            $leadCount.on('input', function() {
              $rangeslider.val(this.value).change();

              newValue = Number( (this.value - 1) * 100 / (50 - 1) );
              newPosition = 16 - (newValue * 0.32);
              tooltipStyle = `calc(${newValue}% + (${newPosition}px))`;
              jQuery("#tooltip").attr("style", 'left:'+tooltipStyle);
              jQuery("#tooltip span").text(this.value);

              var rg = document.querySelector('.relationship-status-slider');
              rg.style.setProperty('--range-progress', `calc(${newValue}% + (${newPosition}px))`);
              range.addEventListener('input', setValue);
            });
});
</script>

<script type="text/javascript">

// Assign event listener
window.onload = window.onchange = window.onresize = function () {
    setScaleSizeVars();
};

/* container element involved */
const scale = document.getElementById("scale");

function setScaleSizeVars() {
    // Modify CSS custom variable to hold current element width/height
    //scale.style.setProperty("--clientWidth" , scale.clientWidth);
    //scale.style.setProperty("--clientHeight", scale.clientHeight); // not used
};

function setInfoValues(element) {
    document.documentElement.style.setProperty('--scale-value', element.value); 

    if(element.value ==""){
     var valNumer = 1;
    } else{
     var valNumer = element.value;
    }

    document.getElementById('infoN').innerHTML = valNumer;
    document.getElementById('infoR').innerHTML = ' > ' + element.value;

    if(element.value ==""){
     var valNum = 1;
    } else{
     var valNum = element.value;
    }

    document.getElementById('relationship-status-slider').value  = valNum;
    document.getElementById('relationship-status-output').value = element.value;
};
</script>

<script>
    var $rangeslider = $('#relationship-status-slider');
    var $amount = $('#relationship-status-output');
    var leadPrice = 2;

    $('#relationship-status-slider').on('change input', function () {
        newValue = Number( (this.value - 1) * 100 / (50 - 1) );

          newPosition = 16 - (newValue * 0.32);
          tooltipStyle = `calc(${newValue}% + (${newPosition}px))`;
          jQuery("#tooltip").attr("style", 'left:'+tooltipStyle);
          jQuery("#tooltip span").text(this.value);

          var re = document.querySelector('.relationship-status-slider');
          re.style.setProperty('--range-progress', `calc(${newValue}% + (${newPosition}px))`);
          range.addEventListener('input', setValue);

        $('#relationship-status-output').val($(this).val());
        var totalPrice = leadPrice*($(this).val());

        $('.totalPrice').text(totalPrice);

        $('.leadsandprice p span').text($(this).val());
        $('.leadsandprice h6 span').text(totalPrice);
        $('#price').val(totalPrice);
        $('#buylead').val($(this).val());
        // consol.log(totalPrice);
    });

    $("a.purchaseLeadsBtn").click(function(){
        $(".buy-leads-purchase").show();
        $(".buy-leads-inner").hide();
        $(".buy-lead-content").hide();
    });

    $(".backtoLead").click(function(){
        $(".buy-leads-inner").show();
        $(".buy-lead-content").show();
        $(".buy-leads-purchase").hide();
    });
 
</script>
<!-- Bhavesh Validation -->
<script type="text/javascript">
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

        jQuery(document).ready(function(){

        jQuery('#leadTermscheck').click(function() {
        if (!jQuery(this).is(':checked')) {
            jQuery('#leadSubmitBtn').attr('disabled', 'disabled');
        } else {
            jQuery('#leadSubmitBtn').removeAttr('disabled');
        }
        });

       jQuery('#card').keypress(function (e) {    
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)){   
                    return false;
                }
                if(jQuery(this).val().length >16){
                    return false;
                }
            });

       jQuery('#cvv').keypress(function (e) {
                var charCodeCvv = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCodeCvv).match(/[^0-9]/g)){   
                    return false;
                }
                if(jQuery(this).val().length >2){
                    return false;
                }
            });
            
              var $regexname=/^[a-zA-Z ]*$/;

              jQuery('#name').donetyping(function(){
                var holderName = jQuery('#name').val();
                  if(holderName == ""){
                      jQuery('#holderError').text("Please enter holder name.");
                      return false;
                    }else{
                      jQuery('#holderError').text("");
                      return true;
                    }
                });

              jQuery('#card').donetyping(function(){
                var cardNumber = jQuery('#card').val();
               if(cardNumber == ""){
                  jQuery('#cardNumError').text("Please enter Card Number.");
                  return false;
                } else if(( cardNumber.length < 16 ) || ( !cardNumber.match(/([0-9])/)) ){
                   jQuery('#cardNumError').text("Enter atleast sixteen number.");
                    return false; 
                }
                 else{
                  jQuery('#cardNumError').text("");
                  return true;
                }
              });

              jQuery('#cvv').donetyping(function(){
                var cvvNumber = jQuery('#cvv').val();
               if(cvvNumber == ""){
                  jQuery('#cvvError').text("Please enter Card Number.");
                  return false;
                } else if(( cvvNumber.length < 3 ) || ( !cvvNumber.match(/([0-9])/)) ){
                   jQuery('#cvvError').text("Please enter atleast three number.");
                    return false; 
                }
                 else{
                  jQuery('#cvvError').text("");
                  return true;
                }
              });

        });
    </script>
<!-- End validation -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('<?php print $publishable_key; ?>');
  
    $(function() {
      var $form = $('#payment-form');
      $form.submit(function(event) {
        //bhavesh validation script come here
        // Disable the submit button to prevent repeated clicks:
        $form.find('.submit').prop('disabled', true);
        jQuery(".dcsLoaderImg").show();
    
        // Request a token from Stripe:
        Stripe.card.createToken($form, stripeResponseHandler);
    
        // Prevent the form from being submitted:
        return false;
      });
    });

    function stripeResponseHandler(status, response) {
        console.log('response--',response);
        console.log('status--',status);

      // Grab the form:
      var $form = $('#payment-form');
    
      if (response.error) { // Problem!
    
        // Show the errors on the form:
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission
        jQuery(".dcsLoaderImg").hide();
    
      } else { // Token was created!
    
        // Get the token ID:
        var token = response.id;
        // Insert the token ID into the form so it gets submitted to the server:
        //$form.append($('<input type="hidden" name="stripeToken">').val(token));
            // Submit the form:
        // $form.get(0).submit();
        var price = $("#price").val();
        var user = $("#user").val();
        var buylead = $("#buylead").val();
            // alert(1);
            $.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php",
                data: {
                    'action': 'create_charge_for_buy_leads',
                    'stripeToken' : token,
                    'price' : price,
                    'user_id' : user,
                    'buylead' : buylead
                },
                beforeSend: function (){

                    console.log('test before send');
                },
                success: function(response) {
                    jQuery(".dcsLoaderImg").hide();
                    if(response =="declined"){
                    jQuery('.payment-errors').text("Your card has been declined.");
                        if (jQuery("#leadTermscheck").is(':checked')) {
                            jQuery('#leadSubmitBtn').removeAttr('disabled');
                        }
                    }

                    //alert(data.status);
                    var data = JSON.parse(response);
                    // console.log('test parse response');
                    // console.log(data);
                    // console.log(data.id);
                    // console.log(data.lead);
                    // console.log(data.email);
                    // console.log(data.status);
                    // alert("Payment done");
                    $(".buy-leads-purchase").hide();
                    $(".buy-leads-inner").hide();
                    $(".buy-lead-content").hide();
                    $(".lead-purchase-sec").show();
                    // $(".purchase-sec").show();
                    $("span.purchasedLead").text(data.lead);
                    // $("span.purchaseEmail").text(data.email);  
                    jQuery(".dcsLoaderImg").hide(); 
                    // alert("Return label created and download successfully");
                },
                error: function(response) {
                    jQuery(".dcsLoaderImg").hide();
                    // alert("Payment failed");
                }
            });
      }
    };
    

    
</script>
<!-- </body>

</html> -->

<?php

get_footer();

?>