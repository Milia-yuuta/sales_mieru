<?php


namespace App\Domain\ViewModel;


use App\Models\Client;


class ClientLabelPdf extends ClientLabel
{
    public function toObject(): \stdClass
    {
        return (object)[
                'zipcode'       => $this->getZipCode(),
                'address'       => $this->getAddress(),
                'building_name' => $this->getBuildingName(),
                'room_number'   => $this->getRoomNumber(),
                'name'          => "{$this->getClientName()} {$this->getClientTitle()}",
                'code'          => "{$this->getPropertyCode()}-{$this->getPropertyRoomNumber()}",
        ];
    }
}