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

      <select autocomplete="off" onchange="setCategory($(this))" id="select-category" class="uk-select">
        <option value="content" >/</option>
        @foreach($categorys as $category)
        <option value="content/{{$category->name}}" >{{$category->name}}</option>
        @endforeach
      </select>

    </div>
    <div class="uk-width-2-3@s">
      <label>Title <span >( <span strlen>0</span> / 60 )</span> </label>
      <input autocomplete="off" oninput="changStrlen($(this))" type="text" class="uk-input" name="" value="">
    </div>
  </div>

  <div class="uk-margin">
    <label>Content</label>
    <textarea autocomplete="off" name="post-content" id="post-content" rows="10" cols="80"></textarea>
  </div>

  <div class="uk-margin">
    <label>Description <span>( <span strlen>0</span> / 230-320 )</span> </label>
    <textarea autocomplete="off" oninput="changStrlen($(this))" class="uk-textarea" name="name" rows="4"></textarea>
  </div>

  <div class="uk-margin">
    <label>Tags</label>
    <input autocomplete="off" type="text" class="uk-input" name="" value="">
  </div>

  <div class="uk-margin uk-flex-center" uk-grid>

    <div class="uk-width-auto">
      <div class="">
        <label>Publish <i class="fas fa-eye"></i></label>
        <div class="c-switcher" name="publish" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button uk-active" value="true" type="button">Yes</button>
          <button class="uk-button" value="false" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Author Name <i class="fas fa-signature"></i></label>
        <div class="c-switcher" name="auther_name" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button " value="true" type="button">Yes</button>
          <button class="uk-button uk-active" value="false" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Allow comment <i class="fas fa-comment"></i> </label>
        <div class="c-switcher" name="allow_comment" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button uk-active" value="true" type="button">Yes</button>
          <button class="uk-button " value="false" type="button">No</button>
        </div>
      </div>
    </div>

    <div class="uk-width-auto">
      <div class="">
        <label>Like  <i class="fas fa-heart"></i></label>
        <div class="c-switcher" name="like" uk-switcher="animation: uk-animation-fade; toggle: > *">
          <button class="uk-button uk-active" value="true" type="button">Yes</button>
          <button class="uk-button" value="false" type="button">No</button>
        </div>
      </div>
    </div>

  </div>

  <div class="uk-margin uk-text-center uk-margin-medium-top">
    <div class="uk-card uk-card-body uk-padding-small">
      <button onclick="sendPost()" type="button" class="uk-button c-button-icon c-button-teal uk-width-small" name="button">Save <i class="fas fa-save color-orange"></i></button>
    </div>
  </div>
</div>


<script>
  CKEDITOR.replace( 'post-content' );

  function changStrlen(input) {
    input.closest('div').find('span[strlen]').text(input.val().length);
  }

  function getSwicherParams() {
    ob={};
    $('.c-switcher').each(function (index) {
      item = $(this);
      ob[item.attr('name')] = (item.find('.uk-active').prop('value')=='true')?true:false;
    });
    return ob;
  }

  function sendPost() {
    console.log(getSwicherParams());
  }
</script>
