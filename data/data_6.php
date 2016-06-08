<script src="https://d3js.org/d3.v4.0.0-alpha.45.min.js"></script>
<script type="application/javascript">
$(document).ready(function(){
    var amis = {
        adulte1: {
          Homme: 0,
          Femme:0
        },
        adulte2:{
          Homme: 0,
          Femme:0
        },
        adulte3: {
          Homme: 0,
          Femme:0
        }
    }

	$.ajaxSetup({ cache: false });

	function getRequest(url, callback) {
		$.get(url, function(data) {
			data = $.parseJSON(data);
		});
	}

	function generateBarChart(idDiv, data)
	{
      // Can specify a custom tick Array.
      // Ticks should match up one for each y value (category) in the series.
      var ticks = ['18 à 21 ans', '22 à 25 ans' ,'26 à 29 ans'];
      var homme = [];
      var femme = [];

      $.each( data, function(tranche, tab_tranche){
        $.each( tab_tranche, function(sexe, tab_age){
          if(sexe === "Homme")
            homme.push(tab_age);
          else
            femme.push(tab_age)
        });
      });

      var plot1 = $.jqplot('chart', [homme, femme], {
          // The "seriesDefaults" option is an options object that will
          // be applied to all series in the chart.
          seriesDefaults:{
              renderer:$.jqplot.BarRenderer,
              rendererOptions: {fillToZero: true}
          },
          // Custom labels for the series are specified with the "label"
          // option on the series option.  Here a series option object
          // is specified for each series.
          series:[
              {label:'Homme'},
              {label:'Femme'},
          ],
          // Show the legend and put it outside the grid, but inside the
          // plot container, shrinking the grid to accomodate the legend.
          // A value of "outside" would not shrink the grid and allow
          // the legend to overflow the container.
          legend: {
              show: true,
              placement: 'outsideGrid'
          },
          highlighter: {
            show: true,
            sizeAdjust: 7.5,
          },
          axes: {
              // Use a category axis on the x axis and use our custom ticks.
              xaxis: {
                  renderer: $.jqplot.CategoryAxisRenderer,
                  ticks: ticks
              },
              // Pad the y axis just a little so bars can get close to, but
              // not touch, the grid boundaries.  1.2 is the default padding.
              yaxis: {
                  padMin: 0,
                  padMax: 3,
                  tickOptions: {formatString: '%d %'}
              }
          }
      });


	};

    $.get('webservices/liste_amis_user.php?user=<?= $_GET['user']; ?>', function(data) {
        data = $.parseJSON(data);

        var tab_user = '';

        $.each(data, function(i, tab_relation) {
           tab_user += tab_relation[1]+',';
        });

        tab_user = tab_user.substring(0, tab_user.length-1);

        $.get('webservices/infos_user.php?user='+tab_user, function(data_1) {
            data_1 = $.parseJSON(data_1);
            $.each(data_1, function(j, tab_user) {

                if(tab_user[6] >= 18 && tab_user[6] <= 21){
                    if(tab_user[7] == 1)
                      amis.adulte1.Homme++;
                    else
                      amis.adulte1.Femme++;
                }
                else if (tab_user[6] >= 22 && tab_user[6] <= 25) {
                  if(tab_user[7] == 1)
                    amis.adulte2.Homme++;
                  else
                    amis.adulte2.Femme++
                }
                else if (tab_user[6] >= 26 && tab_user[6] <= 29) {
                  if(tab_user[7] == 1)
                    amis.adulte3.Homme++;
                  else
                    amis.adulte3.Femme++
                }
            });

            amis.adulte1.Homme = amis.adulte1.Homme/data.length*100;
            amis.adulte2.Homme = amis.adulte2.Homme/data.length*100;
            amis.adulte3.Homme = amis.adulte3.Homme/data.length*100;

            amis.adulte1.Femme = amis.adulte1.Femme/data.length*100;
            amis.adulte2.Femme = amis.adulte2.Femme/data.length*100;
            amis.adulte3.Femme = amis.adulte3.Femme/data.length*100;


            generateBarChart('chart', amis);
        });
    });

});
</script>

<div class="inner cover">
    <h2>Répartition des amis par tranche d’âge (18-21, 22-25, 26-29) et par sexe</h2>
    <div id="chart"></div>
</div>
