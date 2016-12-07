<?php

	session_start();

	include_once('config.php');

	//

	if($_GET['do'] == 'exit') { 
		if(isset($_SESSION['auth_id'])) { 
			unset($_SESSION['auth_id'], $_SESSION['status']);

			header('Location: /kases/');
			exit;			
		}
	}

	##

	if(isset($_POST['log'])) {
		if(isset($_POST['login'])) $login = $_POST['login']; else $login = '';
		if(isset($_POST['password'])) $password = md5($_POST['password']); else $password = '';	

		$sql = mysql_query("SELECT id, status FROM users WHERE login = '".$login."' AND password = '".$password."' LIMIT 1") or die(mysql_error());	

		if(mysql_num_rows($sql) == 1) {
			$res = mysql_fetch_assoc($sql);

			$_SESSION['auth_id'] = $res['id'];
			$_SESSION['status'] = $res['status'];

			header('Location: /kases/'); //index.php
			exit;
		}
		else {
			header('Location: /kases/');
			exit;
		}		
	}

	##

	if(isset($_POST['reg'])) { 
		if(isset($_POST['name'])) $name = $_POST['name']; else $name = '';
		if(isset($_POST['login'])) $login = $_POST['login']; else $login = '';
		if(isset($_POST['password'])) $password = md5($_POST['password']); else $password = '';	

		if(!empty($name) && !empty($login) && !empty($password)) {
			$sql = mysql_query("SELECT id FROM users WHERE login = '".$login."' LIMIT 1") or die(mysql_error());

			if(mysql_num_rows($sql) == 1) {
				$reg_message = 'Lietotājs ar tādu vārdu jau ir reģistrēts! <br><br>';
			}
			else {
				$sql = mysql_query("INSERT INTO users (login, password, name, status) VALUES ('".$login."', '".$password."', '".$name."', 'user')") or die(mysql_error());

				if($sql == true) $reg_message = 'Apsveicam, jūs esat veiksmīgi reģistrēti! <br><br>';
				else $reg_message = 'Kļūda, pamēģiniet vēlreiz! <br><br>';
			}
		}
		else {
			$reg_message = 'Nepieciešams aizpildīt visus laukus! <br><br>';
		}
	}

	##

	if($_GET['do'] == 'del' && !empty($_GET['id'])) {
		$sql = mysql_query("DELETE FROM comments WHERE id = '".$_GET['id']."' LIMIT 1") or die(mysql_error());
	}

	if(isset($_POST['com'])) { 
		$com_user = $_POST['author'];
		$com_text = $_POST['text'];
		$com_date = date("H:i - d.m.Y");

		$sql = mysql_query("INSERT INTO comments (com_date, com_user, com_text) VALUES ('".$com_date."', '".$com_user."', '".$com_text."')") or die(mysql_error());
	}

	print '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Kases aparāti</title>
<link href="css/style.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin,cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    $("#toggle").click(function(){
	        $("#com-list").slideToggle("slow");
	        return false;
	    });
	});
</script>
</head>
<body>

	<div class="container-fluid">
		<div class="top col-sm-14">
			<div class="top-logo">
				<a href="/kases/" class="kases-logo">KASES APARĀTI</a>
			</div>
			<div class="top-authorization">';

			if(!isset($_SESSION['auth_id'])) {
				print '
				<div class="auth-form">
					<form method="post" action="">
						<input type="text" name="login" value="Login" class="login-input">
						<input type="password" name="password" value="Password" class="login-input">
						<input type="submit" name="log" value="Ienākt" class="">
					</form>
				</div>
				<div class="registration">
					<a href="?do=reg" class="reg-link">Reģistrācija</a>
				</div>';
			}
			else {
				$sql = mysql_query("SELECT name, status FROM users WHERE id = '".$_SESSION['auth_id']."' LIMIT 1") or die(mysql_error());
				$res = mysql_fetch_assoc($sql);

				$user_name = $res['name'];
				$user_status = $res['status'];

				if($user_status !== 'admin') $user_status = 'lietotājs';
				else $user_status = 'administrators';

				print '
				<div class="user"> Esat sveicināti, '.$user_name.' ('.$user_status.') | <a href="?do=exit" class="exit-link">Iziet</a> </div>';
			}
			
				print '
			</div>
		</div>
		';

		if($_GET['do'] !== 'reg') {
			print '
		<div class="kases-image col-sm-14">
			<div class="image-heading">Lorem Ipsum ir kļuvis par vispārpieņemtu teksta aizvietotāju kopš 16. gadsimta sākuma...</div>
		</div>
			';
		} 
		else {
			print '
		<div class="reg-form col-sm-14">
			<div class="reg-heading">Reģistrācija:</div> <br>
			'.$reg_message.'
			<form method="post" action="">
				Vārds: <br>
				<input type="text" name="name" class="reg-input"> <br><br>			
				Login: <br>
				<input type="text" name="login" class="reg-input"> <br><br>
				Parole: <br>
				<input type="password" name="password" class="reg-input"> <br><br>
				<input type="submit" name="reg" value="Reģistrācija" class="">
			</form>
		</div>
			';
		}

		print '
		<div class="text col-sm-14">
			<strong>Lorem Ipsum</strong> -tas ir teksta salikums, kuru izmanto poligrāfijā un maketēšanas darbos. Lorem Ipsum ir kļuvis par vispārpieņemtu teksta aizvietotāju kopš 16. gadsimta sākuma. Tajā laikā kāds nezināms iespiedējs izveidoja teksta fragmentu, lai nodrukātu grāmatu ar burtu paraugiem. Tas ir ne tikai pārdzīvojis piecus gadsimtus, bet bez ievērojamām izmaiņām saglabājies arī mūsdienās, pārejot uz datorizētu teksta apstrādi. Tā popularizēšanai 60-tajos gados kalpoja Letraset burtu paraugu publicēšana ar Lorem Ipsum teksta fragmentiem un, nesenā pagātnē, tādas maketēšanas programmas kā Aldus PageMaker, kuras šablonu paraugos ir izmantots Lorem Ipsum teksts.
			
			<br><br>

			<strong>Kas ir Lorem Ipsum? Kāpēc mēs to lietojam? No kurienes tas ir radies? Kur es to varu dabūt?</strong>

			<br><br>
			<img src="images/raschet.jpg" alt="" style="width: 300px; float: left; margin-right: 20px;">
			
			Jau sen ir noskaidrots fakts, ka aplūkojot maketa dizainu un kompozīciju teksta saturs novērš uzmanību. Lorem Ipsum izmanto tāpēc, kas tas nodrošina vairāk vai mazāk vienmērīgu burtu izvietojumu un padara to līdzīgu lasāmam tekstam angļu valodā, kas neizdodas, ja vienu un to pašu tekstu "Šeit ir teksts..
			šeit ir teksts" atkārto. Daudzas maketēšanas un web lapu rediģēšanas programmas mūsdienās izmanto Lorem Ipsum kā standarta parauga tekstu un, izmantojot interneta meklēšanas programmās atslēgas vārdus "lorem ipsum", var redzēt cik daudz web lapu aizvien vēl gaida savu piedzimšanu. Pēdējo gadu laikā teksts Lorem Ipsum ieguvis dažādas versijas. <u>Dažreiz tās radušās kļūdu dēļ, dažreiz – apzināti (piemēram, humoristiski un tiem līdzīgi varianti).</u>
			
			<br clear="all"><br>	

			<i>Ir daudz variantu ar Lorem Ipsum teksta fragmentiem, bet lielākajā daļā no tiem ir veikti dažāda veida labojumi, piemēram, humoristiski iespraudumi vai nejauši vārdi, kas pat aptuveni nav līdzīgi latīņu valodai. Ja jums ir nepieciešams Lorem Ipsum teksta fragments jums ir jābūt pārliecinātiem, ka tekstā nav nekā nepieņemama. Bez tam visi internetā esošie Lorem Ipsum ģeneratori, pārsvarā izmanto vienu un to pašu teksta fragmentu, kas tiek atkārtots, lai iegūtu vajadzīgo teksta daudzumu.</i> 

			<br><br>
			<img src="images/oblachnaya_buchgalneriya_1.jpg" alt="" style="width: 300px; float: right; margin-left: 20px;">

			Pretēji vispārpieņemtai pārliecībai, Lorem Ipsum nav teksts bez satura. Tā pirmsākums meklējams 45.gadā p.m.ē.
			Richard McClintock, latīņu valodas profesors no Hampden-Sydney koledžas, Virdžīnijā, izvēlējās vienu no Lorem Ipsum visneparastākajiem vārdiem "consectetur" un sāka nodarboties ar tā meklēšanu klasiskajā latīņu valodas literatūrā un atrada neapšaubāmu pirmavotu. Lorem Ipsum aizgūts no grāmatas "de Finibus Bonorum et Malorum" ("Par labā un ļaunā robežām") 1.10.32 un 1.10.33. nodaļām, kuru 45.gadā p.m.ē. sarakstījis Cicerons. Šis traktāts par ētikas teoriju bija ļoti populārs Renesanses periodā.

			<br clear="all"><br>
			Tas izmanto vārdnīcu ar vairāk kā 200 latīņu valodas vārdiem, kā arī vairākus teikumu struktūras veidošanas paraugus, kā rezultātā, iegūtais Lorem Ipsum ir teksta principiem atbilstošs, tajā nav rindkopas, kas atkārtojas, iestarpināti humoristiski vai neesoši vārdi.
		</div>

		<div class="comments col-sm-14">
			<div class="com-heading">Reģistrēto lietotāju komentāri:</div> <br>
			';

			if(isset($_SESSION['auth_id'])) {
				print '
			<div class="com-form">
				<form method="post" action="">
					<input type="hidden" name="author" value="'.$user_name.'">
					Komentāri: <br>
					<textarea name="text" cols="50" rows="3"></textarea> <br><br>
					<input type="submit" name="com" value="Pievienot" class="">
				</form>
			</div>
				';
			}

			$sql_last_com = mysql_query("SELECT * FROM comments ORDER BY id DESC LIMIT 3") or die(mysql_error());

			while($res_last_com = mysql_fetch_assoc($sql_last_com)) {
				print '
			<div class="com-box">'.$res_last_com['com_date'].' / <strong>'.$res_last_com['com_user'].':</strong> <br><br> '.$res_last_com['com_text'].''; if($_SESSION['status'] == 'admin') print '<a href="?do=del&id='.$res_last_com['id'].'" class="del-com">Dzēst</a>'; print'</div>';
			}

			print '
			
			<div class="show-com"><a href="#" id="toggle" class="all-com">Visi komentāri (parādīt/aizvērt)</a></div>

			<div style="display: none;" id="com-list">';

			$sql_com_num = mysql_query("SELECT COUNT(id) FROM comments LIMIT 1") or die(mysql_error());
			$res_com_num = mysql_fetch_array($sql_com_num);
			$com_num = $res_com_num[0];

			$sql_all_com = mysql_query("SELECT * FROM comments ORDER BY id DESC LIMIT 3, ".$com_num."") or die(mysql_error());

			while($res_all_com = mysql_fetch_assoc($sql_all_com)) {
				print '
				<div class="com-box">'.$res_all_com['com_date'].' / <strong>'.$res_all_com['com_user'].':</strong> <br><br> '.$res_all_com['com_text'].''; if($_SESSION['status'] == 'admin') print '<a href="?do=del&id='.$res_all_com['id'].'" class="del-com">Dzēst</a>'; print'</div>';
			}

			print '
			</div>
		</div>

		<div class="bottom col-sm-14">
			&copy; Larisa Gordijeviča, 2016.
		</div>
	</div>

</body>
</html>';

?>