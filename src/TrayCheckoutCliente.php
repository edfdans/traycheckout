<?php

namespace edfdans\traycheckout;

/**
 * Classe utilizada para gerenciar os clientes
 */
class TrayCheckoutCliente {
    
    /**
     * Nome do cliente
     * @var string
     */
    private $nome = '';
    /**
     * CPF do cliente
     * @var string
     */
    private $cpf = '';
    /**
     * Email do cliente
     * @var string
     */
    private $email = '';
    /**
     * Nome fantasia do cliente
     * @var string
     */
    private $nomeFantasia = '';
    /**
     * Razão social do cliente
     * @var string
     */
    private $razaoSocial = '';
    /**
     * CNPJ do cliente
     * @var string
     */
    private $cnpj = '';
    /**
     * Contatos do cliente
     * @var TrayCheckoutClienteContato
     */
    private $contatos;
    /**
     * Contatos do cliente
     * @var TrayCheckoutClienteEndereco
     */
    private $enderecos;
    
    /**
     * Inicia a classe com o contato e endereço
     */
    public function __construct() {
        $this->contatos  = new TrayCheckoutClienteContato();
        $this->enderecos = new TrayCheckoutClienteEndereco();
    }
    
    /**
     * Acessar os contatos do cliente
     * @return (TrayCheckoutClienteContato)
     */
    public function contatos() {
        
        if (is_a($this->contatos, 'edfdans\traycheckout\TrayCheckoutClienteContato')) {
            return $this->contatos;
        } else {
            return new TrayCheckoutClienteContato();
        }
        
    }
    
    /**
     * Acessar os endereços do cliente
     * @return (TrayCheckoutClienteEndereco)
     */
    public function enderecos() {
        
        if (is_a($this->enderecos, 'edfdans\traycheckout\TrayCheckoutClienteEndereco')) {
            return $this->enderecos;
        } else {
            return new TrayCheckoutClienteEndereco();
        }
        
    }
    
    /**
     * Atribui e retorna o nome do cliente
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function nome($valor = null) {
        
        if (!is_null($valor)) {
            $this->nome = $valor;
        } else {
            return $this->nome;
        }
        
    }
    
    /**
     * Atribui e retorna o CPF do cliente
     * 
     * @param string $valor [opcional]
     * 
     * Formato 999.999.999-99
     * 
     * @return (string)
     */
    public function cpf($valor = null) {
        
        if (!is_null($valor)) {
            
            if (preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $valor)) {
                $this->cpf = $valor;
            } else {
                throw new Exception('CPF no formato inválido!');
            }
            
        } else {
            return $this->cpf;
        }
        
    }
    
    /**
     * Atribui e retorna o e-mail do cliente
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function email($valor = null) {
        
        if (!is_null($valor)) {
            $this->email = $valor;
        } else {
            return $this->email;
        }
        
    }
    
    /**
     * Atribui e retorna o nome fantasia do cliente
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function nomeFantasia($valor = null) {
        
        if (!is_null($valor)) {
            $this->nomeFantasia = $valor;
        } else {
            return $this->nomeFantasia;
        }
        
    }
    
    /**
     * Atribui e retorna a razão social do cliente
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function razaoSocial($valor = null) {
        
        if (!is_null($valor)) {
            $this->razaoSocial = $valor;
        } else {
            return $this->razaoSocial;
        }
        
    }
    
    /**
     * Atribui e retorna o CNPJ do cliente
     * 
     * @param string $valor [opcional]
     * 
     * Formato 00.000.000/0000-00
     * 
     * @return (string)
     */
    public function cnpj($valor = null) {
        
        if (!is_null($valor)) {
            
            if (preg_match('/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/', $valor)) {
                $this->cnpj = $valor;
            } else {
                throw new Exception('CNPJ no formato inválido!');
            }
            
        } else {
            return $this->cnpj;
        }
        
    }
    
}
