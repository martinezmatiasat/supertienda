<?php include_once('config.php') ?>
<?php require('part-head.php');


$categorias = Categoria::getDestacados();
$productos = Producto::getRandom();
//$listaProd=$productos['results'];
var_dump(IMAGES_PATH_HTML);
var_dump(PRODUCTOS_PATH_HTML);


?>
<body>
   <div class="se-pre-con"></div>
   <div id="newslater-popup" class="mfp-hide white-popup-block open align-center">
      <div class="nl-popup-main">
         <div class="nl-popup-inner">
            <div class="row m-0">
               <div class="col-sm-5 col-xs-0 hidden-xs p-0">
                  <div class="nl-popup-image">
                     <img src="images/suscripcion.PNG" alt="streetwear">
                  </div>
               </div>
               <div class="col-sm-7 col-xs-12 p-0">
                  <div class="newsletter-inner">
                     <h2 class="main_title">Suscribite</h2>
                     <p>
                        Dejanos tu correo y recibí Ofertas increíbles.
                        <br/> <br/>
                     </p>
                     <form>
                        <input type="email" placeholder="Ingrese su correo">
                        <button class="email-btn"></button>
                     </form>
                     <ul>
                        <li>
                           <span>
                              <input type="checkbox" class="checkbox">
                           </span>
                           <label>No volver a mostrar el popup</label>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="main">

      <?php require('part-header.php'); ?>

      <!-- BANNER STRAT -->
      <section>
         <div class="banner">
            <div class="main-banner">
               <div class="banner-2">
                  <img src="images/banner.PNG" alt="Masha Wow">
                  <div class="banner-detail">
                     <div class="row">
                        <div class="col-md-4 col-sm-5 col-xs-4"></div>
                        <div class="col-md-8 col-sm-7 col-xs-8">
                           <div class="banner-detail-inner">
                              <h1 class="banner-title">Masha Wow! </h1>
                              <h1 class="banner-subtitle">Ofertas Exclusivas!</h1>
                              <a href="" class="btn btn-black">Ver Ofertas</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="banner-2">
                  <img src="images/banner.PNG" alt="Masha Wow">
                  <div class="banner-detail">
                     <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-1"></div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                           <div class="banner-detail-inner">
                              <h1 class="banner-title">Masha Wow! </h1>
                              <h1 class="banner-subtitle">Ofertas Exclusivas!</h1>
                              <a href="" class="btn btn-black">Ver Ofertas</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="banner-2">
                  <img src="images/banner.PNG" alt="Masha Wow">
                  <div class="banner-detail">
                     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                           <div class="banner-detail-inner">
                              <h1 class="banner-title">Masha Wow! </h1>
                              <h1 class="banner-subtitle">Ofertas Exclusivas!</h1>
                              <a href="" class="btn btn-black">Ver Ofertas</a>
                           </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- BANNER END -->

      <!-- CONTAIN START -->

      <!-- Sub-banner Block Start -->
      <section class="container">
         <div class="sub-banner-block center-xs pt-30">
            <div class="row m-0">
               <?php foreach ($categorias['results'] as $cat) {
                  list($url,$size) = returnThumbnailImage($cat->imagen, IMAGES_PATH_HTML."crop3/", IMAGES_PATH."crop3/", 382, 380, ADMIN_IMAGES_PATH_HTML.'nopic.jpg', ADMIN_IMAGES_PATH.'nopic.jpg');
               ?>
               <div class="col-sm-4">
                  <div class="sub-banner sub-banner3">
                     <a href="index.php"> <img src="<?php echo $url ?>" alt="Masha Wow!">
                        <div class="sub-banner-detail">
                           <div class="sub-banner-subtitle"><?php echo $cat->nombre ?></div>
                           <div class="sub-banner-title"><?php echo $cat->nombre ?></div>
                        </div>
                     </a>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </section>
      <!-- Sub-banner Block End -->

      <!--  Featured Products Slider Block Start  -->
      <section class="container">
         <div class="ptb-85">
            <div class="product-slider owl-slider">
               <div class="row">
                  <div class="col-xs-12">
                     <div class="heading-part align-center mb-40">
                        <h2 class="main_title">Listado de Ofertas</h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div id="items">
                     <div class="tab_content pro_cat">
                        <ul>
                           <li>

                              <?php foreach ($productos['results'] as $prod){
                               list($url,$size) = returnThumbnailImage($prod->foto,PRODUCTOS_PATH_HTML."crop5/",PRODUCTOS_PATH."crop5/",800,1000,IMAGES_PATH_HTML.'product-default.jpg',IMAGES_PATH.'product-default.jpg');
                              ?>

                              <div id="data-step1" class="items-step1 selected product-slider-main position-r" data-temp="tabdata">
                                 <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
                                    <div class="product-item">
                                       <div class="product-image">
                                          <div class="sale-label"><span><?php echo $prod->vendedor_id ?></span></div>
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
                              </div>

                              <?php } ?>

                           <!-- </li><li>
                              <div id="data-step1" class="items-step1 selected product-slider-main position-r" data-temp="tabdata">
                                 <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
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
                                 <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
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
                                 <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
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
                                 <div class="col-md-3 col-sm-4 col-xs-6 plr-20 mb-40">
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
                           </li>
                        </ul>
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

   <script>
   /* ------------ Newslater-popup JS Start ------------- */
   $(window).load(function () {
      $.magnificPopup.open({
         items: {src: '#newslater-popup'}, type: 'inline'}, 0);
      });
      /* ------------ Newslater-popup JS End ------------- */
      </script>

   </body>
   </html>
