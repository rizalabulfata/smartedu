<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data ujian</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('ujian')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Ujian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <form class="user" method="post" action="<?= base_url('ujian/tambah');?>">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group row">
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
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Nama Ujian<span class="text-danger">*</span></label>
                        <input type="text" name="namaUjian" id="namaUjian" class="form-control"
                            placeholder="Masukkan Nama Ujian" value="<?= set_value('namaUjian'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('namaUjian')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('namaUjian') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label font-weight-bold">Tanggal Mulai <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="datetime-local" name="tgl_mulai" id="tgl_mulai" class="form-control"
                                value="<?= set_value('tgl_mulai'); ?>">
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
                        </div>
                        <div class="invalid-feedback <?= !empty(form_error('tgl_selesai')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('tgl_selesai') ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="1px">No.</th>
                                        <th>Siswa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>aa</td>
                                    <td>
                                        <select name="namaMapel" class="form-control">
                                            <option disabled selected>Pilih Mata Pelajaran</option>
                                            <?php 
                            foreach($mapel as $val){
                            ?>
                                            <option value="<?= $val->uuid; ?>"
                                                <?= set_select('namaMapel', $val->uuid) ;?>>
                                                <?= $val->nama; ?>
                                            </option>
                                            <?php 
                            }
                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tbody>
                                <tfoot>
                                    <td colspan="3">
                                        <button class="btn btn-sm btn-success">
                                            <i class="fa fa-plus"></i> Simpan Siswa
                                        </button>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col">
                        <button type="submit" name="action" value="simpan" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="submit" name="action" value="simpan_detail" class="btn btn-md btn-primary mr-2">
                            <i class="fa fa-plus"></i> Simpan dan Tambah Soal
                        </button>
                        <a href="<?= base_url('ujian')?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
</div>

<script>
$(document).ready(function() {});
</script>