
<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Login Log </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login Log</li>
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
                                                        <th>Name</th>
                                                        <th>Login Datetime</th>
                                                        <th>Login IP</th>
                                                        <th>Browser</th>
                                                        <th>Operating System</th>
                                                        <th>Login Type</th>
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
                    url: "<?php echo site_url('LoginLog/gettabledata'); ?>",
                    data: function (d) {
                        d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                    },
                },
                "columns": [
                    {"taregts": 0, 'data': 'login_log_id', 'visible': false },
                    {"taregts": 1, 
                        'data': 'username'
                    },
                    {"taregts": 1, 
                        'data': 'login_datetime',
                        "render": function (data, type, row) {
                            var myDate = new Date(row.login_datetime);
                            return ('0' + myDate.getDate()).slice(-2) + '-' +('0' + (myDate.getMonth()+1)).slice(-2)+ '-' + myDate.getFullYear() + ' '+myDate.getHours()+ ':'+('0' + (myDate.getMinutes())).slice(-2)+ ':'+myDate.getSeconds();
                        }
                    },
                    {"taregts": 2, 
                        'data': 'login_ip'
                    },
                    {"taregts": 3, 
                        'data': 'browser'
                    },
                    {"taregts": 4, 
                        'data': 'operating_system'
                    },
                    {"taregts": 5, 
                        'data': 'login_type'
                    },
                ]
            });

        }
        
        function nl2br (str, is_xhtml) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        $(document).ready(function () {
            load_transactiontable();
            // reload_transaction_table();
        });

        function reload_transaction_table() {
            var oTable1 = $('#transaction').dataTable();
            oTable1.fnStandingRedraw();
        }

        function deletemodal(id) {
            $('#deletemodal').modal();
            $('#deleteid').val(id);
        }

        function deleterecord() {
            var deleteid = $('#deleteid').val();
            $.ajax({
                url: "<?php echo base_url() . 'UserCards/delete' ?>",
                type: "POST",
                dataType: "json",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', id: deleteid},
                catch : false,
                success: function (data) {
                    if (data.status == 'success') {
                        flash_alert_msg(data.msg, 'success', 3000);
                        $('#deletemodal').modal('hide');
                        reload_transaction_table();
                    } else {
                        flash_alert_msg(data.msg, 'error', 3000);
                    }

                }
            });
        }
      
    </script>