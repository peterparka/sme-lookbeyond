<?php get_header();

if( have_posts() ): while( have_posts() ): the_post(); ?>

		<?php // For some reason has_category only works if we have run get_the_terms
		$term = get_the_terms( $post->ID, 'category' )[0]; ?>

		<!-- WRAPPER -->
		<main role="main">

			<?php get_template_part('template-parts/nav'); ?>

			<section class="bg-white no-pad article">

				<?php if( has_post_thumbnail() && !has_category(['video', 'infographic']) ): ?>
					<div class="hero">
						<img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
					</div>
				<?php endif; ?>

				<article class="os-animation<?php echo ( has_category('infographic') ) ? ' post-infographic' : ' post-article'; ?>">
					<h3><?php the_title(); ?></h3>
					<h5><?php the_date('F j, Y'); ?></h5>
					<?php get_template_part('template-parts/share'); ?>
					<?php the_content();

					if( $url = get_field('video_url') )
					{
						if (strpos($url, 'youtu') !== false) {

							$pattern = '/youtu(be\.com|\.be)\/(embed\/|v\/|watch\?v=)?(?<code>[a-zA-Z0-9_]+)/i';
							$matches = [];

							if (preg_match($pattern, $url, $matches) !== false)
							{
								if(isset($matches['code'])): ?>

									<div class="video-wrapper-wrapper">
										<div class="video-wrapper">
											<!-- <iframe src="https://www.youtube.com/embed/<?php echo $matches['code']; ?>" frameborder="0" allowfullscreen></iframe> -->
											<iframe src="https://www.youtube.com/embed/<?php echo $matches['code']; ?>" width="" height="" frameborder="0" allowfullscreen></iframe>
										</div>
									</div>

								<?php endif;
							}
							else {

								echo '<p>Invalid YouTube Url</p>';
							}
						}

						elseif ( strpos($url, 'vimeo') !== false ) {

							$pattern = '/vimeo\.com(\/video)?\/(?<code>\d+)/i';

							$matches = [];

							if (preg_match($pattern, $url, $matches) !== false)
							{
								if(isset($matches['code'])): ?>

								<div class="video-wrapper-wrapper">
									<div class="video-wrapper">
										<iframe src="https://player.vimeo.com/video/<?php echo $matches['code']; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									</div>
								</div>

								<?php endif;
							}
							else {
								echo '<p>Invalid Vimeo Url</p>';
							}
						}

						else {
							echo '<p>Unrecognised Video Url</p>';
						}
					}

					//get_template_part('template-parts/article-category-tags');
					include(locate_template('template-parts/article-category-tags.php'));

					get_template_part('template-parts/share');

					?>

				</article>

			</section>


			<?php global $wp_query;

			$args = array(
				//'cat' => 'category',
				'tag__in' => $tags_ids,
				'posts_per_page' => 3,
				'post__not_in' => [ get_the_ID() ]
			);

			$posts = get_posts($args);

			if( !empty( $posts ) ): ?>

				<section class="bg-shaded box-wrap">

					<h4>Related Content</h4>

					<ul class="row-no-max grid-center">

						<?php include( locate_template( 'template-parts/article-thumbs.php' )); ?>

					</ul>

				</section>

			<?php endif; ?>

<?php endwhile; endif; get_footer(); ?>
