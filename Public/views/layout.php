<?php 
if (!isset($has_name) ) {
    $has_name = true;
}

if (!isset($title) ) {
    $title = 'Social';
}

if (!isset($style) ) {
    $style = '';
}

if (!isset($header) ) {
    $header = 'header.php';
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <?php if ($local ): ?>
            <base href="http://localhost/Sites/Social/Public/">
        <?php else: ?>
            <base href="http://social.gavadinov.com/">
        <?php endif ?>
        
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>       
        <?= $style ?>
        <link rel="stylesheet" href="css/bootstrap.css">        
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
        <script src='js/vendor/jQuery.js'></script>
        <script src="js/vendor/moment.js"></script>
        <script src="js/vendor/livestamp.js"></script>
        
        <?php 
        
        if (isset($script_top) ) {
            echo $script_top;
        }
        
        ?>
    </head>
    <body>
    	<?php include $header; ?>
        <div class="cont container-fluid">
            <?php include $path; ?>
        </div>
        <?php if (!$has_name): ?>
            <?php include 'views/add_name.php'; ?>
        <?php endif ?>
        
        <footer>
        	<div id="version">
                <p>Test Version #11</p>
            </div>
        </footer>
        
        <script src='js/main.js'></script>
        <script src='js/vendor/bootstrap.min.js'></script>
        <script src='js/vendor/jquery.mCustomScrollbar.concat.min.js'></script>
        
        <?php if (isset($u) ): ?>
            <script src='js/ws.js'></script>
            <?php include 'views/search.view.php'; ?>
        <?php endif ?>

        <?php 
        
        if (isset($script_bottom) ) {
            echo $script_bottom;
        }
        
        ?>
    </body>
</html>