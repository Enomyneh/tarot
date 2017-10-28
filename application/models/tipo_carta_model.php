<?php

class Tipo_Carta_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function get(){
        
        $result = $this->db->select("tp.cod_tipo_carta, tp.nome_tipo_carta")
                    ->from("tipo_carta tp")
                    ->order_by("tp.nome_tipo_carta")
                    ->get()
                    ->result();
        
        return $result;
    }
}

?>
