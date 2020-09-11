<script src="@url('library/ckeditor/ckeditor.js')" charset="utf-8"></script>


<div class="">

  <div class="uk-margin">
    <a target="_blank" href="@url('admin/upload')" uk-toggle class="uk-button c-button c-button-icon" name="button">
      Add Media
      <i class="fas fa-photo-video"></i>
    </a>
  </div>

  <div class="uk-margin" uk-grid>
    <div class="uk-width-1-3@s">
      <label>Category</label>

      <select  onchange="setCategory($(this))" id="select-category" class="uk-select" >
        <option value="0" >/</option>
        @foreach($categorys as $category)
        <option  {{ ( isset($post->category_id) && $post->category_id==$category->id)?'selected':''}} value="{{$category->id}}" >/{{$category->name}}/</option>
        @endforeach
      </select>

    </div>
    <div class="uk-width-2-3@s">
      <label>Title <span >( <span strlen>0</span> / 60 )</span> </label>
      <input dir="auto" id="title"oninput="changStrlen($(this))" type="text" class="uk-input" name="" value="{{$post->title??''}}">
    </div>
  </div>

  <div class="uk-margin">
    <label>Content</label>
    <textarea name="post-content" id="content" rows="10" cols="80">{{$post->content??''}}</textarea>
  </div>

  <div class="uk-margin">
    <label>Description <span>( <span strlen>0</span> / 230-320 )</span> </label>
    <textarea dir="auto" id="description" oninput="changStrlen($(this))" class="uk-textarea" name="name" rows="4">{{$post->description??''}}</textarea>
  </div>

  <div class="uk-margin">
    <label>Tags</label>
    <input id="tags" dir="auto" type="text" class="uk-input" name="" value="{{$post->tags??''}}">
  </div>

  <div class="uk-margin uk-flex-center" uk-grid>

    <div class="uk-width-auto">
      <div class="">
        <label>Publish <i class="fas fa-eye"></i></label>
        <div class="c-switcher" name="publish" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button {{($post!=false && $post->publish==1)?'uk-active':''}}" value="1" type="button">Yes</button>
          <button class="uk-button {{($post!=false && $post->publish==0)?'uk-active':''}}" value="0" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Author Name <i class="fas fa-signature"></i></label>
        <div class="c-switcher" name="author_name" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button {{($post!=false && $post->author_name==1)?'uk-active':''}}" value="1" type="button">Yes</button>
          <button class="uk-button {{($post!=false && $post->author_name==0)?'uk-active':''}}" value="0" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Allow comment <i class="fas fa-comment"></i> </label>
        <div class="c-switcher" name="allow_comment" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button {{($post!=false && $post->allow_comment==1)?'uk-active':''}}" value="1" type="button">Yes</button>
          <button class="uk-button {{($post!=false && $post->allow_comment==0)?'uk-active':''}}" value="0" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Like  <i class="fas fa-heart"></i></label>
        <div class="c-switcher" name="like" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button {{($post!=false && $post->allow_like==1)?'uk-active':''}}" value="1" type="button">Yes</button>
          <button class="uk-button {{($post!=false && $post->allow_like==0)?'uk-active':''}}" value="0" type="button">No</button>
        </div>
      </div>
    </div>

  </div>

  <div class="uk-margin">
    <div class="">
      <ul uk-accordion>
        <li>
          <a class="uk-accordion-title" href="#">Advanse <i class="fas fa-cogs"></i> </a>
          <div class="uk-accordion-content">
            <div uk-grid>

              <div class="uk-width-1-3@s">
                <div class="uk-card uk-card-body uk-padding-small">
                  <h4 class="uk-text-center" >Featured image</h4>

                  <div class="">
                    <label>Image Url</label>
                    <input id="featured_image" onchange="changePostImage($(this))" type="text" class="uk-input" name="" value="">
                  </div>

                  <div class="uk-margin ">
                    <img id="featured_image_show" class="uk-width-medium uk-margin-auto" src="" alt="">
                  </div>
                </div>
              </div>

              <div class="uk-width-2-3@s">
                <div class="uk-card uk-card-body uk-padding-small">
                  <h4 class="uk-text-center" >Custom Fields</h4>

                  <div id="custom-fields">
                    <div id="custom-field-sample" style="display:none;" class="custom-field uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <label>name</label>
                        <input type="text" class="uk-input" name="name" value="">
                      </div>

                      <div class="uk-width-1-2">
                        <label>value</label>
                        <textarea style=" resize: vertical;" name="value" class="uk-textarea uk-width-1-1" rows="1" ></textarea>
                      </div>
                      <div class="uk-width-1-1 uk-margin-remove">
                        <div class="">
                          <button onclick="$(this).closest('.uk-grid-small').remove()" class=" uk-button uk-button-small uk-button-danger" type="button" name="button">remove</button>
                        </div>
                      </div>
                    </div>


                  </div>



                  <div class="uk-margin uk-text-center">
                    <button onclick="addCustomField()" type="button" class="uk-button uk-button-primary" name="button">Add</button>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </li>
      </ul>


    </div>
  </div>

  <div class="uk-margin uk-text-center uk-margin-medium-top">
    <div class="uk-card uk-card-body uk-padding-small">
      <button onclick="sendPost()" type="button" class="uk-button c-button-icon c-button-teal uk-width-small" name="button">Save <i class="fas fa-save color-orange"></i></button>
    </div>
  </div>
</div>


<script>
CKEDITOR.replace( 'content' );

function changStrlen(input) {
  input.closest('div').find('span[strlen]').text(input.val().length);
}

function getSwicherParams() {
  ob={};
  $('.c-switcher').each(function (index) {
    item = $(this);
    // ob[item.attr('name')] = (item.find('.uk-active').prop('value')=='true')?true:false;
    ob[item.attr('name')] = item.find('.uk-active').prop('value');
  });
  return ob;
}

function sendPost() {

  title = $('#title').val();
  content = CKEDITOR.instances.content.getData();
  description = $('#description').val();
  tags = $('#tags').val();
  category = $('#select-category').val();

  featured_image = $('#featured_image').val();

  var params={
    title:title,
    content:content,
    description:description,
    tags:tags,
    swichers:getSwicherParams(),
    category:category,
    custom_fields:getCustomFieldParams(),
  }

  if (featured_image !== '') {
    params['featured_image']=featured_image;
  }

  @if($post!=false)
  params['id']='{{$post->id}}';
  @endif

  post('@url("admin/post/add")',params,function (get) {
    console.log(get);
    if (get.ok) {
      notifi_success();

      setTimeout(function () {

        @if($post!=false)
        window.location.href = '@url("admin/post/edit?id=$post->id")';
        @else
        window.location.href = '@url("admin/posts")'
        @endif

      },1500)
    }
  })

  console.log(params);

}

function changePostImage(input){
  $('#featured_image_show').attr('src',input.val());
}

// new custom field
function addCustomField() {
  field = $('#custom-field-sample').clone();

  field
  .removeAttr('id')
  .css('display','')
  .find('input,textarea').val('');

  $('#custom-fields').append(field);
}

// add a custom field
addCustomField();

function getCustomFieldParams() {
  var custom_params = [];
  $('#custom-fields .custom-field').each(function () {
    item  = $(this);
    name  = item.find('input[name="name"]').val();
    value = item.find('textarea[name="value"]').val();

    if(name !== '')
    custom_params.push({
      name:name,
      value:value
    });
  });

  return custom_params;
}
</script>
