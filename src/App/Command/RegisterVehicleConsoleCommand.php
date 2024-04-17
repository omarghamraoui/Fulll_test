<?php

declare(strict_types=1);

namespace App\App\Command;

use App\Domain\Command\CreateFleetCommand;
use App\Domain\Command\RegisterVehicleCommand;
use App\Domain\Handler\CreateFleetHandler;
use App\Domain\Handler\RegisterVehicleHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:register-vehicle')]
final class RegisterVehicleConsoleCommand extends Command
{
    public function __construct(
        private readonly RegisterVehicleHandler $registerVehicleHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Register vehicle')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $fleetId */
        $fleetId = $input->getArgument('fleetId');
        /** @var string $vehiclePlateNumber */
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        $command = new RegisterVehicleCommand($fleetId, $vehiclePlateNumber);
        try {
            $this->registerVehicleHandler->handle($command);
            $output->writeln('Vehicle has been successfully parked');
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Error' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
