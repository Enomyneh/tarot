<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Compra
 *
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 * @property Combinacao_model combinacao
 * @property Auth auth
 * @property Jogo_model jogo
 * @property Pedido_model pedido
 */

class Compra extends CI_Controller {
    
    public function confirmar()
    {
        // obtem os parametros
        $arcanoMaiorCod = $this->input->get("ama");
        $arcanoMenor1Cod = $this->input->get("ame1");
        $arcanoMenor2Cod = $this->input->get("ame2");
        $origem = $this->input->get("o");

        @session_start();
        if($origem != "" && !is_null($origem)){
            $_SESSION["origem_pedido"] = $origem;
        }
        
        // checa se esta logado
        if($this->auth->check(false) == false){
            // salva o pedido na session
            $_SESSION["pedido"] = serialize(array(
                "arcanoMaiorCod"  => $arcanoMaiorCod,
                "arcanoMenor1Cod" => $arcanoMenor1Cod,
                "arcanoMenor2Cod" => $arcanoMenor2Cod
            ));
            
            // redireciona para o login
            redirect("login/signin");
        }
        
        // carrega as models
        $this->load->model("carta_model","carta");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");

        // checa se o usuario ja possui a combinacao comprada
        $usuarioCombinacao = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod"),
            "cod_carta_1" => $arcanoMaiorCod,
            "cod_carta_2" => $arcanoMenor1Cod,
            "cod_carta_3" => $arcanoMenor2Cod
        ));
        
        if(count($usuarioCombinacao)>0)
        {
            // direciona para a tela da combinacao ja comprada
            redirect(site_url() . "/jogo/escolherSetorVida?cuc=" . $usuarioCombinacao[0]->cod_usuario_combinacao);
        }
        
        // busca os dados das cartas
        $arcanoMaior  = $this->carta->get(array("cod_carta"=>$arcanoMaiorCod));
        $arcanoMenor1 = $this->carta->get(array("cod_carta"=>$arcanoMenor1Cod));
        $arcanoMenor2 = $this->carta->get(array("cod_carta"=>$arcanoMenor2Cod));
        
        // busca o custo da combinacao
        $custo = $this->combinacao->getCusto();
        
        // obtem o saldo do usuario
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        
        if($saldo < $custo){
            // chama a view
            $this->template->view("saldo_insuficiente", array(
               "title"  => "Saldo Insuficiente",
               "saldo"  => $saldo,
               "custo"  => $custo
            ));
        }else{
            // chama a view
            $this->template->view("compra_confirmar", array(
               "title"        => "Confirmar Compra",
               "arcanoMaior"  => $arcanoMaior,
               "arcanoMenor1" => $arcanoMenor1,
               "arcanoMenor2" => $arcanoMenor2,
               "custo"        => $custo
            ));
        }
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
        
        $casasPreenchidas = "";
        $origem = "";
        
        // checa se o usuario ja estava montando seu jogo
        if(isset($_SESSION["casas_preenchidas"])){
            $casasPreenchidas = $_SESSION["casas_preenchidas"];
        }

        if(isset($_SESSION["origem_pedido"])){
            $origem = $_SESSION["origem_pedido"];
        }
        
        // chama a view
        $this->template->view("compra_do_confirmar", array(
           "title"        => "Compra realizada com sucesso",
           "arcanoMaior"  => $arcanoMaior,
           "arcanoMenor1" => $arcanoMenor1,
           "arcanoMenor2" => $arcanoMenor2,
           "casasPreenchidas" => $casasPreenchidas,
           "origem"      => $origem
        ));
    }
    
    public function doMonografiaConfirmar(){
        // checa a sessao
        $this->auth->check();
        
        // obtem os parametros
        $monografiaCod = $this->input->get("m");
        
        // carrega as models
        $this->load->model("monografia_model","monografia");
        $this->load->model("conta_model", "conta");
        
        // busca a monografia
        $monografia = array_shift($this->monografia->get(array("cod_monografia" => $monografiaCod)));
        
        // checa se o usuario ja possui a monografia
        $result = $this->monografia->getUsuarioMonografia(array(
            "cod_usuario" => $this->auth->getData("cod"),
            "cod_monografia" => $monografia->cod_monografia
        ));
        
        // valida
        if($result){
            die("Erro: Voce ja possui esta monografia");
        }
        
        // obtem o saldo do usuario
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        
        // checa o saldo
        if($saldo < $monografia->preco_monografia){
            die("Erro: saldo insuficiente para a operacao");
        }
        
        // debita no extrato
        $result = $this->conta->insertTransacao(array(
            "descricao" => "Compra da monografia: ".$monografia->titulo_monografia,
            "valor"     => $monografia->preco_monografia * -1
        ));
        
        // registra a combinacao comprada
        $this->monografia->insertUsuarioMonografia(array(
            "cod_monografia" => $monografia->cod_monografia,
            "cod_usuario"   => $this->auth->getData("cod")
        ));
        
        // atualiza o saldo na sessao
        @session_start();
        $usuario = unserialize($_SESSION["usuario"]);
        $usuario["saldo"] = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        $_SESSION["usuario"] = serialize($usuario);
        
        // chama a view
        $this->template->view("compra_do_monografia_confirmar", array(
           "title"        => "Compra realizada com sucesso",
           "monografia"   => $monografia
        ));
    }
    
    public function monografiaConfirmar(){
        // obtem os parametros
        $monografiaCod = $this->input->get("m");
        
        // carrega as models
        $this->load->model("conta_model", "conta");
        $this->load->model("monografia_model", "monografia");
        
        // checa se esta logado
        $this->auth->check();
        
        // obtem a monografia
        $monografia = array_shift($this->monografia->get(array("cod_monografia" => $monografiaCod)));
        
        // obtem o saldo do usuario
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        
        if($saldo < $monografia->preco_monografia){
            die("Erro: saldo insuficiente para a operacao");
        }
        
        // chama a view
        $this->template->view("compra_monografia_confirmar", array(
           "title"        => "Confirmar Compra",
           "monografia"   => $monografia
        ));
    }

    // funcao para comprar o jogo com dez combinacoes 
    public function jogo($rota)
    {
        if($rota == "confirm_without_login"){
            $this->confirmarJogoCompleto();
        }
        else if($rota == "confirm"){
            $this->confirmarJogoCompleto();
        }
        else if($rota == "debitar"){
            $this->debitar();
        }
        else if($rota == "redirect_resultado"){
            $this->redirecionarResultado();
        }
        else{
            die("erro: rota nao definida");
        }
    }

    public function confirmarSemLogin(){
        // carrega a session
        $this->load->library("session");

        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");

        // obtem o jogo da session
        $token = $this->session->userdata("token_jogo");

        // valida o token
        if(isMd5($token) == false){
            die("erro: token invalido");
        }

        // busca as cartas do jogo atual
        $urlJogo = $this->url_jogo->get(array("token" => $token));

        // busca o jogo completo a patir da string das cartas
        $jogoCompleto = getJogoByCartasString($urlJogo->cartas);

        // checa se esta logado
        /*
        if($this->auth->check(false) == true){
            // busca as combinacoes do usuario
            $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
                "cod_usuario" => $this->auth->getData("cod")
            ));
        }
        */

        // busca o custo das combinacoes
        $custo = $this->combinacao->getCusto();

        // chama a view
        $this->template->view("compra_confirmar_sem_login", array(
            "title" => "Confirmar compra",
            "jogoCompleto" => $jogoCompleto,
            "custo" => $custo,
            "verticalTabs" => true
        ));
    }

    public function confirmarJogoCompleto()
    {
        // carrega as models
        $this->load->model("carta_model", "carta");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");
        $this->load->model("jogo_model", "jogo");
        $this->load->model("pedido_model", "pedido");

        // busca o jogo completo a patir da session
        $jogoCompleto = $this->jogo->getByTokenInSession();

        // busca os dados do pedido caso ja exista
        $pedidos = $this->pedido->get(array('token' => $jogoCompleto->url->token));

        $pedido = null;
        if(count($pedidos) > 0)
        {
            /** @var Pedido_model $pedido */
            $pedido = array_shift($pedidos);

            // atualiza o status do pedido
            $pedido->atualizaStatus();

            // checa se ja esta pago
            if($pedido->status == STATUS_PAGO)
            {
                // se o jogo ainda nao esta liberado para consulta, insere o jogo para o usuario
                if($jogoCompleto->liberadoParaConsulta == false)
                {
                    $this->inserirJogoParaUsuario($jogoCompleto);
                }
            }
        }

        // chama a view
        $this->template->view("compra_confirmar_jogo_completo", array(
            "title" => "Confirmar compra",
            "jogoCompleto" => $jogoCompleto,
            "pedido" => $pedido,
            "verticalTabs" => true
        ));
    }

    public function debitar(){
        // checa a sessao
        $this->auth->check();
        
        // carrega as models
        $this->load->model("carta_model","carta");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");
        $this->load->model("url_jogo_model", "url_jogo");

        // carrega a session
        $this->load->library("session");

        // obtem o jogo da session
        $token = $this->session->userdata("token_jogo");

        // valida o token
        if(isMd5($token) == false){
            die("erro: token invalido");
        }

        // busca as cartas do jogo atual
        $urlJogo = $this->url_jogo->get(array("token" => $token));

        // busca o jogo completo a patir da string das cartas
        $jogoCompleto = getJogoByCartasString($urlJogo->cartas);

        // busca as combinacoes do usuario
        $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod")
        ));

        // compara para ver quais combinacoes o usuario ja possui
        foreach ($jogoCompleto as $key => $jogo) {
            // marca como nao comprado
            $jogoCompleto[$key]["comprado"] = false;

            foreach ($combinacoes as $combinacao) {
                if( $jogo["arcanoMaior"]->cod_carta == $combinacao->cod_arcano_maior && 
                    $jogo["arcanoMenor1"]->cod_carta == $combinacao->cod_arcano_menor_1 && 
                    $jogo["arcanoMenor2"]->cod_carta == $combinacao->cod_arcano_menor_2){

                    // marca como comprado
                    $jogoCompleto[$key]["comprado"] = true;

                    break;
                }
            }
        }
        
        // busca o custo unitario da combinacao
        $custo = $this->combinacao->getCusto();

        $total = 0;

        foreach ($jogoCompleto as $key => $jogo) {
            if(!$jogo["comprado"]){
                $total += $custo;
            }
        }

        // checa o total
        if($total == 0){
            die("Erro: Nao ha valor para debitar.");
        }

        
        // obtem o saldo do usuario
        $saldo = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        
        // checa o saldo
        if($saldo < $total){
            die("Erro: saldo insuficiente para a operacao");
        }

        // percorre o jogo para debitar um por um no extrato
        foreach ($jogoCompleto as $key => $jogo) {

            if(!$jogo["comprado"]){

                // debita no extrato
                $result = $this->conta->insertTransacao(array(
                    "descricao" => "Compra da combinação: ".$jogo["arcanoMaior"]->nome_carta." - "
                                   .$jogo["arcanoMenor1"]->nome_carta." - ".$jogo["arcanoMenor2"]->nome_carta,
                    "valor"     => $custo * -1
                ));
                
                // registra a combinacao comprada
                $this->combinacao->insertUsuarioCombinacao(array(
                    "cod_carta_1" => $jogo["arcanoMaior"]->cod_carta,
                    "cod_carta_2" => $jogo["arcanoMenor1"]->cod_carta,
                    "cod_carta_3" => $jogo["arcanoMenor2"]->cod_carta,
                    "cod_usuario" => $this->auth->getData("cod")
                ));
            }
        }
        
        // atualiza o saldo na sessao
        @session_start();
        $usuario = unserialize($_SESSION["usuario"]);
        $usuario["saldo"] = $this->conta->getSaldo(array("cod_usuario" => $this->auth->getData("cod")));
        $_SESSION["usuario"] = serialize($usuario);
        
        // chama a view
        $this->template->view("compra_debitar", array(
           "title"        => "Compra realizada com sucesso",
        ));
    }

    public function obterJogo()
    {
        // carrega as models
        $this->load->model("carta_model","carta");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("conta_model", "conta");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("jogo_model", "jogo");

        $jogoCompleto = $this->jogo->getByTokenInSession();

        // checa o valor do jogo, se for gratis, apenas mostra o resultado
//        if($jogoCompleto->custo == 0)
//        {
//
//        }

        $this->redirecionarResultado($jogoCompleto);
        die;
    }

    public function redirecionarResultado(Jogo_model $jogo)
    {
        // monta a url amigavel
        $url = Utils::montarUrlAmigavel($jogo);

        redirect("jogo/resultado/".$url->url . '?came_from_compras=1');
    }

    private function inserirJogoParaUsuario(Jogo_model $jogoCompleto)
    {
        $this->load->model("combinacao_model", "combinacao");

        $setorVida = $jogoCompleto->setorVida;

        $codUsuario = $this->auth->getData("cod");

        foreach($jogoCompleto->combinacoes as $key => $jogo)
        {
            // insere o arcano maior
            $this->combinacao->inserirUsuarioCartaCasaSetor($codUsuario, $jogo['arcanoMaior']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta, $setorVida->cod_setor_vida);

            // insere o arcano menor 1
            $this->combinacao->inserirUsuarioCartaCasaSetor($codUsuario, $jogo['arcanoMenor1']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta, $setorVida->cod_setor_vida);

            // insere o arcano maior
            $this->combinacao->inserirUsuarioCartaCasaSetor($codUsuario, $jogo['arcanoMenor2']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta, $setorVida->cod_setor_vida);
        }

        return true;
    }
}