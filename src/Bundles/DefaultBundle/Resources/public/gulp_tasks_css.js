var minifyCSS = require('gulp-minify-css');
var less = require('gulp-less');

module.exports = function(gulp,argv){

    gulp.task('default_bundle_less', function () {
        gulp.src('./bower_components/bootstrap/less/bootstrap.less')
            .pipe(less({
                paths: [ './bower_components/bootstrap/less/bootstrap.less' ]
            }))
            .pipe(gulp.dest('./web/build/css'))
            .pipe(minifyCSS({keepBreaks:true}))
            .pipe(gulp.dest('./web/build/dist/css'));
    });


    gulp.task('default_bundle_minify-css', function() {
        gulp.src([
            './src/Bundles/DefaultBundle/Resources/public/css/avia.css'])
            .pipe(minifyCSS({keepBreaks:true}))
            .pipe(gulp.dest('./web/build/dist/css'));

        gulp.src(['./src/Bundles/DefaultBundle/Resources/public/images/**/*'])
            .pipe(gulp.dest('./web/build/dist/images'));
    });
    if(argv.dev){
        gulp.watch(['./src/Bundles/DefaultBundle/Resources/public/css/*.css'],['default_bundle_minify-css']);
    }

    return ['default_bundle_less','default_bundle_minify-css'];

};