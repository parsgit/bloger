<nav class="navbar navbar-dark navbar-expand py-3" style="background: #4c4262;">
  <div class="nav-item">
    @if($site->nav_brand??false)
    <a class="navbar-brand" href="@url($site->nav_brand->value)">{{$site->nav_brand->data}}</a>
    @endif
  </div>


    @foreach($site->nav as $key=>$nav)
    <div class="nav-item">
      <a class="nav-link" href="@url($nav->value)">{{$nav->data??''}}</a>
    </div>
    @endforeach

</nav>
