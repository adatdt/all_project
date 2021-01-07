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
                    <div class="actions">

                        <button onclick="showModal('user/add')" class="btn btn-sm btn-warning btn-circle" title="Tambah"><i class="fa fa-plus"></i> Tambah</button>                            
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="row" style="padding: 10px;">
                                <div class="col-md-12">
                                    <!-- <div class="table-scrollable"> -->
                                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th scope="col"> USERNAME </th>
                                                    <th scope="col"> NAMA </th>
                                                    <th scope="col"> ALAMAT </th>
                                                    <th scope="col"> TELEPON </th>
                                                    <th scope="col"> AKSI </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    <!-- </div> -->
                                </div>

                            </div>                                            

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END PAGE BASE CONTENT -->

</div>



<?php include "fileJs.php"; ?>
<script type="text/javascript">
	
	var myData = new MyData()

	$(document).ready(function(){

		myData.loadData();
	})

</script>