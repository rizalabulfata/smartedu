<div class="container-fluid">
    <?php if ($this->session->flashdata('error_msg')) : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error_msg'); ?>
    </div>
    <?php endif; ?>


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Proyek</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('proyek')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Proyek</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" enctype="multipart/form-data" action="<?= base_url('proyek/tambah');?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" class="form-control"
                            placeholder="Masukkan Judul proyek" value="<?= set_value('judul'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('judul')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('judul') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Mata Pelajaran<span
                                class="text-danger">*</span></label>
                        <select name="namaMapel" class="form-control">
                            <option disabled selected>Pilih Mata Pelajaran</option>
                            <?php 
                            foreach($mapel as $val){
                            ?>
                            <option value="<?= $val->uuid; ?>" <?= set_select('namaMapel', $val->uuid) ;?>>
                                <?= $val->nama; ?>
                            </option>
                            <?php 
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback <?= !empty(form_error('namaMapel')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('namaMapel') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label class="form-label font-weight-bold">Upload File Proyek<span
                                class="text-danger">*</span></label>
                        <input type="file" name="berkas" id="berkas" class="form-control"
                            placeholder="Masukkan materi Materi" value="<?= set_value('berkas'); ?>">
                        <small>File dapat berupa dokumen, foto, atau video. Maksimal 50 Mb</small>
                        <div class="invalid-feedback <?= !empty(form_error('berkas')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('berkas') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"
                                value="<?= set_value('deskripsi'); ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label font-weight-bold">Tanggal Mulai <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="datetime-local" name="tgl_mulai" id="tgl_mulai" class="form-control"
                                value="<?= set_value('tgl_mulai'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="invalid-feedback <?= !empty(form_error('tgl_mulai')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('tgl_mulai') ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label font-weight-bold">Tanggal Selesai <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="datetime-local" name="tgl_selesai" id="tgl_selesai" class="form-control"
                                value="<?= set_value('tgl_selesai'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="invalid-feedback <?= !empty(form_error('tgl_selesai')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('tgl_selesai') ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Kelompok <span class="text-danger">*</span></label>
                        <select class="form-control" name="kelompok" id="kelompok">
                            <option disabled selected>Pilih Kelompok</option>
                            <option value="1" <?= set_select('kelompok', 1); ?>>Kelompok 1</option>
                            <option value="2" <?= set_select('kelompok', 2); ?>>Kelompok 2</option>
                        </select>
                        <div class="invalid-feedback <?= !empty(form_error('kelompok')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('kelompok') ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label font-weight-bold">Daftar Siswa</label>
                        <ul id="daftar-siswa" class="list-group">
                            <li class="list-group-item">Pilih kelompok untuk melihat daftar siswa</li>
                        </ul>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col">
                        <button type="submit" name="action" value="simpan" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="submit" name="action" value="simpan_detail" class="btn btn-md btn-primary mr-2">
                            <i class="fa fa-save"></i> Simpan dan Detail
                        </button>
                        <a href="<?= base_url('proyek')?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#deskripsi'))
    .catch(error => {
        console.error(error);
    });
</script>