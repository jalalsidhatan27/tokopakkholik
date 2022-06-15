<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="h5 mb-0 card-title align-self-center">
                            Ubah <?= $title; ?>
                        </h3>
                    </div>
                    <div class="col text-right">
                        <a href="<?= base_url('supplier') ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-chevron-left"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= form_open(); ?>
                <div class="form-group">
                    <label for="namaSupplier">Nama Supplier</label>
                    <input value="<?= set_value('namaSupplier', $supplier->namaSupplier) ?>" type="text"
                        id="namaSupplier" name="namaSupplier" class="form-control" placeholder="Nama Supplier...">
                    <?= form_error('namaSupplier'); ?>
                </div>
                <div class="form-group">
                    <label for="alamatSupplier">Alamat</label>
                    <input value="<?= set_value('alamatSupplier', $supplier->alamatSupplier) ?>" type="text"
                        id="alamatSupplier" name="alamatSupplier" class="form-control" placeholder="Alamat Supplier...">
                    <?= form_error('alamatSupplier'); ?>
                </div>
                <div class="form-group">
                    <label for="noTelp">No Telepon</label>
                    <input value="<?= set_value('noTelp', $supplier->noTelp) ?>" type="text" id="noTelp" name="noTelp"
                        class="form-control" placeholder="No Telepon...">
                    <?= form_error('noTelp'); ?>
                </div>
                <!-- <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea value="<?= set_value('keterangan', $supplier->keterangan) ?>" type="text" id="keterangan"
                        name="keterangan" class="form-control" placeholder="Keterangan ...">
                    <?= form_error('keterangan'); ?>
                </div> -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="4"
                        placeholder="keterangan ..."><?= $supplier->keterangan ?></textarea>
                </div>

                <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>