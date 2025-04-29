<?php
    include 'connect.php';  // Koneksi database
    $id_kategorisend = $_GET['id'];

    // Set header untuk ekspor Excel
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=HasilSurvei.xls");

    // Query untuk mendapatkan nama kategori
    $query1 = "SELECT * FROM kategori WHERE id_kategori = $id_kategorisend";
    $sql = mysqli_query($conn, $query1);
    if ($sql && mysqli_num_rows($sql) > 0) {
        $data1 = mysqli_fetch_assoc($sql);
        $kategoriNama = $data1['nama_kategori'];
    } else {
        $kategoriNama = "Kategori Tidak Ditemukan";
    }

    // Ambil data responden dan jawaban
    $query = mysqli_query($conn, "SELECT * FROM responden JOIN jawaban_user ON id_respondenj = id_responden WHERE id_kategoriResponden = '$id_kategorisend'");
    $no = 1;
    $jawabanTotals = array_fill(1, 10, 0);
    $count = mysqli_num_rows($query);

    // Mulai HTML untuk export
    echo '
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b>PENGOLAHAN INDEKS KEPUASAN MASYARAKAT PER RESPONDEN DAN PER RUANG LINGKUP PELAYANAN</b></p>
                    <p>' . htmlspecialchars($kategoriNama) . '</p>
                </div>
                <div class="panel-body">
                    <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Nama Responden</center></th>
                                <th><center>Pendidikan</center></th>
                                <th><center>Pekerjaan</center></th>
                                <th><center>Jenis Kelamin</center></th>
                                <th><center>Umur</center></th>
                                <th><center>Waktu</center></th>
                                <th><center>RL-1</center></th>
                                <th><center>RL-2</center></th>
                                <th><center>RL-3</center></th>
                                <th><center>RL-4</center></th>
                                <th><center>RL-5</center></th>
                                <th><center>RL-6</center></th>
                                <th><center>RL-7</center></th>
                                <th><center>RL-8</center></th>
                                <th><center>RL-9</center></th>
                                <th><center>RL-10</center></th>
                            </tr>
                        </thead>
                        <tbody>';

    // Tampilkan data responden dan jawaban
    while ($data = mysqli_fetch_assoc($query)) {
        $jk = $data['jenis_kelamin'] == 1 ? 'L' : 'P'; // Jenis kelamin
        echo '
        <tr>
            <td><center>' . $no++ . '.</center></td>
            <td>' . htmlspecialchars($data['nama']) . '</td>
            <td><center>' . htmlspecialchars($data['pendidikan']) . '</center></td>
            <td>' . htmlspecialchars($data['pekerjaan']) . '</td>
            <td><center>' . $jk . '</center></td>
            <td><center>' . htmlspecialchars($data['umur']) . '</center></td>
            <td><center>' . htmlspecialchars($data['tanggal']) . '</center></td>';

        // Loop untuk nilai jawaban
        for ($i = 1; $i <= 10; $i++) {
            echo '<td><center>' . htmlspecialchars($data["jawaban$i"]) . '</center></td>';
            $jawabanTotals[$i] += $data["jawaban$i"];
        }
        echo '</tr>';
    }

    // Perhitungan rata-rata jawaban
    $average = [];
    for ($i = 1; $i <= 10; $i++) {
        $average[$i] = $jawabanTotals[$i] / $count;
    }

    // Rata-rata NRR
    echo '
    <tr>
        <th><b>NRR</b></th>';
    for ($i = 1; $i <= 10; $i++) {
        echo '<td><center><b>' . number_format($average[$i], 2) . '</b></center></td>';
    }
    echo '</tr>';

    // NRR Tertimbang
    echo '
    <tr>
        <th><b>NRR Tertimbang</b></th>';
    for ($i = 1; $i <= 10; $i++) {
        $weightedAvg = $average[$i] * 0.125;
        echo '<td><center><b>' . number_format($weightedAvg, 2) . '</b></center></td>';
    }
    echo '</tr>';

    // Hitung total NRR tertimbang dan IKM
    $totalNRR = array_sum($average);
    $totalNRRWeighted = $totalNRR * 0.125;
    $ikm = $totalNRRWeighted * 25;

    echo '
    <tr>
        <td colspan="8"></td>
        <td><b>Jumlah NRR IKM Tertimbang</b></td>
        <td><center><b>' . number_format($totalNRRWeighted, 2) . '</b></center></td>
    </tr>
    <tr>
        <td colspan="8"></td>
        <td><b>Nilai IKM (JML NRR IKM tertimbang * 25)</b></td>
        <td><center><b>' . number_format($ikm, 2) . '</b></center></td>
    </tr>';

    echo '</tbody></table>';
?>
