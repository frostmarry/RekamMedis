<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Pemeriksaan Pasien";
  $page1 = "raw1";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
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
                      <a href="#reset" class="btn btn-danger">Reset Antrian</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
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
                      <span data-target="#editPasien" data-toggle="modal" data-id="<?php echo $idpasien; ?>" data-nama="<?php echo $row['nama_pasien']; ?>" data-lahir="<?php echo $row['tgl_lahir']; ?>" data-tinggi="<?php echo $row['tinggi_badan']; ?>" data-berat="<?php echo $row['berat_badan']; ?>">
                        <a class="btn btn-primary btn-action mr-1" title="Edit Data Pasien" data-toggle="tooltip"><i class="fas fa-stethoscope"></i> Periksa Pasien</a>
                      </span>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="editPasien">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="needs-validation" novalidate="">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Pasien</label>
                <div class="col-sm-9">
                  <input type="hidden" class="form-control" name="id" required="" id="getId">
                  <input type="text" class="form-control" name="nama" required="" id="getNama">
                  <div class="invalid-feedback">
                    Mohon data diisi!
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal lahir</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control datepicker" id="getTgl" name="tgl">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Berat Badan</label>
                <div class="input-group col-sm-9">
                  <input type="number" class="form-control" name="berat" required="" id="getBerat">
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
                  <input type="number" class="form-control" name="tinggi" required="" id="getTinggi">
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
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
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
      var nama = button.data('nama')
      var id = button.data('id')
      var tgl = button.data('lahir')
      var berat = button.data('berat')
      var tinggi = button.data('tinggi')
      var modal = $(this)
      modal.find('#getId').val(id)
      modal.find('#getNama').val(nama)
      modal.find('#getTgl').val(tgl)
      modal.find('#getBerat').val(berat)
      modal.find('#getTinggi').val(tinggi)
    })
  </script>
</body>

</html>