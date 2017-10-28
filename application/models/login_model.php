<?php

class Login_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
    }
    
    public function activateByID($usuarioID){
        // informa o where
        $this->db->where("cod", $usuarioID);
        
        // ativa o cadastro
        $result = $this->db->update('usuario', array("ativo" => 1));
        
        return $result;
    }
    
    public function save(array $data, $cod = NULL){
        
        if(is_null($cod)){
            // insere no banco
            $result = $this->db->insert('usuario', $data);
            $result = $this->db->insert_id();
        }else{
            // atualiza no bd
            $this->db->where("cod", $cod);
            $result = $this->db->update('usuario', $data);      
        }

        return $result;
    }

    public function getTotalCadastrados(){

        $this->db
            ->select("COUNT(cod) AS total_usuarios")
            ->from("usuario u")
            ->where("ativo", 1);

        return $this->db->get()->row()->total_usuarios;
    }
    
    public function get(array $options = array()){
        // trata as options
        if(isset($options["usuarioID"])){
            $this->db->where("u.cod", $options["usuarioID"]);
        }
        if(isset($options["md5_ativacao"])){
            $this->db->where("md5_ativacao", $options["md5_ativacao"]);
        }
        if(isset($options["email"])){
            $this->db->where("email", $options["email"]);
        }
        if(isset($options["senha"])){
            $this->db->where("senha", $options["senha"]);
        }
        if(isset($options["ativo"])){
            $this->db->where("u.ativo", 1);
        }
        if(isset($options["cod_usuario_not"])){
            $this->db->where("u.cod <> " . $options["cod_usuario_not"]);
        }
        
        // obtem os dados
        $query = $this->db->select("u.cod")
                ->select("u.nome")
                ->select("u.email")
                ->select("u.senha")
                ->select("u.data_nascimento")
                ->select("u.cod_pais")
                ->select("u.cod_estado")
                ->select("u.cod_cidade")
                ->select("u.ddi")
                ->select("u.ddd")
                ->select("u.telefone")
                ->select("u.estado_outro")
                ->select("u.cidade_outro")
                ->select("u.md5_ativacao")
                ->select("u.ativo")
                ->select("u.admin")
                ->select("u.profissao")
                ->select("u.posicao")
                ->select("u.cod_usuario_tipo")
                ->select("u.orientacao_sexual")
                ->select("p.pais")
                ->select("e.estado")
                ->select("e.sigla as estado_sigla")
                ->select("c.cidade")
                ->from("usuario u")
                ->join("pais p", "p.cod = u.cod_pais", "left")
                ->join("estado e", "e.cod = u.cod_estado", "left")
                ->join("cidade c", "c.cod = u.cod_cidade", "left");
        
        // roda a query
        $result = $query->get();
        
        if($result->num_rows()  == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }

    public function getResumo(array $options = array()){
        // trata as options
        if(isset($options["usuarioID"])){
            $this->db->where("cod", $options["usuarioID"]);
        }
        if(isset($options["md5_ativacao"])){
            $this->db->where("md5_ativacao", $options["md5_ativacao"]);
        }
        if(isset($options["email"])){
            $this->db->where("email", $options["email"]);
        }
        if(isset($options["senha"])){
            $this->db->where("senha", $options["senha"]);
        }
        if(isset($options["ativo"])){
            $this->db->where("ativo", 1);
        }
        if(isset($options["busca"])){
            $this->db->where("( u.nome LIKE '%".$options["busca"]."%' OR u.email LIKE '%".$options["busca"]."%')");
        }
        
        // obtem os dados
        $query = $this->db
        		->select("u.cod")
                ->select("u.nome")
                ->select("u.email")
                ->select("MAX(ue.data) AS ultima_compra")
                ->select("MAX(uc.data) AS ultima_combinacao")
                ->select("MAX(um.data) AS ultima_monografia")
                ->select("(
                	SELECT SUM(valor) FROM usuario_extrato WHERE cod_usuario = u.cod
                ) AS saldo")
                ->select("(
                	SELECT COUNT(cod_usuario) FROM usuario_extrato WHERE cod_usuario = u.cod AND valor < 0
                ) AS qtde_compras")
                ->select("(
                	SELECT COUNT(cod_usuario) FROM usuario_combinacao WHERE cod_usuario = u.cod
                ) AS qtde_combinacoes")
                ->select("(
                	SELECT COUNT(cod_usuario) FROM usuario_monografia WHERE cod_usuario = u.cod
                ) AS qtde_monografias")
                ->select("(
                	SELECT COUNT(cod_usuario) FROM usuario_url_jogo WHERE cod_usuario = u.cod
                ) AS qtde_jogos")
                ->select("(
                	SELECT MAX(uuj.data_cadastro) FROM usuario_url_jogo uuj WHERE uuj.cod_usuario = u.cod
                ) AS ultimo_jogo")
                ->from("usuario u")
                ->join("usuario_extrato ue", "ue.cod_usuario = u.cod", "left")
                ->join("usuario_combinacao uc", "uc.cod_usuario = u.cod", "left")
                ->join("usuario_monografia um", "um.cod_usuario = u.cod", "left")
                ->group_by("u.cod, u.nome, u.email")
                ->order_by("MAX(ue.data) DESC ,(
                	SELECT MAX(uuj.data_cadastro) FROM usuario_url_jogo uuj WHERE uuj.cod_usuario = u.cod
                ) DESC");
        
        // roda a query
        $result = $query->get();
        
        if($result->num_rows()  == 1){
            return $result->row();
        }else{
            return $result->result();
        }
    }
    
    public function getSaldo(array $options){
        // trata as options
        if(isset($options["cod_usuario"])){
            $this->db->where("cod_usuario", $options["cod_usuario"]);
        }
        
        // monta a query
        $query = $this->db->select("SUM(valor) AS saldo")
                          ->from("usuario_extrato")
                          ->get();
        
        return $query->row()->saldo;
    }
    
    public function changePasswordByMd5($options){
        $this->db->update(
            "usuario", 
            array("senha"        => $options["senha"]), 
            array("md5_ativacao" => $options["md5_ativacao"])
        );
        
        return true;
    }
}

?>
