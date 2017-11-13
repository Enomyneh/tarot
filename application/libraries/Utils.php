<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once "pagseguro-php-sdk-master/vendor/autoload.php";

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

    public static function createPagSeguroTransactionCode(Jogo_model $jogo, Pedido_model $pedido)
    {
        $ci = get_instance();

        $usuario = Auth::getFullData();

        // valida o custo
        if($jogo->custo == 0)
        {
            die('ERRO: JOGO SEM CUSTO PARA COBRANCA');
        }

        // inicia o pagseguro
        self::initPagSeguro();

        $payment = new \PagSeguro\Domains\Requests\Payment();

        $payment->addItems()->withParameters(
            '0001', // ITEM ID
            'Jogo de Tarot - Taromancia', // ITEM DESCRIPTION
            1, // ITEM QUANTITY
            number_format($jogo->custo, 2, '.', '') // ITEM AMOUNT
        );

        //Add items by parameter
//        $payment->addParameter()->withParameters('itemId', '0003')->index(3);
//        $payment->addParameter()->withParameters('itemDescription', 'Notebook Rosa')->index(3);
//        $payment->addParameter()->withParameters('itemQuantity', '1')->index(3);
//        $payment->addParameter()->withParameters('itemAmount', '201.40')->index(3);

        $payment->setCurrency("BRL");
        $payment->setReference($pedido->codFormatadoPedidoReferencia);

//        $payment->setRedirectUrl("http://www.lojamodelo.com.br");

        // Set your customer information.
        $payment->setSender()->setName($usuario['nome']);
        $payment->setSender()->setEmail($usuario['email']);
        $payment->setSender()->setPhone()->withParameters(
            $usuario['ddd'],
            $usuario['telefone']
        );
//        $payment->setSender()->setDocument()->withParameters(
//            'CPF',
//            '31072545845'
//        );

//        $payment->setShipping()->setAddress()->withParameters(
//            'Av. Brig. Faria Lima',
//            '1384',
//            'Jardim Paulistano',
//            '01452002',
//            'São Paulo',
//            'SP',
//            'BRA',
//            'apto. 114'
//        );
//        $payment->setShipping()->setCost()->withParameters(20.00);
//        $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::SEDEX);

        $payment->setShipping()->setAddressRequired()->withParameters('FALSE');

//Add items by parameter using an array
//        $payment->addParameter()->withArray(['notificationURL', 'http://www.lojamodelo.com.br/nofitication']);


//        $payment->setRedirectUrl("http://www.lojamodelo.com.br");
//        $payment->setNotificationUrl("http://www.lojamodelo.com.br/nofitication");

        try {
            $onlyCheckoutCode = true;
            $result = $payment->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $onlyCheckoutCode
            );

            $checkoutCode = $result->getCode();

        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }

        // salva o checkout cod
        $pedido->pagSeguroCheckoutCode = $checkoutCode;
        $pedido->update();

        return array(
            'success' => true,
            'code' => $checkoutCode
        );
    }

    public static function consultaTransacaoPagSeguro(Pedido_model $pedido)
    {
        if($pedido->pagSeguroTransactionCode == '' OR is_null($pedido->pagSeguroTransactionCode))
        {
            return false;
        }
        if($pedido->status == STATUS_PAGO)
        {
            return false;
        }

        // inicia o pagseguro
        self::initPagSeguro();

        try {
            $response = \PagSeguro\Services\Transactions\Search\Code::search(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $pedido->pagSeguroTransactionCode
            );

        } catch (Exception $e) {
            return null;
        }

        return $response;
    }

    public static function initPagSeguro()
    {
        // define o email e a senha
        $email = (ENVIROMENT_PAGSEGURO == 'production') ? PAGSEGURO_EMAIL_PRODUCAO : PAGSEGURO_EMAIL_SANDBOX;
        $token = (ENVIROMENT_PAGSEGURO == 'production') ? PAGSEGURO_TOKEN_PRODUCAO : PAGSEGURO_TOKEN_SANDBOX;

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName(NOME_SISTEMA)->setRelease(VERSAO_SISTEMA);
        \PagSeguro\Library::moduleVersion()->setName(NOME_SISTEMA)->setRelease(VERSAO_SISTEMA);

        //For example, to configure the library dynamically:
        \PagSeguro\Configuration\Configure::setEnvironment(ENVIROMENT_PAGSEGURO);//production or sandbox
        \PagSeguro\Configuration\Configure::setAccountCredentials(
            $email,
            $token
        );
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
        \PagSeguro\Configuration\Configure::setLog(true, getcwd() . '/application/cache/logPagseguro.log');
    }
}