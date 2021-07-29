@if(empty($prospect->prospect_favorites_id))
  <td class="pin_target"><p class="prospect_pin" data-review-id="{{ $prospect->id }}"></p></td>
@else
  <td class="pin_target_delete"><p class="pin" data-review-id="{{ $prospect->prospect_favorites_id }}"></p></td>
@endif