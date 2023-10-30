<?php /* Template Name: Therapist buy leads */

get_header();

?>

    <div class="dashboard-main">
      <!-- amelio-sidebar start -->
        <?php include get_stylesheet_directory().'/dashboard-sidebar.php'; ?>
        <!-- amelio-sidebar end -->

<!-- amelio-buy-leads -->
<section class="buy-lead-main">
    <div class="buy-leads-inner">
        <h1>Buy Leads</h1>
        <div class="want-to-buy">
            <div class="want-to-buy-col">
                <h3>How many leads do you want to buy?</h3>
                <div class="want-to-buy-counter">
                <input type="number" id="relationship-status-output" value="1" min="1" max="50" class="relationship-status-output color-default">
                </div>
            </div>
            <input type="range" id="relationship-status-slider" class="relationship-status-slider" value="1" min="1"
                max="50" step="1">
            <!-- <output id="relationship-status-output" class="relationship-status-output color-default">0</output> -->
            <!-- <input type="range" class="form-range" id="customRange1">
            <div class="optionControls">
                <div class="question noHover">
                    
                    <div class="rangeslider__holder">
                        <input type="range" min="5" max="25" step="1" value="10" id="loanTerm">
                        <input class="rangeslider__output" type="text" min="5" max="25" />
                    </div>
                </div>
             </div> -->
             <div class="total-pay-content">
                <div class="total-pay-text">
                    <h5>Total to pay:</h5>
                </div>
                <div class="total-pay-dollor">
                    <h4>£<span>24</span>.00</h4>
                </div>
                <div class="purchase-leads">
                <a href="<?php echo wp_logout_url( '/login/' ); ?>">Purchase Leads<img src="<?=get_stylesheet_directory_uri()?>/image/arrow-right-1.svg" alt="purchase"></a>
                </div>

             </div>

        </div>
    </div>
    <div class="buy-lead-content">
        <div class="buy-lead-content-1">
            <h3>FAQs</h3>
            <p>Still have questions? Contact Us.</p>
        </div>
        <div class="buy-lead-content-2">
            <h5>Lorem ipsum dolor sit amet?</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Varius lacus, feugiat arcu ut nam. Vitae sed facilisi enim adipiscing odio pretium consectetur aliquet nulla. </p>
            <hr>  
            <h5>Lorem ipsum dolor sit amet?</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Varius lacus, feugiat arcu ut nam. Vitae sed facilisi enim adipiscing odio pretium consectetur aliquet nulla. </p>
            <hr>   

        </div>
        <div class="buy-lead-content-3">
            <h5>Lorem ipsum dolor sit amet?</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Varius lacus, feugiat arcu ut nam. Vitae sed facilisi enim adipiscing odio pretium consectetur aliquet nulla. </p>
            <hr>  
            <h5>Lorem ipsum dolor sit amet?</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Varius lacus, feugiat arcu ut nam. Vitae sed facilisi enim adipiscing odio pretium consectetur aliquet nulla. </p>
            <hr> 
        </div>
    </div>
    
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.min.js"></script>
        <script>
            $('input[type="range"]').rangeslider({
                polyfill: false
            });

            $('#relationship-status-slider').on('change input', function () {
                //$('#relationship-status-output').text($(this).val());
                $('#relationship-status-output').val($(this).val());
            });
        </script>

<!-- </body>

</html> -->

<?php

get_footer();

?>