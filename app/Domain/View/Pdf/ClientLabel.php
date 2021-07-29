<?php


namespace App\Domain\View\Pdf;


class ClientLabel extends Pdf
{
    protected string $fileName = '顧客ラベル.pdf';
    protected string $view = 'pdf.client';
}