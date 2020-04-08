<?php


namespace fw_micro\core\console;


use fw_micro\core\migrate\defaults\Migrate;
use fw_micro\pattern\Register\Register;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateUp extends Command
{
    protected static $defaultName = 'migrate:up';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $db = Register::get()->db;
        $res = $db->select('migrate', ['class']);
        if (!is_array($res) || !count($res)) {
            $this->up(Migrate::class);
        }

        $migrateList = Register::get()->config['migrate'] ?? [];

        foreach ($migrateList as $class) {
            $output->write($class . '...');
            $this->up($class);
            $output->write('   done.');
        }

        return 0;
    }

    private function up(string $className)
    {
        $class = new $className;
        $status = $class->up();
        if ($status || $status === null) {
            $this->complete($className);
        } else {
            dump($status, $className, Register::get()->db->error());
        }
    }

    private function complete(string $class): void
    {
        Register::get()->db->insert('migrate', [
            'class' => $class,
            'timestamp' => time(),
        ]);
    }
}