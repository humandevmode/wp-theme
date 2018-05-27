const del = require('del');
const gulp = require('gulp');
const newer = require('gulp-newer');
const browser = require('browser-sync');
const uglify = require('gulp-uglify');
const svgo = require('gulp-svgo');
const notify = require('gulp-notify');
const gulpSequence = require('gulp-sequence');
const svgSprite = require('gulp-svg-sprite');
const rename = require('gulp-rename');
const watch = require('gulp-watch');
const webpack = require('webpack');
const gutil = require('gulp-util');
const webpackHotMiddleware = require('webpack-hot-middleware');
const webpackDevMiddleware = require('webpack-dev-middleware');
const path = require('path');
const config = require('./config');

const browserSync = browser.create();

gulp.task('watch', ['prepare'], () => {
	let webpack_config = require('./src/config/webpack.dev');
	const compiler = webpack(webpack_config);

	browserSync.init({
		ui: false,
		open: false,
		notify: false,
		port: config.browserSync.port,
		proxy: {
			target: config.browserSync.proxy.target,
			proxyReq: [
				function (proxyReq) {
					proxyReq.setHeader('X-BrowserSync', 'true');
				}
			]
		},
		files: [
			'./*.php',
			'./src/blocks/**/*.php',
		],
		ghostMode: false,
		middleware: [
			webpackDevMiddleware(compiler, {
				publicPath: webpack_config.output.publicPath,
				hot: true
			}),
			webpackHotMiddleware(compiler),
		],
	});

	watch('./src/images/*.*', images);
	watch('./src/**/images/sprite/*.svg', spriteSvg);
});

gulp.task('prepare', done => {
	gulpSequence(
		'clean',
		'images',
		'js:libs',
		'sprite:svg',
		done
	);
});

gulp.task('build', done => {
	gulpSequence(
		'prepare',
		'webpack',
		done
	);
});

gulp.task('images', images);
gulp.task('js:libs', scripts);
gulp.task('sprite:svg', spriteSvg);

gulp.task('clean', () => {
	return del('assets/*')
});

gulp.task('webpack', function (done) {
	webpack(require('./src/config/webpack.prod'), function (error, stats) {
		if (error) {
			onError(error);
		} else if (stats.hasErrors()) {
			onError(stats.toString({
				colors: true,
				reasons: true
			}));
		} else {
			onSuccess(stats.toString({
				colors: true,
				reasons: true
			}));
		}
	});

	function onError(error) {
		let formattedError = new gutil.PluginError('webpack', error);
		notify({
			title: `Error: ${formattedError.plugin}`,
			message: formattedError.message
		});
		done(formattedError);
	}

	function onSuccess(detailInfo) {
		gutil.log('[webpack]', detailInfo);
		done();
	}
});

function scripts() {
	gulp.src([
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'node_modules/popper.js/dist/umd/popper.min.js',
		'node_modules/select2/dist/js/select2.min.js',
		'node_modules/selectric/public/jquery.selectric.min.js',
	])
		.pipe(gulp.dest('assets/scripts/lib'));

	return gulp.src([
		'node_modules/jquery-pjax/jquery.pjax.js',
	])
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(uglify())
		.pipe(gulp.dest('assets/scripts/lib'));
}

function images() {
	return gulp.src([
		'src/images/*',
		'!src/images/sprite',
		'!src/images/sprite/**'
	])
		.pipe(newer('assets/images'))
		.pipe(svgo())
		.pipe(gulp.dest('assets/images'));
}

function spriteSvg() {
	return gulp.src([
		'src/**/images/sprite/*.svg',
	])
		.pipe(svgSprite({
			mode: {
				defs: {}
			},
			svg: {
				xmlDeclaration: false,
				namespaceIDs: false
			},
			shape: {
				id: {
					generator(name) {
						let parts = name.split('/');
						if (parts[0] === 'blocks') {
							return parts[1] + '__' + path.basename(name, '.svg');
						}

						return path.basename(name, '.svg');
					}
				},
			},
		}))
		.pipe(rename('sprite.svg'))
		.pipe(gulp.dest('assets/images'));
}
