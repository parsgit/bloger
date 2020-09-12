<div class="" uk-grid>
  <div class="uk-width-1-2@s">

    <div class="uk-card uk-card-body ">
      <h3 class="uk-text-center">General Settings</h3>

      <div class="uk-margin">
        <label>Site Title</label>
        <input id="site-title" type="text" class="uk-input" name="site-title" value="">
      </div>

      <div class="uk-margin">
        <label>Tagline</label>
        <input id="tagline" type="text" class="uk-input" name="" value="">
      </div>

      <div class="uk-margin">
        <label>Theme Name</label>
        <input id="theme-name" type="text" class="uk-input" name="" value="">
      </div>



    </div>
  </div>

  <div class="uk-width-1-2@s">
    <div class="uk-card uk-card-body" >
      <h3 class="uk-text-center" >Configs <button onclick="addConfig()" class="c-btn-icon color-green"> <i class="fas fa-plus"></i> </button> </h3>

      <div id="config-items">

        <div id="config-item-sample" class="config-item uk-margin-remove-top" uk-grid style="display:none;">

          <div class="uk-width-1-2@s">
            <input type="text" class="uk-input" placeholder="name" name="name" value="">
          </div>

          <div class="uk-width-1-2@s">
            <input type="text" class="uk-input" placeholder="value" name="value" value="">
          </div>

          <div class="uk-text-right uk-margin-small uk-width-1-1">
            <button onclick="$(this).closest('.config-item').remove()" type="button" class="uk-button uk-button-danger uk-button-small" name="button">remove</button>
          </div>

        </div>

      </div>


    </div>
  </div>

  <div class="uk-width-1-1">
    <div class="uk-margin uk-text-center uk-card uk-card-body">
      <button onclick="save()" class="uk-button uk-button-primary" >Save</button>
    </div>
  </div>
</div>


<script type="text/javascript">
  function addConfig() {
    item = $('#config-item-sample').clone();
    item.css('display','').removeAttr('id');
    $('#config-items').append(item);
  }

  function getConfigParams() {
    var params = [];

    $('#config-items .config-item:not(#config-item-sample)').each(function(){
      config = $(this);

      var name = config.find('input[name="name"]').val();
      var value = config.find('input[name="value"]').val();

      params.push({name:name,value:value});
    });

    return params;
  }


  function save() {

    var site_title = $('#site-title').val();
    var tagline = $('#tagline').val();
    var theme_name = $('#theme-name').val();

    var configs = getConfigParams();

    post('@url("admin/settings/save")',{
      site_title:site_title,
      tagline:tagline,
      theme_name:theme_name,
      configs:configs
    },function (get) {
      console.log(get);
    });
  }
</script>
