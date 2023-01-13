<?php
interface RepositoryInterface {
    public function getOne(): array;
    public function getDb(): StorageInterface;
}

interface StorageInterface {


    public function query(): array;
}

class MysqlRepository implements RepositoryInterface {

    public function getOne(): array
    {
        $db = $this->getDb();
        return $db->query();
    }

    public function getDb(): StorageInterface {
        return new MysqlStorage();
    }
}

class RedisRepository implements RepositoryInterface {

    public function getOne(): array
    {
        $db = $this->getDb();
        return $db->query();
    }

    public function getAll(): array
    {
        $db = $this->getDb();
        return $db->query();
    }

    public function getDb(): StorageInterface {
        return new RedisStorage();
    }
}

class MysqlStorage implements StorageInterface {

    public function query(): array
    {
        return [];
    }
}

class RedisStorage implements StorageInterface {

    public function query(): array
    {
        return [];
    }
}


class ORM {

    protected $connection;
    protected $renderer;
    protected $logger;

    public function __construct(ServiceFactoryInterface $serviceFactory)
    {
        $this->connection = $serviceFactory->DBConnection();
        $this->record = $serviceFactory->DBRecord();
        $this->query = $serviceFactory->DBQueryBuilder();

    }

    public function run()
    {

    }
}

abstract class AbstractConnection  {

    public function __construct(string $connection)
    {
    }

};
interface RendererInterface {};
interface LoggerInterface {};


class MysqlConnection extends AbstractConnection {

}






abstract class ServiceFactoryInterface {

    abstract public function DBConnection(string $connection): AbstractConnection;
    abstract public function DBRecord(): RecordInterface;
    abstract public function DBQueryBuilder(): QueryInterface;
}

class ProductionServiceFactory extends ServiceFactoryInterface {

    public function DBConnection($string): ConnectionInterface
    {
        return new MysqlConnection();
    }

    public function DBRecord(): RecordInterface;
    {

    }

    public function DBQueryBuilder(): QueryInterface
    {

    }
}


