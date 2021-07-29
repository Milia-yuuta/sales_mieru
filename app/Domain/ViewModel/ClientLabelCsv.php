<?php


namespace App\Domain\ViewModel;


use App\Models\Client;


class ClientLabelCsv extends ClientLabel
{
    public function toArray(): array
    {
        return [
                $this->getZipCode(),
                "{$this->getAddress()} {$this->getBuildingName()} {$this->getRoomNumber()}",
                "{$this->getClientName()} {$this->getClientTitle()}",
                "{$this->getPropertyCode()}-{$this->getPropertyRoomNumber()}",
        ];
    }
}