
$(document).ready(function(){
		
		
	///////////////////////////////////////////////////////////////////////
	////////////////////::: Fancybox IFRAME :::////////////////////////////
	///////////////////////////////////////////////////////////////////////
		for(var w=50;w<=1500;w+=50){
			for(var h=50;h<=1500;h+=50){
				$(".iframe"+w+"_"+h).fancybox({
				'zoomOpacity'	: true,
				'centerOnScroll': false,
				'width'			: w,
				'height'		: h,
				'overlayOpacity': 0.5,
				'zoomSpeedIn'	: 500,
				'zoomSpeedOut'	: 500,
				'type'			: 'iframe',
				"onClosed"			: function() {parent.location.reload()}
				});
			}
		}
		
		$(".iframe").fancybox({
				'zoomOpacity'	: true,
				'centerOnScroll': false,
				'width'			: 1200,
				'height'		: 700,
				'overlayOpacity': 0.5,
				'zoomSpeedIn'	: 500,
				'zoomSpeedOut'	: 500,
				'type'			: 'iframe',
				"onClosed"			: function() {parent.location.reload()}
		});
		
	///////////////////////////////////////////////////////////////////////
	////////////////////////::: MULTISELECT :::////////////////////////////
	///////////////////////////////////////////////////////////////////////
		
	//$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
	$(".multiselect").multiselect();
	$('#switcher').themeswitcher();
		
});