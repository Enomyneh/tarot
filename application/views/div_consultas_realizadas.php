<? if(count($jogosConsultaVirtual) > 0): ?>
    <br/>
    <br/>
    <div>
        <h2 class="versalete">Consultas Realizadas</h2>
    </div>
    <div class="big-widget">
        <div class="widget">
            <div class="widget-bottom">
                <div class="widget-content">
                    <div class="textwidget">
                        <? foreach($jogosConsultaVirtual as $jogo): ?>
                            <? $this->load->view('div_jogos', array('jogo' => $jogo)) ?>
                        <? endforeach; ?>
                    </div>
                </div> <!-- end .widget-content-->
            </div> <!-- end .widget-bottom-->
        </div>
    </div>
<? endif; ?>
<? if(count($jogosAutoConsulta) > 0): ?>
    <div>
        <h2>Auto Consulta</h2>
    </div>
    <div class="big-widget">
        <div class="widget">
            <div class="widget-bottom">
                <div class="widget-content">
                    <div class="textwidget">
                        <? foreach($jogosAutoConsulta as $jogo): ?>
                            <? $this->load->view('div_jogos', array('jogo' => $jogo)) ?>
                        <? endforeach; ?>
                    </div>
                </div> <!-- end .widget-content-->
            </div> <!-- end .widget-bottom-->
        </div>
    </div>
<? endif; ?>