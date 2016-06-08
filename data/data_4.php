<script src="https://d3js.org/d3.v4.0.0-alpha.45.min.js"></script>
<script type="application/javascript">
$(document).ready(function(){
    var amis = {
        Homme: 0,
        Femme: 0
    }

	$.ajaxSetup({ cache: false });

	function getRequest(url, callback) {
		$.get(url, function(data) {
			data = $.parseJSON(data);
            console.log(data);
		});
	}

	function generateBarChart(idDiv, data)
	{
        //console.log($.(data));
        //data = [4, 8, 15, 16, 23, 42];
        
		d3.select(idDiv)
            .selectAll("div")
            .data(d3.entries(data))
            .enter().append("div")
            .style("width", function(d) { return d.value-1 + "%"; })
            .attr("class", function(d) {
                if (d.key == ["Homme"] )
                {
                    return "blue";
                }
                if (d.key == ["Femme"])
                {
                    return "pink";
                }
            })
            .text(function(d) { return d.value + "% d'amis " + d.key; });
        
    
	};
    
    $.get('webservices/liste_amis_user.php?user=<?= $_GET['user']; ?>', function(data) {
        data = $.parseJSON(data);
        
        var tab_user = ''
            
        $.each(data, function(i, tab_relation) {
           tab_user += tab_relation[1]+',';
        });
        
        tab_user = tab_user.substring(0, tab_user.length-1);
        
        $.get('webservices/infos_user.php?user='+tab_user, function(data_1) {
            data_1 = $.parseJSON(data_1);
                    
            $.each(data_1, function(j, tab_user) {
                if(tab_user[7] == 1)
                    amis.Homme++;
                else
                    amis.Femme++;
            });
            
            amis.Homme = amis.Homme/data.length*100;
            amis.Femme = amis.Femme/data.length*100;
            generateBarChart('.chart', amis);
        });
    });
    
});
</script>
<style>
    
    .blue{
        background-color: steelblue;
    }
    
    .pink{
        background-color: #f56c84;
    }

.chart div {
    font: 15px sans-serif;
    
    text-align: right;
    padding: 3px;
    margin: 20px 1px;
    color: white;
    display: inline-block;
    height: 50px;
    line-height: 50px;
    text-align: center;
}

</style>

<div class="inner cover">
    <h2>Pourcentage d’amis masculin et féminin</h2>
    <div class="chart"></div>
</div>