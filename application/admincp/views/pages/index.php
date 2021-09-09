
<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Pages <a href="<?php echo site_url('Pages/add'); ?>" class="btn btn-primary waves-effect waves-light pull-right add-btn"><i class="fa fa-plus"></i>  Add</a></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pages</li>
                    </ol>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="error_msg_info">
                        <?php if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('success'); ?></strong> 
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('error'); ?></strong> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dataTable no-footer" id="transaction">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Page Title</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $footer; ?>

    <script type="text/javascript">

        function load_transactiontable() {
            var table;
            var table = jQuery('#transaction').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": false,
                "order": [[0, "DESC"]],
                "ajax": {
                    url: "<?php echo site_url('Pages/gettabledata'); ?>",
                    data: function (d) {
                        d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                    },
                },
                "columns": [
                    {"taregts": 0, 'data': 'page_id', 'visible': false
                    },
                    {"taregts": 1, 'data': 'pagetitle'
                    },
                    {"taregts": 3, "searchable": false, "orderable": false, "sClass": "text-center",
                        "render": function (data, type, row) {
                            var id = btoa(row.page_id);
                            var out = '';
                            out += '<a title="Edit"  href="<?php echo site_url('Pages/edit/'); ?>' + id + '"><i class="glyphicon glyphicon-edit btm-view"></i></a>&nbsp;';
                            return out;
                        }
                    },
                ]
            });

        }
        
        $(document).ready(function () {
            load_transactiontable();
            // reload_transaction_table();
        });

        function reload_transaction_table() {
            var oTable1 = $('#transaction').dataTable();
            oTable1.fnStandingRedraw();
        }
      
    </script>