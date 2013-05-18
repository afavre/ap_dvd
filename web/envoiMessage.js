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