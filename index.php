<?php
include_once 'classes/main.php';

$Projectiles = new Projectiles(getcwd());



/*
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ProjecTiles</title>
<link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="intro-banner">
    <div class="intro-text">
        <div class="intro-text-bg">
            <h3><?php echo $lang['intro-text-title']; ?></h3>
            <div class="column-container">
                <?php foreach($lang['intro-text-list'] as $txt) { ?>
                    <div class="column"><?php echo $txt; ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="login-form">
        <h3><?php echo $lang['login-form-title']; ?></h3>
        <input type="text" name="uname" id="uname" placeholder="<?php echo $lang['login-form-uname'] ?>">
        <input type="password" name="upass" id="upass" placeholder="<?php echo $lang['login-form-upass'] ?>">
    </div>
</div>
</body>
</html> */