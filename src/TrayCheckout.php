<?php

namespace edfdans\traycheckout;

/**
 * Classe de pagamento para o traycheckout
 * 
 * Essa classe foi desenvolvida para agilizar o envio e consulta de pagamentos do
 * provedor do serviço de pagamento traycheckout.
 * Esse pacote é independente da empresa prestadora do serviço.
 *
 * Para iniciar utilize o exemplo teste.php
 * 
 * @package    edfdans
 * @subpackage traycheckout
 * @author     Emerson Diego Feltrin <emersondiegofeltrin@gmail.com>
 * @version    1.0.1
 */
class TrayCheckout {
    
    /**
     * Cliente
     * @var TrayCheckoutCliente
     */
    private $cliente;
    /**
     * Geral
     * @var TrayCheckoutGeral
     */
    private $geral;
    /**
     * Produtos
     * @var TrayCheckoutProdutos
     */
    private $produtos;
    /**
     * Retorno da transação
     * @var TrayCheckoutRetorno
     */
    private $retorno;
    
    /**
     * Gera os dados que serão enviados via post para a consulta da transação
     * @return (array)
     */
    private function consultaGerarDados() {
        
        $dados = [];
        
        $dados['token_account']     = $this->geral()->token();
        $dados['token_transaction'] = $this->geral()->transacao();
        
        return $dados;
        
    }
    
    /**
     * Retorna a URL que será usado na consulta da transação conforme o ambiente definido
     * @return (string)
     */
    private function consultaURL() {
        
        if ($this->geral()->ambiente() == TrayCheckoutAmbiente::HOMOLOGACAO) {
            return 'https://api.sandbox.traycheckout.com.br/v2/transactions/get_by_token';
        } else {
            return 'https://api.traycheckout.com.br/v2/transactions/get_by_token';
        }
        
    }
    
    /**
     * Gera os dados que serão enviados via post para o envio do pagamento
     * @return (array)
     */
    private function pagamentoGerarDados() {
        
        $dados = [];
        
        $dados['token_account']  = $this->geral()->token();
        $dados['customer[name]'] = $this->cliente()->nome();
        $dados['customer[cpf]']  = $this->cliente()->cpf();
        
        $dados['customer[email]']        = $this->cliente()->email();
        $dados['customer[trade_name]']   = $this->cliente()->nomeFantasia();
        $dados['customer[company_name]'] = $this->cliente()->razaoSocial();
        $dados['customer[cnpj]']         = $this->cliente()->cnpj();
        
        for ($i = 0; $i < $this->cliente()->contatos()->getTotalLista(); $i++) {
            
            $dados['customer[contacts][' . $i . '][type_contact]']   = $this->cliente()->contatos()->getIndexLista($i)->tipo();
            $dados['customer[contacts][' . $i . '][number_contact]'] = $this->cliente()->contatos()->getIndexLista($i)->numero();
            
        }
        
        for ($i = 0; $i < $this->cliente()->enderecos()->getTotalLista(); $i++) {
            
            $dados['customer[addresses][' . $i . '][type_address]']  = $this->cliente()->enderecos()->getIndexLista($i)->tipo();
            $dados['customer[addresses][' . $i . '][postal_code]']   = $this->cliente()->enderecos()->getIndexLista($i)->cep();
            $dados['customer[addresses][' . $i . '][street]']        = $this->cliente()->enderecos()->getIndexLista($i)->logradouro();
            $dados['customer[addresses][' . $i . '][number]']        = $this->cliente()->enderecos()->getIndexLista($i)->numero();
            $dados['customer[addresses][' . $i . '][neighborhood]']  = $this->cliente()->enderecos()->getIndexLista($i)->bairro();
            $dados['customer[addresses][' . $i . '][completion]']    = $this->cliente()->enderecos()->getIndexLista($i)->complemento();
            $dados['customer[addresses][' . $i . '][city]']          = $this->cliente()->enderecos()->getIndexLista($i)->cidade();
            $dados['customer[addresses][' . $i . '][state]']         = $this->cliente()->enderecos()->getIndexLista($i)->UF();
            
        }
        
        for ($i = 0; $i < $this->produtos()->getTotalLista(); $i++) {
            
            $dados['transaction_product[' . $i . '][code]']        = $this->produtos()->getIndexLista($i)->codigo();
            $dados['transaction_product[' . $i . '][description]'] = $this->produtos()->getIndexLista($i)->nome();
            $dados['transaction_product[' . $i . '][quantity]']    = $this->produtos()->getIndexLista($i)->quantidade();
            $dados['transaction_product[' . $i . '][price_unit]']  = $this->produtos()->getIndexLista($i)->valorUnitario();
            $dados['transaction_product[' . $i . '][extra]']       = $this->produtos()->getIndexLista($i)->observacao();
            
        }
        
        $dados['order_number'] = $this->geral()->pedido();
        $dados['free']         = $this->geral()->observacao();
        $dados['payment[payment_method_id]'] = $this->geral()->pagamento();
        $dados['payment[split]']             = $this->geral()->parcelas();
        
        return $dados;
    }
    
    /**
     * Retorna a URL que será usado no envio do pagamento conforme o ambiente definido
     * @return (string)
     */
    private function pagamentoURL() {
        
        if ($this->geral()->ambiente() == TrayCheckoutAmbiente::HOMOLOGACAO) {
            return 'https://api.sandbox.traycheckout.com.br/v2/transactions/pay_complete';
        } else {
            return 'https://api.traycheckout.com.br/v2/transactions/pay_complete';
        }
        
    }
    
    /**
     * Inicia a classe com ambiente de homologação, pagamento em boleto e uma parcela
     */
    public function __construct() {
        $this->geral    = new TrayCheckoutGeral();
        $this->cliente  = new TrayCheckoutCliente();
        $this->produtos = new TrayCheckoutProdutos();

        $this->geral()->ambiente(TrayCheckoutAmbiente::HOMOLOGACAO);
        $this->geral()->pagamento(TrayCheckoutClienteFormaPagamento::BOLETO);
        $this->geral()->parcelas(1);
    }
    
    /**
     * Busca o boleto a partir da URL da transação
     * 
     * @param string $url URL informada no retorno da transação
     * @param string $arquivo [opcional] informar para salvar o pdf em algum local
     * @return (string)
     */
    public function buscarBoleto($url, $destino = null) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $pdf = curl_exec($ch);
        
        curl_close($ch);
        
        if (!is_null($destino)) {
            file_put_contents($destino, $pdf);
        }
        
        return $pdf;
                
    }
    
    /**
     * Acessar os dados do cliente
     * @return (TrayCheckoutCliente)
     */
    public function cliente() {
        
        if (is_a($this->cliente, 'edfdans\traycheckout\TrayCheckoutCliente')) {
            return $this->cliente;
        } else {
            return new TrayCheckoutCliente();
        }
        
    }
    
    /**
     * Consulta o pagamento a partir do token da transação
     * @return (boolean) Use $objeto->retorno() para acessar o retorno da consulta
     */
    public function consultarPagamento() {
        
        $url   = $this->consultaURL();
        $dados = $this->consultaGerarDados();

        $this->retorno = new TrayCheckoutRetorno();
        
        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $xml  = curl_exec($ch);
            $erro = curl_error($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            
            if ($code == '200') {

                $resposta = simplexml_load_string($xml);

                if ($resposta->message_response->message == 'success') {
        
                    $this->retorno()->status((string)$resposta->data_response->transaction->status_id);
                    $this->retorno()->transacao((string)$resposta->data_response->transaction->transaction_id);
                    $this->retorno()->token((string)$resposta->data_response->transaction->token_transaction);
                    $this->retorno()->url((string)$resposta->data_response->transaction->payment->url_payment);

                } else {

                    if (isset($resposta->error_response->errors)){

                        foreach ($resposta->error_response->errors->error as $erro) {
                            $this->retorno()->erros((string)$erro->code . ' - ' . (string)$erro->message);
                        }

                    }

                }
                
            } else {
                $this->retorno()->erros($erro);
            }
            
        } catch (Exception $e) {
            $this->retorno()->erros($e->getMessage());
        }
        
        return empty($this->retorno()->erros());
        
    }
    
    /**
     * Envia o pagamento para o provedor do serviço de pagamento
     * @return (boolean) Use $objeto->retorno() para acessar o retorno da transação
     */
    public function enviarPagamento() {
        
        $url   = $this->pagamentoURL();
        $dados = $this->pagamentoGerarDados();

        $this->retorno = new TrayCheckoutRetorno();
        
        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $xml  = curl_exec($ch);
            $erro = curl_error($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            
            if ($code == '200') {

                $resposta = simplexml_load_string($xml);
                
                if ($resposta->message_response->message == 'success') {
                    
                    $this->retorno()->status((string)$resposta->data_response->transaction->status_id);
                    $this->retorno()->transacao((string)$resposta->data_response->transaction->transaction_id);
                    $this->retorno()->token((string)$resposta->data_response->transaction->token_transaction);
                    $this->retorno()->url((string)$resposta->data_response->transaction->payment->url_payment);

                } else {

                    if (isset($resposta->error_response->general_errors)){

                        foreach ($resposta->error_response->general_errors->general_error as $erro) {
                            $this->retorno()->erros((string)$erro->code . ' - ' . (string)$erro->message);
                        }

                    }

                    if (isset($resposta->error_response->validation_errors)){

                        foreach ($resposta->error_response->validation_errors->validation_error as $erro) {
                            $this->retorno()->erros((string)$erro->message_complete);
                        }

                    }

                }
                
            } else {
                $this->retorno()->erros($erro);
            }
            
        } catch (Exception $e) {
            $this->retorno()->erros($e->getMessage());
        }
        
        return empty($this->retorno()->erros());
    }
    
    /**
     * Acessar os dados gerais
     * @return (TrayCheckoutGeral)
     */
    public function geral() {
        
        if (is_a($this->geral, 'edfdans\traycheckout\TrayCheckoutGeral')) {
            return $this->geral;
        } else {
            return new TrayCheckoutGeral();
        }
        
    }
    
    /**
     * Acessar os dados dos produtos
     * @return (TrayCheckoutProdutos)
     */
    public function produtos() {
        
        if (is_a($this->produtos, 'edfdans\traycheckout\TrayCheckoutProdutos')) {
            return $this->produtos;
        } else {
            return new TrayCheckoutProdutos();
        }
        
    }
    
    /**
     * Acessar os dados do retorna da transação
     * @return (TrayCheckoutRetorno)
     */
    public function retorno() {
        
        if (is_a($this->retorno, 'edfdans\traycheckout\TrayCheckoutRetorno')) {
            return $this->retorno;
        } else {
            return new TrayCheckoutRetorno();
        }
        
    }
    
}
