<script src="@url('library/jquery/jquery-3.3.1.min.js')"></script>
<script src="@url('js/public.js')"></script>

<link rel="stylesheet" href="@url('css/panel-style.css')">

<!-- <link rel="stylesheet" href="@url('css/panel-style-white.css')"> -->
<link rel="stylesheet" href="@url('css/panel-style-dark.css')">

<link rel="stylesheet" href="@url('library/icon/css/all.min.css')">

  <div>
    @view('admin/canvas',$_all)

    <div class="uk-flex" uk-height-viewport="expand: true">

      <div  class="uk-visible@m panel-sidebar" >
        <div uk-sticky style="max-height: 100%;overflow: auto;">

          <div class="uk-flex-middle uk-padding-small" style="background: #444242;" uk-grid>
            <a href="@url('admin/user/profile')" class="uk-link">
              <div  class="uk-margin-auto profile-image-div {{($user->image!=null)?'showimage':''}}">
                <i class="fas fa-user color-orange"></i>
                @if($user->image!=null)
                <img src="@url('profile/image/'.$user->image)" alt="">
                @endif
              </div>
            </a>

            <div class="uk-width-expand uk-text-center uk-padding-remove-left">
              <div class="color-orange uk-text-bold">
                {{$user->name}}
              </div>
              <div class="">
                {{$user->username}}
              </div>
            </div>

          </div>

          <div class="uk-margin-small-top">

            <ul class="uk-nav uk-nav-default">
              @foreach($_menus as $menu)
                <li><a href="{{$menu['link']}}"> <i class="{{$menu['icon']}}"></i> <span>{{$menu['name']}}</span> </a></li>
              @endforeach
            </ul>

          </div>




        </div>
      </div>

      <div class="uk-width-expand panel-content-main">
        @view('admin/navbar')

        <div class="uk-container uk-margin-top">
          @view($_content,$_all)
        </div>
      </div>

    </div>
  </div>
