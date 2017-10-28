<h2><?= $monografia[0]->nome_carta ?></h2>
<h2>Descrição</h2>
<div>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vehicula eleifend purus a mattis. Curabitur sit amet dui varius augue iaculis ullamcorper. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas pretium metus id justo faucibus tristique. Cras quis purus sed diam tristique placerat. Proin ac magna ac nunc volutpat gravida eget sed est. Quisque adipiscing mauris nec augue pretium vestibulum. Integer molestie cursus massa, ut eleifend justo aliquam eget. Maecenas purus nisi, consequat vel convallis a, commodo a urna. Proin et sem est. Integer ultricies dui id nunc gravida dapibus. Aenean mi odio, laoreet quis bibendum ut, aliquet a metus. Morbi dapibus eros eu ligula fringilla ut blandit ante ultrices. Nulla pharetra nibh nec lorem ultrices tristique.</p>
</div>
<h2 class="tMargin20">Valor</h2>
<div>
    <span class="valor">R$ <?=moeda($monografia[0]->preco_monografia)?></span>
</div>
<a class="newGreenButton tMargin20" href="<?=site_url()?>/compra/monografiaConfirmar?m=<?=$monografia[0]->cod_monografia?>"><span>Comprar</span></a>