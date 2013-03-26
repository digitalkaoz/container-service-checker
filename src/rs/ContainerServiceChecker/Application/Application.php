<?php
/**
 * @version $Id: Application.php 1373 2013-03-26 13:40:00Z digitalkaoz $
 */
namespace rs\ContainerServiceChecker\Application;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use rs\ContainerServiceChecker\Command;

/**
 * 
 *
 * @author Robert Schönthal <seroscho@gmail.com>
 */
class Application extends BaseApplication
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('container-service-checker', '@package_version@');
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->registerCommands();

        return parent::doRun($input, $output);
    }

    /**
     * Initializes all commands
     */
    protected function registerCommands()
    {
        $this->add(new Command\CheckServicesCommand());
        $this->add(new Command\CheckParametersCommand());
    }
}
