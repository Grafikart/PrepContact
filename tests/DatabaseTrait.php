<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

trait DatabaseTrait
{
    /**
     * @var string|null The name of the Doctrine connection to use
     */
    protected static $connection;

    protected static $hasSchema = false;

    protected static function bootKernel(array $options = [])
    {
        static::ensureKernelTestCase();
        $kernel = parent::bootKernel($options);
        $kernel->getContainer()->get('doctrine')->getConnection(static::$connection)->beginTransaction();
        static::$kernel = $kernel;
        static::buildSchema();
        return $kernel;
    }

    protected static function ensureKernelTestCase(): void
    {
        if (!is_a(static::class, KernelTestCase::class, true)) {
            throw new LogicException(sprintf('The test class must extend "%s" to use "%s".', KernelTestCase::class,
                static::class));
        }
    }

    protected static function buildSchema(): void
    {
        if (static::$hasSchema) {
            return;
        }
        $container = static::$container ?? static::$kernel->getContainer();
        $em = $container->get('doctrine')->getManager();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($meta)) {
            $tool = new SchemaTool($em);
            $tool->dropSchema($meta);
            try {
                $tool->createSchema($meta);
                static::$hasSchema = true;
            } catch (ToolsException $e) {
                throw new \InvalidArgumentException("Database schema is not buildable: {$e->getMessage()}",
                    $e->getCode(), $e);
            }
        }
    }

    protected static function ensureKernelShutdown()
    {
        $container = static::$container ?? static::$kernel->getContainer();
        if (null !== $container) {
            $connection = $container->get('doctrine')->getConnection(static::$connection);
            if ($connection->isTransactionActive()) {
                $connection->rollback();
            }
        }
        parent::ensureKernelShutdown();
    }

    public function loadFixtures($class = null)
    {
        static::$kernel = static::$kernel ?? static::createKernel();
        static::$kernel->boot();
        if ($class === null) {
            return;
        }
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $loader = new Loader();
        $loader->addFixture(new $class());

        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

}
