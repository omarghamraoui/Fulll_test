<?php

namespace App\Tests\Behat;

use App\App\Dto\AddVehicleDto;
use App\App\Dto\ParkVehicleDto;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\Service\FleetService;
use App\Domain\Service\ParkVehicleService;
use App\Domain\Service\VehicleService;
use App\Infra\Repository\FleetRepository;
use App\Tests\Service\DatabaseCleaner;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private Fleet $fleet;
    private Fleet $otherFleet;
    private Vehicle $vehicle;
    private string $plateNumber;
    private Location $location;
    private ?Exception $exception = null;

    public function __construct(
        private readonly FleetService $fleetService,
        private readonly VehicleService $vehicleService,
        private readonly ParkVehicleService $parkVehicleService,
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly VehicleRepositoryInterface $vehicleRepository,
        private readonly LocationRepositoryInterface $locationRepository,
        private readonly DatabaseCleaner $databaseCleaner,
    ) {
    }

    /**
     * @BeforeScenario
     */
    public function cleanDatabase()
    {
        $this->databaseCleaner->cleanDatabase();
    }

    /**
     * @Given /^my fleet$/
     */
    public function myFleet(): void
    {
        $this->fleet = $this->fleetService->createFleet('RentalsCars');
    }

    /**
     * @Given /^a vehicle$/
     */
    public function aVehicle(): void
    {
        $this->plateNumber = 'AB-001-CD';
        $addVehicle = new AddVehicleDto($this->fleet->getFleetId(), $this->plateNumber);
        $this->vehicle = $this->vehicleService->register($addVehicle);
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $lat = 26.15;
        $lng = 86.1;
        $parkVehicle = new ParkVehicleDto($this->fleet->getFleetId(), $this->plateNumber, $lat, $lng);
        $this->parkVehicleService->parkVehicle($parkVehicle);
        $this->location = $this->locationRepository->findLocationByLatLngVehicle($lat, $lng, $this->vehicle);
    }

    /**
     * @When /^I park my vehicle at this location$/
     * @When /^I try to park my vehicle at this location$/
     * @Given /^my vehicle has been parked into this location$/
     */
    public function iParkMyVehicleAtThisLocation()
    {
        try {
            $parkVehicleDto = new ParkVehicleDto(
                $this->fleet->getId(),
                $this->plateNumber,
                $this->location->latitude(),
                $this->location->longitude()
            );
            $this->parkVehicleService->parkVehicle($parkVehicleDto);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then /^the known location of my vehicle should verify this location$/
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $fleetVerify = $this->fleetRepository->findFleetById($this->fleet->getFleetId());
        $vehicleFind = $this->vehicleRepository->findVehicleByPlateNumber($this->plateNumber);
        Assert::assertTrue($vehicleFind->checkLocation($this->location));
    }

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        Assert::assertInstanceOf(Exception::class, $this->exception);
    }

    /**
     * @When /^I register this vehicle into my fleet$/
     * @When /^I try to register this vehicle into my fleet$/
     * @When /^I have registered this vehicle into my fleet$/
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        try {
            $registerVehicle = new AddVehicleDto($this->fleet->getId(), $this->plateNumber);
            $this->vehicleService->register($registerVehicle);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then /^this vehicle should be part of my vehicle fleet$/
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $fleetVerify = $this->fleetRepository->findFleetById($this->fleet->getFleetId());
        Assert::assertTrue($fleetVerify->has($this->plateNumber));
    }

    /**
     * @Then /^I should be informed this vehicle has already been registered into my fleet$/
     */
    public function iShouldBeInformedThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        Assert::assertInstanceOf(Exception::class, $this->exception);
    }

    /**
     * @Given /^the fleet of another user$/
     */
    public function theFleetOfAnotherUser()
    {
        $this->otherFleet = $this->fleetService->createFleet('Taxi');
    }

    /**
     * @Given /^this vehicle has been registered into the other user's fleet$/
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserSFleet()
    {
        $registerVehicle = new AddVehicleDto($this->otherFleet->getFleetId(), $this->plateNumber);
        $this->vehicleService->register($registerVehicle);
    }
}
