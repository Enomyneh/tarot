<?php

class Estado_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function get($options){
        
        if(isset($options["pais"])){
            $this->db->where("e.cod_pais", $options["pais"]);
        }
        
        if(isset($options["term"])){
            $this->db->like("e.estado", $options["term"]);
        }
                
        // faz o select
        $this->db->select("e.cod, e.estado, e.sigla, e.cod_pais")
                 ->from("estado e");
        
        return $this->db->get()->result();
    }
    
}

?>
