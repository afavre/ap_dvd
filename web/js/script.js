/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 

 /*
 
// Lorsque le DOM est chargé on applique le Javascript
$(document).ready(function() {// On simule un survol souris des boutons cochés par défaut
	$("ul.notes-echelle input:checked").parent("li").trigger("mouseover");
	// On simule un click souris des boutons cochés
	$("ul.notes-echelle input:checked").trigger("click");
	// On ajoute la classe "js" à la liste pour mettre en place par la suite du code CSS uniquement dans le cas où le Javascript est activé
	$("ul.notes-echelle").addClass("js");
	// On passe chaque note à l'état grisé par défaut
	$("ul.notes-echelle li").addClass("note-off");
	// Au survol de chaque note à la souris
	$("ul.notes-echelle li").mouseover(function() {
		// On passe les notes supérieures à l'état inactif (par défaut)
		$(this).nextAll("li").addClass("note-off");
		// On passe les notes inférieures à l'état actif
		$(this).prevAll("li").removeClass("note-off");
		// On passe la note survolée à l'état actif (par défaut)
		$(this).removeClass("note-off");
	});
	// Lorsque l'on sort du sytème de notation à la souris
	$("ul.notes-echelle").mouseout(function() {
		// On passe toutes les notes à l'état inactif
		$(this).children("li").addClass("note-off");
		// On simule (trigger) un mouseover sur la note cochée s'il y a lieu
		$(this).find("li input:checked").parent("li").trigger("mouseover");
	});
	
	
	
	// Lorsque le focus est sur un bouton radio
	$("ul.notes-echelle input").focus(function() {
		// On supprime les classes de focus
		$(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
		// On applique la classe de focus sur l'item tabulé
		$(this).parent("li").addClass("note-focus");
		// On passe les notes supérieures à l'état inactif (par défaut)
		$(this).parent("li").nextAll("li").addClass("note-off");
		// On passe les notes inférieures à l'état actif
		$(this).parent("li").prevAll("li").removeClass("note-off");
		// On passe la note du focus à l'état actif (par défaut)
		$(this).parent("li").removeClass("note-off");
	})
	// Lorsque l'on sort du sytème de notation au clavier
	$("ul.notes-echelle input").blur(function() {
		// On supprime les classes de focus
		$(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
		// Si il n'y a pas de case cochée
		if($(this).parents("ul.notes-echelle").find("li input:checked").length == 0) {
			// On passe toutes les notes à l'état inactif
			$(this).parents("ul.notes-echelle").find("li").addClass("note-off");
		}
	});
	// Lorsque la note est cochée
	$("ul.notes-echelle input").click(function() {
		// On supprime les classes de note cochée
		$(this).parents("ul.notes-echelle").find("li").removeClass("note-checked");
		// On applique la classe de note cochée sur l'item choisi
		$(this).parent("li").addClass("note-checked");
	});
	
	
});

*/
 
 
 
 
 
 
 
 
 function chargement(){
   document.getElementById('chargement').style.display='none';
   document.getElementById('site').style.visibility='visible';
}
 
 
 
 
 

function lettre(elem,lettre){
	//alert(elem);
    $('#content').load(
		elem,
        {le: lettre},
        function() { $('#listbis').show(); $('#loader').hide(); }
    );
}

function lienNew(id){
	location.href=$('#'+id).html();
}

function OuvrirPopup(page,nom,option) {
    window.open(page,nom,option);
}
function OuvrirPopupLien(page,nom,option) {
    window.open($(page).html(),nom,option);
}

function cleanChaine(chaine) {
  chaine=noaccent(chaine);
  chaine=nomajuscule(chaine);
  chaine=nocharspec(chaine);

  return chaine
}

function noaccent(chaine) {
  temp = chaine.replace(/[àâä]/gi,"a")
  temp = temp.replace(/[éèêë]/gi,"e")
  temp = temp.replace(/[îï]/gi,"i")
  temp = temp.replace(/[ôö]/gi,"o")
  temp = temp.replace(/[ùûü]/gi,"u")
  return temp
}

function nocharspec(chaine) {
  temp = chaine.replace(/[^a-z0-9.]/gi,"")
  return temp
}

function nomajuscule(chaine) {
  temp = chaine.replace(/[A]/gi,"a")
  temp = temp.replace(/[B]/gi,"b")
  temp = temp.replace(/[C]/gi,"c")
  temp = temp.replace(/[D]/gi,"d")
  temp = temp.replace(/[E]/gi,"e")
  temp = temp.replace(/[F]/gi,"f")
  temp = temp.replace(/[G]/gi,"g")
  temp = temp.replace(/[H]/gi,"h")
  temp = temp.replace(/[I]/gi,"i")
  temp = temp.replace(/[J]/gi,"j")
  temp = temp.replace(/[K]/gi,"k")
  temp = temp.replace(/[L]/gi,"l")
  temp = temp.replace(/[M]/gi,"m")
  temp = temp.replace(/[N]/gi,"n")
  temp = temp.replace(/[O]/gi,"o")
  temp = temp.replace(/[P]/gi,"p")
  temp = temp.replace(/[Q]/gi,"q")
  temp = temp.replace(/[R]/gi,"r")
  temp = temp.replace(/[S]/gi,"s")
  temp = temp.replace(/[T]/gi,"t")
  temp = temp.replace(/[U]/gi,"u")
  temp = temp.replace(/[V]/gi,"v")
  temp = temp.replace(/[W]/gi,"w")
  temp = temp.replace(/[X]/gi,"x")
  temp = temp.replace(/[Y]/gi,"y")
  temp = temp.replace(/[Z]/gi,"z")
  return temp
}

function affichImage(){
        $.ajax({
                type: "POST",
                url: $('#fich').html(),
                data: "tab="+$('#tab').html(),
                success: function(reponse){
                    var rep=reponse.split(',');
                    var img;
                    if(rep[0]==""){
                        img="image_vide.jpeg";
                    }else{
                        img="films/"+rep[0];
                    }

                    $('#imgder').attr('src', '/uploads/'+img);
                    $('#imgder').attr('alt', rep[4]);
                    $('#lienderfilm').attr('href','/film/show/id/'+rep[2]);
                    $('#lienderfilm').attr('title', rep[4]);
                    if(rep[3]!='1'){
                        $('#tab').html($('#tab').html()+'/'+rep[1]);
                    }else{
                        $('#tab').html(rep[1]);
                    }
                }
        });
}

function affichEtoile(note){
	for(var i=1;i<=note;i=i+1){
		$('#'+i+'gris').hide();
		$('#'+i+'jaune').show();
	}
}
/*
function cachBoutEtoile(note){
		$('#'+note+'jaune').hide();
		$('#'+note+'gris').show();
}

function cachAllEtoile(){
	for(var i=1;i<=10;i=i+1){
		$('#'+i+'jaune').hide();
		$('#'+i+'gris').show();
	}
}

var StarOutUrl=		'StarOut.gif';		//image par défaut
var StarOverUrl=	'StarOver.gif';		//image d'une étoile sélectionnée
var StarBaseId=		'Star';				//id de base des étoiles
var NbStar=			10;					//nombre d'étoiles

var LgtStarBaseId=StarBaseId.lastIndexOf('');

function NotationSystem() {
	for (i=1;i<NbStar+1;i++) {
		var img			=document.getElementById(i+'gris');
		var img			=document.getElementById(i+'jaune');
			
		img.onclick		=function() {alert('Vous avez donné la note de '+Name2Nb(this.id)+'.');};
		//Réaction lors du clic sur une étoile
		//Evidemment, il faudrait compléter cette fonction pour la rendre vraiment utile.
		//Par exemple, envoyer la note dans une base de donnée via un XMLHttpRequest.
		
		img.alt			='Donner la note de '+i;
		//Texte au survol
		
		img.src			=StarOutUrl;
		img.onmouseover	=function() {StarOver(this.id);};
		img.onmouseout	=function() {StarOut(this.id);};
	}
}

function StarOver(Star) {
	StarNb=Name2Nb(Star);
	for (i=1;i<(StarNb*1)+1;i++) {
		//document.getElementById('Star'+i).src=StarOverUrl;
		$('#'+i+'gris').hide();
		$('#'+i+'jaune').show();
	}
}

function StarOut(Star) {
	StarNb=Name2Nb(Star);
	for (i=1;i<(StarNb*1)+1;i++) {
		//document.getElementById('Star'+i).src=StarOutUrl;
		$('#'+i+'jaune').hide();
		$('#'+i+'gris').show();
	}
}

function Name2Nb(Star) {
	//Le survol d'une étoile ne nous permet pas de connaître directement son numéro
	//Cette fonction extrait donc ce numéro à partir de l'Id
	StarNb=Star.slice(LgtStarBaseId);
	return(StarNb);
} 

*/


function validAction(urlOk, txt){
  	if (confirm(txt) == true) {
        document.location.href=urlOk;
    }
}

function selVers(id){
	var sel=$('#tabSelVers').val();
	if($('#versVal'+id).val()=='1'){
		$('#vers'+id).attr('class','nonselRech');
		var tab=sel.split('/');
		sel="";
		for(var i=0;i<tab.length;i++){
			if(tab[i]!=''){
				if(tab[i]!=id){
					if(sel!=''){
						sel+="/"+tab[i]
					}else{
						sel=tab[i]
					}
				}
			}
		}
		$('#tabSelVers').val(sel);
		$('#versVal'+id).val('0');
	}else if($('#versVal'+id).val()=='0'){
		$('#vers'+id).attr('class','selRech');
		if(sel!=''){
			sel+="/"+id
		}else{
			sel=id
		}
		$('#tabSelVers').val(sel);
		$('#versVal'+id).val('1');
	}
}


function selQual(id){
	var sel=$('#tabSelQual').val();
	if($('#qualVal'+id).val()=='1'){
		$('#qual'+id).attr('class','nonselRech');
		var tab=sel.split('/');
		sel="";
		for(var i=0;i<tab.length;i++){
			if(tab[i]!=''){
				if(tab[i]!=id){
					if(sel!=''){
						sel+="/"+tab[i]
					}else{
						sel=tab[i]
					}
				}
			}
		}
		$('#tabSelQual').val(sel);
		$('#qualVal'+id).val('0');
	}else if($('#qualVal'+id).val()=='0'){
		$('#qual'+id).attr('class','selRech');
		if(sel!=''){
			sel+="/"+id
		}else{
			sel=id
		}
		$('#tabSelQual').val(sel);
		$('#qualVal'+id).val('1');
	}
}


function selCat(id){
	var num=$("#catNb").html();
	var sel=$('#tabSelCat').val();
	if($('#catVal'+id).val()=='1'){
		$('#cat'+id).attr('class','nonselRechMult');
		num--;
		$("#catNb").html(num);
		var tab=sel.split('/');
		sel="";
		for(var i=0;i<tab.length;i++){
			if(tab[i]!=''){
				if(tab[i]!=id){
					if(sel!=''){
						sel+="/"+tab[i]
					}else{
						sel=tab[i]
					}
				}
			}
		}
		$('#tabSelCat').val(sel);
		$('#catVal'+id).val('0');
	}else if($('#catVal'+id).val()=='0'){
		$('#cat'+id).attr('class','selRechMult');
		num++;
		$("#catNb").html(num);
		if(sel!=''){
			sel+="/"+id
		}else{
			sel=id
		}
		$('#tabSelCat').val(sel);
		$('#catVal'+id).val('1');
	}
}

function selAct(id){
	var num=$("#actNb").html();
	var sel=$('#tabSelAct').val();
	if($('#actVal'+id).val()=='1'){
		$('#act'+id).attr('class','nonselRechMult');
		num--;
		$("#actNb").html(num);
		var tab=sel.split('/');
		sel="";
		for(var i=0;i<tab.length;i++){
			if(tab[i]!=''){
				if(tab[i]!=id){
					if(sel!=''){
						sel+="/"+tab[i]
					}else{
						sel=tab[i]
					}
				}
			}
		}
		$('#tabSelAct').val(sel);
		$('#actVal'+id).val('0');
	}else if($('#actVal'+id).val()=='0'){
		$('#act'+id).attr('class','selRechMult');
		num++;
		$("#actNb").html(num);
		if(sel!=''){
			sel+="/"+id
		}else{
			sel=id
		}
		$('#tabSelAct').val(sel);
		$('#actVal'+id).val('1');
	}
}

function AllSelCat(){
	$('.cat').val('1');
	$('#categories .nonselRechMult').attr('class','selRechMult');
	$('#tabSelCat').val($('#tabAllCat').val());
	$("#catNb").html($("#nbAllCat").val());
}
function AllSupprSelCat(){
	$('.cat').val('0');
	$('#categories .selRechMult').attr('class','nonselRechMult');
	$('#tabSelCat').val('');
	$("#catNb").html(0);
}


function AllSelAct(){
	$('.act').val('1');
	$('#acteurs .nonselRechMult').attr('class','selRechMult');
	$('#tabSelAct').val($('#tabAllAct').val());
	$("#actNb").html($("#nbAllAct").val());
}
function AllSupprSelAct(){
	$('.act').val('0');
	$('#acteurs .selRechMult').attr('class','nonselRechMult');
	$('#tabSelAct').val('');
	$("#actNb").html(0);
}

function EnleverVideo(obj,id,idU,event,txt){
		if (event.stopPropagation) {
			event.stopPropagation();
		  }
		  event.cancelBubble = true;
        $(obj).hide();
		if (confirm(txt) == true) {
			$('#loader'+id).show();
			  $.ajax({
					type: "POST",
					url: $(obj).attr('href'),
					data: "id="+id,
					success: function(reponse){
						if(reponse=='pro'){
							$('#video'+id).hide();
							$('#loader'+id).hide();
							$('#plus'+id).show();
						}else{
							$('#boule'+id+'_'+idU).hide();
							$('#loader'+id).hide();
							$('#plus'+id).show();
						}
					}
				});
		}
}

function AjouterVideo(obj,id,idU,event){
		if (event.stopPropagation) {
			event.stopPropagation();
		  }
		  event.cancelBubble = true;
		  
        $(obj).hide();
        $('#loader'+id).show();
		$.ajax({
			type: "POST",
			url: $(obj).attr('href'),
			data: "id="+id,
			success: function(reponse){
				$('#boule'+id+'_'+idU).show();
				$('#loader'+id).hide();
				$('#moins'+id).show();
			}
		});
}

function autoCompletionAct(){
	
}

function RealSaison(obj, valInit){
		val = $(obj).val();
        if(val!=""){
			var serieAll=$('#real_saison').val();
			var tab=serieAll.split('/');
			var fini=false;
			var i=1;
			while(i<tab.length && !fini){
				tab2=tab[i].split('-');
				
				if(tab2[0]==val){
					$('#video_realisateur_id').val(tab2[1]);
					$('#video_version_id').val(tab2[2]);
					var newOptions = {};
					var nb = parseInt(tab2[3]);
					if(nb==0){
						nb=25;
					}
					for(var y=1; y<=nb; y++){
						newOptions[y] = y;
					}
					var selectedOption = '1';
					if(valInit){
						selectedOption = $('#video_numero').val();
					}
					var select = $('#video_numero');
					if(select.prop) {
					  var options = select.prop('options');
					}
					else {
					  var options = select.attr('options');
					}
					$('option', select).remove();
					 
					$.each(newOptions, function(val, text) {
						options[options.length] = new Option(text, val);
					});
					for(var y=4;y<tab2.length;y++){
						$('#video_numero option[value='+tab2[y]+']').remove();
						if(!valInit){
							selectedOption=parseInt(tab2[y])+1;
						}
					}
					select.val(selectedOption);
					fini=true;
				}
				i++;
			}
        }else{
        }
}

function initRealSaison(obj){
		val = $(obj).val();
        if(val==""){
			var derInsertSaison = $('#der_insert_saison').val();
			$(obj).val(derInsertSaison);
        }
		var valInit = 0;
		if($('#video_numero').val()){
			valInit=$('#video_numero').val();
		}
		
		RealSaison(obj, valInit);
}


function RealSerie(obj){
		val = $(obj).val();
        if(val!=""){
			var serieAll=$('#real_serie').val();
			var tab=serieAll.split('/');
			var fini=false;
			var i=1;
			while(i<tab.length && !fini){
				tab2=tab[i].split('-');
				if(tab2[0]==val){
					$('#saison_realisateur_id').val(tab2[1]);
					
					var newOptions = {
						'1' : '1',
						'2' : '2',
						'3' : '3',
						'4' : '4',
						'5' : '5',
						'6' : '6',
						'7' : '7',
						'8' : '8',
						'9' : '9',
						'10' : '10'
					};
					var selectedOption = '1';
					 
					var select = $('#saison_numero');
					if(select.prop) {
					  var options = select.prop('options');
					}
					else {
					  var options = select.attr('options');
					}
					$('option', select).remove();
					 
					$.each(newOptions, function(val, text) {
						options[options.length] = new Option(text, val);
					});
					for(var y=2;y<tab2.length;y++){
						$('#saison_numero option[value='+tab2[y]+']').remove();
						if(selectedOption==y){
							selectedOption++;
						}
					}
					select.val(selectedOption);
					fini=true;
				}
				i++;
			}
        }else{
        }
}

function initRealSerie(obj){
		val = $(obj).val();
        if(val!=""){
			var serieAll=$('#real_serie').val();
			var tab=serieAll.split('/');
			var fini=false;
			var i=1;
			while(i<tab.length && !fini){
				tab2=tab[i].split('-');
				if(tab2[0]==val){
					$('#saison_realisateur_id').val(tab2[1]);
					for(var y=2;y<tab2.length;y++){
						$('#saison_numero option[value='+tab2[y]+']').remove();
					}
					fini=true;
				}
				i++;
			}
        }else{
        }
}



function envoiFormEditAjax(obj,idE){
	$('#editEp'+idE+' .imgEdit').hide();
	$('#editEp'+idE+' .imgLoader').show();
	s = $(obj).serialize();
	$.ajax({
	        type: "POST",
	        data: s,
	        url: $(obj).attr("action"),
	        success: function(retour){
				if(retour!="false"){
					var tab=retour.split('/-/');
					
					$('#visEp'+idE+' .versionEp').hide();
					$('#visEp'+idE+' .versionEp'+tab[0]).show();
					$('#editEp'+idE+' .versionEp').val(tab[0]);
					
					$('#visEp'+idE+' .qualiteEp').hide();
					$('#visEp'+idE+' .qualiteEp'+tab[1]).show();
					$('#editEp'+idE+' .qualiteEp').val(tab[1]);
					
					$('#visEp'+idE+' .titreEp').html(tab[2]);
					$('#editEp'+idE+' .titreEp').val(tab[2]);
					
					$('#editEp'+idE).hide();
					$('#visEp'+idE).show();
					
					$('#editEp'+idE+' .imgLoader').hide();
					$('#editEp'+idE+' .imgEdit').show();
					$('#repOK').fadeIn(200).delay(2500).fadeOut(800);
				}else{
					$('#editEp'+idE+' .imgLoader').hide();
					$('#editEp'+idE+' .imgEdit').show();
					$('#repErr').fadeIn(200).delay(2500).fadeOut(800);
				}
	        }
	});
	return false;
}

function envoiFormNewAjax(obj,numE){
	$('#newEp'+numE+' .imgNew').hide();
	$('#newEp'+numE+' .imgLoader').show();
	s = $(obj).serialize();
	$.ajax({
	        type: "POST",
	        data: s,
	        url: $(obj).attr("action"),
	        success: function(retour){
				var tab=retour.split('/-/-/');
				
				$("#visnotEp"+numE).html(tab[1]);
				$("#newEp"+numE).html(tab[2]);
				
				$('#visnotEp'+numE).removeClass('visnot');
				$('#visnotEp'+numE).addClass('vis');
				$("#visnotEp"+numE).attr("id", "visEp"+tab[0]);
				
				$('#newEp'+numE).removeClass('new');
				$('#newEp'+numE).addClass('edit');
				$("#newEp"+numE).attr("id", "editEp"+tab[0]);
				/*
					$('#visEp'+tab[0]+' .versionEp').hide();
					$('#visEp'+tab[0]+' .versionEp'+tab[0]).show();
					$('#editEp'+tab[0]+' .versionEp').val(tab[0]);
					
					$('#visEp'+tab[0]+' .qualiteEp').hide();
					$('#visEp'+tab[0]+' .qualiteEp'+tab[1]).show();
					$('#editEp'+tab[0]+' .qualiteEp').val(tab[1]);
					
					$('#visEp'+tab[0]+' .titreEp').html(tab[2]);
					$('#editEp'+tab[0]+' .titreEp').val(tab[2]);
					
					
					$('#editEp'+tab[0]+' .imgLoader').hide();
					$('#editEp'+tab[0]+' .imgEdit').show();
					*/
					
					//$('#editEp'+tab[0]).hide();
					//$('#visEp'+tab[0]).show();
					$('#repOKnew').fadeIn(200).delay(2500).fadeOut(800);
				/*
				//$('Affich').html(retour);
				if(retour!="false"){
					var tab=retour.split('/-/');
					
					$('#visnotEp'+numE+' .versionEp').hide();
					$('#visnotEp'+numE+' .versionEp'+tab[0]).show();
					$('#newEp'+numE+' .versionEp').val(tab[0]);
					
					$('#visnotEp'+numE+' .qualiteEp').hide();
					$('#visnotEp'+numE+' .qualiteEp'+tab[1]).show();
					$('#newEp'+numE+' .qualiteEp').val(tab[1]);
					
					$('#visnotEp'+numE+' .titreEp').html(tab[2]);
					$('#newEp'+numE+' .titreEp').val(tab[2]);
					
					$('#newEp'+numE).hide();
					$('#visnotEp'+numE).show();
					
					$('#newEp'+numE+' .imgLoader').hide();
					$('#newEp'+numE+' .imgEdit').show();
					$('#repOK').fadeIn(200).delay(3000).fadeOut(800);
				}else{
					$('#repErr').fadeIn(200).delay(3000).fadeOut(800);
				}
				*/
	        }
	});
	return false;
}

function finAjoutEp(ep){
	var nbP = parseInt($('#nbP'+ep).val());
	nbP++;
	$('#nbP'+ep).val(nbP);
	
	var nb = parseInt($('.nbAff').html());
	nb++;
	$('.nbAff').html(nb);
	
	$('#editEp'+ep).removeClass('nonPossede');
	$('#visEp'+ep).removeClass('nonPossede');
	$('#visEp'+ep).attr("onMouseOver","this.style.backgroundColor='#e3d5b6';");
	$('#visEp'+ep).attr("onMouseOut","this.style.backgroundColor='';");
}
function finEnleveEp(ep){
	var nbP = parseInt($('#nbP'+ep).val());
	nbP--;
	$('#nbP'+ep).val(nbP);
	
	var nb = parseInt($('.nbAff').html());
	nb--;
	$('.nbAff').html(nb);
	
	if(nbP<=0){
		$('#editEp'+ep).addClass('nonPossede');
		$('#visEp'+ep).addClass('nonPossede');
		$('#visEp'+ep).attr("onMouseOver","");
		$('#visEp'+ep).attr("onMouseOut","");
	}
}


function rechercheFilmAuto(obj,urlAjax){
	$("#div_titre_rech").hide();
	$("#divChoixFilm").slideUp('fast');
	if($("#titre").val()!=''){
		$("#loader_film").slideDown('fast');
		$("#titre_rech").html($("#titre").val());
		$("#div_titre_rech").show();
		s = $(obj).serialize();
		$.ajax({
			type: "POST",
			url: urlAjax,
			data: s,
			success: function(reponse){
				$("#loader_film").slideUp('fast');
				$("#divChoixFilm").html(reponse);
				$("#divChoixFilm").slideDown('slow');
			}
		});
	}
}

function afficheGalerie(){
	$("#galerie").html($("#galerie_img").html());
}

function afficheList_bande_annonce(){
	$("#list_bande_annonce").html($("#liste_ba").html());
}

function changerImage(obj,img,name_img){
	$("#img_choix").slideUp('slow');
	$.ajax({
		type: "POST",
		url: $(obj).attr('href'),
		data: "img="+img+"&name_img="+name_img,
		success: function(reponse){
			if(reponse!='false'){
				$("#img_choix img").attr('src', reponse+'?r='+Math.random());
				$("#img_choix").delay(500).slideDown('slow');
				$("#galerie .img_sel").removeClass("img_sel");
				$(obj).find('img').addClass("img_sel");
			}else{
				$("#img_choix").delay(200).slideDown('slow');
			}
		}
	});
}

function affichCach(id){
			/*
			$('.vis').animate({ 
				height: taille
			  }, 500 );
			  */
			$('.vis').slideUp();
			if(!$('#film_'+id).hasClass('vis')){
				$('.vis').removeClass('vis');
				$('#film_'+id).addClass('vis');
				/*
				$('#film_'+id).animate({ 
					height: $("#synopsis_full_"+id).css('height')
				  }, 500 );
				  */
				$('#film_'+id).slideDown();
			}else{
				$('.vis').removeClass('vis');
			}
	
}

function changerBA(obj, lien){
	$("#info_bandes_annonce li.video_sel").removeClass("video_sel");
	$(obj).parents("li").addClass("video_sel");
	$("#input_ba").find('input').val(lien);
}

function changeTextBA(obj){
	$("#info_bandes_annonce li.video_sel").removeClass("video_sel");
	$('#list_bande_annonce li .lien_video').each(function(index) {
		if($(obj).val()==$(this).attr('href')){
			$(this).parents("li").addClass("video_sel");
		}
	});
}
