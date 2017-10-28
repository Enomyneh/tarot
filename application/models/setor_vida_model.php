<?php

class Setor_Vida_model extends CI_Model {

    public $cod;
    public $nome;
    
    public function __construct($cod = null){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();

        $this->cod = $cod;
    }
    
    public function get($options = array()){
        
        // trata os parametros
        if(isset($options["cod_setor_vida"])){
            $this->db->where("s.cod_setor_vida", $options["cod_setor_vida"]);
        }
        if(isset($options["link_label"])){
            $this->db->where("s.link_label", $options["link_label"]);
        }
        
        // faz o select
        $this->db->select("s.cod_setor_vida, s.nome_setor_vida, s.titulo_descricao, s.descricao, s.imagem, s.link_label")
                 ->from("setor_vida s")
                 ->where("ativo", 1)
                 ->order_by("s.nome_setor_vida");

        $result = $this->db->get();
        
        // checa a forma de retorno (row ou result)
        if(isset($options["cod_setor_vida"]) || $result->num_rows() == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }
    
}

?>
