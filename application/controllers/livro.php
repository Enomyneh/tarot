<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Livro extends CI_Controller {
    
    public function save(){
        // checa se eh admin
        $this->auth->checkAdmin();

        // carrega a model
        $this->load->model("carta_model", "carta");

        // busca as cartas
        $cartas = $this->carta->get(array());
        
        // obtem a monografia
        $monografia = @$this->input->get("m");
        $detalhe    = @$this->input->get("d");

        // carrega a model
        $this->load->model("monografia_model","monografia");
        
        // busca
        if($monografia > 0){

            $busca["cod_monografia"] = $monografia;

            if($detalhe != "" AND $detalhe > 0){
                $busca["cod_detalhe"] = $detalhe;
            }
            
            // obtem
            $monografia = array_shift($this->monografia->get($busca));
        }

        // busca os titulos das monografias gratis
        $titulos = $this->monografia->getTitulosGerais();

        $capa = ($detalhe != "" AND $detalhe > 0) ? FALSE : TRUE;

        if($capa){
            @$monografia->titulo = "";
            @$monografia->sub_titulo = "";
            @$monografia->detalhe_sub_titulo = "";
            @$monografia->cod_detalhe = "";
        }
        
        $this->load->view("monografia_save", array(
            "monografia" => $monografia,
            "cartas"     => $cartas,
            "titulos"    => $titulos,
            "capa"       => $capa
        ));
    }
    
    public function view(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        
        // busca as monografias
        $monografias = $this->monografia->get(array("texto_monografia" => false));

        // mostra na tela
        $this->load->view("monografia_view", array(
            "monografias" => $monografias
        ));
    }
    
    public function vitrine(){
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        
        // busca as monografias
        $monografias = $this->monografia->get();

        // mostra na tela
        $this->template->view("livro_vitrine", array(
            "title"       => "Livros Virtuais",
            "monografias" => $monografias
        ));
    }

    public function resumo(){
        // checa se esta logadoss
        $this->auth->check();
        
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("carta_model", "carta");

        // busca as cartas
        $arcanosMaiores = $this->carta->get(array("cod_tipo_carta"=> 1));
        $arcanosMenores = $this->carta->get(array("cod_tipo_carta"=> 2));

        // busca as monografias do usuario
        $monografias = $this->monografia->get(array("cod_usuario" => $this->auth->getData("cod")));

        // carrega o helper necessario
        $this->load->helper("date_helper");

        // busca as combinacoes que o usuario ja comprou
        $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod")
        ));

        // mostra na tela
        $this->template->view("monografia_resumo", array(
            "title"       => "Combina&ccedil;&otilde;es",
            "monografias" => $monografias,
            "combinacoes" => $combinacoes,
            "arcanosMaiores" => $arcanosMaiores,
            "arcanosMenores" => $arcanosMenores
        ));
    }
    
    public function ver(){
        // checa se esta logadoss
        $this->auth->check();
        
        // obtem o parametro
        $codMonografia = $this->input->get("m");
        
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        
        // busca as monografias
        $monografia = $this->monografia->get(array(
            "cod_monografia"   => $codMonografia,
            "texto_monografia" => TRUE
        ));
        
        // checa se o usuario comprou a monografia
        $result = $this->monografia->getUsuarioMonografia(array(
            "cod_monografia" => $monografia[0]->cod_monografia,
            "cod_usuario" => $this->auth->getData("cod")
        ));

        if($result){

            // obtem o sumario
            $sumario = $this->createSummary($monografia);   

            // mostra a monografia na tela
            $this->template->view("monografia_ver", array(
                "title"       => "Monografia",
                "monografia"  => $monografia,
                "sumario"     => $sumario,
                "keywords"    => $monografia[0]->keywords,
                "menuLateral" => false
            ));
        }else{
            // mostra a opcao de compra na tela
            $this->template->view("monografia_ver_comprar", array(
                "title"       => "Monografia",
                "monografia"  => $monografia
            ));
        }
    }

    public function livre(){
        
        // obtem o parametro
        $codMonografia = $this->input->get("m");
        
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        
        // busca as monografias
        $monografia = $this->monografia->get(array(
            "cod_monografia"   => $codMonografia,
            "texto_monografia" => TRUE,
            "tipo_monografia" => "GRATIS"
        ));

        if($monografia == FALSE || count($monografia) == 0){
            return "ERRO: MONOGRAFIA NAO ENCONTRADA";
        }

        // obtem o sumario
        $sumario = $this->createSummary($monografia);   

        // mostra a monografia na tela
        $this->template->view("monografia_ver", array(
            "title"       => "Monografia",
            "monografia"  => $monografia,
            "sumario"     => $sumario,
            "keywords"    => $monografia[0]->keywords,
            "menuLateral" => false,
            "menuHorizontal" => true
        ));
    }
    
    public function doSave(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // obtem os parametros
        $titulo     = trim($this->input->post("titulo"));
        $subTitulo  = trim($this->input->post("sub-titulo"));
        $detalheSubTitulo = trim($this->input->post("detalhe-sub-titulo"));
        $preco      = $this->input->post("preco");
        $codCarta   = $this->input->post("carta");
        $monografia = $this->input->post("monografia");
        $codMonografia = $this->input->post("cod_monografia");
        $codDetalhe = $this->input->post("cod_detalhe");
        $tituloGeral = $this->input->post("titulo_geral");
        $tipoMonografia = $this->input->post("tipo_monografia");
        $codMonografiaTituloGeral = $this->input->post("cod_monografia_titulo_geral");
        
        // formata a combinacao
        $monografia = str_replace(array("\r","\n","\r\n","\t"), '', $monografia);
        
        // ajusta o preco
        $preco = str_replace(",",".",str_replace(".","",$preco));
        
        // valida os parametros
        if(trim($monografia) == ""){
            die("Erro: preencha a monografia");
        }
        if($titulo == "" AND is_numeric($codDetalhe) AND $codDetalhe > 0){
            die("Erro: Preencha o titulo pois nao eh a capa");
        }
        if($titulo == "" AND ($subTitulo != "" OR $detalheSubTitulo != "")){
            die("Erro: Para ter subtitulo precisa ter titulo");
        }
        if($subTitulo == "" AND $detalheSubTitulo != ""){
            die("erro: para ter detalhe precisa ter subtitulo");
        }
        if($tipoMonografia == "" OR is_null($tipoMonografia)){
            die("erro: preencha o tipo de monografia");
        }

        // carrega a model
        $this->load->model("monografia_model", "monografia");

        if($codMonografia == ""){

            if($codCarta != "" AND is_numeric($codCarta)){
                // checa se ja existe monografia para esta carta
                $codMonografiaDB = $this->monografia->getCodMonografiaByCodCarta($codCarta);

                if(isset($codMonografiaDB->cod_monografia)){
                    $codMonografia = $codMonografiaDB->cod_monografia;
                }
            }
        }

        if($codMonografiaTituloGeral != "" AND strlen($codMonografiaTituloGeral) > 2){

            list($codMonografia, $tituloGeral) = explode("#", $codMonografiaTituloGeral);
        }
        
        $this->monografia->save(array(
            "titulo"             => $titulo,
            "sub_titulo"         => $subTitulo,
            "detalhe_sub_titulo" => $detalheSubTitulo,
            "preco"              => $preco,
            "monografia"         => $monografia,
            "cod_monografia"     => $codMonografia,
            "cod_detalhe"        => $codDetalhe,
            "cod_carta"          => $codCarta,
            "tipo_monografia"    => $tipoMonografia,
            "titulo_geral"       => $tituloGeral
        ));
        
        // redireciona
        redirect("monografia/view");
    }

    public function removerDetalhe($codDetalhe){

        $this->load->model("monografia_model", "monografia");

        $this->monografia->removerDetalhe($codDetalhe);

        redirect("monografia/view");
    }

    private function createSummary($monografia){

        $titulos = array();
        $subTitulos = array();
        $detalhes = array();

        $tituloAtual = null; $subTituloAtual = null; $detalheAtual = null;

        foreach($monografia as $detalhe){

            if($tituloAtual != $detalhe->titulo){

                $tituloAtual = $detalhe->titulo;

                $titulos[] = array(
                    "titulo" => $detalhe->titulo,
                    "cod_detalhe" => ($detalhe->sub_titulo != "") ? NULL : $detalhe->cod_detalhe
                );
            }

            if($subTituloAtual != $detalhe->sub_titulo AND $detalhe->sub_titulo != ""){

                $subTituloAtual = $detalhe->sub_titulo;

                $subTitulos[] = array(
                    "sub_titulo" => $detalhe->sub_titulo,
                    "titulo"     => $detalhe->titulo,
                    "cod_detalhe" => ($detalhe->detalhe_sub_titulo != "") ? NULL : $detalhe->cod_detalhe
                );
            }

            if($detalheAtual != $detalhe->detalhe_sub_titulo AND $detalhe->detalhe_sub_titulo != ""){

                $detalheAtual = $detalhe->detalhe_sub_titulo;

                $detalhes[] = array(
                    "detalhe"    => $detalhe->detalhe_sub_titulo,
                    "titulo"     => $detalhe->titulo,
                    "sub_titulo" => $detalhe->sub_titulo,
                    "cod_detalhe" => $detalhe->cod_detalhe
                );
            }
        }

        return array(
            "titulos"       => $titulos,
            "sub_titulos"   => $subTitulos,
            "detalhes"      => $detalhes
        );
    }

    public function saveKeywords(){
        // checa se esta logadoss
        $this->auth->checkAdmin();
        
        // obtem o parametro
        $codMonografia = $this->input->get("m");
        
        // carrega a model
        $this->load->model("monografia_model", "monografia");
        $this->load->model("carta_model", "carta");
        
        // busca as monografias
        $monografia = $this->monografia->get(array(
            "cod_monografia"   => $codMonografia,
            "texto_monografia" => FALSE
        ));

        $carta = $this->carta->get(array("cod_carta" => $monografia[0]->cod_carta));

        $this->load->view("monografia_save_keywords", array(
            "monografia" => $monografia,
            "carta" => $carta
        ));        
    }

    public function doSaveKeywords(){

        // checa admin
        $this->auth->checkAdmin();

        $this->load->model("monografia_model", "monografia");

        // obtem os parametros
        $keywords = $this->input->post("keywords");
        $codMonografia = $this->input->post("cod_monografia");

        // salva as palavras chave
        $this->monografia->saveKeywords(array(
            "cod_monografia" => $codMonografia,
            "keywords"       => $keywords
        ));

        redirect("monografia/view");
    }
}

?>