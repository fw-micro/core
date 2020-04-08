<?php

namespace fw_micro\core;

use fw_micro\core\migrate\Field;
use fw_micro\pattern\Register\Register;

/**
 * Class Migrate
 * @package fw_micro\core
 */
abstract class Migrate
{
    /**
     * @var \Medoo\Medoo
     */
    protected $db;

    /**
     * Migrate constructor.
     */
    public function __construct()
    {
        $this->db = Register::get()->db;
    }

    /**
     *
     */
    abstract public function up(): void;

    /**
     *
     */
    abstract public function down(): void;

    /**
     * @param string $name
     * @param Field[] $fields
     * @param array $options
     * @return bool|\PDOStatement
     */
    public function createTable(string $name, array $fields, array $options = [])
    {
        $fieldsArr = [];

        foreach ($fields as $field) {
            $fieldsArr[$field->getName()] = $field->getType();
        }
        return $this->db->create($name, $fieldsArr, $options);
    }

    /**
     * @param string $name
     * @return bool|\PDOStatement
     */
    public function dropTable(string $name)
    {
        return $this->db->drop($name);
    }
}
