<?php

class Casa_Carta_model extends CI_Model {

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
        if(isset($options["cod_casa_carta"])){
            $this->db->where("cc.cod_casa_carta", $options["cod_casa_carta"]);
        }
        
        if(isset($options["cod_grupo_casa_carta"])){
            $this->db->where("cc.cod_grupo_casa_carta", $options["cod_grupo_casa_carta"]);
        }
        
        // faz o select
        $this->db->select("cc.cod_casa_carta, cc.nome_casa_carta, cc.titulo_casa_carta, cc.descricao_casa_carta")
                 ->select("gcc.cod_grupo_casa_carta, gcc.nome_grupo_casa_carta")
                 ->from("casa_carta cc")
                 ->join("grupo_casa_carta gcc","gcc.cod_grupo_casa_carta = cc.cod_grupo_casa_carta")
                 ->order_by("cc.cod_casa_carta");
        
        // checa a forma de retorno (row ou result)
        if(isset($options["cod_casa_carta"])){
            return $this->db->get()->row();
        }else{
            return $this->db->get()->result();
        }
    }
    
}

?>
