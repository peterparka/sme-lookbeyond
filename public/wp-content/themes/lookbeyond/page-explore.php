<?php
/*
Template Name: Explore
*/
get_header();

if( have_posts() ): while( have_posts() ): the_post(); ?>

<!-- WRAPPER -->
<main role="main" ng-app="filterApp" ng-controller="FilterCtl">

	<?php get_template_part('template-parts/nav'); ?>

	<!-- HERO  -->
	<section class="hero-alt bg-white">

		<div class="row hero-text grid-middle os-animation" data-os-animation="fadeInUp">
			<h1 class="col-12-bottom">Look Beyond</h1>
			<div class="p-large">
				<?php the_content(); ?>
			</div>
		</div>
	</section>


	<?php if( $posts = get_field('featured_articles') ): ?>

		<section class="bg-shaded no-pad box-wrap">

			<ul class="row-no-max grid-center featured">

				<?php include( locate_template( 'template-parts/article-thumbs.php' )); ?>

			</ul>
		</section>

	<?php endif; ?>



	<!-- SECTION 1 -->
	<section class="bg-shaded no-pad" ng-cloak>

		<div class="row-no-max grid-spaceBetween filters-wrap">

			<div class="col grid-middle">

				<div ng-if="filters[0].has_all_button"
					ng-class="{ 'selected': filters[0].allActive }"
					ng-click="filters[0].allActive = true; clear.all();"
					class="col filter">
					<h5>All Types</h5>
				</div>

				<div ng-repeat="option in filters[0].options track by $index"
					 ng-click="filters[0].allActive = false; clear.all(); changeFilter( filters[0].name, option )"
					 ng-class="{ 'selected': option.active }"
					 class="col filter filter--{{ option.name }}">

					<svg ng-if="option.name === 'article'" class="nc-icon content-type outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
						<g transform="translate(0.5, 0.5)" class="icon">
							<rect x="6" y="2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="36" height="44" stroke-linejoin="round"/>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="30" y1="12" x2="34" y2="12" stroke-linejoin="round"/>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="30" y1="20" x2="34" y2="20" stroke-linejoin="round"/>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="14" y1="28" x2="34" y2="28" stroke-linejoin="round"/>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="14" y1="36" x2="34" y2="36" stroke-linejoin="round"/>
							<rect data-color="color-2" x="14" y="12" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="8" stroke-linejoin="round"/>
						</g>
					</svg>

					<svg ng-if="option.name === 'video'" class="nc-icon content-type outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
						<g transform="translate(0.5, 0.5)" >
							<rect x="2" y="2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="44" height="44" stroke-linejoin="round"></rect>
							<polygon data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" points="
						18,10 30,18 18,26 " stroke-linejoin="round"></polygon>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="36" y1="36" x2="40" y2="36" stroke-linejoin="round"></line>
							<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="8" y1="36" x2="22" y2="36" stroke-linejoin="round"></line>
							<circle data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" cx="26" cy="36" r="4" stroke-linejoin="round"></circle>
						</g>
					</svg>

					<svg ng-if="option.name === 'infographic'" class="nc-icon content-type  outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
						<g transform="translate(0.5, 0.5)">
							<rect data-color="color-2" x="16" y="24" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="18" stroke-linejoin="round"></rect>
							<rect data-color="color-2" x="2" y="32" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="10" stroke-linejoin="round"></rect>
							<polygon fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" points="34,6 26,16 30,16
								30,42 38,42 38,16 42,16 " stroke-linejoin="round"></polygon>
						</g>
					</svg>

					<h5 ng-bind-html="option.display_name"></h5>
				</div>
				<!-- <div class="col filter">
					<?php get_template_part('template-parts/icon-infographic'); ?>
					<h5>Infographic</h5>
				</div>
				<div class="col filter">
					<?php get_template_part('template-parts/icon-article'); ?>
					<h5>Article</h5>
				</div> -->
			</div>

			<div class="col grid-middle">

				<div ng-if="filters[1].has_all_button"
					ng-class="{ 'selected': filters[1].allActive }"
					ng-click="filters[1].allActive = true; clear.all();"
					class="col filter">
					<h5>All Themes</h5>
				</div>

				<div ng-repeat="option in filters[1].options track by $index"
					 ng-click="filters[1].allActive = false; clear.all(); changeFilter( filters[1].name, option )"
					 ng-class="{ 'selected': option.active }"
					 class="col filter filter--{{ filters[1].name }}">
					<h5 ng-bind-html="option.display_name"></h5>
				</div>
				<!-- <div class="col filter">
					<h5>Look Again</h5>
				</div>
				<div class="col filter">
					<h5>Look Back</h5>
				</div> -->
			</div>

			<div class="col grid-middle">

				<div ng-repeat="option in filters[2].options track by $index"
					 ng-click="filters[2].allActive = false; clear.all(); changeFilter( filters[2].name, option )"
					 ng-class="{ 'selected': option.active }"
					 class="col filter filter--{{ filters[2].name }}">

					<?php get_template_part('template-parts/icon-heart'); ?>
					<h5 ng-bind-html="option.display_name"></h5>
				</div>

		</div>
	</section>

	<!-- SECTION 2 -->
	<section class="bg-shaded no-pad box-wrap">

		<ul class="row-no-max grid-center">

			<li class="col" ng-repeat="article in filteredItems | limitTo: limit" ng-cloak>

				<!-- <p>{{ article.category.slug }}</p> -->

				<a href="{{ article.link_url }}">
					<article>

						<div class="box-image">
							<img ng-if="article.image_url" ng-src="{{ article.image_url }}" alt="{{ article.title }}" >
						</div>

						<div>

							<div class="grid-middle">
								<?php // get_template_part('template-parts/icon-article'); <img ng-src="/wp-content/themes/lookbeyond/_img/icon-{{ article.category.slug }}.svg"> ?>

								<svg ng-if="article.category.slug === 'article'" class="nc-icon content-type outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
									<g transform="translate(0.5, 0.5)" class="icon">
										<rect x="6" y="2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="36" height="44" stroke-linejoin="round"/>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="30" y1="12" x2="34" y2="12" stroke-linejoin="round"/>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="30" y1="20" x2="34" y2="20" stroke-linejoin="round"/>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="14" y1="28" x2="34" y2="28" stroke-linejoin="round"/>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="14" y1="36" x2="34" y2="36" stroke-linejoin="round"/>
										<rect data-color="color-2" x="14" y="12" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="8" stroke-linejoin="round"/>
									</g>
								</svg>

								<svg ng-if="article.category.slug === 'video'" class="nc-icon content-type outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
									<g transform="translate(0.5, 0.5)" >
										<rect x="2" y="2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="44" height="44" stroke-linejoin="round"></rect>
										<polygon data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" points="
									18,10 30,18 18,26 " stroke-linejoin="round"></polygon>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="36" y1="36" x2="40" y2="36" stroke-linejoin="round"></line>
										<line data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" x1="8" y1="36" x2="22" y2="36" stroke-linejoin="round"></line>
										<circle data-color="color-2" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" cx="26" cy="36" r="4" stroke-linejoin="round"></circle>
									</g>
								</svg>

								<svg ng-if="article.category.slug === 'infographic'" class="nc-icon content-type  outline" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48">
									<g transform="translate(0.5, 0.5)">
										<rect data-color="color-2" x="16" y="24" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="18" stroke-linejoin="round"></rect>
										<rect data-color="color-2" x="2" y="32" fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" width="8" height="10" stroke-linejoin="round"></rect>
										<polygon fill="none" stroke="" stroke-width="" stroke-linecap="round" stroke-miterlimit="10" points="34,6 26,16 30,16
											30,42 38,42 38,16 42,16 " stroke-linejoin="round"></polygon>
									</g>
								</svg>

								<span ng-repeat="tag in article.tags_full" class="theme-{{ tag.slug }}">{{ tag.name }}</span>

							</div>

							<div class="grid col-12">
								<h4 class="col-12">{{ article.title }}</h4>
								<span class="grid-left col-8">{{ article.date }}</span>
								<div class="grid-right col-4">
									<span class="col">{{ article.favourites }}</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>

			<?php /*

			<li class="col">
				<a href="/article/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-innovation.jpg" alt="nintendo" >
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-article'); ?>
								<span class="theme-2">Look Again</span>
							</div>

							<div class="grid">
								<h4 class="col-12">More than fuel: How oil and gas products are driving innovation</h4>
								<span>June 16, 2016</span>
								<div class="grid-right">
									<span>200</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>


			<li class="col">
				<a href="/article/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-quiz.jpg" alt="nintendo" >
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-article'); ?>
								<span class="theme-1">Look Around</span>
							</div>

							<div class="grid">
								<h4 class="col-12">Quiz: These items have one surprising thing in common. How many have you used already today?</h4>
								<span>April 22, 2016</span>
								<div class="grid-right">
									<span>106</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>


			<li class="col">
				<a href="/article-video/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-music-2.jpg" alt="" >
							<!-- <img src="<?php echo get_template_directory_uri(); ?>/_img/play.svg" alt="play" class="play"> -->
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-video'); ?>
								<span class="theme-1">Look Around</span>
								<span class="theme-3">Look Back</span>
							</div>

							<div class="grid">
								<h4 class="col-12">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sit amet </h4>
								<span>April 16, 2016</span>
								<div class="grid-right">
									<span>102</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>

			<li class="col">
				<a href="/article-infographic/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-infographic.jpg" alt="" >
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-infographic'); ?>
								<span class="theme-3">Look Back</span>
							</div>

							<div class="grid">
								<h4 class="col-12">Etiam facilisis sapien nec elit sodales, ac accumsan lacus vestibulum</h4>
								<span>March 16, 2016</span>
								<div class="grid-right">
									<span>49</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>

			<li class="col">
				<a href="/article/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-misc.jpg" alt="nintendo" >
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-article'); ?>
								<span class="theme-1">Look Around</span>
							</div>

							<div class="grid">
								<h4 class="col-12">Fusce pellentesque porta lorem, ut convallis elit volutpat eusce pellentesque</h4>
								<span>March 6, 2016</span>
								<div class="grid-right">
									<span>106</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li>

			<li class="col">
				<a href="/article/">
					<article>

						<div class="box-image">
							<img src="<?php echo get_template_directory_uri(); ?>/_img/article-90s-2.jpg" alt="nintendo" >
						</div>

						<div>

							<div class="grid-middle">
								<?php get_template_part('template-parts/icon-article'); ?>
								<span class="theme-1">Look Around</span>
								<span class="theme-2">Look Again</span>
							</div>

							<div class="grid">
								<h4 class="col-12">Fusce pellentesque porta lorem, ut convallis elit volutpat eu.</h4>
								<span>Feb 2, 2016</span>
								<div class="grid-right">
									<span>106</span>
									<?php get_template_part('template-parts/icon-heart'); ?>
								</div>
							</div>

						</div>

					</article>
				</a>
			</li> */ ?>

		</ul>

		<p ng-if="filteredItems.length === 0 && !staticListShowing"
			ng-cloak
			class="no-results">There are no items for this search criteria.</p>

		<div class="center">

			<div ng-show="limit < filteredItems.length"
				ng-click="loadMore()"
				ng-cloak
				class="btn load-more">
				<span>Load more</span>
			</div>
		</div>

		<!-- <div class="row grid-center">
			<div class="col scroll-prompt">
				<h5>Scroll</h5>
				<img src="<?php echo get_template_directory_uri(); ?>/_img/scroll.svg" alt="scroll">
			</div>
		</div> -->
	</section>

<?php endwhile; endif; get_footer(); ?>
