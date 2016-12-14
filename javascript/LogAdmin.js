jQuery(document).ready(function(){
	resizeWindow();

	//If the User resizes the window, adjust the #container height
	jQuery(window).bind("resize", resizeWindow);
});

function resizeWindow( e ) {
	var RightHeight	= (parseInt(jQuery('.cms-content').height()) - 180);
	jQuery("#right .Logs").css("height", RightHeight );
}

//overriding SilverStripe's AJAX loading that goes nowhere
jQuery('.Logs .Nav a').click(function(e){
  e.preventDefault();
  var url = jQuery(this).attr('href');
  location.href = url;
});
