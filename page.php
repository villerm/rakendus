<?php 
    $myName = "Viller Maine";
    $fullTimeNow = date("d.m.Y H:i:s");
    $hourNow = date("H");
    $timeHTML = "<p>Lehe avamise hetkel oli: <strong>".$fullTimeNow."<strong></p>";
    $partOfDay = "Hägunea aeg";

    if($hourNow < 10):
        $partOfDay = "hommik";
    elseif( $hourNow >= 10 && $hourNow < 18 ):
        $partOfDay = "aeg õppida!";
    else:
        $partOfDay = "puhka nüüd!";
    endif;

    //info semestri kulgemise kohta
    $semesterStart = new DateTime("2020-1-27");
    $semesterEnd = new DateTime("2020-6-22");
    $semesterDuration = $semesterStart->diff($semesterEnd);
    $today = new DateTime("now"); 
    $fromSemesterStart = $semesterStart->diff($today);

    //pildid
    $imgDir = "../images/";
    $allFiles = array_slice(scandir($imgDir), 2);
    print_r($allFiles);
?>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veebirakendus | Viller Maine</title>
</head>
<body>
    <h1><?php echo $myName;?></h1>
    <?php echo $timeHTML; ?>
    <?php echo $partOfDay; ?>
    <?php if($fromSemesterStart->days < $semesterDuration->days):?>
        <p>Semester on hoos:</p>
        <progress value="<?php echo $fromSemesterStart->days; ?>" min="0" max="<?php echo $semesterDuration->days; ?>" style="height:34px;width:200px;">>
        </progress>
    <?php else:?>
        <p>Semester on läbi!</p>
    <?php endif;?>
</body>
</html>