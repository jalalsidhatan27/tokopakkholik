<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Jurnal Umum</h3>
            <div class="card-tools">
                <button data-toggle="modal" data-target="#add" type="button" class="btn btn-primary btn-sm"><i
                        class="fas fa-plus"></i>Add</button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php
            if ($this->session->flashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i>';
                echo $this->session->flashdata('pesan');
                echo '</h5></div>';
            }
            ?>
            <table class="table table-bordered" id="example1">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Perkiraan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no  = 1;
                    $tgl = '';
                    $ket = '';
                    $jum = 1;
                    foreach ($ju as $key => $value) {
                    ?>
                    <td class="center"><?php echo $no++; ?></td>
                    <td class="center">
                        <?php if ($tgl != $value->tanggal) {
                                $tgl = $value->tanggal;
                                echo date('d F Y', strtotime($value->tanggal));
                            } else {
                                echo "";
                            }  ?>
                    </td>
                    <td>
                        <?= $value->nama_perkiraan ?>
                    </td>
                    <td class="center" contenteditable="true"
                        onBlur="updateju(this,'debet','<?php echo $value->no; ?>')" onClick="showEdit(this);">
                        <?php echo number_format($value->debet, 0, ".", "."); ?></td>
                    <td class="center" contenteditable="true"
                        onBlur="updateju(this,'kredit','<?php echo $value->no; ?>')" onClick="showEdit(this);">
                        <?php echo number_format($value->kredit, 0, ".", "."); ?></td>
                    <td class="center">
                        <?php if ($ket != $value->keterangan) {
                                $ket = $value->keterangan;
                                echo $value->keterangan;
                            } else {
                                echo "";
                            }  ?>
                    </td>

                    <td><a href="<?= base_url(); ?>akunting/hapus_ju/<?= $value->no; ?>" class="btn btn-primary"><i
                                class="fa fa-trash"></i> Hapus</a></td>
                    </tr>
                    <?php } ?>

                    <!--GET TOTAL JURNAL UMUM -->
                    <tr>
                        <td class="text-center"><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td title="total debet" class="text-center"><strong>Rp
                                <?php echo number_format($total_debet->debet, 0, ".", "."); ?></strong></td>
                        <td title="total kredit" class="text-center"><strong>Rp
                                <?php echo number_format($total_kredit->kredit, 0, ".", "."); ?></strong></td>
                        <td></td>
                        <td></td>
                    </tr>


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>


<!-- modal add -->
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Jurnal Umum</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('akunting/tambah_ju');
                ?>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" data-field="date" required="true"
                        data-format="dd-MM-yyyy" />
                </div>

                <div class="form-group">
                    <label>Nama Perkiraan</label>
                    <select name="akun" class="form-control">
                        <option value="">--Nama Perkiraan--</option>
                        <?php foreach ($reference as $key => $value) { ?>
                        <option value="<?= $value->id ?>"><?= $value->nama_perkiraan ?></option>
                        <?php } ?>
                        <option value="b_hutang_dagang">Pembayaran Hutang Dagang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Biaya</label>
                    <input type="text" name="biaya" id="biaya" class="form-control" placeholder="Biaya">
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->