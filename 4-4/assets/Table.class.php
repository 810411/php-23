<?php

class Table extends ConnectDB
{
    protected $tableName;

    public function __construct($tableName)
    {
        $this->tableName = (string)$tableName;
    }

    public function addField($fieldName, $fieldType)
    {
        $tableName = $this->tableName;
        $fieldType = !empty($fieldType) && in_array($fieldType, $this->getFieldTypes()) ? $fieldType : 'INTEGER';
        $sql = "ALTER TABLE `$tableName` ADD `$fieldName` $fieldType NOT NULL;";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
    }

    public function getFieldTypes()
    {
        $fieldTypes = ['TINYINT', 'SMALLINT', 'INT', 'FLOAT', 'DOUBLE', 'CHAR', 'TINYTEXT', 'TEXT',
            'DATE', 'TIME', 'TIMESTAMP', 'DATETIME'];
        return $fieldTypes;
    }

    public function changeField($action, $fieldName, $newFieldName = null, $newFieldType = null)
    {
        $field = $this->getField($fieldName);
        if (isset($field)) {
            switch ($action) {
                case 'editName':
                    if (!empty($newFieldName)) {
                        $field->setName($newFieldName);
                    }
                    break;
                case 'del':
                    $field->delete();
                    break;
                case 'editType':
                    if (!empty($newFieldType)) {
                        $field->setType($newFieldType);
                    }
                    break;
            }
        }
    }

    public function getField($fieldName)
    {
        foreach ($this->getFields() as $tableField) {
            if ($tableField->getName() === $fieldName) {
                return $tableField;
            }
        }
        return null;
    }

    public function getFields()
    {
        $tableName = $this->getTableName();
        $sql = "DESCRIBE `$tableName`";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute([]);
        $fields = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $tableField) {
            $fields[] = new TableField($this->getTableName(), $tableField);
        }
        return $fields;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}