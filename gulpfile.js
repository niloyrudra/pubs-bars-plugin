
var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );
var uglify = require( 'gulp-uglify' );
var autoprefixer = require( 'gulp-autoprefixer' );
var sourcemaps = require( 'gulp-sourcemaps' );
// const concat = require('gulp-concat');
const imagemin = require('gulp-imagemin');

var browserify = require( 'browserify' );
var babelify = require( 'babelify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );


var styleAdminSRC = 'src/scss/style-admin.scss';
var styleFrontSRC = 'src/scss/style-front.scss';
var styleDIST = './assets/css';
var styleWatch = 'src/scss/**/*.scss';

var jsFront = 'main-front.js';
var jsGoogleMap = 'google-map.js';
var jsSRC = 'src/js/';
var jsDIST = './assets/js';
var jsWatch = 'src/js/**/*.js';
var jsFILES = [ jsFront, jsGoogleMap ];

var imgSRC = 'images/*';


//  STYLE COMPILING
gulp.task( 'style', function(done) {

    gulp.src( [styleAdminSRC, styleFrontSRC] )
        .pipe( sourcemaps.init() )
        .pipe( sass( {
            errorLogToConsole: true,
            outputStyle: 'compressed'
        } ) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer( { 
            browsers: [ 'last 2 versions' ],
            cascade: false
        } ) )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( sourcemaps.write( './' ) )
        .pipe( gulp.dest( styleDIST ) );
        done();

} );

//  SCRIPT COMPILING
gulp.task( 'js', function(done) {

    jsFILES.map( function( entry ) {

        return browserify({
            entries: [ jsSRC + entry ]
        })
        .transform( babelify, { presets: [ 'env' ] } )
        .bundle()
        .pipe( source( entry ) )
        .pipe( rename({ extname: '.min.js' }) )
        .pipe( buffer() )
        .pipe( sourcemaps.init({ loadMaps: true }) )
        .pipe( uglify() )
        .pipe( sourcemaps.write( './' ) )
        .pipe( gulp.dest( jsDIST ) );

    } );
    done();

} );

//  IMAGE COMPILING
gulp.task( 'imagemin', (done) => {
    gulp.src( imgSRC )
        .pipe( imagemin( [
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: true},
                    {cleanupIDs: false}
                ]
            })
        ] ) )
        .pipe( gulp.dest( 'assets/images' ) );

    done();
} );


// Watch Task
gulp.task('watch', function() {
    gulp.watch( styleWatch, gulp.series( 'style' ) );
    gulp.watch( jsWatch, gulp.series( 'js' ) );
    gulp.watch( imgSRC, gulp.series( 'imagemin' ) );
});
