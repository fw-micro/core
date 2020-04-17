<?php

namespace fw_micro\core;

use fw_micro\pattern\BaseObject;
use fw_micro\pattern\Register\Register;

abstract class Model extends BaseObject
{
    abstract public static function getTableName(): string;

    private $__data = [];

    public function __set($name, $value)
    {
        $this->__data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->__data[$name] ?? null;
    }

    /**
     * @param array $where
     * @param array $select
     * @return static[]
     */
    public static function findAll(array $where, array $select = []): array
    {
        $columns = array_merge(static::getColumns(), $select);
        $data = Register::get()->db->select(static::getTableName(), $columns, $where);
        if (!is_array($data)) {
            Register::get()->logger->error('error', [Register::get()->db->error(), $data]);
            return [];
        }
        return self::createModels($data);
    }

    /**
     * @param array $where
     * @param array $select
     * @return static[]
     */
    public static function rand(array $where, array $select = []): array
    {
        $columns = array_merge(static::getColumns(), $select);
        $data = Register::get()->db->rand(static::getTableName(), $columns, $where);
        if (!is_array($data)) {
            Register::get()->logger->error('error', [Register::get()->db->error(), $data]);
            return [];
        }
        return self::createModels($data);
    }

    /**
     * @param array $where
     * @param array $select
     * @return static
     */
    public static function findOne(array $where, array $select = []): ?Model
    {
        $columns = array_merge(static::getColumns(), $select);
        $data = Register::get()->db->select(static::getTableName(), $columns, $where);
        if (!is_array($data) || !count($data)) {
            return null;
        }
        return new static($data[0]);
    }

    /**
     * @param array $data
     * @return static[]
     */
    public static function createModels(array $data): array
    {
        $res = [];
        foreach ($data as $item) {
            $res[] = new static($item);
        }
        return $res;
    }

    /**
     * @return bool|\PDOStatement
     */
    public function insert()
    {
        $insert = [];
        foreach (static::getColumns() as $key) {
            if ($this->{$key} !== null) {
                $insert[$key] = $this->{$key};
            }
        }
        return Register::get()->db->insert(static::getTableName(), $insert);
    }

    /**
     * @return array
     */
    public static function getColumns(): array
    {
        $columns = get_class_vars(static::class);
        unset($columns['__data']);
        return array_keys($columns);
    }
}