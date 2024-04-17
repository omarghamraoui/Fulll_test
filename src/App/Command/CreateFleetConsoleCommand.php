<?php

declare(strict_types=1);

namespace App\App\Command;

use App\Domain\Command\CreateFleetCommand;
use App\Domain\Handler\CreateFleetHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-fleet')]
final class CreateFleetConsoleCommand extends Command
{
    public function __construct(
        private readonly CreateFleetHandler $createFleetHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $fleetId */
        $fleetId = $input->getArgument('fleetId');
        $command = new CreateFleetCommand($fleetId);
        try {
            $fleet = $this->createFleetHandler->handle($command);
            $output->writeln('Fleet Id:' . $fleet->getId());
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Error' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
