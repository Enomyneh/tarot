<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Jogo
 * @property Jogo_model jogo
 * @property Combinacao_model combinacao
 * @property Auth auth
 * @property Template template
 * @property Url_jogo_model url_jogo
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 */
class Jogo extends CI_Controller {

    private $texto = "";
    
    public function escolherSetorVida()
    {
        // obtem a flag profissional
        $profissional = $this->input->get("p");

        if($profissional != 1)
        {
            redirect('jogo/consultaVirtual');
        }

        $dados = $this->getDadosTelaInicial();
        
        // carrega o template
        $this->template->view("automatico_escolher_setor_vida", array(
            "title" => "Auto Consulta",
            "verticalTabs"          => true,
            "jogosConsultaVirtual"  => $dados['jogosConsultaVirtual'],
            "jogosAutoConsulta"     => $dados['jogosAutoConsulta'],
            "setoresVida"           => $dados['setoresVida'],
            "profissional"          => $profissional,
            "codUsuarioCombinacao"  => $dados['codUsuarioCombinacao'],
            "menuLateral"           => false
        ));
    }

    private function getDadosTelaInicial()
    {
        // carrega as models
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("jogo_model", "jogo");

        $codUsuarioCombinacao = $this->input->get("cuc");

        // busca os setores da vida
        $setoresVida = $this->setor_vida->get();

        // busca os jogos do usuario
        $jogos = $this->url_jogo->get(array(
            "cod_usuario" => $this->auth->getData("cod"),
            "limit"       => 20
        ));

        if(is_object($jogos)){
            $jogos = array($jogos);
        }

        // percorre os jogos
        foreach ($jogos as $key => $jogo)
        {
            // instancia o jogo
            $jogoCompleto = new Jogo_model();

            // obtem o jogo completo
            $jogos[$key]->jogoCompleto = $jogoCompleto->getByToken($jogo->token);
        }

        // carrega o helper necessario
        $this->load->helper("date_helper");

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

        return array(
            "jogosConsultaVirtual"  => $jogosConsultaVirtual,
            "jogosAutoConsulta"     => $jogosAutoConsulta,
            "setoresVida"           => $setoresVida,
            "codUsuarioCombinacao"  => $codUsuarioCombinacao,
        );
    }

    public function consultaVirtual()
    {
        // obtem a flag profissional
        $profissional = 0;

        $dados = $this->getDadosTelaInicial();

        // carrega o template
        $this->template->view("jogo_consulta_virtual", array(
            "title" => "Auto Consulta",
            "verticalTabs"          => true,
            "jogosConsultaVirtual"  => $dados['jogosConsultaVirtual'],
            "jogosAutoConsulta"     => $dados['jogosAutoConsulta'],
            "setoresVida"           => $dados['setoresVida'],
            "profissional"          => $profissional,
            "codUsuarioCombinacao"  => $dados['codUsuarioCombinacao'],
            "menuLateral"           => false
        ));
    }

    public function escolherCasaCarta(){
        // carrega as models
        $this->load->model("casa_carta_model", "casa_carta");

        $codUsuarioCombinacao = $this->input->get("cuc");
        $setorVidaCod = $this->input->get("sv");
        
        // busca as casas das cartas
        $casasCarta = $this->casa_carta->get(array("cod_grupo_casa_carta" => 1));

        // carrega o template
        $this->template->view("jogo_escolher_casa_carta", array(
            "title"                 => "Escolher Casa da Carta",
            "casasCarta"            => $casasCarta,
            "codUsuarioCombinacao"  => $codUsuarioCombinacao,
            "setorVidaCod"          => $setorVidaCod,
            "sideBanner1"           => false,
            "sideBanner2"           => false,
            "verticalTabs"          => true
        ));
    }

    public function verSetor(){

        // obtem o setor
        $setorVidaCod = $this->input->get("sv");
        $profissional = $this->input->get("p");
        $codUsuarioCombinacao = $this->input->get("cuc");

        // metodo desativado somente redireciona    
        redirect("/jogo/escolherCartas?sv=".$setorVidaCod ."&p=". $profissional);

        die();
        
        // carrega as models
        $this->load->model("setor_vida_model", "setor_vida");
        
        // busca os setores da vida
        $setorVida = $this->setor_vida->get(array("cod_setor_vida" => $setorVidaCod));
        
        // carrega o template
        $this->template->view("jogo_ver_setor", array(
            "title"     => "Setor da Vida",
            "setorVida" => $setorVida,
            "sideBanner1" => false,
            "sideBanner2" => false,
            "profissional" => $profissional,
            "codUsuarioCombinacao" => $codUsuarioCombinacao,
            "verticalTabs" => true
        ));
    }
    
    public function montar(){

        // define a quantidade de casas
        $qtdeCasas = 3;

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
        
        // escolhe cinco cartas aleatorias dos arcanos maiores
        $aleatorios = array();
        for($i = 1; $i<=$qtdeCasas; $i++){
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
        
        // escolhe 10 arcanos menores
        $aleatorios = array();
        for($i = 1; $i<=$qtdeCasas*2; $i++){
            $aleatorios[] = rand(0, count($arcanosMenores)-$i);
        }
        
        // obtem os arcanos menores ativos
        for($i = 0; $i < $qtdeCasas; $i++){
            $jogoAleatorio[$i]["arcanoMenor1"] = $arcanosMenores[$aleatorios[$i]];
            
            unset($arcanosMenores[$aleatorios[$i]]);
            
            sort($arcanosMenores);
        }
        
        // obtem os arcanos menores passivos
        for($i = $qtdeCasas; $i < $qtdeCasas*2; $i++){
            $jogoAleatorio[$i-$qtdeCasas]["arcanoMenor2"] = $arcanosMenores[$aleatorios[$i]];
            
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
        $profissional = $this->input->get_post("p");

        redirect('jogo/montar/?sv=' . $setorVida);
        die();

        if($profissional == 1){
            redirect(site_url()."/tarot/montarJogo?sv=".$setorVida);
        }

        if(!is_numeric($setorVida) || $setorVida == "" || $setorVida == false){
            die("Erro: Setor de vida invalido");
        }
        
        // carrega a view
        $this->template->view("automatico_escolher_cartas", array(
            "title" => "Escolha as cartas",
            "topBanner" => false,
            "setorVida" => $setorVida,
            'verticalTabs' => true
        ));
    }
        
    public function resultado()
    {
        // obtem os parametros
        $params = func_get_args();

        $token = "";

        // procura o token (md5)
        foreach ($params as $key => $param) {
            if(isMd5($param) == true){
                $token = $param;
            }
        }

        // checa se o jogo veio redirecionado da pagina de compra
        $veioDeCompras = $this->input->get('came_from_compras');

        // valida o token
        if(isMd5($token) == false){
            die("erro: token nao encontrado");
        }

        // atualiza na session
        $this->load->library("session");

        // salva o token do jogo na sessao
        $this->session->set_userdata(array("token_jogo" => $token));

        // carrega as models
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("carta_model", "carta");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("jogo_model", "jogo");
        $this->load->model('carta_casa_setor_valor_model', 'carta_casa_setor_valor');

        // obtem o jogo completo
        $jogoCompleto = $this->jogo->getByToken($token);

        // obtem o setor da vida
        $setorVida = $jogoCompleto->setorVida;
        
        // percorre o jogo e busca o resultado das combinacoes e as descricoes das casas
        foreach ($jogoCompleto->combinacoes as $key => $jogo)
        {
            // marca todas combinacoes como compradas
            $jogoCompleto->combinacoes[$key]["comprado"] = true;

            // busca a combinacao
            $jogoCompleto->combinacoes[$key]["resultado"] = $this->combinacao->get(array(
                "cod_arcano_maior"      => $jogo["arcanoMaior"]->cod_carta,
                "cod_arcano_menor_1"    => $jogo["arcanoMenor1"]->cod_carta,
                "cod_arcano_menor_2"    => $jogo["arcanoMenor2"]->cod_carta,
                "cod_setor_vida"        => $setorVida->cod_setor_vida,
                "cod_casa_carta"        => $jogo["casaCarta"]->cod_casa_carta
            ));
        }

        // checa se esta deslogado
        if($this->auth->check(false) == false)
        {
            // nao logado corta o texto e marca para comprar
            foreach ($jogoCompleto->combinacoes as $key => $jogo)
            {
                // se existe resultado
                if(isset($jogoCompleto->combinacoes[$key]["resultado"]->texto_combinacao)){

                    // se ja veio da tela de compras e o jogo eh gratis, nao corta
                    if($jogoCompleto->custo > 0 OR ($jogoCompleto->custo == 0 AND $veioDeCompras != 1))
                    {
                        // obtem somente o texto cortado
                        $jogoCompleto->combinacoes[$key]["resultado"]->texto_combinacao = $this->cortarTextoGratuito($jogo["resultado"]->texto_combinacao);
                    }
                }

                $jogoCompleto->combinacoes[$key]["comprado"] = false;
            }

        }else{

            // percorre o resultado para acertar as casas que o usuario nao possui e ainda deve comprar
            foreach ($jogoCompleto->combinacoes as $key => $jogo)
            {
                // se nao possui o jogo corta o texto
                if($jogoCompleto->jaComprado == false)
                {
                    // se existe resultado
                    if(isset($jogoCompleto->combinacoes[$key]["resultado"]->texto_combinacao))
                    {
                        // se o jogo eh gratis e ja passou pela tela de compra nao corta o texto
                        if($jogoCompleto->custo > 0 OR $veioDeCompras != 1)
                        {
                            // obtem somente o texto cortado
                            $jogoCompleto->combinacoes[$key]["resultado"]->texto_combinacao = $this->cortarTextoGratuito($jogo["resultado"]->texto_combinacao);
                        }
                    }

                    $jogoCompleto->combinacoes[$key]["comprado"] = false;
                }
            }
        }

        // armazena a url do jogo vinculado ao usuario (caso esteja logado)
        if($this->auth->check(NO_REDIRECT)){

            $this->url_jogo->saveUsuarioUrlJogo(array(
                "cod_usuario"   => $this->auth->getData("cod"),
                "cod_url_jogo"  => $jogoCompleto->url->cod_url_jogo
            ));
        }

        // define se deve mostrar jogo gratuito ou nao
        $mostraJogoGratuito = false;

        if($veioDeCompras == 1 AND $jogoCompleto->custo == 0)
        {
            $mostraJogoGratuito = true;
        }

        // chama a view
        $this->template->view("automatico_ver_resultado", array(
            "title"             => "Resultado do Jogo",
            "casasPreenchidas"  => $jogoCompleto,
            "setorVida"         => $jogoCompleto->setorVida,
            "logado"            => $this->auth->check(NO_REDIRECT),
            "veioDeCompras"     => $veioDeCompras,
            "verticalTabs"      => true,
            "mostraJogoGratuito" => $mostraJogoGratuito
        ));
    }

    public function resultadoCuc(){

        // obtem os parametros
        $casaCartaCod = $this->input->get("cc");
        $setorVidaCod = $this->input->get("sv");
        $usuarioCombinacaoCod = $this->input->get("cuc");

        // carrega as models
        $this->load->model("combinacao_model", "combinacao");
        $this->load->model("carta_model", "carta");
        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");

        // busca o setor da vida
        $setorVida = $this->setor_vida->get(array('cod_setor_vida' => $setorVidaCod));

        // busca a casa
        $casaCarta = $this->casa_carta->get(array("cod_casa_carta" => $casaCartaCod));

        // busca as cartas pela combinacao 
        $cartas = $this->combinacao->getUsuarioCombinacao(array(
            "cod_usuario_combinacao" => $usuarioCombinacaoCod,
            "cod_usuario" => $this->auth->getData("cod")
        ));

        if(count($cartas) <= 0){
            die("Erro: Voce nao possui esta combinacao");
        }

        // ajusta
        $cartas = array_shift($cartas);

        // busca a combinacao
        $resultado = $this->combinacao->get(array(
            "cod_arcano_maior"      => $cartas->cod_arcano_maior,
            "cod_arcano_menor_1"    => $cartas->cod_arcano_menor_1,
            "cod_arcano_menor_2"    => $cartas->cod_arcano_menor_2,
            "cod_setor_vida"        => $setorVidaCod,
            "cod_casa_carta"        => $casaCartaCod
        ));

        // chama a view
        $this->template->view("jogo_ver_resultado_cuc", array(
            "title"             => "Resultado do Jogo",
            "casaCarta"         => $casaCarta,
            "setorVida"         => $setorVida,
            "resultado"         => $resultado,
            "cartas"            => $cartas,
            "codUsuarioCombinacao" => $usuarioCombinacaoCod,
            "verticalTabs"      => true,
            "menuLateral"       => false
        ));
    }

    /* lista todos os jogos que ja foram montados pelos usuarios */
    public function lista(){

    }

    private function cortarTextoGratuito($html){
        // instancia o dom documento
        $doc = new DOMDocument();

        // carrega o html
        @$doc->loadHTML($html);

        // altera o texto para cortar a parte gratuita
        $this->ajustarTexto($doc);

        // zera o contador de texto
        $this->texto = "";

        // retorna o texto ajustado
        return $doc->saveHTML();
    }

    private function ajustarTexto($doc){

        // checa se o node atual eh o ultimo da cadeia
        if($doc->hasChildNodes() == false){

            // se ja passou do limite gratuito corta o texto
            if(strlen($this->texto) > QTDE_CARACTERES_FREE){

                // faz o ascii shift do valor
                $doc->nodeValue = str_rot($doc->nodeValue, rand(1, 13));

                // inclui a classe para borrar o texto
                if(is_object($doc->parentNode) && ($doc->parentNode instanceof DOMDocument == false)){
                    $doc->parentNode->setAttribute("class", "borrar");
                }
            }

            // concatena apenas o texto
            $this->texto .= $doc->nodeValue;

            // retorna
            return true;

        }else{

            // percorre todos os filhos do node atual
            for($i = 0; $i < $doc->childNodes->length; $i++){

                // chama a funcao recursivamente
                $this->ajustarTexto($doc->childNodes->item($i));
            }
        }
    }
}

?>