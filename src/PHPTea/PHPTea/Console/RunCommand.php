<?php
namespace PHPTea\PHPTea\Console;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\EventDispatcher\EventDispatcher;

use PHPTea\PHPTea\Core;
use PHPTea\PHPTea\Formatter;

class RunCommand extends BaseCommand {

    protected function configure() {
        $this
            ->setName('phptea')
            ->setDescription('Run tests')
            ->addArgument(
                'files',
                InputArgument::IS_ARRAY,
                "Optional list of files to include in test run"
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $runner = Core::newRunner();
        $runner->loadFiles($input->getArgument('files'));
        $progress = new EventDispatcher();
        $progress->addSubscriber(new Formatter\Documentation());
        return $runner->run($progress);
    }

}
