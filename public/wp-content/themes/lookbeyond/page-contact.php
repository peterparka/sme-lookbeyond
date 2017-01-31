<?php
/*
Template Name: Contact
*/
get_header();

if( have_posts() ): while( have_posts() ): the_post(); ?>
<!-- WRAPPER -->
	<div class="wrapper">

		<?php get_template_part('template-parts/nav'); ?>

		<!-- HERO  -->
		<section class="hero-alt bg-white">

				<div class="row grid-middle">
				<h2 class="col-12-bottom pad-top">Get In Touch</h2>
				<div class="col-12-top p-large">
					<?php the_content(); ?>
				</div>
				<!-- <a class="col-12-top" href=""><p class="col-12-top p-xlarge">email@smenergy.com</p></a> -->
			</div>

		</section>

		<!-- SECTION 1 -->
		<section class="no-pad">

			<ol class="form grid-center-middle">

				<li class="js-3 active">

					<div class="step-content">

						<?php echo do_shortcode('[CONTACT_FORM_TO_EMAIL id="1"]'); ?>

						<?php /*
						<form>

							<label for="first-name" placeholder="Your first name">First name</label>
							<input type="text" id="first-name" name="first-name" value="" required>

							<label for="last-name" placeholder="Your last name">Last name</label>
							<input type="text" id="last-name" name="last-name" value="" required>

							<label for="email" placeholder="Email">Email</label>
							<input type="text" id="email" name="email" value="" required>

							<label for="twitter" placeholder="Address">Comments</label>
							<input type="text" id="comments" name="comments" value="">

							<div id="btn-attendee-info" data-name="js-review-pay"><input type="submit" class="btn" value="Submit"><i class="nc-icon-outline arrows-2_small-right"></i></a></div>
							<!-- <div id="btn-attendee-info" data-name="js-review-pay"><a href="" class="btn" >Submit<i class="nc-icon-outline arrows-2_small-right"></i></a></div> -->

						</form> */ ?>

						<p class="p-xsmall"><?php the_field('submit_button_small_print'); ?></p>
					</div>
				</li>
			</ol>
		</section>
	</div>

<?php get_template_part('template-parts/sub-footer'); ?>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
