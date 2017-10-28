<?php

class Sub_Setor_Vida_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function get($options = array()){
        
        // trata os parametros
        if(isset($options["cod"])){
            $this->db->where("s.cod", $options["cod"]);
        }
        if(isset($options["link_label"])){
            $this->db->where("s.link_label", $options["link_label"]);
        }
        
        // faz o select
        $this->db->select("s.cod, s.sub_setor, s.link_label, s.cod_setor_vida, sv.nome_setor_vida")
                 ->from("sub_setor_vida s")
                 ->join("setor_vida sv", "sv.cod_setor_vida = s.cod_setor_vida")
                 ->order_by("s.cod_setor_vida, s.sub_setor");

        $result = $this->db->get();
        
        // checa a forma de retorno (row ou result)
        if(isset($options["cod"]) || $result->num_rows() == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }
    
}

?>
