<?php
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
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $GLOBALS['database']);
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
    $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUserName'], $GLOBALS['serverPassword'], $GLOBALS['database']);
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