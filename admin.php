<?php
include("settings.php");
session_start();
if(!isset($_SESSION["login"])){ header('Location: login.php'); } 
else {

	if(isset($_POST['logout'])){
		session_destroy();
		header("Refresh: 0; url=login.php");
		ob_end_flush();
	}  

	$word_counter_query = mysqli_query($connection,"SELECT count(1) as total from words");  
	$word_counter=mysqli_fetch_assoc($word_counter_query);
	$article_counter_query = mysqli_query($connection,"SELECT * FROM statistics");  
	$article_counter_query=mysqli_fetch_assoc($article_counter_query);

	if(isset($_POST['add'])){
		$word_post = $_POST['word_post'];
		$synonym_post = $_POST['synonym_post'];
		$double_post = $_POST['double_post'];
		if(isset($double_post)){
			$connection->query("INSERT INTO words (synonym, word) VALUES ('$word_post','$synonym_post')");
		}
		if ($connection->query("INSERT INTO words (word, synonym) VALUES ('$word_post','$synonym_post')"))
		{
			header ("Location:admin.php"); 
		}
	}

}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Makale özgünleştirme Aracı">
    <meta name="author" content="Onur Tiriş">
    <title>Makale Özgünleştirme Aracı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/spinner.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <main class="form-spinner">
		<div class="row">
			<div class="col-sm-6 mb-3">
				<div class="card rounded-pill">
					<div class="card-body">
						<h2 class="card-title fw-bold"><?php echo $word_counter['total']; ?></h2>
						<p class="card-text">Eş anlamlı kelime sayısı</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 mb-3">
				<div class="card rounded-pill">
					<div class="card-body">
						<h2 class="card-title fw-bold"><?php echo $article_counter_query['counter']; ?></h2>
						<p class="card-text">Özgünleştirilmiş makale sayısı</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 mb-3">
				<div class="card bg-light rounded-pill">
					<div class="card-body">
						<form action="admin.php" method="post" class="mb-0 user">
							<div class="form-group row">
								<div class="col-sm-4 mt-2  ">
									<input type="text" maxlength="110" required name="word_post" class="form-control form-control-user" placeholder=" Kelime" style="border-radius: 22px;"  >
								</div>
								<div class="col-sm-4 mt-2 ">
									<input type="text" maxlength="110" required name="synonym_post" class="form-control form-control-user" placeholder=" Eş anlamlısı" style="border-radius: 22px;"  >
								</div>
								<div class="col-sm-1 pt-2">
									<input type="checkbox" name="double_post" class="form-check-input"> Çift
								</div>
								<div class="col-sm-3 mt-2 ">
									<input class="btn btn-success btn-user btn-block" style="border-radius: 22px;" type="submit" name="add" value="Ekle">
									<form action="" method="post"> <input class="btn btn-success btn-user btn-block" style="border-radius: 22px;" type="submit" name="logout" value="Kapat"> </form>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<hr class="my-4">
		<h4 class="mb-4 fw-bolder">Kelime listesi</h4>
		<form class="d-flex" action="" method="post">
			<input type="text" maxlength="110" required name="search_value" class="form-control me-2" type="search" placeholder="Anahtar kelime" >
			<button class="btn btn-success" name="search" type="submit">Ara</button>
		</form>
      
		<table class="table table-light table-bordered table-hover">
			<thead class="table-success pt-2 pb-2 rounded">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Kelime</th>
					<th scope="col">Eş anlamlısı</th>
					<th scope="col"></th>
				</tr>
			</thead>

			<?php 
			$results_per_page = 100;  
			$per_page_query = "SELECT * FROM words";  
			$result = mysqli_query($connection, $per_page_query);  
			$number_of_result = mysqli_num_rows($result);  
			$number_of_page = ceil ($number_of_result / $results_per_page);  
			if (!isset ($_GET['page'])) { $page = 1; } else { $page = $_GET['page']; } 
			$page_first_result = ($page-1) * $results_per_page;  

			if ($_POST) {

				if(isset($_POST['search'])){ 

					$search_value=$_POST["search_value"];
					$sql="SELECT * FROM words WHERE word LIKE '%$search_value%' or synonym LIKE '%$search_value%' ORDER BY id DESC";
					$res=$connection->query($sql);

					while($row=$res->fetch_assoc()){
						$id= $row['id']; 
						$word = $row['word'];
						$synonym = $row['synonym'];
						?>
						<tbody>
							<tr>
								<th scope="row"><?php echo $id; ?></th>
								<td><?php echo $word; ?></td>
								<td><?php echo $synonym; ?></td>
								<td class="text-center"><?php echo "<a class='text-decoration-none' href='delete.php?id=" . $id . "&page=" . $page . "'>Sil</a>"; ?></td>
							</tr>
						</tbody>
						<?php } ?>
						</table>
						<a class="btn btn-success btn-user btn-block mb-3" href="admin.php" style="border-radius: 22px;" role="button">Tüm kelimeleri görüntüle</a>
					<?php 
					}
			}

	        if(isset($_POST['search'])){
				$search_value=$_POST["search_value"];
				$per_page_query="SELECT * FROM words LIMIT " . $page_first_result . ',' . $results_per_page . " WHERE word LIKE '%$search_value%'";
	        }
	        else{
	        	$per_page_query = "SELECT * FROM words ORDER BY id DESC LIMIT " . $page_first_result . ',' . $results_per_page;  
	        }

			$result = mysqli_query($connection, $per_page_query); 

			while ($row = mysqli_fetch_array($result)) { 
				$id= $row['id']; 
				$word = $row['word'];
				$synonym = $row['synonym'];
				?>
	<tbody>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $word; ?></td>
						<td><?php echo $synonym; ?></td>
						<td class="text-center"><?php echo "<a class='text-decoration-none' href='delete.php?id=" . $id . "&page=" . $page . "'>Sil</a>"; ?></td>
					</tr>
				</tbody>
			<?php } ?>
			</table>
      
		<?php 
		if(!isset($_POST['search'])){
			$total_records = $word_counter['total'];
			$total_pages = ceil($total_records / $results_per_page);     
			echo '<a style="border-radius: 22px;" role="button" class="btn btn-success btn-sm m-1" href = "admin.php?page=' . 1 . '">' . "<<" . ' </a>';

			if($page >=5 && $page+3 <= $total_pages){

				for ($i=$page-2; $i<=$page+2; $i++) {  
					if($page == $i){ echo '<a style="border-radius: 22px;" role="button" class="btn btn-primary btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
					else{ echo '<a style="border-radius: 22px;" role="button" class="btn btn-success btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
				}
			}

			else if($page >=5){
				$difference = 4 - ($total_pages-$page);
				for ($i=$page-$difference; $i<=$total_pages; $i++) {  
					if($page == $i){ echo '<a style="border-radius: 22px;" role="button" class="btn btn-primary btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
					else{ echo '<a style="border-radius: 22px;" role="button" class="btn btn-success btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
				}
			}

			else if($page <5){
				if($total_pages >= 5){ $temp_pages =5; } else{ $temp_pages = $total_pages; }
				for ($i=1; $i<=$temp_pages; $i++) {  
					if($page == $i){ echo '<a style="border-radius: 22px;" role="button" class="btn btn-primary btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
					else{ echo '<a style="border-radius: 22px;" role="button" class="btn btn-success btn-sm m-1" href = "admin.php?page=' . $i . '">' . $i . ' </a>'; }
				}
			}
			echo '<a style="border-radius: 22px;" role="button" class="btn btn-success btn-sm m-1" href = "admin.php?page=' . $total_pages . '">' . ">>" . ' </a>';
		}
		?>
         
    	<p class="mt-3 mb-3 text-muted"><a href="https://github.com/onurtiris" class="mt-2 mb-3 text-muted">Developed by Onur Tiriş</a></p>
    
    </main>
    
  </body>
</html>



