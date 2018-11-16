<?php 
	session_start();
	require("../databaseConnection/database.php");
	$logo = 'Search';
	include('../php/functions.php');

	if(isset($_SESSION["user"]))
		$user = $_SESSION["user"];

	include('../includes/header.php');

	$filterArray = array('username', 'date', 'tags', 'keyword');
?>

<section>
	<main>
		<div class = "searchContainer">
			
			<p> Multiple common search parameters are comma delimited so if you <br>
			    are searching for two tags then it would be "php, ajax"</p><br>

			<form class = "searchForm">
				<select class = "filter1" name = "filter1">
				<option selected = "selected">Choose Filter</option>
					<?php 
						foreach($filterArray as $filter)
							echo '<option value =' . $filter . '>' . $filter . '</option>'; 
					?>
			</select> 
		
			<div class = "filterInput1Container">
				
			</div> <br><br>		

			<select class = "filter2" name = "filter2">
				
			</select>

			<div class = "filterInput2Container">
				
			</div> <br><br>
			<input type="button" class = "filterSearchButton" value = "search"> 
			
			</form>
			<div class = 'searchError'>
				
			</div>
		</div>

		<div class = "searchResults">
			
		</div>
		
	</main>

</section>
<?php include('../includes/footer.php'); ?>
