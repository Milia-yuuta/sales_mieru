<?php


namespace App\Services;


use App\Domain\View\Csv\Csv;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Export\Standard\Exporter;
use Symfony\Component\HttpFoundation\StreamedResponse;


final class ExportClientLabelCsvService
{
    private const RESPONSE_HEADER = [
            'Content-type'  => 'text/csv',
            'Cache-Control' => 'must-revalidate, no-cache',
            'Expires'       => 0,
    ];


    public function export(Csv $csv): StreamedResponse
    {
        return response()->streamDownload($this->createCallback($csv), $csv->getFileName(), self::RESPONSE_HEADER);
    }


    private function createCallback(Csv $csv): \Closure
    {
        return function () use ($csv) {
            $config = new ExporterConfig();

            $config->setDelimiter($csv->getDelimiter())
                   ->setEnclosure($csv->getEnclosure())
                   ->setEscape($csv->getEscape())
                   ->setToCharset($csv->getCharset())
                   ->setColumnHeaders($csv->getHeader());

            $exporter = new Exporter($config);

            $exporter->export('php://output', $csv->getBody());
        };
    }
}