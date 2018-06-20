<?php

class Database extends ConnectDB
{
    public function __construct($tableName)
    {
        $sqlCreateTable =
            "CREATE TABLE IF NOT EXISTS `$tableName` (
              id int NOT NULL AUTO_INCREMENT,
              description text NOT NULL,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $statement = $this->getConnection()->prepare($sqlCreateTable);
        $statement->execute([]);
    }

    public function getTables()
    {
        $sql = "SHOW TABLES";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $tables = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $table) {
            $tables[] = new Table($table['Tables_in_' . DB]);
        }
        return $tables;
    }

    public function getTable($tableName)
    {
        $table = new Table($tableName);
        return $table;
    }
}