<?php

namespace edfdans\traycheckout;

/**
 * Classe utilizada para organizar os ambientes do sistema de pagamento
 */
class TrayCheckoutAmbiente {
    
    /**
     * Ambiente de homologação do sistema de pagamento
     * @var integer
     */
    const HOMOLOGACAO = 0;
    /**
     * Ambiente de produção do sistema de pagamento
     * @var integer
     */
    const PRODUCAO    = 1;
}