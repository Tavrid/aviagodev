
var gulp = require('gulp');

var argv = require('yargs').argv;
var defaultBundleCssTasks = require('./src/Bundles/DefaultBundle/Resources/public/gulp_tasks_css.js')(gulp,argv);
var adminBundleCssTasks = require('./src/Acme/AdminBundle/Resources/public/gulp_tasks_css.js')(gulp,argv);

gulp.task('default',defaultBundleCssTasks.concat(adminBundleCssTasks));