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
 * Error 
 *
 * @author indikaaruna
 */
 class Error
 {
     /**
      *
      * @var string
      */
     public $message;
     /**
      *  Report errros for end user. if not it will be loged. 
      * @var boolean
      */
     public $report;
     
     /**
      *
      * @var string 
      */
     public $corde;
     
     /**
      * 
      * @param string $message
      * @param boolean $report
      * @param string $corde
      */
     function __construct($message, $report=true, $corde="") {
         
         $this->message = $message;
         $this->report = $report;
         $this->corde = $corde;
     }

     
     function getMessage() {
         return $this->message;
     }

     function getReport() {
         return $this->report;
     }

     function getCorde() {
         return $this->corde;
     }

     function setMessage($message) {
         $this->message = $message;
     }

     function setReport($report) {
         $this->report = $report;
     }

     function setCorde($corde) {
         $this->corde = $corde;
     }



 }