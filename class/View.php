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
 * render views
 *
 * @author indikaaruna
 */
class View {

    private $data;

    function __construct() {
        $this->data = new ViewData();
    }

    /**
     * 
     * @param type $view  file name of the view
     * @param type $viewData data for view 
     * @return mixed
     */
    public function renderView($view, $viewData = null) {
        if (!is_null($viewData)) {
            $this->data = $viewData;
        }
        ob_start();
        include $view;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}
