#symfony-bootstrap-table

###Use composer

```
"stb/bootstrap": "dev-master"
```

###Enable the bundle
```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stb\Bootstrap\StbBootstrapBundle(),

    );
}
```

### Install assets

```
$ php app/console assets:install
```

