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

    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('proyek/detail/'.$proyek->uuid)?>">
                    <i class="fas fa-arrow-left">
                    </i> Detail Proyek</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Daftar Kelompok & Siswa</h1>
    </div> -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelompok & Siswa</h6>
            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahKelompok">
                <i class="fa fa-plus"></i> Tambah Kelompok
            </button>
            <?php } ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1px">No.</th>
                            <th>Kelompok</th>
                            <th>Siswa</th>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                            <th class="w-25">Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($kelompok as $kel) {
                            ?>
                        <tr>
                            <td align="center"><?= $no++?></td>
                            <td><?= $kel['kelompok']; ?> </td>
                            <td>
                                <ul class="list-group">
                                    <?php 
                                    if (!empty($kel['siswa'])) { 
                                        foreach ($kel['siswa'] as $index => $s) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $s['nama']; ?>

                                        <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                                        <a href="<?= base_url('kelompok/hapus_siswa_kelompok_by_relasi/'.$s['relasi'].'?proyek_uuid='.$proyek->uuid) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus siswa <?= $s['nama']; ?>?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php } ?>
                                    </li>
                                    <?php }
                                    } else { ?>
                                    <li class="list-group-item text-muted">Belum ada siswa</li>
                                    <?php } ?>
                                </ul>
                            </td>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $proyek->created_by ){?>
                            <td>
                                <button class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modalTambahSiswa"
                                    onclick="setKelompokUuid('<?= $kel['kelompok_uuid'] ?>')">
                                    <i class="fa fa-plus"></i> Tambah Siswa
                                </button>
                                <a href="<?= base_url('kelompok/hapus/'.$kel['kelompok_uuid'].'?proyek_uuid='.$proyek->uuid) ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus kelompok <?= $kel['kelompok']; ?>?')">
                                    <i class="fa fa-trash"></i> Hapus kelompok
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <tr>
                    <a href="<?= base_url('proyek/detail/'.$proyek->uuid)?>" class="btn btn-md btn-danger">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </tr>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelompok -->
<div class="modal fade" id="modalTambahKelompok" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kelompok/tambah/') ?>" id="formKelompok">
                <input type="hidden" name="proyek_uuid" value="<?= $proyek->uuid ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelompok">Nama Kelompok</label>
                        <input type="text" name="kelompok" id="kelompok"
                            class="form-control <?= form_error('kelompok') ? 'invalid' : '' ?>"
                            placeholder="Masukkan Nama Kelompok">
                        <div class="invalid-feedback" id="error-kelompok">
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

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa ke Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kelompok/tambah_siswa_by_kelompok/') ?>" method="POST">
                <input type="hidden" name="proyek_uuid" value="<?= $proyek->uuid ?>">
                <input type="hidden" id="kelompok_uuid" name="kelompok_uuid">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaSiswa">Pilih Siswa</label>
                        <select name="siswa_uuid" class="form-control select2" required>
                            <option></option>
                            <?php foreach ($siswa as $s) { ?>
                            <option value="<?= $s->uuid ?>"><?= $s->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah Siswa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log("jQuery Loaded:", typeof $ !== "undefined");
    console.log("Select2 Loaded:", typeof $.fn.select2 !== "undefined");

    $('.select2').select2({
        dropdownParent: $('#modalTambahSiswa'),
        width: '100%',
        placeholder: "Pilih Siswa",
        allowClear: true
    });
    $('#dataTable').DataTable();

    window.setKelompokUuid = function(uuid) {
        $('#kelompok_uuid').val(uuid);
        console.log(uuid);
    }

    var user_uuid = "<?= $this->session->userdata('user_uuid') ?>";

    $(".action-btn").each(function() {
        var created_by = $(this).data("created_by");
        if (created_by !== user_uuid) {
            $(this).hide();
        }
    });

    $('#formKelompok').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#kelompok').addClass('is-invalid');
                    $('#error-kelompok').html(response.error.kelompok);
                } else {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kelompok berhasil ditambahkan!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location
                                .reload(); // Reload hanya setelah pengguna klik OK
                        }
                    });
                }
            }
        });
    });
});
</script>