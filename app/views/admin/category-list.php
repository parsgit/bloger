<div class="uk-card uk-card-body uk-width-auto">

  <div class="uk-text-center">
    <h5>Add Category</h5>
  </div>

  <div class="uk-margin uk-width-1-1">
    <label>Title</label>
    <input type="text" id="input-add-category" autocomplete="off" class="uk-input" name="" value="">
  </div>

  <div class="uk-text-center">
    <button onclick="addCategory()" type="button" class="uk-button uk-button-primary" name="button">Add</button>
  </div>

</div>

<div class="uk-card uk-card-body uk-width-auto uk-margin-medium-top">
  <div class="uk-text-center">
    <h5>List</h5>
  </div>

  <table class="uk-table uk-table-striped uk-margin">
    <thead>
      <tr>
        <th>Name</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody>
      @foreach($list as $category)
      <tr>
        <td>{{$category->name}}</td>
        <td>
          <button onclick="deleteCategoryMessage({id:{{$category->id}}})" class="c-btn-icon color-red"> <i class="fas fa-trash"></i> </button>
          <button onclick="editCategoryModal('{{$category->name}}',{{$category->id}})" class="c-btn-icon color-green"> <i class="fas fa-edit"></i> </button>

        </td>
      </tr>

      @endforeach

    </tbody>
  </table>
</div>







<script>


function addCategory() {

  name = $('#input-add-category').val();

  if (name==null || name =='') {
    return;
  }

  post('@url("admin/category/add")',{
    name:name
  },function (get) {
    if (get.ok) {

      notifi_success();

      reload();

    }
  });

}

function deleteCategoryMessage(params){
  delete_message(params,false,deleteCategory);
}

function deleteCategory(data) {
  post('@url("admin/category/remove")',data,function (get) {
    if (get.ok) {
      notifi_success();
      reload();
    }
  })
}

function editCategoryModal(name,id) {
  UIkit.modal.prompt('Edit :',name).then(function (input) {
    editCategory(input,name,id)
  })
}

function editCategory(name,old,id) {

  console.log('id',id);

  if (name==null || name =='' || name == old) {
    return;
  }

  post('@url("admin/category/edit")',{
    name:name,
    id:id
  },function (get) {
    if (get.ok) {

      notifi_success();

      reload();

    }
  });
}
</script>
