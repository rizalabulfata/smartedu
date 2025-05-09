<!-- Begin Page Content -->
<div class="container-fluid">

    <?php if ($this->session->userdata('success_msg')): ?>
    <div class="alert alert-success">
        <?= $this->session->userdata('success_msg'); ?>
        <?php $this->session->unset_userdata('success_msg'); ?>
        <!-- Hapus setelah ditampilkan -->
    </div>
    <?php endif; ?>

    <?php if ($this->session->userdata('error_msg')): ?>
    <div class="alert alert-danger">
        <?= $this->session->userdata('error_msg'); ?>
        <?php $this->session->unset_userdata('error_msg'); ?>
        <!-- Hapus setelah ditampilkan -->
    </div>
    <?php endif; ?>

    <br>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">List Panduan</h1>
        <?php if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 ){?>
        <a href="<?= base_url('panduan/tambah')?>" class="btn btn-md btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        <?php } ?>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div> -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1px">No.</th>
                            <th>Judul</th>
                            <th>Berkas</th>
                            <th>Tujuan</th>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 ){?>
                            <th>Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($panduan as $val) {
                                ?>
                        <tr>
                            <td align="center"><?= $no ; ?></td>
                            <td><?= $val->judul; ?></td>
                            <td>
                                <a href="<?= base_url('uploads/panduan/' . $val->berkas) ?>" target="_blank"
                                    class="btn btn-sm btn-primary">Klik untuk Melihat</a>
                            </td>
                            <td><?= $val->tujuan; ?></td>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 ){?>
                            <td>
                                <a href="<?=base_url('panduan/hapus/'.$val->uuid)?>" class="btn btn-sm btn-danger"
                                    data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php 
                            $no++;
                            
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>