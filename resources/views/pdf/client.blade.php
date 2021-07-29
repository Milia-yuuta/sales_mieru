<style>
    table {
        margin: 0;
        padding: 0;
        border-spacing: 0;
        height: 100%;
        width: 100%;
    }

    p {
        font-family: "ipaexg", sans-serif;
        font-size: 11px;
    }
</style>

<body>
<table>
    <tbody class="page">
        @foreach($chunks as $chunk)
            @foreach($chunk as $client)
                <tr class="row">
                    <x-pdf-label-card :zipcode="$client->zipcode"
                                      :address="$client->address"
                                      :building-name="$client->building_name"
                                      :room-number="$client->room_number"
                                      :client-name="$client->name"
                                      :code="$client->code"
                                      :row-offset="$loop->parent->index"
                                      :column-offset="$loop->index"
                    />
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
</body>
