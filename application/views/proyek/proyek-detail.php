<div class="container-fluid">
    <?php if ($this->session->flashdata('success_msg'))  : ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success_msg'); ?>
    </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg'))  : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error_msg'); ?>
    </div>
    <?php endif; ?>


    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('proyek')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Proyek</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Proyek</li>
        </ol>
    </nav>

    <h1 class="h3 mb-2 text-gray-800">Detail Proyek</h1>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa fa-user"></i> Dibuat oleh : <?= $guru->nama ?></span>
            <a href="<?= base_url('proyek/pilih_siswa/'.$proyek->uuid)?>" class="btn btn-primary btn-sm"><i
                    class="fa fa-users"></i> Data Siswa Proyek</a>
        </div>

        <div class="card-body">
            <h4 class="card-title font-weight-bold"><?= $proyek->judul ?></h4>

            <p class="card-text">
                <i class="fas fa-calendar-alt"></i> Timeline :
                <?= date('d M Y, h.m', strtotime($proyek->tgl_mulai)) ?> -
                <?= date('d M Y, h.m', strtotime($proyek->tgl_selesai)) ?>
            </p>
            <hr>
            <p class="card-text text-muted"><?= $proyek->deskripsi ?></p>
            <div class="d-flex align-items-center">
                <div>
                    <a href="<?= base_url('uploads/proyek/'.$proyek->file) ?>" target="_blank"
                        class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> Lihat File
                    </a>
                </div>
            </div>
            <hr>
            <?php if( $pengumpulan != 1 ){?>
            <h5 class="font-weight-bold">Pengumpulan Proyek</h5>
            <form method="post" enctype="multipart/form-data"
                action="<?= base_url('proyek/kumpulkan/'.$proyek->uuid) ?>">
                <input type="hidden" name="proyek_uuid" value="<?= $proyek->uuid ?>">
                <input type="hidden" name="kelompok_nama" value="<?= $kelompok_nama ?>">
                <input type="hidden" name="kelompok_uuid" value="<?= $kelompok_siswa ?>">
                <div class="form-group">
                    <label class="font-weight-bold">Tulis Jawaban</label>
                    <textarea name="jawaban_text" class="form-control" rows="4"
                        placeholder="Ketik jawaban di sini..."></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Atau Upload File</label>
                    <input type="file" name="jawaban_file" class="form-control-file">
                    <small class="text-muted">Format : PDF, DOCX, JPG, PNG, Video (max 50 MB)</small>
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Kumpulkan</button>
                <a href="<?= base_url('proyek')?>" class="btn btn-md btn-danger">
                    <i class="fa fa-times"></i> Batal
                </a>
            </form>
            <?php } else { ?>
            <div class="alert alert-info text-center">
                <strong>Jawaban sudah dikumpulkan.</strong>
                <br>
                Jika ingin mengumpulkan ulang atau mengganti jawaban,
                silakan hubungi guru mata pelajaran atau pemberi proyek.

            </div>

            <?php } ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">Jawaban Kelompok</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="1px">No.</th>
                            <th width="30px">Waktu Pengumpulan</th>
                            <th width="50px">Nama Kelompok</th>
                            <th width="1px">Nilai</th>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                            <th>Jawaban</th>
                            <th width="160px">Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach ($jawaban as $j) { ?>
                        <tr>
                            <td align="center"><?= $no; ?></td>
                            <?php if ($j->modified_at <= $proyek->tgl_selesai) { ?>
                            <td>
                                <?= $j->modified_at; ?>
                                <?php } else { ?>
                            <td class="bg-danger text-white">
                                <span>TERLAMBAT!</span>
                                <br>
                                <?= $j->modified_at; ?>
                                <?php } ?>
                            </td>
                            <td><?= $j->kelompok_nama;?></td>
                            <td class="text-center"><?= $j->nilai;?></td>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                            <?php if (!empty($j->jawaban_text)){?>
                            <td><?=$j->jawaban_text?></td>
                            <?php } else{ ?>
                            <td class="text-center"> <a href="<?= base_url('uploads/jawaban/'.$j->jawaban_file)?>"
                                    target="_blank" class="btn btn-sm btn-primary">Klik untuk Melihat</a>
                            </td>
                            <?php  }
                            ?>

                            <td>
                                <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalBeriNilai"><i
                                        class="fas fa-edit text-white"></i>
                                    Beri Nilai</a>
                                <a href="<?= base_url('proyek/hapus_jawaban_proyek/'.$jawaban[0]->uuid)?>"
                                    class="btn btn-sm btn-danger"><i class="fas fa-trash text-white"></i>
                                    Hapus</a>
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

<!-- Modal Tambah Kelompok -->
<div class="modal fade" id="modalBeriNilai" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Penilaian Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url('proyek/nilai_jawaban_proyek/'.$jawaban[0]->uuid) ?>"
                id="formKelompok">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nilai_kelompok">Nilai Kelompok</label>
                        <input type="number" name="nilai_kelompok" id="nilai_kelompok"
                            class="form-control <?= form_error('nilai_kelompok') ? 'invalid' : '' ?>"
                            placeholder="Masukkan Nilai Kelompok">
                        <div class="invalid-feedback" id="error-nilai_kelompok">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('textarea[name="jawaban_text"]').on('input', function() {
        if ($(this).val().trim().length > 0) {
            $('input[name="jawaban_file"]').prop('disabled', true);
        } else {
            $('input[name="jawaban_file"]').prop('disabled', false);
        }
    });

    $('input[name="jawaban_file"]').on('change', function() {
        if ($(this).val()) {
            $('textarea[name="jawaban_text"]').prop('disabled', true);
        } else {
            $('textarea[name="jawaban_text"]').prop('disabled', false);
        }
    });
});
</script>