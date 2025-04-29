<?php
    require 'side.php';
    include 'connect.php';

    $id_kategorisend = isset($_GET['id']) ? $_GET['id'] : '';
    $from_date = isset($_POST['from']) ? $_POST['from'] : '';
    $to_date = isset($_POST['to']) ? $_POST['to'] : '';
    $sql = "SELECT * FROM responden 
        JOIN jawaban_user ON id_respondenj = id_responden 
        WHERE id_kategoriResponden = ?";

    $params = [$id_kategorisend];
    $types = "s";

    if (!empty($from_date) && !empty($to_date)) {
        $sql .= " AND tanggal BETWEEN ? AND ?";
        $params[] = $from_date;
        $params[] = $to_date;
        $types .= "ss"; // Menambah dua parameter string (tanggal)
    }

    $sql .= " ORDER BY id_responden DESC";

    $query = $conn->prepare($sql);
    $query->bind_param($types, ...$params);

    $query->execute();
    $result = $query->get_result();

    $no = 1;
    // Initialize jawaban_total array with 10 elements, all set to 0
    $jawaban_total = array_fill(1, 10, 0);
    $count = $result->num_rows;
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pengolahan Indeks Kepuasan Masyarakat</h1>
        </div>
    </div>

    <form method="POST" action="">
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Dari Tanggal:</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($from_date) ?>" />
            </div>
            <div class="col-md-3">
                <label>Sampai Tanggal:</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($to_date) ?>" />
            </div>
            <div class="col-md-3">
                <br>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form><br>

    <div id="purchase_order">
        <!-- Data akan dimuat di sini melalui AJAX -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#range").click(function () {
                let fromDate = $("#From").val();
                let toDate = $("#to").val();
                if (fromDate && toDate) {
                    $.ajax({
                        url: "range.php",
                        method: "POST",
                        data: { id: "<?= $id_kategorisend; ?>", from: fromDate, to: toDate },
                        success: function (data) {
                            $("#purchase_order").html(data);
                        }
                    });
                } else {
                    alert("Silakan isi rentang tanggal terlebih dahulu");
                }
            });
        });
    </script>

    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Responden
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama Responden</center></th>
                        <th><center>Pendidikan</center></th>
                        <th><center>Pekerjaan</center></th>
                        <th><center>Jenis Kelamin</center></th>
                        <th><center>Umur</center></th>
                        <th><center>Waktu</center></th>
                        <?php for ($i = 1; $i <= 10; $i++) echo "<th><center>RL-$i</center></th>"; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = $result->fetch_assoc()): ?>
                        <tr>
                            <td><center><?= $no++ ?></center></td>
                            <td><?= htmlspecialchars($data['nama']) ?></td>
                            <td><?= htmlspecialchars($data['pendidikan']) ?></td>
                            <td><?= htmlspecialchars($data['pekerjaan']) ?></td>
                            <td><center><?= $data['jenis_kelamin'] == 1 ? 'L' : 'P' ?></center></td>
                            <td><center><?= htmlspecialchars($data['umur']) ?></center></td>
                            <td><center><?= htmlspecialchars($data['tanggal']) ?></center></td>
                            <?php 
                            for ($i = 1; $i <= 10; $i++) {
                                echo "<td><center>" . htmlspecialchars($data["jawaban$i"]) . "</center></td>";
                                $jawaban_total[$i] += $data["jawaban$i"];
                            }
                            ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($count > 0): ?>
                <h4>Hasil Perhitungan IKM</h4>
                <table class="table table-bordered">
                    <tr>
                        <th><center>NRR</center></th>
                        <?php 
                        $nrr_total = 0;
                        for ($i = 1; $i <= 10; $i++) {
                            $nrr = $jawaban_total[$i] / $count;
                            echo "<td><center>" . number_format($nrr, 2) . "</center></td>";
                            $nrr_total += $nrr * 0.125;
                        }
                        ?>
                    </tr>
                    <tr>
                        <th><center>NRR Tertimbang</center></th>
                        <?php for ($i = 1; $i <= 10; $i++) echo "<td><center>" . number_format(($jawaban_total[$i] / $count) * 0.125, 2) . "</center></td>"; ?>
                    </tr>
                    <tr>
                        <td colspan="9"><b><center>Jumlah NRR IKM tertimbang</center></b></td>
                        <td class="text-primary"><b><center><?= number_format($nrr_total, 2) ?></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="9"><b><center>Nilai IKM (JML NRR IKM tertimbang * 25)</center></b></td>
                        <td class="text-primary"><b><center><?= number_format($nrr_total * 25, 2) ?></center></b></td>
                    </tr>
                </table>
            <?php endif; ?>
            
            <form method='POST' action='export.php?id=<?= $id_kategorisend; ?>'>
                <button type="submit" class="btn btn-success">Ekspor ke Excel</button>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Komentar & Saran Responden
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama Responden</center></th>
                        <th><center>Komentar & Saran</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil data komentar dari database
                    $query_komentar = $conn->prepare("
                        SELECT responden.nama, jawaban_user.komentar 
                        FROM responden 
                        JOIN jawaban_user ON responden.id_responden = jawaban_user.id_respondenj 
                        WHERE responden.id_kategoriResponden = ?
                        ORDER BY responden.id_responden DESC
                    ");
                    $query_komentar->bind_param("s", $id_kategorisend);
                    $query_komentar->execute();
                    $result_komentar = $query_komentar->get_result();
                    
                    $no = 1;
                    while ($data = $result_komentar->fetch_assoc()):
                    ?>
                        <tr>
                            <td><center><?= $no++ ?></center></td>
                            <td><?= htmlspecialchars($data['nama']) ?></td>
                            <td><?= htmlspecialchars($data['komentar']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$query->close();
$conn->close();
?>
