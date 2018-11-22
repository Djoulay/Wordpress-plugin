'use strict';

// Load Gulp...of course: cherche dans le fichier node.modules à travers package.json
var gulp         = require( 'gulp' );

// CSS related plugins : require les packages gérés par Gulp
var sass         = require( 'gulp-sass' );//Gulp gère le SASS par exemple
var autoprefixer = require( 'gulp-autoprefixer' );//compatibilité css sur tous navigateurs (ex: plus besoin de webkit...)
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );


// Project related variables : on déclare ce qu'il y a dans les dossiers
var projectURL   = 'https://test.dev';

var styleSRC     = './src/scss/mystyle.scss';
var styleURL     = './assets/';
var mapURL       = './';

var jsSRC        = './src/js/myscript.js';
var jsURL        = './assets/';

var styleWatch   = './src/scss/**/*.scss';//watch tous les **dossiers*fichiers.scss 
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';



//Concernant le CSS
gulp.task( 'styles', function() {
	gulp.src( styleSRC )//la variable passée en paramètre .scss
		.pipe( sourcemaps.init() )//pipe : contenir des actions. Initialiser le sourcemaps : fait abstraction du fichier minifier scss
		.pipe( sass({
			errLogToConsole: true,//si on a une erreur dans notre sass cela se verra sur la console
			outputStyle: 'compressed'//permet de minifier le fichier
		}) )
		.on( 'error', console.error.bind( console ) )//on: listener : affiche l'erreur dans la console
		.pipe( autoprefixer({ browsers: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
		.pipe( sourcemaps.write( mapURL ) )//fichier grâce auquel le débogueur peut faire le lien entre le code étant exécuté et les fichiers sources originaux, permettant ainsi au navigateur de reconstruire la source originale et de l'afficher dans le Débogueur.
		.pipe( gulp.dest( styleURL ) )//changement de direction vers './assets/'; contenu dans la variable styleURL : après modifications
		
});

gulp.task( 'js', function() {
	return browserify({//import du script principal
	})
	.transform( babelify, { presets: [ 'env' ] } )//babel es6 -> vers ancien JS compréhensible par tous navigateurs
	.bundle()//réunir tous le contenu des fichier js en un seul
	.pipe( source( 'myscript.js' ) )
	.pipe( buffer() )//va avec browserify : buffer=> tampon
	.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
	.pipe( sourcemaps.init({ loadMaps: true }) )
	.pipe( uglify() )//minifier le script
	.pipe( sourcemaps.write( '.' ) )
	.pipe( gulp.dest( jsURL ) )
 });

function triggerPlumber( src, url ) {
	return gulp.src( src )
	.pipe( plumber() )
	.pipe( gulp.dest( url ) );
}

//groupe toutes les taches qu'on a dans cette tache
 gulp.task( 'default', ['styles', 'js'], function() {
	gulp.src( jsURL + 'myscript.min.js' )
		.pipe( notify({ message: 'Assets Compiled!' }) );
 });


