/**
 * GULPFILE - By Architect
 */

var $           = require('gulp-load-plugins')(),
    gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    rucksack    = require('gulp-rucksack'),
    del         = require('del'),
    argv        = require('yargs').argv,
    runSequence = require('run-sequence'),
    browserSync = require('browser-sync').create(),

    // Environments
    production = !!(argv.production), // true if --production flag is used

    // Base Paths
    basePaths = {
        src: 'assets/',
        dest: 'public/wp-content/themes/lookbeyond/'
    },

    onError = function (error) {
        gutil.log(gutil.colors.red('Error (' + error.plugin + '): ' + error.message));
        this.emit('end');
    };

/**
 * @name styles
 * @description SASS - LIBSASS COMPILE, MINIFY, OUTPUT
 */
gulp.task('styles', function() {

    gulp.src(basePaths.src + 'scss/**/*.scss')
    .pipe($.plumber({errorHandler: onError}))
    .pipe($.sass({
      errLogToConsole: true,
      includePaths: ['scss']
    }))
    .pipe(rucksack())
    .pipe($.autoprefixer({
        browsers: ['last 4 versions']
    }))
    .pipe($.size({ gzip: true, showFiles: true }))
    .pipe(gulp.dest(basePaths.dest))
    .pipe($.minifyCss({ keepSpecialComments: 0 }))
    .pipe($.size({ gzip: true, showFiles: true }))
    .pipe($.rename({ extname: '.min.css' }))
    .pipe(gulp.dest(basePaths.dest));

});

/**
 * @name scripts
 * @description SCRIPTS - COMPILE, MINIFY, OUTPUT
 *    Generates both minified and unminifed versions
 */
gulp.task('scripts', function() {
    var gulpTasks = gulp.src(basePaths.src + 'js/*.js')
        .pipe($.plumber() );

    if ( ! production ) {
        gulpTasks = gulpTasks.pipe($.jshint() )
            .pipe($.jshint.reporter('default') )
            .pipe($.size({ gzip: true, showFiles: true }));
    }

    return gulpTasks
        .pipe( $.concat('scripts.js') )
        .pipe( gulp.dest(basePaths.dest + '_js') )
        .pipe( $.uglify() )
        .pipe( $.rename({ suffix: '.min' }) )
        .pipe(gulp.dest(basePaths.dest + '_js'))
});

/**
 * @name svgstore
 * @description INLINE SVG - CREATES <SYMBOL> BLOCK OF SVG GOODNESS
 */
gulp.task('svgstore', function () {
    return gulp.src(basePaths.src + 'img/svg/*.svg')
        .pipe($.svgmin())
        .pipe($.svgstore())
        .pipe(gulp.dest(basePaths.dest + '_img/svg'))
});

/**
 * @name svginject
 * @description Inject SVG Block into DOM
 */
gulp.task('svginject', function () {
    var symbols = gulp
        .src(basePaths.dest + '_img/svg/svg.svg')

    function fileContents (filePath, file) {
            return file.contents.toString();
    }

    return gulp
        .src('public/index.php')
        .pipe($.inject(symbols, { transform: fileContents }))
        .pipe(gulp.dest('public'));
});

/**
 * @name svgfallback
 * @description Create PNG sprite fallback for no-svg browsers, IE8 etc.
 */
gulp.task('svgfallback', function () {
    return gulp
        .src(basePaths.src + '/img/svg/*.svg', {base: basePaths.src + 'img/svg/'})
        .pipe($.svgfallback())
        .pipe(gulp.dest(basePaths.dest + '_img/png/sprite'))
});

/**
 * @name copyFonts
 * @description Copies fonts
 */
gulp.task('copyFonts', function () {
    return gulp.src(basePaths.src + 'fonts/*')
        .pipe(gulp.dest(basePaths.dest + '_fonts'))
});

/**
 * @name copyImages
 * @description Copies images
 */
gulp.task('images', function () {
    return gulp.src(basePaths.src + 'img/**/*')
        .pipe(gulp.dest(basePaths.dest + '_img'))
});

/**
 * @name modernizr
 * @description MOVE FROM ASSETS INTACT (BOWER v. NOT AVAILABLE)
 */
gulp.task('modernizr', function () {
    return gulp.src(basePaths.src + 'js/vendor/modernizr-custom.js')
        .pipe(gulp.dest(basePaths.dest + '_js'))
});

/**
 * @name bower
 * @description Runs bower and outputs to bower-packages
 */
gulp.task('bower', function() {
    return $.bower()
        .pipe(gulp.dest(basePaths.src + 'bower-packages'))
});

/**
 * @name vendorScripts
 * @description Gets the required bower packages and outputs to vendor.js
 */
gulp.task('vendorScripts', function() {
    var bowerPackages = [
        basePaths.src + 'bower-packages/jquery/dist/jquery.min.js',
        basePaths.src + 'bower-packages/waypoints/lib/jquery.waypoints.min.js',
        basePaths.src + 'bower-packages/angular/angular.min.js',
        basePaths.src + 'bower-packages/angular-sanitize/angular-sanitize.min.js'
    ];
    return gulp.src(bowerPackages)
        .pipe($.concat('vendor.js'))
        .pipe($.uglify() )
        .pipe(gulp.dest(basePaths.dest + '_js'));
});

/**
 * @name clean
 * @description CLEAN OUTPUT DIRECTORIES
 */
gulp.task('clean', function() {
    del(['public/_bower-packages',
         'public/_css',
         'public/_js',
         'public/_img/',
         '!public/_img/png*',
         'public/_fonts',
         ],
         { read: false })
});

/**
 * @name watch
 * @description Watches files for changes
 */
gulp.task('watch', function() {
    gulp.watch('assets/scss/**/*.scss', ['styles']);
    gulp.watch('assets/js/*.js', ['scripts']);
    gulp.watch('assets/img/*', ['images']);
});

/**
 * @name default
 * @description Default 'gulp' task. Runs a sequence depending on environment
 */
gulp.task('default', ['clean'], function(cb) {
  if ( ! production )
    runSequence( 'bower', 'styles', 'vendorScripts', 'scripts', 'modernizr', 'images', 'copyFonts', ['svgstore'], 'svginject', 'svgfallback', cb);
  else
    runSequence( 'bower', 'styles', 'vendorScripts', 'scripts', 'modernizr', 'images', 'copyFonts', ['svgstore'], 'svginject', cb);
});
