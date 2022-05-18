<?php

class ClasseCurso extends Controller {

    function __construct() {
        parent::__construct();
        //Auth::autentica();
        $this->view->js = array('classecurso/classecurso.js');
        $this->view->css = array('classecurso/classecurso.css');
    }
    
    function index() {
        $this->view->title = 'Gerenciamento de Classes de Curso';
		$this->view->render('header');
		$this->view->render('footer');
    }
     function insert()
    {
        $this->model->insert();
    }
    
	function listaClasse()
    {
        $this->model->listaClasse();
    }

    function selectCurso()
    {
        $this->model->selectCurso();
    }
	
	function del()
    {
        $this->model->del();
    }
	
	function loadData()
    {
        $this->model->loadData();
    }
	
	function save()
    {
        $this->model->save();
    }

    function selCodCurso()
    {
        $this->model->selCodCurso();
    }
}