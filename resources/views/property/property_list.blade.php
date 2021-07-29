<tr data-option="style-pin" class="property_list">
  @if(empty($property->property_favorites_id))
    <td style="width: 40px" class="target_pin"><p class="prospect_pin js_select_stage_search" data-review-id="{{ $property->id }}"></p></td>
  @else
    <td style="width: 40px" class="target_pin_delete"><p class="pin js_select_stage_search" data-review-id="{{ $property->property_favorites_id }}"></p></td>
  @endif
  <td style="width: 300px">
    <p>{{ $property->property_name }}</p>
    <p class="address">{{ $property->address }}</p>
  </td>
  <td style="width: 200px; overflow: hidden"><p style="overflow: hidden; width: 135px">{{ $property->nearest_station }}<br>@if($property->bus_stop_walk_time > 0) バス{{ $property->bus_stop_walk_time }}分@endif　@if($property->nearest_station_walk_time > 0)徒歩{{ $property->nearest_station_walk_time }}分@endif</p></td>
  <td style="width: 150px"><span class="c-check  @if($property->manager_visit_count) checked visit_checked @else visit_check @endif" data-review-id="{{ $property->id }}" data-area-id="{{ $property->area_master_id }}"></span></td>
  <td style="width: 150px"><span class="c-check  @if($property->manager_TEL_count) checked tel_checked @else tel_check @endif " data-review-id="{{ $property->id }}" data-area-id="{{ $property->area_master_id }}"></span></td>
  <td style="width: 150px"><span class="c-check  @if($property->check_building_count) checked building_checked @else building_check @endif " data-review-id="{{ $property->id }}" data-area-id="{{ $property->area_master_id }}"></span></td>
  <td class="prospect_count discrimination_count" style="width: 60px">
    <span class="c-count" data-stage="discrimination" data-option="discrimination open-rooms" data-flex="justify-end" data-review-id="{{ $property->id }}">{{$property->DiscriminationCount}}</span>
  </td>
  <td class="prospect_count latent_count" style="width: 60px">
    <span class="c-count" data-stage="latent" data-option="latent open-rooms" data-flex="justify-end" data-review-id="{{ $property->id }}">{{$property->LatentCount}}</span>
  </td>
  <td class="prospect_count overt_count" style="width: 60px">
    <span class="c-count" data-stage="overt" data-option="overt open-rooms" data-flex="justify-end" data-review-id="{{ $property->id }}">{{$property->OvertCount}}</span>
  </td>
</tr>
