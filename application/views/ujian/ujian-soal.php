<div class="container-fluid">
    <?php if ($this->session->flashdata('error_msg'))  : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error_msg'); ?>
    </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success_msg'))  : ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success_msg'); ?>
    </div>
    <?php endif; ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Soal ujian</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('ujian')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Ujian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Soal Ujian</li>
        </ol>
    </nav>

    <div class="card shadow mb-4 ">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Ujian</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <colgroup>
                    <col style="width: 30%;"> <!-- Kolom kiri (label) -->
                    <col style="width: 70%;"> <!-- Kolom kanan (isi) -->
                </colgroup>
                <tbody>
                    <tr>
                        <td class="table-primary font-weight-bold">Nama Ujian</td>
                        <td><?= $ujian->nama; ?></td>
                    </tr>
                    <tr>
                        <td class="table-primary font-weight-bold">Mata Pelajaran</td>
                        <td><?= $ujian->mapel_nama; ?></td>
                    </tr>
                    <tr>
                        <td class="table-primary font-weight-bold">Dibuat Oleh</td>
                        <td><?= $ujian->guru_nama; ?></td>
                    </tr>
                    <tr>
                        <td class="table-primary font-weight-bold">Tanggal Dibuat</td>
                        <td><?= date('H:i, d M Y', strtotime($ujian->modified_at)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Form untuk menambahkan soal -->
            <form method="post" action="<?= base_url('ujian/tambah_soal/'.$ujian->uuid); ?>">
                <input type="hidden" name="ujian_uuid" value="<?= $ujian->uuid ?>">

                <div class="input-group mb-3">
                    <input type="text" name="soal" id="soal" class="form-control" placeholder="Masukkan Soal"
                        value="<?= set_value('soal'); ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                            title="Simpan Soal">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>

                <div class="invalid-feedback <?= !empty(form_error('soal')) ? 'd-block' : ''; ?>">
                    <?= form_error('soal') ?>
                </div>
            </form>

            <!-- Tabel daftar soal -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50px" class="text-center">No.</th>
                            <th>Soal</th>
                            <th width="100px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($soal as $s): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $s->soal; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('ujian/hapus_soal/'.$s->uuid) ?>" class="btn btn-sm btn-danger"
                                    data-toggle="tooltip" data-placement="top" title="Hapus Data"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <button class="btn btn-sm btn-warning" data-toggle="modal"
                                    data-target="#modalEditSoal<?= $s->uuid ?>"> <i class="fas fa-edit"></i></button>

                                <!-- Modal Tambah Siswa -->
                                <div class="modal fade" id="modalEditSoal<?= $s->uuid ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="modalEditSoal<?= $s->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form action="<?= base_url('ujian/edit_soal/'.$s->uuid) ?>" method="POST">
                                            <input type="hidden" name="ujian_uuid" value="<?= $ujian->uuid ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $s->uuid ?>">Edit Soal
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="form-label font-weight-bold">Soal<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="soal" id="soal" class="form-control"
                                                            placeholder="Masukkan Soal" value="<?= $s->soal; ?>">
                                                        <div
                                                            class="invalid-feedback <?= !empty(form_error('soal')) ? 'd-block' : '' ; ?> ">
                                                            <?= form_error('soal') ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= base_url('ujian')?>" class="btn btn-md btn-danger">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>



</div>