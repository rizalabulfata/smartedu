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
    <h1 class="h3 mb-2 text-gray-800">Tambah Peserta ujian</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('ujian')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Ujian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Peserta Ujian</li>
        </ol>
    </nav>
    <!-- Kolom Kiri: Detail Ujian & Siswa -->
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

    <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $ujian->created_by ){?>
    <form method="post" action="<?= base_url('ujian/tambah_siswa/'.$ujian->uuid); ?>">
        <input type="hidden" name="ujian_uuid" value="<?= $ujian->uuid ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success">Tambah Peserta Ujian</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-8">
                        <label class="font-weight-bold">Masukkan Nama Siswa <span class="text-danger">*</span></label>
                        <select name="siswa" class="form-control">
                            <option disabled selected>Pilih Siswa</option>
                            <?php foreach($siswa as $val): ?>
                            <option value="<?= $val->uuid; ?>" <?= set_select('siswa', $val->uuid); ?>>
                                <?= $val->nama; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback <?= !empty(form_error('siswa')) ? 'd-block' : ''; ?>">
                            <?= form_error('siswa') ?>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php } ?>


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">Data Peserta Ujian</h6>
        </div>
        <div class="card-body">
            <!-- Tabel daftar siswa -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50px" class="text-center">No.</th>
                            <th>Siswa</th>
                            <th width="200px" class="text-center">Waktu Pengumpulan</th>
                            <th width="50px" class="text-center">Nilai</th>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $ujian->created_by ){?>
                            <th width="200px" class="text-center">Aksi</th>

                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($peserta as $val) {
                                ?>
                        <tr>
                            <td align="center"><?= $no ; ?></td>
                            <td><?= $val->nama; ?></td>

                            <?php if ($val->pengumpulan != NULL){ ?>
                            <?php if ($val->pengumpulan <= $ujian->tgl_selesai) { ?>
                            <td><?= $val->pengumpulan; ?></td>
                            <?php } else { ?>
                            <td class="bg-danger text-white">
                                <span>TERLAMBAT!</span>
                                <br>
                                <?= $val->pengumpulan; ?>
                            </td>
                            <?php } ?>
                            <?php } else { ?>
                            <td class="text-muted small text-center">
                                <span>Siswa belum mengumpulkan</span>
                            </td>
                            <?php } ?>

                            <td class="text-center"><?= $val->ujian_nilai; ?></td>

                            <?php if($this->session->userdata('role') == 1 || $this->session->userdata('uuid') == $ujian->created_by ){?>
                            <td>
                                <a href="<?= base_url('ujian/hapus_siswa/'.$val->uuid)?>"
                                    class="btn btn-sm btn-danger"><i class="fas fa-trash text-white"></i>
                                    Hapus</a>
                                <?php if($val->ujian_nilai == NULL ){?>
                                <a href="<?= base_url('ujian/tambah_nilai/'.$ujian->uuid.'/'.$val->siswa_uuid)?>"
                                    class="btn btn-sm btn-primary"><i class="fas fa-edit text-white"></i>
                                    Beri Nilai</a>
                                <?php } else {?>
                                <a href="<?= base_url('ujian/tambah_nilai/'.$ujian->uuid.'/'.$val->siswa_uuid)?>"
                                    class="btn btn-sm btn-warning"><i class="fas fa-edit text-white"></i>
                                    Edit Nilai</a>
                                <?php }?>
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
            <a href="<?= base_url('ujian')?>" class="btn btn-md btn-danger">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>