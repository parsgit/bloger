<div class="uk-card uk-card-body">

  <ul uk-accordion>
    <li>
      <a class="uk-accordion-title" href="#">Add User <i class="fas fa-user-plus"></i></a>
      <div id="user-add-content" class="uk-accordion-content">
        <form id="add-form">

          <div class="uk-margin uk-child-width-1-3@s" uk-grid>

            <div>
              <div>
                <label>Username</label>
                <input autocomplete="off" placeholder=".." type="text" class="uk-input" name="username" value="">
              </div>
            </div>

            <div>
              <div>
                <label>Name</label>
                <input autocomplete="off" placeholder=".." type="text" class="uk-input" name="name" value="">
              </div>
            </div>

            <div>
              <div>
                <label>Email</label>
                <input autocomplete="off" placeholder="" type="text" class="uk-input" name="email" value="">
              </div>
            </div>

          </div>

          <hr>

          <div class="uk-margin uk-child-width-1-3@m" uk-grid>

            <div>
              <div>
                <label>Password</label>
                <input autocomplete="off" placeholder="*****" type="password" class="uk-input" name="password" value="">
              </div>
            </div>

            <div>
              <div>
                <label>Confirm Password</label>
                <input autocomplete="off" placeholder="*****" type="password" class="uk-input" name="confirm_password" value="">
              </div>
            </div>

            <div>
              <div>
                <label>Role</label>
                <select class="uk-select" name="type">
                  <option value="author">author</option>
                  <option value="editor">editor</option>
                  <option value="administrator">administrator</option>
                </select>
              </div>
            </div>

          </div>


          <div class="uk-margin uk-text-center">
            <button onclick="addUser()" type="button" class="uk-button c-button-teal" name="button">Add User</button>
          </div>
        </form>



      </div>
    </li>
  </ul>

</div>

<div class="uk-card uk-card-body uk-margin">

  <table class="uk-table uk-table-striped uk-margin">
    <thead>
      <tr>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody>
      @foreach($list??[] as $myuser)
      <tr>
        <td>{{$myuser->name}}</td>
        <td>{{$myuser->username}}</td>
        <td>{{$myuser->email}}</td>
        <td>{{$myuser->type}}</td>
        <td>
          <button onclick="removeUserMessage({{$myuser->id}},'{{$myuser->username}}')" class="c-btn-icon color-red"> <i class="fas fa-trash"></i> </button>
          <button onclick="" class="c-btn-icon color-green"> <i class="fas fa-edit"></i> </button>

        </td>
      </tr>

      @endforeach

    </tbody>
  </table>

</div>


<script type="text/javascript">
  function addUser() {

    data = new FormData(document.getElementById('add-form'));

    ajax('@url("admin/user/add")',data,function (get) {
      if (get.ok) {
        notifi_success();
        reload();
      }
    });

  }

  function removeUserMessage(id,username) {
    delete_message({id:id},'Delete user "'+username+'" ?',removeUser);
  }
  function removeUser(params) {
    post('@url("admin/user/remove")',params,function (get) {
      if (get.ok) {
        notifi_success();
        reload();
      }
    })
  }
</script>
