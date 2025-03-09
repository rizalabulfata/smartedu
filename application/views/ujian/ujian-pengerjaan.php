<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengerjaan Ujian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .timer-box {
        font-size: 20px;
        font-weight: bold;
        color: red;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-primary">Pengerjaan Ujian</h4>
            <div class="timer-box">Sisa Waktu: <span id="timer">--:--</span></div>
        </div>
        <hr>
        <form id="ujianForm" method="post" action="<?= base_url('ujian/pengerjaan/'.$ujian->uuid); ?>">
            <input type="hidden" name="ujian_uuid" value="<?= $ujian->uuid; ?>">
            <?php $no = 1; foreach ($soal as $s) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong><?= $no++; ?>. <?= $s->soal; ?></strong></p>
                    <input type="text" name="jawaban[<?= $s->uuid; ?>]" class="form-control"
                        placeholder="Masukkan jawaban Anda...">
                </div>
            </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-success">Kirim Jawaban</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<script>
var waktuUjian = 30 * 60;
var warningCount = 0;
console.log('warningCount ');
console.log(warningCount);

function startTimer() {
    var timerInterval = setInterval(function() {
        var menit = Math.floor(waktuUjian / 60);
        var detik = waktuUjian % 60;
        document.getElementById('timer').textContent = menit + ":" + (detik < 10 ? '0' : '') + detik;

        if (waktuUjian <= 0) {
            clearInterval(timerInterval);
            // alert("Waktu habis! Jawaban akan dikirim otomatis.");
            // document.getElementById('ujianForm').submit();
            Swal.fire({
                title: "Waktu Habis!",
                text: "Jawaban akan dikirim otomatis.",
                icon: "info",
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.getElementById('ujianForm').submit();
            });
        }

        waktuUjian--;
    }, 1000);
}

$(document).ready(function() {
    startTimer();
    console.log('aa');
});

$(window).on('blur', function() {
    console.log("Tab berpindah! Warning ke-" + warningCount);
    warningCount++;
    if (warningCount > 2) {
        Swal.fire({
            icon: "error",
            title: "Pelanggaran",
            allowOutsideClick: false,
            text: "Anda telah meninggalkan halaman lebih dari 2 kali! Ujian akan dikirim otomatis.",
        }).then(() => {
            document.getElementById('ujianForm').submit();
        });
    } else {
        Swal.fire({
            title: "Perhatian",
            text: "Jangan beralih tab! Jika dilakukan 2 kali, ujian akan dikirim otomatis.",
            icon: "warning"
        });
    }
});
// var warningCount = 0;
// $(window).on('blur', function() {
//     warningCount++;
//     if (warningCount > 2) {
//         alert("Anda telah meninggalkan halaman lebih dari 2 kali! Ujian akan dikirim otomatis.");
//         document.getElementById('ujianForm').submit();
//     } else {
//         alert("Jangan beralih tab! Jika dilakukan 2 kali, ujian akan dikirim otomatis.");
//     }
// });
</script>