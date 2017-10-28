<?php

class Mapeamento_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function getTipo($options = array()){
        
        // trata os parametros
        if(isset($options["link_label"])){
            $this->db->where("t.link_label", $options["link_label"]);
        }
        if(isset($options["cod"])){
            $this->db->where("t.cod", $options["cod"]);
        }
        // faz o select
        $this->db->select("t.cod, t.tipo, t.link_label")
                 ->from("mapeamento_tipo t")
                 ->order_by("t.tipo");

        $result = $this->db->get();
        
        // checa a forma de retorno (row ou result)
        if($result->num_rows() == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }

    public function insert($data){

        $this->db->insert("mapeamento", $data);

        return $this->db->insert_id();
    }

    public function addToPedido($data){

        $this->db->insert("pedido_mapeamento", $data);

        return true;
    }

    public function addPergunta($data){

        $this->db->insert("mapeamento_pergunta", $data);

        return $this->db->insert_id();
    }

    public function getPerguntas($options){

        if(isset($options["cod_mapeamento"])){

            $this->db->where("cod_mapeamento" , $options["cod_mapeamento"]);
        }

        $this->db->select("mp.cod as cod_pergunta")
                 ->select("mp.cod_mapeamento")
                 ->select("mp.pergunta")
                 ->from("mapeamento_pergunta mp")
                 ->order_by("mp.cod");

        return $this->db->get()->result();
    }
    
}

?>
