<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Pemeriksaan Pasien";
  $page1 = "raw1";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";

  if (isset($_POST['reset_ant'])) {
    $del = mysqli_query($conn, "TRUNCATE TABLE antrian");
    echo '<script>
    setTimeout(function() {
      swal({
        title: "Antrian Berhasil Di Reset!",
        text: "Antrian Pasien Berhasil Di Reset",
        icon: "success"
        });
      }, 500);
  </script>';
  }
  ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <?php
      include 'part/navbar.php';
      include 'part/sidebar.php';
      ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $mbuh; ?></h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Antrian <?php echo $page; ?></h4>
                    <div class="card-header-action">
                      <a href="#" data-target="#reset_ant" data-toggle="modal" class="btn btn-danger">Reset Antrian</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="antrian">
                        <thead>
                          <tr>
                            <th>No. Antrian</th>
                            <th>ID Pasien</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM antrian");
                          while ($row = mysqli_fetch_array($sql)) {
                            $idpasien = $row['id_pasien'];
                          ?>
                            <tr>
                              <td><?php echo $row['no_urut']; ?></td>
                              <?php
                              $pasien = mysqli_query($conn, "SELECT * FROM pasien WHERE id='$idpasien'");
                              $pas = mysqli_fetch_array($pasien);
                              ?>
                              <td><?php echo $pas['kode_pasien']; ?></td>
                              <td><?php echo ucwords($pas['nama_pasien']); ?></td>
                              <td>
                                <?php
                                if ($row['status'] == 0) {
                                  echo '<div class="badge badge-pill badge-primary mb-1">Belum Diperiksa';
                                } else {
                                  echo '<div class="badge badge-pill badge-danger mb-1">Sudah diperiksa';
                                }
                                ?>
                    </div>
                    </td>
                    <td>
                      <?php if ($row['status'] == 0) { ?>
                        <span data-target="#editPasien" data-toggle="modal" data-id="<?php echo $idpasien; ?>" data-whatever="<?php echo ucwords($pas['nama_pasien']); ?>" data-lahir="<?php echo $row['tgl_lahir']; ?>" data-tinggi="<?php echo $row['tinggi_badan']; ?>" data-berat="<?php echo $row['berat_badan']; ?>">
                          <a class="btn btn-primary btn-action mr-1" title="Periksa Pasien" data-toggle="tooltip"><i class="fas fa-stethoscope"></i> Periksa Pasien</a>
                        </span>
                      <?php } else { ?>
                        <a class="btn btn-secondary btn-action mr-1" title="Pasien sudah diperiksa" data-toggle="tooltip"><i class="fas fa-stethoscope"></i> Pasien sudah diperiksa</a>
                      <?php } ?>
                    </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="reset_ant">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hapus Antrian Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="needs-validation" novalidate="">
              Apakah anda yakin ingin menghapus antrian pasien?
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="reset_ant">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="editPasien">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="detail_pasien.php" method="POST" novalidate="" target="_blank">
              <div class="form-group row">
                <div class="col-sm-9">
                  <input type="hidden" name="id" required="" id="getNama">
                  <button type="submit" class="btn btn-primary" name="submit">Periksa Rekam Medis Pasien</button>
                </div>
              </div>
            </form>
            <form action="" method="POST" class="needs-validation" novalidate="">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tekanan Darah</label>
                <div class="input-group col-sm-9">
                  <input type="hidden" name="id" required="" id="getId">
                  <input type="number" class="form-control" name="tensi" required="" placeholder="Tekanan Darah Pasien">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      mmHg
                    </div>
                  </div>
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Berat Badan</label>
                <div class="input-group col-sm-9">
                  <input type="number" class="form-control" name="berat" required="" value="0" placeholder="Berat Badan Pasien">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Kg
                    </div>
                  </div>
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tinggi Badan</label>
                <div class="col-sm-9 input-group">
                  <input type="number" class="form-control" name="tinggi" required="" value="0" placeholder="Tinggi Badan Pasien">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      cm
                    </div>
                  </div>
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Diagnosa Penyakit</label>
                <div class="col-sm-9">
                  <textarea placeholder="Wajib" class="summernote" name="diagnosa" required></textarea>
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Fonis Penyakit</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="tensi" required="" placeholder="Nama Penyakit yang menyerang Pasien">
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Biaya Pemeriksaan</label>
                <div class="input-group col-md-9">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Rp
                    </div>
                  </div>
                  <input type="number" class="form-control" name="biaya" required="" value="0">
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Pemeriksaan Selesai</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include 'part/footer.php'; ?>
  </div>
  </div>
  <?php include "part/all-js.php"; ?>

  <script>
    $('#editPasien').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var id = button.data('id')
      var modal = $(this)
      modal.find('.modal-title').text('Pemeriksaan Pasien yang bernama ' + recipient)
      modal.find('#getId').val(id)
      modal.find('#getNama').val(recipient)
    })
  </script>
</body>

</html>