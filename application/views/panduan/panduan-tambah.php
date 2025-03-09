<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Panduan</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('panduan')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar panduan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" enctype="multipart/form-data" action="<?= base_url('panduan/tambah');?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" class="form-control"
                            placeholder="Masukkan Judul Panduan" value="<?= set_value('judul'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('judul')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('judul') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Upload File Panduan <span
                                class="text-danger">*</span></label>
                        <input type="file" name="berkas" id="berkas" class="form-control"
                            placeholder="Masukkan berkas Panduan" value="<?= set_value('berkas'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('berkas')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('berkas') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Ditujukan Kepada <span
                                class="text-danger">*</span></label>
                        <select class="form-control" name="tujuan">
                            <option disabled selected>Pilih Role</option>
                            <option value="1" <?= set_select('tujuan', 1); ?>>Guru</option>
                            <option value="2" <?= set_select('tujuan', 2); ?>>Siswa</option>
                        </select>
                        <div class="invalid-feedback <?= !empty(form_error('tujuan')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('tujuan') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('panduan')?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>