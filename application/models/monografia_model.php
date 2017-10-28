<?php

class Monografia_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        
    }
    
    public function insertUsuarioMonografia($options){
        $result = $this->db->insert("usuario_monografia", array(
            "cod_monografia" => $options["cod_monografia"],
            "cod_usuario"    => $options["cod_usuario"]
        ));
        
        return $result;
    }
    
    public function getUsuarioMonografia($options){
        
        $this->db->select("cod_usuario")
                 ->select("cod_monografia")
                 ->from("usuario_monografia")
                 ->where("cod_usuario", $options["cod_usuario"])
                 ->where("cod_monografia", $options["cod_monografia"]);
        
        return $this->db->get()->result();
    }
    
    public function save($options){

        $dataMonografia = array(
            "preco_monografia" => $options["preco"],
            "cod_carta"        => $options["cod_carta"],
            "titulo_geral"     => $options["titulo_geral"],
            "tipo_monografia"  => $options["tipo_monografia"]
        );

        if($options["titulo"] == ""){
            $dataMonografia["monografia"] = $options["monografia"];
        }

        $dataDetalhe = array();

        if($options["titulo"] != "" AND strlen($options["titulo"]) > 1){

            $dataDetalhe["titulo"] = $options["titulo"];
            $dataDetalhe["monografia"] = $options["monografia"];

            if($options["sub_titulo"] != "" AND strlen($options["sub_titulo"]) > 1){
                $dataDetalhe["sub_titulo"] = $options["sub_titulo"];
            }else{
                $dataDetalhe["sub_titulo"] = NULL;
            }

            if($options["detalhe_sub_titulo"] != "" AND strlen($options["detalhe_sub_titulo"]) > 1){
                $dataDetalhe["detalhe_sub_titulo"] = $options["detalhe_sub_titulo"];
            }else{
                $dataDetalhe["detalhe_sub_titulo"] = NULL;
            }
        }

        $codMonografia = NULL;
        
        if(isset($options["cod_monografia"]) && $options["cod_monografia"] > 0){

            $codMonografia = $options["cod_monografia"];

            $this->db->update("monografia", $dataMonografia, array(
                "cod_monografia" => $options["cod_monografia"]
            ));

        }else{

            $this->db->insert("monografia", $dataMonografia);

            $codMonografia = $this->db->insert_id();
        }

        if(count($dataDetalhe) > 0){

            $dataDetalhe["cod_monografia"] = $codMonografia;

            if(is_numeric($options["cod_detalhe"]) AND $options["cod_detalhe"] > 0){

                $this->db->update("monografia_detalhes", $dataDetalhe, array("cod" => $options["cod_detalhe"]));

            }else{

                $this->db->insert("monografia_detalhes", $dataDetalhe);
            }
        }
        
        return true;
    }

    public function getCodMonografiaByCodCarta($codCarta){

        $this->db->select("cod_monografia")
                 ->from("monografia")
                 ->where("cod_carta", $codCarta);

        return $this->db->get()->row();
    }
    
    public function get($options = array()){
        
        if(isset($options["cod_monografia"])){
            $this->db->where("m.cod_monografia", $options["cod_monografia"]);
        }

        if(isset($options["cod_detalhe"])){

            $this->db->where("md.cod", $options["cod_detalhe"]);
        }

        if(isset($options["tipo_monografia"])){

            $this->db->where("tipo_monografia", $options["tipo_monografia"]);
        }

        if(isset($options["cod_carta"])){
            $this->db->where("m.cod_carta", $options["cod_carta"]);
        }
        
        if(isset($options["cod_usuario"])){
            $this->db->join("usuario_monografia um", "um.cod_monografia = m.cod_monografia");
            $this->db->where("um.cod_usuario", $options["cod_usuario"]);
            $this->db->select("um.data AS 'data_compra_monografia'");
        }

        if(!isset($options["texto_monografia"]) OR $options["texto_monografia"] == TRUE){
            $this->db->select("md.monografia");
        }

        $this->db->select("m.cod_monografia")
                 ->select("m.preco_monografia")
                 ->select("m.cod_carta")
                 ->select("m.monografia as capa")
                 ->select("m.keywords")
                 ->select("m.titulo_geral")
                 ->select("m.tipo_monografia")
                 ->select("m.imagem_capa")
                 ->select("md.titulo")
                 ->select("md.sub_titulo")
                 ->select("md.detalhe_sub_titulo")
                 ->select("md.cod as cod_detalhe")
                 ->select("c.nome_carta")
                 ->from("monografia m")
                 ->join("carta c", "c.cod_carta = m.cod_carta", "left")
                 ->join("monografia_detalhes md", "md.cod_monografia = m.cod_monografia", "left")
                 ->order_by("m.cod_monografia, md.titulo, md.sub_titulo, md.detalhe_sub_titulo");
        
        return $this->db->get()->result();
    }

    public function removerDetalhe($codDetalhe){

        $this->db->delete("monografia_detalhes", array("cod" => $codDetalhe));

        return true;
    }

    public function saveKeywords($data){

        $this->db->update("monografia", array("keywords" => $data["keywords"]), array("cod_monografia" => $data["cod_monografia"]));

        return true;
    }

    public function getTitulosGerais(){

        $result = $this->db->select("titulo_geral")
                           ->select("cod_monografia")
                           ->from("monografia")
                           ->where("titulo_geral <> ''");

        return $result->get()->result();
    }
    
}

?>
