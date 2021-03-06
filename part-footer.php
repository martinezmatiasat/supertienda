<!-- FOOTER START -->
<?php include_once('config.php');
require('part-head.php');
$categorias = Categoria::getAllList(); ?>
<div class="footer">
    <div class="footer-inner">
        <div class="footer-top ptb-40">
            <div class="container">
                <div class="row">
                    <div class="footer-static-block">
                        <!-- <span class="opener plus"></span> -->
                        <!--  Site Services Features Block Start  -->
                        <div class="col-sm-4">
                            <div class="ser-feature-block">
                                <div class="feature-box feature1">
                                    <div class="ser-title">Este es un texto de muestra</div>
                                    <div class="ser-subtitle">SEste es un texto de muestra</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ser-feature-block">
                                <div class="feature-box feature2">
                                    <div class="ser-title">Este es un texto de muestra</div>
                                    <div class="ser-subtitle">Este es un texto de muestra</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ser-feature-block">
                                <div class="feature-box feature3">
                                    <div class="ser-title">Este es un texto de muestra</div>
                                    <div class="ser-subtitle">Este es un texto de muestra</div>
                                </div>
                            </div>
                        </div>
                        <!--  Site Services Features Block End  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle mtb-60" >
            <div class="container">
                <div class="row">
                    <div class="col-md-6 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <h3 class="title">Información</h3>
                            <ul class="footer-block-contant link">
                                <li><a>Sobre Masha Wow!</a></li>
                                <li><a>Términos y Condiciones</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <h3 class="title">Datos de Contacto</h3>
                            <ul class="footer-block-contant address-footer">
                                <li><p>Buenos Aires, Argentina.</p></li>
                                <li><p><a>info@mashawow.com.ar</a></p></li>
                                <li><p>11 5500-5500</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="footer-bottom top">
            <div class="container">
                <div class="site-link align-center col-sm-12">
                   <ul>
                      <li>|</li>
                   <?php foreach ($categorias['results'] as $cat) {
                       if ($cat->subcategoria_id=='0') ?> <li><a href="shop.php?cid=<?php echo $cat->categoria_id ?>"><?php echo $cat->nombre ?></a>|</li>
                  <?php } ?>
                  </ul>
                </div>
                <div class="col-sm-12 align-center">
                    <div class="copy-right center-xs">© 2019 Todos los derechos reservados. </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="footer-bottom bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="newsletter">
                            <h3 class="title visible-lg">
                                <span class="newsletter-icon"><img src="images/newsletter-icon.png" alt="Masha Wow!"></span>
                                Recibí las Ofertas Masha Wow!
                            </h3>
                            <div class="email-box-main right-side float-none-sm center-xs">
                                <form>
                                    <div class="email-box">
                                        <input type="text" placeholder="Dejanos tu correo" class="input-text">
                                        <button class="btn btn-color">Go!</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="footer_social pt-xs-15 center-xs mt-xs-15 right-side float-none-sm">
                            <ul class="social-icon">
                                <li><a title="Facebook" class="facebook"><i class="fa fa-facebook"> </i></a></li>
                                <li><a title="Twitter" class="twitter"><i class="fa fa-twitter"> </i></a></li>
                                <li><a title="Instagram" class="linkedin"><i class="fa fa-instagram"> </i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="scroll-top">
    <div id="scrollup"></div>
</div>
<!-- FOOTER END -->
