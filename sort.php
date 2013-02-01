<?php
   $time_start = microtime(true);
?>

<!doctype html>
<html>
<head>
<title>Arrest Data Sorting Filter</title>
<meta charset="utf-8">
<meta author="Stas Baydakov" />
<meta robots="noindex,nofollow" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
</script>

<script type="text/javascript">

function checkFunction(element)
{
	var tblID			=	$(element).parent().parent().parent().parent().attr('id');
	var checkedStatus 	= 	$(element).attr('checked');
	
	$("#" + tblID + " tr td:last-child input:checkbox").each(function() 
	{
		this.checked 	= 	checkedStatus;
	});

}

function printFunction(element)
{
		  var boxes 				= $('[id^=checkbox_print]:checked');	
		  var recordsToPrint		= [];
		 
		  for( j=0; j< boxes.length ; j++)			 
		  {
				 var celChildren 	= 	$(boxes[j]).parent().parent("tr").find("td");
				 var curText		=	[];

				 for( i=1; i< celChildren.length ; i++)
				 {
					 curText[i-1] 	= 	$(celChildren[i]).text();
				 }
				 recordsToPrint[j]	=	curText; 
			}

		   jQuery.ajaxSetup({async:false});
		   var jqxhr = $.get( "PDFLetter.php?action=letters",{ 'records': recordsToPrint},function(data,status)
					 {
			   			//alert("File: " + data + "\n" + "has been downloaded with Status: " + status);
						window.open( data , "_blank");	
				  	});	
		   jQuery.ajaxSetup({async:true});
		    
}
</script>
</head>
<body>

	<div id="example-list-fs" class="example">
      <ul id="example-list-fs-ul"></ul>
    </div>
    
<?php

require_once 'SortArrest.php';


$a = new CrimeList();
$a->mapAllFlagsAndLists($_POST);


if ($_POST['content']) 
{

	// Determine which SORTING ALGORITHM to use and perform the action
	if ($_POST['algorithm'] 	== 'lapd')  $a->sortingLAPD($_POST['content']);
	elseif ($_POST['algorithm'] == 'vcsd')  $a->sortingVCSD($_POST['content']);
	elseif ($_POST['algorithm'] == 'sbcsd') $a->sortingSBSD($_POST['content']);
	elseif ($_POST['algorithm'] == 'lasd')  $a->sortingLASD($_POST['content']);
	elseif ($_POST['algorithm'] == 'ocsd')  $a->sortingOCSD($_POST['content']);


	// Wrap up with OUTPUT
	echo "<div class=output>\n";
	echo "<p><b>Search parameters:</b> Sorting Algorithm - <em>" . $_POST['algorithm'] . "</em>; Zip List - <em>" . $_POST['zip_list'] . "</em>; Crime List - <em>" . $_POST['crime_list'] . "</em>; Output Options - <em>" . ($_POST['results_only'] ? 'results_only' : false) . ", " . ($_POST['all_short'] ? 'all_short' : false) . ", " . ($_POST['all_full'] ? 'all_full' : false) . "</em></p><hr />\n\n\n";
	
	if ( $a->isMatchedShortFlagSet() ) 
	{
		echo "<p>Matched records input (short version):</p>\n\n<pre>\n";
		$record_plus 		= $a->getFullMatchedRecords();
		$record_plus_length = sizeof($record_plus);
		
		echo "<table id=\"table_one\" border=\"1\">";
		echo "<thead>";
		echo "<tr><th></th>";
		echo "<th><b>First name</b></th>";
		echo "<th><b>Middle name</b></th>";
		echo "<th><b>Last name</b></th>";
		echo "<th><b>Street adress</b></th>";
		echo "<th><b>City</b></th>";
		echo "<th><b>State</b></th>";
		echo "<th><b>Zip</b></th>";
		echo "<th><b>Charges</b></th>";
		echo "<th><input type=\"checkbox\" name=\"select_all\" id=\"select_all_match_shrt\" onclick=\"checkFunction(this)\" /></th></tr>";
		echo "</thead>";
		
		
		for ($i=0, $j=1; $i<$record_plus_length; $i++)
		{
		if( !$a->isMatched( $record_plus[$i] ) )
			continue;
			echo "<tr><td>" . $j++ . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['first_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['middle_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['last_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['street_address'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['city'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['state'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['zip'] . "</td>";
			echo "<td>" . $record_plus[$i]['charges'] . "</td>";
			echo "<td><input type=\"checkbox\" name=\"print_letter\" id=\"checkbox_print" . $i . "\"/></td></tr>";			
		}
		echo "</table>";
		
		echo "</pre><hr />\n\n\n";
	}
	
	
	
	if ( $a->isShortFlagSet() )
	{
		echo "<p>All records input (short version):</p>\n\n<pre>\n";
		$record_plus 		= $a->getFullMatchedRecords();
		$record_plus_length = sizeof($record_plus);
	
		echo "<table id=\"table_two\" border=\"1\">";
		echo "<thead>";
		echo "<tr><th></th>";
		echo "<th><b>First name</b></th>";
		echo "<th><b>Middle name</b></th>";
		echo "<th><b>Last name</b></th>";
		echo "<th><b>Street adress</b></th>";
		echo "<th><b>City</b></th>";
		echo "<th><b>State</b></th>";
		echo "<th><b>Zip</b></th>";
		echo "<th><b>Charges</b></th>";
		echo "<th><input type=\"checkbox\" name=\"select_all\" id=\"select_all_shrt\" onclick=\"checkFunction(this)\" /></th></tr>";
		echo "</thead>";
	
	
		for ($i=0; $i<$record_plus_length; $i++)
		{
			echo "<tr><td>" . ($i+1) . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['first_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['middle_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['last_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['street_address'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['city'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['state'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['zip'] . "</td>";
			echo "<td>" . $record_plus[$i]['charges'] . "</td>";
			echo "<td><input type=\"checkbox\" name=\"print_letter\" id=\"checkbox_print_srt" . $i . "\"/></td></tr>";
		}
		echo "</table>";
	
		echo "</pre><hr />\n\n\n";
	}
	
	if ( $a->isFullFlagSet() )
	{
		echo "<p>All records input (full version):</p>\n\n<pre>\n";
	
		$record_plus 		= $a->getFullMatchedRecords();
		$record_plus_length = sizeof($record_plus);
	
		echo "<table id=\"table_three\" border=\"1\">";
		echo "<thead>";
		echo "<tr><th></th>";
		echo "<th><b>First name</b></th>";
		echo "<th><b>Middle name</b></th>";
		echo "<th><b>Last name</b></th>";
		echo "<th><b>Street adress</b></th>";
		echo "<th><b>City</b></th>";
		echo "<th><b>State</b></th>";
		echo "<th><b>Zip</b></th>";	
		echo "<th><b>Charges</b></th>";
		echo "<th><b>Gender</b></th>";
		echo "<th><b>Race</b></th>";
		echo "<th><b>Arrest agency</b></th>";
		echo "<th><b>Arrest date</b></th>";
		echo "<th><input type=\"checkbox\" name=\"select_all\" id=\"select_all_fl\" onclick=\"checkFunction(this)\" /></th></tr>";
		echo "</thead>";
	
	
		for ($i=0; $i<$record_plus_length; $i++)
		{
			echo "<tr><td>" . ($i+1) . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['first_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['middle_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['last_name'] . "</td>";		
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['street_address'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['city'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['state'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['zip'] . "</td>";
			echo "<td>" . $record_plus[$i]['charges'] . "</td>";
			echo "<td>" . $record_plus[$i]['gender'] . "</td>";
			echo "<td>" . $record_plus[$i]['race'] . "</td>";
			echo "<td>" . $record_plus[$i]['arrest_agency'] . "</td>";
			echo "<td>" . $record_plus[$i]['arrest_date']. "</td>";
			echo "<td><input type=\"checkbox\" name=\"print_letter\" id=\"checkbox_print_fl" . $i . "\"/></td></tr>";
	}
	echo "</table>";
	echo "</pre><hr />\n\n\n";
	}
	
	if ( $a->isMatchedFullFlagSet() )
	{
		echo "<p>Matched records input (full version):</p>\n\n<pre>\n";
	
		$record_plus = $a->getFullMatchedRecords();
		$record_plus_length = sizeof($record_plus);
	
		echo "<table id=\"table_four\" border=\"1\">";
		echo "<thead>";
		echo "<tr><th></th>";
		echo "<th><b>First name</b></th>";
		echo "<th><b>Middle name</b></th>";
		echo "<th><b>Last name</b></th>";	
		echo "<th><b>Street adress</b></th>";
		echo "<th><b>City</b></th>";
		echo "<th><b>State</b></th>";
		echo "<th><b>Zip</b></th>";
		echo "<th><b>Charges</b></th>";
		echo "<th><b>Gender</b></th>";
		echo "<th><b>Race</b></th>";
		echo "<th><b>Arrest agency</b></th>";
		echo "<th><b>Arrest date</b></th>";
		echo "<th><input type=\"checkbox\" name=\"select_all\" id=\"select_all_match_fl\" onclick=\"checkFunction(this)\" /></th></tr>";
		echo "</thead>";
	
	
		for ($i=0, $j=1; $i<$record_plus_length; $i++)
		{
			if( !$a->isMatched( $record_plus[$i] ) )
				continue;
			echo "<tr><td>" . $j++ . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['first_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['middle_name'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['last_name'] . "</td>";	
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['street_address'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['city'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['state'] . "</td>";
			echo "<td contenteditable=\"true\">" . $record_plus[$i]['zip'] . "</td>";
			echo "<td>" . $record_plus[$i]['charges'] . "</td>";
			echo "<td>" . $record_plus[$i]['gender'] . "</td>";
			echo "<td>" . $record_plus[$i]['race'] . "</td>";
			echo "<td>" . $record_plus[$i]['arrest_agency'] . "</td>";
			echo "<td>" . $record_plus[$i]['arrest_date']. "</td>";
			echo "<td><input type=\"checkbox\" name=\"print_letter\" id=\"checkbox_print_all_fl" . $i . "\"/></td></tr>";
		}
		echo "</table>";
		echo "</pre><hr />\n\n\n";
	}
	
	echo "</div>";
	
	echo "<div id=\"print_div\"><button id=\"print_letters\" onclick=\"printFunction(this)\">Print Letters</button><span id=\"pdfout\"></span></div>";
} else {
	echo "<h3>Please fill out all required fields.</h3>\n\n\n";
}


?> 

<style>
body { font: 14px/1.5 Arial, Helvetica, sans-serif; }
.output { line-height: 1; }
hr { clear: both; height: 0; border-top: 1px solid #eee; }
form textarea { width: 99%; }
form div { min-width: 200px; width: 22%; float: left; padding: 10px; background: #EEE; margin: 0 10px 10px 0; border-radius: 5px; }
form div:hover { background: #e5e5e5; }
input[type="submit"] { display: block; margin: 20px auto; font-size: 16px; padding: 5px 15px; }
label { cursor: pointer; }
</style>

<form method="post">
<p><b>Content:</b><br><textarea rows=18 name="content"></textarea>

<div><b>Sorting Algorithm:</b><br>
<input type="radio" name="algorithm" id="algorithm1" checked value="lapd" <?php echo ($_POST['algorithm'] == "lapd" ? 'checked' : ''); ?>/> <label for="algorithm1">Original (LAPD)</label><br>
<input type="radio" name="algorithm" id="algorithm2" value="vcsd" <?php echo ($_POST['algorithm'] == "vcsd" ? 'checked' : ''); ?>/> <label for="algorithm2">Ventura Sheriff</label><br>
<input type="radio" name="algorithm" id="algorithm3" disabled value="sbcsd" <?php echo ($_POST['algorithm'] == "sbcsd" ? 'checked' : ''); ?>/> <label for="algorithm3">San Bernardino Sheriff</label><br>
<input type="radio" name="algorithm" id="algorithm4" value="lasd" <?php echo ($_POST['algorithm'] == "lasd" ? 'checked' : ''); ?>/> <label for="algorithm4">Los Angeles Sheriff</label><br>
<input type="radio" name="algorithm" id="algorithm5" value="ocsd" <?php echo ($_POST['algorithm'] == "ocsd" ? 'checked' : ''); ?>/> <label for="algorithm5">Orange County Sheriff</label></div>

<div><b>Zip Codes:</b><br>
<input type="radio" name="zip_list" id="zip1" checked value="los_angeles" <?php echo ($_POST['zip_list'] == "los_angeles" ? 'checked' : ''); ?>/> <label for="zip1">Los Angeles</label><br>
<input type="radio" name="zip_list" id="zip2" value="lap" <?php echo ($_POST['zip_list'] == "lap" ? 'checked' : ''); ?>/> <label for="zip2">laP</label><br>
<input type="radio" name="zip_list" id="zip3" value="lax" <?php echo ($_POST['zip_list'] == "lax" ? 'checked' : ''); ?>/> <label for="zip3">lax</label><br>
<input type="radio" name="zip_list" id="zip4" value="ontario" <?php echo ($_POST['zip_list'] == "ontario" ? 'checked' : ''); ?>/> <label for="zip4">Ontario</label><br>
<input type="radio" name="zip_list" id="zip5" value="or" <?php echo ($_POST['zip_list'] == "or" ? 'checked' : ''); ?>/> <label for="zip5">or</label><br>
<input type="radio" name="zip_list" id="zip6" value="oxnard" <?php echo ($_POST['zip_list'] == "oxnard" ? 'checked' : ''); ?>/> <label for="zip6">Oxnard</label><br>
<input type="radio" name="zip_list" id="zip7" value="pc" <?php echo ($_POST['zip_list'] == "pc" ? 'checked' : ''); ?>/> <label for="zip7">pc</label><br>
<input type="radio" name="zip_list" id="zip8" value="sfs" <?php echo ($_POST['zip_list'] == "sfs" ? 'checked' : ''); ?>/> <label for="zip8">sfs</label><br>
<input type="radio" name="zip_list" id="zip9" value="wc" <?php echo ($_POST['zip_list'] == "wc" ? 'checked' : ''); ?>/> <label for="zip9">wc</label><br>
<input type="radio" name="zip_list" id="zip10" value="all" <?php echo ($_POST['zip_list'] == "all" ? 'checked' : ''); ?>/> <label for="zip10">Include All</label><br>
<input type="radio" name="zip_list" id="zip11" value="global" <?php echo ($_POST['zip_list'] == "global" ? 'checked' : ''); ?>/> <label for="zip11">Global Zips</label></div>

<div><b>Crime Type:</b><br>
<input type="radio" name="crime_list" id="crime1" checked value="dui" <?php echo ($_POST['crime_list'] == "dui" ? 'checked' : ''); ?>/> <label for="crime1">DUI</label><br>
<input type="radio" name="crime_list" id="crime2" value="other" <?php echo ($_POST['crime_list'] == "other" ? 'checked' : ''); ?>/> <label for="crime2">Other</label><br>
<input type="radio" name="crime_list" id="crime3" value="all" <?php echo ($_POST['crime_list'] == "all" ? 'checked' : ''); ?>/> <label for="crime3">Include All</label></div>

<div><b>Output Options:</b><br>
<input type="checkbox" name="results_only" id="option1" <?php echo (isset($_POST['results_only']) ? 'checked' : ''); ?>/> <label for="option1">Show matched records(Short version)</label><br>
<input type="checkbox" name="matched_full" id="option4" <?php echo (isset($_POST['matched_full']) ? 'checked' : ''); ?>/> <label for="option4">Show matched records (Full version)</label><br>
<input type="checkbox" name="all_short" id="option2" <?php echo (isset($_POST['all_short']) ? 'checked' : ''); ?>/> <label for="option2">Show all records (Short version)</label><br>
<input type="checkbox" name="all_full" id="option3" <?php echo (isset($_POST['all_full']) ? 'checked' : ''); ?>/> <label for="option3">Show all records (Full version)</label></div>
<hr />
<input type="submit" value="Sort" />
</form>

<?php
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "\n\n\n<p><i>This page was created in ".$time." seconds</i></p>\n\n";
?>

</body>
</html>