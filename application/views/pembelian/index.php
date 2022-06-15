<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="h5 mb-0 card-title align-self-center">
                            Data <?= $title; ?>
                        </h3>
                    </div>
                    <div class="col text-right">
                        <a href="<?= base_url('pembelian/add') ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped mb-0 datatable">
                    <thead>
                        <tr>
                            <th width="100">No.</th>
                            <th>ID Pembelian</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pembelian as $row) : ?>
                        <tr>
                            <td><?= $no++; ?>.</td>
                            <td>
                                <a href="<?= base_url('pembelian/detail/') . $row->idPembelian; ?>">
                                    <?= $row->idPembelian; ?>
                                </a>
                            </td>
                            <td><?= indo_date($row->tanggal); ?></td>
                            <td><?= format_uang($row->totalHargaBeli); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a onclick="return confirm('Yakin ingin hapus data?')"
                                        href="<?= base_url('pembelian/hapus/') . $row->idPembelian ?>"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>