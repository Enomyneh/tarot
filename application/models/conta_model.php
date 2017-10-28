<?php

class Conta_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function getSaldo($options = array()){
        
        $this->db->where("cod_usuario", $options["cod_usuario"]);
        
        // monta a query
        $query = $this->db->select("SUM(valor) AS saldo")
                          ->from("usuario_extrato")
                          ->get();
        
        return $query->row()->saldo;
    }
    
    public function getExtrato(){
        // coloca o where do usuario
        $this->db->where("cod_usuario", $this->auth->getData("cod"));
        
        $query = $this->db->select("cod_usuario")
                          ->select("descricao")
                          ->select("valor")
                          ->select("data")
                          ->from("usuario_extrato")
                          ->order_by("data DESC")
                          ->get();
        
        return $query->result();
    }
    
    public function insertTransacao(array $options){
		
		if(isset($options["usuarioID"])){
			$usuarioID = $options["usuarioID"];
		}else{
			$usuarioID = $this->auth->getData("cod");
		}
        
        $result = $this->db->insert("usuario_extrato", array(
            "cod_usuario" => $usuarioID,
            "descricao"   => $options["descricao"],
            "valor"       => $options["valor"],
            "data"        => date("Y-m-d H:i:s")
        ));
        
        return $result;
    }
}

?>
