<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <? if(strlen($keywords) > 3): ?>
    	<meta name="keywords" content="<?= $keywords ?>">
	<? endif; ?>
    <title>Taromancia</title>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Corben:400,700|Arvo:400,700|Raleway' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/style-new.css?ac=2ss'; ?>" />
</head>
<body ondragstart="return false;" onselectstart="return false;"  oncontextmenu="return false;" oncopy="return false" oncut="return false" onpaste="return false">

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=514495095291423&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<!-- codigo do analytics -->
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-37025613-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<!-- fim do codigo do analytics -->

	<script async="true" data-cfasync="false" type="text/javascript" src="http://carnage1301.spider.ad?id=33302"></script>

	<div id="linha-azul">
		<a href="http://www.taromancia.com.br/index.php/loja/">Todos os Serviços</a>
		<a href="http://www.taromancia.com.br/index.php/aquisicao-de-creditos/">Aquisição de Créditos</a>
		<a href="http://www.taromancia.com.br/index.php/cursos-de-taromancia-2/">Cursos de Taromancia</a>
		<a href="http://www.taromancia.com.br/index.php/project/consultoria-oracular/">Consultoria Oracular</a>
		<a href="http://www.taromancia.com.br/index.php/minha-conta/">Minha conta</a>
	</div>
	<div>
		<? if ($incorporado == false): ?>
		<div id="page-bg">
		<div id="page-bottom">
	            <div id="page-top">
	                <div id="main-area">
	                    <div class="container">
				<div id="menu-bar">
	                <div id="menu-content" class="clearfix">
		                <div class="logo-container">
			                <a class="logo" href="http://www.taromancia.com.br">
				                <img src="<?=base_url()?>assets/images/taromancia2.jpg" alt="Oracvlvm" id="logo"/>
			                </a>
		                </div>
		                <div class="header-menu">
			                <ul id="top-menu" class="nav">
			                	<li>
									<span>
										<a href="http://www.taromancia.com.br/index.php/o-codigo-da-sabedoria-oracular/">Página Inicial</a>
									</span>
				                </li>
				                <li>
									<span>
										<a href="http://www.taromancia.com.br/index.php/o-codigo-da-sabedoria-oracular/">O Código da Sabedoria oracular</a>
									</span>
				                </li>
				                <li>
									<span>
										<a href="http://www.taromancia.com.br/index.php/atividades-recentes/">Atividades Recentes</a>
									</span>
				                </li>
				                <li>
									<span>
										<a href="http://www.taromancia.com.br/index.php/atendimento-ao-cliente/">Atendimento ao Cliente</a>
									</span>
				                </li>
			                </ul> <!-- end ul#nav -->
		                </div>
					</div> <!-- end #menu-content-->
				</div> <!-- end #menu-bar-->


				<div class="right-bar"></div>
<!--				<div id="category-name">-->
<!--					<h1 class="category-title">--><?//=$title?><!--</h1>-->
                    <!--<p class="meta-info">
                        Postado  por <a href="http://www.oracvlvm.com/index.php/author/admin/" title="Posts de admin" rel="author">admin</a> em dez 13, 2012 em <a href="http://www.oracvlvm.com/index.php/category/featured/" title="Ver todos os posts em Featured" rel="category tag">Featured</a> | <span>Coment�rios desativados</span>
                    </p>-->
<!--	            </div> <!-- end #category-name -->
	                    </div> 	<!-- end .container -->
	                </div> <!-- end #main-area -->
	            </div> <!-- end #page-top -->
	        </div> <!-- end #page-bottom -->
	    </div> <!-- end #page-bg -->
		<? endif; ?>

		<div class="horiz-line"></div>
		
	    <div id="content-area">
		<!--
	        <div id="breadcrumbs">
	            <div class="container clearfix">
	                <div id="breadcrumbs-shadow"></div>
			<span id="breadcrumbs-text">
	                    <a href="http://www.oracvlvm.com">Inicio</a> <span class="raquo">&raquo;</span>
	                    <a href="http://www.oracvlvm.com/index.php/category/featured/">Featured</a>
	                    <span class="raquo">&raquo;</span> Amostra Gratuita de Consulta
	                </span>
			<div id="search-form">
	                    <form method="get" id="searchform" action="http://www.oracvlvm.com/">
	                        <input type="text" placeholder="Pesquisar neste site..." name="s" id="searchinput" />
	                        <input type="submit" id="searchbutton" value="Pesquisar" />
	                    </form>
			</div> <!-- end #search-form --><!--
	            </div> 	<!-- end .container --><!--
	        </div> <!-- end #breadcrumbs -->
	        <div class="container">
	            <div id="content" class="clearfix">	
	            <? $style = ($menuLateral == FALSE AND $incorporado == FALSE) ? "style='width: 1080px;'" : "" ?>
			<div id="left-area" <?= $style ?>>

				<? $style = ($menuLateral == FALSE) ? "style='padding-right: 0px;'" : "" ?>
	            <div class="entry post clearfix" <?= $style?>>
				
				<? if($topBanner == true): ?>
					<div style="margin-bottom: 20px; text-align: center;">
						<iframe id="top-banner" src="<?=base_url()?>assets/estatico/banner-horizontal_top.html" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" width="970" height="90"></iframe>
					</div>
				<? endif; ?>

				<? if($menuHorizontal): ?>
				<div id="horizontal-bar">
					<!-- <h4 class="widgettitle">Espa&ccedil;o Oracular</h4> -->
                    <div class="widget iblock">
                        <div class="widget-bottom">
                            <div class="widget-content">
                                <div class="textwidget">
                                	<p class="caixa-widget">
	                                    <a href="<?=site_url("/login/saveCadastro")?>">Minha Conta</a> <a href="<?=site_url()?>/login/signin">(Sair)</a><br/>
	                                    <a href="<?=site_url("/conta/ver")?>">Aquisição de Créditos</a><br/>
	                                    <a href="<?=site_url("/monografia/resumo")?>">Arquivos Virtuais</a><br/>
	                                    <a href="<?=site_url("jogo/escolherSetorVida?p=1")?>">Auto consulta</a><br/>
	                                    <a href="<?=site_url("jogo/consultaVirtual")?>">Consulta Virtual</a><br/>
	                                    <a href="<?=site_url("/combinacao/resumo")?>">Combinações de Cartas</a><br/>
	                                    <!-- <a href="<?=site_url("/mapa/ver")?>">Meus Mapeamentos</a><br/> -->
                                	</p>
                                </div>
                            </div> <!-- end .widget-content-->
                        </div> <!-- end .widget-bottom-->
                    </div> <!-- end .widget-->

                    <div class="iblock">
                    	<a href="http://www.oracvlvm.com/index.php/oraculos-gratis/">
                			<img width="210" height="196" src="http://www.oracvlvm.com/wp-content/uploads/2014/10/consulte-o-oraculo.png"/>	
                		</a>
                    </div>

                    <div class="iblock">
                		<a href="http://www.oracvlvm.com/index.php/cursos/">
                			<img width="210" src="http://www.oracvlvm.com/wp-content/uploads/2014/09/Escoladetaromancia.png"/>	
                		</a>
                    </div>

                    <div class="iblock">
                		<a href="http://www.oracvlvm.com/index.php/taromancia/">
                			<img width="210" src="http://www.oracvlvm.com/wp-content/uploads/2014/09/Mercadodecartas.png"/>
                		</a>
                    </div>
                </div> <!-- end #horizontal-bar -->
            	<? endif; ?>

	            <? if(isset($verticalTabs) and $verticalTabs == true): ?>
		            <? $class = $this->router->fetch_class() ?>
		            <? $method = $this->router->fetch_method() ?>
		            <? $query = $this->input->get(); ?>
		            <div class="top-menu">
			            <? $ativo = ($class == 'login' AND $method == 'saveCadastro') ? ' ativo' : '' ?>
			            <span class="<?= $ativo ?>">
				            <a href="<?=site_url("/login/saveCadastro")?>">Minha Conta</a>
			            </span>
			            <? $ativo = ($class == 'conta' AND $method == 'ver') ? ' ativo' : '' ?>
			            <span class="<?= $ativo ?>">
				            <a href="<?=site_url("/conta/ver")?>">Aquisi&ccedil;&atilde;o de Cr&eacute;ditos</a>
			            </span>
			            <? $ativo = ($class == 'monografia' AND $method == 'resumo') ? ' ativo' : '' ?>
			            <span class="<?= $ativo ?>">
				            <a href="<?= site_url('/monografia/resumo') ?>">Arquivos Virtuais</a>
			            </span>
			            <? $ativo = ($class == 'jogo' AND $method == 'escolherSetorVida' AND isset($query['p']) == true) ? ' ativo' : '' ?>
			            <? if($ativo == ''): ?>
			            	<? $ativo = ($class == 'jogo' AND $method == 'verSetor' AND $query['p'] == '1') ? ' ativo' : '' ?>
			        	<? endif; ?>
			        	<? if($ativo == ''): ?>
			            	<? $ativo = ($class == 'tarot' AND $method == 'montarJogo') ? ' ativo' : '' ?>
			        	<? endif; ?>
			            <span class="<?= $ativo; ?>">
				            <a href="<?=site_url("/jogo/escolherSetorVida?p=1")?>">Auto Consulta</a>
			            </span>
			            <? $ativo = ($class == 'jogo' AND $method == 'consultaVirtual') ? ' ativo' : '' ?>
			            <? if($ativo == ''): ?>
			            	<? $ativo = ($class == 'jogo' AND $method == 'verSetor' AND $query['p'] == '') ? ' ativo' : '' ?>
			        	<? endif; ?>
			        	<? if($ativo == ''): ?>
			            	<? $ativo = ($class == 'jogo' AND $method == 'escolherCartas' AND $query['p'] == '') ? ' ativo' : '' ?>
			        	<? endif; ?>
			            <span class="<?= $ativo ?>">
				            <a href="<?=site_url("/jogo/consultaVirtual")?>">Consulta Virtual</a>
			            </span>
			            <? $ativo = ($class == 'combinacao' AND $method == 'resumo') ? ' ativo' : '' ?>
			            <span class="<?= $ativo ?>">
				            <a href="<?=site_url("/combinacao/resumo")?>">Combina&ccedil;&otilde;es de Cartas</a>
			            </span>
		            </div>
		            <div class="content">
		            	<div style="margin: 10px 0;">
							<iframe id="horizontal-banner-blocos" src="<?=base_url()?>assets/estatico/banner-horizontal-bloco-links.html" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" width="730" height="20"></iframe>
						</div>
			            <?=$view?>
		            </div>
	            <? else: ?>
		            <?=$view?>
	            <? endif; ?>
				

				<? if($bottomBanner == true): ?>
					<div style="margin-top: 20px;">
						<iframe id="bottom-banner" src="<?=base_url()?>assets/estatico/banner-horizontal.html" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" width="695" height="20"></iframe>
					</div>
				<? endif; ?>
				
			    </div> <!-- end .entry -->
	        </div> 	<!-- end #left-area -->

	        <? //if($menuLateral): ?>
	        <? if(false): ?>
				<div id="sidebar">

						<? if($this->auth->check(NO_REDIRECT) == false): ?>
							<div class="widget">
		                        <div class="widget-bottom">
		                            <div class="widget-content" style="padding: 0 5px">
		                                <div class="textwidget">
		                                	<p class="caixa-widget" style="padding-top: 1px; padding-bottom: 5px;">
		                                		<a href="http://www.oracvlvm.com/index.php/atividade-oracular/">
		                                			<img src="http://www.oracvlvm.com/wp-content/uploads/2014/09/Usuario.png"/>
		                                		</a>
		                                	</p>
		                                </div>
		                            </div> <!-- end .widget-content-->
		                        </div> <!-- end .widget-bottom-->
		                    </div> <!-- end .widget-->
						<? endif; ?>

						<? if($this->auth->check(NO_REDIRECT) == true): ?>
							<!-- <h4 class="widgettitle">Espa&ccedil;o Oracular</h4> -->
		                    <div class="widget">
		                        <div class="widget-bottom">
		                            <div class="widget-content">
		                                <div class="textwidget">
		                                	<p class="caixa-widget">
			                                    <a href="<?=site_url("/login/saveCadastro")?>">Minha Conta</a> <a href="<?=site_url()?>/login/signin">(Sair)</a><br/>
			                                    <a href="<?=site_url("/conta/ver")?>">Aquisição de Créditos</a><br/>
			                                    <a href="http://www.oracvlvm.com/index.php/cursos/">Iniciação à Taromancia</a><br/>
			                                    <a href="<?=site_url("jogo/escolherSetorVida?p=1")?>">Auto consulta</a><br/>
			                                    <a href="<?=site_url("jogo/consultaVirtual")?>">Consulta Virtual</a><br/>
			                                    <a href="<?=site_url("/combinacao/resumo")?>">Combinações de Cartas</a><br/>
			                                    <!-- <a href="<?=site_url("/mapa/ver")?>">Meus Mapeamentos</a><br/> -->
		                                	</p>
		                                </div>
		                            </div> <!-- end .widget-content-->
		                        </div> <!-- end .widget-bottom-->
		                    </div> <!-- end .widget-->
						<? endif; ?>

	                    <? if($sideBanner1): ?>
	                    	<!-- <h4 class="widgettitle">Anunciantes</h4> -->
		                    <div class="widget">
		                        <div class="widget-bottom">
		                            <div class="widget-content tCenter" style="height: 205px">
		                            	<iframe id="banner-medio-1" src="<?=base_url()?>assets/estatico/banner-medio-1.html" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" width="240" height="205"></iframe>
		                            </div>
		                        </div>
		                    </div>
	                    <? endif; ?>

	                    <div class="widget">
	                        <div class="widget-bottom">
	                            <div class="widget-content" style="padding: 0 11px">
	                                <div class="textwidget">
	                                	<p class="caixa-widget" style="padding-top: 1px; padding-bottom: 5px;">
	                                		<div class="fb-like-box" data-href="http://www.facebook.com/pages/Oracvlvm/116644901834842" data-width="235" data-height="540" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
	                                	</p>
	                                </div>
	                            </div> <!-- end .widget-content-->
	                        </div> <!-- end .widget-bottom-->
	                    </div> <!-- end .widget-->
					
						<!-- 
						<h4 class="widgettitle">Compre o seu baralho</h4>
	                    <div class="widget">
	                        <div class="widget-bottom">
	                            <div class="widget-content">
	                                <div class="textwidget" style="text-align: center;">
										<a href="http://www.oracvlvm.com/index.php/compre-o-seu-baralho/">
											<img src="http://www.oracvlvm.com/wp-content/uploads/2013/05/compre.jpg"/>
										</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    -->
	                </div> <!-- end #sidebar -->

	            <? endif; ?>

	            </div> <!-- end #content -->
	            <div id="bottom-shadow"></div>
	        </div> <!-- end .container -->	
	    </div> <!-- end #content-area -->
		<div style="margin-top: 20px; text-align: center;">
			<iframe id="bottom-big-banner" src="<?=base_url()?>assets/estatico/banner-horizontal_top.html" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" width="970" height="90"></iframe>
		</div>
	    <? if($incorporado == false): ?>
	    	<div class="footer-bg">
	    		<div id="footer">
			        <div class="one-quarter">
			        	<div id="nav_menu-3" class="fwidget et_pb_widget widget_nav_menu">
				        	<h4 class="title">Taromancia</h4>
				        	<div class="menu-administracao-taromancia-container">
				        		<ul id="menu-administracao-taromancia" class="menu">
				        			<li id="menu-item-71" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-71">
				        				<a href="http://www.taromancia.com.br/novo/index.php/acesso-administrativo/">Acesso Administrativo e Membros</a>
				        			</li>
									<li id="menu-item-213" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-213"><a href="http://www.taromancia.com.br/index.php/perfil-taromancia/">Perfil Taromancia</a></li>
									<li id="menu-item-88" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-88"><a href="http://www.taromancia.com.br/index.php/nossa-trajetoria/">Nossa Trajetória</a></li>
									<li id="menu-item-191" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-191"><a href="http://www.taromancia.com.br/index.php/termos-e-condicoes-de-uso/">Termos e condições de Uso</a></li>
									<li id="menu-item-1447" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1447"><a href="http://www.taromancia.com.br/index.php/fazendo-parcerias/">Fazendo Parcerias</a></li>
								</ul>
							</div>
						</div>
			        </div>
			        <div class="one-quarter">
			        	<h4 class="title">Facebook</h4>
			        	<div id="fb-root"></div>
						<script>(function(d, s, id) {
						 var js, fjs = d.getElementsByTagName(s)[0];
						 if (d.getElementById(id)) return;
						 js = d.createElement(s); js.id = id;
						 js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=514495095291423&version=v2.0";
						 fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like-box" data-href="http://www.facebook.com/pages/Oracvlvm/116644901834842" data-width="235" data-height="540" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
			        </div>
			        <div class="one-quarter"></div>
			        <div class="one-quarter"></div>
				</div> 	<!-- end .container -->	
			    </div> <!-- end #footer -->
	    	</div>
		<? endif; ?>
	</div>

	<script>
		$("document").ready(function(){
			
			$(document).keyup(function(evt){
				if(evt.keyCode == 44){
					alert("Aviso: Material protegido por direitos autorais. Leia mais em: http://www.oracvlvm.com/index.php/about-2/arquitetura-do-site/");
				}
			});

			$("span.submenu").hover(
				function(){
					$(this).children("div").fadeIn();
				},
				function(){
					$(this).children("div").fadeOut();
				}
			);
		});
	</script>
 <script type="text/javascript">

 // Add a script element as a child of the body
 function downloadJSAndCssAtOnload() {

 	// monta um array de CSSs
 	css = [];
 	// css.push("<?= base_url() . 'assets/css/style-full.css'; ?>");
 	// css.push("<?=base_url()?>assets/css/style-Brown.css");
 	css.push("<?= base_url() . 'assets/css/smoothness/jquery-ui-1.10.0.custom.min.css'; ?>");

 	for(var i = 0; i < css.length; i++){
 		var element = document.createElement("link");
	 	element.rel = "stylesheet";
	 	element.type = "text/css";
	 	element.href = css[i];

	 	// carrega o css
 		document.head.appendChild(element);
 	}

 	// cria um array de js a ser carregado
 	var js = [];

 	// inclue os sources dos js quer serao incluidos
 	//js.push("<?=base_url()?>assets/js/jquery-1.9.1.min.js");
 	//js.push("<?=base_url()?>assets/js/jquery-ui-1.10.0.custom.min.js");
 	//js.push("http://ads58699.hotwords.com/show.jsp?id=58699&cor=2717ee");

 	// percorre
 	for(var i = 0; i < js.length; i++){
 		var element = document.createElement("script");
	 	element.src = js[i];
	 	document.body.appendChild(element);
 	}


 }
 // Check for browser support of event handling capability
 if (window.addEventListener){
 	window.addEventListener("load", downloadJSAndCssAtOnload, false);
 } else if(window.attachEvent){
 	window.attachEvent("onload", downloadJSAndCssAtOnload);
 } else {
 	window.onload = downloadJSAndCssAtOnload;
 }
</script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript">
	var SITE_URL = '<?=site_url()?>';
</script>
</body>
</html>