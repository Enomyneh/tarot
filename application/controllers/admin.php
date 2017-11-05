<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Admin
 *
 * @property Auth auth
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 * @property CI_Input input
 *
 */
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // checa se eh admin
        if($this->auth->checkAdmin(NO_REDIRECT) == false)
        {
            redirect('/jogo/escolherSetorVida');
        }
    }

    public function index(){
        
        redirect('tarot/index');
        
    }
    
    public function precosCartas()
    {
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");

        $cartasCasasSetoresValores = $this->carta_casa_setor_valor->get();

        $precoAlterado = $this->input->get('precoAlterado');

        $this->load->view('admin_precos_cartas', array(
            'cartasCasasSetoresValores' => $cartasCasasSetoresValores,
            'precoAlterado' => $precoAlterado
        ));
    }

    public function precoCartaEditar($codCartaCasaSetorValor)
    {
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");

        $cartaCasaSetorValor = array_shift($this->carta_casa_setor_valor->get(array(
           'codCasaCartaSetorValor' => $codCartaCasaSetorValor
        )));

        $this->load->view('admin_preco_carta_editar', array(
           'cartaCasaSetorValor' => $cartaCasaSetorValor
        ));
    }

    public function precoCartaDoEditar()
    {
        $codCartaCasaSetorValor = $this->input->post('cod_carta_casa_setor_valor');
        $valor = Utils::convertCurrencyToFloat($this->input->post('valor'));

        if($valor == 0)
        {
            die("ERRO VALOR NAO PODE SER ZERO");
        }

        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");

        /** @var Carta_Casa_Setor_Valor_model $cartaCasaSetorValor */
        $cartaCasaSetorValor = array_shift($this->carta_casa_setor_valor->get(array(
            'codCasaCartaSetorValor' => $codCartaCasaSetorValor
        )));

        $this->carta_casa_setor_valor->save(
            $cartaCasaSetorValor->carta,
            $cartaCasaSetorValor->casa,
            $cartaCasaSetorValor->setor,
            $valor
        );

        redirect('admin/precosCartas?precoAlterado=1');
    }
}