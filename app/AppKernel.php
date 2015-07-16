<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

//    public function init()
//    {
//        date_default_timezone_set( 'Europe/Moscow' );
//        parent::init();
//    }

    public function registerBundles() {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Acme\AdminBundle\AcmeAdminBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Acme\UserBundle\AcmeUserBundle(),
            new Bundles\DefaultBundle\BundlesDefaultBundle(),
            new Acme\CoreBundle\AcmeCoreBundle(),
            new Lsw\ApiCallerBundle\LswApiCallerBundle(),
            new Bundles\ApiBundle\BundlesApiBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Beryllium\CacheBundle\BerylliumCacheBundle(),
            // Add your dependencies
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            //...
            // If you haven't already, add the storage bundle
            // This example uses SonataDoctrineORMAdmin but
            // it works the same with the alternatives
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),


            // Then add SonataAdminBundle
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Bundles\YandexAviaBundle\BundlesYandexAviaBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
