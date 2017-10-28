<?php

class Pais_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function get(){
                
        // faz o select
        $this->db->select("p.cod, p.pais")
                 ->from("pais p");
        
        return $this->db->get()->result();
    }
    
}

?>
