jQuery(document).ready(function(){
	var pageBlogs = 2;
	var maxp = jQuery(".btnLoadmoreWrapper").data("maxp");
	jQuery(document).on('click','.dcsLoadMorePostsbtn',function(){
		var ajaxurl = dcs_frontend_ajax_object.ajaxurl;
		var dcsPostType = jQuery('input[name="dcsPostType"]').val();
		var offset = parseInt(jQuery('input[name="offset"]').val() );
		var dcsloadMorePosts = parseInt(jQuery('input[name="dcsloadMorePosts"]').val() );
		var newOffset = offset+dcsloadMorePosts;
		jQuery('.btnLoadmoreWrapper').hide();
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: ({
				action: "dcsAjaxLoadMorePostsAjaxReq",
				offset: newOffset,
				page: pageBlogs,
				dcsloadMorePosts: dcsloadMorePosts,
				postType: dcsPostType,
			}),
			success: function(response){
				if (!jQuery.trim(response)){ 
					// blank output
					jQuery('.noMorePostsFound').show();
				}else{
					// append to last div
					jQuery(response).insertAfter(jQuery('.loadMoreRepeat').last());
					jQuery('input[name="offset"]').val(newOffset);
					jQuery('.btnLoadmoreWrapper').show();
					if(maxp === pageBlogs)  {
	                  jQuery('.btnLoadmoreWrapper').hide();
	               }
	                pageBlogs++;
				}
			},
			beforeSend: function() {
				jQuery('.dcsLoaderImg').show();
			},
			complete: function(){
				jQuery('.dcsLoaderImg').hide();
			},
		});
	});
    
    setTimeout(function(){
	   jQuery('.appendLoadMore').append( jQuery('.loadMoreSection') ); 
	}, 50);
    
});