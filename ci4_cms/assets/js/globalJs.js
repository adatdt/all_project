function showModal(url){
    $.magnificPopup.open({
        items: {
            src: url
        },
        modal: true,
        type: 'ajax',
        tLoading: '<i class="fa fa-refresh fa-spin"></i> Mohon tunggu...',
        showCloseBtn: false,
    });
}

function closeModal() {
    $.magnificPopup.close();
}

function confirmAction(messege=null, url){
    bootbox.confirm({
        message:messege,
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success btn-circle'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger btn-circle'
            }
        },
        callback: function (result) {
            // console.log('This was logged in the callback: ' + result);
            // console.log(result);
            if(result==true)
            {
                $.ajax({
                    url         : url,
                    type        : 'GET',
                    dataType    : 'json',

                    // beforeSend: function(){
                    //     blockUi('#box');
                    // },

                    success: function(json) {
                        if(json.code == 1)
                        {
                            closeModal();
                            toastr.success(json.message, 'Sukses');
                            $('#dataTables').DataTable().ajax.reload( null, false );
                        }
                        else
                        {
                            toastr.error(json.message, 'Gagal');
                        }
                    },

                    error: function() {
                        toastr.error('Silahkan Hubungi Administrator', 'Gagal');
                    }

                    // complete: function(){
                    //     $('#box').unblock(); 
                    // }
                });
            }
        }
    });

}


rules   = {};
messages= {};

function validateForm(id,callback){
    $(id).validate({
        ignore      : 'input[type=hidden], .select2-search__field', 
        errorElement: 'span',
        errorClass: 'help-inline',        
        rules       : rules,
        messages    : messages,

        highlight   : function(element, errorClass) {
            $(element).addClass('val-error');
            $(element).removeClass('val-succ');
        },

        unhighlight : function(element, errorClass) {
            $(element).removeClass('val-error');
            $(element).addClass('val-succ');            
        },

        errorPlacement: function(error, element) {
            

            if (element.parents('div').hasClass('has-feedback')) {
                error.appendTo( element.parent() );
            }            

            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            else {
                error.insertAfter(element);
            }
        },

        submitHandler: function(form) 
        {

            if(typeof callback != 'undefined' && typeof callback == 'function')
            {
                callback(form.action,getFormData($(form)));
            }

        }
    });
}

function postData(url,data){
    $.ajax({
        url         : url,
        data        : data,
        type        : 'POST',
        dataType    : 'json',

        beforeSend: function(){
            blockUi('#box');
        },

        success: function(json) {
            if(json.code == 1)
            {
                closeModal();
                toastr.success(json.message, 'Sukses');
                $('#dataTables').DataTable().ajax.reload( null, false );
            }
            else
            {
                toastr.error(json.message, 'Gagal');
            }
        },

        error: function() {
            toastr.error('Silahkan Hubungi Administrator', 'Gagal');
        },

        complete: function(){
            $('#box').unblock(); 
        }
    });
}

function getFormData(form){
    var unindexed_array = form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function blockUi(id){
    $(id).block({
        message: '<h4><i class="fa fa-spinner fa-spin"></i> Loading</h4>',
    });
}

function unblockUi(id)
{
    $('id').unblock(); 
}