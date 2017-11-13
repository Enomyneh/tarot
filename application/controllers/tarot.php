<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarot extends CI_Controller {
    
    public function combinacoesDisponiveis(){

        redirect('/jogo/escolherSetorVida');

        // carrega a model 
        $this->load->model("combinacao_model", "combinacao");
        
        try{
            // busca somente as combinacoes disponiveis
            $combinacoesDisponiveis = $this->combinacao->getDisponiveis();
        }catch(Exception $e){
            // todo tratar errors
        }
        
        // checa se esta logado
        if($this->auth->check(false)){
            // busca as combinacoes do usuario
            $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
                "cod_usuario" => $this->auth->getData("cod")
            ));
            
            // percorre as combinacoes disponiveis no sistema
            // e sinaliza se o usuario ja possui a combinacao ou nao
            foreach($combinacoesDisponiveis as $k => $combinacaoDisp){
                // seta como padrao false
                $combinacoesDisponiveis[$k]->jaComprada = false;
                
                // percorre as combinacoes do usuario
                foreach($combinacoes as $combinacao){
                    // checa se o usuario ja possui a combinacao
                    if( $combinacaoDisp->arcanoMaiorCod == $combinacao->cod_arcano_maior &&
                        $combinacaoDisp->arcanoMenor1Cod == $combinacao->cod_arcano_menor_1 &&
                        $combinacaoDisp->arcanoMenor2Cod == $combinacao->cod_arcano_menor_2 ){
                        // seta no array dos disponiveis que esta combinacao ja esta comprada
                        $combinacoesDisponiveis[$k]->jaComprada = true;
                    }
                }
            }
        }
        
        $this->template->view("tarot_combinacoes_disponiveis", array(
            "title" => "Combina&ccedil;&otilde;es Dispon&iacute;veis",
            "combinacoesDisponiveis" => $combinacoesDisponiveis
        ));
    }
    
    public function combinacaoEscolhida(){
        // obtem os parametros
        $arcanoMaiorCod = $this->input->get("am");
        $arcanoMenor1Cod = $this->input->get("ame1");
        $arcanoMenor2Cod = $this->input->get("ame2");

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("combinacao_model", "combinacao");

        // busca os dados das cartas
        $arcanoMaior  = $this->carta->get(array("cod_carta"=>$arcanoMaiorCod));
        $arcanoMenor1 = $this->carta->get(array("cod_carta"=>$arcanoMenor1Cod));
        $arcanoMenor2 = $this->carta->get(array("cod_carta"=>$arcanoMenor2Cod));
        
        // busca o custo da combinacao
        $custo = $this->combinacao->getCusto();
        
        // carrega a view
        $this->template->view("tarot_combinacao_escolhida", array(
            "title" => "Combinação Escolhida",
            "arcanoMaior" => $arcanoMaior,
            "arcanoMenor1" => $arcanoMenor1,
            "arcanoMenor2" => $arcanoMenor2,
            "custo"        => $custo
        ));
    }

    public function index(){

        // checa se eh admin
        if($this->auth->checkAdmin(NO_REDIRECT) == false)
        {
            redirect('/jogo/escolherSetorVida');
        }

        // carrega as models
        $this->load->model("tipo_carta_model", "tipo_carta");
        $this->load->model("carta_model", "carta");
        $this->load->model("grupo_casa_carta_model", "grupo_casa_carta");
        
        // obtem a inf de registro de combinacao disponivel
        $combinacaoDisponivel = $this->input->get("cd");
        $arcMaior = $this->input->get("ama");
        $arcMenor1 = $this->input->get("ame1");
        $arcMenor2 = $this->input->get("ame2");

        // busca os tipos de carta
        $tiposCarta = $this->tipo_carta->get();

        // busca as cartas para cada tipo
        foreach($tiposCarta as $tipoCarta){
            if($tipoCarta->cod_tipo_carta == 1){
                $arcanosMaiores = $this->carta->get(array("cod_tipo_carta"=>$tipoCarta->cod_tipo_carta));
            }else{
                $arcanosMenores = $this->carta->get(array("cod_tipo_carta"=>$tipoCarta->cod_tipo_carta));
            }
        }
        
        // busca os grupos de casa de cartas
        $gruposCasaCarta = $this->grupo_casa_carta->get();

        // carrega a view
        $this->load->view('tarot_index', array(
            "arcanosMaiores" => $arcanosMaiores,
            "arcanosMenores" => $arcanosMenores,
            "gruposCasaCarta" => $gruposCasaCarta,
            "combinacaoDisponivel" => $combinacaoDisponivel,
            "arcMaior" => $arcMaior,
            "arcMenor1" => $arcMenor1,
            "arcMenor2" => $arcMenor2
        ));
    }
    
    public function montarJogo(){
        // checa a autenticacao
        $this->auth->check();
        
        // obtem os parametros
        $setorVidaCod = $this->input->get("sv");
        
        $casasPreenchidas = "";
        
        // checa se possui os dados na sesao
        @session_start();
        if(isset($_SESSION["casas_preenchidas"]) && isset($_SESSION["setor_vida"])){
            $setorVidaCod = $_SESSION["setor_vida"];
            $casasPreenchidas = $_SESSION["casas_preenchidas"];
            
            // limpa os dados
            unset($_SESSION["casas_preenchidas"]);
            unset($_SESSION["setor_vida"]);
        }
        
        // carrega as models
        $this->load->model("setor_vida_model", "setor_vida");
        
        // busca os setores da vida
        $setorVida = $this->setor_vida->get(array("cod_setor_vida" => $setorVidaCod));
        
        // carrega o template
        $this->template->view("tarot_montar_jogo", array(
            "title" => "Montar jogo",
            "setorVida" => $setorVida,
            "casasPreenchidas" => $casasPreenchidas,
			"topBanner" => false,
            "verticalTabs" => true
        ));
    }
    
    public function escolherSetor(){
        // checa a autenticacao
        $this->auth->check();
        
        /*
        // carrega as models
        $this->load->model("setor_vida_model", "setor_vida");
        
        // busca os setores da vida
        $setoresVida = $this->setor_vida->get();
        
        // carrega o template
        $this->template->view("tarot_escolher_setor", array(
            "title" => "Escolha o Setor da Vida",
            "setoresVida" => $setoresVida
        ));
        */
    
        redirect(site_url()."/jogo/escolherSetorVida?p=1");

    }

    public function escolherSetorVida(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // obtem os parametros
        $arcanoMaiorCod = $this->input->post("arcano-maior");
        $arcanoMenor1Cod = $this->input->post("arcano-menor-1");
        $arcanoMenor2Cod = $this->input->post("arcano-menor-2");
        $grupoCasaCartaCod = $this->input->post("grupo-casa-carta");
        $tornarCombinacaoDisponivel = $this->input->post("tornar-combinacao-disponivel");
        
        // se for para tornar combinacao disponivel -> encaminha para outro metodo
        if($tornarCombinacaoDisponivel != false && $tornarCombinacaoDisponivel != "false"){
            return $this->tornarCombinacaoDisponivel($arcanoMaiorCod, $arcanoMenor1Cod, $arcanoMenor2Cod);
        }

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("grupo_casa_carta_model", "grupo_casa_carta");

        // busca os dados das cartas
        $arcanoMaior  = $this->carta->get(array("cod_carta"=>$arcanoMaiorCod));
        $arcanoMenor1 = $this->carta->get(array("cod_carta"=>$arcanoMenor1Cod));
        $arcanoMenor2 = $this->carta->get(array("cod_carta"=>$arcanoMenor2Cod));
        $grupoCasaCarta = $this->grupo_casa_carta->get(array("cod_grupo_casa_carta"=>$grupoCasaCartaCod));

        // busca os setores
        $setoresVida = $this->setor_vida->get();

        // carrega a view
        $this->load->view('tarot_escolher_setor_vida', array(
            "arcanoMaior" => $arcanoMaior,
            "arcanoMenor1" => $arcanoMenor1,
            "arcanoMenor2" => $arcanoMenor2,
            "setoresVida" => $setoresVida,
            "grupoCasaCarta" => $grupoCasaCarta
        ));
    }
    
    public function escolherCasa(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // obtem os parametros
        $arcanoMaiorCod    = $this->input->get("ama");
        $arcanoMenor1Cod   = $this->input->get("ame1");
        $arcanoMenor2Cod   = $this->input->get("ame2");
        $grupoCasaCartaCod = $this->input->get("gcc");
        $setorVidaCod      = $this->input->get("sv");
        $mensagem          = $this->input->get("m");

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("grupo_casa_carta_model", "grupo_casa_carta");
        
        // busca todas as cartas
        $cartas = $this->carta->get(array());
        
        // declara os arrays
        $arcanosMaiores = array();
        $arcanosMenores = array();
        
        // percorre as cartas
        foreach($cartas as $carta){
            // armazena os maiores e menores
            if($carta->cod_tipo_carta == 1){
                $arcanosMaiores[] = $carta;
            }else{
                $arcanosMenores[] = $carta;
            }
            
            // armazena as cartas escolhidas
            if($carta->cod_carta == $arcanoMaiorCod){
                $arcanoMaior = $carta;
            }
            if($carta->cod_carta == $arcanoMenor1Cod){
                $arcanoMenor1 = $carta;
            }
            if($carta->cod_carta == $arcanoMenor2Cod){
                $arcanoMenor2 = $carta;
            }
        }
        
        // busca os grupos de casas de cartas
        $gruposCasaCarta = $this->grupo_casa_carta->get();
        
        // busca os dados dos setores da vida
        $setoresVida = $this->setor_vida->get();
        $setorVidaSelecionado = $this->setor_vida->get(array("cod_setor_vida"=>$setorVidaCod));
        
        // busca as casas das cartas
        $casasCarta = $this->casa_carta->get(array("cod_grupo_casa_carta"=>$grupoCasaCartaCod));
        
        // declara variavel para armazenar as combinacoes
        $combinacoes = array();
        
        // percorre as casas para buscar as combinacoes ja existentes
        foreach($casasCarta as $casaCarta){
            
            // busca a combinacao da casa
            $combinacao = $this->combinacao->get(array(
                "cod_arcano_maior" => $arcanoMaiorCod,
                "cod_arcano_menor_1" => $arcanoMenor1Cod,
                "cod_arcano_menor_2" => $arcanoMenor2Cod,
                "cod_setor_vida" => $setorVidaCod,
                "cod_casa_carta" => $casaCarta->cod_casa_carta
            ));
            
            // se a combinacao eh valida, salva no array
            if(count($combinacao) > 0){
                $auxArray = array(
                    "cod_casa_carta" => $casaCarta->cod_casa_carta,
                    "texto_combinacao" => $combinacao->texto_combinacao
                );
                
                // armazena
                $combinacoes[] = (object)$auxArray;
            }
        }
        
        // carrega a view
        $this->load->view('tarot_escolher_casa', array(
            "arcanosMaiores"  => $arcanosMaiores,
            "arcanosMenores"  => $arcanosMenores,
            "arcanoMaior"     => $arcanoMaior,
            "arcanoMenor1"    => $arcanoMenor1,
            "arcanoMenor2"    => $arcanoMenor2,
            "gruposCasaCarta" => $gruposCasaCarta,
            "setoresVida"     => $setoresVida,
            "casasCarta"      => $casasCarta,
            "mensagem"        => $mensagem,
            "combinacoes"     => $combinacoes,
            "setorVidaSelecionado" => $setorVidaSelecionado,
            "grupoCasaCartaSelecionado" => $grupoCasaCartaCod
        ));
    }
    
    public function doPreencherCombinacao(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // obtem os parametros
        $arcanoMaiorCod  = $this->input->post("arcano-maior");
        $arcanoMenor1Cod = $this->input->post("arcano-menor-1");
        $arcanoMenor2Cod = $this->input->post("arcano-menor-2");
        $grupoCasaCartaCod = $this->input->post("grupo-casa-carta");
        $setorVidaCod    = $this->input->post("setor-vida");
        $casaCartaCod    = $this->input->post("casa-carta");
        $combinacao      = $this->input->post("combinacao-texto");
        $todasCasas      = $this->input->post("todas-casas");
		
        // formata a combinacao
        $combinacaoStr = str_replace(array("\r","\n","\r\n","\t"), '', $combinacao);

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("combinacao_model", "combinacao");
        
        // checa se eh para salvar em todas as casas
        if($todasCasas == "true"){
            // busca todas as casas
            $casasCartas = $this->casa_carta->get(array("cod_grupo_casa_carta" => $grupoCasaCartaCod));

            // percorre as casas e salva
            foreach($casasCartas as $casa){
                // preenche o array  com os dados para salvar
                $data = array(
                    "cod_arcano_maior"   => $arcanoMaiorCod,
                    "cod_arcano_menor_1" => $arcanoMenor1Cod,
                    "cod_arcano_menor_2" => $arcanoMenor2Cod,
                    "cod_setor_vida"     => $setorVidaCod,
                    "cod_casa_carta"     => $casa->cod_casa_carta,
                    "texto_combinacao"   => $combinacaoStr
                );

                // salva a casa com a combinacao
                $this->combinacao->save($data);
            }
            
        }else{
            // preenche o array  com os dados para salvar
            $data = array(
                "cod_arcano_maior"   => $arcanoMaiorCod,
                "cod_arcano_menor_1" => $arcanoMenor1Cod,
                "cod_arcano_menor_2" => $arcanoMenor2Cod,
                "cod_setor_vida"     => $setorVidaCod,
                "cod_casa_carta"     => $casaCartaCod,
                "texto_combinacao"   => $combinacaoStr
            );
            
            // salva as combinacoes
            $this->combinacao->save($data);
        }
        
        // armazena a mensagem
        $mensagem = "A combinação foi salva com sucesso!";
        
        // monta os parameetros
        $params =  "ama=".$arcanoMaiorCod;
        $params .= "&ame1=".$arcanoMenor1Cod;
        $params .= "&ame2=".$arcanoMenor2Cod;
        $params .= "&sv=".$setorVidaCod;
        $params .= "&gcc=".$grupoCasaCartaCod;
        $params .= "&m=".$mensagem;
        
        // redireciona
        redirect(site_url()."/tarot/escolherCasa?".$params);
    }
    
    public function preencherCasa(){
        // obtem os parametros
        $nomeCasaCarta = $this->input->post("nome_casa_carta");
        $combinacaoCasaCarta = $this->input->post("combinacao_casa_carta");
        
        // carrega a view
        $this->load->view("tarot_preencher_casa",array(
            "nomeCasaCarta"         => $nomeCasaCarta,
            "combinacaoCasaCarta"   => $combinacaoCasaCarta
        ));
    }
    
    public function preencherCombinacao(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        // obtem os parametros
        $arcanoMaiorCod  = $this->input->get("ama");
        $arcanoMenor1Cod = $this->input->get("ame1");
        $arcanoMenor2Cod = $this->input->get("ame2");
        $setorVidaCod    = $this->input->get("sv");
        $casaCartaCod    = $this->input->get("cc");

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("combinacao_model", "combinacao");

        // busca os dados das cartas
        $arcanoMaior  = $this->carta->get(array("cod_carta"=>$arcanoMaiorCod));
        $arcanoMenor1 = $this->carta->get(array("cod_carta"=>$arcanoMenor1Cod));
        $arcanoMenor2 = $this->carta->get(array("cod_carta"=>$arcanoMenor2Cod));
        
        // busca os dados dos setores da vida
        $setorVida = $this->setor_vida->get(array("cod_setor_vida"=>$setorVidaCod));
        
        // busca os dados das casas das cartas
        $casaCarta = $this->casa_carta->get(array("cod_casa_carta"=>$casaCartaCod));
        
        // busca a combinacao se existir
        $combinacao = $this->combinacao->get(array(
            "cod_arcano_maior" => $arcanoMaiorCod,
            "cod_arcano_menor_1" => $arcanoMenor1Cod,
            "cod_arcano_menor_2" => $arcanoMenor2Cod,
            "cod_setor_vida" => $setorVidaCod,
            "cod_casa_carta" => $casaCartaCod
        ));
        
        // carrega a view
        $this->load->view('tarot_preencher_combinacao', array(
            "arcanoMaior"  => $arcanoMaior,
            "arcanoMenor1" => $arcanoMenor1,
            "arcanoMenor2" => $arcanoMenor2,
            "combinacao"   => $combinacao,
            "casaCarta"    => $casaCarta,
            "setorVida"    => $setorVida
        ));
    }
    
    public function tornarCombinacaoDisponivel($arcMaior, $arcMenor1, $arcMenor2){
        $valid = true;
        
        $this->load->model("combinacao_model", "combinacao");
        
        // valida os parametros
        if(!is_numeric($arcMaior) || $arcMaior <= 0){
            $valid = false;
        }
        if(!is_numeric($arcMenor1) || $arcMenor1 <= 0){
            $valid = false;
        }
        if(!is_numeric($arcMenor2) || $arcMenor2 <= 0){
            $valid = false;
        }
        
        try{
            // registra a combinacao como disponivel
            $this->combinacao->setDisponivel($arcMaior, $arcMenor1, $arcMenor2);
        }catch(Exception $e){
            // todo tratar erro
        }
        
        // tudo certo retorna ao index
        redirect(site_url()."/tarot/index/?cd=1&ama=".$arcMaior."&ame1=".$arcMenor1."&ame2=".$arcMenor2);
    }
    
    public function verResultado()
    {
        $qtdeCasas = 3;

        // carrega a session
        $this->load->library('session');
        
        // carrega as models necessarias
        $this->load->model("combinacao_model","combinacao");
        $this->load->model("carta_model","carta");
        $this->load->model("setor_vida_model","setor_vida");
        $this->load->model("casa_carta_model","casa_carta");
        $this->load->model("url_jogo_model", "url_jogo");
        
        // obtem os parametros
        $setorVidaCod = $this->input->post("setor-vida");
        $casasPreenchidasStr = $this->input->post("casas-preenchidas");

        // splita a string recebida
        $auxArr = explode(",", $casasPreenchidasStr);
        
        // declara o array para receber as casas
        $casasPreenchidas = array();
        
        // percorre o array auxilizar
        foreach($auxArr as $aux){
            // splita a string com a chave #
            $explode = explode("#", $aux);
            
            // salva no array com a chave sendo o numero da casa
            $casasPreenchidas[$explode[0]] = $aux;
        }

        // checa se tem 10 casas preenchidas
        if(count($casasPreenchidas) < $qtdeCasas){
            die("Erro: Deve-se preencher todas as ".$qtdeCasas." casas!");
        }
        
        // ordena o array pelas chaves (k)
        ksort($casasPreenchidas);

        $aux = array();

        foreach ($casasPreenchidas as $casa) {
            $aux[] = $casa;
        }

        $casasPreenchidas = $aux;

        // percorre o array para concluir a formatacao
        foreach($casasPreenchidas as $k => $casaPreenchida){
            // splita o array com a chave #
            $casaPreenchida = explode("#", $casaPreenchida);
            
            // salva no formato correto
            $casasPreenchidas[$k] = array(
                "casa"         => $casaPreenchida[0],
                "arcanoMaior"  => $this->carta->get(array("cod_carta" => $casaPreenchida[1])),
                "arcanoMenor1" => $this->carta->get(array("cod_carta" => $casaPreenchida[2])),
                "arcanoMenor2" => $this->carta->get(array("cod_carta" => $casaPreenchida[3]))
            );
        }

        $setorVida = $this->setor_vida->get(array("cod_setor_vida" => $setorVidaCod));

        // monta a url amigavel
        $url = montarUrlAmigavel($setorVida, $casasPreenchidas);
        
        // salva o token do jogo na sessao
        $this->session->set_userdata(array("token_jogo" => $url->token));

        // salva a url deste jogo
        $this->url_jogo->save(array(
            "cod_setor_vida"    => $setorVidaCod,
            "cartas"            => $url->cartas,
            "token"             => $url->token,
            "tipo_jogo"         => "AUTO_CONSULTA"
        ));

        redirect("jogo/resultado/".$url->url);
    }
    
    public function inclusaoVariavel($dados = array()){
        // checa se eh admin
        $this->auth->checkAdmin();

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("grupo_casa_carta_model", "grupo_casa_carta");

        // busca os dados das cartas
        $arcanosMaiores = $this->carta->get(array("cod_tipo_carta"=> 1 ));
        $arcanosMenores = $this->carta->get(array("cod_tipo_carta"=> 2 ));
        $setoresVidas   = $this->setor_vida->get();
        $casasCartas    = $this->casa_carta->get(array("cod_grupo_casa_carta" => 1));
        
        // chama a view
        $this->load->view("tarot_inclusao_em_massa", array(
            "arcanosMaiores" => $arcanosMaiores,
            "arcanosMenores" => $arcanosMenores,
            "setoresVida"    => $setoresVidas,
            "casasCartas"    => $casasCartas,
            "msg"            => @$dados["msg"],
            "texto1"         => @$dados['texto1'],
            "texto2"         => @$dados['texto2'],
            "texto3"         => @$dados['texto3'],
            "arcanoMaiorSel" => @$dados['arcanoMaior'],
            "arcanoMenor1Sel" => @$dados['arcanoMenor1'],
            "arcanoMenor2Sel" => @$dados['arcanoMenor2']
        ));
    }
    
    public function doInclusaoEmMassa(){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        $this->load->library("session");
        
        // carrega a model
        $this->load->model("combinacao_model","combinacao");
        
        // obtem os parametros
        $arcanoMaior  = $this->input->post("arcano-maior");
        $arcanoMenor1 = $this->input->post("arcano-menor1");
        $arcanoMenor2 = $this->input->post("arcano-menor2");
        $casasCartas  = $this->input->post("casa-carta");
        $setoresVida  = $this->input->post("setor-vida");
        $texto1       = $this->input->post("texto-1");
        $texto2       = $this->input->post("texto-2");
        $texto3       = $this->input->post("texto-3");
        
        $combinacao = $texto1.$texto2.$texto3;
		
        // formata a combinacao
        $combinacaoStr = str_replace(array("\r","\n","\r\n","\t"), '', $combinacao);
        
        foreach($setoresVida as $setorVida){
            foreach($casasCartas as $casaCarta){
                // preenche o array  com os dados para salvar
                $data = array(
                    "cod_arcano_maior"   => $arcanoMaior,
                    "cod_arcano_menor_1" => $arcanoMenor1,
                    "cod_arcano_menor_2" => $arcanoMenor2,
                    "cod_setor_vida"     => $setorVida,
                    "cod_casa_carta"     => $casaCarta,
                    "texto_combinacao"   => $combinacaoStr
                );

                // salva as combinacoes
                $this->combinacao->save($data);
            }
        }
        
        $dados = array(
            "msg"    => 'Dados salvo com sucesso!',
            "texto1" => $texto1,
            "texto2" => $texto2,
            "texto3" => $texto3,
            "arcanoMaior" => $arcanoMaior,
            "arcanoMenor1" => $arcanoMenor1,
            "arcanoMenor2" => $arcanoMenor2
        );
        
        // chama o controller
        $this->inclusaoEmMassa($dados);
    }
}

?>