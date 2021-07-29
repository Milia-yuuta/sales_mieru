<div class="foot_stock">
  <div class="l">
    <div class="l_fix">
      <ul class="c-list">
        <li>
          <div class="head">
            <p class="ttl">判別手段無</p>
          </div>
          <div class="cnt">
            <span class="c-count" id="{{$data['id']}}" data-status="DiscriminationNoMeansCount" data-option="discrimination">{{$data['DiscriminationNoMeansCount']}}</span>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">潜在長期</p>
          </div>
          <div class="cnt">
            <span class="c-count" id="{{$data['id']}}" data-status="LongLatentCount" data-option="latent">{{$data['LongLatentCount']}}</span>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">潜在MA</p>
          </div>
          <div class="cnt">
            <span class="c-count" id="{{$data['id']}}" data-status="ActualThisLatentCount" data-option="latent">{{$data['ActualThisLatentCount']}}</span>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">顕在来期</p>
          </div>
          <div class="cnt">
            <span class="c-count" id="{{$data['id']}}" data-status="OvertNextSeasonCount" data-option="overt">{{$data['OvertNextSeasonCount']}}</span>
          </div>
        </li>
      </ul>
    </div>
    <div class="l_auto" data-option="line-left">
      <div class="l" data-space="20">
        <div class="l_fix" data-flex="align-center">
          <p class="ttl">今月</p>
        </div>
        <div class="l_auto">
          <ul class="list_count" data-optoin="style-double">
            <li>
              <div class="head">
                <p class="ttl">専任</p>
              </div>
              <div class="cnt">
                <span class="c-count" id="{{$data['id']}}" data-status="FullServiceCount" data-option="style-square mediation">{{$data['FullServiceCount']}}</span>
              </div>
            </li>
            <li>
              <div class="head">
                <p class="ttl">売主</p>
              </div>
              <div class="cnt">
                <span class="c-count" id="{{$data['id']}}" data-status="sellerCount" data-option="style-square mediation">{{$data['sellerCount']}}</span>
              </div>
            </li>
            <li>
              <div class="head">
                <p class="ttl">一般</p>
              </div>
              <div class="cnt">
                <span class="c-count" id="{{$data['id']}}" data-status="panpyCount" data-option="style-square mediation">{{$data['panpyCount']}}</span>
              </div>
            </li>
            <li>
              <div class="head">
                <p class="ttl">専属</p>
              </div>
              <div class="cnt">
                <span class="c-count" id="{{$data['id']}}" data-status="exclusiveCount" data-option="style-square mediation">{{$data['exclusiveCount']}}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>