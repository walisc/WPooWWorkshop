<?php get_header(); ?>

<!-- Page Content -->
<div class="container">

	<!-- Jumbotron Header -->
	<header class="jumbotron my-4">
		<h1 class="display-3">WordCamp CapeTown 2019</h1>
		<p class="lead">Join us then as we explore the world of WordPress together.</p>
		<a href="#" class="btn btn-primary btn-lg">Register Now</a>
	</header>

	<!-- Page Features -->
	<div class="row text-center">

		<?php
		$wc_sponsors = wpAPIObjects::GetInstance()->GetObject("_wc_sponsors");

		foreach ($wc_sponsors->Query()->Select()->Fetch() as $sponsor)
		{
			$logoData = json_decode($sponsor["_logo"]);

			?>
			<div class="col-lg-3 col-md-6 mb-4">
				<div class="card">
					<img class="card-img-top" src="<?php echo $logoData->url ?>" alt="<?php echo $logoData->filename ?>">
					<div class="card-body">
						<h4 class="card-title"><?php echo $sponsor["_name"]?></h4>
						<p class="card-text"><?php echo $sponsor["_description"]?></p>
					</div>
					<div class="card-footer">
						<a href="<?php echo $sponsor["_url"]?>" class="btn btn-primary">Find Out More!</a>
					</div>
				</div>
			</div>
			<?
		}
		?>

</div>
<!-- /.container -->


<?php get_footer(); ?>



<!---->
<?php
//
//$args = array(
//'post_type' => '_wc_sponsors'
//);
//
//$sponsors_query = new WP_Query($args);
//
//while ($sponsors_query->have_posts()) : $sponsors_query->the_post(); ?>
<!--	ffff-->
<!--	<div class="col-lg-3 col-md-6 mb-4">-->
<!--		<div class="card">-->
<!--			<img class="card-img-top" src="http://placehold.it/500x325" alt="">-->
<!--			<div class="card-body">-->
<!--				<h4 class="card-title">--><?php //echo get_post_custom_values('_wc_sponsors__name')?><!--</h4>-->
<!--				<p class="card-text">--><?php //echo get_post_custom_values('_wc_sponsors__description')?><!--</p>-->
<!--			</div>-->
<!--			<div class="card-footer">-->
<!--				<a href="#" class="btn btn-primary">Find Out More!</a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!---->
<!---->
<!---->
<!---->
<?//
//endwhile;

