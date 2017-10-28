<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jogo extends CI_Controller {
    
    public function escolherSetorVida(){
        // carrega as models
        $this->load->model("setor_vida_model", "setor_vida");
        
        // busca os setores da vida
        $setoresVida = $this->setor_vida->get();
        
        // carrega o template
        $this->template->view("automatico_escolher_setor_vida", array(
            "title" => "Jogue Tarot",
            "setoresVida" => $setoresVida
        ));
    }
    
    public function montar(){
        // carrega a session
        $this->load->library('session');

        // obtem os parametros
        $setorVidaCod = $this->input->get("sv");

        if(!is_numeric($setorVidaCod) || $setorVidaCod == "" || $setorVidaCod == false){
            die("Erro: Setor de vida invalido");
        }
        
        // carrega as models
        $this->load->model("setor_vida_model",  "setor_vida");
        $this->load->model("carta_model",       "carta");
        $this->load->model("combinacao_model",  "combinacao");
        $this->load->model("casa_carta_model",  "casa_carta");
        $this->load->model("url_jogo_model",    "url_jogo");

        // busca os setores da vida
        $setorVida = $this->setor_vida->get(array("cod_setor_vida" => $setorVidaCod));
        
        // busca todas as cartas
        $cartas = $this->carta->get(array());
        
        $arcanosMaiores = array(); $arcanosMenores = array();
        $jogoAleatorio = array();
        
        // separa os tipos de carta
        foreach($cartas as $carta){
            if($carta->cod_tipo_carta == 1){
                $arcanosMaiores[] = $carta;
            }else{
                $arcanosMenores[] = $carta;
            }
        }
        
        // escolhe dez cartas aleatorias dos arcanos maiores
        $aleatorios = array();
        for($i = 1; $i<=10; $i++){
            $aleatorios[] = rand(0, count($arcanosMaiores)-$i);
        }
        
        // percorre as escolhas aleatorias para subtrair do vetor
        foreach($aleatorios as $k => $aleatorio){
            // armazena no vetor final
            $jogoAleatorio[] = array(
                "casa"          => $k+1,
                "arcanoMaior"   => $arcanosMaiores[$aleatorio]
            );
            
            unset($arcanosMaiores[$aleatorio]);
            
            sort($arcanosMaiores);
        }
        
        $aleatorios = array();
        for($i = 1; $i<=20; $i++){
            $aleatorios[] = rand(0, count($arcanosMenores)-$i);
        }
        
        // obtem os arcanos menores ativos
        for($i = 0; $i < 10; $i++){
            $jogoAleatorio[$i]["arcanoMenor1"] = $arcanosMenores[$aleatorios[$i]];
            
            unset($arcanosMenores[$aleatorios[$i]]);
            
            sort($arcanosMenores);
        }
        
        // obtem os arcanos menores passivos
        for($i = 10; $i < 20; $i++){
            $jogoAleatorio[$i-10]["arcanoMenor2"] = $arcanosMenores[$aleatorios[$i]];
            
            unset($arcanosMenores[$aleatorios[$i]]);
            
            sort($arcanosMenores);
        }

        // monta a url amigavel
        $url = montarUrlAmigavel($setorVida, $jogoAleatorio);
        
        // salva o token do jogo na sessao
        $this->session->set_userdata(array("token_jogo" => $url->token));

        // salva a url deste jogo
        $this->url_jogo->save(array(
            "cod_setor_vida"    => $setorVidaCod,
            "cartas"            => $url->cartas,
            "token"             => $url->token
        ));

        redirect("jogo/resultado/".$url->url);
    }
    
    public function escolherCartas(){
        
        // obtem o setor da vida
        $setorVida = $this->input->get_post("sv");

        if(!is_numeric($setorVida) || $setorVida == "" || $setorVida == false){
            die("Erro: Setor de vida invalido");
        }
        
        // carrega a view
        $this->template->view("automatico_escolher_cartas", array(
            "title" => "Escolha as cartas",
            "topBanner" => false,
            "setorVida" => $setorVida
        ));
    }
        
    public function resultado(){

        // obtem os parametros
        $params = func_get_args();

        $token = "";

        // procura o token (md5)
        foreach ($params as $key => $param) {
            if(isMd5($param) == true){
                $token = $param;
            }
        }

        // valida o token
        if(isMd5($token) == false){
            die("erro: token nao encontrado");
        }

        // carrega as models
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("carta_model", "carta");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");

        // busca o jogo
        $jogo = $this->url_jogo->get(array("token" => $token));

        // armazena o setor da vida
        $setorVidaCod = $jogo->cod_setor_vida;

        // busca o setor da vida
        $setorVida = $this->setor_vida->get(array('cod_setor_vida' => $setorVidaCod));

        // obtem as cartas do jogo
        $cartasStr = $jogo->cartas;

        // obtem o jogo completo
        $jogoCompleto = getJogoByCartasString($cartasStr);
        
        // percorre o jogo e busca o resultado das combinacoes e as descricoes das casas
        foreach ($jogoCompleto as $key => $jogo) {
            // marca todas combinacoes como compradas
            $jogoCompleto[$key]["comprado"] = true;

            // busca a combinacao
            $jogoCompleto[$key]["resultado"] = $this->combinacao->get(array(
                "cod_arcano_maior"      => $jogo["arcanoMaior"]->cod_carta,
                "cod_arcano_menor_1"    => $jogo["arcanoMenor1"]->cod_carta,
                "cod_arcano_menor_2"    => $jogo["arcanoMenor2"]->cod_carta,
                "cod_setor_vida"        => $setorVidaCod,
                "cod_casa_carta"        => $jogo["casaCarta"]->cod_casa_carta
            ));
        }

        // monta o array com as strings pra substituir
        $replaceStr = array("<p style=\"text-align: justify;\">", "<p>", "</p>");

        // checa se esta logado
        if($this->auth->check(false) == false){
            // nao logado corta o texto e marca para comprar
            foreach ($jogoCompleto as $key => $jogo) {
                // se existe resultado
                if(isset($jogoCompleto[$key]["resultado"]->texto_combinacao)){
                    // troca os p's por espaços
                    $texto = str_replace($replaceStr, " ", $jogo["resultado"]->texto_combinacao);

                    // obtem somente o texto cortado
                    $jogoCompleto[$key]["resultado"]->texto_combinacao = substr(strip_tags($texto), 0, QTDE_CARACTERES_FREE);
                }

                $jogoCompleto[$key]["comprado"] = false;
            }
        }else{
            // busca as combinacoes do usuario
            $combinacoes = $this->combinacao->getUsuarioCombinacao(array(
                "cod_usuario" => $this->auth->getData("cod")
            ));

            // percorre o resultado para acertar as casas que o usuario nao possui e ainda deve comprar
            foreach ($jogoCompleto as $key => $jogo) {
                // declara a variavel
                $possuiCombinacao = false;

                // percorre as combinacoes para ver se possui
                foreach ($combinacoes as $combinacao) {
                    if( $jogo["arcanoMaior"]->cod_carta == $combinacao->cod_arcano_maior &&
                        $jogo["arcanoMenor1"]->cod_carta == $combinacao->cod_arcano_menor_1 &&
                        $jogo["arcanoMenor2"]->cod_carta == $combinacao->cod_arcano_menor_2){

                        // seta combinacao como comprada
                        $possuiCombinacao = true;

                        break;
                    }
                }

                // se nao possui combinacao corta o texto
                if($possuiCombinacao == false){
                    // se existe resultado
                    if(isset($jogoCompleto[$key]["resultado"]->texto_combinacao)){
                        // troca os p's por espaços
                        $texto = str_replace($replaceStr, " ", $jogo["resultado"]->texto_combinacao);

                        // obtem somente o texto cortado
                        $jogoCompleto[$key]["resultado"]->texto_combinacao = substr(strip_tags($texto), 0, QTDE_CARACTERES_FREE);
                    }

                    $jogoCompleto[$key]["comprado"] = false;
                }
            }
        }

        // chama a view
        $this->template->view("automatico_ver_resultado", array(
            "title"             => "Resultado do Jogo",
            "casasPreenchidas"  => $jogoCompleto,
            "setorVida"         => $setorVida,
            "logado"            => $this->auth->check(false)
        ));
    }
}

?>