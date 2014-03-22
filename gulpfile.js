// Require plugins.
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    notify = require('gulp-notify'),
    scss = require('gulp-ruby-sass'),
    autoprefix = require('gulp-autoprefixer'),
    coffee = require('gulp-coffee'),
    jshint = require('gulp-jshint');

// Config
var scssDir = 'public/assets/scss', // Where do you store your SCSS files?
    targetCSSDir = 'public/assets/css', // Which directory should SCSS compile to?
    coffeeDir = 'public/assets/coffee', // Where do you store your coffee files?
    targetJSDir = 'public/assets/js', // Which directory should CoffeeScript compile to?
    scss_options = { style: 'compressed', compass: true };

// Compile SCSS, autoprefix CSS,
// and save to target CSS directory
gulp.task('css', function () {
    return gulp.src(scssDir + '/**/*.scss')
        .pipe(scss(scss_options).on('error', gutil.log))
        .pipe(autoprefix('last 10 version'))
        .pipe(gulp.dest(targetCSSDir))
        .pipe(notify('CSS minified'))
});

// Handle CoffeeScript compilation
gulp.task('js', function () {
    return gulp.src(coffeeDir + '/**/*.coffee')
        .pipe(coffee().on('error', gutil.log))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(gulp.dest(targetJSDir))
});

// Keep an eye on Scss, Coffee, and PHP files for changes...
gulp.task('watch', function () {
    gulp.watch(scssDir + '/**/**/*.scss', ['css']);
    gulp.watch(coffeeDir + '/**/*.coffee', ['js']);
});

// What tasks does running gulp trigger?
gulp.task('default', ['css', 'js', 'watch']);