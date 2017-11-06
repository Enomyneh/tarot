<?php

class Url_jogo_model extends CI_Model {

    public $codUrlJogo;
    public $setorVida;
    public $cartasString;
    public $token;
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function get($options){
        if(isset($options["token"])){
            $this->db->where("uj.token", $options["token"]);
        }
        if(isset($options["cod_url_jogo"])){
            $this->db->where("uj.cod_url_jogo", $options["cod_url_jogo"]);
        }
        if(isset($options["limit"])){
            $this->db->limit($options["limit"]);
        }

        if(isset($options["cod_usuario"])){

            $this->db->select("uuj.titulo")
                     ->select("uuj.data_cadastro")
                     ->select("sv.nome_setor_vida")
                     ->select("uj.tipo_jogo")
                     ->join("usuario_url_jogo uuj", "uuj.cod_url_jogo = uj.cod_url_jogo")
                     ->join("setor_vida sv", "sv.cod_setor_vida = uj.cod_setor_vida")
                     ->where("uuj.cod_usuario", $options["cod_usuario"])
                     ->where("sv.ativo = 1")
                     ->order_by("uuj.data_cadastro DESC");
        }

        $this->db->select("uj.cod_url_jogo")
                 ->select("uj.cod_setor_vida")
                 ->select("uj.cartas")
                 ->select("uj.token")
                 ->from("url_jogo uj");

        $result = $this->db->get();

        if($result->num_rows == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }
    
    public function save($data){
        
        // checa se ja existe a descricao
        $result = $this->db->select("cod_url_jogo")
                           ->from("url_jogo")
                           ->where("token", $data["token"])
                           ->get()
                           ->row();
        
        // se ja existe retorna
        if(isset($result->cod_url_jogo)){
            return true;
        }

        // caso contrario inclui
        $this->db->insert("url_jogo", $data);

        return true;
    }

    public function saveUsuarioUrlJogo($data){

        // checa se a url ja existe para o usuario
        $result = $this->db
                 ->select("cod_usuario_url_jogo")
                 ->from("usuario_url_jogo")
                 ->where("cod_usuario", $data["cod_usuario"])
                 ->where("cod_url_jogo", $data["cod_url_jogo"])
                 ->get();

        // existe?
        if($result->num_rows() > 0){
            // obtem o id
            $codUsuarioUrlJogo = $result->row()->cod_usuario_url_jogo;

            // atualiza no bd
            $result = $this->db->update(
                "usuario_url_jogo",
                array( "data_cadastro"        => date("Y-m-d H:i:s") ), 
                array( "cod_usuario_url_jogo" => $codUsuarioUrlJogo  )
            );

        }else{

            // insere
            $result = $this->db->insert("usuario_url_jogo", array(
                "cod_url_jogo" => $data["cod_url_jogo"],
                "cod_usuario"  => $data["cod_usuario"],
                "data_cadastro"=> date("Y-m-d H:i:s")
            ));
        }

        return $result;
    }

    public function saveTituloUsuarioUrlJogo($data){

        // atualiza no bd
        $result = $this->db->update(
            "usuario_url_jogo",
            array("titulo" => $data["titulo"]),
            array(
                "cod_url_jogo" => $data["cod_url_jogo"],
                "cod_usuario"  => $data["cod_usuario"]
            )
        );

        return $result;
    }

    public function getUsuarioUrlJogo($options){
        if(isset($options["cod_usuario"])){
            $this->db->where("cod_usuario", $options["cod_usuario"]);
        }

        $this->db->select("cod_usuario")
                 ->select("cod_url_jogo")
                 ->select("data_cadastro")
                 ->from("usuario_url_jogo");

        return $this->db->get()->result();
    }
}

?>
