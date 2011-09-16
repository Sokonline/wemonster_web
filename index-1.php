<?php
$devName = $_GET['devname'];

echo "<html><head><meta http-equiv=\"refresh\" content=\"30;url=index.php?devname=$devName\">";

//All variables in php are named $variablename, and can all be defined anywhere within the document.
//They also don't have types, so any variable can take any value.

/*************
Because values that are echoed are written into a html file, you can echo out
Javascript,
and put in php variables where they are needed. This would be done like:

echo "Javascript code variable=" $variableToBeAdded;
*************/

//This is essentially the same as #include in C-based languages- gets the specified file and allows use of it's functionality
require("include.php");

// This connects to server and selects the database. The variables used here are defined in "include.php"
$link = mysql_connect("localhost", "wrbrep_test", "playmob!")or die("cannot connect");  
mysql_select_db("wrbrep_nimbusDB", $link)or die("cannot select DB");

//inits graph colour
$currentgraphcolour = 0;

//HARDCODED devID of developer using portal
$currentdevID = "e328ae7862f1edb9fe9c01636dc0bb3b";

$sql = "SELECT `devID` FROM `developers` WHERE name='$devName'";
$result = mysql_query($sql, $link);

while($values = mysql_fetch_array($result, MYSQL_ASSOC)) {
$currentdevID = $values['devID'];
}

$distinctdeveloper_sql = "SELECT DISTINCT name FROM `developers` WHERE devID='$currentdevID'";
$distinctdeveloper_result = mysql_query($distinctdeveloper_sql, $link);
//get actual developer name
while($values = mysql_fetch_array($distinctdeveloper_result, MYSQL_ASSOC)) {
$currentdevName= $values['name'];
}

echo "</br><p>&#160;&#160;Number of items sold over time </p>";
//SQL = finds all fields from the purchases table, and then runs the query, storing the returned value in $result
$items_sold_sql = "SELECT * FROM `purchases`";
$items_sold_result = mysql_query($items_sold_sql, $link);

$distinctitems_sql = "SELECT DISTINCT a.itemID FROM `purchases` a WHERE a.gameID in (SELECT b.gameID FROM `games` b WHERE b.devID = '$currentdevID')";
$distinctitems_result = mysql_query($distinctitems_sql, $link);

//This finds the number of rows that were returned, so that you can check that the query has worked properly
$items_sold_rows = mysql_num_rows($items_sold_result);

//draws general bar chart
echo "<body onLoad=\"loadgraphs();\">
	<article>	
		<canvas id=\"graphitemsSpace\" width=\"550\" height=\"200\"></canvas>		
	</article>
</body>";

$distinctitems_rows = mysql_num_rows($distinctitems_result);
echo "<p>There are $distinctitems_rows different item(s).<p>";

//count total sales for each distinct item
if ($distinctitems_rows!= 0) {

//inits php item array
$currentitempos = 0;

//get current distinct itemID
while($values = mysql_fetch_array($distinctitems_result, MYSQL_ASSOC)) {
$currentID = $values['itemID'];

//select currentID
$currentitem_sold_sql = "SELECT * FROM `purchases` WHERE itemID='$currentID' ";
$currentitem_sold_result = mysql_query($currentitem_sold_sql, $link);

$currentitems_rows = mysql_num_rows($currentitem_sold_result);

//$graphcolours = array("#000000","#FF0000","#00FF00","#0000FF","#FFFF00","#00FFFF","#FF00FF","#C0C0C0","#FFFFFF");

//count total sales & draw graph
//echo "<html>\n";
$total = 0;
while($values = mysql_fetch_array($currentitem_sold_result, MYSQL_ASSOC)) {
//echo "<p>value is " . $values['purchase_count'] . "</p>";
//$total += $values['purchase_count'];
$total++;
}
//match itemID with actual name 
$currentitemname_sql = "SELECT DISTINCT name FROM `items` WHERE itemID='$currentID' ";
$currentitemname_result = mysql_query($currentitemname_sql, $link);
while($values = mysql_fetch_array($currentitemname_result, MYSQL_ASSOC)) {
//echo "<p>name is " . $values['name'] . "</p>";
$currentitemname = $values['name'];
}
//echo "<p>There are $total '$currentitemname' items<p>";
if (strlen($currentID) > 16) {
  $currentID = substr($currentID,0,16);
}
$itemdata[$currentitempos] = "$currentitemname,$total";
$currentitempos++;
}
//echo "</html>\n";
}else {
echo "Leaderboard not found";
}
/*
if($items_sold_rows!= 0) {

// This outputs the webpage- anything that is echoed is essentially written into a html file that is then loaded by the browser
echo "<html>\n";

echo "<table>\n";

echo "<tr><td><p>ItemID</p></td><td><p>date</p></td><td><p>purchase_count</p></td></tr>";

//The returned value of the SQL is an array of arrays, so this puts each individual array into $values,
//where it can then be accessed as in $values['itemID'];

while($values = mysql_fetch_array($items_sold_result, MYSQL_ASSOC)) {

echo "<tr><td>" . $values['itemID'] . "</td><td>" . $values['date'] . "</td><td>" . $values['purchase_count'] . "</td></tr>\n";

}
        
echo "</table>\n</html>";
} else {
echo "Leaderboard not found";
}*/

/********************
UNCOMMENT THIS
********************/
//echo "<h1>Item sales over days </h1>";
//HARDCODED current item being investigated
$itemtoconsider = "017242463b20052f1148071341d56c41";
$item_sold_sql = "SELECT itemID FROM `purchases` WHERE itemID='$itemtoconsider'";
$item_sold_result = mysql_query($item_sold_sql, $link);

$distinctdays_sql = "SELECT DISTINCT date FROM `purchases`";
$distinctdays_result = mysql_query($distinctdays_sql, $link);

//Get all fields present for that particular item
$item_sold_rows = mysql_num_rows($item_sold_result);
//echo "<p><b>There are $item_sold_rows $itemtoconsider entries</b><p>";

//match itemID with actual name 
$presentitemname_sql = "SELECT DISTINCT name FROM `items` WHERE itemID='$itemtoconsider' ";
$presentitemname_result = mysql_query($presentitemname_sql, $link);
while($values = mysql_fetch_array($presentitemname_result, MYSQL_ASSOC)) {
//echo "<p>name is " . $values['name'] . "</p>";
$presentitemname = $values['name'];
}

$distinctdays_rows = mysql_num_rows($distinctdays_result);
/********************
UNCOMMENT THIS
********************/
//echo "<p><b>There are $distinctdays_rows different day(s) for $presentitemname</b><p>";

//draws days bar chart
/********************
UNCOMMENT THIS
********************/
/*
echo "<body>
	<article>	
		<canvas id=\"graphitemsSpaceDays\" width=\"800\" height=\"400\"></canvas>		
	</article>
</body>";
*/

//count total sales for an item per day
if ($distinctdays_rows!= 0) {

//inits php item array
$currentdayitempos = 0;

//get current distinct date/day
while($values = mysql_fetch_array($distinctdays_result, MYSQL_ASSOC)) {
$currentID = $values['date']; //DATEPART(yy, date) DATEPART(mm, date) DATEPART(dd, date) 

//select currentID
$currentday_item_sql = "SELECT * FROM `purchases` WHERE date='$currentID' ";
$currentday_item_result = mysql_query($currentday_item_sql, $link);

$currentday_item = mysql_num_rows($currentday_item_result);

//count total sales & draw graph
/********************
UNCOMMENT THIS
********************/
//echo "<html>\n";
$total = 0;
while($values = mysql_fetch_array($currentday_item_result, MYSQL_ASSOC)) {
//echo "<p>value is " . $values['purchase_count'] . "</p>";
//$total += $values['purchase_count'];
$total++;
}
/********************
UNCOMMENT THIS
********************/
//echo "<p>There are $total '$currentID' items<p>";
if (strlen($currentID) > 16) {
  $currentID = substr($currentID,0,16);
}
$itemdaydata[$currentdayitempos] = "$currentID,$total";
$currentdayitempos++;

}
/********************
UNCOMMENT THIS
********************/
//echo "</html>\n";
}else {
echo "Leaderboard not found";
}

//inits graph colour
$currentgraphcolour = 0;

/********************
UNCOMMENT THIS
********************/
//echo "<h1>Number of players using the game </h1>";
//SQL = finds all fields from the purchases table, and then runs the query, storing the returned value in $result
///$players_sql = "SELECT * FROM `games`";
$players_sql = "SELECT * FROM `usergames`";
$players_result = mysql_query($players_sql, $link);

$distinctgames_sql = "SELECT DISTINCT gameID FROM `usergames` a WHERE a.gameID in (SELECT b.gameID FROM `games` b WHERE b.devID = '$currentdevID')";
//$distinctgames_sql = "SELECT DISTINCT gameID FROM `usergames`";
$distinctgames_result = mysql_query($distinctgames_sql, $link);

//This finds the number of rows that were returned, so that you can check that the query has worked properly
$players_rows = mysql_num_rows($players_result);

$distinctgames_rows = mysql_num_rows($distinctgames_result);
/********************
UNCOMMENT THIS
********************/
//echo "<p><b>There are $distinctgames_rows different game(s)</b></p>";

//draws bar chart
/********************
UNCOMMENT THIS
********************/
/*
echo "<body>
	<article>	
		<canvas id=\"graphplayerSpace\" width=\"800\" height=\"400\"></canvas>		
	</article>
</body>";
*/

//count total count for each distinct game
if ($distinctgames_rows!= 0) {

//inits php player array
$currentplayerpos = 0;

//get current distinct name
while($values = mysql_fetch_array($distinctgames_result, MYSQL_ASSOC)) {
///$currentID = $values['name'];
$currentID = $values['gameID'];

//select currentID
///$currentgame_sql = "SELECT * FROM `games` WHERE name='$currentID' ";
$currentgame_sql = "SELECT * FROM `usergames` WHERE gameID='$currentID' ";
$currentgame_result = mysql_query($currentgame_sql, $link);

$currentgame_rows = mysql_num_rows($currentgame_result);

//count total sales & draw graph
/********************
UNCOMMENT THIS
********************/
//echo "<html>\n";
$total = 0;
while($values = mysql_fetch_array($currentgame_result, MYSQL_ASSOC)) {
//echo "<p>game is " . $values['name'] . "</p>";
$total += 1;
}
//match gameID with actual name 
$currentgamename_sql = "SELECT DISTINCT name FROM `games` WHERE gameID='$currentID' ";
$currentgamename_result = mysql_query($currentgamename_sql, $link);
while($values = mysql_fetch_array($currentgamename_result, MYSQL_ASSOC)) {
//echo "<p>name is " . $values['name'] . "</p>";
$currentgamename = $values['name'];
}
/********************
UNCOMMENT THIS
********************/
//echo "<p>There are $total '$currentgamename' players<p>";
$playerdata[$currentplayerpos] = "$currentgamename,$total";
$currentplayerpos++;

}
/********************
UNCOMMENT THIS
********************/
//echo "</html>\n";
}else {
echo "Leaderboard not found";
}
/*
if($players_rows!= 0) {

// This outputs the webpage- anything that is echoed is essentially written into a html file that is then loaded by the browser
echo "<html>\n";

echo "<table>\n";

echo "<tr><td><p>userID</p></td><td><p>gameID</p></td></tr>";

//The returned value of the SQL is an array of arrays, so this puts each individual array into $values,
//where it can then be accessed as in $values['itemID'];

while($values = mysql_fetch_array($players_result, MYSQL_ASSOC)) {

echo "<tr><td>" . $values['userID'] . "</td><td>" . $values['gameID'] . "</td></tr>\n";

}
        
echo "</table>\n</html>";

} else {
echo "Leaderboard not found";
}*/
?>

<head>
	<meta charset=utf-8>
	<title>PlayMob Data Visualisation (Giverboard)</title>
	<meta name="keyword" content="play mob playmob board giverboard charities charity" />
	<meta name="description" content="site for giverboard" />
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script src="j/excanvas.js"></script>	
	<![endif]-->
	<style>
		#graphSpace { margin-left:80px; }
	</style>
	
	<script type="text/javascript">
                //add functions here
                function loadgraphs() {
                         itemsgraph();
                         itemsDaysGraph();
                         playergraph();
                }
                //draw graph for items sold over time
                function itemsgraph() {							
			var graphCanvas = document.getElementById('graphitemsSpace');
			// Ensure that the element is available within the DOM
			if (graphCanvas && graphCanvas.getContext) {
				// Open a 2D context within the canvas
				var context = graphCanvas.getContext('2d');

                                //Read data from php array $data
                                var jsData = ["<?php echo join("\", \"", $itemdata); ?>"];

				// Bar chart data
                                var size = "<?= $currentitempos ?>";
				var data = new Array(size);
                                
                                for(i=0; i<size; i++)
                                {
                                  data[i] = jsData[i];
                                }

				// Draw the bar chart
				drawBarChart(context, data, 50, 100, (graphCanvas.height - 20), 50);
			}
		}
                //draw graph an item sold over a number of days
                function itemsDaysGraph() {							
			var graphCanvas = document.getElementById('graphitemsSpaceDays');
			// Ensure that the element is available within the DOM
			if (graphCanvas && graphCanvas.getContext) {
				// Open a 2D context within the canvas
				var context = graphCanvas.getContext('2d');

                                //Read data from php array $data
                                var jsData = ["<?php echo join("\", \"", $itemdaydata); ?>"];

				// Bar chart data
                                var size = "<?= $currentdayitempos ?>";
				var data = new Array(size);
                                
                                for(i=0; i<size; i++)
                                {
                                  data[i] = jsData[i];
                                }

				// Draw the bar chart
				drawBarChart(context, data, 50, 100, (graphCanvas.height - 20), 50);
			}
		}
                //draw graph for number of players using the game
		function playergraph() {			
			var graphCanvas = document.getElementById('graphplayerSpace');
			// Ensure that the element is available within the DOM
			if (graphCanvas && graphCanvas.getContext) {
				// Open a 2D context within the canvas
				var context = graphCanvas.getContext('2d');

                                //Read data from php array $data
                                var jsData = ["<?php echo join("\", \"", $playerdata); ?>"];

				// Bar chart data
                                var size = "<?= $currentplayerpos ?>";
				var data = new Array(size);
                                
                                for(i=0; i<size; i++)
                                {
                                  data[i] = jsData[i];
                                }

				// Draw the bar chart
				drawBarChart(context, data, 50, 100, (graphCanvas.height - 20), 50);
			}
		}
		
		// drawBarChart - draws a bar chart with the specified data
		function drawBarChart(context, data, startX, barWidth, chartHeight, markDataIncrementsIn) {
			// Draw the x and y axes
			context.lineWidth = "1.0";
			var startY = 380;
			drawLine(context, startX, startY, startX, 30); 
			drawLine(context, startX, startY, 570, startY);			
			context.lineWidth = "0.0";
			var maxValue = 0;
                        var currentgraphcolour = 0;
                        //choose colours for bars
                        var graphcolours = new Array("#703445", "#B90000", "#FFFFFF", "#A7CCFF", "#0061F4");
			for (var i=0; i<data.length; i++) {
				// Extract the data
				var values = data[i].split(",");
				var name = values[0];
				var height = parseInt(values[1]);
				if (parseInt(height) > parseInt(maxValue)) maxValue = height;
				// Write data to chart
				context.fillStyle = graphcolours[currentgraphcolour];
                                currentgraphcolour++;
height *= 2;
                                if (currentgraphcolour > 8) currentgraphcolour = 0;
				drawRectangle(context, startX + (i * barWidth) + i, (chartHeight - height), barWidth, height, true);
				// Add the column title to the x-axis
				context.textAlign = "left";
				context.fillStyle = "#000";
				context.fillText(name, startX + (i * barWidth) + i, chartHeight + 10, 200);				

context.fillText(height / 2, startX + (i * barWidth) + i, chartHeight - (height + 5), 200);				
			}
			// Add some data markers to the y-axis
			var numMarkers = Math.ceil(maxValue / markDataIncrementsIn);
			context.textAlign = "right";
			context.fillStyle = "#000";
			var markerValue = 0;
			for (var i=0; i<numMarkers; i++) {		
				context.fillText(markerValue, (startX - 5), (chartHeight - markerValue), 50);
				markerValue += markDataIncrementsIn;
			}
		}		
		
		// drawLine - draws a line on a canvas context from the start point to the end point 
		function drawLine(contextO, startx, starty, endx, endy) {
			contextO.beginPath();
			contextO.moveTo(startx, starty);
			contextO.lineTo(endx, endy);
			contextO.closePath();
			contextO.stroke();
		}
		
		// drawRectanle - draws a rectangle on a canvas context using the dimensions specified
		function drawRectangle(contextO, x, y, w, h, fill) {			
			contextO.beginPath();
			contextO.rect(x, y, w, h);
			contextO.closePath();
			contextO.stroke();
			if (fill) contextO.fill();
		}		
	</script>
</head>