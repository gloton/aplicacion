<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Plantilla</title>
		<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
		<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet">
	    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	    <!--[if lt IE 9]>
			<script src="http://getbootstrap.com/2.3.2/assets/js/html5shiv.js"></script>
	    <![endif]-->	
		<style>
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>	    
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<?php if(isset($_layoutParams['menu'])): ?>
							<?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
							<?php 
							if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
							$_item_style = 'current'; 
							} else {
							$_item_style = '';
							}
							?>
							<li><a class="<?php echo $_item_style; ?>" href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>"><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></a></li>
							<?php endfor; ?>
							<?php endif; ?>							
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<div class="container">
			<!-- inicio contenido -->
