Symfony Standard Edition
========================

Building
----------
**1) install assets**

    $ php app/console assets:install
	$ php app/console assetic:dump --env=prod

**2) Building with node.js**

	$ npm i gulp -g
	$ npm i bower -g
	$ npm i gulp-less -g
	$ npm update
	$ bower install
	$ gulp
**3) Add parameters**
Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml`

Watch changes
----------------------
	$ gulp --dev