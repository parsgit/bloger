<div class="uk-card uk-card-body">

  <h4 class="uk-margin uk-text-center uk-text-bold" >Edit information</h4>

  <form id="edit-info-form">

    <div class="uk-margin uk-child-width-1-2@s" uk-grid>

      <div>
        <div>
          <label>Username</label>
          <input autocomplete="off" placeholder=".." type="text" class="uk-input" name="username" value="{{$myuser->username}}">
        </div>
      </div>

      <div>
        <div>
          <label>Name</label>
          <input autocomplete="off" placeholder=".." type="text" class="uk-input" name="name" value="{{$myuser->name}}">
        </div>
      </div>

      <div>
        <div>
          <label>Email</label>
          <input autocomplete="off" placeholder="" type="text" class="uk-input" name="email" value="{{$myuser->email}}">
        </div>
      </div>

      @if($myuser->id!=$user->id)
      <div>
        <div>
          <label>Role</label>
          <select class="uk-select" name="type">
            <option value="author" {{($myuser->type=='author')?'selected':''}} >author</option>
            <option value="editor" {{($myuser->type=='editor')?'selected':''}} >editor</option>
            <option value="administrator" {{($myuser->type=='administrator')?'selected':''}} >administrator</option>
          </select>
        </div>
      </div>
      @endif

    </div>

    <input type="hidden" name="image" value="">
    <input type="hidden" name="user_id" value="{{$myuser->id}}">

  </form>

  <div id="profile-image-div" class="uk-margin-auto profile-image-div {{!(empty($myuser->image))?'showimage':''}}">
    <i class="fas fa-user color-orange"></i>
    <i onclick="$('#input-image').click()" class="uk-link fas fa-plus-square"></i>
    <i onclick="removeImage()" class="uk-link fas fa-minus"></i>

    <img src="" alt="">
  </div>

  <div uk-form-custom>
    <input id="input-image" accept=".png,.jpg" type="file" multiple>
  </div>
  <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>


  <div class="uk-margin uk-text-center uk-margin-medium-top">
    <button onclick="SaveChenge()" type="button" class="uk-button c-button-teal" name="button">Save Change</button>
  </div>

</div>


<div class="uk-card uk-card-body uk-margin">

  <h4 class="uk-margin uk-text-center uk-text-bold" >Change Password</h4>

  <form id="edit-password-form">

    <div class="uk-margin uk-child-width-1-3@m uk-flex-center" uk-grid>

      @if(! $isAdmin)
      <div>
        <div>
          <label>Old Password</label>
          <input autocomplete="off" placeholder="*****" type="password" class="uk-input" name="old_password" value="">
        </div>
      </div>

      @endif

      <div>
        <div>
          <label>New Password</label>
          <input autocomplete="off" placeholder="*****" type="password" class="uk-input" name="password" value="">
        </div>
      </div>

      <div>
        <div>
          <label>Confirm New Password</label>
          <input autocomplete="off" placeholder="*****" type="password" class="uk-input" name="confirm_password" value="">
        </div>
      </div>

    </div>

    <input type="hidden" name="user_id" value="{{$myuser->id}}">


    <div class="uk-margin uk-margin-medium-top uk-text-center">
      <button onclick="ChangePassword()" type="button" class="uk-button c-button-teal" name="button">change password</button>
    </div>
  </form>
</div>



<script type="text/javascript">
var bar = document.getElementById('js-progressbar');

upload = UIkit.upload('#input-image', {

  url: '@url("admin/upload")',
  name:'file',
  multiple:true,
  params:{
    category:'profile/image',
    storage:'storage',
    save_db:false
  },

  beforeSend: function () {
  },
  beforeAll: function () {
  },
  load: function () {
  },
  error: function () {
    console.log('error', arguments);
    error_post()
  },
  complete: function () {
  },

  loadStart: function (e) {

    bar.removeAttribute('hidden');
    bar.max = e.total;
    bar.value = e.loaded;
  },

  progress: function (e) {

    bar.max = e.total;
    bar.value = e.loaded;
  },

  loadEnd: function (e) {
    console.log('loadEnd', arguments);

    bar.max = e.total;
    bar.value = e.loaded;
  },

  completeAll: function (get) {
    console.log('completeAll',get, arguments);

    setTimeout(function () {
      bar.setAttribute('hidden', 'hidden');
    }, 1000);

    response = jQuery.parseJSON(get.response);
    console.log(response);

    if (response.ok) {
      notifi_success();
      $('#edit-info-form input[name="image"]').val(response.name);
      $('#profile-image-div img').attr('src',profile_url+response.name);
      $('#profile-image-div').addClass('showimage');
    }
    else {
      UIkit.modal.alert(response.errors[0].msg);
    }
  }

});

var profile_url = '@url("profile/image/")';

@if(! empty($myuser->image))
$('#profile-image-div img').attr('src',profile_url+'{{$myuser->image}}');
$('input[name="image"]').val('{{$myuser->image}}');
@endif

function removeImage() {
  $('#edit-info-form input[name="image"]').val('');
  $('#profile-image-div img').attr('src','');
  $('#profile-image-div').removeClass('showimage');
}

function SaveChenge() {

  data = new FormData(document.getElementById('edit-info-form'));

  ajax('@url("admin/user/edit")',data,function (get) {
    if (get.ok) {
      loading(false);
      notifi_success();
    }
  });
}

function ChangePassword() {

  data = new FormData(document.getElementById('edit-password-form'));

  ajax('@url("admin/user/edit/password")',data,function (get) {
    if (get.ok) {
      loading(false);
      notifi_success();
      reload();
    }
  });
}

</script>
