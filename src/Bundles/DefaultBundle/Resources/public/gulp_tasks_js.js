
var browserify = require('browserify');
var source = require('vinyl-source-stream');

var uglify = require('gulp-uglify');
var buffer = require('vinyl-buffer');
var coffee = require('gulp-coffee');

var path = require('path');
var gutil = require('gulp-util');

module.exports = function(gulp,argv){
    var pat = [
        {
            less: path.join(__dirname,'/js/index/index.coffee'),
            outputLess: './web/build/js/index',
            js: ['./web/build/js/index/index.js'],
            watch : [path.join(__dirname,'/js/index/*.coffee')],
            outputJs: 'index.js',
            outputDist: './web/build/dist/js/index'
        }
    ];
    var tasks = [];

    pat.forEach(p);

    function p(paths,index){
        gulp.task('js_'+index, function() {
            gulp.src(paths.less)
                .pipe(coffee({bare: true}).on('error', gutil.log))
                .pipe(gulp.dest(paths.outputLess));

            if(argv.dev){
                browserify(paths.js,{debug:true})
                    .bundle()
                    .pipe(source(paths.outputJs))
                    .pipe(coffee({bare: true}).on('error', gutil.log))
                    //.pipe(buffer())
                    .pipe(gulp.dest(paths.outputDist));
            } else {
                browserify(paths.js)
                    .bundle()
                    .pipe(source(paths.outputJs))
                    .pipe(buffer()) // <----- convert from streaming to buffered vinyl file object
                    .pipe(uglify()) // now gulp-uglify works
                    .pipe(gulp.dest(paths.outputDist));
            }
        });

        if(argv.dev){
            gulp.watch(paths.watchJs, ['js_'+index]);
        }
        tasks.push('js_'+index);
    }
    gulp.task('default', tasks);

    if(argv.dev){
        gulp.watch(['./src/Bundles/DefaultBundle/Resources/public/js/*.js'],['default_bundle_index_js']);
    }

    return tasks;

};