<div class="panel_tab">
  <div class="l">
    <div class="l_auto">
      <p class="ttl h6">顧客情報</p>
    </div>
  </div>
  <div class="l" data-space="m-20">
    {{ Form::open( ['route' => ['client.store'], 'method' => 'POST', 'autocomplete' => 'off']) }}
    {{Form::hidden('client_id', $firstProspect?->propertyRooms?->first()?->client?->id)}}
    {{Form::hidden('prospect_id', $firstProspect?->id)}}
    <div class="l_auto">
      <ul class="list_form">
        <div style="display: flex">
          <div>
            <li style="display: flex; height: 35px; align-items: center;">
              <div class="head">
                <p class="ttl">氏名</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-width="130" style="width: 260px">
                    <input type="text"  name="name" placeholder="山田太郎" @isset($firstProspect?->propertyRooms?->first()?->client?->name) value="{{$firstProspect?->propertyRooms?->first()?->client?->name}}" @endisset data-option="style-fill" required >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">郵便番号</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px" data-width="130" data-option="style-unit-before">
                    <span class="unit">〒</span>
                    <input type="text"  name="zip_code" placeholder="1234567" @isset($firstProspect?->propertyRooms?->first()?->client?->zip_code) value="{{$firstProspect?->propertyRooms?->first()?->client?->zip_code}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">

              <div class="head">
                <p class="ttl">住所</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="address1" placeholder="東京都千代田区麹町４丁目５−２２" @isset($firstProspect?->propertyRooms?->first()?->client?->address1) value="{{$firstProspect?->propertyRooms?->first()?->client?->address1}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">番地</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="address2" placeholder="４丁目５−２２" @isset($firstProspect?->propertyRooms?->first()?->client?->address2) value="{{$firstProspect?->propertyRooms?->first()?->client?->address2}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">建物名</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="address3" placeholder="紀伊国町ビル" @isset($firstProspect?->propertyRooms?->first()?->client?->address3) value="{{$firstProspect?->propertyRooms?->first()?->client?->address3}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">担当者</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="address4" placeholder="104" @isset($firstProspect?->propertyRooms?->first()?->client?->address4) value="{{$firstProspect?->propertyRooms?->first()?->client?->address4}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">住所連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="address_check" value="1" name="address_check" @if($firstProspect?->propertyRooms?->first()?->client?->address_check === '1') checked @endif>
                    <label for="address_check"></label>
                  </div>
                </div>
              </div>
            </li>
          </div>
          <div style="margin-left: 145px">
            <li style="display: flex; height: 35px; align-items: center;">
              <div class="head">
                <p class="ttl">TEL</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="tel" placeholder="09012345678"  data-width="140" data-option="style-fill" @isset($firstProspect?->propertyRooms?->first()?->client?->tel) value="{{$firstProspect?->propertyRooms?->first()?->client?->tel}}" @endisset class="num" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">電話連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="tel_check" value="1" name="tel_check" @if($firstProspect?->propertyRooms?->first()?->client?->tel_check === '1') checked @endif>
                    <label for="tel_check"></label>
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">携帯番号</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="text"  name="mobile" placeholder="09012345678"  data-width="140" data-option="style-fill" @isset($firstProspect?->propertyRooms?->first()?->client?->mobile) value="{{$firstProspect?->propertyRooms?->first()?->client?->mobile}}" @endisset class="num" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">携帯番号連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="mobile_check" value="1" name="mobile_check" @if($firstProspect?->propertyRooms?->first()?->client?->mobile_check === '1') checked @endif>
                    <label for="mobile_check"></label>
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">PCメールアドレス</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="email"  name="email" placeholder="sample.info@okuraya.com" @isset($firstProspect?->propertyRooms?->first()?->client?->email) value="{{$firstProspect?->propertyRooms?->first()?->client?->email}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">PCメールアドレス<br>連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="email_check" value="1" name="email_check" @if($firstProspect?->propertyRooms?->first()?->client?->email_check === '1') checked @endif>
                    <label for="email_check"></label>
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">スマートフォンアドレス</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="email"  name="s_mobile_email" placeholder="sample.info@okuraya.com" @isset($firstProspect?->propertyRooms?->first()?->client?->email) value="{{$firstProspect?->propertyRooms?->first()?->client?->s_mobile_email}}" @endisset data-option="style-fill" >
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">スマートフォンアドレス<br>連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="s_mobile_email_check" value="1" name="s_mobile_email_check" @if($firstProspect?->propertyRooms?->first()?->client?->s_mobile_email_check === '1') checked @endif>
                    <label for="s_mobile_email_check"></label>
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">携帯メールアドレス</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" style="width: 260px">
                    <input type="email"  name="mobile_email" placeholder="sample.info@okuraya.com" @isset($firstProspect?->propertyRooms?->first()?->client?->email) value="{{$firstProspect?->propertyRooms?->first()?->client?->mobile_email}}" @endisset data-option="style-fill">
                  </div>
                </div>
              </div>
            </li>
            <li style="display: flex; height: 35px; margin-top: 15px; align-items: center;">
              <div class="head">
                <p class="ttl">携帯メールアドレス<br>連絡可否</p>
              </div>
              <div class="cnt">
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="checkbox" id="mobile_email_check" value="1" name="mobile_email_check" @if($firstProspect?->propertyRooms?->first()?->client?->mobile_email_check === '1') checked @endif>
                    <label for="mobile_email_check"></label>
                  </div>
                </div>
              </div>
            </li>
          </div>
        </div>
        <li>
          <div class="stack">
            <div class="btnarea">
              <button class="btn" data-option="size-l w-full">変更を保存する</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
    {{Form::close()}}
  </div>
</div>