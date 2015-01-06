var browserify = require('browserify');
var source = require('vinyl-source-stream');

var uglify = require('gulp-uglify');
var buffer = require('vinyl-buffer');
var coffee = require('gulp-coffee');

var path = require('path');
var gutil = require('gulp-util');

module.exports = function (gulp, argv) {
    var pat = [
        {
            coffee: path.join(__dirname, '/src/js/index/index.coffee'),
            watch: [path.join(__dirname, '/src/js/**/*.coffee')],
            outputJs: 'index.js',
            outputDist: './web/build/dist/js/index'
        },
        {
            coffee: path.join(__dirname, '/src/js/list/index.coffee'),
            watch: [path.join(__dirname, '/src/js/**/*.coffee')],
            outputJs: 'index.js',
            outputDist: './web/build/dist/js/list'
        }
    ];
    var tasks = [];

    pat.forEach(p);

    function p(paths, index) {
        gulp.task('coffee_' + index, function () {

            if (argv.dev) {
                browserify({
                    entries: [paths.coffee],
                    extensions: ['.coffee'],
                    debug: true
                })
                    .transform('coffeeify')
                    .bundle()
                    .pipe(source(paths.outputJs))
                    .pipe(gulp.dest(paths.outputDist));
            } else {
                browserify({
                    entries: [paths.coffee],
                    extensions: ['.coffee']
                })
                    .transform('coffeeify')
                    .bundle()
                    .pipe(source(paths.outputJs))
                    .pipe(buffer()) // <----- convert from streaming to buffered vinyl file object
                    .pipe(uglify())
                    .pipe(gulp.dest(paths.outputDist));
            }
        });

        if (argv.dev) {
            gulp.watch(paths.watch, ['coffee_' + index]);
        }
        tasks.push('coffee_' + index);
        //tasks.push('js_'+index);
    }

    console.log(tasks);
    gulp.task('default', tasks);

    if (argv.dev) {
        gulp.watch(['./src/Bundles/DefaultBundle/Resources/public/src/js/*.js'], ['default_bundle_index_js']);
    }

    return tasks;

};