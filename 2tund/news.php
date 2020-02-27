<?php
require('../../../../config.php');
require('functions.php');
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uudised</title>
</head>
<style>
    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 15px;
        margin: 20px 0;
    }
</style>

<body>
    <div class="container">
        <h1>Uudised</h1>
        <a href='.'>Lisa uudis</a>
    </div>
    <div class="container">
        <?php echo readnews();?>
    </div>
</body>

</html>