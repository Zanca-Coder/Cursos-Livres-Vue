<?php

class ClasseCurso_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listaClasse()
    {
        $sql=$this->db->select(
            "SELECT
                    *
            FROM
                classe_curso_livre"
        );
        echo json_encode($sql);
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
        $codCur = $x->codcurso->codcurso;
        $txtAno = $x->ano;
        $txtSem = $x->semestre;
        $txtDesc = $x->descricao;
        $txtTerm = $x->termo->tipo;
        $txtTurma = $x->turma;
        $txtIdPai = $x->idcategoriapaimoodle;
        $codTipCur = $x->codtipocurso->tipo;

        $result=$this->db->insert('classe_curso_livre',
        array('codcurso' => $codCur,
              'ano' => $txtAno,
              'semestre' => $txtSem,
              'descricao' => $txtDesc,
              'termo' => $txtTerm,
              'turma' => $txtTurma,
              'idcategoriapaimoodle' => $txtIdPai,
              'codtipocurso' => $codTipCur
            ));
        if($result){
            $msg=array("codigo"=>1, "texto"=>"Registro inserido com sucesso.");
        }
        else{
            $msg=array("codigo"=>0, "texto"=>"Erro ao inserir.");
        }
        echo(json_encode($msg));
    }

    public function del()
    {
        $seq=$_GET['sequencia'];
        $sql=$this->db->select("SELECT
                                    idmoodle
                                FROM
                                    classe_curso_livre
                                WHERE
                                    sequencia = :seq", array(":seq"=> $seq)
                                    );
        $idmoodle=$sql[0]->idmoodle;
        $msg=array("codigo"=>0, "texto"=>"Erro ao excluir.");
        if($seq>0 && $idmoodle == null){
            $result=$this->db->delete('classe_curso_livre', "sequencia='$seq'");
            if($result){
                    $msg=array("codigo" => 1, "texto" => "Registro excluído com sucesso.");
            }
        }else{
            exit;
        }

        echo(json_encode($msg));
    }

    public function loadData()
    {
        $x=file_get_contents('php://input');
        $x=json_decode($x);
        $seq=$x->sequencia;
        $result=$this->db->select('SELECT * from classe_curso_livre where sequencia=:seq', array(":seq"=>$seq));
        $result = json_encode($result[0]);
        echo($result);        
    }

    public function save()
    {
        $x=file_get_contents('php://input');
        $x=json_decode($x);
        $seq=(int)$x->sequencia;
        $codCur=(int)$x->codcurso;
        $codTipCur=$x->codtipocurso;
        $txtAno=$x->ano;
        $txtSem=$x->semestre;
        $txtDesc=$x->descricao;
        $txtTerm=$x->termo;
        $txtTurma=$x->turma;
        $txtIdPai=$x->idcategoriapaimoodle;

        $msg=array("codigo" => 0, "texto" => "Erro ao atualizar.");
        if($codCur>0){
            $dadosSave=array('codcurso' => $codCur,
                             'codtipocurso' => $codTipCur,
                             'ano' => $txtAno,
                             'semestre' => $txtSem,
                             'descricao' => $txtDesc,
                             'termo' => $txtTerm,
                             'turma' => $txtTurma,
                             'idcategoriapaimoodle' => $txtIdPai);
            
            $result=$this->db->update('classe_curso_livre', $dadosSave, "sequencia='$seq'");
            if($result){
                    $msg=array("codigo"=>1, "texto" => "Registro atualizado com sucesso.");
            }
        }
        echo(json_encode($msg));
    }
}
