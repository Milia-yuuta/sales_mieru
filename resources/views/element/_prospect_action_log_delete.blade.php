<div class="p-pseudo_modal" id="modal_prospect_action_log_delete">
  <div class="c-modal" data-option="w-560" style="width: 400px">
    <button data-remodal-action="close" class="remodal-prospect_action_log_delete_close remodal-close"></button>
    <div class="head">
      <p class="ttl" style="text-align: center">追客行動を削除しますか？</p>
    </div>
    <form action="{{ route('prospectActionLog.delete') }}" method="post" accept-charset="utf-8" autocomplete="off">
      @CSRF
      @method('DELETE')
      {{Form::hidden('prospect_action_log_id', 0, ['class' => 'delete_prospectActionLog'])}}
      {{Form::hidden('next_prospect_action_log_id', 0, ['class' => 'delete_nextProspectActionLog'])}}
      <div class="foot">
        <div class="btnarea" data-flex="justify-center">
          <input class="btn" type="submit" value="削除する" style="background-color: indianred; color: white; border: indianred">
        </div>
      </div>
    </form>
  </div>
</div>
