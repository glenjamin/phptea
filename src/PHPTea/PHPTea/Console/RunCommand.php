<?php
namespace PHPTea\PHPTea\Console;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use PHPTea\PHPTea\Core;

class RunCommand extends BaseCommand {

    protected function configure() {
        $this
            ->setName('phptea')
            ->setDescription('Run tests')
            ->addArgument(
                'files',
                InputArgument::IS_ARRAY
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $runner = Core::newRunner();
        $runner->loadFiles($input->getArgument('files'));
        return $runner->run();
    }

}
