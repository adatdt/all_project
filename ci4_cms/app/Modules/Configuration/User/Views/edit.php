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
            <form id="formData" action="<?php echo  site_url() ?>configuration/user/action_edit" method="post">
                <div class="box-body">
                     <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="form-group form-md-line-input form-md-floating-label has-info">

                                    <input type="text" class="form-control input-sm <?php echo !empty($data->username)?'edited':'' ?> " id="form_control_1" required name="username" value="<?php echo $data->username; ?>" >
                                    <label for="form_control_1">User Name<span style="color:red"> *</span></label>                                   
                                </div>


                                <div class="form-group form-md-line-input form-md-floating-label has-info ">
                                    <input type="text" class="form-control input-sm <?php echo !empty($data->first_name)?'edited':'' ?>" id="form_control_2" required name="firstName" value="<?php echo $data->first_name; ?>">
                                    <label for="form_control_2" class="">Nama Depan<span style="color:red"> *</span></label>
                                </div>

                            </div>               

                            <div class="col-sm-6 form-group">
                                <div class="form-group form-md-line-input form-md-floating-label has-info">

                                    <input type="text" class="form-control input-sm <?php echo !empty($data->last_name)?'edited':'' ?>" id="lastName" required name="lastName" value="<?php echo $data->last_name; ?>">
                                    <label for="lastName">Nama Belakang<span style="color:red"> *</span></label>                                   
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label has-info">
                                    <input type="text" class="form-control input-sm <?php echo !empty($data->email)?'edited':'' ?>" id="email"  name="email" value="<?php echo $data->email; ?>" required >
                                    <label for="email">Email<span style="color:red"> *</span></label>

                                    <input type="hidden" name="idData" value="<?php echo $id; ?>" required>
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

    $('input:-webkit-autofill').each(function(){
        if ($(this).val().length !== "") {
            $(this).siblings('label, i').addClass('active');
        }
    });



</script>