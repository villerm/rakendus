<?php

require("../classes/Session.class.php");
require("../classes/valmis.class.php");
require("../classes/Photo.class.php");
SessionManager::sessionStart("vr20", 0, "/Kool/Veebirakendus/rakendus/", "localhost");
//login välja
if(isset($_GET["logout"])){
    session_destroy();
    $_SESSION = [];
    header("Location: index.php");
}
//puhastamise funktsioon
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function saveNews($userid, $title, $content)
{
    $response = null;
    //andmebaasi yhendus
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $GLOBALS['database']);
    //sql paring
    $stmt = $conn->prepare('INSERT INTO vr_news (userid, title, content) VALUES (?, ?, ?)');
    echo $conn->error;
    //annan paringule paris andmed
    $userid = 1;
    // i=int s=string d=decimal
    $stmt->bind_param("iss", $userid, $title, $content);
    if ($stmt->execute()) {
        $response = 1;
    } else {
        $response = 0;
        echo $stmt->error;
    }
    //sulgen paringu ja andmebaasi yhenduse
    $stmt->close();
    $conn->close();
    return $response;
}
function readNews($count){
    $database = 'villermaine';
    $response = null;
    if($count == NULL){
        $count = -1;
    }
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
    //sql paring
    $stmt = $conn->prepare('SELECT title, content, created FROM vr_news WHERE deleted IS NULL ORDER BY created DESC LIMIT ?');
    echo $conn->error;
    $stmt->bind_param('i', $count);
    $stmt->bind_result($title, $content, $created);
    $stmt->execute();
    while($stmt->fetch()){
        $response .= '<div class="card col-md-4"><div class="card-body"><h5 class="card-title">'.$title.'</h5>';
        $response .= '<h6 class="card-subtitle mb-2 text-muted">'.date('d.M Y H:i',strtotime($created)).'</h6>';
        $response .= '<p class="card-text">'.$content.'</p></div></div>';
    }
    if($response == null){
        $response = '<h2>Uudiseid pole!</h2>';
    }
    //sulgen paringu ja andmebaasi yhenduse
    $stmt->close();
    $conn->close();
    return $response;
}
function saveActivity($course, $elapsedTime, $content){
    $database = 'villermaine';
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
    //sql paring
    $stmt = $conn->prepare('INSERT INTO vr20_studylog (course, activity, time) VALUES (?, ?, ?)');
    echo $conn->error;
    $stmt->bind_param('isd', $course, $content, $elapsedTime);
    if ($stmt->execute()) {
        $response = 1;
    } else {
        $response = 0;
        echo $stmt->error;
    }
    //sulgen paringu ja andmebaasi yhenduse
    $stmt->close();
    $conn->close();
    return $response;
}
function readActivity(){
    $database = 'villermaine';
    $courseNames = array(
        'Disaini alused',
        'Sissejuhatus tarkvaraarendusse',
        'Sissejuhatus informaatikasse',
        'Andmebaasid',
        'Videomängude disain',
        'Üld- ja sotsiaalpsühholoogia'
    );
    $activityName = array(
        'Iseseisev materjali omandamine',
        'Koduste ülesannete lahendamine',
        'Kordamine',
        'Rühmatööd'
    );
    $response = NULL;
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
    //sql paring
    $stmt = $conn->prepare('SELECT course, activity, time, day FROM vr20_studylog ORDER BY day DESC');
    echo $conn->error;
    $stmt->bind_result($course, $activity, $time, $day);
    $stmt->execute();
    while($stmt->fetch()){
        $response .= '<tr>';
        $course = $course-1;
        $activity = $activity-1;
        $response .= '<td>'.$courseNames[$course].'</td>';
        $response .= '<td>'.$activityName[$activity].'</td>';
        $response .= '<td>'.$time.'</td>';
        $response .= '<td>'.date('d.M Y H:i',strtotime($day)).'</td>';
        $response .= '</tr>';
    }
    if($response == null){
        $response = '<td><h2>Logid puuduvad!</h2></td>';
    }
    //sulgen paringu ja andmebaasi yhenduse
    $stmt->close();
    $conn->close();
    return $response;
}
    
$notice = null;
$name = null;
$surname = null;
$email = null;
$gender = null;
$birthMonth = null;
$birthYear = null;
$birthDay = null;
$birthDate = null;
$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];

//muutujad võimalike veateadetega
$nameError = null;
$surnameError = null;
$birthMonthError = null;
$birthYearError = null;
$birthDayError = null;
$birthDateError = null;
$genderError = null;
$emailError = null;
$passwordError = null;
$confirmpasswordError = null;

//kui on uue kasutaja loomise nuppu vajutatud
if(isset($_POST["submitUserData"])){
  //kui on sisestatud nimi
  if(isset($_POST["firstName"]) and !empty($_POST["firstName"])){
      $name = test_input($_POST["firstName"]);
  } else {
      $nameError = "Palun sisestage eesnimi!";
  } //eesnime kontrolli lõpp
  
  if (isset($_POST["surName"]) and !empty($_POST["surName"])){
      $surname = test_input($_POST["surName"]);
  } else {
      $surnameError = "Palun sisesta perekonnanimi!";
  }
  
  if(isset($_POST["gender"])){
      $gender = intval($_POST["gender"]);
  } else {
      $genderError = "Palun märgi sugu!";
  }

  //kontrollime, kas sünniaeg sisestati ja kas on korrektne
    if(isset($_POST["birthDay"]) and !empty($_POST["birthDay"])){
        $birthDay = intval($_POST["birthDay"]);
    } else {
        $birthDayError = "Palun vali sünnikuupäev!";
    }
    
    if(isset($_POST["birthMonth"]) and !empty($_POST["birthMonth"])){
        $birthMonth = intval($_POST["birthMonth"]);
    } else {
        $birthMonthError = "Palun vali sünnikuu!";
    }
    
    if(isset($_POST["birthYear"]) and !empty($_POST["birthYear"])){
        $birthYear = intval($_POST["birthYear"]);
    } else {
        $birthYearError = "Palun vali sünniaasta!";
    }
    
    //vaja ka kuupäeva valiidsust kontrollida ja kuupäev kokku panna
    if(empty($birthMonthError) and empty($birthYearError) and empty($birthDayError)){
        if(checkdate($birthMonth, $birthDay, $birthYear)){
            $tempDate = new DateTime($birthYear ."-" .$birthMonth ."-" . $birthDay);
            $birthDate = $tempDate->format("Y-m-d");
        } else {
            $birthDateError = "Valitud kuupäev on vigane!";
        }
    }
    
  //email ehk kasutajatunnus
  
    if (isset($_POST["email"]) and !empty($_POST["email"])){
      $email = test_input($_POST["email"]);
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);
      if ($email === false) {
          $emailError = "Palun sisesta korrektne e-postiaadress!";
      }
    } else {
        $emailError = "Palun sisesta e-postiaadress!";
    }
    
    //parool ja selle kaks korda sisestamine
    
    if (!isset($_POST["password"]) or empty($_POST["password"])){
      $passwordError = "Palun sisesta salasõna!";
    } else {
        if(strlen($_POST["password"]) < 8){
            $passwordError = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["password"]) ." märki).";
        }
    }
    
    if (!isset($_POST["confirmpassword"]) or empty($_POST["confirmpassword"])){
      $confirmpasswordError = "Palun sisestage salasõna kaks korda!";  
    } else {
        if($_POST["confirmpassword"] != $_POST["password"]){
            $confirmpasswordError = "Sisestatud salasõnad ei olnud ühesugused!";
        }
    }

  
  //Kui kõik on korras, salvestame
  if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($birthDateError) and empty($genderError) and empty($emailError) and empty($passwordError) and empty($confirmpasswordError)){
      $notice = signUp($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
      if($notice == "ok"){
          $notice = "Uus kasutaja on loodud!";
          $name = null;
          $surname = null;
          $email = null;
          $gender = null;
          $birthMonth = null;
          $birthYear = null;
          $birthDay = null;
          $birthDate = null;
      } else {
          $notice = "Uue kasutaja salvestamisel tekkis tehniline tõrge: " .$notice;
      }
  }//kui kõik korras
  
} //kui on nuppu vajutatud

function signUp($name, $surname, $email, $gender, $birthDate, $password){
    $database = 'villermaine';
    $notice = null;
	$conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
	$stmt = $conn->prepare("INSERT INTO vr20_users (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
	echo $conn->error;
	
	//krüpteerin parooli
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	
	$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	
	if($stmt->execute()){
		$notice = "ok";
	} else {
		$notice = $stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}
function signIn($email, $password){
    $database = 'villermaine';
	$notice = null;
	$conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
	$stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vr20_users WHERE email=?");
	$stmt->bind_param("s", $email);
	$stmt->bind_result($idFromDB, $firstnameFromDB, $lastnameFromDB, $passwordFromDB);
	echo $conn->error;
	$stmt->execute();
	if($stmt->fetch()){
		if(password_verify($password, $passwordFromDB)){
			$_SESSION["userid"] = $idFromDB;
			$_SESSION["userFirstName"] = $firstnameFromDB;
			$_SESSION["userLastName"] = $lastnameFromDB;
			
			$stmt->close();
			$conn->close();
			header("Location: index.php");
			exit();
		} else {
			$notice = "Vale salasõna!";
		}
	} else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}
function addPhotoData($userid, $filename, $alttext, $privacy){
    $database = 'villermaine';
    $notice = null;
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
    $stmt = $conn->prepare("INSERT INTO vr20_photos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
    echo $conn->error;
    $stmt->bind_param("issi", $userid, $filename, $alttext, $privacy);
    if($stmt->execute()){
		$notice = 1;
	} else {
		$notice = $stmt->error;
    }
    $stmt->close();
	$conn->close();
	return $notice;
}
