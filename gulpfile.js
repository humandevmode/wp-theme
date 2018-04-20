const gulp = require('gulp');
const del = require('del');
const newer = require('gulp-newer');
const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const autoprefixer = require('gulp-autoprefixer');
const csso = require('gulp-csso');
const postcss = require('gulp-postcss');
const mqpacker = require('css-mqpacker');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const browserify = require('browserify');
const babel = require('babelify');
const browser = require('browser-sync');
const spriteSmith = require('gulp.spritesmith');
const uglify = require('gulp-uglify');
const svgo = require('gulp-svgo');
const gulpSequence = require('gulp-sequence');
const svgSprite = require('gulp-svg-sprite');
const rename = require('gulp-rename');
const sourcemap = require('gulp-sourcemaps');
const watch = require('gulp-watch');

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

let scripts = function () {
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
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(newer('assets/scripts/lib'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/scripts/lib'));

	return browserify('src/main.js')
		.transform(babel)
		.bundle().on('error', notify.onError())
		.pipe(source('main.min.js'))
		.pipe(buffer())
		.pipe(uglify())
		.pipe(gulp.dest('assets/scripts'));
};

let styles = function () {
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
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('assets/styles'))
		.pipe(browserSync.stream());
};

let images = function () {
	return gulp.src(['src/images/**/*', '!src/images/{sprite,sprite/**}'])
		.pipe(newer('assets/images'))
		.pipe(svgo())
		.pipe(gulp.dest('assets/images'));
};

let spritePng = function () {
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
};

let spriteSvg = function () {
	return gulp.src('src/images/sprite/svg/*')
		.pipe(svgSprite({
			mode: {
				defs: {}
			},
			svg: {
				xmlDeclaration: false,
				namespaceIDs: false
			}
		}))
		.pipe(rename('sprite.svg'))
		.pipe(gulp.dest('assets/images'));
};

gulp.task('scripts', scripts);
gulp.task('styles', styles);
gulp.task('images', images);
gulp.task('sprite:png', spritePng);
gulp.task('sprite:svg', spriteSvg);

gulp.task('clean', () => {
	return del('assets/*');
});

gulp.task('watch', ['build'], () => {
	browserSync.init({
		notify
			: false,
		open: false,
		browser: 'chrome.exe',
		proxy: 'starter.loc',
		port: 3998,
		ui: {
			port: 3999
		}
	});

	watch('./src/**/*.js', scripts);
	watch('./src/**/*.scss', styles);
	watch('./src/images/*.*', images);
	watch('./src/images/sprite/png/*.*', spritePng);
	watch('./src/images/sprite/svg/*.*', spriteSvg);
	watch(['./assets/{images,scripts}/**/*.*', './views/**/*.blade.php'], browserSync.reload);
});
