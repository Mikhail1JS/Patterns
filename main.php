<?php

$sqlFactory = new MySQLFactory();
$postgresqlFactory = new PostgreSQLFactory();
$oraclesqlFactory = new OracleSQLFactory();

$SmartOrm = new ORM($sqlFactory);

class ORM {

    protected $connection;
    protected $record;
    protected $query;

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



interface InterfaceConnection  {
    public function getDB(): StorageInterface;

};

class MySqlConnection implements InterfaceConnection
{

    public function __construct(public string|array $config){}
    public function getDB():StorageInterface
    {
        $connection = new PDO ($this->config);

        return new MySqlStorage($connection);
    }

}

class PostgreSQLConnection implements InterfaceConnection {
    public function __construct(public string|array $config){}
    public function getDB():StorageInterface
    {
        $connection = new PDO ($this->config);

       return new PostgreSqlStorage($connection);
    }

}

class OracleSQLConnection implements InterfaceConnection {
    public function __construct(public string|array $config){}
    public function getDB():StorageInterface
    {
        $connection = new PDO ($this->config);

        return new OracleSQLStorage($connection);
    }

}

class DBQuery
{
    public $select;
    public $where;
}

class DBQueryBuilder
{
    public function __construct( public DBQuery $query){}

    public function select($field): self
    {
        $this->query->select = $field;
        return $this;
    }

    public function condition($condition): self
    {
        $this->query->where = $condition;
        return $this;
    }

    public function getCriteria(): DBQuery
    {
        return $this->query;
    }
}


interface StorageInterface {
    public function query(string $query);
}

class MySqlStorage implements StorageInterface {

    public function __construct(private PDO $connection){

    }

    public function query(string $query): PDOStatement
    {
        return $this->connection->query($query);
    }
}

class PostgreSqlStorage implements StorageInterface {

    public function __construct(private PDO $connection){

    }

    public function query(string $query): PDOStatement
    {
        return $this->connection->query($query);
    }
}

class OracleSqlStorage implements StorageInterface {

    public function __construct(private PDO $connection){

    }

    public function query(string $query): PDOStatement
    {
        return $this->connection->query($query);
    }
}

interface DBRecordInterface {
    public function getOne(string $query);

    public function getAll(string $query): array;


}

class MySqlDBRecord implements DBRecordInterface {

    public function __construct (public StorageInterface $db ){}
    public function getAll(string $query): array
    {
        return $this->db->query($query)->fetchAll();
    }

    public function getOne(string $query)
    {
        return $this->db->query($query)->fetch();
    }
}


class PostgreSQLDBRecord implements DBRecordInterface {

    public function __construct (public StorageInterface $db ){}
    public function getAll(string $query): array
    {
        return $this->db->query($query)->fetchAll();
    }

    public function getOne(string $query)
    {
        return $this->db->query($query)->fetch();
    }
}


class OracleSQLDBRecord implements DBRecordInterface {

    public function __construct (public StorageInterface $db ){}
    public function getAll(string $query): array
    {
        return $this->db->query($query)->fetchAll();
    }

    public function getOne(string $query)
    {
        return $this->db->query($query)->fetch();
    }
}



interface ServiceFactoryInterface {

    public function DBConnection(): InterfaceConnection;
    public function DBRecord(): DBRecordInterface;
    public function DBQueryBuilder(): DBQueryBuilder;
}

class MySQLFactory implements ServiceFactoryInterface {


    public function DBConnection():  InterfaceConnection
    {
        $connection = '';
        return new MysqlConnection($connection);
    }

    public function DBRecord(): DBRecordInterface
    {
        $db = $this->DBConnection()->getDB();
        return new MySqlDBRecord($db);

    }

    public function DBQueryBuilder(): DBQueryBuilder
    {
        return new DBQueryBuilder(new DBQuery());
    }
}


class PostgreSQLFactory implements ServiceFactoryInterface {


    public function DBConnection():  InterfaceConnection
    {
        $connection = '';
        return new PostgreSQLConnection($connection);
    }

    public function DBRecord(): DBRecordInterface
    {
        $db = $this->DBConnection()->getDB();
        return new PostgreSQLDBRecord($db);

    }

    public function DBQueryBuilder(): DBQueryBuilder
    {
        return new DBQueryBuilder(new DBQuery());
    }
}


class OracleSQLFactory implements ServiceFactoryInterface {


    public function DBConnection():  InterfaceConnection
    {
        $connection = '';
        return new OracleSQLConnection($connection);
    }

    public function DBRecord(): DBRecordInterface
    {
        $db = $this->DBConnection()->getDB();
        return new OracleSQLDBRecord($db);

    }

    public function DBQueryBuilder(): DBQueryBuilder
    {
        return new DBQueryBuilder(new DBQuery());
    }
}
