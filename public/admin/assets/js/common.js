$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('form.FromSubmit').submit(function (event) {
    $('.error_form').text('')
    event.preventDefault();
    tinyMCE.triggerSave();
    
    var formId = $(this).attr('id');
        
        var formAction = $(this).attr('action');
        var buttonText = $('#'+formId+' button[type="submit"]').html();
        var $btn = $('#'+formId+' button[type="submit"]').attr('disabled','disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $.ajax({
            type: "POST",
            url: formAction,
            data: new FormData(this),
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            success: function (response) {
                if (response.status == true && response.msg !="") {
                   $('#'+formId+' button[type="submit"]').html(buttonText);
                    $('#'+formId+' button[type="submit"]').removeAttr('disabled','disabled');
                    window.location=response.url;
                }
            },
            error: function (jqXhr) {
              $("html, body").animate({ scrollTop: 0 }, "slow");
                var errors = $.parseJSON(jqXhr.responseText);
                    showErrorMessages(formId, errors);
                 $('#'+formId+' button[type="submit"]').html(buttonText);
                    $('#'+formId+' button[type="submit"]').removeAttr('disabled','disabled');
            }
        });
        return false;
    // };
});
  function showErrorMessages(formId, errorResponse) {
      var msgs = "";
      $.each(errorResponse.errors, function(key, value) {
        key=key.split('.')
        if (key[1] != null) {
          $('#'+key[0]+'_error_'+key[1]).text(value);
        }else{
          $('#'+key[0]+'_error').text(value);
        }

      });
  }
  function flashMessage($type, message) {
     $.notify(message, {
          type: $type,
          allow_dismiss: false,
          delay: 3000,
          showProgressbar: false,
          timer: 300
      });
  }
  $(document).on("click", ".delete_record", function(){
    var op=$(this);
    swal({
      title: "Are you sure want to delete this record ?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var formAction = $(this).data("route");
        $.ajax({
            type: "DELETE",
            url: formAction,
            success: function (response) {
                if(response.success == 1){
                 
                    swal(response.msg, {
                    icon: "success",
                    });
                   $('.table').DataTable().draw(false);
                   
                 
                }else{
                    flashMessage('danger', response.msg);
                    swal(response.msg, {
                    icon: "warning",
                    });
                }
            },
            error: function (jqXhr) {
          }
        });
        
      } 
    });
});


function deleteAll(className,url){
    var id = [];
    var checked = $("." + className + ":checked").length;
        if (checked > 0)
        {
          $("." + className + ":checked").each(function(){
               if($(this).val()!=1){
                    id.push($(this).val());
                 }
          });
          swal({
                  title: "do you really want to delete the record?",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {

                  var formAction = url;
                  $.ajax({
                      type: "POST",
                      url: formAction,
                      data:{checkbox:id},
                      success: function (response) {

                        if(response.success == 1){
                          $('.table').DataTable().draw(false);
                        }else{
                            flashMessage('danger', response.msg);
                        }
                      },
                      error: function (jqXhr) {
                    }
                });
              }
          });
        }
        else
        {
            swal("Select at list one record.");
        }
}

function statusAll(className,url,all_none){
     var id = [];
    var checked = $("." + className + ":checked").length;
    
        if (checked > 0)
        {
          $("." + className + ":checked").each(function(){
              if($(this).val()!=1){
                  id.push($(this).val());
              }
          });
          swal({
                title: "Are you sure want to change status?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    var formAction = url;
                    $.ajax({
                        type: "POST",
                        url: formAction,
                        data:{checkbox:id,all_none:all_none},
                        success: function (response) {

                            if(response.success == 1){
                                $('.table').DataTable().draw(false);
                            }else{
                                flashMessage('danger', response.msg);
                            }
                        },
                        error: function (jqXhr) {
                      }
                    });
                  swal("Success! status has been successfully changed!", {
                  icon: "success",
                });
              }
          });
        }
        else
        {
            swal("Select at list one record.");
        }
}


window.deleteAll = deleteAll
window.statusAll = statusAll
