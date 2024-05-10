<?php
require_once 'header.php';
require_once 'sidebar.php';

require '../dbkoneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query to fetch data of periksa based on ID
    $sql = "SELECT * FROM periksa WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["submit"])) {
    $_id = $_POST['id'];
    $_tanggal = $_POST['tanggal'];
    $_berat = $_POST['berat'];
    $_tinggi = $_POST['tinggi'];
    $_tensi = $_POST['tensi'];
    $_keterangan = $_POST['keterangan'];
    $_pasien_id = $_POST['pasien_id'];
    $_dokter_id = $_POST['dokter_id'];

    // Check if the ID already exists in the database
    $existing_id = $_GET['id'];
    $sql_check_id = "SELECT id FROM periksa WHERE id = ?";
    $stmt_check_id = $dbh->prepare($sql_check_id);
    $stmt_check_id->execute([$existing_id]);
    $existing_row = $stmt_check_id->fetch(PDO::FETCH_ASSOC);

    if ($existing_row) {
        // If ID exists, perform an update
        $sql = "UPDATE periksa SET tanggal=?, berat=?, tinggi=?, tensi=?, keterangan=?, pasien_id=?, dokter_id=? WHERE id=?";
        $data = [$_tanggal, $_berat, $_tinggi, $_tensi, $_keterangan, $_pasien_id, $_dokter_id, $_id];
    } else {
        // If ID doesn't exist, perform an insert
        $sql = "INSERT INTO periksa (id, tanggal, berat, tinggi, tensi, keterangan, pasien_id, dokter_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $data = [$_id, $_tanggal, $_berat, $_tinggi, $_tensi, $_keterangan, $_pasien_id, $_dokter_id];
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    echo "<script>window.location.href = 'index.php';</script>";
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Website</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Periksa</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="text-center">Form Periksa</h2>
                            <form action="edit.php?id=<?= $row['id'] ?>" method="POST">
                                <div class="form-group row">
                                    <label for="id" class="col-4 col-form-label">ID</label>
                                    <div class="col-8">
                                        <input id="id" name="id" type="text" class="form-control" value="<?= $row['id'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal" class="col-4 col-form-label">Tanggal</label>
                                    <div class="col-8">
                                        <input id="tanggal" name="tanggal" type="date" class="form-control" value="<?= $row['tanggal'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="berat" class="col-4 col-form-label">Berat</label>
                                    <div class="col-8">
                                        <input id="berat" name="berat" type="text" class="form-control" value="<?= $row['berat'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tinggi" class="col-4 col-form-label">Tinggi</label>
                                    <div class="col-8">
                                        <input id="tinggi" name="tinggi" type="text" class="form-control" value="<?= $row['tinggi'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tensi" class="col-4 col-form-label">Tensi</label>
                                    <div class="col-8">
                                        <input id="tensi" name="tensi" type="text" class="form-control" value="<?= $row['tensi'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan" class="col-4 col-form-label">Keterangan</label>
                                    <div class="col-8">
                                        <textarea id="keterangan" name="keterangan" cols="30" rows="10"><?= $row['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pasien_id" class="col-4 col-form-label">Pasien</label>
                                    <div class="col-8">
                                        <select id="pasien_id" name="pasien_id" class="custom-select">
                                            <?php
                                            $sql_pasien = "SELECT * FROM pasien";
                                            $rs_pasien = $dbh->query($sql_pasien);
                                            foreach ($rs_pasien as $row_pasien) {
                                                echo "<option value=\"{$row_pasien['id']}\">{$row_pasien['nama']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dokter_id" class="col-4 col-form-label">Dokter</label>
                                    <div class="col-8">
                                        <select id="dokter_id" name="dokter_id" class="custom-select">
                                            <?php
                                            $sql_dokter = "SELECT * FROM dokter";
                                            $rs_dokter = $dbh->query($sql_dokter);
                                            foreach ($rs_dokter as $row_dokter) {
                                                echo "<option value=\"{$row_dokter['id']}\">{$row_dokter['nama']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-4 col-8">
                                        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Footer
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
require_once 'footer.php';
?>
