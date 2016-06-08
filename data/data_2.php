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

    function generateAxis(sId){
      var line1 =[['2008-06-30 8:00AM',4], ['2008-7-14 8:00AM',6.5], ['2008-7-28 8:00AM',5.7], ['2008-8-11 8:00AM',9], ['2008-8-25 8:00AM',8.2]];
      var plot2 = $.jqplot(sId, [line1], {
        title:'Customized Date Axis',
        axes:{
          xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:'%b %#d, %#I %p'},
            min:'June 16, 2008 8:00AM',
            tickInterval:'2 weeks'
          }
        },
        series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });
    }

    generateAxis('popularite');
});

</script>
<div class="inner cover">
    <div id="popularite">
      <div class="explication">
        <h2>Explications :</h2>
        <p>
          Evolution de la popularité (notation) au fil du mois
          (2 points, JQplot Date Axis, +1 point bonus si vous mettez
          la courbe de ce graphique sur
          le graphique au-dessus pour faire correspondre ces données)
        </p>
      </div>
    </div>
</div>
