export function lazy_load_script(scriptSrc, target = null) {
  //一回だけ実行するためにおく変数
  let isScrolled = false;

  //スクロールで発火
  if (target == null) {
    target = $("#scroll_target");
  }

  target.scroll(function() {
    oneTimeFunction(false)
  });

  function oneTimeFunction() {
    if (isScrolled) {
      return;
    }

    isScrolled = true;

    const scriptTag = document.createElement('script');
    scriptTag.src = scriptSrc;
    scriptTag.setAttribute("defer", "defer");
    document.body.appendChild(scriptTag)
  }
}