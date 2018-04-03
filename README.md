# Traycheckout
[![MIT license](https://img.shields.io/dub/l/vibe-d.svg)](http://opensource.org/licenses/MIT)

Esse pacote irá permitir o envio e consulta de pagamentos da Traycheckout.

### ATENÇÃO! ESSE PACOTE FOI DESCONTINUADO
### UTILIZE O PACOTE DA YAPAY [yapay](https://github.com/emersondiegofeltrin/yapay)

### SOMENTE GERAÇÃO DE BOLETO

### CONSULTAR PAGAMENTO
```shell

$tc = new TrayCheckout();
$tc->geral()->ambiente(TrayCheckoutAmbiente::HOMOLOGACAO);
$tc->geral()->token(''); 
$tc->geral()->transacao('');

if ($tc->consultarPagamento()){
    print_r($tc->retorno());
    $tc->buscarBoleto($tc->retorno()->url(), 'teste.pdf');
}else{
    print_r($tc->retorno()->erros());
}

```

### ENVIAR PAGAMENTO
```shell

$tc = new TrayCheckout();
$tc->geral()->ambiente(TrayCheckoutAmbiente::HOMOLOGACAO);
$tc->geral()->token(''); 

$tc->geral()->desconto(0);
$tc->geral()->acrescimo(0);
$tc->geral()->dataVencimento(date('d/m/Y'));
$tc->geral()->observacao('Observação da fatura');

$tc->cliente()->nome('Cliente de teste');
$tc->cliente()->cpf('000.000.000-00');
$tc->cliente()->email('email@empresa.com.br');
$tc->cliente()->nomeFantasia('Empresa');
$tc->cliente()->razaoSocial('Empresa Ltda');
$tc->cliente()->cnpj('00.000.000/0000-00');

$tc->cliente()->contatos()->adicionar(TrayCheckoutClienteContatoTipo::COMERCIAL, '(00) 00000000');
$tc->cliente()->enderecos()->adicionar(TrayCheckoutClienteEnderecoTipo::COBRANCA, 'Rua XV de Novembro', '100', '', 'Centro', 'Cidade', 'UF', '99999-999');

$tc->produtos()->adicionar('1', 'Produto 1', 10, 1, 'Observação do produto');

if ($tc->enviarPagamento()){
    print_r($tc->retorno());
}else{
    print_r($tc->retorno()->erros());
}

```

