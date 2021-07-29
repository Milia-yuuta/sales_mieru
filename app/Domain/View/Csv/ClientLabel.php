<?php


namespace App\Domain\View\Csv;


class ClientLabel extends Csv
{
    protected string $fileName = '顧客ラベル.csv';
    protected array $header = ['郵便番号', '住所', '顧客名', 'コード'];

    public function getBody(): array
    {
        return $this->body;
    }
}