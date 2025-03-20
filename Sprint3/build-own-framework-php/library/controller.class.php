<?php
class Controller {

    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;

    function __construct($model, $controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = new $model();
        // Instantiate the model and template objects
//        $this->_model = new $model;  // No reference needed for model
       $this->_template = new Template($controller, $action);  // Template initialization
    }

    function set($name, $value) {
        $this->_template->set($name, $value);
    }

    function __destruct() {
        $this->_template->render();
    }
}
