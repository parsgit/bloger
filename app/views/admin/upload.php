<div class="uk-card uk-card-body">

  <div class="uk-text-center">
    <h5>Upload File</h5>
  </div>

  <div class="" uk-grid>
    <div class="uk-width-auto">
      <div class="">
        <label>Select Category</label>
        <select onchange="setCategory($(this))" id="select-category" class="uk-select">
          <option value="content" >/</option>

          @foreach($categorys as $category)
          <option value="content/{{$category->name}}" >{{$category->name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Storage location</label>
        <select onchange="setStorageType($(this))" class="uk-select">
          <option value="public" >public</option>
          <option value="storage" >storage</option>
        </select>
      </div>
    </div>

  </div>

  <div class="js-upload uk-placeholder uk-text-center">
    <span uk-icon="icon: cloud-upload"></span>
    <span class="uk-text-middle color-white">Attach binaries by dropping them here or</span>
    <div uk-form-custom>
      <input type="file" multiple>
      <span class="uk-link color-orange">selecting one</span>
    </div>
  </div>

  <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

</div>

<div class="uk-card uk-card-body uk-margin">

  <div class="uk-text-center">
    <h5>List</h5>
  </div>

  <div class="uk-flex-bottom" uk-grid>
    <div class="uk-width-auto">
      <div class="">
        <label>Select Category</label>
        <select id="select-get-list-category" onchange="setCategoryList($(this))" id="select-category" class="uk-select">
          <option value="content" >/</option>

          @foreach($categorys as $category)
          <option value="content/{{$category->name}}" >{{$category->name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Storage location</label>
        <select id="select-get-list-storage" onchange="setStorageTypeList($(this))" class="uk-select">
          <option value="public" >public</option>
          <option value="storage" >storage</option>
        </select>
      </div>
    </div>

    <div class="uk-width-auto " style="margin-left:auto;">
      <div style="width: 220px;">
        <form class="uk-search uk-search-default">
          <span uk-search-icon></span>
          <input  oninput="searchList($(this))" autocomplete="off"  style="background: white;" class="uk-search-input uk-input" type="search" placeholder="Search...">
        </form>
      </div>
    </div>

  </div>

  <hr>

  <div class="uk-margin uk-flex-center" id="file-items" uk-grid>

    <div id="file-item-sample" class="item-in-card-main" style="width: 200px;display:none;">
      <div class="item-in-card">
        <div class="item-image">
          <img src="" alt="" style="display:none;">
          <i class="fas fa-file-download"></i>
        </div>

        <div class="item-type">

        </div>

        <div class="item-name">

        </div>

        <div class="item-input">
          <input id="input" style="display:none;" type="text"/>
        </div>

        <div class="item-btns">
          <i btn-copy onclick="copyUrl($(this))" class="uk-link fas fa-copy color-white"></i>
          <i onclick="editNameMessage($(this))" class="uk-link fas fa-edit color-greenyellow"></i>
          <i btn-remove onclick="deleteFileMessage($(this))" class="uk-link fas fa-trash-alt color-orange"></i>
        </div>
      </div>
    </div>

  </div>


</div>

<script>

var category = 'content';
var storage  = 'public';

function setCategory(e) {
  category = e.val();
  upload.params['category']=category;

}

function setStorageType(e) {
  storage = e.val();
  upload.params['storage']=storage;
}


var bar = document.getElementById('js-progressbar');

upload = UIkit.upload('.js-upload', {

  url: '@url("admin/upload")',
  name:'file',
  multiple:true,
  params:{
    category:category,
    storage:storage
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
      console.log();
      $('#select-get-list-category').val(upload.params.category).change();
      $('#select-get-list-storage').val(upload.params.storage).change();
      getFileList();
    }
    else {
      UIkit.modal.alert(response.errors[0].msg);
    }
  }

});


var categoryList = 'content';
var storageList  = 'public';

function setCategoryList(e) {
  categoryList = e.val();
  getFileList();
}

function setStorageTypeList(e) {
  storageList = e.val();
  getFileList();
}


function getFileList() {
  post('@url("admin/file/list")',{
    category:categoryList,
    storage:storageList
  },function (get) {
    loading(false);
    generateList(get.list)
  })
}

$(function () {
  getFileList();
})

function generateList(list) {
  $('#file-items>div:not(#file-item-sample)').remove();
  for(item of list){
    cloneNewFile(item);
  }

  setTimeout(function () {
    loading(false);
  },500);

}

base_file_url = '{{url()}}';

function cloneNewFile(info) {
  item = $('#file-item-sample').clone();
  item.removeAttr('id').data('id',info.id);
  item.find('.item-name').text(info.name);
  item.find('.item-type').text(info.type+' - '+info.ext);

  info.name = encodeURI(info.name);

  if (info.location=='public') {
    url = base_file_url+info.category+'/'+info.name;
  }
  else {
    url = base_file_url+'file/image/'+info.category+'/'+info.name;
  }

  item.data('url',url);
  item.find('input').val(url)

  if (info.type.indexOf('image')>-1) {
    item.find('.item-image>i').fadeOut(0);
    item.find('.item-image>img').fadeIn(0).attr('src',url);
  }

  item.css('display','');

  $('#file-items').append(item);
}

function copyUrl(i) {
  console.log('copy run');
  var input = i.closest('.item-in-card-main').find('input');
  input.css('display','');

  copyText = input.get(0);

  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  document.execCommand("copy");
  input.css('display','none');

  notifi_success('Copyed.');
}



function deleteFileMessage(i){
  var main = i.closest('.item-in-card-main');

  id = main.data('id');
  name = main.find('.item-name').text();

  delete_message({id:id,name:name},"Delete '"+name+"' file?",deleteFile);
}

function deleteFile(data) {
  post('@url("admin/file/remove")',data,function (get) {
    if (get.ok) {
      notifi_success();
      getFileList();
    }
  })
}

function searchList(input) {
  $("#file-items .item-in-card-main:not(#file-item-sample)").filter(function() {
    item = $(this).find('.item-name').text().toLowerCase().indexOf(input.val());
    $(this).toggle(item > -1)
  });
}

function editNameMessage(btn) {

  item = btn.closest('.item-in-card-main');
  _edit_item_id = item.data('id');
  name = item.find('.item-name').text();
  UIkit.modal.prompt('Edit :',name).then(function (input) {
    editName(input,name,_edit_item_id)
  })
}

function editName(name,old,id) {

  console.log(old,name,_edit_item_id);

  if (name==null || name =='' || name == old) {
    return;
  }

  post('@url("admin/file/edit")',{
    name:name,
    id:id
  },function (get) {
    if (get.ok) {

      notifi_success();

      getFileList();

    }
  });
}

</script>
