<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es-AR">
    <!--<![endif]-->
    <?php include_once('config.php');
    require('part-head.php');
    $relacionados = Producto::getRandom();
    ?>

    <body>
        <div class="se-pre-con"></div>
        <div class="main">

            <?php require('part-header.php'); ?>

            <!-- BANNER STRAT -->
            <div class="banner inner-banner">
                <div class="container">
                    <div class="bread-crumb mtb-60 center-xs">
                        <div class="page-title">Título de la Oferta</div>
                        <div class="bread-crumb-inner right-side float-none-xs">
                            <ul>
                                <li><a href="index.php">Home</a><i class="fa fa-angle-right"></i></li>
                                <li><span>Título de la Oferta</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BANNER END -->

            <!-- CONTAIN START -->
            <section class="container">
                <div class="pro-page pt-55">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 mb-xs-30">
                            <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                                <a href="#"><img src="images/producto.PNG" alt="Streetwear"></a>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="product-detail-main">
                                        <div class="product-item-details">
                                            <h1 class="product-item-name">Título de la Oferta</h1>
                                            <div class="price-box">
                                                <span class="price">$80.00</span>
                                                <del class="price old-price">$100.00</del>
                                            </div>
                                            <p>
                                                Esta es una descripción de la Oferta Esta es una descripción de la Oferta
                                                Esta es una descripción de la Oferta Esta es una descripción de la Oferta
                                                Esta es una descripción de la Oferta Esta es una descripción de la Oferta
                                            </p>
                                            <div class="mb-40">
                                                <div class="bottom-detail cart-button">
                                                    <ul>
                                                        <li class="pro-cart-icon">
                                                            <form>
                                                                <button title="Add to Cart" class="btn-black">
                                                                    <span></span>Obtener Cupón</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- esto se imprime una vez clickeado en obtener cupon -->
                                            <div class="detail-inner-left">
                                                <ul>
                                                    <h3>
                                                        El cupón es: xxxxxxx <br/>
                                                        y tiene una validez de xx días.
                                                    </h3>
                                                    <p>Enviar cupón por correo:</p>
                                                    <form action="" method="post">
                                                        <div class="alert alert-success"><strong>El Cupón fue enviado a su correo</strong></div>
                                                        <div class="form-group">
                                                            <input type="email" name="emailcupon" class="form-control" required data-required-error="Campo Obligatorio" placeholder="ejemplo@dominio.com">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" name="submit" class="btn-black">Enviar cupón</button>
                                                        </div>
                                                    </form>
                                                </ul>
                                            </div>
                                            <!-- /esto se imprime una vez clickeado en obtener cupon -->

                                            <div class="share-link">
                                                <label>Compatir en : </label>
                                                <div class="social-link">
                                                    <ul class="social-icon">
                                                        <li><a class="facebook" title="Facebook" href="#"><i class="fa fa-facebook"> </i></a></li>
                                                        <li><a class="twitter" title="Twitter" href="#"><i class="fa fa-twitter"> </i></a></li>
                                                        <li><a class="rss" title="RSS" href="#"><i class="fa fa-whatsapp"> </i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container">
                <div class="pb-85">
                    <div class="product-slider owl-slider">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="heading-part align-center mb-40">
                                    <h2 class="main_title">Productos Relacionados</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="product-slider-main position-r">
                                <div class="owl-carousel pro_cat_slider">
                                   <?php foreach ($relacionados['results'] as $rel){
                                      if ($rel->eliminado!=1) {
                                         $vendedor = Vendedor::getById($rel->vendedor_id);
                                         list($url,$size) = returnThumbnailImage($rel->foto,PRODUCTOS_PATH_HTML."crop5/",PRODUCTOS_PATH."crop5/",800,1000,IMAGES_PATH_HTML.'product-default.jpg',IMAGES_PATH.'product-default.jpg');
                                         ?>
                                         <div id="data-step1" class="items-step1 selected product-slider-main position-r" data-temp="tabdata">
                                            <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
                                               <div class="product-item">
                                                 <div class="product-image">
                                                    <div class="sale-label"><span><?php echo $vendedor->nombre; ?></span></div>
                                                    <a href="producto-abierto.php">
                                                       <img src="<?php echo $url ?>" alt="Masha Wow!">
                                                    </a>
                                                    <div class="product-detail-inner">
                                                       <div class="detail-inner-left align-center">
                                                          <ul>
                                                             <li class="pro-cart-icon">
                                                                <form>
                                                                   <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                             </li>
                                                          </ul>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="product-item-details">
                                                    <div class="product-item-name">
                                                       <a href="producto-abierto.php"><?php echo $rel->nombre; ?></a>
                                                    </div>
                                                    <div class="price-box">
                                                       <?php if ($prod->descuento!=0 && $prod->descuento!='') { ?>
                                                          <span class="price"><?php echo '$ ' . ((100-$rel->descuento)*$rel->precio/100); ?></span>
                                                          <del class="price old-price"><?php echo "$ $rel->precio"; ?></del>
                                                       <?php } else { ?>
                                                          <span class="price"><?php echo "$ $rel->precio"; ?></span>
                                                       <?php } ?>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                     <?php }
                                  } ?>
                                  <!--
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-image">
                                                <div class="sale-label"><span>Masha Wow!</span></div>
                                                <a href="producto-abierto.php">
                                                    <img src="images/producto.PNG" alt="Masha Wow!">
                                                </a>
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <form>
                                                                    <button title="Obtener Código"><span></span></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="producto-abierto.php">Masha Wow!</a>
                                                </div>
                                                <div class="price-box">
                                                    <span class="price">$80.00</span>
                                                    <del class="price old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- CONTAINER END -->

            <?php require('part-footer.php'); ?>

        </div>

        <?php require('part-script.php'); ?>

    </body>
</html>
