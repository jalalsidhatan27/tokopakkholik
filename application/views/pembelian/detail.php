<div class="row">
    <div class="col-md-3">
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Petugas</h6>
                    <small class="text-muted"><?= $pembelian->nama; ?></small>
                </div>
                <span class="text-muted"></span>
            </li>
            <!-- <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Uang Bayar</h6>
                    <small class="text-muted"><?= format_uang($pembelian->uangBayar); ?></small>
                </div>
                <span class="text-muted"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Kembalian</h6>
                    <small class="text-muted"><?= format_uang($pembelian->kembalian); ?></small>
                </div>
                <span class="text-muted"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Nama Pelanggan</h6>
                    <small class="text-muted"><?= $pembelian->namaPelanggan; ?></small>
                </div>
                <span class="text-muted"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Alamat Pelanggan</h6>
                    <small class="text-muted"><?= $pembelian->alamatPelanggan; ?></small>
                </div>
                <span class="text-muted"></span>
            </li> -->
        </ul>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <h5 class="font-weight-light mb-0">Detail pembelian</h5>
                        <span class="text-muted small"><?= $pembelian->idPembelian ?> &bullet;
                            <?= indo_date($pembelian->tanggal, true) ?></span>
                    </div>
                    <div class="col-sm text-right">
                        <a href="<?= base_url('pembelian/cetak_detail/') . $idPembelian ?>" class="btn btn-primary"><i
                                class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mt-3 mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah Beli</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($detail as $row) : ?>
                            <tr>
                                <td align="center"><?= $no++; ?>.</td>
                                <td align="center"><?= $row->namaBarang; ?></td>
                                <td align="center"><?= format_uang($row->hargaBeli) ?></td>
                                <td align="center"><?= $row->qty; ?></td>
                                <td align="right"><?= format_uang($row->subtotal) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total Harga</th>
                                <th class="text-right"><?= format_uang($pembelian->totalHargaBeli) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>