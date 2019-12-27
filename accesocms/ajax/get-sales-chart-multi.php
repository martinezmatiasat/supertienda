<?php
require_once dirname(__FILE__)."/../../config.php";
require_once ADMIN_PAGES_PATH.'/security.php';
include_once ADMIN_LANG.ADMIN_LANGUAGE.'.inc';

$year = isset($_POST['year']) ? $_POST['year'] : null;

if ($year){
	$list = Compra::getSalesAmountYear($year, VENDEDOR_ID);
	$i = 1;
	$added = 0;
	$list2 = array(array('Mes', 'Ventas'));
	while ($i <= 12 && $added < count($list)){
		if (isset($list[$i])){
			$list2[] = array($lang['MONTH_'.$i],$list[$i]);
			$added++;
		}else {
			$list2[] = array($lang['MONTH_'.$i],0);
		}
		$i++;
	}
	if (count($list2) == 1) $list2[] = array(' ',0);
	echo json_encode($list2);
}
?>