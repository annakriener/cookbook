var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var less = require('gulp-less');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var env = process.env.GULP_ENV;

var basePath = 'src/CookbookBundle/Resources/public';

//JAVASCRIPT TASK: write one minified js file out of jquery.js, bootstrap.js and all of my custom js files
gulp.task('js', function () {
    return gulp.src(['bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        basePath + '/js/**/*.js'])
        .pipe(concat('script.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'))
        .pipe(browserSync.reload({stream: true}));
});

//CSS TASK: write one minified css file out of bootstrap.less and all of my custom less files
gulp.task('css', function () {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        basePath + '/less/**/*.less'])
        .pipe(gulpif(/[.]less/, less()))
        .pipe(concat('styles.css'))
        .pipe(gulpif(env === 'prod', uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/css'))
        .pipe(browserSync.reload({stream: true}));
});

//IMAGE TASK: Just pipe images from project folder to public web folder
gulp.task('img', function() {
    return gulp.src(basePath +'/img/**/*.*')
        .pipe(gulp.dest('web/img'));
});

gulp.task('fonts', function() {
    return gulp.src(['bower_components/bootstrap/dist/fonts/*.*',
        basePath +'/fonts/**/*.*'])
        .pipe(gulp.dest('web/fonts'));
});

gulp.task('watch', function() {
    gulp.watch(basePath + '/js/**/*.js', ['js']);
    gulp.watch(basePath + '/less/**/*.less', ['css']);
    gulp.watch([basePath + '/img/**/*'], ['img', browserSync.reload]);
});

//define executable tasks when running "gulp" command
gulp.task('default', ['js', 'css', 'img', 'fonts', 'watch']);