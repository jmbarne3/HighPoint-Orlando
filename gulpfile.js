const browserSync = require('browser-sync').create();
const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const include = require('gulp-include');
const eslint = require('gulp-eslint');
const isFixed = require('gulp-eslint-if-fixed');
const babel = require('gulp-babel');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const scsslint = require('gulp-scss-lint');
const uglify = require('gulp-uglify');
const merge = require('merge');


const configLocal = require('./gulp-config.json');
const configDefault = {
  src: {
    scssPath: './src/scss',
    jsPath:   './src/js'
  },
  dist: {
    cssPath:  './static/css',
    jsPath:   './static/js',
    fontPath: './static/fonts'
  },
  devPath: './dev',
  packagesPath: './node_modules',
  sync: false,
  syncTarget: 'http://localhost/'
};
const config = merge(configDefault, configLocal);


//
// Installation of components/dependencies
//

// Copy Font Awesome files
gulp.task('move-components-fontawesome', (done) => {
  gulp.src(`${config.packagesPath}/font-awesome/fonts/**/*`)
    .pipe(gulp.dest(`${config.dist.fontPath}/font-awesome`));
  done();
});

// Run all component-related tasks
gulp.task('components', gulp.parallel(
  'move-components-fontawesome'
));


//
// CSS
//

// Base linting function
function lintSCSS(src) {
  return gulp.src(src)
    .pipe(scsslint({
      maxBuffer: 400 * 1024 // default: 300 * 1024
    }));
}

// Lint all theme scss files
gulp.task('scss-lint-theme', () => {
  return lintSCSS(`${config.src.scssPath}/*.scss`);
});

// Base SCSS compile function
function buildCSS(src, dest) {
  dest = dest || config.dist.cssPath;

  return gulp.src(src)
    .pipe(sass({
      includePaths: [config.src.scssPath, config.packagesPath]
    })
      .on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(autoprefixer({
      // Supported browsers added in package.json ("browserslist")
      cascade: false
    }))
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest(dest))
    .pipe(browserSync.stream());
}

// Compile theme stylesheet
gulp.task('scss-build-theme', () => {
  return buildCSS(`${config.src.scssPath}/style.scss`);
});

gulp.task('scss-build-editor', () => {
  return buildCSS(`${config.src.scssPath}/editor.scss`);
});

// All theme css-related tasks
gulp.task('css', gulp.series('scss-lint-theme', 'scss-build-theme', 'scss-build-editor'));


//
// JavaScript
//

// Run eshint on js files in src.jsPath. Do not perform linting
// on vendor js files.
gulp.task('es-lint', () => {
  return gulp.src([`${config.src.jsPath}/*.js`])
    .pipe(eslint({
      fix: true
    }))
    .pipe(eslint.format())
    .pipe(isFixed(config.src.jsPath));
});

// Concat and uglify js files through babel
gulp.task('js-build', () => {
  return gulp.src(`${config.src.jsPath}/script.js`)
    .pipe(include({
      includePaths: [config.packagesPath, config.src.jsPath]
    }))
    .on('error', console.log) // eslint-disable-line no-console
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename('script.min.js'))
    .pipe(gulp.dest(config.dist.jsPath));
});

// All js-related tasks
gulp.task('js', gulp.series('es-lint', 'js-build'));


//
// Rerun tasks when files change
//
gulp.task('watch', () => {
  if (config.sync) {
    browserSync.init({
      proxy: {
        target: config.syncTarget
      }
    });
  }

  gulp.watch(`${config.src.scssPath}/**/*.scss`, gulp.series('css'));
  gulp.watch(`${config.src.jsPath}/**/*.js`, gulp.series('js')).on('change', browserSync.reload);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
});


//
// Default task
//
gulp.task('default', gulp.series('components', 'css', 'js'));
