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
    error_post()
  })
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
  UIkit.notification({message: message , status: status,timeout: 50000})
}

var _delete_params;
function delete_message(params,message,callback){

  if (message==false || message==null) {
    message = message || 'Delete item?';
  }

  _delete_params=params;

  UIkit.modal.confirm(message).then(function () {
    callback(_delete_params)
  });
}
