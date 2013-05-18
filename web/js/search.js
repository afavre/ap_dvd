/*
$(document).ready(function(){
  $('#searchform input[type="submit"]').hide();

  $('#search_keywords').keyup(function(key){
      if(this.value.length >= 3 || $('#search').html()!=null){
		  $('.resultat').hide();
		  $('.loader').show();
          $('#content').load(
                    $(this).parents('form').attr('action'),
                    {query: this.value},
                    function() { $('.loader').hide();$('.resultat').show(); }
          );
	}
  });
});
*/
