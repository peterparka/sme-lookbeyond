
<?php foreach($posts as $post):

	setup_postdata( $post );?>

	<li class="col">
		<a href="<?php the_permalink(); ?>">
			<article>

				<div class="box-image">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
				</div>

				<div>

					<?php $category = get_the_terms( get_the_ID(), 'category' )[0];

					if( $category ): ?>

						<div class="grid-middle">

							<?php get_template_part('template-parts/icon-' . $category->slug ); ?>

							<?php $tags = get_the_tags();

							if( $tags ) {

								foreach($tags as $tag): ?>

									<span class="theme-<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></span>

								<?php endforeach;
							} ?>
						</div>

					<?php endif; ?>

					<div class="grid">

						<h4 class="col-12"><?php the_title(); ?></h4>
						<span><?php echo get_the_date('F j, Y'); ?></span>

						<?php $likes = (int) get_post_meta( get_the_ID(), 'vortex_system_likes', true ); ?>

						<div class="grid-right">
							<span><?php echo $likes; ?></span>
							<?php get_template_part('template-parts/icon-heart'); ?>
						</div>
					</div>

				</div>

			</article>
		</a>
	</li>

<?php endforeach;
wp_reset_postdata(); ?>
