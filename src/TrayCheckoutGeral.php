<?php

namespace edfdans\traycheckout;

/**
 * Classe utilizada para gerenciar as configurações do pagamento
 */
class TrayCheckoutGeral {
    
    /**
     * Ambiente do sistema de pagamento
     * @var TrayCheckoutAmbiente
     */
    private $ambiente = TrayCheckoutAmbiente::HOMOLOGACAO;
    /**
     * Token para pagamento
     * @var string
     */
    private $token = '';
    /**
     * Transação do pagamento
     * @var string
     */
    private $transacao  = '';
    /**
     * Quantidade de parcelas para pagamento
     * @var int
     */
    private $parcelas = 1;
    /**
     * Número do pedido
     * @var string
     */
    private $pedido = '';
    /**
     * Observação do pedido
     * @var string
     */
    private $observacao = '';
    /**
     * Forma de pagamento
     * @var TrayCheckoutClienteFormaPagamento
     */
    private $pagamento;
    
    /**
     * Atribui e retorna o ambiente do sistema de pagamento
     * 
     * @param TrayCheckoutAmbiente $valor [opcional]
     * @return (TrayCheckoutAmbiente)
     */
    public function ambiente($valor = null) {
        
        if (!is_null($valor)) {
            
            if (in_array($valor, [ TrayCheckoutAmbiente::HOMOLOGACAO, TrayCheckoutAmbiente::PRODUCAO ])) {
                $this->ambiente = $valor;
            } else {
                throw new Exception('Ambiente informado desconhecido');
            }
            
        } else {
            return $this->ambiente;
        }
        
    }
    
    /**
     * Atribui e retorna a observação do pagamento
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function observacao($valor = null) {
        
        if (!is_null($valor)) {
            $this->observacao = $valor;
        } else {
            return $this->observacao;
        }
        
    }
    
    /**
     * Atribui e retorna a forma de pagamento
     * 
     * @param TrayCheckoutClienteFormaPagamento $valor [opcional]
     * @return (TrayCheckoutClienteFormaPagamento)
     */
    public function pagamento($valor = null) {
        
        if (!is_null($valor)) {
            
            if (in_array($valor, [ TrayCheckoutClienteFormaPagamento::BOLETO ])) {
                $this->pagamento = $valor;
            } else {
                throw new Exception('Tipo de pagamento não permitido!');
            }
            
        } else {
            return $this->pagamento;
        }
        
    }
    
    /**
     * Atribui e retorna as parcelas
     * 
     * @param int $valor [opcional]
     * @return (int)
     */
    public function parcelas($valor = null) {
        
        if (!is_null($valor)) {
            $this->parcelas = $valor;
        } else {
            return $this->parcelas;
        }
        
    }
    
    /**
     * Atribui e retorna o número do pedido
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function pedido($valor = null) {
        
        if (!is_null($valor)) {
            $this->pedido = $valor;
        } else {
            return $this->pedido;
        }
        
    }
    
    /**
     * Atribui e retorna o token para pagamento
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function token($valor = null) {
        
        if (!is_null($valor)) {
            $this->token = $valor;
        } else {
            return $this->token;
        }
        
    }
    
    /**
     * Atribui e retorna a transação do pagamento
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function transacao($valor = null) {
        
        if (!is_null($valor)) {
            $this->transacao = $valor;
        } else {
            return $this->transacao;
        }
        
    }
    
}
