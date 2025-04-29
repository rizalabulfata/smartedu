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
            <?php if($this->session->userdata('role') != 2){?>
            <h5 class="font-weight-bold">Pengumpulan Proyek</h5>
            <form method="post" enctype="multipart/form-data"
                action="<?= base_url('proyek/kumpulkan/'.$proyek->uuid) ?>">
                <input type="hidden" name="proyek_uuid" value="<?= $proyek->uuid ?>">
                <input type="hidden" name="kelompok_nama" value="<?= $kelompok_nama ?>">
                <input type="hidden" name="kelompok_uuid" value="<?= $kelompok_siswa ?>">
                <div class="form-group">
                    <label class="font-weight-bold">Tulis Jawaban</label>
                    <textarea name="jawaban_text" id="jawaban_text" class="form-control" rows="4"
                        placeholder="Ketik jawaban di sini..."></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Upload File</label>
                    <input type="file" name="jawaban_file" id="jawaban_file" class="form-control-file">
                    <small class="text-muted">Format : PDF, DOCX, JPG, PNG, Video (max 50 MB)</small>
                    <br>
                    <label for="keterangan_file" class="form-label mt-2">Keterangan File</label>
                    <textarea name="keterangan_file" id="keterangan_file" rows="2" class="form-control"
                        placeholder="Masukkan Keterangan untuk File yang Anda Upload"></textarea>
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Kumpulkan</button>
                <a type="button" id="delete-answer" class="btn btn-md btn-danger">
                    <i class="fa fa-times"></i> Hapus
                </a>
            </form>
            <?php } ?>
            <!-- <div class="alert alert-info text-center">
                <strong>Jawaban sudah dikumpulkan.</strong>
                <br>
                Jika ingin mengumpulkan ulang atau mengganti jawaban,
                silakan hubungi guru mata pelajaran atau pemberi proyek.

            </div> -->

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
                            <th style="width: 5%">No.</th>
                            <th style="width: 20%">Waktu Pengumpulan</th>
                            <th style="width: 15%">Nama Kelompok</th>
                            <th style="width: 5%">Nilai</th>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                            <th>Jawaban</th>
                            <th style="width: 20%">Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach ($jawaban as $j) { ?>
                        <tr>
                            <td class="text-center" width="1px"><?= $no; ?></td>
                            <?php if ($j->modified_at <= $proyek->tgl_selesai) { ?>
                            <td class="text-center">
                                <?= $j->modified_at; ?>
                                <?php } else { ?>
                            <td class="bg-danger text-white text-center">
                                <span>TERLAMBAT!</span>
                                <br>
                                <?= $j->modified_at; ?>
                                <?php } ?>
                            </td>
                            <td><?= $j->kelompok_nama;?></td>
                            <td class="text-center"><?= $j->nilai;?></td>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>

                            <td class="text-justify">
                                <div style="max-height: 100px; overflow-y: auto;">
                                    <?=$j->jawaban_text?>
                                </div>
                                <hr>
                                <a href="<?= base_url('uploads/jawaban/'.$j->jawaban_file)?>" target="_blank"
                                    class="btn btn-sm btn-primary">Klik untuk Melihat</a>
                                <br>
                                <small><i>Keterangan File : <?= $j->keterangan_file; ?></i></small>
                            </td>

                            <td>
                                <a class="btn btn-sm btn-success btn-beri-nilai" data-toggle="modal"
                                    data-target="#modalBeriNilai" data-uuid="<?= $j->uuid ?>">
                                    <i class="fas fa-edit text-white"></i> Beri Nilai
                                </a>
                                <a href="<?= base_url('proyek/hapus_jawaban_proyek/'.$j->uuid)?>"
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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">Komentar</h6>
        </div>
        <div class="card-body">
            <!-- Input Komentar -->
            <form method="post" action="<?= base_url('proyek/komentar_tambah/'.$proyek->uuid) ?>">
                <input type="hidden" name="uuid" id="uuidInput">
                <div class="mb-3">
                    <div class="d-flex align-items-start">
                        <i class="fa-solid fa-circle-user text-secondary fs-2 me-2"></i>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3"
                            placeholder="Tambahkan Komentar"></textarea>
                        <div class="invalid-feedback <?= !empty(form_error('komentar')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('komentar') ?>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" id="submit" class="btn btn-primary btn-sm" disabled>Kirim</button>
                        <button type="button" id="delete-comment" class="btn btn-danger btn-sm" disabled>Hapus</button>
                    </div>
                </div>
            </form>

            <!-- Daftar Komentar -->
            <div class="mt-4">
                <?php
                foreach ($komentar as $k) { ?>
                <div class="d-flex">
                    <i class="fa-solid fa-circle-user text-secondary fs-2 me-3 align-self-start"></i>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                                <strong><?=$k->pengomen?> </strong>
                                <span class="text-muted small"><?= date('d M Y, h.m', strtotime($k->modified_at)) ?> WIB
                                </span>
                            </p>
                        </div>
                        <p class="mb-2">
                            <?=$k->komentar?>
                        </p>
                        <hr>
                    </div>
                </div>
                <?php } ?>
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
            <form method="post" action="<?= base_url('proyek/nilai_jawaban_proyek/') ?>" id="formKelompok">
                <input type="hidden" name="uuid" id="uuidInput">
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

    function cekKomentar() {
        let komentar = $("#komentar").val().trim();
        $("#submit, #delete-comment").prop("disabled", komentar === "");
    }

    $("#komentar").on("input", cekKomentar);
    $("#delete-comment").click(function() {
        $("#komentar").val("");
        $("#submit, #delete-comment").prop("disabled", true);
    });
    cekKomentar();

    $("#delete-answer").click(function() {
        $("#jawaban_text, #jawaban_file, #keterangan_file").val("");
        $("#jawaban_text, #jawaban_file, #keterangan_file").prop('disabled', false);
    });

    // $("#jawaban_text").on('input', function() {
    //     if ($(this).val().trim().length > 0) {
    //         $("#jawaban_file, #keterangan_file").prop('disabled', true);
    //     }
    // });

    // $("#jawaban_file, #keterangan_file").on('change', function() {
    //     if ($(this).val()) {
    //         $("#jawaban_text").prop('disabled', true);
    //     }
    // });

    $('.btn-beri-nilai').on('click', function() {
        var uuid = $(this).data('uuid'); // Ambil UUID dari tombol yang ditekan
        $('#uuidInput').val(uuid); // Masukkan UUID ke dalam input form
        $('#formKelompok').attr('action', "<?= base_url('proyek/nilai_jawaban_proyek/') ?>" + uuid);
    });
});
</script>