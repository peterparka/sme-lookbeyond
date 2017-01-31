<!-- SECTION 6 pre footer section -->
<section class="prefooter bg-white">

	<div class="row-no-max grid-1_md-3 lb-colors">

		<?php if( have_rows('footnote_ctas') ): while( have_rows('footnote_ctas') ) : the_row(); ?>

			<article class="col">
				<h4><?php the_sub_field('title'); ?></h4>
					<p class="p-large"><?php the_sub_field('text'); ?></p>

					<?php if( $link = get_sub_field('link') ): ?>
						<a href="<?php echo $link; ?>"><?php get_template_part('template-parts/icon-arrow-right'); ?></a>
					<?php endif; ?>
			</article>

				<!-- <article class="col">
					<h4>Explore</h4>
						<p class="p-large">Something about the Explore Page. Explore many things and learn more.</p>
						<a href="/explore"><?php get_template_part('template-parts/icon-arrow-right'); ?></a>
				</article>

				<article class="col">
					<h4>Contact Us</h4>
					<p class="p-large">Want to learn more about something? Send us a message to find out more.</p>
					<a href="/contact"><?php get_template_part('template-parts/icon-arrow-right'); ?></a>
				</article> -->

		<?php endwhile; endif; ?>


		<article class="col" id="twitter-feed">
			<?php

			if( function_exists('getTweets') ):

				$tweets = getTweets(2, get_field('twitter_url', 'option') ); // lookbeyond_org

				foreach($tweets as $tweet): ?>

					<h5><img src="<?php echo get_template_directory_uri(); ?>/_img/twitter.svg" alt=""> <?php echo twitter_time_ago($tweet['created_at']); ?></h5>
					<p><?php echo $tweet['text']; ?></p>

				<?php endforeach;

			endif; ?>

			<?php /* @todo - twitter feeds
			<h5><img src="<?php echo get_template_directory_uri(); ?>/_img/twitter.svg" alt=""> 2 hours ago</h5>
			<p>Do you know what it’s made of? Discover what goes into the everyday products you use at... http://fb.me/7gEVurl3V</p>
			<h5><img src="<?php echo get_template_directory_uri(); ?>/_img/twitter.svg" alt="">2 hours ago</h5>
			<p>Do you know what it’s made of? Discover what goes into the everyday products you use at... http://fb.me/7gEVurl3V</p>
			*/ ?>
		</article>

	</div>

</section>
