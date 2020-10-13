<script src="@url('library/ckeditor/ckeditor.js')" charset="utf-8"></script>

<style media="screen">
.field-border{
  border-style: solid;
  border-radius: 5px;
  padding: 8px;
}

.small-border{
  border-style: solid;
  border-radius: 5px;
  padding: 4px;
}

.hide{
  display: none;
}
.uk-sortable-handle{
  width: 20px;
  height: 15px;
  background: rgb(77, 74, 74);
  margin-top: -5px;
  margin-left: -8px;
  margin-bottom: -8px;
}
</style>

<div class="uk-container">

  <div class="uk-card uk-card-body">

    <div class="uk-flex-middle" uk-grid>
      <div class="uk-width-1-3">
        <div class="">
          <label>Config Name</label>
          <input id="main-name" type="text" class="uk-input uk-form-small" name="" value="{{$config->name??''}}">
        </div>
      </div>


      <div id="main-action" class="uk-width-2-3 uk-text-center">
        <div class="uk-margin-top">
          <button onclick="newTextItems()" class="uk-button uk-button-default" style="color:white;" type="button" name="button">Add Input</button>
          <button onclick="addTextareaItems()" class="uk-button uk-button-default" style="color:white;" type="button" name="button">Add Textarea</button>
          <button onclick="addItem()" class="uk-button uk-button-default" style="color:white;" type="button" name="button">Add Items</button>
        </div>
      </div>
    </div>



    <div id="items-content" class="">

      <!-- text sample -->
      <div id="text-sampel" item="main" item-type="1" class="field-border uk-margin hide">
        <div class="uk-margin " uk-grid>

          <div class="uk-width-1-3" >
            <div class="uk-margin">
              <input item="key" type="text" class="uk-input uk-form-small" placeholder="key" name="key" value="">
            </div>
          </div>

          <div class="items-text-main uk-width-2-3">

            <div class="items-text" uk-sortable="handle: .uk-sortable-handle">

              <div id="text-sampel-input-box" class="item-text uk-margin ">
                <div class="uk-sortable-handle"></div>
                <input data-use="yes" item="data" type="text" class="uk-input uk-form-small" placeholder="Data" value="">
                <textarea data-use="no" item="data" style="display:none;" class="uk-textarea"></textarea>

                <div class="uk-text-right uk-flex uk-flex-between uk-margin-small">
                  <input item="value" class="uk-input uk-form-width-fit uk-form-small" type="text" placeholder="value(optional)">
                  <button btn="remove" onclick="textField.removeInputBox($(this))" type="button" class="c-btn-icon color-red" name="button"><i class="fas fa-trash"></i></button>
                </div>
              </div>

            </div>

            <div class="">
              <button btn="add-input" onclick="textField.addInput($(this))" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Add Input; pos: top"><i class="fas fa-plus" ></i></button>
              <button btn="add-textarea" onclick="textField.addTextarea($(this))" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Add Textarea; pos: top"><i class="fas fa-plus"></i><i class="fas fa-paragraph"></i></button>
            </div>

          </div>


        </div>

        <div class="">
          <button btn="remove" onclick="textField.removeMain($(this))" type="button" class="c-btn-icon color-red" name="button"    uk-tooltip="title: Remove this item; pos: top"><i class="fas fa-trash"></i></button>
        </div>
      </div>

      <!-- items sample -->
      <div id="item-sampel" item="main" item-type="2" class="field-border uk-margin hide">

        <div class="" uk-grid>
          <div class="uk-width-1-3@s">
            <label>Items Key</label>
            <input item="main-key" type="text" class="uk-input uk-form-small" name="" value="">
          </div>

          <div class="uk-width-1-3@s">
            <label>Data</label>
            <input item="main-data" type="text" class="uk-input uk-form-small" name="" value="">
          </div>

        </div>


        <div class="uk-padding-small item-sampel-items-text" >

        </div>

        <div class="uk-padding-small">
          <button onclick="itemField.addChildItem($(this));" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Add item; pos: top" ><i class="fas fa-plus"></i></button>
          <button onclick="textField.removeMain($(this))" type="button" class="c-btn-icon color-red" name="button"    uk-tooltip="title: Remove this item; pos: top"><i class="fas fa-trash"></i></button>
        </div>

      </div>


    </div>

  </div>

  <div class="uk-margin uk-text-center uk-padding">
    <button onclick="save()" type="button" class="uk-button uk-button-primary uk-width-small" name="button">Save</button>
  </div>
</div>

<script type="text/javascript">

textField = new function() {
  this.textMainOb     = $('#text-sampel');
  this.inputBoxOb = $('#text-sampel-input-box');

  this.cloneMain = function () {
    var item = this.textMainOb.clone();
    item.removeAttr('id').removeClass('hide');
    return item;
  }

  this.cloneThisMainItem = function (btn) {
    var item = btn.closest('.field-border').clone();
    item.removeAttr('id').removeClass('hide');
    item.find('input,textarea').val('');
    appendToMainItems(item);
    return item;
  }

  this.cloneInputBox = function () {
    var item = this.inputBoxOb.clone();
    item.removeAttr('id');
    return item;
  }

  this.addMain = function () {
    var main = this.cloneMain();
    appendToMainItems(main);
    return main;
  }


  this.appendToItemsText=function (box,btn) {
    var items = btn.closest('.items-text-main').find('.items-text');
    items.append(box);
    return this;
  }

  this.addInput=function (btn) {
    var box = this.cloneInputBox();
    this.appendToItemsText(box,btn);
    return box;
  }

  this.initTextarea = function (box) {

    box.find('input[item="data"]').data('use','no').fadeOut(0);
    box.find('textarea').fadeIn(0).data('use','yes'); // :)

    ck_editro = CKEDITOR.replace( box.find('textarea').get(0) );
    box.prop('editro',ck_editro);
    return ck_editro;
  }

  this.addTextarea=function (btn) {
    var box = this.cloneInputBox();
    var editor = this.initTextarea(box);
    this.appendToItemsText(box,btn);
    return {box:box,editor:editor};
  }

  this.removeInputBox = function (btn) {
    btn.closest('.item-text').remove();
  }

  this.removeMain = function (btn) {
    btn.closest('.field-border').remove();
  }

}


function appendToMainItems(item) {
  $('#items-content').append(item);
}

function newTextItems() {
  textField.addMain();
}

function addTextareaItems() {
  var main = textField.addMain();
  textField.initTextarea(main.find('.item-text'));
}


itemField = new function() {

  this.itemMainOb = $('#item-sampel');

  this.cloneMain = function () {
    var item = this.itemMainOb.clone();
    item.removeAttr('id').removeClass('hide');
    return item;
  }

  this.addMain = function () {
    var main = this.cloneMain();
    appendToMainItems(main);
    return main;
  }

  this.addItem = function (main) {
    var item  = textField.cloneMain();
    main.find('.item-sampel-items-text').append(item);
  }

  this.addChildItem = function(btn) {
    var main = btn.closest('.field-border');
    itemField.addItem(main);
  }

  this.cloneThisMainItem = function (btn) {
    var item = btn.closest('.field-border').clone();
    item.removeAttr('id').removeClass('hide');
    item.find('input,textarea').val('');

    var items = btn.closest('.item-sampel-items-text');

    items.append(item);
    return item;
  }
}

function addItem() {
  var main = itemField.addMain();
  itemField.addItem(main);
  main.find('button[btn="clone"]').attr('onclick','itemField.cloneThisMainItem($(this))');

}

function getParams(field) {

  var items={};
  var _type={};

  $('#items-content>div[item="main"]:not(#text-sampel,#item-sampel)').each(function(index,html){
    field = $(this);
    item_type = field.attr('item-type');

    if (item_type==1) {
      get = getType1Params(field);

      items[get.key]=get.items;
      _type[get.key]='type_1';
    }
    else {


      main_key = field.find('input[item="main-key"]').val();
      main_data = field.find('input[item="main-data"]').val();

      _type[main_key]='type_2';

      var child = {};

      field.find('.item-sampel-items-text>div[item="main"]').each(function () {
        get = getType1Params($(this));
        child[get.key]=get.items;
      });

      items[main_key]={data:main_data,params:child};
    }

  });

  items['_type']=_type;

  return items;
}
function getType1Params(field) {
  key = field.find('input[name="key"]').val();


  var items_text_ob = field.find('.items-text .item-text');

  if (items_text_ob.length>1) {
    var items_text=[];
  }
  else {
    var items_text={};
  }

  items_text_ob.each(function () {
    var item = $(this);

    data_type='input';

    if (item.find('input[item="data"]').data('use')=='yes') {
      var data = item.find('input[item="data"]').val();
    }
    else {
      var data = item.prop('editro').getData();
      data_type='textarea';
    }

    var params ={
      data:data,
      value:item.find('input[item="value"]').val(),
      data_type:data_type
    }

    if (items_text_ob.length>1) {
      items_text.push(params);
    }
    else {
      items_text=params;
    }


  });

  return {key:key,items:items_text};
}



function save() {

  params = getParams();
  console.log('params',params);
  if (params ==false) {
    return;
  }

  var config_name = $('#main-name').val();

  if (config_name==='') {
    UIkit.modal.alert('Please enter the config name');
    return;
  }

  post('@url("admin/settings/items/save")',{
    config_name:config_name,
    params:params
  },function (get) {

    loading(false);

    if (get.ok) {
      notifi_success();
      reload()
    }

  })
}

@if(isset($config))


var json = {!! json_encode($config->value) !!};

var _type = json._type;

for (var key in json) {
  if (json.hasOwnProperty(key)) {

    if (key=='_type') {
      continue;
    }

    generateItems(key,json[key]);
  }
}
@endif

function generateItems(key,items) {
  if (_type[key]=='type_1') {
    initType1(key,items);
  }
  else {
    initType2(key,items);
  }
}

function initType2(key,items) {

  main = itemField.addMain();
  main.find('input[item="main-key"]').val(key);
  main.find('input[item="main-data"]').val(items.data);

  for (var _key in items.params) {
    if (items.params.hasOwnProperty(_key)) {
      var _items = items.params[_key];
      var _textClone = textField.cloneMain();
      main.find('.item-sampel-items-text').append(_textClone);
      initType1(_key,_items,_textClone);
    }
  }

}

function initType1(key,items,main=false) {

  if (main==false) {
    main = textField.addMain();
  }

  main.find('.item-text').remove();

  main.find('input[item="key"]').val(key);

  if (! Array.isArray(items)) {
    if (items.data_type=='input') {
      box = textField.addInput(main.find('button[btn="add-input"]'));

      box.find('input[item="data"]').val(items.data)
      box.find('input[item="value"]').val(items.value)
    }
    else {
      te = textField.addTextarea(main.find('button[btn="add-textarea"]'));
      te.editor.setData(items.data);
      te.box.find('input[item="value"]').val(items.value)
    }
  }
  else {
    for (var item of items) {
      initItem(main,item);
    }
  }
}

function initItem(main,item) {

  if (item.data_type=='input') {
    box = textField.addInput(main.find('button[btn="add-input"]'));
    box.find('input[item="data"]').val(item.data)
    box.find('input[item="value"]').val(item.value)
  }
  else {
    te = textField.addTextarea(main.find('button[btn="add-textarea"]'));
    te.editor.setData(item.data);
    te.box.find('input[item="value"]').val(item.value)
  }

}

</script>
