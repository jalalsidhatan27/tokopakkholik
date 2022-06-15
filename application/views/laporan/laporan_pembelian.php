<style type="text/css">
table {
    width: 100%;
    border-collapse: collapse;
}

table tr th,
table tr td {
    border: 1px solid black;
    font-size: 11pt;
    padding: 10px;
}

.text-center {
    text-align: center;
}

h3 {
    text-transform: uppercase;
}
</style>

<div class="text-center">
    <h3>Laporan Pembelian</h3>
    <p class="desc"><?= $tanggal; ?></p>
</div>
<table>
    <tr>
        <td>Total Pembelian</td>
        <td>:</td>
        <td><?= $jumlah ?> Pembelian</td>
    </tr>
    <tr>
        <td>Total Pendapatan</td>
        <td>:</td>
        <td><?= format_uang($total) ?></td>
    </tr>
</table>
<br />
<br />
<table>
    <tr>
        <th>No</th>
        <th>ID Pembelian</th>
        <th>Tanggal</th>
        <th>Total Harga</th>
        <th>Pelanggan</th>
        <th>Alamat</th>
        <th>Petugas</th>
    </tr>
    <?php
    $no = 1;
    foreach ($pembelian as $row) :
    ?>
    <tr>
        <td align="center"><?= $no++; ?></td>
        <td align="center"><?= $row->idPembelian ?></td>
        <td align="center"><?= indo_date($row->tanggal) ?></td>
        <td align="center"><?= format_uang($row->totalHargaBeli); ?></td>
        <td align="center"><?= $row->namaPelanggan ?></td>
        <td align="center"><?= $row->alamatPelanggan ?></td>
        <td align="center"><?= $row->nama; ?></td>
    </tr>
    <?php endforeach; ?>
</table>