<?php
/**
 * @version $Id: CheckCommand.php 1373 2013-03-26 13:35:00Z digitalkaoz $
 */
namespace rs\ContainerServiceChecker\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * checks if all container services could be created
 *
 * @author Robert Schönthal <seroscho@gmail.com>
 */
class CheckServicesCommand extends BaseCheckCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('check:services')
            ->setDescription('checks all public services to be loadable')
            ->addArgument('kernel', InputArgument::REQUIRED, 'the Path to the Kernel Class')
            ->addOption('environment', 'env', InputOption::VALUE_REQUIRED, 'the kernel environment', 'dev')
            ->addOption('debug', null, InputOption::VALUE_NONE, 'the kernel debug mode')
            ->addOption('scope', null, InputOption::VALUE_REQUIRED, 'the container scope')
            ->setHelp(<<<EOF
The <info>check:services</info> command takes a Symfony2 Kernel File as argument, instanciates it and tries to load all services from the Container

You could set the <comment>environment</comment>                             <info>check:services</info> <comment>--environment=prod</comment>
You could activate <comment>debug</comment>                                  <info>check:services</info> <comment>--debug</comment>
You could enter a different <comment>scope</comment>, e.g. the request scope <info>check:services</info> <comment>--scope=request</comment>
EOF
            );
    }

    /**
     * iterates all services and fetches them
     *
     * @param ContainerInterface $container
     * @param OutputInterface $output
     */
    protected function check($container, OutputInterface $output)
    {
        $errornous = false;
        foreach ($container->getServiceIds() as $id) {
            try {
                $container->get($id);
            } catch (\Exception $e) {

                $output->writeln(sprintf('<error>%s</error> could not be loaded: <comment>%s</comment>', $id, $e->getMessage()));
                $errornous = true;
            }
        }

        if (!$errornous) {
            $output->writeln('<info>all public services could be loaded from kernel</info>');
        }
    }
}
