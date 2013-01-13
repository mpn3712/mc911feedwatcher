<html>
<head>
	
	<title>Wham No Spell Good</title>
	
	<meta name="description" content="Graph of spelling quantity on 13wham.com">
	<meta name="keywords" content="Spelling, quantity, 13wham, wham, whamnospellgood">
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<meta charset="utf-8">
	<style>

	body{
		/*background-image:url('/subtle_grunge.png');
		background-repeat:repeat-y repeat-x;*/
	}

	div.topwrapper{
		width: 900px;
		margin: auto;
	}

	div.graph {
	  font: 10px sans-serif;
	}
	
	div.header {
	  text-align:center;
	}

	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	.bar {
	  fill: steelblue;
	}

	.x.axis path {
	  display: none;
	}

	</style>

</head>
<body>

	<div class="top">
		
		<div class="topwrapper">
		
			<div class="header">
				
				<?php 
					
					require_once("Database.class.php");
					$db = new Database();
					if( $_GET['eventtypeid'] == "" )
					{
						echo "You must pass in a eventtypeid, like this: http://monroe911.mycodespace.net/visdata.php?eventtypeid=13";
					}
					else
					{
						echo '<h2>Graph of daily incidents for event: "';
						echo $db->GetEventTextFromID($_GET['eventtypeid']);
						echo '"</h2>';
					}
				?>
				
				</h2>

			</div>

			<div class="graph" id="graph">

				<script src="http://d3js.org/d3.v3.min.js"></script>
				<script>

				var margin = {top: 20, right: 20, bottom: 30, left: 40},
					width = 900 - margin.left - margin.right,
					height = 450 - margin.top - margin.bottom;

				//var formatPercent = d3.format(".0%");

				var x = d3.scale.ordinal()
					.rangeRoundBands([0, width], .1);

				var y = d3.scale.linear()
					.range([height, 0]);

				var xAxis = d3.svg.axis()
					.scale(x)
					.orient("bottom");

				var yAxis = d3.svg.axis()
					.scale(y)
					.orient("left")
					//.tickFormat(formatPercent);

				var svg = d3.select("#graph").append("svg")
					.attr("width", width + margin.left + margin.right)
					.attr("height", height + margin.top + margin.bottom)
				  .append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
					.attr("class", "chart");

				var apiurl = "eventd3api.php?eventtypeid=<?php echo $_GET['eventtypeid'];?>&startdate=2012-1-1";
				//var apiurl = "data.tsv";

				//alert(apiurl);

				d3.tsv(apiurl, function(error, data) {

				  data.forEach(function(d) {
					d.quantity = +d.quantity;
				  });

				  x.domain(data.map(function(d) { return d.day; }));
				  y.domain([0, d3.max(data, function(d) { return d.quantity; })]);

				  svg.append("g")
					  .attr("class", "x axis")
					  .attr("transform", "translate(0," + height + ")")
					  .call(xAxis);

				  svg.append("g")
					  .attr("class", "y axis")
					  .call(yAxis)
					.append("text")
					  .attr("transform", "rotate(-90)")
					  .attr("y", 6)
					  .attr("dy", ".71em")
					  .style("text-anchor", "end")
					  .text("quantity");

				  svg.selectAll(".bar")
					  .data(data)
					.enter().append("rect")
					  .attr("class", "bar")
					  .attr("x", function(d) { return x(d.day); })
					  .attr("width", x.rangeBand())
					  .attr("y", function(d) { return y(d.quantity); })
					  .attr("height", function(d) { return height - y(d.quantity); });

				});

				</script>

			</div>
			
		</div>
		
	</div>

</body>
</html>