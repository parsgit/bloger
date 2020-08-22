<div id="modal-loading" class="uk-flex-top" uk-modal="bg-close:false;esc-close:false;">
  <div class="uk-modal-dialog uk-margin-auto-vertical uk-text-center modal-loading-style" style="background: transparent;">
    <div uk-spinner="ratio: 3"></div>
    <div class="uk-text-center">
      <span id="modal-loading-text"></span>
    </div>
  </div>
</div>

<script>
  function loading(action) {
    modal = $('#modal-loading');

    if (typeof action === 'string' || action instanceof String) {
      modal.find('#modal-loading-text').text(action);
      UIkit.modal('#modal-loading').show();
    }
    else if (typeof action === "boolean" && action ) {
      modal.find('#modal-loading-text').text('');
      UIkit.modal('#modal-loading').show();
    }
    else{
      UIkit.modal('#modal-loading').hide();
    }
  }
</script>
