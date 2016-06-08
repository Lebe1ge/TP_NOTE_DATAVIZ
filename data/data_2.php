<script>
$(document).ready(function(){
  	// Pas de cache sur les requ�te IMPORTANT !
  	$.ajaxSetup({ cache: false });

  	/***
  		On d�finit ici les fonctions de base qui vont nous servir � la r�cup�ration des donn�es
  		Je ne d�finis que le GET ici, mais il est possible d'utiliser POST pour r�cup�rer ses donn�es (on le verra dans un prochain TP)
  	****/
  	function getRequest(url, callback) {
  		$.get(url, function(data) {
  			data = $.parseJSON(data);
  			callback(data);
  		});
  	}

    function generateAxis(sId, data){

      console.log(data);
      var plot3 = $.jqplot(sId, [data], {
			    title:'Evolution de la popularité (notation) au fil du mois',
			    axes:{
				    xaxis:{
				        renderer:$.jqplot.DateAxisRenderer
				    }
				},
				series:[{lineWidth:4, markerOptions:{style:'none'}}]
			});
    }



    getRequest('webservices/popularite.php?user=<?= $_GET['user'] ?>', function(data) {
      generateAxis('popularite', data);
  	});
});

</script>
<div class="inner cover">
    <div id="popularite"></div>
</div>
