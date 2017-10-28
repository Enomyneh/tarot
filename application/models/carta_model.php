<?php

class Carta_model extends CI_Model {

    public $cod;
    public $nome;
    
    public function __construct($cod = null){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();

        $this->cod = $cod;
    }
    
    public function get($options = array()){
        
        // filtra o cod_tipo_carta
        if(isset($options["cod_tipo_carta"])){
            $this->db->where("c.cod_tipo_carta", $options["cod_tipo_carta"]);
        }
        
        if(isset($options["cod_carta"])){
            $this->db->where("c.cod_carta", $options["cod_carta"]);
        }
        
        // faz o select
        $this->db->select("c.cod_carta, c.nome_carta, c.cod_tipo_carta")
                 ->from("carta c");
        
        // checa a forma de retorno (row ou result)
        if(isset($options["cod_carta"])){
            return $this->db->get()->row();
        }else{
            return $this->db->get()->result();
        }
    }
    
    public function getDescricao($options){
        // trata as opcoes
        if(isset($options["cod_carta"])){
            $this->db->where("cod_carta", $options["cod_carta"]);
        }
        if(isset($options["sub_tipo"]) && $options["sub_tipo"] != ""){
            $this->db->where("sub_tipo", $options["sub_tipo"]);
        }
        
        $this->db->select("cod")
                 ->select("cod_carta")
                 ->select("sub_tipo")
                 ->select("descricao")
                 ->from("cartas_descricao");
        
        return $this->db->get()->row();
    }
    
    public function saveDescricao($options){
        // consulta o banco para saber se faz insert ou update
        $cartaDescricao = $this->getDescricao(array(
            "cod_carta" => $options["cod_carta"],
            "sub_tipo" => $options["sub_tipo"]
        ));
        
        // trata as options
        if(is_object($cartaDescricao) && isset($cartaDescricao->cod)){
            
            // faz update
            $this->db->update("cartas_descricao", array(
                "descricao" => $options["descricao"]
            ), array(
                "cod" => $cartaDescricao->cod
            ));
            
            return true;
            
        }else{
            // faz insert
            $this->db->insert("cartas_descricao", array(
                "cod_carta" => $options["cod_carta"],
                "sub_tipo"  => $options["sub_tipo"],
                "descricao" => $options["descricao"]
            ));
            
            return $this->db->insert_id();
        }
    }
}

?>
