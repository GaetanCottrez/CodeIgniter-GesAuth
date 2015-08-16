<?php echo doctype('html5')?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<?php echo title($title); ?>
<?php // load meta ?>
		<?php $meta = array(array('name' => 'robots', 'content' => 'no-cache'), array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'), array('name' => 'Content-type', 'content' => 'text/html; charset='.$charset, 'type' => 'equiv')); ?>
		<?php echo meta($meta); ?>
<?php // load favicon ?>
		<?php $link = array('href' => base_url().'assets/images/favicon.ico', 'rel' => 'shortcut icon', 'type' => 'image/x-icon');?>
		<?php echo link_tag($link);?>
		<?php foreach($css as $url): ?>
<?php // load file css ?>
			<?php $link = array('href' => $url,'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen'); ?>
			<?php echo link_tag($link);?>
		<?php endforeach; ?>
<?php // load script for detect close browser ?>
		<?php echo script('text/javascript', '', 'var gesauth_url_close_browser = "'.site_url('login/ajax_close_browser').'";'); ?>
<?php // load script js ?>
		<?php foreach($js as $url): ?>
			<?php echo script('text/javascript', $url); ?>
		<?php endforeach; ?>
	</head>
	<body>
		<div id="processing"></div>
		<div class="container-fluid">
			<header class="row-fluid">
				<?php echo $menu; ?>
			</header>
			<!-- <h3><?php echo $title; ?></h3> -->
			<?php echo $output; ?>
		</div>
	</body>
	<footer class="row-fluid"></footer>
	<?php $this->output->enable_profiler(TRUE); ?>
</html>