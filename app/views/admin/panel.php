<link rel="stylesheet" href="@url('css/panel-style.css')">

  <div>
    @view('admin/canvas')
    @view('admin/navbar')

    <div class="uk-flex" uk-height-viewport="expand: true">

      <div  class="uk-visible@m panel-sidebar">
        <div class="uk-padding">

          <ul class="uk-nav uk-nav-default">
            <li><a href="#">Item 1</a></li>
            <li><a href="#">Item 1</a></li>
          </ul>

        </div>
      </div>

      <div class="uk-width-expand panel-content-main">
        <div class="uk-padding-small">
          @view($_content,$_all)
        </div>
      </div>

    </div>
  </div>
