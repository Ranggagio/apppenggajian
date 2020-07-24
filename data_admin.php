<?php include "header.php"; ?>

    <!-- Begin page content -->
    <div class="container">
      
    <?php
    $view = isset($_GET['view']) ? $_GET['view'] : null;
    switch($view){
      default:
      //untuk pesan berhasil atau gagal proses 
      if(isset($_GET['e']) && $_GET['e']=='sukses'){
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Selamat!</strong> Proses Berhasil.
        </div>

        <?php
             }elseif(isset($_GET['e']) && $_GET['e']=='gagal'){
        ?>

        <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> Proses Gagal.
        </div>
        <?php  
      } 
        
      ?>
           <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Data Administrator</h3>
        </div>
        <div class="panel-body">
        <a href="data_admin.php?view=tambah" class="btn btn-primary" style="margin-bottom: 10px;">Tambah Data</a>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Nama Lengkap</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
              $sqlAdmin = mysqli_query($konek, "SELECT * FROM admin ORDER BY username ASC");
              while($data=mysqli_fetch_array($sqlAdmin)){
                echo "<tr>
                  <td class='text-center'>$no</td>
                  <td>$data[username]</td>
                  <td class='text-center'>
                    <a href='data_admin.php?view=edit&id=$data[idadmin]' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='aksi_admin.php?act=delete&id=$data[idadmin]' class='btn btn-warning btn-sm'>Hapus</a>
                    </td>
                </tr>";
                $no++;
              }
            ?>

        </table>

      </div>
    </div>
      <?php
      break;
      case "tambah":
      ?>
         <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Tambah Data Administrator</h3>
        </div>
        <div class="panel-body">


        <form class="form-horizontal" method="POST" action="aksi_admin.php?act=insert">
          <div class="form-group">
            <label class="col-md-4">Username</label>
            <div class="col-md-8">
              <input type="text" name="username" class="form-control" placeholder="Username" required>
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4">Password</label>
            <div class="col-md-8">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4">Nama Lengkap</label>
            <div class="col-md-8">
              <input type="text" name="namalengkap" class="form-control" placeholder="Nama Lengkap" required>
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Simpan">
              <a href="data_admin.php" class="btn btn-danger">Batal</a>
          </div>
      </div>
    </form>

    </div>
    </div>
      <?php
      break;
      case "edit":

      $sqlEdit = mysqli_query($konek, "SELECT * FROM admin WHERE idadmin='$_GET[id]'");
      $e = mysqli_fetch_array($sqlEdit);
      ?>
         <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Edit Data Administrator</h3>
        </div>
        <div class="panel-body">

            <form class="form-horizontal" method="POST" action="aksi_admin.php?act=update">
              <input type="hidden" name="idadmin" value="<?php echo $e['idadmin']; ?>">
          <div class="form-group">
            <label class="col-md-4">Username</label>
            <div class="col-md-8">
              <input type="text" name="username" class="form-control" value="<?php echo $e['username']; ?>" required>
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4">Password</label>
            <div class="col-md-8">
              <input type="password" name="password" class="form-control" placeholder="Password">
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4">Nama Lengkap</label>
            <div class="col-md-8">
              <input type="text" name="namalengkap" class="form-control" value="<?php echo $e['namalengkap']; ?>" required>
          </div>
      </div>

      <div class="form-group">
            <label class="col-md-4"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Update Data">
              <a href="data_admin.php" class="btn btn-danger">Batal</a>
          </div>
      </div>
    </form>

          </div>
      </div>
    </div>
      <?php
      break;
    }
    ?>


   <?php include "footer.php"; ?>
    
