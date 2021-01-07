
<script type="text/javascript">

    class MyData
    {

        getTreeGrid(data)
        {
            $('#table').bootstrapTable('destroy');
            var $table = $('#table')

            $(function() {
                $table.bootstrapTable(
                {
                    // url: 'privilege?userGroup='+userGroup,
                    data:data,
                    idField: 'id',
                    showColumns: true,
                    columns: [
                        {
                          field:'dataEmpty',
                          width :10,
                          title: ''
                        },
                        {
                          field: 'name',
                          title: 'NAMA'
                        },
                        {
                          field: 'action',
                          title: 'ACTION',
                          // sortable: true,
                          align: 'left',
                          // formatter: 'statusFormatter'
                        }
                    ],
                    treeShowField: 'name',
                    parentIdField: 'pid',
                    onPostBody: function() 
                    {
                        var columns = $table.bootstrapTable('getOptions').columns

                        if (columns && columns[0][1].visible) {
                            $table.treegrid({
                                treeColumn: 1,
                                onChange: function() 
                                {
                                    $table.bootstrapTable('resetView')
                                }
                            })
                        }
                    }
                })
            })            
        }

        getData(userGroup)
        {
            
            $.ajax({
                url         : 'privilege',
                data        : "userGroup="+userGroup,
                type        : 'get',
                dataType    : 'json',

                beforeSend: function(){
                    blockUi('#contentTree');
                },

                success: function(x) {
                    
                    myData= new MyData();
                    myData.getTreeGrid(x);
                },

                error: function() {
                    toastr.error('Silahkan Hubungi Administrator', 'Gagal');
                },

                complete: function(){
                    $('#contentTree').unblock(); 
                }
            });
        }

        editData(id)
        {
            $.ajax({
                url         : 'privilege/edit',
                data        : "id="+id+"&userGroup="+$("#group").val(),
                type        : 'post',
                dataType    : 'json',

                beforeSend: function(){
                    blockUi('#contentTree');
                },

                success: function(x) {

                    if(x.code == 1)
                    {
                        // toastr.success(x.message, 'Sukses');
                        myData= new MyData()
                        myData.getTreeGrid(x.data);
                        toastr.success(x.message, 'Berhasil');
                        console.log(x)
                    }
                    else
                    {
                        toastr.error(x.message, 'Gagal');
                    }
                },

                error: function() {
                    toastr.error('Silahkan Hubungi Administrator', 'Gagal');
                },

                complete: function(){
                    $('#contentTree').unblock(); 
                }
            });            
        }

        confirmAction()
        {
            bootbox.confirm({
                message: "Apa Yakin Ingin Tambah SEMUA?",
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
                    console.log('This was logged in the callback: ' + result);
                }
            });
        }

    }
</script>