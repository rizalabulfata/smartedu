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


    <br>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar ujian</h1>
        <?php if($this->session->userdata('role') == 2 ){?>
        <a href="<?= base_url('ujian/tambah')?>" class="btn btn-md btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        <?php } ?>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div> -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1px">No.</th>
                            <th>Nama Ujian</th>
                            <th>Mata Pelajaran</th>
                            <th>Jadwal</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($ujian as $val) {
                                ?>
                        <tr>
                            <td align="center"><?= $no ; ?></td>
                            <td><?= $val->nama; ?></td>
                            <td><?= $val->mapel_nama; ?></td>
                            <td><?= $val->tgl_mulai_formatted; ?> - <?= $val->tgl_selesai_formatted; ?></td>
                            <td><?= $val->guru_nama; ?></td>
                            <td>
                                <?php if($this->session->userdata('role') != 2 ){?>
                                <?php if($val->pengerjaan == 1 && $val->pengumpulan == 1) { ?>
                                <a class="btn btn-sm btn-primary btn-pengerjaan" data-uuid="<?= $val->uuid ?>"><i
                                        class="fas fa-play text-white"></i>
                                    Mulai Mengerjakan</a>
                                <?php } else if($val->pengumpulan != 1) { ?>
                                <span class="text-muted small d-block text-center">
                                    Anda sudah mengerjakan ujian ini.
                                </span>
                                <?php } else{ ?>
                                <span class="text-danger small d-block text-center">
                                    Anda bukan peserta ujian ini.
                                </span>
                                <?php } ?>
                                <?php } ?>

                                <?php if($this->session->userdata('uuid') == $val->created_by || $this->session->userdata('role') == 1 ){?>

                                <a href="<?=base_url('ujian/tambah_siswa/'.$val->uuid)?>" class="btn btn-sm btn-warning"
                                    data-toggle="tooltip" data-placement="top" title="Detail Peserta">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="<?=base_url('ujian/tambah_soal/'.$val->uuid)?>" class="btn btn-sm btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Detail Soal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="<?=base_url('ujian/hapus/'.$val->uuid)?>" class="btn btn-sm btn-danger"
                                    data-toggle="tooltip" data-placement="top" title="Hapus Ujian"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus ujian <?= $val->nama; ?>?')">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <?php } else if ($this->session->userdata('role') != 3) { ?>
                                <span class="text-danger small d-block text-center">
                                    Tidak ada akses.<br>
                                    (bukan pembuat ujian)
                                </span>

                                <?php } ?>
                            </td>
                        </tr>
                        <?php 
                            $no++;
                            
                        }
                        ?>
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<script>
$(document).ready(function() {
    const base_url = "<?= base_url(); ?>";
    $('.btn-pengerjaan').on("click", function() {
        const uuid = $(this).data('uuid');
        Swal.fire({
            title: "Konfirmasi Memulai Ujian",
            text: "Anda akan memasuki sesi ujian. Harap diperhatikan bahwa berpindah tab selama ujian berlangsung tidak diperkenankan. Jika dilakukan, ujian akan otomatis berakhir.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Mulai Ujian",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = base_url + "ujian/pengerjaan/" + uuid;
            }
        });
    });

});
</script>