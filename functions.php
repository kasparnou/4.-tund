<?php
	//et saab kasutada $_SESSION muutujaid
	//kõigis failides mis on sellega seotud
	session_start();
	
	
	$database = "if16_kaspnou";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		//ühendus
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		// s - string
		// i - int
		// d - decimal/double
		// iga küsimärgi jaoks üks täht, mis tüüpi on
		$stmt->bind_param("ss", $email, $password );
		
		if($stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else 	{
			echo "error ".$stmt->error;
		}	
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ? ");
		//asendan ?
		$stmt->bind_param("s", $email);
		//määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult SELECTI puhul
		if ($stmt->fetch()){
			//vähemalt üks rida tuli
			//kasutaja sisselogimise parool räsiks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				//õnnestus
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
				
			}else{
				$notice = "Vale parool!";
			}
		}else {
			//ei leitud sellist rida
			$notice = "Sellist emaili ei ole!";
			
		}
		
		return $notice;
	
	}
	
	/*function sum($x, $y) {
	
		return $x+$y;
	
	}
	
	
	
	echo sum(1085252, 5198511654198);
	echo "<br>";
	
	echo sum(4, 5);
	echo "<br>";
	
	function hello($firstName, $lastName) {
		
		return "Tere tulemast " 
		.$firstName
		." "
		.$lastname
		."!"; 
		
	}
	
	$firstName = "Kaspar";
	$lastName = "nou"
	echo hello($firstName, $lastName);*/
	
	
	
	
	
	


?>