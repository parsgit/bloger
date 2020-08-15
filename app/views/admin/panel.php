<link rel="stylesheet" href="@url('css/panel-style.css')">
<link rel="stylesheet" href="@url('css/panel-style-white.css')">
<link rel="stylesheet" href="@url('library/icon/css/all.min.css')">

  <div>
    @view('admin/canvas')
    @view('admin/navbar')

    <div class="uk-flex" uk-height-viewport="expand: true">

      <div  class="uk-visible@m panel-sidebar">
        <div class="uk-margin-small-top">

          <ul class="uk-nav uk-nav-default">
            <li><a href="@url('admin/category')"> <i class="fas fa-stream"></i> Category</a></li>
            <li><a href="@url('admin/posts')"> <i class="fas fa-file-alt"></i> Post</a></li>
            <li><a href="@url('admin/settings')"> <i class="fas fa-cogs"></i> Setting</a></li>
          </ul>

        </div>
      </div>

      <div class="uk-width-expand panel-content-main">
        <div class="uk-container uk-margin-top">
          @view($_content,$_all)
        </div>
      </div>

    </div>
  </div>
