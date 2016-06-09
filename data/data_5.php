<style type="text/css">
	.blue{
        background-color: steelblue;
    }
    
    .pink{
        background-color: #f56c84;
    }
</style>

<div class="inner cover">
    <h2>Question n°5 : notation des <span>filles</span></h2>
    <!-- PIE CHART -->
	<div id="pie_chart"></div>

	<p class="text-center">
		<a href="#" data-sexe="0" class="btn pink" >Notation des filles</a>
		<a href="#" data-sexe="1" class="btn blue" >Notation des garçons</a>
	</p>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Pas de cache sur les requête IMPORTANT !
		$.ajaxSetup({ cache: false });

		getNotation(0);

		$('.btn').click(function(e){
			e.preventDefault();
			sexe = $(this).attr('data-sexe');

			if(sexe == 0){
				$('h2 span').html('filles');
			}else if(sexe == 1){
				$('h2 span').html('garçons');
			}
			getNotation(sexe);
		});
	});

	function getNotation(sexe){

		$.get('webservices/notation_by_sexe.php?user=<?= $_GET["user"]; ?>&sexe=' + sexe, function(data) {
		 	data = $.parseJSON(data);
		 	console.log(data);
			
			var plot1 = $.jqplot('pie_chart', [data], {
		        gridPadding: {top:0, bottom:38, left:0, right:0},
		        seriesDefaults:{
		            renderer:$.jqplot.PieRenderer, 
		            trendline:{ show:false }, 
		            rendererOptions: { padding: 8, showDataLabels: true }
		        },
		        legend:{
		            show:true,
		            rendererOptions: {
		                numberRows: 6
		            }, 
		            location:'e',
		            marginTop: '15px'
		        }       
		    });
		});
	}
</script>


