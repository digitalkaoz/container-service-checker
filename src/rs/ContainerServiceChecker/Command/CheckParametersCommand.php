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
class CheckParametersCommand extends BaseCheckCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('check:parameters')
            ->setDescription('checks all classname parameters for valid classes')
            ->addArgument('kernel', InputArgument::REQUIRED, 'the Path to the Kernel Class')
            ->addOption('environment', 'env', InputOption::VALUE_REQUIRED, 'the kernel environment', 'dev')
            ->addOption('debug', null, InputOption::VALUE_NONE, 'the kernel debug mode')
            ->setHelp(<<<EOF
The <info>check:parameters</info> command takes a Symfony2 Kernel File as argument, instanciates it and tries to load all container parameter classes

You could set the <comment>environment</comment>                             <info>check:services</info> <comment>--environment=prod</comment>
You could activate <comment>debug</comment>                                  <info>check:services</info> <comment>--debug</comment>
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
        foreach ($container->getParameterBag()->all() as $id => $parameter) {
            if (!is_string($parameter)) {
               continue;
            }

            if (strpos($parameter, '\\') && !class_exists($parameter)) {
                $output->writeln(sprintf('<error>%s</error> is not autoloadable: <comment>%s</comment>', $id,$parameter));
                $errornous = true;
            }
        }

        if (!$errornous) {
            $output->writeln('<info>all container parameter classes could be autoloaded</info>');
        }
    }
}
