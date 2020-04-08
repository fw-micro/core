<?php


namespace fw_micro\core\migrate\defaults;


use fw_micro\core\migrate\Field;

class Migrate extends \fw_micro\core\Migrate
{
    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $this->createTable('migrate', [
            (new Field())->setName('class')->string(255)->unique(),
            (new Field())->setName('timestamp')->addType('TIMESTAMP')
        ]);
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        $this->dropTable('migrate');
    }
}