
jQuery(document).ready(function(){


if(parseInt(AJAXOBJ.auto_load_posts)==1) {
/*
* Ajax Auto Load Posts
*/
postload = true; // For Prevent Extra load
jQuery(window).scroll(function() { 
var windowtop = jQuery(window).scrollTop(); 
var windowheight = jQuery(window).height();
var documentheight = jQuery(document).height();
var wtplugh = parseInt(windowtop) + parseInt(windowheight);

if((wtplugh==documentheight) && (postload))  {
		postload = false;
		jQuery('.isba_load_more_wr a').click(); // Click load if scroll equals to document height
} 

});
 

 

}
/*
* Ajax Load More Posts
*/
jQuery('.isba_load_more_wr a').click(function(){
 	var posts_per_page; 

 	posts_per_page = jQuery(this).attr('date-posts'); // Getting value with button attr
 	
 	if(posts_per_page==null) {
 		posts_per_page = parseInt(AJAXOBJ.posts_per_page); // If attribute not found get value with wp options
 	}

 	posts_per_page = parseInt(posts_per_page) + parseInt(AJAXOBJ.posts_per_page);
 	if(parseInt(AJAXOBJ.published_posts)<parseInt(posts_per_page)) { 
		jQuery(this).addClass('preventbutton'); // If posts per page greater then published post stop loading.
		jQuery(this).html('No more posts.');
	} else {
		jQuery(this).hide(); 
		jQuery(this).parent().append('<div class="isba_loader"></div>');
	}

	jQuery.ajax({
	type: 'POST',  
	url: AJAXOBJ.ajaxurl,
	data: { 
			"action": "isba_load_more_posts",
			"posts_per_page": posts_per_page
		  },
	success: function(data){
	  	jQuery("#isba_container").html(data);
	 	jQuery('.isba_loader').remove();
	 	jQuery('.isba_load_more_wr a').show(); 
	 	postload = true;
	}
	});

	jQuery(this).attr('date-posts',posts_per_page);

});



}); 
 // Document Ready End 

 