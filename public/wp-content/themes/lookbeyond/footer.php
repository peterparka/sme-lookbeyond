	<footer class="bg-dark">

			<div class="row grid-center os-animation" data-os-animation="fadeInUp">

				<div class="col-12_md-4">
			    <a href="/" class="logo"><h4>Look<br /> Beyond</h4></a>
				</div>

				<div class="col-12_md-4 bold">
					<a href="/explore/">Explore</a>
					<!-- <a href="">Play</a> -->
					<a href="/contact">Contact</a>
				</div>

				<div class="col-12_md-4 bold">
					<!-- <a href=""><img src="<?php echo get_template_directory_uri(); ?>/_img/facebook.svg" alt="">Facebook</a>
					<a href=""><img src="<?php echo get_template_directory_uri(); ?>/_img/instagram.svg" alt="">Instagram</a> -->

					<?php if( $twitter_url = get_field('twitter_url', 'option') ): ?>
					    <a href="https://twitter.com/<?php echo $twitter_url; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/_img/twitterfoot.svg" alt="Twitter">Twitter</a>
					<?php endif; ?>


				</div>

			</div>

			<div class="row-no-max copyright">
					<div class="row grid-2">
								<a href="/privacy-policy">Privacy Policy</a>
								<a href="/terms">Terms of Use</a>
					</div>
			</div>

	</footer>

		<!-- end main -->
	</main>

		<!-- Scripts -->
			<script src="<?php echo get_template_directory_uri(); ?>/_js/vendor.js"></script>
		  <!-- <script src="<?php echo get_template_directory_uri(); ?>/_js/scripts.min.js"></script> -->
      <!-- <script>window.jQuery || document.write('<script src="_js/vendor/jquery-1.11.1.min.js"><\/script>')</script> -->
        <?php wp_footer(); ?>

        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58139494abf442c3"></script>
    </body>
</html>
