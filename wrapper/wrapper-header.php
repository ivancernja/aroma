<?php /* Wrapper Name: Header */ ?>
<div class="row">
	<div class="span4 offset4" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
		<?php get_template_part("static/static-logo"); ?>
	</div>
</div>
<div class="row">
	<div class="<?php echo cherry_get_layout_class( 'content' ); ?> offset2" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
		<?php get_template_part("static/static-nav"); ?>
	</div>
</div>