<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Pedido
 * @property Jogo_model jogo
 * @property Pedido_model pedido
 */
class Pedido extends CI_Controller {
    
    public function mapeamento(){

        // checa se esta logado
        $this->auth->checkUsuarioLite();

        // obtem os parametro
        $setorVidaLabel = $this->input->get("setor-vida");
        $subSetorVidaLabel = $this->input->get("sub-setor");
        $tipoMapeamentoLabel = $this->input->get("tipo-mapa");

        // carrega as models
        $this->load->model("sub_setor_vida_model", "sub_setor_vida");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("mapeamento_model", "mapeamento");

        // obtem o setor da vida a partir da label
        $setorVida = $this->setor_vida->get(array("link_label" => $setorVidaLabel));

        // obtem o subsetor a partir da label
        $subSetor = $this->sub_setor_vida->get(array("link_label" => $subSetorVidaLabel));

        // obtem o tipo de mapeamento a partir da label
        $tipoMapeamento = $this->mapeamento->getTipo(array("link_label" => $tipoMapeamentoLabel));
        
        
        $this->template->view("pedido_mapeamento", array(
            "title" => "Pré-Análise",
            "setorVida" => $setorVida,
            "subSetor" => $subSetor,
            "tipoMapeamento" => $tipoMapeamento
        ));
    }

    public function mapeamentoSolicitado(){

        // checa se esta logado
        $this->auth->checkUsuarioLite();
        
        // obtem os parametros
        $codSetorVida = $this->input->post("cod-setor-vida");
        $codSubSetorVida = $this->input->post("cod-sub-setor-vida");
        $codTipoMapeamento = $this->input->post("cod-tipo-mapeamento");
        $codTipoMapeamento = $this->input->post("cod-tipo-mapeamento");
        $perguntas = $this->input->post("perguntas");
        $primeiraPergunta = trim($this->input->post("primeira-pergunta"));
        $orientacao = trim($this->input->post("orientacao-sexual"));

        if($primeiraPergunta != "" AND strlen($primeiraPergunta) > 0){

            if(is_array($perguntas) == FALSE){
                $perguntas = array();
            }
            array_unshift($perguntas, $primeiraPergunta);
        }

        // carrega as models
        $this->load->model("pedido_model", "pedido");
        $this->load->model("login_model", "login");
        $this->load->model("mapeamento_model", "mapeamento");

        // adiciona o pedido
        $codPedido = $this->pedido->insert(array(
            "data" => date("Y-m-d H:i:s"),
            "status" => "AGUARDANDO_AMOSTRA",
            "cod_usuario" => Auth::getData("cod"),
            "ativo" => 1
        ));

        // adiciona o mapeamento
        $codMapeamento = $this->mapeamento->insert(array(
            "cod_mapeamento_tipo" => $codTipoMapeamento,
            "cod_setor_vida" => $codSetorVida,
            "cod_sub_setor_vida" => $codSubSetorVida
        ));

        // relaciona o mapeamento com o pedido
        $result = $this->mapeamento->addToPedido(array(
            "cod_mapeamento" => $codMapeamento,
            "cod_pedido"     => $codPedido
        ));

        // adiciona as perguntas ao mapeamento
        if(is_array($perguntas) AND count($perguntas) >0){

            foreach($perguntas as $pergunta){

                $this->mapeamento->addPergunta(array(
                    "cod_mapeamento" => $codMapeamento,
                    "pergunta" => $pergunta
                ));
            }
        }

        // atualiza o genero se necessario
        if($orientacao != ""){

            $this->login->save(array("orientacao_sexual" => $orientacao), Auth::getData("cod"));
        }

        // tudo certo retorna
        $this->template->view("pedido_mapeamento_solicitado", array(
            "title" => "Obrigado",
            "codPedido" => $codPedido
        ));
    }

    public function verTodos(){

        // checa se esta logado
        $this->auth->checkAdmin();

        // carrega a model necessaria
        $this->load->model("pedido_model", "pedido");
        $this->load->model("mapeamento_model", "mapeamento");

        // obtem todos os pedidos
        $pedidos = $this->pedido->get();

        // obtem a mensagem se houver
        $mensagem = $this->session->flashdata("msg");

        foreach($pedidos as $pedido){

            // busca as perguntas de cada mapeamento
            $pedido->perguntas = $this->mapeamento->getPerguntas(array("cod_mapeamento" => $pedido->cod_mapeamento));
        }

        $this->load->helper("date_helper");

        $this->load->view("pedido_ver_todos", array(
            "pedidos" => $pedidos,
            "mensagem" => $mensagem
        ));
    }

    public function registrarAmostra(){

        $this->auth->checkAdmin();

        // carrega model
        $this->load->model("pedido_model", "pedido");

        // obtem o codigo do pedido
        $codPedido = $this->input->get("pedido");

        // muda o status do pedido
        $this->pedido->changeStatus("AMOSTRA_ENVIADA", $codPedido);

        // seta a mensagem
        $this->session->set_flashdata("msg","AMOSTRA REGISTRADA COM SUCESSO");

        // mostra a tela de pedidos
        redirect("/pedido/verTodos");
    }

    public function montarLink(){

        $this->auth->checkAdmin();

        // carrega as models necesarias
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("sub_setor_vida_model", "sub_setor_vida");
        $this->load->model("mapeamento_model", "mapeamento");

        // busca os setores da vida
        $setoresVida = $this->setor_vida->get();
        $subSetoresVida = $this->sub_setor_vida->get();
        $tiposMapeamento = $this->mapeamento->getTipo();

        $subSetoresVidaAgrupado = array();

        // agrupa os sub setores da vida
        foreach($subSetoresVida as $sub){

            if(!isset($subSetoresVidaAgrupado[$sub->cod_setor_vida])){
                $subSetoresVidaAgrupado[$sub->cod_setor_vida] = array();
            }

            $subSetoresVidaAgrupado[$sub->cod_setor_vida][] = $sub;
        }

        $this->load->view("pedido_montar_link", array(
            "setoresVida" => $setoresVida,
            "subSetoresVida" => $subSetoresVidaAgrupado,
            "tiposMapeamento" => $tiposMapeamento
        ));
    }

    public function remover(){

        $this->auth->checkAdmin();

        $codPedido = $this->input->get("p");

        $this->load->model("pedido_model", "pedido");

        $this->pedido->desativar($codPedido);

        redirect(site_url() . "/pedido/verTodos");
    }

    public function gerarPagSeguro()
    {
        $this->load->model("jogo_model", "jogo");
        $this->load->model("pedido_model", 'pedido');

        $jogo = new Jogo_model();
        $jogo->getByTokenInSession();

        // cria o pedido
        $pedido = $this->pedido->create($jogo);

        // gera o codigo do PagSeguro
        $retorno = Utils::createPagSeguroTransactionCode($jogo, $pedido);

        die(json_encode($retorno));
    }

    public function pagSeguroSalvarTransactionCode()
    {
        $this->load->model("pedido_model", 'pedido');

        // obtem os parametros
        $codPedido = $this->input->post('codPedido');
        $pagSeguroTransactionCode = $this->input->post('pagSeguroTransactionCode');

        // obtem o pedido
        /** @var Pedido_model $pedido */
        $pedido = array_shift($this->pedido->get(array('cod_pedido' => $codPedido)));

        // inclui o pagseguroTransactionCode
        $pedido->pagSeguroTransactionCode = $pagSeguroTransactionCode;

        // salva no bd
        $pedido->update();

        die(json_encode(array('status' => true)));
    }
}

