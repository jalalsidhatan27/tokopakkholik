<div class="page-content">
    <div class="page-header">
        <h1>
            Lap. Laba Rugi
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <form method="post" action="<?php echo base_url(); ?>akunting/filter_lap_laba_rugi" enctype="multipart/form-data">
            <div class="row ">
                <div class="form-grup">
                    <div class="col-xs-12">
                        <select class="form-control" name="bulan">
                            <option value="">Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
                <div class="form-grup">
                    <div class="col-xs-12">
                        <select class="form-control" name="tahun">
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = 2019; $i < 2028; $i++) {
                                # code...
                            ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Filter</button>
                <a class="btn btn-success" href="<?php echo base_url(); ?>akunting/labarugi_print"><i class="fa fa-print"></i> Print
                </a>
            </div>
        </form>
    </div>
</div>