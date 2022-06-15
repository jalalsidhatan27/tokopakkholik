<div class="row my-4">
    <div class="col-md-9 pb-4 pb-sm-0">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <h5 class="font-weight-light mb-0">Keranjang Pemesanan</h5>
                        <span class="text-muted small">Daftar Barang</span>
                    </div>
                    <div class="col-sm text-right">
                        <a href="<?= base_url('pembelian/add_item') ?>" class="btn btn-primary"><i
                                class="fa fa-plus"></i> Tambah</a>
                        <a onclick="return confirm('Data pemesanan akan dihapus. anda yakin ingin batal?')"
                            href="<?= base_url('pembelian') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
                            Batal</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mt-3 mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Beli</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$keranjangb) : ?>
                            <tr>
                                <td class="text-center" colspan="6">
                                    Tidak ada barang dikeranjang
                                </td>
                            </tr>
                            <?php
                            else :
                                $no = 1;
                                foreach ($keranjangb as $row) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $row->namaBarang; ?></td>
                                <td><?= $row->qty; ?></td>
                                <td><?= format_uang($row->hargaBeli) ?></td>
                                <td><?= format_uang($row->hargaBeli * $row->qty) ?></td>
                                <td>
                                    <a onclick="return confirm('Yakin ingin hapus?');"
                                        href="<?= base_url('pembelian/delete_item/' . $row->noItem) ?>"
                                        class="badge badge-danger py-2 px-3">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <?= form_open(); ?>
                <!-- <div class="form-group">
                    <label for="namaPelanggan">Nama Pelanggan</label>
                    <select name="idPelanggan" class="form-control select_nm_pel">
                        <option value="">--Pilih Pelanggan--</option>
                        <?php foreach ($pelanggan as $p) { ?>
                        <option value="<?= $p->idPelanggan; ?> " data-alamat="<?= $p->alamatPelanggan; ?>"
                            data-telp="<?= $p->noTelp; ?>">
                            <?= $p->namaPelanggan; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamatPelanggan">Alamat</label>
                    <input type="text" name="alamatPelanggan" rows="2" id="alamat_pel" class="form-control"
                        placeholder="Alamat Pelanggan...">
                </div>
                <div class="form-group">
                    <label for="noTelp">No Telp</label>
                    <div>
                        <input type="text" name="noTelp" id="no_telp_pel" rows="3" class="form-control"
                            placeholder="No Telepon...">
                    </div>
                </div> -->

                <!-- <div class="form-group">
                    <label for="namaPelanggan">Nama Pelanggan</label>
                    <input type="text" name="namaPelanggan" value="<?= set_value('namaPelanggan') ?>"
                        class="form-control" placeholder="Nama Pelanggan...">
                </div>
                <div class="form-group">
                    <label for="alamatPelanggan">Alamat</label>
                    <textarea class="form-control" name="alamatPelanggan" rows="2"
                        placeholder="Alamat Pelanggan..."><?= set_value('alamatPelanggan'); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="noTelp">No Telp</label>
                    <div>
                        <input type="text" name="noTelp" <?= set_value('noTelp'); ?> id="no_telp_pel" rows="3"
                            class="form-control" placeholder="No Telepon...">
                    </div>
                </div>
                <hr> -->

                <div class="form-group">
                    <label for="konfirmasi">Confirm</label>
                    <input type="text" name="konfirmasi" value="<?= set_value('konfirmasi') ?>" class="form-control"
                        placeholder="Confirm...">
                </div>

                <?= $this->session->flashdata('msg'); ?>

                <div class="form-group">
                    <label for="total">Total Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp.</div>
                        </div>
                        <input type="hidden" name="totalHargaBeli" id="totalHargaBeli"
                            value="<?= $total_harga_beli; ?>">
                        <input type="text" class="form-control" readonly
                            value="<?= format_uang($total_harga_beli, false); ?>">
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="uangBayar">Uang Bayar</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp.</div>
                        </div>
                        <input name="uangBayar" type="number" class="form-control" id="uangBayar" placeholder="0">
                    </div>
                    <?= form_error('uangBayar'); ?>
                </div>
                <div class="form-group">
                    <label for="kembalian">Kembalian</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp.</div>
                        </div>
                        <input type="text" class="form-control" id="kembalian" readonly value="0">
                    </div>
                </div> -->
                <hr>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-check"></i> Simpan
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('body').on('keyup', '#uangBayar', function() {
        let total = $('#totalHargaBeli').val();
        let uang = $(this).val();

        $('#kembalian').val(uang - total);
    });
});

$('.select_nm_pel').change(function() {
    var alamatPelanggan = $('option:selected', this).attr('data-alamat');
    var noTelp = $('option:selected', this).attr('data-telp');
    $('#alamat_pel').val(alamatPelanggan);
    $('#no_telp_pel').val(noTelp);
});
</script>