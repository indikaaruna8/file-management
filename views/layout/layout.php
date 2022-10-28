<?php

function layout_header() {
    ?><!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    This is the file used for installation

    -->
    <html>
        <head>
            <title>File And Folder Management</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="/<?php echo URL_ALLIAS ?>/resources/js/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
            <link href="/<?php echo URL_ALLIAS ?>/resources/css/main.css" rel="stylesheet" type="text/css"/>
           
            <link href="/<?php echo URL_ALLIAS ?>/resources/js/jquery/ui-1.11.2/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
            <script src="/<?php echo URL_ALLIAS ?>/resources/js/jquery/ui-1.11.2/jquery-ui.min.js" type="text/javascript"></script>
            
            

            <script>
                var siteUrl = "/<?php echo URL_ALLIAS ?>/";
            </script>
        </head>
    </head>
    <body>
        <?php
//     echo substr(sprintf('%o', fileperms('/tmp')), -4);
//  echo substr(sprintf('%o', fileperms(CONFIG_FILE_PATH)), -4);
//  echo FileAndFolder::getPermitions(CONFIG_FILE_PATH);
//    
        ?>

        <div id="container">
            <?php
        }

        function layout_footer() {
            ?>

        </div>
    </body>
    <script src="/<?php echo URL_ALLIAS ?>/resources/js/folder-manage.js" type="text/javascript"></script>

    </html>
    <?php
}
?>
