<?php


namespace App\Domain\ViewModel;


use App\Models\Client;


abstract class ClientLabel
{
    public function __construct(
            private string $zipCode,
            private string $address,
            private ?string $buildingName,
            private ?string $roomNumber,

            private string $clientName,
            private string $clientType,

            private string $propertyCode,
            private string $propertyRoomNumber
    )
    {
    }


    public function getZipCode(): string
    {
        return $this->zipCode;
    }


    public function getAddress(): string
    {
        return $this->address;
    }


    public function getBuildingName(): string
    {
        return $this->buildingName;
    }


    public function getRoomNumber(): string
    {
        return $this->roomNumber;
    }


    public function getClientName(): string
    {
        return $this->clientName;
    }


    public function getClientTitle(): string
    {
        return $this->clientType == Client::TYPE['INDIVIDUAL']
                ? '様'
                : '御中';
    }


    public function getPropertyCode(): string
    {
        return $this->propertyCode;
    }


    public function getPropertyRoomNumber(): string
    {
        return $this->propertyRoomNumber;
    }
}