<?php

/**
 * Class Pedido_model
 *
 * @property CI_DB_active_record db
 */
class Pedido_model extends CI_Model {

    public $cod;
    public $codFormatadoPedidoReferencia;
    public $status;
    public $data;
    public $tokenJogo;
    public $pagSeguroTransactionCode;
    public $pagSeguroCheckoutCode;
    public $statusAmigavel;
    public $codUsuario;
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();
        
    }
    
    public function insert($data = array()){
        
        // faz o insert
        $this->db->insert("pedido", $data);

        return $this->db->insert_id();
    }

    public function getOld($options = array()){

        if(isset($options["cod_usuario"])){
            $this->db->where("u.cod", $options["cod_usuario"]);
        }

        $this->db->select("p.cod as cod_pedido")
                 ->select("p.data as data_pedido")
                 ->select("p.status as status_pedido")
                 ->select("p.cod_usuario")
                 ->select("m.cod as cod_mapeamento")
                 ->select("mt.tipo as mapeamento_tipo")
                 ->select("u.nome as nome_usuario")
                 ->select("u.email as email_usuario")
                 ->select("u.orientacao_sexual as orientacao_sexual_usuario")
                 ->select("u.data_nascimento as data_nascimento_usuario")
                 ->select("s.nome_setor_vida")
                 ->select("ss.sub_setor")
                 ->from("pedido p")
                 ->join("pedido_mapeamento pm", "pm.cod_pedido = p.cod", "left")
                 ->join("mapeamento m", "m.cod = pm.cod_mapeamento", "left")
                 ->join("mapeamento_tipo mt", "mt.cod = m.cod_mapeamento_tipo", "left")
                 ->join("usuario u", "u.cod = p.cod_usuario", "left")
                 ->join("setor_vida s", "s.cod_setor_vida = m.cod_setor_vida", "left")
                 ->join("sub_setor_vida ss", "ss.cod = m.cod_sub_setor_vida", "left")
                 ->where("p.ativo", 1)
                 ->order_by("p.cod");

        return $this->db->get()->result();

    }

    public function desativar($codPedido){

        $this->db->where("cod", $codPedido);
        $this->db->update("pedido", array("ativo" => 0));

        return true;
    }
    
    public function changeStatus($status, $codPedido){

        $this->db->where("cod", $codPedido);
        $this->db->update("pedido", array("status" => $status));

        return true;
    }

    /**
     * @param Jogo_model $jogo
     * Cada jogo tem um token e só pode gerar um pedido
     */
    public function create(Jogo_model $jogo)
    {
        $this->auth->check();

        $codPedido = null;

        // checa se o pedido ja existe
        $result = $this->db->select('cod_pedido_novo')
                ->from('pedido_novo')
                ->where('token_jogo', $jogo->url->token)
                ->get();

        if($result->num_rows() > 0)
        {
            $row = $result->row();

            $codPedido = $row->cod_pedido_novo;

        }else{

            $data = date('Y-m-d H:i:s');

            $this->db->insert('pedido_novo', array(
                'data' => $data,
                'status' => STATUS_AGUARDANDO_PAGAMENTO,
                'token_jogo' => $jogo->url->token,
                'cod_usuario' => $this->auth->getData('cod')
            ));

            $codPedido = $this->db->insert_id();
        }

        $pedido = array_shift($this->get(array('cod_pedido' => $codPedido)));

        return $pedido;
    }

    public function get(array $options)
    {
        if(isset($options['cod_pedido']))
        {
            $this->db->where('cod_pedido_novo', $options['cod_pedido']);
        }
        if(isset($options['token']))
        {
            $this->db->where('token_jogo', $options['token']);
        }

        $this->db->select('cod_pedido_novo')
            ->select('status')
            ->select('data')
            ->select('token_jogo')
            ->select('pagseguro_transaction_code')
            ->select('pagseguro_checkout_code')
            ->select('cod_usuario')
            ->from('pedido_novo');

        $result = $this->db->get();

        $pedidos = array();

        foreach($result->result() as $row)
        {
            $pedido = new Pedido_model();

            $pedido->cod = $row->cod_pedido_novo;
            $pedido->status = $row->status;
            $pedido->statusAmigavel = _helper_pedido_status_amigavel($pedido->status);
            $pedido->data = $row->data;
            $pedido->pagSeguroTransactionCode = $row->pagseguro_transaction_code;
            $pedido->pagSeguroCheckoutCode = $row->pagseguro_checkout_code;
            $pedido->tokenJogo = $row->token_jogo;
            $pedido->codFormatadoPedidoReferencia = PEDIDOS_PREFIXO_REFERENCIA . str_pad($pedido->cod, PEDIDOS_PADDING_LENGTH, '0', STR_PAD_LEFT);
            $pedido->codUsuario = $row->cod_usuario;

            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    public function update()
    {
        $this->db->update('pedido_novo',
            array(
                'data' => $this->data,
                'status' => $this->status,
                'token_jogo' => $this->tokenJogo,
                'pagseguro_transaction_code' => $this->pagSeguroTransactionCode,
                'pagseguro_checkout_code' => $this->pagSeguroCheckoutCode,
                'cod_usuario' => $this->codUsuario
            ),
            array('cod_pedido_novo' => $this->cod));

        return true;
    }

    public function atualizaStatus()
    {
        if($this->pagSeguroTransactionCode == '' OR is_null($this->pagSeguroTransactionCode) == true){
            return false;
        }

        if($this->status == STATUS_PAGO)
        {
            // se ja esta pago nao precisa mexer no status
            return false;
        }

        // busca os dados da transacao
        /** @var \PagSeguro\Parsers\Transaction\Search\Code\Response $transacaoPagSeguro */
        $transacaoPagSeguro = Utils::consultaTransacaoPagSeguro($this);

        // valida se ja foi pago no Pagseguro
        if($transacaoPagSeguro->getStatus() == PAGSEGURO_ID_STATUS_PAGO)
        {
            $this->status = STATUS_PAGO;
            $this->update();

        }else{

            // se ainda nao consta como pago atualiza com status aguardando pagseguro
            if($this->status != STATUS_AGUARDANDO_PAGSEGURO)
            {
                $this->status = STATUS_AGUARDANDO_PAGSEGURO;
                $this->update();
            }
        }

        return true;
    }
}


