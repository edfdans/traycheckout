<?php

namespace edfdans\traycheckout;

/**
 * Classe utilizada para organizar os objetos dos contatos dos clientes
 */
class ClienteContato {
    
    /**
     * Tipo do contato
     * @var TrayCheckoutClienteContatoTipo
     */
    private $tipo   = TrayCheckoutClienteContatoTipo::RESIDENCIAL;
    /**
     * Número do contato
     * @var string
     */
    private $numero = '';

    /**
     * Atribui e retorna o tipo do contato
     *
     * @param TrayCheckoutClienteContatoTipo $valor [opcional]
     * 
     * Opções:
     * TrayCheckoutClienteContatoTipo::RESIDENCIAL
     * TrayCheckoutClienteContatoTipo::COMERCIAL
     * TrayCheckoutClienteContatoTipo::CELULAR
     * 
     * @return (TrayCheckoutClienteContatoTipo)
     */
    public function tipo($valor = null) {
        
        if (!is_null($valor)) {
            
            if (in_array($valor, [ TrayCheckoutClienteContatoTipo::RESIDENCIAL, TrayCheckoutClienteContatoTipo::COMERCIAL, TrayCheckoutClienteContatoTipo::CELULAR ])) {
                $this->tipo = $valor;
            } else {
                throw new Exception('Tipo do contato não permitido!');
            }
            
        } else {
            return $this->tipo;
        }
        
    }
    
    /**
     * Atribui e retorna o número do contato
     * 
     * @param string $valor [opcional]
     * 
     * Formato (99) 99999999X
     * 
     * @return (string)
     */
    public function numero($valor = null) {
        
        if (!is_null($valor)) {
        
            if (preg_match('/^([0-9]{10,11})|(\([0-9]{2}\)\ [0-9]{8,9})$/', $valor)) {
                $this->numero = $valor;
            } else {
                throw new Exception('Número do contato inválido!');
            }
            
        } else {
            return $this->numero;
        }
        
    }
    
}
