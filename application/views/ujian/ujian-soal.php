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
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>