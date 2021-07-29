<div class="c-pursuit_report" data-option="style-excavation" >
  <div class="head" >
    <p class="ttl" style="background: #FCDB8B9E">前取</p>
  </div>
  <div class="body">
    <div class="stack">
      <p class="ttl">前取反響</p>
    </div>
    <div class="stack" data-flex="align-center justify-end">
      <p data-label="color-blue">見込発生数</p>
      <p data-label="color-pink">媒介数</p>
    </div>
    <div class="stack" style="overflow-x: hidden">
      <div class="p-scroll_pursuit barGraphTarget" @if(count($individualReport['area']['visit']['bar']['user']) > 8) style="width: {{count($individualReport['area']['visit']['bar']['user'])*40}}px" @endif>
      <div class="p-scroll_pursuit barGraphTarget">
        <canvas id="pre_re_bar" height="200"></canvas>
      </div>
    </div>
  </div>
  <div class="foot">
    <div class="p-scroll_pursuit">
      <canvas id="pre_re_rate" height="300"></canvas>
    </div>
  </div>
</div>
</div>