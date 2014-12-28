var minifyCSS = require('gulp-minify-css');
var less = require('gulp-less');

module.exports = function(gulp,argv){

    gulp.task('admin_bundle_less', function () {
        gulp.src('./src/Acme/AdminBundle/Resources/public/lib/bootstrap/less/bootstrap.less')
            .pipe(less({
                paths: [ './src/Acme/AdminBundle/Resources/public/lib/bootstrap/less/bootstrap.less' ]
            }))
            .pipe(gulp.dest('./web/build/admin/css'))
            .pipe(minifyCSS({keepBreaks:true}))
            .pipe(gulp.dest('./web/build/admin/dist/css'));
    });


    //gulp.task('default_bundle_minify-css', function() {
    //    gulp.src([
    //        './src/Bundles/DefaultBundle/Resources/public/css/avia.css',
    //        './src/Bundles/DefaultBundle/Resources/public/lib/ui-theme/css/jquery-ui.css'])
    //        .pipe(minifyCSS({keepBreaks:true}))
    //        .pipe(gulp.dest('./web/build/dist/css'));
    //
    //    gulp.src(['./src/Bundles/DefaultBundle/Resources/public/images/**/*'])
    //        .pipe(gulp.dest('./web/build/dist/images'));
    //});
    //if(argv.dev){
    //    gulp.watch(['./src/Bundles/DefaultBundle/Resources/public/css/*.css'],['default_bundle_minify-css']);
    //}

    return ['admin_bundle_less'];

};