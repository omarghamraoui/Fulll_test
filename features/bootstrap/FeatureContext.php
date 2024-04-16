<?php

use App\App\Dto\AddVehicleDto;
use App\App\Dto\ParkVehicleDto;
use App\Domain\Factory\FleetFactory;
use App\Domain\Factory\LocationFactory;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Service\FleetService;
use App\Domain\Service\ParkVehicleService;
use App\Domain\Service\VehicleService;
use App\Infra\Repository\FleetRepository;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private FleetRepository $fleetRepository;
    private FleetService $fleetService;
    private VehicleService $vehicleService;
    private FleetFactory $fleetFactory;
    private VehicleFactory $vehicleFactory;
    private LocationFactory $locationFactory;
    private ParkVehicleService $parkVehicleService;
    private Fleet $fleet;
    private Fleet $otherFleet;
    private string $type;
    private string $plateNumber;
    private Location $location;
    private ?Exception $exception = null;

    public function __construct()
    {
        $this->fleetRepository = new FleetRepository();
        $this->fleetFactory = new FleetFactory();
        $this->vehicleFactory = new VehicleFactory();
        $this->locationFactory = new LocationFactory();
        $this->fleetService = new FleetService($this->fleetRepository, $this->fleetFactory);
        $this->vehicleService = new VehicleService($this->fleetRepository, $this->vehicleFactory);
        $this->parkVehicleService = new ParkVehicleService(
            $this->fleetRepository,
            $this->vehicleFactory,
            $this->locationFactory
        );
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
        $this->type = 'car';
        $this->plateNumber = 'AB-001-CD';
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $this->location = new Location(26.15, 86.1);
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
                $this->type,
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
        $fleetVerify = $this->fleetRepository->find($this->fleet->getId());
        $vehicleFind = $fleetVerify->find($this->plateNumber);
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
            $registerVehicle = new AddVehicleDto($this->fleet->getId(), $this->type, $this->plateNumber);
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
        $fleetVerify = $this->fleetRepository->find($this->fleet->getId());
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
        $registerVehicle = new AddVehicleDto($this->otherFleet->getId(), $this->type, $this->plateNumber);
        $this->vehicleService->register($registerVehicle);
    }
}
