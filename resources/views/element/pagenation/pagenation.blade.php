<div class="c-pager">
    <div class="total">
        <p data-total="{{ number_format($PageNationInstance->total()) }}">{{$PageNationInstance->lastItem()}}</p>
    </div>
    <ul class="area_pager">
        {{ $PageNationInstance->appends(request()->input())->links('vendor.pagination.default') }}
    </ul>
</div>