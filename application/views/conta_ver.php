<div>
    <div class='barra-cinza'>
        <span>Saldo disponível:</span>
        <? if($saldo <= 0): ?>
            <span class='dinheiro zero'>R$ <?=number_format($saldo,2,",",".")?></span>    
        <? else: ?>
            <span class='dinheiro'>R$ <?=number_format($saldo,2,",",".")?></span>
        <? endif; ?>
        <a class="lMargin80 newBlueButton" href="http://www.taromancia.com.br/index.php/aquisicao-de-creditos/" target='_blank'><span>Adquirir créditos</span></a>
    </div>

<? /*
    <p class="sub-title tMargin30">
        <b class="versalete">Habilitação de Créditos</b>
    </p>

    <div class="big-widget">
        <div class="widget">
            <div class="widget-bottom">
                <div class="widget-content">
                    <div class="textwidget extrato">
                        <div class="metade">
                            <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
                            <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post">
                                <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
                                <input type="hidden" name="itemCode" value="3BF76FD4C9C9E4E664238F9B156B66C7" />
                                <input type="image" src="<?= base_url(); ?>/assets/images/Pagamento-em-reais.png" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
                            </form>
                            <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                        </div>
                        <div class="metade">
                            <!-- INICIO DO PAYPAL -->
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                <input type="hidden" name="cmd" value="_s-xclick">
                                <input type="hidden" name="hosted_button_id" value="LRTS27KUVU7RE">
                                <input type="image" src="<?= base_url(); ?>/assets/images/Pagamentos-em-outras-moedas.png" border="0" name="submit" alt="PayPal - A maneira mais fácil e segura de efetuar pagamentos online!">
                                <img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
                            </form>
                            <!-- FIM DO PAYPAL -->
                        </div>
                    </div>
                </div> <!-- end .widget-content-->
            </div> <!-- end .widget-bottom-->
        </div>
    </div>

    *
    */?>

    <p class="sub-title tMargin30">
        <b class="versalete">Extrato de Créditos</b>
    </p>

    <div class="big-widget">
        <div class="widget">
            <div class="widget-bottom">
                <div class="widget-content">
                    <div class="textwidget extrato">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="180" class="item-1">Data</th>
                                    <th class="item-2">Descri&ccedil;&atilde;o</th>
                                    <th class="item-3">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? $count = 0; ?>
                                <? foreach($extrato as $linha): ?>
                                    <? $count++ ?>
                                    <? $class = ($count%2 == 1) ? " class='impar'" : ""  ?>
                                    <tr<?= $class ?>>
                                        <td><?= mysql_to_br($linha->data) ?></td>
                                        <td><?= $linha->descricao ?></td>
                                        <td>R$ <?= moeda($linha->valor)?></td>
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end .widget-content-->
            </div> <!-- end .widget-bottom-->
        </div>
    </div>
    <div>
        <br/><br/>
        <p><b class="versalete">IMPORTANTE!</b></p>
        <p>Leia os <a href="http://www.oracvlvm.com/index.php/about-2/arquitetura-do-site/">Termos de Uso</a> do nosso site.</p>
<!--         <p>Dúvidas, acesse nosso atendimento ao cliente no link: <a href="http://www.oracvlvm.com/index.php/contate-nos/atendimento-ao-cliente/">Atendimento Oracvlvm</a></p> -->
    </div>
</div>