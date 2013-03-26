<?php
/**
 * @version $Id: CheckCommand.php 1373 2013-03-26 13:35:00Z digitalkaoz $
 */
namespace rs\ContainerServiceChecker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * checks if all container services could be created
 *
 * @author Robert Schönthal <seroscho@gmail.com>
 */
abstract class BaseCheckCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->loadContainer($input);

        $this->check($container, $output);
    }

    /**
     * checks a facett of the container
     *
     * @param ContainerInterface $container
     * @param OutputInterface $output
     */
    protected abstract function check($container, OutputInterface $output);

    /**
     * loads the container
     *
     * @param InputInterface $input
     * @return ContainerInterface
     */
    private function loadContainer(InputInterface $input)
    {
        $kernel = $this->loadKernel($input);

        $container = $kernel->getContainer();

        if ($input->hasOption('scope') && $input->getOption('scope')) {
            $container->enterScope($input->getOption('scope'));

            if('request' == $input->getOption('scope')) {
                $container->set('request', new Request());
            }
        }

        return $container;
    }

    /**
     * loads the kernel
     *
     * @param InputInterface $input
     * @return KernelInterface
     * @throws \InvalidArgumentException
     */
    private function loadKernel(InputInterface $input)
    {
        $kernelFile = $input->getArgument('kernel');

        //TODO make it configurable?
        $kernelClass = str_replace('.php','', basename($kernelFile));
        //TODO make it configurable?
        $autoloadFile = dirname($input->getArgument('kernel')).DIRECTORY_SEPARATOR.'autoload.php';

        if (!is_readable($kernelFile)) {
            throw new \InvalidArgumentException('kernel is not loadable from '.$kernelFile);
        }
        if (!is_readable($autoloadFile)) {
            throw new \InvalidArgumentException('autoloader no loadable from '.$autoloadFile);
        }

        require_once($autoloadFile);
        require_once($kernelFile);

        $kernel = new $kernelClass($input->getOption('environment'), $input->getOption('debug'));
        $kernel->boot();

        return $kernel;
    }
}
