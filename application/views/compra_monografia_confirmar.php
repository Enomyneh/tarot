<h2>Monografia</h2>
<div>
    <h2>
        <span>T&iacute;tulo: </span>
        <span><?=$monografia->nome_carta?></span>
    </h2>
</div>
<h2>Confirmar compra</h2>
<div>
    <p>Tem certeza que deseja confirmar a compra da monografia acima?</p>
    <p>Sim, debitar R$ <?=moeda($monografia->preco_monografia)?> do meu saldo de R$ <?=moeda($this->auth->getData("saldo"));?></p>
    <a class="newGreenButton tMargin20" href="<?=site_url()?>/compra/doMonografiaConfirmar?m=<?=$monografia->cod_monografia?>"><span>Comprar</span></a>
</div>