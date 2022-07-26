<?php 
	$bdd = new PDO('mysql:host=localhost;dbname=dbwedding', 'root', '');
	if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){

		$title = $_POST['title'];
		$location = $_POST['location'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$color = $_POST['color'];
		$booking_id = $_POST['booking_id'];

		$sql = "INSERT INTO events(title, start, location, end, color, booking_id) values ('$title', '$start','$location', '$end', '$color', '$booking_id')";

		$query = $bdd->prepare( $sql );

		if ($query == false) {

		 print_r($bdd->errorInfo());
		 die ('error prepare');

		}

		$sth = $query->execute();

		if ($sth == false) {

		 print_r($query->errorInfo());
		 die ('error execute');

		}
	}
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;
?>
