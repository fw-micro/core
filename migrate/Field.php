<?php


namespace fw_micro\core\migrate;


/**
 * Class Field
 * @package fw_micro\core\migrate
 */
class Field
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $type = [];

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return $this
     */
    public function integer(): self
    {
        $this->type[] = 'INT';
        return $this;
    }

    /**
     * @return $this
     */
    public function null(): self
    {
        $this->type[] = 'NULL';
        return $this;
    }

    /**
     * @return $this
     */
    public function notNull(): self
    {
        $this->type[] = 'NOT NULL';
        return $this;
    }

    /**
     * @return $this
     */
    public function autoIncrement(): self
    {
        $this->type[] = 'AUTO_INCREMENT';
        return $this;
    }

    /**
     * @param int $max
     * @return $this
     */
    public function string(int $max): self
    {
        $this->type[] = "VARCHAR({$max})";
        return $this;
    }

    /**
     * @return $this
     */
    public function unique(): self
    {
        $this->type[] = 'UNIQUE';
        return $this;
    }

    public function primary(): self
    {
        $this->type[] = 'PRIMARY KEY';
        return $this;
    }

    /**
     * @param array $type
     * @return $this
     */
    public function setType(array $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function addType(string $type): self
    {
        $this->type[] = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getType(): array
    {
        return $this->type;
    }
}