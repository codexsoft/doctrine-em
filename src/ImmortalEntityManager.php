<?php


namespace CodexSoft\DoctrineEm;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ImmortalEntityManager implements EntityManagerInterface
{
    private EntityManager $entityManager;
    private LoggerInterface $logger;

    public function __construct(EntityManager $entityManager, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new NullLogger();
        $this->entityManager = $entityManager;
    }

    private function assertEmIsOpen(): void
    {
        if (!$this->entityManager->isOpen()) {
            try {
                $this->entityManager = EntityManager::create(
                    $this->entityManager->getConnection(),
                    $this->entityManager->getConfiguration(),
                    $this->entityManager->getEventManager()
                );
                $this->logger->notice('Entity manager was reopened');
            } catch (ORMException $e) {
                $this->logger->warning('Failed to reopen closed EntityManager', ['exception' => $e]);
                throw $e;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getCache()
    {
        return $this->entityManager->getCache();
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return $this->entityManager->getConnection();
    }

    /**
     * @inheritDoc
     */
    public function getExpressionBuilder()
    {
        return $this->entityManager->getExpressionBuilder();
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * @inheritDoc
     */
    public function transactional($func)
    {
        return $this->entityManager->transactional($func);
    }

    /**
     * @inheritDoc
     */
    public function commit()
    {
        $this->entityManager->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback()
    {
        $this->entityManager->rollback();
    }

    /**
     * @inheritDoc
     */
    public function createQuery($dql = '')
    {
        return $this->entityManager->createQuery($dql);
    }

    /**
     * @inheritDoc
     */
    public function createNamedQuery($name)
    {
        return $this->entityManager->createNamedQuery($name);
    }

    /**
     * @inheritDoc
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
        return $this->entityManager->createNativeQuery($sql, $rsm);
    }

    /**
     * @inheritDoc
     */
    public function createNamedNativeQuery($name)
    {
        return $this->entityManager->createNamedNativeQuery($name);
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder()
    {
        return $this->entityManager->createQueryBuilder();
    }

    /**
     * @inheritDoc
     */
    public function getReference($entityName, $id)
    {
        return $this->entityManager->getReference($entityName, $id);
    }

    /**
     * @inheritDoc
     */
    public function getPartialReference($entityName, $identifier)
    {
        return $this->entityManager->getPartialReference($entityName, $identifier);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->entityManager->close();
    }

    /**
     * @inheritDoc
     */
    public function copy($entity, $deep = false)
    {
        return $this->entityManager->copy($entity, $deep);
    }

    /**
     * @inheritDoc
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->entityManager->lock($entity, $lockMode, $lockVersion);
    }

    /**
     * @inheritDoc
     */
    public function getEventManager()
    {
        return $this->entityManager->getEventManager();
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration()
    {
        return $this->entityManager->getConfiguration();
    }

    /**
     * @inheritDoc
     */
    public function isOpen()
    {
        // todo: return always true?
        $this->assertEmIsOpen();
        return $this->entityManager->isOpen();
    }

    /**
     * @inheritDoc
     */
    public function getUnitOfWork()
    {
        return $this->entityManager->getUnitOfWork();
    }

    /**
     * @inheritDoc
     */
    public function getHydrator($hydrationMode)
    {
        return $this->entityManager->getHydrator($hydrationMode);
    }

    /**
     * @inheritDoc
     */
    public function newHydrator($hydrationMode)
    {
        return $this->entityManager->newHydrator($hydrationMode);
    }

    /**
     * @inheritDoc
     */
    public function getProxyFactory()
    {
        return $this->entityManager->getProxyFactory();
    }

    /**
     * @inheritDoc
     */
    public function getFilters()
    {
        return $this->entityManager->getFilters();
    }

    /**
     * @inheritDoc
     */
    public function isFiltersStateClean()
    {
        return $this->entityManager->isFiltersStateClean();
    }

    /**
     * @inheritDoc
     */
    public function hasFilters()
    {
        return $this->entityManager->hasFilters();
    }

    /**
     * @inheritDoc
     */
    public function find($className, $id)
    {
        return $this->entityManager->find($className, $id);
    }

    /**
     * @inheritDoc
     */
    public function persist($object)
    {
        $this->assertEmIsOpen();
        $this->entityManager->persist($object);
    }

    /**
     * @inheritDoc
     */
    public function remove($object)
    {
        $this->assertEmIsOpen();
        $this->entityManager->remove($object);
    }

    /**
     * @inheritDoc
     */
    public function merge($object)
    {
        $this->assertEmIsOpen();
        return $this->entityManager->merge($object);
    }

    /**
     * @inheritDoc
     */
    public function clear($objectName = null)
    {
        $this->entityManager->clear($objectName);
    }

    /**
     * @inheritDoc
     */
    public function detach($object)
    {
        $this->entityManager->detach($object);
    }

    /**
     * @inheritDoc
     */
    public function refresh($object)
    {
        $this->assertEmIsOpen();
        $this->entityManager->refresh($object);
    }

    /**
     * @inheritDoc
     */
    public function flush()
    {
        //$this->assertEmIsOpen();
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getRepository($className)
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * @inheritDoc
     */
    public function getMetadataFactory()
    {
        return $this->entityManager->getMetadataFactory();
    }

    /**
     * @inheritDoc
     */
    public function initializeObject($obj)
    {
        $this->entityManager->initializeObject($obj);
    }

    /**
     * @inheritDoc
     */
    public function contains($object)
    {
        return $this->entityManager->contains($object);
    }

    //public function __call($name, $arguments)
    //{
    //     TODO: Implement @method Mapping\ClassMetadata getClassMetadata($className)
    //}

    /**
     * @inheritDoc
     */
    public function getClassMetadata($className)
    {
        return $this->entityManager->getClassMetadata($className);
    }

}
