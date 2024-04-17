<?php

declare(strict_types=1);

namespace App\App\Command;

use App\Domain\Command\CreateFleetCommand;
use App\Domain\Command\LocalizeVehicleCommand;
use App\Domain\Command\RegisterVehicleCommand;
use App\Domain\Handler\CreateFleetHandler;
use App\Domain\Handler\LocalizeVehicleHandler;
use App\Domain\Handler\RegisterVehicleHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:localize-vehicle')]
final class LocalizeVehicleConsoleCommand extends Command
{
    public function __construct(
        private readonly LocalizeVehicleHandler $localizeVehicleHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Register vehicle')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number')
            ->addArgument('lat', InputArgument::REQUIRED, 'latitude')
            ->addArgument('lng', InputArgument::REQUIRED, 'longitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $fleetId */
        $fleetId = $input->getArgument('fleetId');
        /** @var string $vehiclePlateNumber */
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        /** @var float $lat */
        $lat = $input->getArgument('lat');
        /** @var float $lng */
        $lng = $input->getArgument('lng');
        $command = new LocalizeVehicleCommand($fleetId, $vehiclePlateNumber, $lat, $lng);
        try {
            $this->localizeVehicleHandler->handle($command);
            $output->writeln('Vehicle has been successfully localize');
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Error' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
