
<script type="text/javascript">

	class MyData {

        loadData=()=> 
        {
            $('#dataTables').DataTable({
                "ajax": {
                    "url": "<?php echo site_url('configuration/action') ?>",
                    "type": "POST",
                    "data": function(d) {
                        // d.dateTo = document.getElementById('dateTo').value;
                        // d.dateFrom = document.getElementById('dateFrom').value;
                        // d.service = document.getElementById('service').value;
                        // d.port_origin = document.getElementById('port_origin').value;
                        // d.port_destination = document.getElementById('port_destination').value;
                        // d.depart_date = document.getElementById('depart_date').value;
                        // d.channel = document.getElementById('channel').value;
                        // d.merchant = document.getElementById('merchant').value;
                        // d.searchData=document.getElementById('searchData').value;
                        // d.searchName=$("#searchData").attr('data-name');
                    },
                },

                "serverSide": true,
                "processing": true,
                "columns":[

            			// {"data": "no","orderable": false,"className": "text-center","width": 5},
                		{"data": "action_name","orderable": true,"className": "text-left"},
                        {"data": "status","orderable": true,"className": "text-center"},
                        {"data": "action","orderable": true,"className": "text-center"}
                ],
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "processing": "Proses.....",
                    "emptyTable": "Tidak ada data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "lengthMenu": "Menampilkan _MENU_",
                    "search": "Pencarian :",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya",
                        "last": "Terakhir",
                        "first": "Pertama"
                    }
                },
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 10,
                "searching": false,
                "pagingType": "bootstrap_full_number",
                "order": [
                    [0, "desc"]
                ],
                "initComplete": function() {
                    var $searchInput = $('div.dataTables_filter input');
                    var data_tables = $('#dataTables').DataTable();
                    $searchInput.unbind();
                    $searchInput.bind('keyup', function(e) {
                        if (e.keyCode == 13 || e.whiche == 13) {
                            data_tables.search(this.value).draw();
                        }
                    });
                },

                fnDrawCallback: function(allRow) {
                    // console.log(allRow);
                    if (allRow.json.recordsTotal) {
                        $('.download').prop('disabled', false);
                    } else {
                        $('.download').prop('disabled', true);
                    }
                }
            });

        }

        reload=()=> {
            $('#dataTables').DataTable().ajax.reload();
        }

        init=()=> {
            if (!jQuery().DataTable) {
                return;
            }

            this.loadData();
        }

	}
</script>