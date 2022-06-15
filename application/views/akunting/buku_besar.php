<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buku Besar</h3>
            <form method="post" class="col-xs-4" action="<?php echo base_url('akunting/get_bukubesar'); ?>">

                <select class="form-control" name="akun" onchange="this.form.submit()">
                    <option value="">-- Nama Akun -- </option>
                    <?php
                    foreach ($ref as $r) {
                    ?>
                    <option value="<?php echo $r->nama_perkiraan; ?>"><?php echo $r->nama_perkiraan; ?></option>
                    <?php } ?>
                </select>

            </form>
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
                        <th class="center" width="10%">No.</th>
                        <th class="center">Tanggal</th>
                        <th class="center">Keterangan</th>
                        <th class="center">Nama Perkiraan</th>
                        <th class="center">Debet</th>
                        <th class="center">Kredit</th>
                        <th class="center">Saldo Debet</th>
                        <th class="center">Saldo Kredit</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <?php
                        $no          = 1;
                        $tgl         = '';
                        $ket         = '';
                        $s_debet     = 0;
                        $s_kredit     = 0;
                        foreach ($ju as $j) {
                            $s_debet  += $j->debet  - $j->kredit;
                            $s_kredit += $j->kredit - $j->debet;
                            $last       = array($s_kredit);
                        ?>

                        <td class="center"><?php echo $no++; ?></td>

                        <td class="center">
                            <?php if ($tgl != $j->tanggal) {
                                    $tgl = $j->tanggal;
                                    echo date('d F Y', strtotime($j->tanggal));
                                } else {
                                    echo "";
                                }  ?>
                        </td>

                        <td class="center">
                            <?php if ($ket != $j->keterangan) {
                                    $ket = $j->keterangan;
                                    echo $j->keterangan;
                                } else {
                                    echo "";
                                }  ?>
                        </td>

                        <td><?php
                                if ($j->debet == 0) {
                                    // echo nbs() . $j->nama_perkiraan;
                                    echo $j->nama_perkiraan;
                                } else {
                                    echo $j->nama_perkiraan;
                                } ?>
                        </td>

                        <td class="center">Rp <?php echo number_format($j->debet, 0, ".", "."); ?></td>

                        <td class="center">Rp <?php echo number_format($j->kredit, 0, ".", "."); ?></td>

                        <td class="center"><?php if (@$set_saldo->debet == 0) {
                                                    echo "-";
                                                } else {
                                                    echo number_format($s_debet, 0, ".", ".");
                                                }; ?></td>

                        <td class="center"><?php if (@$set_saldo->kredit == 0) {
                                                    echo "-";
                                                } else {
                                                    echo number_format($s_kredit, 0, ".", ".");
                                                }; ?></td>
                    </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>