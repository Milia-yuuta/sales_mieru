<div class="p-pseudo_modal" id="modal_prospect_delete">
  <div class="c-modal" data-option="w-560" style="width: 400px">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="head">
      <p class="ttl" style="text-align: center">見込を削除しますか？</p>
    </div>
    <form action="{{ route('prospect.delete',$firstProspect->id) }}" method="post" accept-charset="utf-8" autocomplete="off">
      @CSRF
      @method('DELETE')
      <div class="foot">
        <div class="btnarea" data-flex="justify-center">
          <input class="btn" type="submit" value="削除する" style="background-color: indianred; color: white">
        </div>
      </div>
    </form>
  </div>
</div>
