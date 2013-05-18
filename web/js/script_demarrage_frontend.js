$(document).ready(function(){

	///////////////////////////////////////////////////////////////////////
	//////////////////////////////::: NOTE ::://///////////////////////////
	///////////////////////////////////////////////////////////////////////
		$(".star, .star_hover").hover(function () { // Au survole d'une étoile
			 var id = $(this).attr("id"); // On récupere son id, exemple : star_5
			 var num = id.split('star_'); // On récupère le numéro de l'id, exemple : 5
			 for (var i=1;i<=num[1];i++){ // on modifie le css pour chaque étoile situé avant celle survolé par  la souris
				 var hover = '#star_'+i; // On crée le nom de l'id dont on va modifier le css, exemple : star_1
				 $(hover).css("background-position","0 -16px");
			 }
			 $('#affichNote').html('('+num[1]+'/10)');
			 $('#affichNote').attr('class','note'+num[1]);
		 }, function() { // fonction utilisé lorsque la souris se retire de l'étoile survolé (fait la même chose mais remet le background)
			 var id = $(this).attr("id");
			 var num = id.split('star_');
			 for (var i=1;i<=num[1];i++){
				 $('#star_'+i+'[class=star]').css("background-position","0 0");
				 $('#star_'+i+'[class=star_hover]').css("background-position","0 -32px");
			 }
			 $('#affichNote').html('('+$('#affichNoteFixe').html()+'/10)');
			 $('#affichNote').attr('class','note'+$('#affichNoteFixe').html());
		 });
		 /*
		 $(".star, .star_hover").live('click', function(){
			 var id = $(this).attr("id");
			 var vote = id.split('star_');
			 validAction($('#noter').html()+vote[1], 'Souhaitez-vous attribuer la note de '+vote[1]);
			 return false;
		});
		*/
		
	///////////////////////////////////////////////////////////////////////
	////////////////////::: Fancybox IFRAME NOTE :::///////////////////////
	///////////////////////////////////////////////////////////////////////
		var color;
		var op;
		for(var i=1;i<=10;i++){
			if(i<5){
				color='#b10000';
				op=0.1;
			}else if(i==5){
				color='#b1b1b1';
				op=0.3;
			}else if(i>5){
				color='#00af00';
				op=0.1;
			}
			$("#star_"+i).fancybox({
					'zoomOpacity'	: true,
					'centerOnScroll': false,
					'width'			: 350,
					'height'		: 300,
					'overlayOpacity': op,
					'overlayColor' 	: color,
					'zoomSpeedIn'	: 500,
					'zoomSpeedOut'	: 500,
					'type'			: 'iframe'
			});
		}

	///////////////////////////////////////////////////////////////////////
	////////////////////::: Fancybox IMAGE ::://///////////////////////////
	///////////////////////////////////////////////////////////////////////
		$(".lookimg").fancybox({
			'easingIn' : 'easeInOutSine',
			'easingOut' : 'easeOutQuint',
			'zoomSpeedIn':		500,
			'zoomSpeedOut':		500,
			'overlayShow':		false,
			'frameWidth':1000,
			'frameHeight':600
			
		});
		
		
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
		
});