<script src="https://d3js.org/d3.v4.0.0-alpha.45.min.js"></script>
<script type="application/javascript">
$(document).ready(function(){
    var message = {
        Amis: 0,
        Inconnue: 0
    }
    var tab_user = [];

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
                if (d.key == ["Amis"] )
                {
                    return "blue";
                }
                if (d.key == ["Inconnue"])
                {
                    return "pink";
                }
            })
            .text(function(d) { return d.value + "% d'" + d.key; });


	};

    $.get('webservices/liste_amis_user.php?user=<?= $_GET['user']; ?>', function(data) {
        data = $.parseJSON(data);


        $.each(data, function(i, tab_relation) {
            tab_user.push(tab_relation[1]);
        });
        console.log(tab_user);

        $.get('webservices/messages_user.php?user=<?= $_GET['user']; ?>', function(data_1) {
            data_1 = $.parseJSON(data_1);

            $.each(data_1, function(j, tab_message) {
                if($.inArray(tab_message[1], tab_user) !== -1){
                    message.Amis++;
                }else
                    message.Inconnue++;
            });

            message.Amis = message.Amis/data_1.length*100;
            message.Inconnue = message.Inconnue/data_1.length*100;

            generateBarChart('.chart', message);
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
