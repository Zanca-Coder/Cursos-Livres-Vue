<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        //Auth::autentica();
        $this->view->js = array('index/index.js');
        $this->view->css = array('index/index.css');
    }
    
    function index() {
        $this->view->title = 'Página Inicial';
		$this->view->render('header');
		$this->view->render('footer');
    }
    
}