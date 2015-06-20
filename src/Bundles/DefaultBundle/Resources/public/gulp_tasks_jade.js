var gulp = require('gulp');
var argv = require('yargs').argv;
var path = require('path');
var jade = require('gulp-jade');
module.exports = function(){

    gulp.task('default_jade', function () {
        gulp.src(path.join(__dirname, 'src/jade/**/*.jade'))
            .pipe(jade())
            .pipe(gulp.dest('./web/build/view'));
    });

    if(argv.dev){
        gulp.watch([path.join(__dirname, 'src/jade/**/*.jade')],['default_jade']);
    }

    return ['default_jade'];

};