<?php include('includes/session.inc.php'); ?>
<div class="page-header"><div class="img"></div></div>
	<div class="navbar">
		<div class="navbar-inner">
		 <ul class="nav">
		 <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<b class="caret"></b></a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
				<?php echo $_SESSION['menu'];?>
			</ul>
		</li>
		</ul>
		 <div id="idBar" class="span4 pull-right">Welcome, <?php echo $_SESSION['first_name']." | ".$_SESSION['today']; ?></div>
	 </div>	
</div>