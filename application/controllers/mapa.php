<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa extends CI_Controller {
    
    
    public function ver(){
        // checa se esta logado
        $this->auth->checkUsuarioLite();
        
        // carrega as models
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("pedido_model", "pedido");

        // busca os jogos do usuario        
        $jogos = $this->url_jogo->get(array(
            "cod_usuario" => $this->auth->getData("cod"),
            "limit"       => 20
        ));

        if(is_object($jogos)){
            $jogos = array($jogos);
        }

        // busca todas combinacoes do usuario (ja compradas)
        $combinacoesCompradas = $this->combinacao->getUsuarioCombinacao(array("cod_usuario" => $this->auth->getData("cod")));

        // busca o custo de cada combinacao
        $custoCombinacao = $this->combinacao->getCusto();

        // percorre os jogos
        foreach ($jogos as $key => $jogo) {
            
            // obtem o jogo completo
            $jogos[$key]->jogoCompleto = getJogoByCartasString($jogo->cartas);

            $combinacoesNaoCompradas = 0;

            // percorre o jogo completo para checar as combinacoes compradas
            foreach ($jogos[$key]->jogoCompleto as $jogoCompleto) {

                $combinacaoCompradaFlag = false;

                // percorre as combinacoes compradas
                foreach($combinacoesCompradas as $combinacaoComprada){
                    
                    // checa se eh a mesma combinacao
                    if(
                        $jogoCompleto["arcanoMaior"]->cod_carta == $combinacaoComprada->cod_arcano_maior &&
                        $jogoCompleto["arcanoMenor1"]->cod_carta == $combinacaoComprada->cod_arcano_menor_1 &&
                        $jogoCompleto["arcanoMenor2"]->cod_carta == $combinacaoComprada->cod_arcano_menor_2 
                    ){
                        // combinacao comprada 
                        $combinacaoCompradaFlag = true;
                        break;
                    }
                }

                // checa se encontrou a combinacao comprada
                if($combinacaoCompradaFlag == false){
                    $combinacoesNaoCompradas++;
                }
            }

            // salva o numero de combinacoes nao compradas
            $jogos[$key]->combinacoesNaoCompradas = $combinacoesNaoCompradas;

            // salva o custo das combinacoes nao compradas
            $jogos[$key]->custoCombinacoesNaoCompradas = $custoCombinacao * $combinacoesNaoCompradas;
        }

        // busca os pedidos de mapeamento
        $pedidos = $this->pedido->get(array("cod_usuario" => $this->auth->getData("cod")));
        
        // carrega o helper necessario
        $this->load->helper("date_helper");

        $statusAmigavel = array(
            "AGUARDANDO_AMOSTRA" => "Aguardando amostra",
            "AMOSTRA_ENVIADA"    => "Amostra enviada"
        );

        // separa os tipos de jogo
        $jogosConsultaVirtual = array();
        $jogosAutoConsulta = array();

        foreach($jogos as $jogo){
            if($jogo->tipo_jogo == "CONSULTA_VIRTUAL"){

                $jogosConsultaVirtual[] = $jogo;
            }else{

                $jogosAutoConsulta[] = $jogo;
            }
        }

        // chama a view
        $this->template->view("mapa_ver", array(
           "jogosConsultaVirtual" => $jogosConsultaVirtual,
           "jogosAutoConsulta"    => $jogosAutoConsulta,
           "title"       => "Meus Mapas",
           "pedidos"     => $pedidos,
           "statusAmigavel" => $statusAmigavel
        ));
    }

    public function salvarTitulo(){

        $this->load->model("url_jogo_model", "url_jogo");

        // obtem os parametros
        $titulo     = $this->input->post("titulo");
        $codUrlJogo = $this->input->post("cod");

        // salva no banco
        $this->url_jogo->saveTituloUsuarioUrlJogo(array(
            "cod_usuario"   => $this->auth->getData("cod"),
            "cod_url_jogo"  => $codUrlJogo,
            "titulo"        => $titulo
        ));

        echo("ok");
        return true;
    }

    public function verJogoCompleto(){
        // obtem o token
        $token = $this->input->get("token");

        // carrega o token na session
        $this->load->library("session");

        // salva o token do jogo na sessao
        $this->session->set_userdata(array("token_jogo" => $token));

        // redireciona pra pag de compra
        redirect(site_url()."/compra/jogo/confirm");
    }
}

?>