@forelse($errors->all() as $error)
  <section class="area_flash">
    <ul class="list_flash">
      <li class="flash_warning flash_fixed">
        <article class="link_float">
          <div class="data">
            @if($error == 'auth.failed')
              <p style="color: red">IDまたはパスワードが間違っています。</p>
            @else
            <p style="color: red">{{$error}}</p>
              @endif
          </div>
        </article>
      </li>
    </ul>
  </section>
@empty
@endforelse