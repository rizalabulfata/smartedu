<style>
.pagination li {
    display: inline-block;
    margin: 0 2px;
}

.pagination li a {
    padding: 5px 10px;
    border: 1px solid #ddd;
    color: #007bff;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li.active a {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination li.disabled a {
    color: #ccc;
    pointer-events: none;
}
</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Mata Pelajaran</h1>
    </div>

    <!-- Card Simulasi -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <div id="mapelList">
                <input class="search form-control mb-3" placeholder="Cari mata pelajaran..." />
                <div class="row list">
                    <?php if (!empty($mapel)) : ?>
                    <?php foreach ($mapel as $val) : ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-left-primary shadow-sm">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-3">
                                        <i class="fas fa-book fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title name"><?= $val->nama ?></h6>
                                    </div>
                                </div>
                                <a href="<?= base_url('materi/detail/' . $val->uuid) ?>"
                                    class="btn btn-sm btn-outline-primary mt-auto">
                                    Lihat Materi
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada data mata pelajaran</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination justify-content-center mt-3"></ul>
                </div>
            </div>
        </div>
    </div>




</div>
<!-- /.container-fluid -->

</div>

<script>
var options = {
    valueNames: ['name'], // target class untuk search
    page: 6, // jumlah item per halaman
    pagination: true
};

var mapelList = new List('mapelList', options);
</script>