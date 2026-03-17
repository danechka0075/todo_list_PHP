<?php
$pages = ['home', 'formReg', 'formVhod', 'tasks', 'profile'];
$page = isset($_GET['page']) ? $_GET['page']: 'home';
if(!in_array($page, $pages))
    {
        $page = '404';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
    include_once("header.php");
    include("$page.php");
    include_once("footer.php");
    ?>
</body>
</html>