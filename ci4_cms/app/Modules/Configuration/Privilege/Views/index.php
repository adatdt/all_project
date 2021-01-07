
<style type="text/css">
    .switch {
      position: relative;
      display: inline-block;
      width: 90px;
      height: 25px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ca2222;
      -webkit-transition: .4s;
      transition: .4s;
      height: 25px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 17px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;

    }

    input:checked + .slider {
      background-color: #2ab934;
    }

    input:disabled + .slider {
      background-color: grey;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(55px);
      -ms-transform: translateX(55px);
      transform: translateX(55px);
    }

    /*------ ADDED CSS ---------*/
    .on
    {
      display: none;
    }

    .on, .off
    {
      color: white;
      position: absolute;
      transform: translate(-50%,-50%);
      top: 50%;
      left: 50%;
      font-size: 10px;
      font-family: Verdana, sans-serif;
    }

    input:checked+ .slider .on
    {display: block;}

    input:checked + .slider .off
    {display: none;}

    /*--------- END --------*/

    /* Rounded sliders */
    .slider.round {
      /*border-radius: 34px;*/
      margin-right: -2px;
    }

    .slider.round:before {
      /*border-radius: 50%;*/
    }

    .keep-open{
        display: none;
    }    


    .checkbox label:after, 
    .radio label:after {
        content: '';
        display: table;
        clear: both;
    }

    .checkbox .cr,
    .radio .cr {
        position: relative;
        display: inline-block;
        border: 1px solid #a9a9a9;
        border-radius: .25em;
        width: 1.3em;
        height: 1.3em;
        float: left;
        margin-right: .5em;
    }

    .radio .cr {
        border-radius: 50%;
    }

    .checkbox .cr .cr-icon,
    .radio .cr .cr-icon {
        position: absolute;
        font-size: .8em;
        line-height: 0;
        top: 50%;
        left: 20%;
    }

    .radio .cr .cr-icon {
        margin-left: 0.04em;
    }

    .checkbox label input[type="checkbox"],
    .radio label input[type="radio"] {
        display: none;
    }

    .checkbox label input[type="checkbox"] + .cr > .cr-icon,
    .radio label input[type="radio"] + .cr > .cr-icon {
        transform: scale(3) rotateZ(-20deg);
        opacity: 0;
        transition: all .3s ease-in;
    }

    .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
    .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }

    .checkbox label input[type="checkbox"]:disabled + .cr,
    .radio label input[type="radio"]:disabled + .cr {
        opacity: .5;
    }

    /*samain format jika menggunakan plugin select2*/
    .select2-container--bootstrap .select2-selection 
    {
        border-top: 0px !important;
        border-left: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px  solid #327ad5 !important ;

    }


</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treegrid/0.2.0/css/jquery.treegrid.min.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.css" rel="stylesheet">


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-treegrid/0.2.0/js/jquery.treegrid.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/treegrid/bootstrap-table-treegrid.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>




<div class="page-content">

    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active"><?php echo $title ?></span>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->

    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-cursor font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?php echo $title ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">

                        <div class="col-md-12">                                 

                            <div class="form-group form-md-line-input form-md-floating-label has-info">

                                <?php echo form_dropdown('group', $group,"", 'class="select2 form-control input-sm edited" id="group" data-placeholder="Pilih" '); ?>
                                <label for="group">User Group</label>
                            
                            </div>
                        </div>

                        <div class="col-md-12" id="contentTree" style="min-height: 100px;">                                    
                            <table id="table"></table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END PAGE BASE CONTENT -->

</div>

<?php include "fileJs.php"; ?>
<script src="<?php echo base_url(); ?>/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>
<script type="text/javascript">
	
	var myData = new MyData()


	$(document).ready(function(){

        $("#group").change(()=>{
            $getGroup=$("#group").val();
            myData.getData($getGroup);
        });



    })

</script>