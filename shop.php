<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es-AR">
<!--<![endif]-->
<?php include_once('config.php');
require('part-head.php');

$vendedor = Vendedor::getByUrl(getVar('url'));
if ($vendedor){
    $parts = explode('?', curPageURL());
    if (isset($parts[1])){
        $vars = explode('&', $parts[1]);
        foreach ($vars as $var){
            $vv = explode('=', $var);
            if (count($vv) == 2) $_GET[$vv[0]] = $vv[1];  
        }
    }
}
$cid = getVar('cid');
$desde = getVar('pd');
$hasta = getVar('ph');
$q = getVar('q');
$order = getVar('order');
$rows = getVar('rows');
$page = getVar('page', 1);
$productos = Producto::getFrontList($page, $rows, $order, $q, $hasta, $desde, $vendedor ? $vendedor->vendedor_id : '', $cid);

$categorias = Categoria::getAllList();
$max = getTotalRows("select precio c from producto order by precio desc limit 1");
$vUrl = $vendedor ? $vendedor->getUrl() : '';
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
                        <form action="">
                            <div class="price-range mb-30">
                               <div class="inner-title">Rango de Precios</div>
                               <span id="amount"></span>
                               <input class="price-txt" type="hidden" id="pd" name="pd">
                               <input class="price-txt" type="hidden" id="ph" name="ph">
                               <input type="hidden" name="q" value="<?php echo $q ?>">
                               <input type="hidden" name="cid" value="<?php echo $cid ?>">
                               <input type="hidden" name="order" value="<?php echo $order ?>">
                               <input type="hidden" name="rows" value="<?php echo $rows ?>">
                               <div id="slider-range"></div>
                            </div>
                            <button type="submit" class="btn-black">Buscar</button>
                        </form>
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
                                 $tieneSubcat = false;
                                 foreach ($categorias['results'] as $subc) {
                                    if ($subc->subcategoria_id==$cat->categoria_id) $tieneSubcat = true;
                                 }
                                 if ($cat->subcategoria_id=='0' && $tieneSubcat) { ?>
                                    <li>
                                       <a href="#"><?php echo $cat->nombre ?></a>
                                       <ul>
                                          <?php foreach ($categorias['results'] as $subcat) {
                                             if ($subcat->subcategoria_id==$cat->categoria_id) { ?>
                                                <li>
                                                   <a href="<?php echo generateUrl($q, $subcat->categoria_id, $desde, $hasta, $order, $rows, $vUrl) ?>"><?php echo $subcat->nombre ?></a>
                                                </li>
                                             <?php }
                                          }?>
                                       </ul>
                                    </li>
                                 <?php } elseif ($cat->subcategoria_id=='0' && !$tieneSubcat) { ?>
                                    <li>
                                       <a href="<?php echo generateUrl($q, $cat->categoria_id, $desde, $hasta, $order, $rows, $vUrl) ?>"><?php echo $cat->nombre ?></a>
                                    </li>
                                 <?php }
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
                           <div class="short-by float-right-sm">
                              <span>Filtrar por</span>
                              <div class="select-item">
                                 <select name="opcSelect" id="opcSelect" data-url="<?php echo generateUrl($q, $cid, $desde, $hasta, '', $rows, $vUrl) ?>">
                                    <option value="1" <?php echo $order == 1 ? 'selected="selected"' : '' ?>>Nombre (A to Z)</option>
                                    <option value="2" <?php echo $order == 2 ? 'selected="selected"' : '' ?>>Nombre (Z - A)</option>
                                    <option value="3" <?php echo $order == 3 ? 'selected="selected"' : '' ?>>Precio (Bajo &gt; Alto)</option>
                                    <option value="4" <?php echo $order == 4 ? 'selected="selected"' : '' ?>>Precio (Alto &gt; Bajo)</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="show-item right-side float-left-sm">
                              <span>Mostrar</span>
                              <div class="select-item">
                                 <select name="cantPerPage" id="cantPerPage" data-url="<?php echo generateUrl($q, $cid, $desde, $hasta, $order, '', $vUrl) ?>">
                                    <option value="24" <?php echo $rows == '' || $rows == 24 ? 'selected="selected"' : '' ?>>24</option>
                                    <option value="12" <?php echo $rows == 12 ? 'selected="selected"' : '' ?>>12</option>
                                    <option value="6" <?php echo $rows == 6 ? 'selected="selected"' : '' ?>>6</option>
                                 </select>
                              </div>
                              <span>Por hoja</span>
                           </div>
                        </div>
                     </div>
                     <br>
                     
                  </form>
               </div>
               <div class="product-listing">
                  <div class="row mlr_-20">
                     <?php
                     foreach ($productos['results'] as $prod){
                         $vendedor = Vendedor::getById($prod->vendedor_id);
                        list($url,$size) = returnThumbnailImage($prod->foto,PRODUCTOS_PATH_HTML."crop5/",PRODUCTOS_PATH."crop5/",800,1000,IMAGES_PATH_HTML.'product-default.jpg',IMAGES_PATH.'product-default.jpg');
                        
                        ?>
                        <div class="col-md-4 col-xs-6 plr-20">
                           <div class="product-item">
                              <div class="product-image">
                                 <div class="sale-label"><span><?php echo $vendedor->nombre; ?></span></div>
                                 <a href="<?php echo WEB_PATH_HTML ?>producto-abierto.php?pid=<?php echo $prod->producto_id ?>">
                                    <img src="<?php echo $url ?>" alt="Masha Wow!">
                                 </a>
                                 <div class="product-detail-inner">
                                    <div class="detail-inner-left align-center">
                                       <ul>
                                          <li class="pro-cart-icon">
                                          	<a href="<?php echo WEB_PATH_HTML ?>producto-abierto.php?pid=<?php echo $prod->producto_id ?>&shop" title="Obtener Código"><span></span></a>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="product-item-details">
                                 <div class="product-item-name">
                                    <a href="<?php echo WEB_PATH_HTML ?>producto-abierto.php?pid=<?php echo $prod->producto_id ?>"><?php echo $prod->nombre; ?></a>
                                 </div>
                                 <div class="price-box">
                                 	<?php if ($prod->descuento > 0){ ?>
                                    <span class="price"><?php echo "$ $prod->descuento"; ?></span>
                                    <del class="price old-price"><?php echo "$ $prod->precio"; ?></del>
                                    <?php }else { ?>
                                    <span class="price"><?php echo "$ $prod->precio"; ?></span>
                                    <?php } ?>
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
      <script>
      var amount = $("#amount");
      var sliderrange = $("#slider-range");
      sliderrange.slider({
          range: true,
          min: 0,
          max: <?php echo $max ?>,
          values: [ <?php echo $desde && $desde != '' ? $desde : 0 ?>, <?php echo $hasta && $hasta !='' ? $hasta : $max ?> ],
          slide: function( event, ui ) {
              amount.empty().append( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
              $("#pd").val(ui.values[ 0 ]);
              $("#ph").val(ui.values[ 1 ]);
          }
      });
      amount.empty().append("$" + sliderrange.slider( "values", 0 ) +" - $" + sliderrange.slider( "values", 1 ) );
      
      $("#opcSelect").change(function(){
      	var url = $(this).data("url") + '&order=' + $(this).val();
      	window.location.href = url;
      });
      
      $("#cantPerPage").change(function(){
      	var url = $(this).data("url") + '&rows=' + $(this).val();
      	window.location.href = url;
      });
      </script>
   </body>
   </html>
