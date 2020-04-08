<?php


namespace fw_micro\core\console;


use fw_micro\core\migrate\defaults\Migrate;
use fw_micro\pattern\Register\Register;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDown extends Command
{
    protected static $defaultName = 'migrate:down';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $db = Register::get()->db;
        $res = $db->select('migrate', ['class']);
        if (!is_array($res) || !count($res)) {
            $this->up(Migrate::class);
        }

        $res = $db->select('migrate', ['class'], ["ORDER" => ["class" => "DESC"],]);

        foreach ($res as $row) {
            $className = $row['class'];
            $output->write($className . '...');
            $this->down($className);
            $output->writeln('   done.');
        }

        return 0;
    }

    private function down(string $className)
    {
        $class = new $className;
        $status = $class->down();
        if ($status || $status === null) {
            $this->complete($className);
        } else {
            if (Register::get()->logger) {
                Register::get()->logger->error('migrate', Register::get()->db->error());
            }
            throw new \Exception('error');
        }
    }

    private function complete(string $class): void
    {
        Register::get()->db->delete('migrate', ['class' => $class]);
    }
}