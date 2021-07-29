<!-- フラッシュメッセージ -->
@if (session('flash_message'))
<section class="area_flash">
  <ul class="list_flash">
    <li class="flash_success flash_fixed">
      <article class="link_float">
        <div class="data">
          <p>{{ session('flash_message') }}</p>
        </div>
      </article>
    </li>
  </ul>
</section>
@elseif(session('flash_error'))
  <section class="area_flash">
    <ul class="list_flash">
      <li class="flash_warning flash_fixed">
        <article class="link_float">
          <div class="data">
              <p style="color: red">{{ session('flash_error') }}</p>
          </div>
        </article>
      </li>
    </ul>
  </section>
@endif