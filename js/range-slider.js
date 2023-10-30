$(document).ready(function(){
	var $inputRange = $('input[type="range"]');
	
	$.fn.addCommas = function() {
		 return this.each(function(){ 
			  $(this).val( $(this).val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
		 })
	}
	
	// Update <output> from range value
	function valueOutput($element) {
		// Get value from range slider
		var $value = $element.value;
		// Get output element(s)
		var $output = $($element).parent().children(".rangeslider__output")[0];		
		
		// Format output value
		$($output).val($value).addCommas();
		$($output).val("£" + $($output).val());
	}
	
	// Calculate output(s) for multiple range sliders
	for (var i = $inputRange.length - 1; i >= 0; i--) {
		valueOutput($inputRange[i]);
	};

	// Calculate output with range slider movement
	$(document).on('input', 'input[type="range"]', function(e) {
		valueOutput(e.target);
	});

	// Initialise rangeslide.js
	$inputRange.rangeslider({
		// Stop polyfill reverting when 
		// browser compatible with input[rangeslider]
		polyfill: false,
		
		// Run once user has finished adjusting range slider
		onSlideEnd: function() {
			console.log("Range slider changed");
		}
	});
	
	window.addEventListener('orientationchange', function(){
		$inputRange.rangeslider("update");
	});

	
});
