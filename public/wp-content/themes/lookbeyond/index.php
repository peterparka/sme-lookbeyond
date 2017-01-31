<?php
get_header();

if( have_posts() ): while( have_posts() ): the_post(); ?>


<!-- WRAPPER -->
<main role="main">

	<?php get_template_part('template-parts/nav'); ?>

	<!-- HERO  -->
	<section class="hero bg-white">

		<div class="row hero-text grid-middle os-animation" data-os-animation="fadeInUp" data-os-animation-delay=".5s">
			<h1 class="col-12-bottom "><?php the_title(); ?></h1>
			<p class="col-12-top p-xlarge"><?php the_field('sub_title'); ?></p>
		</div>

	</section>


	<section class="hero-boxes ">
		<div class="row-no-max grid-3_md-5">

			<div class="col os-animation" data-os-animation="fadeInUp" data-os-animation-delay=".7s">
				<img src="<?php echo get_template_directory_uri(); ?>/_img/hero-box-1.jpg" alt="children studying">
			</div>

			<div class="col os-animation" data-os-animation="fadeInUp" data-os-animation-delay="1s">

			</div>

			<div class="col os-animation" data-os-animation="fadeInUp" data-os-animation-delay="1.3s">
				<img src="<?php echo get_template_directory_uri(); ?>/_img/hero-box-2.jpg" alt="children studying">
			</div>

			<div class="col os-animation" data-os-animation="fadeInUp" data-os-animation-delay="1s">
				<img src="<?php echo get_template_directory_uri(); ?>/_img/hero-box-3.jpg" alt="children studying">
			</div>

			<div class="col os-animation" data-os-animation="fadeInUp" data-os-animation-delay=".7s">

			</div>
		</div>
	</section>


	<!-- SECTION 1 -->
	<section class="bgg-c1 xpad-top z-top ">

		<header class="row text-block os-animation" data-os-animation="fadeInUp">
			<span class="accent"></span>
			<h4 class="p-large"><?php the_field('infographic_circles_title'); ?></h4>
		</header>


		<?php if( have_rows('infographic_circles') ): ?>

			<div class="row grid-center circle-wrap">

				<?php while( have_rows('infographic_circles') ) : the_row(); ?>

					<div class="col-12_sm-4 circle os-animation" data-os-animation="fadeInUp"></>
						<div class="circle__inner">
							<div class="circle__wrapper">
								<div class="circle__content">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/<?php echo strtolower( get_sub_field('icon') ); ?>.svg" alt="<?php the_sub_field('text'); ?>">
									<h5><?php the_sub_field('text'); ?></h5> <!-- Staying Connected -->
								</div>
							</div>
						</div>
					</div>

				<?php endwhile; ?>
			</div>
		<?php endif; ?>

	</section>

	<!-- SECTION 2 -->
	<section class="bg-white xpad-top">

		<header class="row text-block os-animation" data-os-animation="fadeInUp">
			<span class="accent-top"></span>
			<h2><?php the_field('plain_section_title'); ?></h2>
			<?php the_field('plain_section_text'); ?>
		</header>

	</section>

	<section class="bg-image grid-middle">

		<div class="img-wrapper">

			<?php if( $image = get_field('background_section_image') ): ?>
				<img src="<?php echo $image; ?>" alt="<?php the_field('background_section_text'); ?>">
			<?php endif; ?>

			<div class="dark-gradient"></div>
		</div>

		<div class="row grid-1-middle-center text-block">
			<h3 class="col-12_lg-9 os-animation" data-os-animation="fadeInDown"><?php the_field('background_section_text'); ?></h3>
		</div>

	</section>


	<?php if( have_rows('chequered_blocks') ): ?>

		<section class="no-pad alt-blocks">

			<?php $i = 1; while( have_rows('chequered_blocks') ) : the_row(); ?>

				<article class="<?php echo ( $i % 2 ) ? 'grid-row-reverse-middle' : 'grid-middle'; ?> bgg-c<?php echo $i; ?>">
					<header class="col-12_md-6 text-block">
						<h3 class="os-animation" data-os-animation="fadeInDown"><?php the_sub_field('title'); ?></h3>
						<span class="accent os-animation" data-os-animation="fadeIn" data-os-animation-delay=".5s"></span>
						<p class="p-large os-animation" data-os-animation="fadeInUp"><?php the_sub_field('text'); ?></p><!-- We're here, there, everywhere.  -->
					</header>

					<div class="col-12_md-6 <?php echo ( $i === 1 ) ? 'bg-dark' : 'bg-image'; ?>">

						<?php if( $i === 1 ): ?>
							<div>
								<div class="circle-sml os-animation" data-os-animation="zoomIn" data-os-animation-delay=".2s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/recycle.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-sm os-animation" data-os-animation="zoomIn" data-os-animation-delay=".3s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/card-2.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-md os-animation" data-os-animation="zoomIn" data-os-animation-delay=".2s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/shoe.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-sm os-animation" data-os-animation="zoomIn" data-os-animation-delay=".3s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/doc.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-md os-animation" data-os-animation="zoomIn" data-os-animation-delay=".5s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/toothpaste.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-sm os-animation" data-os-animation="zoomIn" data-os-animation-delay=".2s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/laptop.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-sm os-animation" data-os-animation="zoomIn" data-os-animation-delay=".5s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/bandaid.svg" alt="">
								</div>
							</div>

							<div>
								<div class="circle-md os-animation" data-os-animation="zoomIn" data-os-animation-delay=".3s">
									<img src="<?php echo get_template_directory_uri(); ?>/_img/shirt.svg" alt="">
								</div>
							</div>

						<?php else: ?>

							<?php if( $image = get_sub_field('image') ): ?>
								<img src="<?php echo $image; ?>" alt="<?php the_sub_field('title'); ?>">
							<?php endif; ?>

						<?php endif; ?>

					</div>
				</article>

			<?php $i++; endwhile; ?>

		</section>

	<?php endif; ?>

	<!-- SECTION 5 explore cta section -->
	<?php if( $btn_link = get_field('banner_button_link') ): ?>
		<section class="bg-white">
			<div class="grid">
				<div class="col-12 text-block os-animation" data-os-animation="fadeInUp">
					<span class="accent-top"></span>
					<h2><?php the_field('banner_button_title'); ?></h2>
					<a href="<?php echo $btn_link; ?>" class="btn"><?php the_field('banner_button_text'); ?></a>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part('template-parts/sub-footer'); ?>

<?php endwhile; endif; get_footer(); ?>
