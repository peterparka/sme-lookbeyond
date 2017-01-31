<?php
/*
Template Name: Thank you
*/
get_header();

if( have_posts() ): while( have_posts() ): the_post(); ?>
<!-- WRAPPER -->
	<div class="wrapper">

		<?php get_template_part('template-parts/nav'); ?>

		<!-- HERO  -->
		<section class="hero-alt bg-white">

			<div class="row grid-middle">
				<h2 class="col-12-bottom pad-top"><?php the_title(); ?></h2>

				<div class="col-12-top p-large">
					<?php the_content(); ?>
				</div>
				<!-- <a class="col-12-top" href=""><p class="col-12-top p-xlarge">email@smenergy.com</p></a> -->
			</div>

		</section>
	</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
