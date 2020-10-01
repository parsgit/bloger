<div class="" uk-grid>

  <div class="uk-width-1-1" uk-grid>
    <div class="">
      <div class="">
        <a style="color: white;" href="@url('admin/settings/index-page')" class="uk-button uk-button-default" name="button">Index Page</a>
      </div>
    </div>

  </div>

  <div class="uk-width-1-2@s">

    <div class="uk-card uk-card-body">
      <h3 class="uk-text-center">General Settings</h3>

      <div class="uk-margin">
        <label>Site Title</label>
        <input id="site-title" type="text" class="uk-input" value="{{$config->site_title??''}}">
      </div>

      <div class="uk-margin">
        <label>Tagline</label>
        <input id="tagline" type="text" class="uk-input" value="{{$config->tagline??''}}">
      </div>



    </div>
  </div>

  <div class="uk-width-1-2@s">
    <div class="uk-card uk-card-body" >
      <h3 class="uk-text-center" >Configs
        <button onclick="addConfig()" class="c-btn-icon color-green" uk-tooltip="title: Add Input; pos: top"> <i class="fas fa-plus"></i> </button>
        <button onclick="openAddItemsPage()" class="c-btn-icon color-green" uk-tooltip="title: Add Advance Items; pos: top"> <i class="fas fa-border-all"></i> </button>
      </h3>

      <div id="config-items">

        <div id="config-item-sample" class="config-item uk-margin-remove-top" uk-grid style="display:none;">

          <div class="uk-width-1-2@s">
            <input type="text" class="uk-input" placeholder="name" name="name" value="">
          </div>

          <div class="uk-width-1-2@s">
            <input  type="text"   class="uk-input" placeholder="value" name="value" value="">
            <a class="uk-button uk-button-primary uk-width-1-1" style="display:none;" name="edit" >Edit</a>
          </div>

          <div class="uk-text-right uk-margin-small uk-width-1-1">
            <button onclick="remove_config_message($(this))/*$(this).closest('.config-item').remove()*/" type="button" class="uk-button uk-button-danger uk-button-small" name="remove">remove</button>
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
    return item;
  }

  function getConfigParams() {
    var params = [];

    $('#config-items .config-item:not(#config-item-sample)').each(function(){
      config = $(this);

      if (config.data('type') !='items') {
        var name = config.find('input[name="name"]').val();
        var value = config.find('input[name="value"]').val();

        params.push({name:name,value:value});
      }

    });

    return params;
  }


  function save() {

    var site_title = $('#site-title').val();
    var tagline = $('#tagline').val();

    var configs = getConfigParams();

    configs.push({name:'site_title',value:site_title,type:'general'});
    configs.push({name:'tagline'   ,value:tagline   ,type:'general'});

    post('@url("admin/settings/save")',{
      configs:configs
    },function (get) {
      if (get.ok) {
        setTimeout(function () {
          loading(false);
        },1000);
      }
    });
  }

  function remove_config_message(btn) {
    div = btn.closest('.config-item');
    name = div.find('input[name="name"]').val();
    delete_message(name,'Delete config "'+name+'" ?',delete_config);
  }

  function delete_config(name) {
    post('@url("admin/settings/config/remove")',{name:name},function (get) {
      if (get.ok) {

        if (get.ok) {
          setTimeout(function () {
            loading(false);
          },1000);
          notifi_success();
          reload();
        }
      }
    })
  }

  function openAddItemsPage() {
    window.location.href = "@url('admin/settings/items-page')";
  }

  @foreach($configArray as $key=> $config)
  console.log('run config:','{{$config->type}}');
    @if($config->type=='custom' || $config->type=='items')
      item = addConfig();
      item.data('name','{{$config->name}}');
      item.find('input[name="name"]').val('{{$config->name}}');

      @if($config->type=='custom')
        item.find('input[name="value"]').val('{{$config->value}}');
      @else
        item.data('type','items');
        item.find('input[name="value"]').fadeOut(0);
        item.find('a[name="edit"]')
        .fadeIn(0)
        .attr('href','@url("admin/settings/items-page?id=".$config->id)');
      @endif

    @endif
  @endforeach



</script>
