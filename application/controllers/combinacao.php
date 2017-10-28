<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Combinacao
 *
 * @property Combinacao_model combinacao
 * @property CI_Input input
 *
 */
class Combinacao extends CI_Controller {

    public function vitrine(){

        // mostra na tela
        $this->template->view("combinacao_vitrine", array(
            "title"       => "Combinações de Cartas"
        ));
    }

    public function resumo(){
        // checa se esta logadoss
        $this->auth->check();
        
        // carrega a model
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("carta_model", "carta");

        // busca as cartas
        $arcanosMaiores = $this->carta->get(array("cod_tipo_carta"=> 1));
        $arcanosMenores = $this->carta->get(array("cod_tipo_carta"=> 2));

        // carrega o helper necessario
        $this->load->helper("date_helper");

        // busca as combinacoes que o usuario ja comprou
        $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario" => $this->auth->getData("cod")
        ));

        // mostra na tela
        $this->template->view("combinacao_resumo", array(
            "title"       => "Combina&ccedil;&otilde;es",
            "monografias" => array(),
            "combinacoes" => $combinacoes,
            "arcanosMaiores" => $arcanosMaiores,
            "arcanosMenores" => $arcanosMenores,
            "verticalTabs"  => true,
            "menuLateral"   => false
        ));
    }
    
    public function cadastrar(){
        // checa se eh admin
        $this->auth->checkAdmin();

        // carrega a model 
        $this->load->model("carta_model", "carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("casa_carta_model", "casa_carta");
        
        try{
            $cartas         = $this->carta->get(array());
            $setoresVida    = $this->setor_vida->get(array());
            $casasCarta     = $this->casa_carta->get(array("cod_grupo_casa_carta" => 1));

        }catch(Exception $e){
            // todo tratar errors
        }
        
        // carrega a view
        $this->load->view("combinacao_cadastrar", array(
            "cartas"        => $cartas,
            "setoresVida"   => $setoresVida,
            "casasCartas"   => $casasCarta,
            "message"       => $this->input->get("m")
        ));
    }

    public function doCadastrar(){
        // checa admin
        $this->auth->checkAdmin();

        $carta1         = $this->input->post("carta-1");
        $carta2         = $this->input->post("carta-2");
        $carta3         = $this->input->post("carta-3");
        $carta1Valor    = Utils::convertCurrencyToFloat($this->input->post("carta-1-valor"));
        $carta2Valor    = Utils::convertCurrencyToFloat($this->input->post("carta-2-valor"));
        $carta3Valor    = Utils::convertCurrencyToFloat($this->input->post("carta-3-valor"));
        $setoresVida    = $this->input->post("setor-vida");
        $casasCartas    = $this->input->post("casa-carta");

        $textoCombinacaoCarta1 = $this->input->post("combinacao-carta-1");
        $textoCombinacaoCarta2 = $this->input->post("combinacao-carta-2");
        $textoCombinacaoCarta3 = $this->input->post("combinacao-carta-3");

        // trata a combinacao
        $textoCombinacaoCarta1 = str_replace(array("\r","\n","\r\n","\t"), '', $textoCombinacaoCarta1);
        $textoCombinacaoCarta2 = str_replace(array("\r","\n","\r\n","\t"), '', $textoCombinacaoCarta2);
        $textoCombinacaoCarta3 = str_replace(array("\r","\n","\r\n","\t"), '', $textoCombinacaoCarta3);

        $this->load->model("combinacao_model", "combinacao");

        if(strlen($textoCombinacaoCarta1) > 5 && is_numeric($carta1) && $carta1 > 0){
            $codCombinacaoCarta1 = $this->combinacao->saveNew($textoCombinacaoCarta1);
        }else{
            $codCombinacaoCarta1 = NULL;
        }
        if(strlen($textoCombinacaoCarta2) > 5 && is_numeric($carta2) && $carta2 > 0){
            $codCombinacaoCarta2 = $this->combinacao->saveNew($textoCombinacaoCarta2);
        }else{
            $codCombinacaoCarta2 = NULL;
        }
        if(strlen($textoCombinacaoCarta3) > 5 && is_numeric($carta3) && $carta3 > 0){
            $codCombinacaoCarta3 = $this->combinacao->saveNew($textoCombinacaoCarta3);
        }else{
            $codCombinacaoCarta3 = NULL;
        }

        foreach($setoresVida as $setorVida){

            foreach($casasCartas as $casaCarta){

                $this->combinacao->saveRelationship(array(
                    "carta1"                 => $carta1,
                    "carta2"                 => $carta2,
                    "carta3"                 => $carta3,
                    "cod_setor_vida"         => $setorVida,
                    "cod_casa_carta"         => $casaCarta,
                    "cod_combinacao_carta_1" => $codCombinacaoCarta1,
                    "cod_combinacao_carta_2" => $codCombinacaoCarta2,
                    "cod_combinacao_carta_3" => $codCombinacaoCarta3,
                    "carta1Valor"            => $carta1Valor,
                    "carta2Valor"            => $carta2Valor,
                    "carta3Valor"            => $carta3Valor
                ));
            }
        }

        // redireciona
        redirect("combinacao/cadastrar?m=sucesso");
    }
}