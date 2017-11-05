<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Utils {

    public static function convertCurrencyToFloat($currency)
    {
        if(trim($currency) == '')
        {
            return 0;
        }

        $float = str_replace('R$ ', '', $currency);

        $float = str_replace('.', '', $float);

        $float = str_replace(',', '.', $float);

        if(is_numeric($float) AND $float > 0)
        {
            return $float;
        }else{

            return 0;
        }
    }

    public static function getJogoByCartasString($cartasStr)
    {
        // obtem a instancia
        $ci = &get_instance();

        // carrega as models
        $ci->load->model("carta_model", "carta");
        $ci->load->model("casa_carta_model", "casa_carta");

        // transforma em um array das casas
        $casasCarta = explode("|", $cartasStr);

        // desativa a ultima
        unset($casasCarta[count($casasCarta)-1]);

        // busca todas as cartas
        $cartas = $ci->carta->get();

        // monta array com o jogo completo
        $jogoCompleto = array();

        // percorre o jogo para montar as cartas  e buscar as combinacoes
        foreach ($casasCarta as $key => $casa) {
            // salva os dados da casa da carta
            $jogoCompleto[$key]["casaCarta"] = $ci->casa_carta->get(array("cod_casa_carta" => ($key+1)));

            // separa as cartas
            list($arcMaior,$arcMenor1,$arcMenor2) = explode("#", $casa);

            foreach($cartas as $carta){
                // procura o arcano maior
                if($carta->cod_carta == $arcMaior){
                    $jogoCompleto[$key]["arcanoMaior"] = $carta;
                }
                if($carta->cod_carta == $arcMenor1){
                    $jogoCompleto[$key]["arcanoMenor1"] = $carta;
                }
                if($carta->cod_carta == $arcMenor2){
                    $jogoCompleto[$key]["arcanoMenor2"] = $carta;
                }
            }
        }

        // retorna o jogo completo
        return $jogoCompleto;
    }

    public static function montarUrlAmigavel(Jogo_model $jogo)
    {
        // obtem o setor da vida
        $setorVida = $jogo->setorVida;

        // muda o nome do setor da vida amoroso
        if(strtolower($setorVida->nome_setor_vida) == "amoroso"){
            $setorVida->nome_setor_vida = "amor";
        }

        // monta a url amigavel
        $urlAmigavel = "vida/".ajustaStringParaUrl($setorVida->nome_setor_vida)."/tarot/psychic/arcano/";
        $urlAmigavel2 = "vida/".ajustaStringParaUrl($setorVida->nome_setor_vida)."/tarot/psychic/arcano/";

        // monta uma string soh com o codigo das cartas
        $cartas = "";

        // percorre para armazenar as cartas e montar a url amigavel
        foreach($jogo->combinacoes as $key => $jogo)
        {
            $cartas .= $jogo["arcanoMaior"]->cod_carta."#".$jogo["arcanoMenor1"]->cod_carta."#".$jogo["arcanoMenor2"]->cod_carta."|";

            // coloca as cartas somente ate a 3a casa
            if($key < 3){

                $urlAmigavel  .=  ajustaStringParaUrl($jogo["arcanoMaior"]->nome_carta) .  "/"
                    . ajustaStringParaUrl($jogo["arcanoMenor1"]->nome_carta) . "/"
                    . ajustaStringParaUrl($jogo["arcanoMenor2"]->nome_carta) . "/";
            }
        }

        // gera o token
        $token = md5($setorVida->cod_setor_vida.$cartas);

        // armazena o token na url
        //$urlAmigavel2 .= "token/".$token;
        $urlAmigavel .= "token/".$token;

        // monta o objeto de retorno
        $result = new stdClass();

        $result->token = $token;
        $result->cartas = $cartas;
        $result->url = $urlAmigavel;

        return $result;
    }
}
