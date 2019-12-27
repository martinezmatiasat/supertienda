<?php
include 'header.php';
changeHeaderVariablesAdmin('', '', '', array());
function callback($buffer){}

if (!VENDEDOR){
    $data = Compra::getIndex();
    $latest = $data['results'];
    ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></h1>
	<div id="breadcrumb">
		<a href="index.php" title="<?php echo showLang($lang, 'HOME_BREADCRUM') ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, 'HOME_HOME') ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></a>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>Resumenes</h5></div>
				<div class="widget-content">
					<div class="row">
						<label>Total de Ventas: </label>
						<span><?php echo showPrice(Compra::getSalesAmount()) ?></span>
					</div>
					<div class="row">
						<label>Ventas este Mes: </label>
						<span><?php echo showPrice(Compra::getSalesAmount(date('m'))) ?></span>
					</div>
					<div class="row">
						<label>Ventas este A&ntilde;o: </label>
						<span><?php echo showPrice(Compra::getSalesAmount(false,date('Y'))) ?></span>
					</div>
					<div class="row">
						<label>Total de Ventas: </label>
						<a href="compras.php"><span><?php echo Compra::getNumberOfSales(); ?></span></a>
					</div>
					<div class="row">
						<label>Ventas Pendientes: </label>
						<a href="compras.php"><span><?php echo Compra::getNumberOfSales(array(0)); ?></span></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>&Uacute;ltimas Ventas</h5></div>
				<div class="widget-content" style="padding: 0px;">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Email</th>
								<th>Total</th>
								<th>Estado</th>
								<th>Codigo</th>
							</tr>
						</thead>
						<?php foreach ($latest as $order){ 
						?>
						<tr>
							<td class="centerTd" align="center"><?php echo $order->compra_id ?></td>
							<td class="centerTd" align="center"><?php echo $order->email ?></td>
							<td class="centerTd" align="center"><?php echo showPrice($order->total) ?></td>
							<td class="centerTd" align="center"><?php echo $order->estado == 0 ? 'Pendiente' : ($order->estado == 1 ? 'Usado' : 'Expirado') ?></td>
							<td class="centerTd" align="center"><?php echo $order->codigo ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-4">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>Ventas</h5></div>
				<div class="widget-content">
					<div id="all-sales"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon"><i class="fa fa-align-justify"></i></span>
					<h5>Ventas por Mes</h5>
					<span class="pull-right" style="margin-top: 8px; margin-right: 10px;"><?php echo Compra::getYearsSelect('years'); ?></span>
				</div>
				<div class="widget-content">
					<div class="clear"></div>
					<div id="month-sales"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var titles = new Array();
var sales = new Array();
<?php
	for ($i = 0; $i <= 2; $i++){?>
		titles.push("<?php echo $i == 0 ? 'Pendiente' : ($i == 1 ? 'Usado' : 'Expirado') ?>");
		sales.push("<?php echo  Compra::getNumberOfSales(array($i)) ?>");
<?php } ?>
dashboard();
</script>
<?php }else { 
$data = Compra::getIndex(VENDEDOR_ID);
$latest = $data['results'];
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></h1>
	<div id="breadcrumb">
		<a href="index.php" title="<?php echo showLang($lang, 'HOME_BREADCRUM') ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, 'HOME_HOME') ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></a>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>Resumenes</h5></div>
				<div class="widget-content">
					<div class="row">
						<label>Total de Ventas: </label>
						<span><?php echo showPrice(Compra::getSalesAmount(false, false, VENDEDOR_ID)) ?></span>
					</div>
					<div class="row">
						<label>Ventas este Mes: </label>
						<span><?php echo showPrice(Compra::getSalesAmount(date('m'), false, VENDEDOR_ID)) ?></span>
					</div>
					<div class="row">
						<label>Ventas este A&ntilde;o: </label>
						<span><?php echo showPrice(Compra::getSalesAmount(false,date('Y'), false)) ?></span>
					</div>
					<div class="row">
						<label>Total de Ventas: </label>
						<a href="compras.php"><span><?php echo Compra::getNumberOfSales(false, VENDEDOR_ID); ?></span></a>
					</div>
					<div class="row">
						<label>Ventas Pendientes: </label>
						<a href="compras.php"><span><?php echo Compra::getNumberOfSales(array(0)); ?></span></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>&Uacute;ltimas Ventas</h5></div>
				<div class="widget-content" style="padding: 0px;">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Email</th>
								<th>Total</th>
								<th>Estado</th>
								<th>Codigo</th>
							</tr>
						</thead>
						<?php foreach ($latest as $order){ 
						?>
						<tr>
							<td class="centerTd" align="center"><?php echo $order->compra_id ?></td>
							<td class="centerTd" align="center"><?php echo $order->email ?></td>
							<td class="centerTd" align="center"><?php echo showPrice($order->total) ?></td>
							<td class="centerTd" align="center"><?php echo $order->estado == 0 ? 'Pendiente' : ($order->estado == 1 ? 'Usado' : 'Expirado') ?></td>
							<td class="centerTd" align="center"><?php echo $order->codigo ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-4">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="fa fa-align-justify"></i></span><h5>Ventas</h5></div>
				<div class="widget-content">
					<div id="all-sales"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon"><i class="fa fa-align-justify"></i></span>
					<h5>Ventas por Mes</h5>
					<span class="pull-right" style="margin-top: 8px; margin-right: 10px;"><?php echo Compra::getYearsSelect('years'); ?></span>
				</div>
				<div class="widget-content">
					<div class="clear"></div>
					<div id="month-sales"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var titles = new Array();
var sales = new Array();
<?php
	for ($i = 0; $i <= 2; $i++){?>
		titles.push("<?php echo $i == 0 ? 'Pendiente' : ($i == 1 ? 'Usado' : 'Expirado') ?>");
		sales.push("<?php echo  Compra::getNumberOfSales(array($i), VENDEDOR_ID) ?>");
<?php } ?>
dashboardMulti();
</script>
<?php } ?>
<?php 
include 'footer.php';
?>