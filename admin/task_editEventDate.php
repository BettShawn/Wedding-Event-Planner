<?php

$bdd = new PDO('mysql:host=localhost;dbname=dbwedding', 'root', '');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];

	$sql = "UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ";
	$query = $bdd->prepare( $sql );
	
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('error prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('error execute');
	}else{
		die ('OK');
	}
}
header('Location: '.$_SERVER['HTTP_REFERER']);
	
?>
