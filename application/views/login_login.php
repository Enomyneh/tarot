<style type="text/css">
  #container {
    width: 670px;
    height: 60px;
    position: relative;
  }
  #wrapper > #container {
    display: table;
    position: static;
  }
  #container div {
    position: absolute;
    top: 50%;
  }
  #container div div {
    position: relative;
    top: -50%;
  }
  #container > div {
    display: table-cell;
    vertical-align: top;
    position: static;
  }
</style>
<form id="form" action="<?=site_url()?>/login/doSignin" method="POST">

    <div id="wrapper">
      <div id="container">
        <div><div><img width="330" height="350" src="<?=base_url()?>/assets/images/projeto-oracvlvm.jpg"/></div></div>
        <div>
            <div style="padding-left: 25px;">
                <h2>Acesse a mais de 7 milhões de Combinações do Tarot</h2>

                <p><a target="_blank" href="https://www.facebook.com/pages/Oracvlvm/116644901834842?ref=hl">
                    Acompanhe as atualizações em nosso perfil no Facebook: Facebook Oracvlvm
                </a></p>

                <br/>
                <p style="padding-bottom: 0px;">Acesse sua conta com e-mail e senha</p>

                <span><input type="text" name="email" placeholder="E-mail"></span>

                <span><input type="password" name="senha" placeholder="Senha"></span>

                <div class="clearfix tMargin20">
                    <a class="newGreenButton submit"><span>Entrar</span></a>
                    <button type="submit" class="hidden" />
                </div>
                <span class="tMargin20">
                    <br/>
                    <div>Esqueceu sua senha? <a href="<?=site_url()?>/login/forgotPassword">Clique aqui</a></div>
                    <div>N&atilde;o &eacute; cadastrado? <a href="<?=site_url()?>/login/signup">Cadastre-se aqui</a></div>
                </span>
            </div>
        </div>
      </div>
    </div>
</form>
<script>
$(document).ready(function(){
    $("a.submit").click(function(){
        $("form").submit();
    });
});
</script>

