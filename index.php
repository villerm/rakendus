<?php 
    require('../../../config.php');
    require('header.php');
    $myName = "Viller Maine";
    $fullTimeNow = date("d.m.Y H:i:s");
    $hourNow = date("H");
    $timeHTML = "<p>Lehe avamise hetkel oli: <strong>".$fullTimeNow."<strong></p>";
    $partOfDay = "Hägunea aeg";

    if($hourNow < 10):
        $partOfDay = "hommik";
        $colorMode = 1;
    elseif( $hourNow >= 10 && $hourNow < 18 ):
        $partOfDay = "aeg õppida!";
        $colorMode = 2;
    else:
        $partOfDay = "puhka nüüd!";
        $colorMode = 3;
    endif;

    //info semestri kulgemise kohta
    $semesterStart = new DateTime("2020-1-27");
    $semesterEnd = new DateTime("2020-6-22");
    $semesterDuration = $semesterStart->diff($semesterEnd);
    $today = new DateTime("now"); 
    $fromSemesterStart = $semesterStart->diff($today);
    //pildid
    $imgDir = "../images/";
    $imgTypesAllowed = ["image/jpeg", "image/png"];
    $imgList = [];
    $allFiles = array_slice(scandir($imgDir), 2);
    $randomFileNumbers = [];
    foreach($allFiles as $file){
        $fileInfo = getimagesize($imgDir .$file);
        if(in_array($fileInfo["mime"], $imgTypesAllowed)){
            array_push($imgList, $file);
        }
    }
    $imgCount = count($imgList);
    if($imgCount > 0):
        $imgNum = mt_rand( 0, $imgCount-1 );
    endif;
    //muudame piltide järjekordi suvaliselt
    shuffle($imgList);
    //print_r($imgList);
?>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veebirakendus | Viller Maine</title>
    <style>
        <?php if($colorMode == 1):?>
        body{
            background:#fff;
            color:#000;
        }
        <?php elseif($colorMode == 2):?>
        body{
            background:#ccc;
            color:#000;
        }
        <?php else: ?>
        body{
            background:#000;
            color:#ccc;
        }
        <?php endif;?>
    </style>
</head>
<body>
    <div class="container">
    <h1><?php echo $myName;?></h1>
    <?php echo $timeHTML; ?>
    <?php echo $partOfDay; ?>
    <?php if($fromSemesterStart->days < $semesterDuration->days && $fromSemesterStart->invert != 1):?>
        <p>Semester on hoos:</p>
        <progress value="<?php echo $fromSemesterStart->days; ?>" min="0" max="<?php echo $semesterDuration->days; ?>" style="height:34px;width:200px;">>
        </progress>
    <?php elseif($fromSemesterStart->invert == 1):?>
        <p>Semester pole veel alanudki</p>
    <?php else:?>
        <p>Semester on läbi!</p>
    <?php endif;?>
    <div>
        <h3>Kolm suvalist pilti ka siia</h3>
        <?php 
        //prindime 3 pilti arrayst
        for ($i=0; $i<3; $i++){
            echo '<img src="'.$imgDir.$imgList[$i].'" alt="pilt" style="max-width:250px;height:auto;"></img>';
        };
        ?>
    </div>
    </div>
    <hr>
    <div class="container">
        <h2>Uudised</h2>
        <div class="row">
            <?php echo readnews(6);?>
        </div>
    </div>
    <hr>
    <div class="container">
    <h2>Logid</h2>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Aine nimetus</th>
                <th scope="col">Kirjeldus</th>
                <th scope="col">Kulunud aeg</th>
                <th scope="col">Lisatud</th>
                </tr>
            </thead>
            <?php echo readActivity();?>
        </table>
    </div>
</body>
</html>