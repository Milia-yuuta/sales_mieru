@switch($request->input((string) ($SortValue)))
    @case(1)
    <div  class="button_sort up"></div>
    <input type="hidden" class="sort_value up" name="{{$SortValue}}">
    @break
    @case(2)
    <div  class="button_sort down"></div>
    <input type="hidden" class="sort_value down" name="{{$SortValue}}">
    @break
    @default
    <div  class="button_sort"></div>
    <input type="hidden" class="sort_value" name="{{$SortValue}}">
    @break
@endswitch
