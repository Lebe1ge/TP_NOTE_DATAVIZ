<style type="text/css">
	.blue{
        background-color: steelblue;
    }
    
    .pink{
        background-color: #f56c84;
    }
</style>

<div class="inner cover">
    <h2>Question n°7: Notations <span></span> par Tranche d'age</h2>
    <!-- data_axis -->
	<div id="data_axis"></div>

	<p class="text-center">
		<a href="#" data-sexe="null" class="btn btn-default" >Notation des deux</a>
		<a href="#" data-sexe="0" class="btn pink" >Notation des filles</a>
		<a href="#" data-sexe="1" class="btn blue" >Notation des garçons</a>
	</p>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Pas de cache sur les requête IMPORTANT !
		$.ajaxSetup({ cache: false });

		$('.btn').click(function(e){
			e.preventDefault();
			sexe = $(this).attr('data-sexe');

			if(sexe == 0){
				$('h2 span').html('des filles');
			}else if(sexe == 1){
				$('h2 span').html('des garçons');
			}else{
				$('h2 span').html('');
			}
			getNotation(sexe);
		});

		getNotation(null);
	});


	function getNotation(sexe){
		$.get('webservices/notation_by_age.php?user=<?= $_GET["user"]; ?>&sexe=' + sexe, function(data) {
		 	data = $.parseJSON(data);
			var plot3 = $.jqplot('data_axis', [data], {
			    title:'Répartition de votre popularité (notation) auprès de vos amis par tranche d’âge.',
			    axes:{
				    xaxis:{ 
          				tickInterval: 1
				    },
				    yaxis:{
				    	tickInterval: 1
				    }
				},
				seriesDefaults: {    
                  showLine:false
                },
				series:[{lineWidth:4, markerOptions:{style:'none'}}]
			});
		});
	}
</script>


