<div class="c-pursuit_report" data-option="style-excavation" >
    <div class="head" >
        <p class="ttl" style="background: #3B96DD">社内発掘</p>
    </div>
    <div class="body">
        <div class="stack">
            <p class="ttl">個人TEL</p>
        </div>
        <div class="stack" data-flex="align-center justify-end">
            <p data-label="color-green">行動量</p>
            <p data-label="color-blue">見込発生数</p>
            <p data-label="color-pink">媒介数</p>
        </div>
        <div class="stack" data-option="m-20" style="overflow: auto">
            <div class="p-scroll_pursuit barGraphTarget" @if(count($individualReport['area']['visit']['bar']['user']) > 8) style="width: {{count($individualReport['area']['visit']['bar']['user'])*40}}px" @endif>
                <canvas id="company_individual_tel_bar" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="p-scroll_pursuit">
            <canvas id="company_individual_tel_rate" height="300"></canvas>
        </div>
    </div>
</div>