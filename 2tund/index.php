<?php
require('../../../../config.php');
require('functions.php');
$newsTitle = null;
$newsContent = null;
$newsError = null;
$database = 'villermaine';
if (isset($_POST['newsSubmit'])) :
    if (isset($_POST['newsTitle']) && !empty(test_input($_POST['newsTitle']))) :
        $newsTitle = test_input($_POST['newsTitle']);
    else :
        $newsError = "Uudise pealkiri on tühi! ";
    endif;
    if (isset($_POST['newsContent']) && !empty(test_input($_POST['newsContent']))) :
        $newsContent = test_input($_POST['newsContent']);
    else :
        $newsError .= "Uudise sisu on tühi!";
    endif;
endif;

//puhastamise funktsioon
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (empty($newsError) && isset($newsTitle) && isset($newsContent)) {
    $response = saveNews(1, $newsTitle, $newsContent);
    if ($response == 1) {
        $newsError = 'Uudis on salvestatud!';
        $newsTitle = null;
        $newsContent = null;
    } else {
        $newsError = $response;
    }
}

?>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veebirakendused ja nende loomine</title>
</head>

<style>
    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 15px;
        margin: 20px 0;
    }

    .newsForm label,
    textarea,
    input {
        display: block;
    }

    .newsform label {
        margin-top: 20px;
    }
</style>

<body>
    <div class="container">
        <h1>Uudise lisamine</h1>
        <p>See leht on valminud õppetöö raames!</p>
    </div>
    <div class="container">
        <form class="newsForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="newsTitle">Pealkiri</label>
            <input type="text" name="newsTitle" placeholder="Uudise pealkiri" value="<?php if(isset($newsTitle)){echo $newsTitle; };?>">
            <label for="newsContent">Uudise sisu</label>
            <textarea name="newsContent" id="newsContent" cols="30" rows="10" placeholder="Sisestage uudis"><?php if(isset($newsContent)){echo $newsContent;}; ?></textarea>
            <input type="submit" class="btn btn--submit" value="Salvesta" name="newsSubmit">
            <span><?php if (isset($newsError)) {
                        echo $newsError;
                    }; ?></span>
        </form>
    </div>

</body>

</html>