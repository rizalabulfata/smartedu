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

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('ujian/tambah_siswa/'.$ujian->uuid)?>">
                    <i class="fas fa-arrow-left">
                    </i> Tambah Siswa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Peserta Ujian</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Kolom Kiri: Detail Ujian & Siswa -->
        <div class="col-md-8">
            <div class="card shadow mb-4 ">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Ujian</h5>
                </div>
                <div class="card-body">
                    <p>Nama Ujian : <strong> <?= $ujian->nama; ?> </strong> </p>
                    <p>Mata Pelajaran : <strong> <?= $mapel; ?> </strong> </p>
                    <p>Nama Siswa : <strong> <?= $siswa->nama; ?> </strong> </p>
                    <p>Guru Pengajar : <strong> <?= $guru; ?> </strong> </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Nilai -->
        <div class="col-md-4">
            <div class="card shadow mb-4 ">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Nilai Ujian</h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-primary">
                        <?= isset($nilai) ? $nilai : '-'; ?>
                    </h1>
                    <p class="text-muted">Skor yang diperoleh</p>
                    <small>maksimal 10</small>
                </div>
            </div>
        </div>
    </div>


    <!-- Bagian Soal & Jawaban -->
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Soal & Jawaban</h5>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('ujian/tambah_nilai/'.$ujian->uuid .'/'.$siswa->uuid); ?>">
                <?php $no = 1; foreach ($soal as $d): ?>
                <div class="row ">
                    <div class="col-10">
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong>Soal <?= $no++; ?> :</strong> <?= $d->soal; ?>
                            </div>
                            <div class="card-body">
                                <p class="mb-0"><strong>Jawaban :</strong>
                                    <?php if (isset($jawaban[$d->uuid][0]->jawaban_siswa)): ?>
                                    </i> <?= $jawaban[$d->uuid][0]->jawaban_siswa; ?>
                                </p>

                                <?php else: ?>
                                <p class="text-danger">Tidak dijawab
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card mb-3">
                            <?php if (isset($jawaban[$d->uuid][0]->jawaban_siswa)): ?>
                            <div class="card-header bg-success text-white text-center" for="nilai_<?= $d->uuid; ?>">
                                <div>
                                    Nilai <span class="text-white">*</span>
                                </div>
                                <small>Isi dengan 0 - 10</small>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="input-group">
                                    <input type="number" name="nilai[<?= $d->uuid; ?>]" class="form-control" min="0"
                                        max="10" value="<?= $jawaban[$d->uuid][0]->nilai;?>" required>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="card bg-danger text-white">
                                <div class="text-center">
                                    Tidak Dijawab
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    <a href="<?= base_url('ujian/tambah_siswa/'.$ujian->uuid)?>" class="btn btn-md btn-danger">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- </div> -->




</div>
<!-- /.container-fluid -->

</div>