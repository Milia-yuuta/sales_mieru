<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\UseCases\PropertyRoom\IndexToCsvAction;
use App\Models\PropertyRoom;
use App\Services\ExportClientLabelCsvService;

use App\Domain\ViewModel\ClientLabelCsv as ClientLabelCsvModel;
use App\Domain\ViewModel\ClientLabelPdf as ClientLabelPdfModel;
use App\Domain\View\Csv\ClientLabel as ClientLabelCsv;
use App\Domain\View\Pdf\ClientLabel as ClientLabelPdf;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\UseCases\Prospect\IndexLabelTargetAction;


class ShippingInformationController extends Controller
{

    public function __construct(
            private ExportClientLabelCsvService $csvService
    )
    {
    }


    public function index(Request $request, IndexLabelTargetAction $action)
    {
        return view('prospect.label.index', [
                'request' => $request,
                'prospects' => $action($request)
        ]);
    }


    public function csv(Request $request): StreamedResponse
    {
        $propertyRoomsToClientLabel = function (array $rooms) {
            return array_map(function (PropertyRoom $room) {
                $client = $room->client;
                $property = $room->property;

                return (new ClientLabelCsvModel(
                        $client?->zip_code,
                        $client?->address1.$client?->address2,
                        $client?->address3,
                        $client?->address4,
                        $client?->name,
                        $client?->type,
                        $property->code,
                        $room->room_name
                ))->toArray();
            }, $rooms);
        };

        $propertyRoomViewModels = (new IndexToCsvAction)($request->input('room', []), $propertyRoomsToClientLabel);

        return $this->csvService->export(new ClientLabelCsv($propertyRoomViewModels));
    }


    public function pdf(Request $request, ClientLabelPdf $pdf)
    {
        $propertyRoomsToClientLabel = function (array $rooms) {
            return collect(array_map(function (PropertyRoom $room) {
                $client = $room->client;
                $property = $room->property;

                return (new ClientLabelPdfModel(
                        $client?->zip_code,
                        $client?->address1.$client?->address2,
                        $client?->address3,
                        $client?->address4,
                        $client?->name,
                        $client?->type,
                        $property->code,
                        $room->room_name
                ))->toObject();
            }, $rooms));
        };

        $propertyRoomViewModels = (new IndexToCsvAction)($request->input('room', []), $propertyRoomsToClientLabel);

        $chunkedPropertyRoomViewModels = $propertyRoomViewModels->chunk(20)->map(fn(Collection $chunk) => $chunk->chunk(4));

        $pdf->render($chunkedPropertyRoomViewModels);
    }
}
