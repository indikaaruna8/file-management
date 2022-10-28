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

/**
 * Manage http request
 *
 * @author indikaaruna
 */
class Request {

    const DEFAULT_CONTROLLER = "Index", DEFAULT_ACTION = "index";

    private static $instance;
    private $action;
    private $controller;
    private $requestType;
    private $uri;
    private $uriParts;
    private $uriIndexStart;
    private $controllerName;
    private $controllerFileName;
    private $actionName;

    private function __construct() {
        $this->initRequest();
    }

    /**
     *  singletant objecg 
     * @return Config 
     */
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    private function initRequest() {
        $this->uriIndexStart = (URL_ALLIAS == "") ? 0 : 1;
        $this->uri = strtok($_SERVER["REQUEST_URI"],"?");
        $this->uriParts = explode("/", $this->uri);
        $this->uriParts = is_array($this->uriParts) ? $this->uriParts : array();
        $this->setAction();
        $this->setContoller();
        $this->setControllerName();
        $this->setControllerFileName();
        $this->setActionName();
    }

    private function getUriParts($index) {
        if (isset($this->uriParts[$index])) {

            return $this->uriParts[$index];
        }
    }

    /**
     * identify the  controller
     */
    private function setContoller() {
        $controllerText = $this->getUriParts($this->uriIndexStart + 1);

        if ("" != $controllerText) {
            $controllerText = preg_replace("/[^A-Za-z0-9\-]/", '', $controllerText);
            if (false !== strpos($controllerText, "-")) {
                foreach (explode("-", $controllerText) as $key => $value) {
                    $this->controller.= ("" != $value) ? ucfirst(strtolower($value)) : "";
                }
            } else {
                $this->controller = ucfirst($controllerText);
            }
        }
        $this->controller = ("" == $this->controller) ? self::DEFAULT_CONTROLLER : $this->controller;
    }

    /**
     * identify the Action
     */
    private function setAction() {
        $actionText = $this->getUriParts($this->uriIndexStart + 2);

        if ("" != $actionText) {

            $actionText = preg_replace("/[^A-Za-z0-9\-]/", '', $actionText);

            if (false !== strpos($actionText, "-")) {
                foreach (explode("-", $actionText) as $key => $value) {
                    if (0 == $key) {
                        $this->action = strtolower($value);
                    } else {
                        $this->action.= ("" != $value) ? ucfirst(strtolower($value)) : "";
                    }
                }
            } else {

                $this->action = strtolower($actionText);
            }
        }
        $this->action = ("" == $this->action) ? self::DEFAULT_ACTION : $this->action;
    }
    
    /**
     * set Controller name
     */
    private function setControllerName() {
        $this->controllerName = $this->controller . "Controller";
    }
    
    /**
     * set controler file name
     */
    private function setControllerFileName() {
        $this->controllerFileName = $this->controller . "Controller.php";
    }

    private function setActionName() {
        $this->actionName =  $this->action. "Action";
    }

    public function getAction() {
        return $this->action;
    }

    public function getController() {
        return $this->controller;
    }
    public function getControllerName() {
        return $this->controllerName;
    }

    public function getControllerFileName() {
        return $this->controllerFileName;
    }

    public function getActionName() {
        return $this->actionName;
    }
    
    /**
     * 
     * @param string $key
     * @param mixed $default default value for variavle
     * @return mixed 
     */
    function httpGet($key,$default=""){
        
        if(isset($_GET[$key])){ return $_GET[$key]; }
        
        return $default;
    }
    
    /**
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function httpPost($key,$default=""){
        if(isset($_POST[$key])) return $_POST[$key];
        return $default;
    }


}
