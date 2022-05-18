<?php

class Professor extends Controller {

    function __construct() {
        parent::__construct();
        //Auth::autentica();
        $this->view->js = array('professor/professor.js');
        $this->view->css = array('professor/professor.css');
    }
    
    function index() {
        $this->view->title = 'Gerenciamento de Professores';
		$this->view->render('header');
		$this->view->render('footer');
    }
     function addProfessor()
    {
        $this->model->insert();
    }
    
	function listaProfessor()
    {
        $this->model->listaProfessor();
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
}