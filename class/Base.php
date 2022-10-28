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
 * Basic Objcts are stored in this file. 
 *
 * @author indikaaruna
 */
class Base {
    //put your code here
    protected $systemError;
    
    protected $config;
    
    protected  $request;
    
    protected $view;
    protected  $response;
     
    /**
     * 
     */
    function __construct() {
        $this->systemError= SystemError::getInstance();
        $this->config=  Config::getInstance();
        $this->request= Request::getInstance();
        $this->view =  new View();
        $this->response= Response::getInstance();
    }
    /**
     * gte system erros
     * @return objct
     */
    function getSystemError() {
        return $this->systemError;
    }
    /**
     * 
     * @return object
     */
    function getConfig() {
        return $this->config;
    }


}
