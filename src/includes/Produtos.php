<?php

namespace edfdans\traycheckout;

/**
  * Classe utilizada para organizar os objetos dos produtos
 */
class Produtos {
    
    /**
     * Código do produto
     * @var string
     */
    private $codigo = '';
    /**
     * Nome do produto
     * @var string
     */
    private $nome = '';
    /**
     * Quantidade do produto
     * @var numeric
     */
    private $quantidade = 1;
    /**
     * Valor unitário do produto
     * @var numeric
     */
    private $valorUnitario = 0;
    /**
     * Observação do produto
     * @var string
     */
    private $observacao = '';
    
    /**
     * Atribui e retorna o código do produto
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function codigo($valor = null) {
        
        if (!is_null($valor)) {
            $this->codigo = $valor;
        } else {
            return $this->codigo;
        }
        
    }
    
    /**
     * Atribui e retorna o nome do produto
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
     * Atribui e retorna a quantidade do produto
     * 
     * @param numeric $valor [opcional]
     * @return (numeric)
     */
    public function quantidade($valor = null) {

        if (!is_null($valor)) {
            $this->quantidade = $valor;
        } else {
            return $this->quantidade;
        }
        
    }
    
    /**
     * Atribui e retorna o valor unitário do produto
     * 
     * @param numeric $valor [opcional]
     * @return (numeric)
     */
    public function valorUnitario($valor = null) {
        
        if (!is_null($valor)) {
            $this->valorUnitario = $valor;
        } else {
            return $this->valorUnitario;
        }
        
    }
    
    /**
     * Atribui e retorna a observação do produto
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
    
}