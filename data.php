<?php
	// et saada ligi sessioonile
	require("functions.php");
	//ei ole sisse loginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login4.php");
		
	}
	
	//kas kasutaja tahab välja logida
	//kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login4.php");
		
	}

?>


<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>


</p>