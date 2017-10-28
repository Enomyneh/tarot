<?php

class Grupo_Casa_Carta_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function get($options = array()){
        // trata os parametros
        if(isset($options["cod_grupo_casa_carta"])){
            $this->db->where("gcc.cod_grupo_casa_carta", $options["cod_grupo_casa_carta"]);
        }
        
        // faz o select
        $this->db->select("gcc.cod_grupo_casa_carta, gcc.nome_grupo_casa_carta")
                 ->from("grupo_casa_carta gcc")
                 ->order_by("gcc.nome_grupo_casa_carta");
        
        // checa a forma de retorno (row ou result)
        if(isset($options["cod_grupo_casa_carta"])){
            return $this->db->get()->row();
        }else{
            return $this->db->get()->result();
        }
    }
    
}

?>
