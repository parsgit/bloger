<div id="mob-menu" uk-offcanvas>
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>

        <div class="uk-flex-middle uk-padding-small" uk-grid>
          <a href="@url('admin/profile')" class="uk-link">
            <div class="uk-flex-middle uk-flex-center" style="border-radius: 100%;width: 70px;height: 70px;border-style: solid;/*! padding-left: 5px; */" >
              <i class="fas fas fa-user color-orange" style="font-size: 50px;margin-top: 8px;margin-left: 13px;" ></i>
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

        <div class="uk-margin">

          <ul class="uk-nav uk-nav-default">

            @foreach($_menus as $menu)
              <li><a href="{{$menu['link']}}"> <i class="{{$menu['icon']}}"></i> <span>{{$menu['name']}}</span> </a></li>
            @endforeach

          </ul>

        </div>
    </div>
</div>
