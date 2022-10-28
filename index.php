<?php
/*
 *   _$$$$$__ _$$__ _______ _______ ______ _______ _$$__ _______
 *   $$___$$_ _$$__ $$__$$_ $$$$$__ ______ $$$$$__ _$$__ $$$$$__
 *   _$$$____ _____ $$__$$_ ____$$_ $$_$$_ ____$$_ $$$$_ ____$$_
 *   ___$$$__ _$$__ _$$$$$_ _$$$$$_ $$$_$_ _$$$$$_ _$$__ _$$$$$_
 *   $$___$$_ _$$__ ____$$_ $$__$$_ $$____ $$__$$_ _$$__ $$__$$_
 *   _$$$$$__ $$$$_ $$$$$__ _$$$$$_ $$____ _$$$$$_ __$$_ _$$$$$_ 
 * 
 * 
 */
 
ob_start();
define("CONFIG_FILE_PATH", "/Users/indikaaruna/Sites/antlabs/phpfm.ini");
define("URL_ALLIAS", "antlabs");
define("APPLICATION_PATH", getcwd());
define("CONTROLLER_PATH", APPLICATION_PATH . DIRECTORY_SEPARATOR . "controller" . DIRECTORY_SEPARATOR);
define("VIEW_PATH", APPLICATION_PATH . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR);

include_once "class/Config.php";
include_once "class/FileAndFolder.php";
include_once "class/SystemError.php";
include_once "class/Base.php";
include 'class/Request.php';
include 'class/Response.php';
include_once 'class/Application.php';
include_once 'class/View.php';
include_once 'class/ViewData.php';
include_once "views/layout/layout.php";

$application = new Application();
$application->init();

$response = Response::getInstance();

$content = $application->renderAction();

$errors = SystemError::getInstance()->getReportedError();

if ($response->isJasonResposnse()) {
    $output = array(
        "errorCount" => count($errors),
        "errors" => (count($errors) > 0) ? $errors : "",
        "data" => $content
    );
    ob_end_clean();
    //header('Content-Type: application/json');
    echo json_encode($output);
} else if (!$response->getHideLayout()) {

    layout_header();
    echo $content;
    layout_footer();
} else {

    echo $content;
}
ob_end_flush();

//$req = Request::getInstance();
//echo "<br>" . $req->getAction();
//echo "<br>" . $req->getController();

