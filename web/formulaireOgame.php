        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>formulaire</title>
        <style type="text/css">
        <!--
        /* mettez ici le style que vous voulez pour le formulaire */
          form {width:450px;text-align:center;}
          .pok {
          width:450px;
          background-color:gainsboro;
          border:2px outset gainsboro;
          -moz-border-radius :30px;
          -webkit-border-radius:30px;
          border-radius :30px;}
          .pok label {float:left;text-align:right;width:200px;display:block;}
        }
        -->
        </style>
        <script type="text/javascript">
        function envoiMessage(form)
        {
        var txt_message = "<center>Coordonnée : "+form.coordonnee.value
        +"<br>Pseudo : "+form.pseudo.value
        +"<br>Petit transporteur : " +form.pt.value
        +"<br>Grand transporteur : " +form.gt.value
        +"<br>Chasseur léger : "+form.cle.value
        +"<br>Chasseur lourd : "+form.cll.value
        +"<br>Croiseur : "+form.croiseur.value
        +"<br>Vaisseau de bataille : "+form.vb.value
        +"<br>Recycleur : "+form.recycleur.value
        +"<br>Bombardier : "+form.bb.value
        +"<br>Destructeur : "+form.destructeur.value
        +"<br>Etoile de la mort : "+form.edlm.value
        +"<br>Traqueur  : "+form.traqueur.value
        +"</center>";
        form.message.value = txt_message;
        form.subject.value =form.coordonnee.value+" : "+form.pseudo.value;
        }
        </script>
        </head>
        <body>
        <form action="http://allianceserenity.forumgratuit.org/post" method="post" name="post" enctype="multipart/form-data" onSubmit="envoiMessage(this)"target="_parent">
        <input type="hidden" name="lt" value="0" />
        <input type="hidden" name="mode" value="newtopic" /> <!-- Un nouveau topic sera créé -->
        <input type="hidden" name="topictype" value="0" checked="checked" /> <!-- Value 0: Sujet Normal (1 = post-it / 2 = annonce) -->
        <input type="hidden" name="message" value="" /> <!-- Contiendra le texte du message -->
        <input type="hidden" name="f" value="22" /> <!--  ID du forum dans lequel le message sera posté-->
        <input type="hidden" name="subject" value="" />
        <table class="pok" cellspacing="5" cellpadding="5">
        <tr><th>Votre flotte </th></tr>
        <tr><td><label for="coordonnee">Coordonnée de la flotte :</label><input type="text" size="25" name="coordonnee" id="coordonnee" /></td></tr>
        <tr><td><label for="pseudo">Pseudo: </label><input type="text" size="25" name="pseudo" id="pseudo" /></td></tr>
        <tr><td><label for="pt">Petit transporteur : </label><input type="text" size="25" name="pt" id="pt" /></td></tr>
		<tr><td><label for="gt">Grand transporteur : </label><input type="text" size="25" name="gt" id="gt" /></td></tr>
        <tr><td><label for="cle">Chasseur Léger  : </label><input type="text" size="25" name="cle" id="cle" /></td></tr>
        <tr><td><label for="cll">Chasseur Lourd : </label><input type="text" size="25" name="cll" id="cll" /></td></tr>
        <tr><td><label for="croiseur">Croiseur : </label><input type="text" size="25" name="croiseur" id="croiseur" /></td></tr>        
        <tr><td><label for="vb">Vaisseau de bataille : </label><input type="text" size="25" name="vb" id="vb" /></td></tr>       
	    <tr><td><label for="recycleur">Recycleur : </label><input type="text" size="25" name="recycleur" id="recycleur" /></td></tr>
        <tr><td><label for="bb">Bombardier : </label><input type="text" size="25" name="bb" id="bb" /></td></tr>
        <tr><td><label for="destructeur">Destructeur : </label><input type="text" size="25" name="destructeur" id="destructeur" /></td></tr>
        <tr><td><label for="edlm">Etoile de la mort : </label><input type="text" size="25" name="edlm" id="edlm" /></td></tr>
        <tr><td><label for="traqueur">Traqueur : </label><input type="text" size="25" name="traqueur" id="traqueur" /></td></tr>		
	  </table>
        <input type="submit" name="post" value="Envoyer" />
        </form>
        </body>
        </html>