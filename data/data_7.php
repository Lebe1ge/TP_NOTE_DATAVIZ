<script src="https://d3js.org/d3.v4.0.0-alpha.45.min.js"></script>
<script type="application/javascript">
$(document).ready(function(){
  var popularite = {
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
    var tab_user = [];
    var user_notation = [];

	$.ajaxSetup({ cache: false });

	function getRequest(url, callback) {
		$.get(url, function(data) {
			data = $.parseJSON(data);
            console.log(data);
		});
	}

	function generateScatterPlot(idDiv, data)
	{

    var dataset = [];
    var tmp = [];
      $.each( data, function(tranche, tab_tranche){
        $.each( tab_tranche, function(sexe, tab_age){
          console.log(tab_age);
          if(sexe === "Homme")
            tmp.push(tab_age);
          else
            tmp.push(tab_age)
        });
        dataset.push(tmp);
      });
      console.log(tmp);

      console.log(dataset);

        var xScale = d3.scale.linear()
      		.domain([0, d3.max(dataset, function(d) { return d[0]; })])
              .range([padding, w - padding * 2]);
      	var yScale = d3.scale.linear()
              .domain([0, d3.max(dataset, function(d) { return d[1]; })])
              .range([h - padding, padding]);

      	// Définit l'axe des abscisses
      	var xAxis = d3.svg.axis()
              .scale(xScale)
              .orient("bottom")
      		.ticks(5);

      	// Définit l'axe des ordonnées
      	var yAxis = d3.svg.axis()
              .scale(yScale)
              .orient("left")
              .ticks(5);

      	// Créer l'élément SVG
      	var svg = d3.select("body")
              .append("svg")
              .attr("width", w)
              .attr("height", h);

      	// Créer les points (des petits cercles) en utilisant les coordonnées du dataset
      	svg.selectAll("circle")
      		.data(dataset)
      		.enter()
      		.append("circle")
      		.attr("cx", function(d) {
      			return xScale(d[0]);
      		})
      		.attr("cy", function(d) {
      			return yScale(d[1]);
      		})
      		.attr("r", 5);

      	// Créer les labels
      	svg.selectAll("text")
      		.data(dataset)
      		.enter()
      		.append("text")
      		.text(function(d) {
      			return d[0] + "," + d[1];
      		})
      		.attr("x", function(d) {
      			return xScale(d[0]) - 5;
      		})
      		.attr("y", function(d) {
      			return yScale(d[1]) + 20;
      		})
      		.attr("font-family", "sans-serif")
      		.attr("font-size", "11px")
      		.attr("fill", "red");

      	// Créer les axes
      	// Axe des abscisses
      	svg.append("g")
      		.attr("class", "axis")  // Assigne la classe "axis"
      		.attr("transform", "translate(0," + (h - padding) + ")")
      		.call(xAxis);

      	// Axe des ordonnées
      	svg.append("g")
      		.attr("class", "axis")
      		.attr("transform", "translate(" + padding + ",0)")
      		.call(yAxis);

	};

    $.get('webservices/liste_amis_user.php?user=<?= $_GET['user']; ?>', function(data) {
        data = $.parseJSON(data);

        $.each(data, function(i, tab_relation) {
           tab_user += tab_relation[1]+',';
        });

        tab_user = tab_user.substring(0, tab_user.length-1);
        $.get('webservices/notations_user.php?user='+ tab_user, function(data_1) {
            data_1 = $.parseJSON(data_1);

            $.each(data_1, function(j, tab_notation) {
                user_notation += tab_notation[0]+',';
            });
            user_notation = user_notation.substring(0, user_notation.length-1);
            $.get('webservices/infos_user.php?user='+ user_notation, function(data_2) {
              data_2 = $.parseJSON(data_2);
              $.each(data_2, function(j, tab_user) {

                  if(tab_user[6] >= 18 && tab_user[6] <= 21){
                      if(tab_user[7] == 1)
                        popularite.adulte1.Homme++;
                      else
                        popularite.adulte1.Femme++;
                  }
                  else if (tab_user[6] >= 22 && tab_user[6] <= 25) {
                    if(tab_user[7] == 1)
                      popularite.adulte2.Homme++;
                    else
                      popularite.adulte2.Femme++
                  }
                  else if (tab_user[6] >= 26 && tab_user[6] <= 29) {
                    if(tab_user[7] == 1)
                      popularite.adulte3.Homme++;
                    else
                      popularite.adulte3.Femme++
                  }
              });

            });
            generateScatterPlot('.nuage', popularite);
        });
    });

});
</script>
<style>
  h1 {
  	font-family: Calibri;
      font-style: italic;
      color: teal;
  }

  .axis path,
  .axis line {
      fill: none;
      stroke: black;
      shape-rendering: crispEdges;
  }

  .axis text {
      font-family: sans-serif;
      font-size: 11px;
  }
</style>

<div class="inner cover">
    <h2>Répartition de votre popularité (notation) auprès de vos amis par tranche d’âge</h2>
    <div class="nuage"></div>
</div>
