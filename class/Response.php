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
 * manage http response. set headers 
 *
 * @author indikaaruna
 */
class Response {

    private $header = array();
    private $hideLayout = false;
    private $isJasonResponse ;
    //put your code here
    private static $instance;

    private  function __construct() {
       
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

    public function getHideLayout() {
        return $this->hideLayout;
    }

    public function setHideLayout($hideLayout) {
        $this->hideLayout = $hideLayout;
    }

    public function setHader($key, $value) {
        $this->header[$key] = $value;
    }

    public function setIsJasonResponse($isJasonResponse) {

        $this->isJasonResponse = $isJasonResponse;
       
    }

    public function isJasonResposnse() {

        return $this->isJasonResponse;
    }

}
