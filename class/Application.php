<?php

/*
 *   _$$$$$__ _$$__ _______ _______ ______ _______ _$$__ _______
 *   $$___$$_ _$$__ $$__$$_ $$$$$__ ______ $$$$$__ _$$__ $$$$$__
 *   _$$$____ _____ $$__$$_ ____$$_ $$_$$_ ____$$_ $$$$_ ____$$_
 *   ___$$$__ _$$__ _$$$$$_ _$$$$$_ $$$_$_ _$$$$$_ _$$__ _$$$$$_
 *   $$___$$_ _$$__ ____$$_ $$__$$_ $$____ $$__$$_ _$$__ $$__$$_
 *   _$$$$$__ $$$$_ $$$$$__ _$$$$$_ $$____ _$$$$$_ __$$_ _$$$$$_ 
 */
 

/**
 * Application render 
 *
 * @author indikaaruna
 */
class Application extends Base {

    //put your code here
    private $controllerObject;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Check controller exist
     * @return boolean
     */
    private function isControllerExists() {
        //echo CONTROLLER_PATH . $this->request->getControllerFileName();
        if (file_exists(CONTROLLER_PATH . $this->request->getControllerFileName())) {

            include_once  CONTROLLER_PATH . $this->request->getControllerFileName();
            return true;
        }


        return false;
    }
    
    /**
     *  Initialize the system. 
     */
    public function init() {
        
        if ($this->isControllerExists()) {

            if (class_exists($this->request->getControllerName())) {
                $controller = $this->request->getControllerName();
                $this->controllerObject = new $controller ();


                if (!method_exists($this->controllerObject, $this->request->getActionName())) {

                    $this->systemError->setSystemError("Action Not found", TRUE, "06003");
                }
            } else {

                $this->systemError->setSystemError("Controller class Not found", TRUE, "06002");
            }
        } else {
            $this->systemError->setSystemError("Controller Not found", TRUE, "06001");
        }
      
    }
    
    /**
     * render the action 
     * @return mixed
     */
    public function renderAction() {
        $content = "";
       

        if (!is_null($this->controllerObject)) {
            $action = $this->request->getActionName();
            return  $this->controllerObject->$action();
        } 

    }
    

}
