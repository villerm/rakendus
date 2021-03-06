<?php
    $id = $_REQUEST["photoId"];
    $rating = $_REQUEST["rating"];
    require("../classes/Session.class.php");
    SessionManager::sessionStart("vr20", 0, "/~viller.maine/", "tigu.hk.tlu.ee");
    require('../../../../config.php');
    $database = 'villermaine';
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $database);
    $firstError = $conn->error;
    $stmt = $conn->prepare("INSERT INTO vr20_photoratings (photoid, userid, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id, $_SESSION["userid"], $rating);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("SELECT AVG(rating) FROM vr20_photoratings WHERE photoid=?");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($score);
    $stmt->execute();
    $stmt->fetch();

    $stmt->close();
    $conn->close();
    echo round($score,2);