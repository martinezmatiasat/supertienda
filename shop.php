<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es-AR">
    <!--<![endif]-->
    
    <?php require('part-head.php'); ?>
    
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
                                            <li>
                                                <a href="#">Categoría 1 <span>(21)</span></a>
                                                <ul>
                                                    <li>
                                                        <a href="#">Subcategoría 1 (0)</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Subcategoría 2 (3)</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#">Categoría 2 <span>(05)</span></a>
                                            </li>
                                            <li>
                                                <a href="#">Categoría 3 <span>(10)</span></a>
                                            </li>
                                            <li>
                                                <a href="#">Categoría 4 <span>(12)</span></a>
                                            </li>
                                            <li>
                                                <a href="#">Categoría 5 <span>(18)</span></a>
                                            </li>
                                            <li>
                                                <a href="#">Categoría 6 <span>(70)</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8">
                        <div class="shorting mb-30">
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
                                            <select>
                                                <option value="" selected="selected">Nombre (A to Z)</option>
                                                <option value="">Nombre (Z - A)</option>
                                                <option value="">Precio (Bajo &gt; Algo)</option>
                                                <option value="">Precio (Alto &gt; Bajo)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="show-item right-side float-left-sm">
                                        <span>Mostrar</span>
                                        <div class="select-item">
                                            <select>
                                                <option value="" selected="selected">24</option>
                                                <option value="">12</option>
                                                <option value="">6</option>
                                            </select>
                                        </div>
                                        <span>Por hoja</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-listing">
                            <div class="row mlr_-20">
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                                <div class="col-md-4 col-xs-6 plr-20">
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
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="pagination-bar align-center">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                        </ul>
                                    </div>
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
