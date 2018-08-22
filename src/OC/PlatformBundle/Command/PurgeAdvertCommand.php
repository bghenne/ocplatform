<?php


namespace OC\PlatformBundle\Command;

use OC\PlatformBundle\Service\Purger\Advert;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PurgeAdvertCommand
 *
 * @package Command
 * @category Console Command
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class PurgeAdvertCommand extends Command
{
    /**
     * @var Advert $purgerAdvertService
     */
    private $purgerAdvertService;

    /**
     * Get purger advert service
     *
     * @return Advert
     */
    public function getPurgerAdvertService(): Advert
    {
        return $this->purgerAdvertService;
    }

    /**
     * Set purger advert service
     *
     * @param Advert $purgerAdvertService
     *
     * @return PurgeAdvertCommand
     */
    public function setPurgerAdvertService($purgerAdvertService)
    {
        $this->purgerAdvertService = $purgerAdvertService;

        return $this;
    }

    /**
     * PurgeAdvertCommand constructor.
     *
     * @param Advert $purgerAdvertService
     * @access public
     *
     * @return void
     */
    public function __construct(Advert $purgerAdvertService)
    {
        $this->setPurgerAdvertService($purgerAdvertService);
        parent::__construct();
    }

    /**
     * Configure command
     *
     * @access protected
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('oc:platform:advert:purge')
             ->setDescription('Purge advert with creation data lower than x days in the past, specify it after command')
             ->addArgument('days', InputArgument::REQUIRED, 'Number of days in the past to start purging');
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @access protected
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            $days = $input->getArgument('days');

            $this->getPurgerAdvertService()->purge($days);

            $message = sprintf('Purge for %s last days done with success !', $days);

        } catch (\Exception $e) {
            $message = 'An error occurred while purging';
        }

        $output->writeln($message);
    }
}