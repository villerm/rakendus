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
</body>
</html>