<?php
require_once "../config.php";
//loon andmebaasiga ühenduse 
		//tahab saada koigepealt serverit siis kasutajt ja siis parooli aj siis andmebaasi
		$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
		//määran suhtlemisel kasutatava kooditabeli
		$conn->set_charset("utf8");
		
		//valmistame ette andmete saatmise sql käsu 
		$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_daycomment_rol_sil");
		echo $conn->error;
		//seome saadavad andmed muutujatega
		$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
		//täidame käsu 
		$stmt->execute();
		// kui saan ühe kirje
		//if($stmt-> fetch()){
		//kui saan ühe kirje siis smt fetch
		//kui tuleb teadmata arv kirjeid siis
		$comment_html= null;
		while($stmt-> fetch()){
			//echo $comment_from_db;
			//<p> kommentaar, hinne päevale: 6, lisatud xxxxxxx </p> 
			$comment_html .= "<p>".$comment_from_db .", hinne päevale;".$grade_from_db;
			$comment_html.= ", lisatud " .$added_from_db .".</p> \n";
		}


?>



<!DOCTYPE html>
<html lang="et">
<head>
 <meta charset="utf-8">
 <title>Roland Silt programmeerib veebi</title>
</head>

<body>
<img src="piktuurid/vp_43.png">
<h1> Roland Silt programmeerib veebi</h1>
<p> See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
<p> Õppetöö toimus <a href="https://www.tlu.ee" target="_blank"> Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
<?php echo $comment_html;  ?> 
<img src="piktuurid/tlu_42.jpg" alt="Tallinna ülikooli ajaloolise Terra õppehoone sissepääs"></a> 
</body>
</html>




