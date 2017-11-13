<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carta extends CI_Controller {
    
    public function escolher(){
        
        // obtem os parametros
        $casaCod         = $this->input->get("casa");
        $combinacaoAtual = $this->input->get("cA");
        
        // declara as variaveis necessarias
        $arcMaiorAtual = $arcMenor1Atual = $arcMenor2Atual = null;
        
        // checa se existe combinacao atual
        if(strlen($combinacaoAtual) > 3){
            // splita a string e obtem os dados
            $arr = explode("-",$combinacaoAtual);
            
            // obtem os dados
            $arcMaiorAtual = $arr[1]; $arcMenor1Atual = $arr[2]; $arcMenor2Atual = $arr[3];
        }
        
        // carrega a model
        $this->load->model("carta_model", "carta");
        
        try{
            // busca as cartas
            $arcanosMaiores = $this->carta->get(array("cod_tipo_carta"=> 1));
            $arcanosMenores = $this->carta->get(array("cod_tipo_carta"=> 2));
        }catch(Exception $e){
            // todo
        }

        $this->load->view("carta_escolher", array(
            "arcanosMaiores" => $arcanosMaiores,
            "arcanosMenores" => $arcanosMenores,
            "arcMaiorAtual" => $arcMaiorAtual,
            "arcMenor1Atual" => $arcMenor1Atual,
            "arcMenor2Atual" => $arcMenor2Atual,
            "casaCod"        => $casaCod
        ));
    }
    
    public function checarDisponibilidadeJSON(){
        // obtem os parametros
        $arcMaior  = $this->input->post("ama");
        $arcMenor1 = $this->input->post("ame1");
        $arcMenor2 = $this->input->post("ame2");
        
        // valida os arcanos menores
        if($arcMenor1 == $arcMenor2){
            // retorna o json
            die(json_encode(array(
                "result" => false,
                "message" => "O Arcano menor 1 deve ser diferente do Arcano menor 2"
            )));
        }
        
        // carrega a model
        $this->load->model("combinacao_model","combinacao");
        /*
        // busca a disponibilidade da combinacao
        $result = $this->combinacao->getDisponiveis(array(
            "arcanoMaiorCod"    => $arcMaior,
            "arcanoMenor1Cod"   => $arcMenor1,
            "arcanoMenor2Cod"   => $arcMenor2
        ));

        
        // checa a disponibilidade
        if(count($result) == 0){
            die(json_encode(array(
                "result" => false,
                "message" => "A combinação não está disponível para consulta"
            )));
        }
        */
        
        // checa se o usuario possui a combinacao como comprada
        $result = $this->combinacao->getUsuarioCombinacao(array(
            "cod_carta_1" => $arcMaior,
            "cod_carta_2" => $arcMenor1,
            "cod_carta_3" => $arcMenor2,
            "cod_usuario" => $this->auth->getData("cod")
        ));
        
        // checa a permissao do usuario
        if(count($result) == 0){
            die(json_encode(array(
                "result" => false,
                "available" => true,
                "message" => "Esta combinação não faz parte da sua conta. Você deve comprá-la, para poder visualizar seu resultado."
            )));
        }
        
        die(json_encode(array(
            "result" => true,
            "message" => "Combinação disponível"
        )));
    }
    
    public function comprarCombinacaoFromEscolhas(){
        // obtem os parametros
        $casasPreenchidas  = $this->input->get("cP");
        $comprarCombinacao = $this->input->get("cC");
        $setorVida         = $this->input->get("sV");
        
        // valida a combinacao a comprar
        if(!$comprarCombinacao || strlen($comprarCombinacao) < 4){
            return false;
        }
        
        // formata a combinacao
        list($cc, $ama, $ame1, $ame2) = explode("-", $comprarCombinacao);
        
        // monta as casas preenchidas
        if(strlen($casasPreenchidas) > 3){
            $casasPreenchidas .= "|$cc-$ama-$ame1-$ame2";
        }else{
            $casasPreenchidas .= "$cc-$ama-$ame1-$ame2";
        }
        
        // salva as casas preenchidas e o setor da vida na sessao
        @session_start();
        $_SESSION["casas_preenchidas"] = $casasPreenchidas;
        $_SESSION["setor_vida"] = $setorVida;
        
        // redireciona para a tela de compra da combinacao
        redirect(site_url()."/compra/confirmar?ama=$ama&ame1=$ame1&ame2=$ame2");
    }
    
    public function preencherDescricao($codCarta = "", $subTipo = ""){
        // checa se eh admin
        $this->auth->checkAdmin();
        
        $descricao = "";
        
        if(is_numeric($codCarta) && $codCarta > 0){
            $cartaSelecionada = $codCarta;
        }else{
            // obtem o parametro se houver
            $cartaSelecionada = $this->input->get("c");
            $subTipo = $this->input->get("st");
        }
        
        $this->load->model("carta_model", "carta");
        
        // busca as cartas
        $cartas = $this->carta->get(array());
        
        // busca os dados da carta selecionada
        if(is_numeric($cartaSelecionada) && $cartaSelecionada > 0){
            $cartaSelecionada = $this->carta->get(array("cod_carta" => $cartaSelecionada));
            
            // checa se busca a descricao
            if($cartaSelecionada->cod_tipo_carta == 1 || ($cartaSelecionada->cod_tipo_carta == 2 && ($subTipo == 'PASSIVO' || $subTipo == "ATIVO"))){
                $descricao = $this->carta->getDescricao(array(
                    "cod_carta" => $cartaSelecionada->cod_carta,
                    "sub_tipo" => $subTipo
                ));
            }
        }
        
        // chama a view
        $this->load->view("carta_preencher_descricao", array(
            "cartas" => $cartas,
            "cartaSelecionada" => $cartaSelecionada,
            "descricao" => $descricao,
            "subTipo" => $subTipo
        ));
    }
    
    public function doPreencherDescricao(){
        // obtem os parametros
        $codCartaDescricao = $this->input->post("cod-carta-descricao");
        $codCarta = $this->input->post("carta");
        $descricao = $this->input->post("descricao");
        $subTipo = $this->input->post("sub-tipo");
        
        // trata a descricao
        $descricao = str_replace(array("\r","\n","\r\n","\t"), '', $descricao);
        
        // carrega a model
        $this->load->model("carta_model", "carta");
        
        $this->carta->saveDescricao(array(
            "cod_carta_descricao" => $codCartaDescricao,
            "cod_carta" => $codCarta,
            "descricao" => $descricao,
            "sub_tipo" => $subTipo
        ));
        
        return $this->preencherDescricao($codCarta, $subTipo);
    }

}

?>