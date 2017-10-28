<?php

class Pedido_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function insert($data = array()){
        
        // faz o insert
        $this->db->insert("pedido", $data);

        return $this->db->insert_id();
    }

    public function get($options = array()){

        if(isset($options["cod_usuario"])){
            $this->db->where("u.cod", $options["cod_usuario"]);
        }

        $this->db->select("p.cod as cod_pedido")
                 ->select("p.data as data_pedido")
                 ->select("p.status as status_pedido")
                 ->select("p.cod_usuario")
                 ->select("m.cod as cod_mapeamento")
                 ->select("mt.tipo as mapeamento_tipo")
                 ->select("u.nome as nome_usuario")
                 ->select("u.email as email_usuario")
                 ->select("u.orientacao_sexual as orientacao_sexual_usuario")
                 ->select("u.data_nascimento as data_nascimento_usuario")
                 ->select("s.nome_setor_vida")
                 ->select("ss.sub_setor")
                 ->from("pedido p")
                 ->join("pedido_mapeamento pm", "pm.cod_pedido = p.cod", "left")
                 ->join("mapeamento m", "m.cod = pm.cod_mapeamento", "left")
                 ->join("mapeamento_tipo mt", "mt.cod = m.cod_mapeamento_tipo", "left")
                 ->join("usuario u", "u.cod = p.cod_usuario", "left")
                 ->join("setor_vida s", "s.cod_setor_vida = m.cod_setor_vida", "left")
                 ->join("sub_setor_vida ss", "ss.cod = m.cod_sub_setor_vida", "left")
                 ->where("p.ativo", 1)
                 ->order_by("p.cod");

        return $this->db->get()->result();

    }

    public function desativar($codPedido){

        $this->db->where("cod", $codPedido);
        $this->db->update("pedido", array("ativo" => 0));

        return true;
    }
    
    public function changeStatus($status, $codPedido){

        $this->db->where("cod", $codPedido);
        $this->db->update("pedido", array("status" => $status));

        return true;
    }
}

?>
