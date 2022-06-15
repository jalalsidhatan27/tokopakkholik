<!-- INPUT PERSEDIAAN -->
<div class="modal fade" id="input_pers_awal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo base_url('akunting/lap_laba_rugi') ?>"></a>
                <!-- <h4 class="modal-title">INPUT MODAL</h4> -->
                INPUT PERSEDIAAN
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('akunting/pers_akhir');
                ?>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" data-field="date" required="true"
                        data-format="dd-MM-yyyy" />
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
</div>

<!-- INPUT MODAL AWAL -->
<div class="modal fade" id="input_modal_awal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo base_url('akunting/neraca') ?>"></a>
                <!-- <h4 class="modal-title">INPUT MODAL</h4> -->
                INPUT MODAL
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('akunting/save_modal');
                ?>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" data-field="date" required="true"
                        data-format="dd-MM-yyyy" />
                </div>
                <div class="form-group">
                    <label>Kas</label>
                    <input type="number" name="kas" id="n_kas" class="form-control" onchange="h_modal()">
                </div>
                <div class="form-group">
                    <label>Inventaris</label>
                    <input type="number" name="inventaris" id="n_inv" class="form-control" onchange="h_modal()">
                </div>

                <div class="form-group">
                    <label>Persediaan Barang Dagangan</label>
                    <input type="number" name="persediaan" id="n_pers" class="form-control" onchange="h_modal()">
                </div>
                <div class="form-group">
                    <label>Perlengkapan Toko</label>
                    <input type="number" name="perlengkapan" id="n_perl" class="form-control" onchange="h_modal()">
                </div>

                <div class="form-group">
                    <label>Kendaraan</label>
                    <input type="number" name="kendaraan" id="n_kend" class="form-control" onchange="h_modal()">
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <input type="text" name="total" id="n_total" class="form-control" placeholder="Keterangan">
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
</div>


</div>
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; <?= date('Y') ?> &middot; Toko Pak Kholik</div>
            <div class="text-muted"></div>
        </div>
    </div>
</footer>
</div>
</div>


<!-- logoutModal -->
<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Logout?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                Yakin ingin logout?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- ./logoutModal -->

<script src="<?= base_url('assets/') ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Datatables -->
<script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Daterangepicker -->
<script src="<?= base_url(); ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?= $this->session->flashdata('pesan'); ?>

<script type="text/javascript">
$(function() {
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(fileName);
    });

    // Date rang

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#tangal').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#tanggal').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hari ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
            '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ],
            'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                .endOf('year')
            ]
        }
    }, cb);

    cb(start, end);

    // Bootstrap
    $('[data-toggle="tooltip"]').tooltip();

    $('#search-only-datatable').DataTable({
        dom: "<'row'<'col-md-4 col-lg-2'f><'col-md-4'><'col-md-4 col-lg-6 text-center'p>>" +
            "<'row mt-2'<'col-md-12 overflow-y h-25'tr>>",
        ordering: false,
        info: false,
    });

    var table = $('.datatable').DataTable({
        buttons: ['copy', 'csv', 'print', 'excel'],
        dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
        }]
    });

    table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
});

function h_modal() {
    var kas = $('#n_kas').val();
    var inv = $('#n_inv').val();
    var pers = $('#n_pers').val();
    var perl = $('#n_perl').val();
    var kend = $('#n_kend').val();
    var total = parseInt(kas) + parseInt(inv) + parseInt(pers) + parseInt(perl) + parseInt(kend);
    $('#n_total').val(convertToRupiah(total));
}

function convertToRupiah(angka) {

    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');

    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';

    return rupiah.split('', rupiah.length - 1).reverse().join('');

}
</script>
</body>

</html>