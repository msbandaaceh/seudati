$(document).ready(function () {
    loadStatistik('get_statistik_izin_keluar', '#chart2', '#izin_keluar');
    loadStatistik('get_statistik_izin_diklat', '#chart3', '#izin_diklat');
    loadStatistik('get_statistik_cuti', '#chart4', '#cuti');

    loadStatistikPieIzinKeluar();
    loadStatistikPieIzinDiklat();
    loadStatistikPieCuti();
});

function loadStatistikPieIzinKeluar() {
    $.ajax({
        url: 'get_chart_izin_keluar', // endpoint controller
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ctx = document.getElementById("chart16").getContext('2d');

            var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke5.addColorStop(0, '#7f00ff');
            gradientStroke5.addColorStop(1, '#e100ff');

            var gradientStroke6 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke6.addColorStop(0, '#fc4a1a');
            gradientStroke6.addColorStop(1, '#f7b733');

            var gradientStroke7 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke7.addColorStop(0, '#283c86');
            gradientStroke7.addColorStop(1, '#45a247');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Total Permohonan", "Belum Diproses", "Selesai"],
                    datasets: [{
                        backgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7],
                        hoverBackgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7],
                        data: [
                            data.total_semua,
                            data.total_proses,
                            data.total_selesai
                        ]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: true },
                    tooltips: { displayColors: false }
                }
            });

            $('#stat_all_izin_keluar').html("");
            $('#stat_proses_izin_keluar').html("");
            $('#stat_done_izin_keluar').html("");
            $('#stat_all_izin_keluar').append(data.total_semua);
            $('#stat_proses_izin_keluar').append(data.total_proses);
            $('#stat_done_izin_keluar').append(data.total_selesai);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
};

function loadStatistikPieIzinDiklat() {
    $.ajax({
        url: 'get_chart_izin_diklat', // endpoint controller
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ctx = document.getElementById("chart17").getContext('2d');

            var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke5.addColorStop(0, '#7f00ff');
            gradientStroke5.addColorStop(1, '#e100ff');

            var gradientStroke6 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke6.addColorStop(0, '#fc4a1a');
            gradientStroke6.addColorStop(1, '#f7b733');

            var gradientStroke7 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke7.addColorStop(0, '#283c86');
            gradientStroke7.addColorStop(1, '#45a247');

            var gradientStroke8 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke8.addColorStop(0, '#42e695');
            gradientStroke8.addColorStop(1, '#3bb2b8');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Total Permohonan", "Belum Diproses", "Sedang Diproses", "Selesai"],
                    datasets: [{
                        backgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7, gradientStroke8],
                        hoverBackgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7, gradientStroke8],
                        data: [
                            data.total_semua,
                            data.belum_proses,
                            data.on_process,
                            data.total_selesai
                        ]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: true },
                    tooltips: { displayColors: false }
                }
            });

            $('#stat_all_izin_diklat').html("");
            $('#stat_belum_proses_izin_diklat').html("");
            $('#stat_sedang_proses_izin_diklat').html("");
            $('#stat_done_izin_diklat').html("");
            $('#stat_all_izin_diklat').append(data.total_semua);
            $('#stat_belum_proses_izin_diklat').append(data.belum_proses);
            $('#stat_sedang_proses_izin_diklat').append(data.on_process);
            $('#stat_done_izin_diklat').append(data.total_selesai);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
};

function loadStatistikPieCuti() {
    $.ajax({
        url: 'get_chart_cuti', // endpoint controller
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ctx = document.getElementById("chart18").getContext('2d');

            var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke5.addColorStop(0, '#7f00ff');
            gradientStroke5.addColorStop(1, '#e100ff');

            var gradientStroke6 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke6.addColorStop(0, '#fc4a1a');
            gradientStroke6.addColorStop(1, '#f7b733');

            var gradientStroke7 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke7.addColorStop(0, '#283c86');
            gradientStroke7.addColorStop(1, '#45a247');

            var gradientStroke8 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke8.addColorStop(0, '#42e695');
            gradientStroke8.addColorStop(1, '#3bb2b8');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Total Permohonan", "Belum Diproses", "Sedang Diproses", "Selesai"],
                    datasets: [{
                        backgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7, gradientStroke8],
                        hoverBackgroundColor: [gradientStroke5, gradientStroke6, gradientStroke7, gradientStroke8],
                        data: [
                            data.total_semua,
                            data.belum_proses,
                            data.on_process,
                            data.total_selesai
                        ]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: true },
                    tooltips: { displayColors: false }
                }
            });

            $('#stat_all_cuti').html("");
            $('#stat_belum_proses_cuti').html("");
            $('#stat_sedang_proses_cuti').html("");
            $('#stat_done_cuti').html("");
            $('#stat_all_cuti').append(data.total_semua);
            $('#stat_belum_proses_cuti').append(data.belum_proses);
            $('#stat_sedang_proses_cuti').append(data.on_process);
            $('#stat_done_cuti').append(data.total_selesai);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
};

function loadStatistik(url, elementId, elementTotal) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            let total = 0;
            let dataSparkline = [];

            for (let i = 1; i <= 12; i++) {
                let bulanData = response.find(item => parseInt(item.bulan) === i);
                let jumlah = bulanData ? parseInt(bulanData.total) : 0;

                dataSparkline.push(jumlah);
                total += jumlah;
            }

            $(elementId).sparkline(dataSparkline, {
                type: 'bar',
                width: '80',
                height: '40',
                lineWidth: '2',
                lineColor: '#fff',
                fillColor: 'transparent',
                spotColor: '#fff',
            });
            $(elementTotal).html('');
            $(elementTotal).append(total + ' Permohonan');
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}