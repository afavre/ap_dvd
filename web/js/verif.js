$(document).ready(function(){
 
      if($('#video_titre').val()!="" && $('#new').val()==1){
            verifExisteFilm('#video_titre');
      }
/*
      $('#film_titre').keyup(function(key){
          if($('#new').val()==1){
                verifExisteFilm($(this).val());
          }

      });
	  */
});


function verifExisteFilm(obj){
        $('#invalide').hide();
        $('#valide').hide();
        $('#loader_verif').show();
		key = $(obj).val();
        if(key!=""){
            //alert('rrr'+$('#fich').html());
			$.ajax({
               type: "POST",
               url: $('#fich').html(),
               data: 'value='+key+'&type='+$('#type').val(),
               success: function(reponse){
                   //alert(reponse);
                    var rep=reponse.split('/');
                    if(rep[0]=='true'){
                        $('#loader_verif').hide();
                        $('#valide').hide();
                        $('#invalide').show();
                        var affich='<span class="rouge"><b>Existe peut-etre deja !</b></span> <a class="lientitre" href="'+$('#lienvideo').html()+'/'+rep[2]+'/edit?type='+$('#type').val()+'">Modifier "'+rep[1]+'"</a>';
                        for(var i=3;i<rep.length;i=i+2){
                            affich=affich+' <span class="rouge">ou</span> <a class="lientitre" href="'+$('#lienvideo').html()+'/'+rep[i+1]+'/edit?type='+$('#type').val()+'">Modifier "'+rep[i]+'"</a>';
                        }
                        $('#textlientitre').html(affich);
                    }else{
                        $('#loader_verif').hide();
                        $('#invalide').hide();
                        $('#valide').show();
                        $('#lientitre').attr('href','');
                        $('#textlientitre').html("<span class='vert'><b>N'existe sans doute pas !</b></span>");
                    }
               }
             });
			 
        }else{
            $('#loader_verif').hide();
            $('#lientitre').attr('href','');
            $('#textlientitre').html('');
        }
}







    function setCookie(c_name, value, exdays) {
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
            document.cookie = c_name + "=" + c_value;
        }

    function getCookie(c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return unescape(y);
            }
        }
    }

    function DeleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
        }




/*







  $.ajax({
               type: "POST",
               url: 'verifUpload.php',
               data: 'keyFile='+ keyFile,
               success: function(reponse){
                   if(xhr.responseText != 'false') {
						var response = eval('('+response+')');
						
						document.getElementById('fileName').innerHTML = response.filename;
						document.getElementById('progress').innerHTML =
						  Math.round(response.current / response.total * 100) + '%';
						alert("xhs"+response);
						if(response.done != 1) {
						  verifUpload();
						}
					  } else {
						verifUpload();
					  }
               }
             });
			 
			 */