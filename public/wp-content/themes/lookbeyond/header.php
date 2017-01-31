<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?php wp_title(); ?></title>

        <script src="https://use.typekit.net/zvq3vtk.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Humans.txt -->
        <link type="text/plain" rel="author" href="/humans.txt" />
        <!-- Favicon -->
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/_img/sme-favicon.ico" type='image/x-icon'/ >

        <?php wp_head(); ?>

        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-86477149-1', 'auto');
        ga('send', 'pageview');

        </script>
    </head>
    <body <?php body_class(); ?>>
