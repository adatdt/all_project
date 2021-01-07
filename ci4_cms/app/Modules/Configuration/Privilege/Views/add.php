<style type="text/css">
    .wajib{ color:red; }
</style>
<div class="col-md-6 col-md-offset-3">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-cursor font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?php echo $title ?></span>
            </div>
            <div class="actions">
                <button type="button" class="btn btn-sm btn-default btn-circle" onclick="closeModal()"><i class="fa fa-times"></i></button>
            </div>
        </div>        
        <div class="portlet-body" id='box'>
            <form id="formData" action="<?php echo  site_url() ?>configuration/user/action_add" method="post">
                <div class="box-body">
                     <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="form-group form-md-line-input form-md-floating-label has-info">

                                    <input type="text" class="form-control input-sm" id="form_control_1" required name="username" autocomplete="off" >
                                    <label for="form_control_1">User Name</label>                                   
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label has-info">
                                    <input type="text" class="form-control input-sm" id="form_control_2" required name="firstName" autocomplete="off">
                                    <label for="form_control_2">Nama Depan</label>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label has-info">
                                    <input type="password" class="form-control input-sm" id="password" required name="password" autocomplete="off" >
                                    <label for="password">Password</label>
                                </div>                                                                

                            </div>               

                            <div class="col-sm-6 form-group">
                                <div class="form-group form-md-line-input form-md-floating-label has-info">

                                    <input type="text" class="form-control input-sm" id="lastName" required name="lastName" autocomplete="off">
                                    <label for="lastName">Nama Belakang</label>                                   
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label has-info">
                                    <input type="text" class="form-control input-sm" id="email"  name="email" autocomplete="off">
                                    <label for="email">Email</label>
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