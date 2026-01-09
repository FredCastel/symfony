<?php

namespace Core\Infrastructure\Doctrine;

use Core\Domain\Aggregate\Aggregate;
use Core\Domain\ValueObject\Version;
use Core\Infrastructure\Doctrine\DoctrineIdGenerator;
use Core\Infrastructure\Doctrine\Entity\DoctrineEntityKey;
use Core\Infrastructure\Doctrine\Entity\DoctrineEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Uid\Uuid;

abstract class DoctrineAggregateRepository extends ServiceEntityRepository
{
    protected Serializer $serializer;
    private DoctrineIdGenerator $idGenerator;

    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, DoctrineEvent::class);
        $this->idGenerator = new DoctrineIdGenerator();

        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    abstract public function getAggregateClass(): string;

    public function save(Aggregate $aggregate, array $events): void
    {
        //check current aggregate version        
        $version = $this->getAggregateVersion($aggregate->getId()->value);

        if ($version != $aggregate->getVersion()->value)
            throw new \Exception("Aggregation " . static::getAggregateClass() . " version is " . $aggregate->getVersion()->value . " need $version", 1);

        foreach ($events as $event) {
            $version++;
            $eventEntity = new DoctrineEvent();
            $eventEntity->setId(Uuid::fromString($this->idGenerator->next()));
            $eventEntity->setAggregate(get_class($aggregate));
            //$eventEntity->setAggregate($this->getAggregateClass());
            $eventEntity->setAggregateId(Uuid::fromString($aggregate->getId()->value));
            $eventEntity->setVersion($version);
            $eventEntity->setEvent(get_class($event));
            $json = $this->serializer->serialize($event, 'json');
            $eventEntity->setPayload($json);
            $eventEntity->setRecordingDate(new \DateTimeImmutable('now'));
            $this->getEntityManager()->persist($eventEntity);
        }

        //synchro entity/aggregatae ids
        $conn = $this->getEntityManager()->getConnection();

        //1 delete aggregate entities keys
        $conn->executeStatement(
            'DELETE FROM entity WHERE aggregate_id = :aggregateId',
            ['aggregateId' => $aggregate->getId()->value]
        );

        //2 insert new entities key
        if (!empty($aggregate->getEntities())) {
            $placeholders = [];
            $params = [];
            foreach ($aggregate->getEntities() as $entity) {
                $placeholders[] = "(?, ?)";
                $params[] = Uuid::fromString($entity->getId()->value);
                $params[] = Uuid::fromString($aggregate->getId()->value);
            }
            $sql = sprintf(
                'INSERT INTO entity (aggregate_id, id) VALUES %s',
                implode(', ', $placeholders)
            );

            $conn->executeStatement($sql, $params);
        }
    }

    public function get(string $id): Aggregate
    {
        $events = $this->getEventsByAggregate($id);
        $class = $this->getAggregateClass();
        $version = $this->getAggregateVersion($id);

        $instance = new $class(new \Core\Domain\ValueObject\Id($id), $version);
        // $instance->setVersion(new Version($version));
        foreach ($events as $event) {
            $instance = $instance->apply($event);
        }
        return $instance;
    }

    protected function getEventsByAggregate(string $id)
    {
        $table = DoctrineEvent::class;
        $aggregate = $this->getAggregateClass();
        $dql = "SELECT e.event, e.payload FROM $table as e 
            WHERE e.aggregate = :aggregate 
              and e.aggregateId = :id 
            ORDER BY e.version";
        $results = $this->getEntityManager()->createQuery($dql)
            ->setParameter('aggregate', $aggregate)
            ->setParameter('id', $id)
            ->getArrayResult();
        return array_map(function ($result) {
            return $this->serializer->deserialize($result['payload'], $result['event'], 'json');
        }, $results);
    }

    protected function getAggregateVersion(string $id): int
    {
        $table = DoctrineEvent::class;
        $aggregate = $this->getAggregateClass();
        $dql = "SELECT max( e.version ) FROM $table as e 
            WHERE e.aggregate = :aggregate 
              and e.aggregateId = :id";
        $em = $this->getEntityManager();
        $result = $em->createQuery($dql)
            ->setParameter('aggregate', $aggregate)
            ->setParameter('id', $id)
            ->getSingleScalarResult();

        return $result ?? 0;
    }
}
