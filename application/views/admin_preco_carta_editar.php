<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <form action="<?= site_url() ?>/admin/precoCartaDoEditar" method="post">
        <p>
            <b>Carta: </b>
            <span><?= $cartaCasaSetorValor->carta->nome  ?></span>
        </p>
        <p>
            <b>Casa: </b>
            <span><?= $cartaCasaSetorValor->casa->nome  ?></span>
        </p>
        <p>
            <b>Setor: </b>
            <span><?= $cartaCasaSetorValor->setor->nome  ?></span>
        </p>
        <p>
            <b>Valor: </b>
            <span>
                <input type="text" name="valor" class="moeda" value="R$ <?= moeda($cartaCasaSetorValor->valor) ?>" />
            </span>
        </p>
        <input type="submit" class="button" value="SALVAR"/>
        <input type="hidden" name="cod_carta_casa_setor_valor" value="<?= $cartaCasaSetorValor->cod ?>" />
    </form>
    <br/><br/><br/>
    <a href="<?= site_url() ?>/admin/precosCartas">VOLTAR</a>
</div>

<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script>

$('document').ready(function(){

    $('.moeda').maskMoney({
        prefix : 'R$ ',
        thousands : '.',
        decimal : ','
    });

});

</script>

</body>
</html>