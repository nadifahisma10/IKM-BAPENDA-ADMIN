<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Hasil_Survei_Bapenda.xls");

    // Include file koneksi
    include 'connect.php';

    // Ambil id kategori dari URL
    $id_kategorisend = $_GET['id'];

    // Cek apakah parameter 'from' dan 'to' ada
    if (isset($_GET['from'], $_GET['to'])) {

        $result = '';
        // Query untuk mengambil data responden berdasarkan kategori dan tanggal
        $query = "SELECT * FROM responden 
                  JOIN jawaban_user 
                  ON id_responden = id_respondenj 
                  WHERE id_kategoriResponden = ? 
                  AND tanggal BETWEEN ? AND ?";
        
        // Persiapkan statement
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $id_kategorisend, $_GET['from'], $_GET['to']);
        $stmt->execute();
        $sql = $stmt->get_result();

        // HTML table untuk hasil export
        $result .= '
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p><b>PENGOLAHAN INDEKS KEPUASAN MASYARAKAT PER RESPONDEN DAN PER RUANG LINGKUP PELAYANAN</b></p>
                    </div>
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
                        </thead>';

        $no = 1;
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $jk = ($data['jenis_kelamin'] == 1) ? "L" : "P";
                $result .= '
                    <tbody>
                        <tr>
                            <td><center>' . $no++ . '.</center></td>
                            <td>' . $data["nama"] . '</td>
                            <td><center>' . $data["pendidikan"] . '</center></td>
                            <td>' . $data["pekerjaan"] . '</td>
                            <td><center>' . $jk . '</center></td>
                            <td><center>' . $data["umur"] . '</center></td>
                            <td><center>' . $data["tanggal"] . '</center></td>
                            <td><center>' . $data["jawaban1"] . '</center></td>
                            <td><center>' . $data["jawaban2"] . '</center></td>
                            <td><center>' . $data["jawaban3"] . '</center></td>
                            <td><center>' . $data["jawaban4"] . '</center></td>
                            <td><center>' . $data["jawaban5"] . '</center></td>
                            <td><center>' . $data["jawaban6"] . '</center></td>
                            <td><center>' . $data["jawaban7"] . '</center></td>
                            <td><center>' . $data["jawaban8"] . '</center></td>
                            <td><center>' . $data["jawaban9"] . '</center></td>
                            <td><center>' . $data["jawaban10"] . '</center></td>
                        </tr>';
            }

            // Menghitung jumlah total jawaban untuk setiap pertanyaan
            $queryj = $conn->prepare("SELECT COUNT(*) AS jumlah FROM responden 
                                      JOIN jawaban_user 
                                      ON id_responden = id_respondenj 
                                      WHERE id_kategoriResponden = ? 
                                      AND tanggal BETWEEN ? AND ?");
            $queryj->bind_param("iss", $id_kategorisend, $_GET['from'], $_GET['to']);
            $queryj->execute();
            $jumlah = $queryj->get_result()->fetch_assoc();
            $count = $jumlah['jumlah'];

            // Menghitung jawaban total
            $queryv = $conn->prepare("SELECT * FROM responden 
                                      JOIN jawaban_user 
                                      ON id_responden = id_respondenj 
                                      WHERE id_kategoriResponden = ? 
                                      AND tanggal BETWEEN ? AND ?");
            $queryv->bind_param("iss", $id_kategorisend, $_GET['from'], $_GET['to']);
            $queryv->execute();
            $resultv = $queryv->get_result();

            $jawaban1 = $jawaban2 = $jawaban3 = $jawaban4 = $jawaban5 = $jawaban6 = $jawaban7 = $jawaban8 = 0;

            while ($datav = $resultv->fetch_assoc()) {
                $jawaban1 += $datav['jawaban1'];
                $jawaban2 += $datav['jawaban2'];
                $jawaban3 += $datav['jawaban3'];
                $jawaban4 += $datav['jawaban4'];
                $jawaban5 += $datav['jawaban5'];
                $jawaban6 += $datav['jawaban6'];
                $jawaban7 += $datav['jawaban7'];
                $jawaban8 += $datav['jawaban8'];
                $jawaban9 += $datav['jawaban9'];
                $jawaban10 += $datav['jawaban10'];
            }

            $average1 = $jawaban1 / $count;
            $average2 = $jawaban2 / $count;
            $average3 = $jawaban3 / $count;
            $average4 = $jawaban4 / $count;
            $average5 = $jawaban5 / $count;
            $average6 = $jawaban6 / $count;
            $average7 = $jawaban7 / $count;
            $average8 = $jawaban8 / $count;
            $average9 = $jawaban9 / $count;
            $average10 = $jawaban10 / $count;

            $result .= '
                <tr>
                    <th>
                        <td><b>NRR</b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><center><b>' . number_format($average1, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average2, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average3, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average4, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average5, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average6, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average7, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average8, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average9, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average10, 2) . '</b></center></td>
                    </th>
                </tr>
                <tr>
                    <th>
                        <td><b>NRR Tertimbang</b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><b> </b></td>
                        <td><center><b>' . number_format($average1 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average2 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average3 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average4 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average5 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average6 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average7 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average8 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average9 * 0.125, 2) . '</b></center></td>
                        <td><center><b>' . number_format($average10 * 0.125, 2) . '</b></center></td>
                    </th>
                </tr>
                </tbody>
            </table>';

            // Menghitung total NRR
            $nrr = $average1 + $average2 + $average3 + $average4 + $average5 + $average6 + $average7 + $average8 + $average9 + $average10;

            $result .= '
                <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>
                        <td width="61%"></td>
                        <td width="61%"><b>Jumlah NRR IKM tertimbang</b></td>
                        <td class="text-primary"><h4><center><b>' . number_format($nrr, 2) . '</b></center></h4></td>
                    </tr>
                    <tr>
                        <td width="61%"></td>
                        <td width="61%"><b>Nilai IKM (JML NRR IKM tertimbang * 25)</b></td>
                        <td class="text-primary"><h3><center><b>' . number_format($nrr * 25, 2) . '</b></center></h3></td>
                    </tr>
                </table>';
        } else {
            $result .= '
                <tr>
                    <td colspan="15" class="text-info">Tidak Ada Responden Untuk Periode Waktu Ini, Silahkan Atur Waktu yang Sesuai !</td>
                </tr>';
        }

        $result .= '</table>';
        echo $result;
    }
?>
