<?php
include_once 'config.php';

$producto = Producto::getById(getVar('pid'));
if (!$producto || $producto->eliminado){
    header('Location: index.php');
    exit();
}

if (isset($_GET["comprar"])) {
    $com = new Compra(array('producto_id' => $producto->producto_id, 'vendedor_id'=>$producto->vendedor_id, 'codigo'=>strtoupper(generateRandomString(6)), 'estado'=> 0));
    $com->session_id = session_id();
    $com->fecha_expiracion = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")." + ".$producto->duracion." days"));
    $com->insert();
}

require('part-head.php');

$relacionados = Producto::getRelacionados($producto);
$imagenes = ProductoImagen::getAllList($producto->producto_id);
?>
<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es-AR">
<!--<![endif]-->
<body>
   <div class="se-pre-con"></div>
   <div class="main">

      <?php require('part-header.php'); ?>

      <!-- BANNER STRAT -->
      <div class="banner inner-banner">
         <div class="container">
            <div class="bread-crumb mtb-60 center-xs">
               <div class="page-title"><?php echo $producto->nombre ?></div>
               <div class="bread-crumb-inner right-side float-none-xs">
                  <ul>
                     <li><a href="index.php">Home</a><i class="fa fa-angle-right"></i></li>
                     <li><span><?php echo $producto->nombre ?></span></li>
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
                     <?php foreach ($imagenes['results'] as $img){
                        list($url,$size) = returnThumbnailImage($img->imagen,PRODUCTOS_PATH_HTML,PRODUCTOS_PATH,80,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg');?>
                        <a href="#"><img src=<?php echo $url ?> alt="Streetwear"></a>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-md-7 col-sm-7">
                  <div class="row">
                     <div class="col-xs-12">
                        <div class="product-detail-main">
                           <div class="product-item-details">
                              <h1 class="product-item-name"><?php echo $producto->nombre ?></h1>
                              <div class="price-box">
                                 <?php if ($producto->descuento!=0 && $producto->descuento!='') { ?>
                                    <span class="price"><?php echo "$ $producto->descuento" ?></span>
                                    <del class="price old-price"><?php echo "$ $producto->precio"; ?></del>
                                 <?php } else { ?>
                                    <span class="price"><?php echo "$ $producto->precio"; ?></span>
                                 <?php } ?>
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
                                          <form action="producto-abierto.php" method="get">
                                             <input type="hidden" name="pid" value="<?php echo $producto->producto_id ?>">
                                             <input type="hidden" name="comprar" value="">
                                             <button title="Add to Cart" class="btn-black" type="submit">
                                                <span></span>Obtener Cupón
                                             </button>
                                          </form>
                                       </li>
                                    </ul>
                                 </div>
                              </div>

                              <?php if (isset($_GET["comprar"])){ ?>
                                 <!-- esto se imprime una vez clickeado en obtener cupon -->
                                 <div class="detail-inner-left show-on-buy">
                                    <ul>
                                       <h3>
                                          El cupón es: <?php echo $com->codigo ?> <br/>
                                          y tiene una validez de <?php echo $producto->duracion ?> días.
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
                                 <?php } ?>


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
                           <?php 
                           foreach ($relacionados['results'] as $rel){
                              $vendedor = Vendedor::getById($rel->vendedor_id);
                              list($url,$size) = returnThumbnailImage($rel->foto,PRODUCTOS_PATH_HTML."crop5/",PRODUCTOS_PATH."crop5/",800,1000,IMAGES_PATH_HTML.'product-default.jpg',IMAGES_PATH.'product-default.jpg');?>
                              <div class="item">
                                 <div class="product-item">
                                    <div class="product-image">
                                       <div class="sale-label"><span><?php echo $vendedor->nombre; ?></span></div>
                                       <a href="producto-abierto.php?pid=<?php echo $rel->producto_id ?>">
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
                                          <a href="producto-abierto.php?pid=<?php echo $rel->producto_id ?>"><?php echo $rel->nombre; ?></a>
                                       </div>
                                       <div class="price-box">
                                          <?php if ($rel->descuento!=0 && $rel->descuento!='') { ?>
                                             <span class="price"><?php echo "$ $rel->descuento"; ?></span>
                                             <del class="price old-price"><?php echo "$ $rel->precio"; ?></del>
                                          <?php } else { ?>
                                             <span class="price"><?php echo "$ $rel->precio"; ?></span>
                                          <?php } ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php } ?>
                        </div>
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
