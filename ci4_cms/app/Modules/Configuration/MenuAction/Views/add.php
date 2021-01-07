<style type="text/css">
    .wajib{ color:red; }
</style>
<div class="col-md-6 col-md-offset-3" >
    <div class="portlet light bordered" id='box'>
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-cursor font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?php echo $title ?></span>
            </div>
            <div class="actions">
                <button type="button" class="btn btn-sm btn-default btn-circle" onclick="closeModal()"><i class="fa fa-times"></i></button>
            </div>
        </div>        
        <div class="portlet-body" >
            <form id="formData" action="<?php echo  site_url() ?>configuration/action/action_add" method="post">
                <div class="box-body">
                     <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="form-group form-md-line-input form-md-floating-label has-info">

                                    <input type="text" class="form-control input-sm" id="actionName" required name="actionName" autocomplete="off" >
                                    <label for="actionName">Nama Aksi</label>                                   
                                </div>

                            </div>                    

                        </div>                    
                    </div>
                </div>
                <div style="padding-bottom: 50px;">
                    <!-- <button type="submit" class="btn btn-sm btn-success btn-circle pull-right" title="Simpan">Simpan</button> -->
                    <button type="submit" class="btn btn-sm btn-success btn-circle pull-right" id="saveBtn"><i class="fa fa-check"></i> simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">

    validateForm('#formData',function(url,data){
        postData(url,data);
    });

</script>