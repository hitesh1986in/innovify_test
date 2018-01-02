<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>List of Candidate</h1>
            </div>
            <a href="<?php echo base_url('dashboard/add') ?>" class="btn btn-success pull-right">Add Candidate</a>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Payable Amount (Rs.)</th>
                    <th>Innovify Charge(Rs.)</th>
                    <th>VAT(Rs.)</th>
                    <th>Total Amount (Rs.)</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div><!-- .row -->
</div><!-- .container -->

<script>
    var datatable;
    jQuery(document).ready(function () {
//datatables
        datatable = $('#datatable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "candidate": [], //Initial no order.
            "pageLength": 20, // Set Page Length
            "lengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
// Load data for the table's content from an Ajax source
            "ajax": {
                "url": "dashboard/getdata",
                "type": "POST",
//Custom Post
                "data": {"YOUR CUSTOM POST NAME": "YOUR VALUE"}

            },

//Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 4, 7], //first, Fourth, seventh column
                    "orderable": false //set not orderable
                }
            ],
            "fnInitComplete": function (oSettings, response) {

                $("#countData").text(response.recordsTotal);
            }

        });
    });
</script>