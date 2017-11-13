import gulp from "gulp";
import del from "del";
import newer from "gulp-newer";
import sass from "gulp-sass";
import plumber from "gulp-plumber";
import notify from "gulp-notify";
import autoprefixer from "gulp-autoprefixer";
import csso from "gulp-csso";
import postcss from "gulp-postcss";
import mqpacker from "css-mqpacker";
import source from "vinyl-source-stream";
import buffer from "vinyl-buffer";
import browserify from "browserify";
import babel from "babelify";
import browser from "browser-sync";
import spriteSmith from "gulp.spritesmith";
import uglify from "gulp-uglify";
import svgo from "gulp-svgo";
import gulpSequence from "gulp-sequence";
import svgSprite from "gulp-svg-sprite";
import gRename from "gulp-rename";
import sourcemap from "gulp-sourcemaps";

let browserSync = browser.create();

gulp.task('build', ['clean'], cb => {
	gulpSequence(
		'fonts',
		'images',
		'styles',
		'scripts',
		'sprite:svg',
		cb
	);
});

gulp.task('fonts', () => {
	return gulp.src(['src/styles/fonts/**/*'])
		.pipe(newer('assets/styles/fonts'))
		.pipe(gulp.dest('assets/styles/fonts'));
});

gulp.task('scripts', () => {
	gulp.src([
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'node_modules/popper.js/dist/umd/popper.min.js',
	])
		.pipe(newer('assets/scripts/lib'))
		.pipe(gulp.dest('assets/scripts/lib'));

	gulp.src([
		'node_modules/jquery-pjax/jquery.pjax.js',
	])
		.pipe(newer('assets/scripts/lib'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/scripts/lib'));

	return browserify('src/main.js')
		.transform(babel)
		.bundle().on('error', notify.onError())
		.pipe(source('main.js'))
		.pipe(buffer())
		.pipe(uglify())
		.pipe(gulp.dest('assets/scripts'));
});

gulp.task('styles', () => {
	return gulp.src('src/main.scss')
		.pipe(plumber({
			errorHandler: notify.onError()
		}))
		.pipe(sourcemap.init())
		.pipe(sass())
		.pipe(autoprefixer([
			'last 2 version', '> 1%'
		]))
		.pipe(postcss([
			mqpacker({
				sort: true
			}),
		]))
		.pipe(csso())
		.pipe(sourcemap.write('./'))
		.pipe(gulp.dest('assets/styles'))
		.pipe(browserSync.stream());
});

gulp.task('sprite:png', () => {
	let data = gulp.src('src/images/sprite/png/*')
		.pipe(spriteSmith({
			imgName: 'sprite.png',
			cssName: 'sprite.scss',
			algorithm: 'binary-tree',
			cssTemplate: 'src/config/spritesmith.conf',
			cssVarMap: function (sprite) {
				sprite.name = 's-' + sprite.name
			}
		}));
	data.img.pipe(gulp.dest('assets/images'));
	data.css.pipe(gulp.dest('src/styles/mixins'));
});

gulp.task('sprite:svg', () => {
	"use strict";
	return gulp.src('src/images/sprite/svg/*')
		.pipe(svgSprite({
			mode: {
				symbol: {
					inline: true,
					dest: 'images',
				},
			}
		}))
		.pipe(gRename('sprite.svg'))
		.pipe(gulp.dest('assets/images'));
});

gulp.task('images', () => {
	return gulp.src(['src/images/**/*', '!src/images/{sprite,sprite/**}'])
		.pipe(newer('assets/images'))
		.pipe(svgo())
		.pipe(gulp.dest('assets/images'));
});

gulp.task('clean', () => {
	return del('assets/*');
});

gulp.task('watch', ['build'], () => {
	browserSync.init({
		notify: false,
		open: false,
		browser: 'chrome.exe',
		proxy: 'starter.loc',
		port: 3998,
		ui: {
			port: 3999
		}
	});

	gulp.watch('src/**/*.scss', ['styles']);
	gulp.watch('src/**/*.js', ['scripts']);
	gulp.watch('src/images/*.*', ['images']);
	gulp.watch('src/images/sprite/png/*.*', ['sprite:png']);
	gulp.watch('src/images/sprite/svg/*.*', ['sprite:svg']);

	gulp.watch(['assets/{images,scripts}/**/*.*', '**/*.php', '!inc/**/*.php'], browserSync.reload);
});
