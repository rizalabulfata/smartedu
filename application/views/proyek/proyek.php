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
        <h1 class="h3 mb-2 text-gray-800">Daftar Proyek</h1>
        <?php if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 ){?>
        <a href="<?=base_url('proyek/tambah')?>" class="btn btn-md btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah
            Data</a>
        <?php } ?>
    </div>

    <!-- Card Simulasi -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <?php if(!empty($proyek)) : ?>
                <?php foreach($proyek as $val) : ?>
                <?php if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 || $val->pengerjaan == 1 ){?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-1">
                        <div class="card-header">
                            <span>Mata Pelajaran :</span>
                            <span class="text-primary font-weight-bold"><?= $val->mapel ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold"><?= $val->judul ?></h5>
                            <p class="card-text text-muted"><?= substr(strip_tags($val->deskripsi), 0, 30) ?>...</p>
                            <p class="card-text small mb-2">
                                <i class="fas fa-calendar-alt"></i> Mulai :
                                <?= date('d M Y, h.m', strtotime($val->tgl_mulai)) ?> WIB
                            </p>
                            <?php 
                            $waktu_sekarang = date('Y-m-d H:i');
                            $warna = (strtotime($val->tgl_selesai) < strtotime($waktu_sekarang)) ? 'text-danger' : 'text-dark';
                            ?>
                            <p class="card-text small mb-2 <?= $warna ?>">
                                <i class="fas fa-calendar-alt"></i> Selesai :
                                <?= date('d M Y, h.m', strtotime($val->tgl_selesai)) ?> WIB
                            </p>

                            <div class="text-muted small mb-2">
                                <i class="fa fa-user me-1"></i> Dibuat oleh : <?= $val->guru ?>
                            </div>

                            <!-- Gunakan mt-auto agar tombol selalu di bawah -->
                            <div class="mt-auto">
                                <a href="<?= base_url('proyek/detail/'. $val->uuid) ?>"
                                    class="btn btn-primary">Detail</a>

                                <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $val->created_by ){?>
                                <a href="<?= base_url('proyek/hapus/'. $val->uuid) ?>" class="btn btn-danger">Hapus</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-center">Belum ada data proyek</p> <!-- Jika array kosong, tampilkan pesan -->
                <?php endif; ?>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>