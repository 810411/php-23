<?php

class TableField extends ConnectDB
{
    protected $table;
    protected $name;
    protected $type;
    protected $null;
    protected $key;
    protected $default;
    protected $extra;

    public function __construct($tableName, $tableField)
    {
        $this->table = $tableName;
        $this->name = $tableField['Field'];
        $this->type = $tableField['Type'];
        $this->null = $tableField['Null'];
        $this->key = $tableField['Key'];
        $this->default = $tableField['Default'];
        $this->extra = $tableField['Extra'];
    }

    public function delete()
    {
        $tableName = $this->getTable();
        $fieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` DROP COLUMN `$fieldName`;";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNull()
    {
        return $this->null;
    }

    public function setName($name)
    {
        $tableName = $this->getTable();
        $fieldType = $this->getNull() === 'NO' ? $this->getType() . ' NOT NULL' : $this->getType();
        $oldFieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` CHANGE `$oldFieldName` `$name` $fieldType";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $tableName = $this->getTable();
        $fieldType = $this->getNull() === 'NO' ? $type . ' NOT NULL' : $type;
        $fieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` CHANGE `$fieldName` `$fieldName` $fieldType";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $this->type = $type;
    }
}