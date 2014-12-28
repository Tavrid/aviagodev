Symfony Standard Edition
========================

Building
----------
**1) install assets**

    $ php app/console assets:install
	$ php app/console assetic:dump --env=pro

**2) Building vs node.js**

	$ npm i gulp -g
	$ npm i bower -g
	$ npm update
	$ bower install
	$ gulp

Watch changes
----------------------
	$ gulp --dev