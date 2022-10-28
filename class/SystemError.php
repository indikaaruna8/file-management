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
include 'Error.php';

class SystemError {

    /**
     *
     * @var array
     */
    private $systemErrors = array();

    /**
     *
     * @var SystemError
     */
    private static $instance;

    /**
     * 
     * @return SystemError
     */
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * 
     * @return array
     */
    function getSystemErrors() {
        return $this->systemErrors;
    }

    function getReportedError() {
        $errors = array();
        foreach ($this->systemErrors as $errorObject) {

            if ($errorObject->getReport()) {
                $errors[] = $errorObject;
            }
        }
        return $errors;
    }

    /**
     * 
     * @param string $message
     * @param string $report
     * @param string  $corde
     * @return \SystemError
     */
    function setSystemError($message, $report = true, $corde = "") {

        $this->systemErrors[] = new Error($message, $report, $corde);
        return $this;
    }

    /**
     * 
     * @return int
     */
    public function getErrorCount() {
        return count($this->systemErrors);
    }

}
