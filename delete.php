<?php
include("settings.php");
session_start();

if (!isset($_SESSION["login"])) {
	echo "Bu sayfaya erişiminiz yoktur.";
}

else {
	if ($_GET) 
	{
		if ($connection->query("DELETE FROM words WHERE id =".(int)$_GET['id'])) 
		{
          	$results_per_page = 100; 
          	$word_counter_query = mysqli_query($connection,"SELECT count(1) as total from words");  
          	$word_counter=mysqli_fetch_assoc($word_counter_query);
			$total_pages = ceil($word_counter['total'] / $results_per_page); 
          	$page = $_GET['page'];
          
            if ($page > 1) { header("location:admin.php?page=$page"); }
            else { header("location:admin.php"); }
		}
	}
}

?>
