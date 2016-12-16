<?php 
	define('PAGE', "client-show-story");
	define('LEVEL', 1);
	include_once 'api/auth.php';
?>
<?php 
	include("clientSections/section-top.php"); 
	include_once("api/internal/sales.php");
	include_once 'components/saleTable.php';
?>
<?php
	
	
	if(isset($_GET['fromDate']) || isset($_GET['upToDate'])){
		$fromDate = $upToDate = "";
		if(isset($_GET['fromDate'])) $fromDate = $_GET['fromDate'];
		if(isset($_GET['upToDate'])) $upToDate = $_GET['upToDate'];
		$listOfSales = api_internal_sales_getAllFinishedSalesByUserBetween($_SESSION['id'], $fromDate, $upToDate);
	}
	else $listOfSales = api_internal_sales_getAllFinishedSalesByUser($_SESSION['id']);
?>

<div class="ui <?php echo (count($listOfSales)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia	</div>No existen registros de ventas
</div>

<div class="ui segment">
	<h1>Historial de compras</h1>
	<div class="ui segment">
		<div class="ui sub header">Filtrar por fecha</div>
		<form class="ui form" id="formFiltro">
			<div class="inline fields">
				<div class="field">
					<label>Desde</label>
					<input id="fromDateField" type="date" name="fromDate" min="1800-01-01" value="<?php echo isset($_GET['fromDate'])?$_GET['fromDate']:"1900-01-01" ?>">
				</div>
				<div class="field">
					<label>Hasta</label>
					<input id="upToDateField" type="date" name="upToDate" value="<?php echo isset($_GET['upToDate'])?$_GET['upToDate']:date('Y-m-d') ?>" min="1800-01-01">
				</div>
				<div class="field">
				<div id="buttonDateFilter" class="ui right floated basic blue small labeled icon button">
					<i class="calendar icon"></i> Buscar
				</div>
				</div>
			</div>
		</form>
	</div>
	
<?php
	forEach($listOfSales as $sale){
		$listOfProducts = api_internal_getProductsBySale($sale['id']);
		echo '
			<div style="margin-top:80px;" class="ui divider"></div>
				<div class="ui grid">
					<div style ="font-size: 1.5em" class="six wide column"><b>Código de venta: </b>'.$sale['id'].'</div>
					<div style ="font-size: 1.5em" class="six wide column"><b>Fecha de venta: </b>'.$sale['date'].'</div>
				</div>
			
		';
		saleTable($listOfProducts, $sale['id']);
	}
?>			
</div>
<?php include("clientSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
		$('#buttonDateFilter').click(function(e){
			e.preventDefault();
			let fromDate = $('#fromDateField').val();
			let upToDate = $('#upToDateField').val();
			let location = "";
			if(typeof fromDate == 'undefined') fromDate = "";
			if(typeof upToDate == 'undefined') upToDate = "";
			window.location.href = "?fromDate="+fromDate+"&upToDate="+upToDate;
		});
	});
</script>
<?php 
	unset($searchedUser, $usersList, $id, $key, $row, $value);
?>