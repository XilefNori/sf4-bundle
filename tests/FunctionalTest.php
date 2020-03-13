<?php


namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();

        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');

        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);

        /** @var KnpUIpsum $ipsum */
        $this->assertIsString($ipsum->getParagraphs());
    }

    // public function testServiceWiringWithConfiguration(): void
    // {
    //     $kernel = new KnpULoremIpsumTestingKernel([
    //         'word_provider' => 'stub_word_list'
    //     ]);
    //     $kernel->boot();
    //
    //     $container = $kernel->getContainer();
    //
    //     /** @var KnpUIpsum $ipsum */
    //     $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
    //     $this->assertStringContainsString('stub', $ipsum->getWords(2));
    // }

    public static function tearDownAfterClass(): void
    {
        $cache_dir = ROOT_DIR . '/var/cache/kernel/';

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($cache_dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($cache_dir);
    }
}


class KnpULoremIpsumTestingKernel extends Kernel
{
    /** @var array */
    private $knpUIpsumConfig;

    public function __construct(array $knpUIpsumConfig = [])
    {
        $this->knpUIpsumConfig = $knpUIpsumConfig;

        parent::__construct('test', true);
    }


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
        $loader->load(function (ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);

            $container->loadFromExtension('knpu_lorem_ipsum', $this->knpUIpsumConfig);
        });
    }

    public function getCacheDir()
    {
        return ROOT_DIR . '/var/cache/kernel/' . spl_object_hash($this);
    }
}

class StubWordList implements WordProviderInterface
{

    /**
     * Return word list to use for fake text
     *
     * @return array
     */
    public function getWordList(): array
    {
        return ['stub', 'stub2'];
    }
}
