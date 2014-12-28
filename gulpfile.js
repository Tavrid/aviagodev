var less = require('gulp-less');
var path = require('path');
var gulp = require('gulp');
var minifyCSS = require('gulp-minify-css');
var argv = require('yargs').argv;

gulp.task('less', function () {
    gulp.src('./bower_components/bootstrap/less/bootstrap.less')
        .pipe(less({
            paths: [ './bower_components/bootstrap/less/bootstrap.less' ]
        }))
        .pipe(gulp.dest('./web/build/css'));
});

gulp.task('minify-css', function() {
    gulp.src('./web/build/css/*.css')
        .pipe(minifyCSS({keepBreaks:true}))
        .pipe(gulp.dest('./web/build/css/dist/'))
});


gulp.task('default',['less','minify-css']);