<?php
	 require_once "../../config.php";
	$author_name = "Roland Silt";
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_now = date("N");
	//echo $weekday_now;
	$weekdaynames_et = ["esmaspäev" , "teisipäev" , "kolmapäev" , "neljapäev" , "reede" , "laupäev" , "pühapäev"];
	echo $weekdaynames_et[$weekday_now - 1];
	
	$proverbs_et = ["hirmul on suured silmad" , "julge hundi rind on rasvane" , "kuidas küla koerale nõnda koer külale" , "kelle jalg tatsub, selle suu matsub"]; 
	$random_proverb = $proverbs_et [mt_rand(0, count($proverbs_et) -1)]; 
	$hours_now = date("H");
	//echo $hours_now;
	 $part_of_day = "suvaline päeva osa"; 
	// <   >  ==  != <= >=
	if($hours_now < 7 and $weekday_now <=5) {$part_of_day = "uneaeg";}
	// and or 
	if($hours_now >= 8 and $hours_now < 18 and $weekday_now <=5) {$part_of_day = "Kool täies jõus";} 
	if ($hours_now >= 19 and $hours_now <23) {$part_of_day = "Vedelen niisama";} 
	if ($hours_now < 12 and $weekday_now <=6) {$part_of_day = "ilu uni";} 
	if ($hours_now >12 and $weekday_now =1) {$part_of_day = "panen peeneks";} 
	//uurime semestri kestmist
	$semester_begin = new DateTime("2022-9-5");
	$semester_end = new DateTime("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	//echo $semester_duration;
	$semester_duration_days = $semester_duration->format("%r%a");
	$from_semester_begin =$semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	//juhuslik arv
	//küsin massiivi pikkust
	//echo count($weekdaynames_et)
	//echo mt_rand(0, count($weekdaynames_et) - 1 ); 
	//echo $weekdaynames_et(mt_rand(0, count($weekdaynames_et) - 1); 
	
	//juhuslik foto
	$photo_dir = "piktuurid"; 
	//loen kataloogi sisu
	//$all_files = scandir($photo_dir);
	//var_dump($all_files);
	$all_files = array_slice(scandir($photo_dir), 2);
	//kontrollin kas on ikka foto 
	$allowed_photo_types = ["image/jpeg", "image/png"];
	//klassikaline tsükkel 
	// muutuja väärtuse suurendamine  $muutuja = $muutuja + 5 
	// $muutuja += 5
	// kui on vaja liita 1 
	//$muutuja ++
	// samamoodi $muutuja -= 5 ja $muutujua --
	for($i = 0;$i < count($all_files); $i ++) {
	} 
	$photo_files = [];
	foreach ($all_files as $filename) {
		//echo $filename; 
		$file_info = getimagesize($photo_dir ."/" . $filename);
		//var_dump($file_info); 
		//KAS ON LUBATUD TÜÜPIDE NIMERKIRJAS
		if( isset($file_info["mime"])){ 
			if(in_array($file_info["mime"], $allowed_photo_types)) {
				array_push($photo_files, $filename); 
				}//if in array
			}//if  isset
		}//foreach 
	//var_dump($photo_files);
	
		
	
	//var_dump(all_real_files);
	//<img src = "kataloog/fail" alt="tekst">
	$photo_html = '<img src="' .$photo_dir ."/" . $photo_files[mt_rand(0, count($photo_files) - 1)] .'"';
	$photo_html .= ' alt="Tallinna pilt">';
	
	//VAATAME MIDA VORMI SISESTATI
	//var_dump($_POST); 
	//echo $_POST["Todays_adjective_input"];
	$todays_adjective = "Pole midagi sisestatud";
	if(isset( $_POST["Todays_adjective_input"]) and !empty($_POST["Todays_adjective_input"])){ 
		$todays_adjective = $_POST["todays_adjective_input"];
	}
	//loome rippmenüü valikud
	//<option value="0">tln_177.jpg </option>
	//<option value="1">tln_178.jpg </option>
	//<option value="2">tln_180.jpg </option>
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0;$i < count($photo_files); $i ++) {
		$select_html .= '<option value="' .$i  .'">';
	if($i == $photo_files){
	$select_html .= " selected";}
		$select_html.= $photo_files[$i];
		$select_html.= "</option>";
	}
	//if(isset($_POST["photo_select"]) and !empty($_POST["photo_select"])){
		//echo $_POST("photo_select");
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >=0){
		echo "Valiti pilt nr:" .$_POST["photo_select"];
	}
	$comment_error = null;
	//kas klikiti päeva kommentaari nuppu
	
	if(isset($_POST["comment_submit"]))
		if(isset($_POST["comment_input"]) and !empty(($_POST["comment_input"]))){
			$comment =$_POST["comment_input"];
		}  else {
			$comment_error= "Kommentaar jäi kirjutamata";
		}
		$grade = $_POST["grade_input"];
		
		if(empty($comment_error)){
		//loon andmebaasiga ühenduse 
		//tahab saada koigepealt serverit siis kasutajt ja siis parooli aj siis andmebaasi
		$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
		//määran suhtlemisel kasutatava kooditabeli
		$conn->set_charset("utf8"); 
		//valmistame ette andmete saatmise sql käsu 
		$stmt = $conn->prepare("INSERT INTO vp_daycomment_rol_sil (comment, grade) values(?, ?)");
		echo $conn->error;
		//seome SQL KÄSU õigete andmetega
		//andmetüübid- i- integer, d decimal ehk murdarv, s string ehk tekst
		$stmt->bind_param("si",$comment, $grade);
		$stmt->execute();
		echo $conn->error;
		//sulgeme käsu
		$stmt->close();
		//andmebaasoühendus kinni
		$conn->close();
		} 
		
	
		


	
	?>
<!DOCTYPE html>
<html lang="et">
<head>
 <meta charset="utf-8">
 <title><?php echo $author_name;?> programmeerib veebi</title>
</head>

<body>
<img src="piktuurid/vp_43.png">
<h1> Roland Silt ikka programmeerib veebi</h1>
	<p> See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
	<p> Õppetöö toimus <a href="https://www.tlu.ee" target="_blank"> Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
	<p> Lehe avamise hetk: <?php echo $weekdaynames_et [$weekday_now - 1].", " .$full_time_now;?></p>
	<p> Praegu <?php echo $part_of_day;?>.</p>
	<p> Semestri pikkus on <?php echo $semester_duration_days;?> päeva. See on kestnud juba <?php echo $from_semester_begin_days; ?> päeva. </p>
<img src="piktuurid/tlu_42.jpg" alt="Tallinna ülikooli ajaloolise Terra õppehoone sissepääs"></a>  
	<p> Tänane vanasõna: <?php echo $random_proverb;?></p>
<form method="POST">
	<label for="comment_input">kommentaar tänase päeva kohta (140 tähte) </label>
	<br>
	<textarea id="comment_input" name="comment_input" cols="35" rows="4" 
	placeholder="kommentaar"></textarea>
	<br>
	<label for="grade_input">Hinne tänasele päevale (0-10)</label>
	<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="5"
	<br>
	<input type="submit" id="comment_submit" name="comment_submit" value="salvesta">
	<span><?php echo $comment_error; ?> </span>
</form>
<br>
<hr>
</form>
	



	<form method="POST"> 
<input type="text" id="todays_adjective_input" name="todays_adjective_input"
placeholder="Kirjuta siia omadussõna tänase päeva kohta">
<input type="submit" id="todays_adjective_submit" name="todays adjective_submit" value="Saada omadussõna!">
</form> 	
<p> omadussõna tänase kohta: <?php echo $todays_adjective; ?></p>
<hr>
<form method="POST">
	<select id="photo_select" name="photo_select">
	<?php echo $select_html; ?>
	
	
	</select>
	<input type="submit" id="photo_submit" name="photo_submit" value="Määra foto">
	</form>
	<?php echo $photo_html; ?>
		if(isset($POST("photo_select"]) and ($_POST["photo_select"] >=0)) 
		{
			$photo_html ='<img src="' .$photo_dir ."/" . $photo_files[$_POST["photo_select"]] . '"alt="Tallinna pilt">';
			echo $photo_html;
		}
		else
		{
		echo $photo_html;
		}
		?>
			
	<hr>
</body>
</html>




