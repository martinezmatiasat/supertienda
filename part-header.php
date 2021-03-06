<?php 
include_once('config.php');
require('part-head.php');
$categorias = Categoria::getAllList(); ?>
<header class="navbar navbar-custom" id="header">
   <div class="header-middle">
      <div class="container">
         <div class="header-inner">
            <div class="row m-0">
               <div class="col-md-4 col-sm-12 hidden-sm hidden-xs">
                  <div class="header-right-part float-none-sm">
                  </div>
               </div>
               <div class="col-md-4 col-sm-12">
                  <div class="navbar-header float-none-sm">
                     <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <i class="fa fa-bars"></i></button>
                        <a class="navbar-brand page-scroll" href="index.php">
                           <img alt="Masha Wow!" src="<?php echo WEB_PATH_HTML ?>images/logo.png">
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                     <div class="header-right-part right-side float-none-sm">
                        <ul>
                           <li class="mobile-view-search">
                              <div class="header_search_toggle mobile-view">
                                 <form action="shop.php">
                                    <div class="search-box">
                                       <input type="text" placeholder="Buscar" class="input-text" name="q">
                                       <button class="search-btn"></button>
                                    </div>
                                 </form>
                              </div>
                           </li>
                           <li class="cart-icon visible-sm visible-xs">
                              <a href="#">
                                 <span>
                                    <small class="cart-notification">2</small>
                                 </span>
                                 <div class="header-right-text">Shopping Cart</div>
                                 <div class="header-price">$ 354.32</div>
                              </a>
                              <div class="cart-dropdown header-link-dropdown">
                                 <ul class="cart-list link-dropdown-list">
                                    <li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                                       <div class="media"> <a class="pull-left"> <img alt="Streetwear" src="images/1.jpg"></a>
                                          <div class="media-body">
                                             <span><a>Black African Print Skirt</a></span>
                                             <p class="cart-price">$14.99</p>
                                             <div class="product-qty">
                                                <div class="custom-qty">
                                                   <input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                    <li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                                       <div class="media"> <a class="pull-left"> <img alt="Streetwear" src="images/2.jpg"></a>
                                          <div class="media-body">
                                             <span><a>Black African Print Skirt</a></span>
                                             <p class="cart-price">$14.99</p>
                                             <div class="product-qty">
                                                <div class="custom-qty">
                                                   <input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                 </ul>
                                 <p class="cart-sub-totle">
                                    <span class="pull-left">Cart Subtotal</span>
                                    <span class="pull-right"><strong class="price-box">$29.98</strong></span>
                                 </p>
                                 <div class="clearfix"></div>
                                 <div class="mt-20">
                                    <a href="cart.php" class="btn-color btn">Cart</a>
                                    <a href="checkout.php" class="btn-color btn right-side">Checkout</a>
                                 </div>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="header-bottom">
         <div class="container">
            <div id="menu" class="navbar-collapse collapse left-side align-center" >
               <ul class="nav navbar-nav">
                  <li class="level"><a href="shop.php" class="page-scroll">Todas las categorías</a></li>
                  <?php
                  foreach ($categorias['results'] as $cat) {
                     $tieneSubcat = false;
                     foreach ($categorias['results'] as $subc) {
                        if ($subc->subcategoria_id==$cat->categoria_id) $tieneSubcat = true;
                     }
                        if ($cat->subcategoria_id=='0' && $tieneSubcat) { ?>
                           <!-- CATEGORIA -->
                           <li class="level dropdown">
                              <span class="opener plus"></span>
                              <a class="page-scroll"><?php echo $cat->nombre ?></a>
                              <div class="megamenu mobile-sub-menu">
                                 <div class="megamenu-inner-top">
                                    <ul class="sub-menu-level1">
                                       <li class="level2">
                                          <ul class="sub-menu-level2 ">
                                             <?php foreach ($categorias['results'] as $subcat) {
                                                if ($subcat->subcategoria_id==$cat->categoria_id) { ?>
                                                   <li class="level3"><a href="shop.php?cid=<?php echo $subcat->categoria_id ?>"><?php echo $subcat->nombre ?></a></li>
                                                <?php }
                                             }?>
                                          </ul>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </li>
                        <?php } elseif ($cat->subcategoria_id=='0' && !$tieneSubcat) { ?>
                           <li class="level dropdown">
                              <span class="opener plus"></span>
                              <a class="page-scroll"><?php echo $cat->nombre ?></a>
                           </li>
                        <?php }
                  } ?>

               </ul>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
