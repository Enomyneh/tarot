<?php

/**
 * Class Combinacao_model
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 */
class Combinacao_model extends CI_Model {
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function save(array $data){
        // monta o array para insercao
        $dados = array(
            "cod_setor_vida"   => $data["cod_setor_vida"],
            "cod_casa_carta"   => $data["cod_casa_carta"],
            "texto_combinacao" => $data["texto_combinacao"]
        );
        
        // busca o codigo da combinacao para saber se ja existe ou nao
        $result = $this->db->select("cc.cod_combinacao")
                           ->from("combinacao_carta cc")
                           ->join("combinacao c", "c.cod_combinacao = cc.cod_combinacao")
                           ->where("cc.cod_arcano_maior",   $data["cod_arcano_maior"])
                           ->where("cc.cod_arcano_menor_1", $data["cod_arcano_menor_1"])
                           ->where("cc.cod_arcano_menor_2", $data["cod_arcano_menor_2"])
                           ->where("c.cod_casa_carta", $data["cod_casa_carta"])
                           ->where("c.cod_setor_vida", $data["cod_setor_vida"])
                           ->get()->row();
        
        if(isset($result->cod_combinacao) && (int)$result->cod_combinacao > 0){
            // atualiza no banco
            $this->db->update("combinacao", $dados, array("cod_combinacao" => (int)$result->cod_combinacao));
            
        }else{
            // insere no banco
            $this->db->insert("combinacao",$dados);

            // obtem o codigo inserido
            $combinacaoCod = $this->db->insert_id();

            // insere as cartas_combinacoes
            $this->db->insert("combinacao_carta", array(
                "cod_arcano_maior"   => $data["cod_arcano_maior"],
                "cod_arcano_menor_1" => $data["cod_arcano_menor_1"],
                "cod_arcano_menor_2" => $data["cod_arcano_menor_2"],
                "cod_combinacao"     => $combinacaoCod
            ));
        }
        
        return true;
    }
    
    public function get(array $options = array()){
        // trata os parametros
        $this->db->where("c.cod_casa_carta", $options["cod_casa_carta"]);
        $this->db->where("c.cod_setor_vida", $options["cod_setor_vida"]);

        // trata outros parametros
        $this->db->where("c.cod_carta_1", $options["cod_arcano_maior"])
                 ->where("c.cod_carta_2", $options["cod_arcano_menor_1"])
                 ->where("c.cod_carta_3", $options["cod_arcano_menor_2"]);

        // executa o select
        $result = $this->db
                     ->select("c1.texto_combinacao_nova as 'texto_combinacao_1'")
                     ->select("c2.texto_combinacao_nova as 'texto_combinacao_2'")
                     ->select("c3.texto_combinacao_nova as 'texto_combinacao_3'")
                     ->select("c.cod_setor_vida")
                     ->select("c.cod_casa_carta")
                     ->from("combinacao_nova_cartas_casa_carta_setor_vida c")
                     ->join("combinacao_nova c1", "c1.cod_combinacao_nova = c.cod_combinacao_nova_carta_1")
                     ->join("combinacao_nova c2", "c2.cod_combinacao_nova = c.cod_combinacao_nova_carta_2")
                     ->join("combinacao_nova c3", "c3.cod_combinacao_nova = c.cod_combinacao_nova_carta_3")
                     ->limit(1)
                     ->get();

        // obtem o registro
        $row = $result->row();

        if(count($row) > 0){
          // ajusta o texto combinacao
          $row->texto_combinacao = encodar_html($row->texto_combinacao_1 . $row->texto_combinacao_2 . $row->texto_combinacao_3);

          return $row;
        }

        // caso nao tenha combinacao especifica busca uma generica
        $result = $this->getMaiorAtivoEspecificoPassivoGenerico($options);

        if($result == false){

            $result2 = $this->getMaiorPassivoEspecificoAtivoGenerico($options);

            if($result2 == false){

                $result3 = $this->getAtivoPassivoEspecificoMaiorGenerico($options);

                if($result3 == false){

                    return $this->getAllGenerico($options);

                }else{

                    return $result3;

                }

            }else{

                return $result2;

            }

        }else{

            return $result;
        }

        die("erro");
    }
    
    public function getCusto(){
        // monta a query
        $query = $this->db->select("custo")
                          ->from("custo")
                          ->where("tipo", "combinacao")
                          ->get();
        
        return $query->row()->custo;
    }
    
    public function setDisponivel($arcMaior, $arcMenor1, $arcMenor2){
        
        $result = $this->db->insert("combinacao_disponivel",array(
            "cod_carta_1" => $arcMaior,
            "cod_carta_2" => $arcMenor1,
            "cod_carta_3" => $arcMenor2
        ));
        
        return $result;
    }
    
    public function getDisponiveis($options = array()){
        // trata as options
        if(isset($options["arcanoMaiorCod"])){
            $this->db->where("cd.cod_carta_1", $options["arcanoMaiorCod"]);
        }
        if(isset($options["arcanoMenor1Cod"])){
            $this->db->where("cd.cod_carta_2", $options["arcanoMenor1Cod"]);
        }
        if(isset($options["arcanoMenor2Cod"])){
            $this->db->where("cd.cod_carta_3", $options["arcanoMenor2Cod"]);
        }
        
        $query = $this->db
                ->select("cd.cod_carta_1    AS 'arcanoMaiorCod'")
                ->select("cam.nome_carta    AS 'arcanoMaiorNome'")
                ->select("cd.cod_carta_2    AS 'arcanoMenor1Cod'")
                ->select("cam1.nome_carta   AS 'arcanoMenor1Nome'")
                ->select("cd.cod_carta_3    AS 'arcanoMenor2Cod'")
                ->select("cam2.nome_carta   AS 'arcanoMenor2Nome'")
                ->from("combinacao_disponivel cd")
                ->join("carta cam", "cam.cod_carta = cd.cod_carta_1")
                ->join("carta cam1", "cam1.cod_carta = cd.cod_carta_2")
                ->join("carta cam2", "cam2.cod_carta = cd.cod_carta_3")
                ->order_by("cam.nome_carta,cam1.nome_carta,cam2.nome_carta");
        
        $result = $query->get();
        
        if($result->num_rows() == 0){
            return $result->row();
        }else{
            return $result->result();
        }
        
    }
    
    public function insertUsuarioCombinacao(array $options){
        $this->db->insert("usuario_combinacao", $options);
    }
    
    public function getUsuarioCombinacao(array $options){
        $this->db->where("cod_usuario",$options["cod_usuario"]);

        $order_by = "cama.nome_carta, came1.nome_carta, came2.nome_carta";
        
        if(isset($options["cod_carta_1"])){
            $this->db->where("cod_carta_1", $options["cod_carta_1"]);
        }
        if(isset($options["cod_carta_2"])){
            $this->db->where("cod_carta_2", $options["cod_carta_2"]);
        }
        if(isset($options["cod_carta_3"])){
            $this->db->where("cod_carta_3", $options["cod_carta_3"]);
        }
        if(isset($options["cod_usuario_combinacao"])){
            $this->db->where("uc.cod_usuario_combinacao", $options["cod_usuario_combinacao"]);
        }
        if(isset($options["order_by"])){
          if($options["order_by"] == "data"){
            $order_by = "data_compra_combinacao DESC";
          }
        }
        if(isset($options["limit"])){
          $this->db->limit($options["limit"]);
        }
        
        // select
        $this->db->select("uc.cod_usuario")
                 ->select("uc.cod_usuario_combinacao")
                 ->select("uc.cod_carta_1   AS 'cod_arcano_maior'")
                 ->select("cama.nome_carta  AS 'nome_arcano_maior'")
                 ->select("uc.cod_carta_2   AS 'cod_arcano_menor_1'")
                 ->select("came1.nome_carta AS 'nome_arcano_menor_1'")
                 ->select("uc.cod_carta_3   AS 'cod_arcano_menor_2'") 
                 ->select("came2.nome_carta AS 'nome_arcano_menor_2'")
                 ->select("uc.data AS 'data_compra_combinacao'")
                 ->from("usuario_combinacao uc")
                 ->join("carta cama",  "cama.cod_carta = uc.cod_carta_1")
                 ->join("carta came1", "came1.cod_carta = uc.cod_carta_2")
                 ->join("carta came2", "came2.cod_carta = uc.cod_carta_3")
                 ->order_by($order_by);
        
        return $this->db->get()->result();
    }

    public function saveNew($textoCombinacao){

        $this->db->insert("combinacao_nova", array(
            "texto_combinacao_nova" => $textoCombinacao
        ));

        return $this->db->insert_id();
    }

    public function saveRelationship($options){

        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("carta_model", "carta");

        $casa = new Casa_Carta_model($options['cod_casa_carta']);
        $setor = new Setor_Vida_model($options['cod_setor_vida']);

        $this->db->select("cod")
                 ->from("combinacao_nova_cartas_casa_carta_setor_vida")
                 ->where("cod_casa_carta", $casa->cod)
                 ->where("cod_setor_vida", $setor->cod);

        $carta1 = $carta2 = $carta3 = null;

        if($options["carta1"] == ""){
            $this->db->where("cod_carta_1 IS NULL");
        }else{
            $carta1 = new Carta_model($options['carta1']);
            $this->db->where("cod_carta_1", $carta1->cod);
        }

        if($options["carta2"] == ""){
            $this->db->where("cod_carta_2 IS NULL");
        }else{
            $carta2 = new Carta_model($options['carta2']);
            $this->db->where("cod_carta_2", $carta2->cod);
        }

        if($options["carta3"] == ""){
            $this->db->where("cod_carta_3 IS NULL");
        }else{
            $carta3 = new Carta_model($options['carta3']);
            $this->db->where("cod_carta_3", $options["carta3"]);
        }

        // roda a query
        $result = $this->db->get();

        if($result->num_rows() > 0){

            // faz o update

            // obtem o codigo do relacionamento
            $cod = $result->row();
            $cod = $cod->cod;

            $this->db->update("combinacao_nova_cartas_casa_carta_setor_vida", array(

                "cod_combinacao_nova_carta_1" => $options["cod_combinacao_carta_1"],
                "cod_combinacao_nova_carta_2" => $options["cod_combinacao_carta_2"],
                "cod_combinacao_nova_carta_3" => $options["cod_combinacao_carta_3"],
                "cod_carta_1"         => (is_null($carta1)) ? NULL : $carta1->cod,
                "cod_carta_2"         => (is_null($carta2)) ? NULL : $carta2->cod,
                "cod_carta_3"         => (is_null($carta3)) ? NULL : $carta3->cod,
                "cod_setor_vida"      => $setor->cod,
                "cod_casa_carta"      => $casa->cod

            ), array("cod" => $cod)); 

        }else{

            // faz o insert

            $this->db->insert("combinacao_nova_cartas_casa_carta_setor_vida", array(
                "cod_combinacao_nova_carta_1" => $options["cod_combinacao_carta_1"],
                "cod_combinacao_nova_carta_2" => $options["cod_combinacao_carta_2"],
                "cod_combinacao_nova_carta_3" => $options["cod_combinacao_carta_3"],
                "cod_carta_1"         => (is_null($carta1)) ? NULL : $carta1->cod,
                "cod_carta_2"         => (is_null($carta2)) ? NULL : $carta2->cod,
                "cod_carta_3"         => (is_null($carta3)) ? NULL : $carta3->cod,
                "cod_setor_vida"      => $setor->cod,
                "cod_casa_carta"      => $casa->cod
            ));

        }

        // faz a inclusao dos valores se necessario
        if(is_null($carta1) == false)
        {
            if(is_numeric($options['carta1Valor']) AND $options['carta1Valor'] > 0)
            {
                // salva o valor
                $this->carta_casa_setor_valor->save($carta1, $casa, $setor, $options['carta1Valor']);
            }
        }
        if(is_null($carta2) == false)
        {
            if(is_numeric($options['carta2Valor']) AND $options['carta2Valor'] > 0)
            {
                // salva o valor
                $this->carta_casa_setor_valor->save($carta2, $casa, $setor, $options['carta2Valor']);
            }
        }
        if(is_null($carta3) == false)
        {
            if(is_numeric($options['carta3Valor']) AND $options['carta3Valor'] > 0)
            {
                // salva o valor
                $this->carta_casa_setor_valor->save($carta3, $casa, $setor, $options['carta3Valor']);
            }
        }

        return true;
    }

    public function getCartaUnicaNova($tipoCarta, $options){

        // busca o texto
        $this->db->where("c.cod_casa_carta", $options["cod_casa_carta"]);
        $this->db->where("c.cod_setor_vida", $options["cod_setor_vida"]);

        if($tipoCarta == 1){

            // trata outros parametros
            $this->db->select("c1.texto_combinacao_nova as 'texto_combinacao_1'")
                   ->where("c.cod_carta_1", $options["cod_arcano_maior"])
                   ->where("c.cod_carta_2 IS NULL")
                   ->where("c.cod_carta_3 IS NULL")
                   ->join("combinacao_nova c1", "c1.cod_combinacao_nova = c.cod_combinacao_nova_carta_1");

        }else if($tipoCarta == 2){

            // trata outros parametros
            $this->db->select("c2.texto_combinacao_nova as 'texto_combinacao_2'")
                    ->where("c.cod_carta_2", $options["cod_arcano_menor_1"])
                    ->where("c.cod_carta_1 IS NULL")
                    ->where("c.cod_carta_3 IS NULL")
                    ->join("combinacao_nova c2", "c2.cod_combinacao_nova = c.cod_combinacao_nova_carta_2");

        }else if($tipoCarta == 3){

            // trata outros parametros
            $this->db->select("c3.texto_combinacao_nova as 'texto_combinacao_3'")
                   ->where("c.cod_carta_3", $options["cod_arcano_menor_2"])
                   ->where("c.cod_carta_1 IS NULL")
                   ->where("c.cod_carta_2 IS NULL")
                   ->join("combinacao_nova c3", "c3.cod_combinacao_nova = c.cod_combinacao_nova_carta_3");

        }else {

            return false;

        }

        // executa a query
        $result = $this->db
                     ->select("c.cod_setor_vida")
                     ->select("c.cod_casa_carta")
                     ->from("combinacao_nova_cartas_casa_carta_setor_vida c")
                     ->limit(1)
                     ->get();

        // obtem o registro
        $row = $result->row();

        if(count($row) > 0){

          if($tipoCarta == 1){
              return $row->texto_combinacao_1;
          }else if($tipoCarta == 2){
              return $row->texto_combinacao_2;
          }else if($tipoCarta == 3){
              return $row->texto_combinacao_3;
          }

        }else{
            return false;
        }
    }

    public function getCartaUnicaGenerica($tipoCarta, $options){
        // busca o texto 
        $this->db->select("descricao AS 'texto_combinacao'")
                 ->from("cartas_descricao");

        if($tipoCarta == 1){

            $this->db->where("cod_carta", $options["cod_arcano_maior"]);

        }else if($tipoCarta == 2){

            $this->db->where("cod_carta", $options["cod_arcano_menor_1"]);
            $this->db->where("sub_tipo", "ATIVO");

        }else if($tipoCarta == 3){

            $this->db->where("cod_carta", $options["cod_arcano_menor_2"]);
            $this->db->where("sub_tipo", "PASSIVO");

        }

        $row = $this->db->get()->row();

        if(count($row)>0){

            return $row->texto_combinacao;

        }else{

            return false;

        }
    }

    public function getAllGenerico($options){
        $texto1 = $texto2 = $texto3 = "";

        // busca o texto 1 na tabela nova
        $texto = $this->getCartaUnicaNova(1, $options);

        if($texto != false && strlen($texto) > 1){

            $texto1 = $texto;

        }else{

            // busca o texto 1 na tabela antiga (generica)
            $texto = $this->getCartaUnicaGenerica(1, $options);

            if($texto != false && strlen($texto) > 1 ){

            		$texto1 = $texto;
            }
        }

        if($texto1 != ""){

	        	// busca o texto 2 na tabela nova
		        $texto = $this->getCartaUnicaNova(2, $options);

		        if($texto != false && strlen($texto) > 1){

		            $texto2 = $texto;

		        }else{

		            // busca o texto 2 na tabela antiga (generica)
		            $texto = $this->getCartaUnicaGenerica(2, $options);

		            if($texto != false && strlen($texto) > 1 ){

		            		$texto2 = $texto;
		            }
		        }
        }

        if($texto2 != ""){
        		// busca o texto 3 na tabela nova
		        $texto = $this->getCartaUnicaNova(3, $options);

		        if($texto != false && strlen($texto) > 1){

		            $texto3 = $texto;

		        }else{

		            // busca o texto 3 na tabela antiga (generica)
		            $texto = $this->getCartaUnicaGenerica(3, $options);

		            if($texto != false && strlen($texto) > 1 ){

		            		$texto3 = $texto;
		            }
		        }
        }

        $row = new StdClass();

        // checa se os 3 textos foram encontrados
        if($texto1 != "" && $texto2 != "" && $texto3 != ""){
            // combinacao generica encontrada
            $row->texto_combinacao = $texto1 . $texto2 . $texto3;

            $row->texto_combinacao = encodar_html($row->texto_combinacao);
        }else{
        		$row->texto_combinacao = "";
        }

        return $row;
    }

    public function getMaiorAtivoEspecificoPassivoGenerico($options){

        $texto1_2 = $texto3 = "";

        // busca o texto 1 e o texto2 especificos
        // trata os parametros
        $this->db->where("c.cod_casa_carta", $options["cod_casa_carta"]);
        $this->db->where("c.cod_setor_vida", $options["cod_setor_vida"]);

        // trata outros parametros
        $this->db->where("c.cod_carta_1", $options["cod_arcano_maior"])
                 ->where("c.cod_carta_2", $options["cod_arcano_menor_1"])
                 ->where("c.cod_carta_3 IS NULL");

        // executa o select
        $result = $this->db
                     ->select("c1.texto_combinacao_nova as 'texto_combinacao_1'")
                     ->select("c2.texto_combinacao_nova as 'texto_combinacao_2'")
                     ->select("c.cod_setor_vida")
                     ->select("c.cod_casa_carta")
                     ->from("combinacao_nova_cartas_casa_carta_setor_vida c")
                     ->join("combinacao_nova c1", "c1.cod_combinacao_nova = c.cod_combinacao_nova_carta_1")
                     ->join("combinacao_nova c2", "c2.cod_combinacao_nova = c.cod_combinacao_nova_carta_2")
                     ->limit(1)
                     ->get();

        // obtem o registro
        $row = $result->row();

        if(count($row) > 0){

          // ajusta o texto combinacao
          $texto1_2 = $row->texto_combinacao_1 . $row->texto_combinacao_2;

        }else{
            return false;
        }

        // busca a carta 3 generica
        $result = $this->db->select("descricao AS 'texto_combinacao'")
                 ->from("cartas_descricao")
                 ->where("cod_carta", $options["cod_arcano_menor_2"])
                 ->where("sub_tipo", "PASSIVO")
                 ->get();

        $row = $result->row();

        // achou texto3 ok 
        if(count($row)>0){
            
            $texto3 = $row->texto_combinacao;
        }else{

            return false;
        }

        // checa se os 3 textos foram encontrados
        if($texto1_2 != "" && $texto3 != ""){
            // combinacao encontrada
            $row->texto_combinacao = $texto1_2 . $texto3;

            $row->texto_combinacao = encodar_html($row->texto_combinacao);

            return $row;

        }else{

            return false;
        }

        return false;
    }

    public function getMaiorPassivoEspecificoAtivoGenerico($options){
        $texto1 = $texto2 = $texto3 = "";

        // busca o texto 1 e o texto 3 especificos
        // trata os parametros
        $this->db->where("c.cod_casa_carta", $options["cod_casa_carta"]);
        $this->db->where("c.cod_setor_vida", $options["cod_setor_vida"]);

        // trata outros parametros
        $this->db->where("c.cod_carta_1", $options["cod_arcano_maior"])
                 ->where("c.cod_carta_2 IS NULL")
                 ->where("c.cod_carta_3", $options["cod_arcano_menor_2"]);

        // executa o select
        $result = $this->db
                     ->select("c1.texto_combinacao_nova as 'texto_combinacao_1'")
                     ->select("c3.texto_combinacao_nova as 'texto_combinacao_3'")
                     ->select("c.cod_setor_vida")
                     ->select("c.cod_casa_carta")
                     ->from("combinacao_nova_cartas_casa_carta_setor_vida c")
                     ->join("combinacao_nova c1", "c1.cod_combinacao_nova = c.cod_combinacao_nova_carta_1")
                     ->join("combinacao_nova c3", "c3.cod_combinacao_nova = c.cod_combinacao_nova_carta_3")
                     ->limit(1)
                     ->get();

        // obtem o registro
        $row = $result->row();

        if(count($row) > 0){
          // ajusta o texto combinacao
          $texto1 = $row->texto_combinacao_1;
          $texto3 = $row->texto_combinacao_3;

        }else{
            return false;
        }

        // busca a carta 2 generica
        $result = $this->db->select("descricao AS 'texto_combinacao'")
                 ->from("cartas_descricao")
                 ->where("cod_carta", $options["cod_arcano_menor_1"])
                 ->where("sub_tipo", "ATIVO")
                 ->get();

        $row = $result->row();

        // achou texto2 ok 
        if(count($row)>0){
            
            $texto2 = $row->texto_combinacao;
        }else{

            return false;
        }

        // checa se os 3 textos foram encontrados
        if($texto1 != "" && $texto2 != "" && $texto3 != ""){
            // combinacao encontrada
            $row->texto_combinacao = $texto1 . $texto2 . $texto3;

            $row->texto_combinacao = encodar_html($row->texto_combinacao);

            return $row;

        }else{
            
            return false;
        }

        return false;
    }

    public function getAtivoPassivoEspecificoMaiorGenerico($options){
        $texto1 = $texto2 = $texto3 = "";

        // busca o texto 2 e o texto 3 especificos
        // trata os parametros
        $this->db->where("c.cod_casa_carta", $options["cod_casa_carta"]);
        $this->db->where("c.cod_setor_vida", $options["cod_setor_vida"]);

        // trata outros parametros
        $this->db->where("c.cod_carta_1 IS NULL")
                 ->where("c.cod_carta_2", $options["cod_arcano_menor_1"])
                 ->where("c.cod_carta_3", $options["cod_arcano_menor_2"]);

        // executa o select
        $result = $this->db
                     ->select("c2.texto_combinacao_nova as 'texto_combinacao_2'")
                     ->select("c3.texto_combinacao_nova as 'texto_combinacao_3'")
                     ->select("c.cod_setor_vida")
                     ->select("c.cod_casa_carta")
                     ->from("combinacao_nova_cartas_casa_carta_setor_vida c")
                     ->join("combinacao_nova c2", "c2.cod_combinacao_nova = c.cod_combinacao_nova_carta_2")
                     ->join("combinacao_nova c3", "c3.cod_combinacao_nova = c.cod_combinacao_nova_carta_3")
                     ->limit(1)
                     ->get();

        // obtem o registro
        $row = $result->row();

        if(count($row) > 0){
          // ajusta o texto combinacao
          $texto2 = $row->texto_combinacao_2;
          $texto3 = $row->texto_combinacao_3;

        }else{
            return false;
        }

        // busca a carta 1 generica
        $result = $this->db->select("descricao AS 'texto_combinacao'")
                 ->from("cartas_descricao")
                 ->where("cod_carta", $options["cod_arcano_maior"])
                 ->get();

        $row = $result->row();

        // achou texto1 ok 
        if(count($row)>0){
            
            $texto1 = $row->texto_combinacao;
        }else{

            return false;
        }

        // checa se os 3 textos foram encontrados
        if($texto1 != "" && $texto2 != "" && $texto3 != ""){
            // combinacao encontrada
            $row->texto_combinacao = $texto1 . $texto2 . $texto3;

            $row->texto_combinacao = encodar_html($row->texto_combinacao);

            return $row;

        }else{
            
            return false;
        }

        return false;
    }

    public function inserirUsuarioCartaCasaSetor($codUsuario, $codCarta, $codCasa, $codSetor)
    {
        $result = $this->db->select('cod_usuario')
            ->from('usuario_carta_casa_setor')
            ->where('cod_usuario', $codUsuario)
            ->where('cod_carta', $codCarta)
            ->where('cod_casa_carta', $codCasa)
            ->where('cod_setor_vida', $codSetor)
            ->get();

        if($result->num_rows() > 0)
        {
            return true;
        }

        $this->db->insert('usuario_carta_casa_setor', array(
            'cod_usuario' => $codUsuario,
            'cod_carta' => $codCarta,
            'cod_casa_carta' => $codCasa,
            'cod_setor_vida' => $codSetor
        ));

        return true;
    }
}