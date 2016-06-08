<div class="inner cover">
    <h2>Question n°1</h2>
    <!-- DATE_AXIS -->
	<div id="date_axis"></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Pas de cache sur les requête IMPORTANT !
		$.ajaxSetup({ cache: false });

		$.get('webservices/nb_friend_user_by_month.php?user=<?= $_GET["user"]; ?>', function(data) {
		 	data = $.parseJSON(data);
		 	console.log(data);
			var plot3 = $.jqplot('date_axis', [data], {
			    title:'Evolution du nombre d’amis au fil du mois.', 
			    axes:{
				    xaxis:{
				        renderer:$.jqplot.DateAxisRenderer
				    }
				},
				series:[{lineWidth:4, markerOptions:{style:'none'}}]
			});
		});
	});
</script>