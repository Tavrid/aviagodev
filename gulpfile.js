
var gulp = require('gulp');

var argv = require('yargs').argv;
//var defaultBundleCssTasks = require('./src/Bundles/DefaultBundle/Resources/public/gulp_tasks_css.js')(gulp,argv);
var defaultBundleJsTasks = require('./src/Bundles/DefaultBundle/Resources/public/gulp_tasks_js')(gulp,argv);
//var adminBundleCssTasks = require('./src/Acme/AdminBundle/Resources/public/gulp_tasks_css.js')(gulp,argv);
var jadeTask = require('./src/Bundles/DefaultBundle/Resources/public/gulp_tasks_jade')(gulp,argv);

gulp.task('default',defaultBundleJsTasks.concat(jadeTask));