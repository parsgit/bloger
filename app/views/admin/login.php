<script src="@url('library/jquery/jquery-3.3.1.min.js')"></script>
<script src="@url('js/public.js')"></script>
<link rel="stylesheet" href="@url('library/icon/css/all.min.css')">

<link rel="stylesheet" href="@url('css/login.css')">


<div class="uk-flex uk-flex-middle uk-flex-center" style="background: rgb(22, 149, 149);" uk-height-viewport="expand: true">
  <div class="uk-width-large uk-card uk-card-body uk-card-default uk-card-hover">
    <div class="">

      <form id="form"  method="post">


        <div class="uk-margin">
          <h4 class="uk-text-center color-orange uk-text-bold" style="color: #99948b;" >Login User</h4>
        </div>

        <div class="uk-margin">
          <label>Username</label>
          <input type="text" class="uk-input" name="username" value="">
        </div>

        <div class="uk-margin">
          <label>Password</label>
          <input type="password" class="uk-input" name="password" value="">
        </div>

        <div class="uk-margin uk-margin-medium-top">
          <div class="uk-child-width-1-2@m" uk-grid>

            <div class="uk-position-relative">

              <div class="">
                <img class="uk-width-1-1" id="captcha" src="{!! $captcha !!}" />
              </div>
              <div class="captcha" >
                <i onclick="newCaptcha($(this))" class="fas fa-sync-alt" ></i>
              </div>

            </div>

            <div class="">
              <div class="">
                <input type="text" class="uk-input" name="captcha" value="">
              </div>
            </div>
          </div>
        </div>

        <div class="uk-margin uk-margin-medium-top">
          <button onclick="login()" type="button" class="uk-width-1-1 uk-button uk-button-primary">Login</button>
        </div>

      </form>

    </div>
  </div>
</div>


<script type="text/javascript">
  function login(){

    data = new FormData(document.getElementById('form'));

    ajax('@url("login")',data,function (get) {
      if (get.ok) {
        window.location.href='@url("admin")';
      }
      else if(get.ok==false) {
        $('#captcha').attr('src',get.captcha);
        $('input[name="captcha"]').val('');
      }
    });
  }

  function newCaptcha(btn) {
    btn.fadeOut();
    ajax('@url("captcha/new")',{},function (get) {
      if (get.ok) {
        $('#captcha').attr('src',get.captcha);
        $('input[name="captcha"]').val('');
        loading(false);
      }

      setTimeout(function () {
        btn.fadeIn();
      },10000);
    });
  }
</script>
