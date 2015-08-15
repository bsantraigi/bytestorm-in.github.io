<?php
	error_reporting(E_ALL);
	$con = mysqli_connect("sql211.byethost18.com","b18_16306077","simple_pass","b18_16306077_grider2");
	$str = file_get_contents("outlets (2).sql");
	mysqli_query($con,$str);
?>