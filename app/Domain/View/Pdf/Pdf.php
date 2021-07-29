<?php


namespace App\Domain\View\Pdf;


use Mpdf\Mpdf;
use http\Client;
use Illuminate\Support\Collection;


class Pdf
{
    private Mpdf $pdf;
    protected string $view = '';
    protected string $styleSheet = '';
    protected string $size = 'A4';
    protected string $orientation = 'landscape';
    protected string $fileName;


    public function __construct(Mpdf $pdf)
    {
        $this->pdf = $pdf;
    }


    public function render($clients): Mpdf
    {
        $this->loadHtml($clients);

        $this->pdf->Output();

        return $this->pdf;
    }


    public function getFileName(): string
    {
        return $this->fileName;
    }


    private function loadHtml(Collection $clients): static
    {
        $clients->each(function (Collection $chunks, $index) use($clients) {
            $html = view($this->view, ['chunks' => $chunks])->render();
            $this->pdf->WriteHTML($html);

            if (isset($clients[$index + 1])) {
                $this->pdf->AddPage();
            }
        });

        return $this;
    }
}