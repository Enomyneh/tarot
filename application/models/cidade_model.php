<?php

class Cidade_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function get($options = array()){
        
        if(isset($options["estado"])){
            $this->db->where("c.cod_estado", $options["estado"]);
        }
        
        if(isset($options["term"])){
            $this->db->like("c.cidade", $options["term"]);
        }
                
        // faz o select
        $this->db->select("c.cod, c.cidade, c.cod_estado")
                 ->from("cidade c");
        
        return $this->db->get()->result();
    }
    
}

?>
