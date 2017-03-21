<?php

namespace edfdans\traycheckout;

/**
  * Classe utilizada para organizar os objetos dos endereços dos clientes
 */
class ClienteEndereco {
    
    /**
     * Tipo do endereço
     * @var TrayCheckoutClienteEnderecoTipo
     */
    private $tipo = TrayCheckoutClienteEnderecoTipo::ENTREGA;
    /**
     * Logradouro do endereço
     * @var string
     */
    private $logradouro = '';
    /**
     * Número do endereço
     * @var string
     */
    private $numero = '';
    /**
     * Complemento do endereço
     * @var string
     */
    private $complemento = '';
    /**
     * Bairro do endereço
     * @var string
     */
    private $bairro = '';
    /**
     * Cidade do endereço
     * @var string
     */
    private $cidade = '';
    /**
     * UF do endereço
     * @var string
     */
    private $uf = '';
    /**
     * CEP do endereço
     * @var string
     */
    private $cep = '';
    
    /**
     * Atribui e retorna o tipo do endereço
     *
     * @param TrayCheckoutClienteEnderecoTipo $valor [opcional]
     * 
     * Opções:
     * TrayCheckoutClienteEnderecoTipo::COBRANCA
     * TrayCheckoutClienteEnderecoTipo::ENTREGA
     * 
     * @return (string)
     */
    public function tipo($valor = null) {
        
        if (!is_null($valor)){
            
            if (in_array($valor, [ TrayCheckoutClienteEnderecoTipo::COBRANCA, TrayCheckoutClienteEnderecoTipo::ENTREGA ])) {
                $this->tipo = $valor;
            } else {
                throw new Exception('Tipo do endereço não permitido!');
            }
        
        } else {
            return $this->tipo;
        }
        
    }
    
    /**
     * Atribui e retorna o logradouro do endereço
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function logradouro($valor = null) {
        
        if (!is_null($valor)) {
            $this->logradouro = $valor;
        } else {
            return $this->logradouro;
        }
        
    }
    
    /**
     * Atribui e retorna o número do endereço
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function numero($valor = null) {
        
        if (!is_null($valor)) {
            $this->numero = $valor;
        } else {
            return $this->numero;
        }
        
    }
    
    /**
     * Atribui e retorna o complemento do endereço
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function complemento($valor = null) {
        
        if (!is_null($valor)) {
            $this->complemento = $valor;
        } else {
            return $this->complemento;
        }
        
    }
    
    /**
     * Atribui e retorna o bairro do endereço
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function bairro($valor = null) {
        
        if (!is_null($valor)) {
            $this->bairro = $valor;
        } else {
            return $this->bairro;
        }
        
    }
    
    /**
     * Atribui e retorna a cidade do endereço
     * 
     * @param string $valor [opcional]
     * @return (string)
     */
    public function cidade($valor = null) {
        
        if (!is_null($valor)) {
            $this->cidade = $valor;
        } else {
            return $this->cidade;
        }
        
    }
    
    /**
     * Atribui e retorna a UF do endereço
     * 
     * @param string $valor [opcional]
     * 
     * Use a sigla com dois caracteres, ex: PR
     * 
     * @return (string)
     */
    public function UF($valor = null) {
        
        if (!is_null($valor)) {
        
            if (strlen($valor) == 2) {

                if (preg_match('/^[A-Z]{2}$/', $valor)) {
                    $this->uf = $valor;
                } else {
                    throw new Exception('UF inválida!');
                }

            } else {
                throw new Exception('UF inválida!');
            }
            
        } else {
            return $this->uf;
        }
        
    }
    
    /**
     * CEP do endereço
     * 
     * @param string $valor [opcional]
     * 
     * Formato 99999-999
     * 
     * @return (string)
     */
    public function cep($valor = null) {
        
        if (!is_null($valor)) {
        
            if (preg_match('/^[0-9]{5}\-[0-9]{3}$/', $valor)) {
                $this->cep = $valor;
            } else {
                throw new Exception('CEP inválido!');
            }
            
        } else {
            return $this->cep;
        }
        
    }
    
}
