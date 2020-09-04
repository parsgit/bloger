function post(url,params,callback=false,error=false){
  loading(true)

  $.post(url,params)
  .done(function(get){
    if (get.ok==false) {
      UIkit.modal.alert(get.message)
    }
    else if(get.ok!=false && get.ok!=true) {
      error_post()
      return;
    }

    callback(get);
  })
  .fail(function(){
    error_post();

    if (error!=false)
    error();

  })
}

function ajax(url,params,callback=false,_error=false) {

  loading(true);

  $.ajax({
    url : url,
    type: "POST",
    data : params,
    processData: false,
    contentType: false,
    success:function(get, textStatus, jqXHR){
      if (get.ok==false) {
        UIkit.modal.alert(get.message)
      }
      else if(get.ok!=false && get.ok!=true) {
        error_post()
        return;
      }

      callback(get);
    },
    error: function(jqXHR, textStatus, errorThrown){
      error_post();

      if (error!=false)
      error();

    }
  });

}

function error_post() {
  setTimeout(function () {
    loading(false);
    UIkit.modal.alert('Error Internet Connection !')
  },500);
}

function reload(){

  setTimeout(function () {
    loading(true);
    window.location.reload();
  },1000)
}


function notifi_success(message){
  message = message || 'done successfully';
  notifi(message,'success');
}

function notifi(message,status){
  UIkit.notification({message: message , status: status})
}

function delete_message(params,message,callback){

  if (message==false || message==null) {
    message = message || 'Delete item?';
  }

  UIkit.modal.confirm(message).then(function () {
    callback(params)
  });
}
