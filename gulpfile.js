
var gulp = require('gulp');

var argv = require('yargs').argv;
var defaultBundleCssTasks = require('./src/Bundles/DefaultBundle/Resources/public/gulp_tasks_css.js')(gulp,argv);

gulp.task('default',defaultBundleCssTasks);