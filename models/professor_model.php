<?php

class Professor_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listaProfessor()
    {
        $sql = "SELECT
                    p.username,
                    c.nomecurso,
                    c.codcurso,
                    p.nomecompleto,
                    p.criado 
                from
                    professor_curso_livre p 
                join
                    curso c
                where 
                    c.codcurso = p.cursolivre";
        $result = $this->db->select($sql);
        echo (json_encode($result));
    }

    public function selectCurso()
    {
        $sql=$this->db->select(
            "SELECT
                codcurso,
                nomecurso
            FROM
                curso"
        );
        echo json_encode($sql);
    }

    public function insert()
    {
        $x = json_decode(file_get_contents('php://input'));
        $user = $x->username;
        $curLiv = $x->cursolivre;
        $nomeProf = $x->nomecompleto;
        $txtCriado = $x->criado;

        $result = $this->db->insert('professor_curso_livre',
        array(
            'username' => $user,
            'cursolivre' => $curLiv->codcurso,
            'nomecompleto' => $nomeProf,
            'criado' => $txtCriado
            )
        );
        if ($result) {
            $msg = array("codigo" => 1, "texto" => "Registro inserido com sucesso.");
        } else {
            $msg = array("codigo" => 0, "texto" => "Erro ao inserir.");
        }
        echo (json_encode($msg));
    }

    public function del()
    {
        $x = json_decode(file_get_contents('php://input'));
        $user = $x->username;
        $curLiv = $x->codcurso;
        $msg = array("codigo" => 0, "texto" => "Erro ao Excluir.");
        if ($curLiv > 0) {
            $result = $this->db->delete('professor_curso_livre', "cursolivre='$curLiv' and username='$user'");
            if ($result) {
                $msg = array("codigo" => 1, "texto" => "Registro excluído com sucesso.");
            }
        }
        echo (json_encode($msg));
    }

    public function loadData()
    {
        $x = file_get_contents('php://input');
        $x = json_decode($x);
        $curLiv = (int)$x->codcurso;
        $user = $x->username;
        $result = $this->db->select('SELECT * from professor_curso_livre where cursolivre=:cod and username=:user', array(":cod" => $curLiv, ":user" => $user));
        $result = json_encode($result[0]);
        echo ($result);
    }

    public function save()
    {
        $x = file_get_contents('php://input');
        $x = json_decode($x);
        $curLiv = (int)$x->cursolivre;
        $user = $x->username;
        $nomeProf = $x->nomecompleto;
        $txtCriado = $x->criado;
        $msg = array("codigo" => 0, "texto" => "Erro ao atualizar.");
        if ($curLiv > 0) {
            $dadosSave = array(
                'nomecompleto' => $nomeProf,
                'criado' => $txtCriado
            );

            $result = $this->db->update('professor_curso_livre', $dadosSave, "cursolivre='$curLiv' and username='$user'");
            if ($result) {
                $msg = array("codigo" => 1, "texto" => "Registro atualizado com sucesso.");
            }
        }
        echo (json_encode($msg));
    }
}
