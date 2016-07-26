<head>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700|Bitter:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <?php foreach($scripts as $script) { ?>
    <script src="js/<?php echo $script; ?>.js"></script>
    <?php } ?>
</head>