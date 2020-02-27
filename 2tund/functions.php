<?php
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
