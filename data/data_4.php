<script type="application/javascript">
$(document).ready(function(){

	$.ajaxSetup({ cache: false });

	function getRequest(url, callback) {
		$.get(url, function(data) {
			data = $.parseJSON(data);
			callback(data);
		});
	}

	function generateBarChart(idDiv, data)
	{
		d3.select(idDiv).selectAll("div")
			.data(data)
			.enter()
			.append("div")
			.attr("class", "bar")
			.style("height", function (res) {
				var barHeight = res * 5;
				return barHeight + "px";
			});
	};
    
	getRequest('webservices/liste_amis_user.php?user=<?= $_GET['user']; ?>', function(data) {
		console.log(data);
		generateBarChart('d3test', data);
	});

});
</script>
<style>

.chart div {
  font: 10px sans-serif;
  background-color: steelblue;
  text-align: right;
  padding: 3px;
  margin: 1px;
  color: white;
}

</style>

<div class="inner cover">
    <h2>Pourcentage d’amis masculin et féminin</h2>
    <div id="d3_bar_4">
        <div class="chart">
            <div style="width: 40px;">4</div>
            <div style="width: 80px;">8</div>
            <div style="width: 150px;">15</div>
            <div style="width: 160px;">16</div>
            <div style="width: 230px;">23</div>
            <div style="width: 420px;">42</div>
        </div>
    </div>
</div>