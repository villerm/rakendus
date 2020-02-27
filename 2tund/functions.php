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
function readNews(){
    $database = 'villermaine';
    $response = null;
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $database);
    //sql paring
    $stmt = $conn->prepare('SELECT title, content FROM vr_news');
    echo $conn->error;
    $stmt->bind_result($title, $content);
    $stmt->execute();
    while($stmt->fetch()){
        $response .= '<div class="news"><h2>'.$title.'</h2>';
        $response .= '<p>'.$content.'</p></div>';
    }
    if($response == null){
        $response = '<h2>Uudiseid pole!</h2>';
    }
    //sulgen paringu ja andmebaasi yhenduse
    $stmt->close();
    $conn->close();
    return $response;
}
