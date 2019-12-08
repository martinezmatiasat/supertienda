<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es-AR">
<!--<![endif]-->
<?php include_once('config.php');
require('part-head.php');
if(isset($_GET['url'])){
   $vendedor = Vendedor::getByUrl($_GET['url']);
   $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", 24, array("vendedor_id = $vendedor->vendedor_id" , "eliminado = 0"), "nombre");
} else {
   $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", 24, array("eliminado = 0"), "nombre");
}
$categorias = Categoria::getAllList();
?>

<body>
   <div class="se-pre-con"></div>
   <div class="main">
      <?php require('part-header.php'); ?>

      <!-- BANNER STRAT -->
      <div class="banner inner-banner">
         <div class="container">
            <div class="bread-crumb mtb-60 center-xs">
               <div class="page-title">Listado completo de productos o por vendedor</div>
               <div class="bread-crumb-inner right-side float-none-xs">
                  <ul>
                     <li><a href="index.php">Home</a><i class="fa fa-angle-right"></i></li>
                     <li><span>Listado</span></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- BANNER END -->

      <!-- CONTAIN START -->
      <section class="container pb-85 pt-55">
         <div class="row">
            <div class="col-md-3 col-sm-4 mb-xs-30">
               <div class="sidebar-block">
                  <div class="sidebar-box filter-sidebar mb-40">
                     <span class="opener plus"></span>
                     <div class="main_title sidebar-title">
                        <h3><span>Filtros</span> </h3>
                     </div>
                     <div class="sidebar-contant">
                        <div class="price-range mb-30">
                           <div class="inner-title">Rango de Precios</div>
                           <input class="price-txt" type="text" id="amount">
                           <div id="slider-range"></div>
                        </div>
                     </div>
                     <div class="sidebar-box listing-box mb-40">
                        <span class="opener plus"></span>
                        <div class="main_title sidebar-title">
                           <h3><span>Categorias</span></h3>
                        </div>
                        <div class="sidebar-contant">
                           <ul>
                              <?php
                              foreach ($categorias['results'] as $cat) {
                                 if ($cat->subcategoria_id=='0') { ?>
                                    <li>
                                       <a href="#"><?php echo $cat->nombre ?><span>(05)</span></a>
                                    </li>
                                 <?php } else { echo "hola";?>
                                 <li>
                                    <a href="#"><?php echo $cat->nombre ?><span>(21)</span></a>
                                    <ul>
                                       <?php foreach ($categorias['results'] as $subcat) {
                                          if ($subcat->subcategoria_id!='0') { ?>
                                             <li>
                                                <a href="#"><?php echo $subcat->nombre ?></a>
                                             </li>
                                          <?php }
                                       } ?>
                                    </ul>
                                 </li>
                              <?php };
                           } ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="shorting mb-30">
               <form class="" name="ordenar" action="shop.php" method="get">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="view">
                           <div class="list-types grid active ">
                              <a href="shop.php">
                                 <div class="grid-icon list-types-icon"></div>
                              </a>
                           </div>
                           <div class="list-types list">
                              <a href="shop-list.php">
                                 <div class="list-icon list-types-icon"></div>
                              </a>
                           </div>
                        </div>
                        <div class="short-by float-right-sm">
                           <span>Filtrar por</span>
                           <div class="select-item">
                              <select name="opcSelect">
                                 <option value="1" selected="selected">Nombre (A to Z)</option>
                                 <option value="2">Nombre (Z - A)</option>
                                 <option value="3">Precio (Bajo &gt; Alto)</option>
                                 <option value="4">Precio (Alto &gt; Bajo)</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="show-item right-side float-left-sm">
                           <span>Mostrar</span>
                           <div class="select-item">
                              <select name="cantPerPage">
                                 <option value="24" selected="selected">24</option>
                                 <option value="12">12</option>
                                 <option value="6">6</option>
                              </select>
                           </div>
                           <span>Por hoja</span>
                        </div>
                     </div>
                  </div>
                  <br>
                  <input type="submit" class="btn-black" name="btn-ordenar" value="Buscar">
               </form>
            </div>
            <div class="product-listing">
               <div class="row mlr_-20">
                  <?php
                  if (isset($_REQUEST['opcSelect'])) {
                     if ($_REQUEST['opcSelect']=='1') {
                        $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", $_REQUEST["cantPerPage"], array("eliminado = 0"), "nombre");
                     } elseif ($_REQUEST['opcSelect']=='2') {
                        $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", 24, array("eliminado = 0"), "nombre DESC");
                     }  elseif ($_REQUEST['opcSelect']=='3') {
                        $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", 24, array("eliminado = 0"), "descuento");
                     }  elseif ($_REQUEST['opcSelect']=='4') {
                        $productos = ConnectionFactory::getFactory()->getList("producto", "Producto", 24, array("eliminado = 0"), "descuento DESC");
                     }
                  }
                  foreach ($productos['list'] as $prod){
                     if(!isset($_GET['url'])){
                        $vendedor = Vendedor::getById($prod->vendedor_id);
                     }
                     list($url,$size) = returnThumbnailImage($prod->foto,PRODUCTOS_PATH_HTML."crop5/",PRODUCTOS_PATH."crop5/",800,1000,IMAGES_PATH_HTML.'product-default.jpg',IMAGES_PATH.'product-default.jpg');
                     ?>
                     <div class="col-md-4 col-xs-6 plr-20">
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
                                 <a href="producto-abierto.php"><?php echo $prod->nombre; ?></a>
                              </div>
                              <div class="price-box">
                                 <span class="price"><?php echo "$ $prod->descuento"; ?></span>
                                 <del class="price old-price"><?php echo "$ $prod->precio"; ?></del>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php } ?>
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
