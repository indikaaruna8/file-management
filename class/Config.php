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
 *  Manage Configuration data
 *
 * @author indikaaruna
 */
class Config {
    
    /**
     *   
     * @var Config 
     */
    private static $instance;
    
    private $configSetting;

    /**
     * Prevent to make duplicate copy this constructor is private 
     */
    private function __construct() {
        $this->readConfigFile();
    }
    /**
     *  singletant objecg 
     * @return Config 
     */
    public static function getInstance(){
        if(!isset(self::$_instance)) self::$instance= new self();
       
       return self::$instance;
    }
   
    /**
     * read config file
     * @return \Config
     */
    private function readConfigFile(){
        if(file_exists(CONFIG_FILE_PATH)){
            if(is_readable ( CONFIG_FILE_PATH )) {
                $this->configSetting= parse_ini_file(CONFIG_FILE_PATH);
                //print_r($this->configSetting);
            }else{
                SystemError::getInstance()->setSystemError("Configuration file is  not readable.", TRUE,"02002"); 
            }
        }else{
            SystemError::getInstance()->setSystemError("Configuration file is  not exists. ", TRUE,"02001");
        }
       return $this;
    }
    
    /**
     * 
     * @param string $key
     * @return mixed
     */
    function get($key){
        if(isset($this->configSetting[$key])){
            return $this->configSetting[$key];
        }
        return "";
    }
    
}
