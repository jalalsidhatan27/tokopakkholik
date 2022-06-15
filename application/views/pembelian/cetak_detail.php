<style type="text/css">
.table-data {
    width: 100%;
    border-collapse: collapse;
}

.table-data tr th,
.table-data tr td {
    border: 1px solid black;
    font-size: 11pt;
    padding: 10px;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

h3 {
    text-transform: uppercase;
}

.py-2 {
    padding: 40px 0;
}
</style>

<div class="text-center">
    <h3>Laporan Pembelian</h3>
    <p class="desc">No.<?= $pembelian->idPembelian; ?></p>
</div>
<br />
<table class="py-2">
    <tr>
        <td>Tanggal</td>
        <td>: <?= indo_date($pembelian->tanggal) ?></td>
    </tr>
    <tr>
        <td>Operator</td>
        <td>: <?= $pembelian->nama; ?></td>
    </tr>

</table>
<table class="table-data">

    <tr class="text-center">
        <th>#</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php
    $no = 1;
    foreach ($detail as $row) : ?>
    <tr>
        <td align="center"><?= $no++; ?>.</td>
        <td><?= $row->namaBarang; ?></td>
        <td align="right"><?= format_uang($row->hargaBeli) ?></td>
        <td align="center"><?= $row->qty; ?></td>
        <td align="right"><?= format_uang($row->subtotal) ?></td>
    </tr>
    <?php endforeach; ?>

    <tr>
        <th colspan="4" class="text-right">Total Harga</th>
        <th class="text-right"><?= format_uang($pembelian->totalHargaBeli) ?></th>
    </tr>
    <!-- <tr>
        <th colspan="4" class="text-right">Payment Amount</th>
        <th class="text-right"><?= format_uang($pembelian->uangBayar) ?></th>
    </tr>
    <tr>
        <th colspan="4" class="text-right">Refund</th>
        <th class="text-right"><?= format_uang($pembelian->kembalian) ?></th>
    </tr> -->

</table>