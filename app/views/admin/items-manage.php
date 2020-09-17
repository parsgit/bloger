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
</style>

<div class="uk-container">

  <div class="uk-card uk-card-body">

    <div class="uk-flex-middle" uk-grid>
      <div class="uk-width-1-3">
        <div class="">
          <label>Config Name</label>
          <input id="main-name" type="text" class="uk-input uk-form-small" name="" value="">
        </div>
      </div>


      <div id="main-action" class="uk-width-2-3 uk-text-center">
        <div class="uk-margin-top">
          <button onclick="newTextItems()" class="uk-button uk-button-default" style="color:white;" type="button" name="button">Add Input Items</button>
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
              <input item="name" type="text" class="uk-input uk-form-small" placeholder="Name" name="name" value="">
            </div>
          </div>

          <div class="items-text-main uk-width-2-3">

            <div class="items-text">

              <div id="text-sampel-input-box" class="item-text uk-margin">
                <input data-use="yes" item="data" type="text" class="uk-input uk-form-small" placeholder="Data" value="">
                <textarea data-use="no" item="data" style="display:none;" class="uk-textarea"></textarea>

                <div class="uk-text-right uk-flex uk-flex-between uk-margin-small">
                  <input item="value" class="uk-input uk-form-width-fit uk-form-small" type="text" placeholder="value(optional)">
                  <button onclick="textField.removeInputBox($(this))" type="button" class="c-btn-icon color-red" name="button"><i class="fas fa-trash"></i></button>
                </div>
              </div>

            </div>

            <div class="">
              <button onclick="textField.addInput($(this))" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Add Input; pos: top"><i class="fas fa-plus" ></i></button>
              <button onclick="textField.addTextarea($(this))" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Add Textarea; pos: top"><i class="fas fa-plus"></i><i class="fas fa-paragraph"></i></button>
            </div>

          </div>


        </div>

        <div class="">
          <button btn="clone" onclick="textField.cloneThisMainItem($(this))" type="button" class="c-btn-icon color-white" name="button" uk-tooltip="title: Clone this item; pos: top" ><i class="fas fa-clone"></i></button>
          <button btn="remove" onclick="textField.removeMain($(this))" type="button" class="c-btn-icon color-red" name="button"    uk-tooltip="title: Remove this item; pos: top"><i class="fas fa-trash"></i></button>
        </div>
      </div>

      <!-- items sample -->
      <div id="item-sampel" item="main" item-type="2" class="field-border uk-margin hide">

        <div class="" uk-grid>
          <div class="uk-width-1-3@s">
            <label>Name</label>
            <input item="main-name" type="text" class="uk-input uk-form-small" name="" value="">
          </div>

          <div class="uk-width-1-3@s">
            <label>Value</label>
            <input item="main-value" type="text" class="uk-input uk-form-small" name="" value="">
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

  <div class="uk-margin uk-text-center">
    <button onclick="save()" type="button" class="uk-button uk-button-primary uk-width-small" name="button">Save</button>
  </div>
</div>

<script type="text/javascript">

textField = new function() {
  this.textMainOb     = $('#text-sampel');
  this.inputBoxOb = $('#text-sampel-input-box');

  this.cloneMain = function () {
    let item = this.textMainOb.clone();
    item.removeAttr('id').removeClass('hide');
    return item;
  }

  this.cloneThisMainItem = function (btn) {
    let item = btn.closest('.field-border').clone();
    item.removeAttr('id').removeClass('hide');
    item.find('input,textarea').val('');
    appendToMainItems(item);
    return item;
  }

  this.cloneInputBox = function () {
    let item = this.inputBoxOb.clone();
    item.removeAttr('id');
    return item;
  }

  this.addMain = function () {
    let main = this.cloneMain();
    appendToMainItems(main);
    return main;
  }

  this.appendToItemsText=function (box,btn) {
    let items = btn.closest('.items-text-main').find('.items-text');
    items.append(box);
    return this;
  }

  this.addInput=function (btn) {
    let box = this.cloneInputBox();
    this.appendToItemsText(box,btn);
    return this;
  }

  this.initTextarea = function (box) {

    box.find('input[item="data"]').data('use','no').fadeOut(0);
    box.find('textarea').fadeIn(0).data('use','yes'); // :)

    ck_editro = CKEDITOR.replace( box.find('textarea').get(0) );
    box.prop('editro',ck_editro);
  }

  this.addTextarea=function (btn) {
    let box = this.cloneInputBox();
    this.initTextarea(box);
    this.appendToItemsText(box,btn);
    return this;
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
  let main = textField.addMain();
  textField.initTextarea(main.find('.item-text'));
}


itemField = new function() {

  this.itemMainOb = $('#item-sampel');

  this.cloneMain = function () {
    let item = this.itemMainOb.clone();
    item.removeAttr('id').removeClass('hide');
    return item;
  }

  this.addMain = function () {
    let main = this.cloneMain();
    appendToMainItems(main);
    return main;
  }

  this.addItem = function (main) {
    let item  = textField.cloneMain();
    main.find('.item-sampel-items-text').append(item);
  }

  this.addChildItem = function(btn) {
    let main = btn.closest('.field-border');
    itemField.addItem(main);
  }

  this.cloneThisMainItem = function (btn) {
    let item = btn.closest('.field-border').clone();
    item.removeAttr('id').removeClass('hide');
    item.find('input,textarea').val('');

    let items = btn.closest('.item-sampel-items-text');

    items.append(item);
    return item;
  }
}

function addItem() {
  let main = itemField.addMain();
  itemField.addItem(main);
  main.find('button[btn="clone"]').attr('onclick','itemField.cloneThisMainItem($(this))');
}


function getParams() {
  let items=[];

  $('#items-content div[item="main"]:not(#text-sampel,#item-sampel)').each(function(index,html){
    field = $(this);
    item_type = field.attr('item-type');
    item_type = 1;

    get = getType1Params(field);
    items.push(get);
  });

  console.log(items);
}


function getType1Params(field){

  name = field.find('input[item="name"]').val();

  let items=[];

  field.find('.items-text-main .item-text').each(function () {

    config = $(this);

    if (config.find('input[item="data"]').data('use')=='yes') {
      data = config.find('input[item="data"]').val();
    }
    else {
      data = config.prop('editro').getData()
    }

    value = config.find('input[item="value"]').val();
    items.push({data:data,value:value});
  });

  return {name:name,items:items};
}

function save() {
  getParams();
}

</script>
