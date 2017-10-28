<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conta extends CI_Controller {
    
    public function verOld(){
        // checa se esta logado
        $this->auth->check();
        
        // carrega as models
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");
        $this->load->model("monografia_model", "monografia");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("setor_vida_model", "setor_vida");
        
        // obtem o extrato
        $extrato = $this->conta->getExtrato();
        
        // obtem o saldo
        $saldo = $this->conta->getSaldo(array("cod_usuario"=>$this->auth->getData("cod")));
        
        // carrega o helper necessario
        $this->load->helper("date_helper");
        
        // busca as combinacoes que o usuario ja comprou
        $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod")
        ));

        // busca as urls do jogo
        $urlsJogo = $this->url_jogo->getUsuarioUrlJogo(array("cod_usuario", $this->auth->getData("cod")));

        $jogosCompletos = array();

        // percorre e busca os jogos completos do usuario
        foreach ($urlsJogo as $key => $url) {
            // busca o jogo a partir do codigo da url
            $urlJogo = $this->url_jogo->get(array("cod_url_jogo" => $url->cod_url_jogo));

            // busca o setor da vida
            $setorVida = $this->setor_vida->get(array("cod_setor_vida" => $urlJogo->cod_setor_vida));

            // jogo completo
            $jogoCompleto = getJogoByCartasString($urlJogo->cartas);

            // busca a url amigavel
            $urlAmigavel = montarUrlAmigavel($setorVida, $jogoCompleto);

            // busca o jogo completo
            $jogosCompletos[] = array(
                "data"       => $url->data_cadastro,
                "setor_vida" => $setorVida,
                "cartas"     => getJogoByCartasString($urlJogo->cartas),
                "url"        => $urlAmigavel
            );
        }
        
        // busca as monografias do usuario
        $monografias = $this->monografia->get(array("cod_usuario" => $this->auth->getData("cod")));
        
        // chama a view
        $this->template->view("conta_ver", array(
           "title"       => "Minha conta",
           "extrato"     => $extrato,
           "saldo"       => $saldo,
           "combinacoes" => $combinacoes,
           "monografias" => $monografias,
           "jogosCompletos" => $jogosCompletos
        ));
    }
    
    public function ver(){
        // checa se esta logado
        $this->auth->check();
        
        // carrega as models
        $this->load->model("conta_model", "conta");
        
        // obtem o extrato
        $extrato = $this->conta->getExtrato();
        
        // obtem o saldo
        $saldo = $this->conta->getSaldo(array("cod_usuario"=>$this->auth->getData("cod")));
        
        // carrega o helper necessario
        $this->load->helper("date_helper");
        
        // chama a view
        $this->template->view("conta_ver", array(
           "title"       => "Meus Créditos",
           "extrato"     => $extrato,
           "saldo"       => $saldo,
           "verticalTabs" => true,
            "menuLateral" => false
        ));
    }

    public function doConfirmar(){
        
        // checa a sessao
        $this->auth->check();
        
        // obtem os parametros
        $arcanoMaiorCod = $this->input->get("ama");
        $arcanoMenor1Cod = $this->input->get("ame1");
        $arcanoMenor2Cod = $this->input->get("ame2");
        
        // carrega as models
        $this->load->model("carta_model","carta");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");
        
        // busca os dados das cartas
        $arcanoMaior  = $this->carta->get(array("cod_carta"=>$arcanoMaiorCod));
        $arcanoMenor1 = $this->carta->get(array("cod_carta"=>$arcanoMenor1Cod));
        $arcanoMenor2 = $this->carta->get(array("cod_carta"=>$arcanoMenor2Cod));
        
        // checa se o usuario ja possui a combinacao comprada
        $usuarioCombinacao = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod"),
            "cod_carta_1" => $arcanoMaiorCod,
            "cod_carta_2" => $arcanoMenor1Cod,
            "cod_carta_3" => $arcanoMenor2Cod
        ));
        
        if(count($usuarioCombinacao)>0){
            die("Erro: Voce ja comprou esta combinacao");
        }
        
        // busca o custo da combinacao
        $custo = $this->combinacao->getCusto();
        
        // obtem o saldo do usuario
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        
        // checa o saldo
        if($saldo < $custo){
            die("Erro: saldo insuficiente para a operacao");
        }
        
        // debita no extrato
        $result = $this->conta->insertTransacao(array(
            "descricao" => "Compra da combinação: ".$arcanoMaior->nome_carta." - "
                           .$arcanoMenor1->nome_carta." - ".$arcanoMenor2->nome_carta,
            "valor"     => $custo * -1
        ));
        
        // registra a combinacao comprada
        $this->combinacao->insertUsuarioCombinacao(array(
            "cod_carta_1" => $arcanoMaiorCod,
            "cod_carta_2" => $arcanoMenor1Cod,
            "cod_carta_3" => $arcanoMenor2Cod,
            "cod_usuario" => $this->auth->getData("cod")
        ));
        
        // atualiza o saldo na sessao
        @session_start();
        $usuario = unserialize($_SESSION["usuario"]);
        $usuario["saldo"] = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        $_SESSION["usuario"] = serialize($usuario);
        
        // chama a view
        $this->template->view("compra_do_confirmar", array(
           "title"        => "Compra realizada com sucesso",
           "arcanoMaior"  => $arcanoMaior,
           "arcanoMenor1" => $arcanoMenor1,
           "arcanoMenor2" => $arcanoMenor2,
        ));
    }
    
    public function verUsuarios(){
        $this->auth->checkAdmin();

        $this->load->helper("date_helper");
        
        // carrega a model
        $this->load->model("login_model", "login");
        $this->load->model("conta_model", "conta");

        // obtem a busca do usuario
        $busca = $this->input->get_post("busca");

        // busca os usuarios
        $logins = $this->login->getResumo(array("ativo" => true, "busca" => $busca));

        // se tiver soh um colocar no array
        if(is_object($logins)){
            $logins = array($logins);
        }

        // obtem o total de usuarios
        $totalUsuarios = $this->login->getTotalCadastrados();

        // carrega view
        $this->load->view("conta_ver_usuarios", array(
            "logins" => $logins,
            "totalUsuarios" => $totalUsuarios
        ));
    }
    
    public function verUsuario(){
        $this->auth->checkAdmin();

        // carrega a model
        $this->load->model("login_model", "login");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");

        // define um limite de busca de query
        $limit = 10;

        // obtem o usuario
        $usuarioID = $this->input->get("u");

        // obtem o usuario
        $login = $this->login->get(array("ativo" => true, "usuarioID" => $usuarioID));

        // obtem o resumo do usuario
        $loginResumo = $this->login->getResumo(array("usuarioID" => $usuarioID));

        // busca os jogos do usuario        
        $jogos = $this->url_jogo->get(array("cod_usuario" => $usuarioID, "limit" => $limit));

        if(is_object($jogos)){
            $jogos = array($jogos);
        }

        // busca todas combinacoes do usuario (ja compradas)
        $combinacoes = $this->combinacao->getUsuarioCombinacao(array("cod_usuario" => $usuarioID, "order_by" => "data", "limit" => $limit));

/*
        
        print_r($login);
        print_r($loginResumo);
        print_r($jogos[0]);
        print_r($combinacoes[0]);

        die();
        */

        // carrega o helper de datas
        $this->load->helper("date_helper");

        $this->load->view("conta_ver_usuario", array(
            "login"         => $login,
            "loginResumo"   => $loginResumo,
            "jogos"         => $jogos,
            "combinacoes"   => $combinacoes,
            "limit"         => $limit
        ));

    }

    public function incluirCredito(){
        // autentica como admin
        $this->auth->checkAdmin();
        
        // carrega a model
        $this->load->model("login_model", "login");
        $this->load->model("conta_model", "conta");
        
        // obtem o usuario
        $codUsuario = $this->input->get("u");
        
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $codUsuario));
        
        $login = $this->login->get(array("usuarioID" => $codUsuario));
        
        $this->load->view("conta_incluir_credito", array(
           "login" => $login,
           "saldo" => $saldo
        ));
    }
    
    public function doIncluirCredito(){
        // checa a permissao
        $this->auth->checkAdmin();
        
        // obtem os params
        $usuarioID = $this->input->post("cod_usuario");
        $credito = $this->input->post("credito");
        
        // formata o numero
        $credito = str_replace(",",".",str_replace(".","",$credito));
        
        // valida o credito
        if(!is_numeric($credito) || $credito <= 0){
            die("Erro: Valor de credito invalido");
        }
        
        // carrega a model
        $this->load->model("conta_model", "conta");
        
        // insere a transacao
        $result = $this->conta->insertTransacao(array(
            "descricao" => "Inclusão de créditos",
            "valor"     => $credito,
			"usuarioID" => $usuarioID
        ));
        
        // chama a view
        $this->load->view("conta_do_incluir_credito", array(
            "usuarioID" => $usuarioID
        ));
    }
    
    public function comprarCredito(){

        $incorporado = $this->input->get("incorporado");

        $incorporado = ($incorporado == "true") ? true : false;

        $this->template->view("conta_comprar_credito", array(
            "title" => "Adquirir Cr&eacute;ditos",
            "incorporado" => $incorporado
        ));
    }
}

?>