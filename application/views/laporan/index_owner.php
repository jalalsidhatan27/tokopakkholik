<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white">
                <h3 class="h5 mb-0 card-title text-center">
                    Buat Laporan Pembelian
                </h3>
            </div>
            <div class="card-body">
                <?= form_open(); ?>
                <div class="form-group">
                    <label for="tanggal">Tanggal Pembelian</label>
                    <div class="input-group">
                        <input value="<?= set_value('tanggal'); ?>" type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal Pembelian...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <?= form_error('tanggal'); ?>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Cetak <i class="fa fa-fw fa-print"></i></button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>