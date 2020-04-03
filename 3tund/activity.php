<?php
require('header.php');
$database = 'villermaine';

if (isset($_POST['activitySubmit'])) :
    if (isset($_POST['courseName']) && !empty(test_input($_POST['courseName']))) :
        $courseName = test_input($_POST['courseName']);
    else :
        $activityError = "Aine valik on tegemata!";
    endif;
    if (isset($_POST['elapsedTime']) && !empty($_POST['elapsedTime'])) :
        $elapsedTime = $_POST['elapsedTime'];
    else :
        $activityError = "Aega pole sisestatud! ";
    endif;
    if (isset($_POST['content']) && !empty(test_input($_POST['content']))) :
        $content = test_input($_POST['content']);
    else :
        $activityError .= "Sisu on tühi!";
    endif;
endif;

if (empty($activityError) && isset($courseName) && isset($content)) {
    $response = saveActivity($courseName, $elapsedTime, $content);
    if ($response == 1) {
        $activityError = 'Logi on salvestatud!';
        $elapsedTime = null;
        $content = null;
    } else {
        $activityError = $response;
    }
}
?>
<body>
    <div class="container">
        <a href='.'>Tagasi</a>
        <h2>Sisesta uus logi</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="courseName">Aine</label>
                <select name="courseName" id="courseName" class="form-control">
                    <option selected value="1">Disaini alused</option>
                    <option value="2">Sissejuhatus tarkvaraarendusse</option>
                    <option value="3">Sissejuhatus informaatikasse</option>
                    <option value="4">Andmebaasid</option>
                    <option value="5">Videomängude disain</option>
                    <option value="6">Üld- ja sotsiaalpsühholoogia</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="content">Tegevus</label>
                <select name="content" id="content" class="form-control">
                    <option selected value="1">Iseseisev materjali omandamine</option>
                    <option value="2">Koduste ülesannete lahendamine</option>
                    <option value="3">Kordamine</option>
                    <option value="4">Rühmatööd</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="elapsedTime">Kulunud aeg</label>
                <input type="number" class="form-control" min=".25" max="24" step=".25" name="elapsedTime">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="activitySubmit">Salvesta</button>
        <?php if (isset($activityError)) {
                    $alertType = 'danger';
                    if($activityError == 'Logi on salvestatud!'){
                        $alertType = 'success';
                    }
                        echo '<div class="alert alert-'.$alertType.'" role="alert">'.$activityError.'</div>';
                    }; ?>
        </form>
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