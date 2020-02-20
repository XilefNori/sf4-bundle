<?php


namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new KnpULoremIpsumTestingKernel('test', true);
        $kernel->boot();

        $container = $kernel->getContainer();

        $ipsum =  $container->get('knpu_lorem_ipsum.knpu_ipsum');

        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);

        /** @var KnpUIpsum $ipsum */
        $this->assertIsString($ipsum->getParagraphs());
    }
}


class KnpULoremIpsumTestingKernel extends Kernel
{
    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
        ];
    }

    /**
     * Loads the container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}
