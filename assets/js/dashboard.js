var chartIzinKeluar = null;
var chartIzinDiklat = null;
var chartCuti = null;

$(document).ready(function () {
    // cek dulu ada elementnya gak, biar gak request sia-sia
    if ($('#chart2').length) loadStatistik('get_statistik_izin_keluar', '#chart2', '#izin_keluar');
    if ($('#chart3').length) loadStatistik('get_statistik_izin_diklat', '#chart3', '#izin_diklat');
    if ($('#chart4').length) loadStatistik('get_statistik_cuti', '#chart4', '#cuti');

    // 1 function untuk semua pie
    loadPieChart('chart16', 'get_chart_izin_keluar', 'chartIzinKeluar', {
        all: '#stat_all_izin_keluar',
        proses: '#stat_proses_izin_keluar',
        selesai: '#stat_done_izin_keluar'
    });
    loadPieChart('chart17', 'get_chart_izin_diklat', 'chartIzinDiklat', {
        all: '#stat_all_izin_diklat',
        belum: '#stat_belum_proses_izin_diklat',
        on: '#stat_sedang_proses_izin_diklat',
        selesai: '#stat_done_izin_diklat'
    });
    loadPieChart('chart18', 'get_chart_cuti', 'chartCuti', {
        all: '#stat_all_cuti',
        belum: '#stat_belum_proses_cuti',
        on: '#stat_sedang_proses_cuti',
        selesai: '#stat_done_cuti'
    });
});

// 1 function reusable, gak perlu copy-paste 3x
function loadPieChart(canvasId, url, chartVarName, selectors) {
    const el = document.getElementById(canvasId);
    if (!el) return;

    $.getJSON(url, function (data) {
        const ctx = el.getContext('2d');

        // destroy yang lama
        if (window[chartVarName]) window[chartVarName].destroy();

        const g1 = ctx.createLinearGradient(0, 0, 0, 300);
        g1.addColorStop(0, '#7f00ff'); g1.addColorStop(1, '#e100ff');
        const g2 = ctx.createLinearGradient(0, 0, 0, 300);
        g2.addColorStop(0, '#fc4a1a'); g2.addColorStop(1, '#f7b733');
        const g3 = ctx.createLinearGradient(0, 0, 0, 300);
        g3.addColorStop(0, '#283c86'); g3.addColorStop(1, '#45a247');

        window[chartVarName] = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Total", "Belum Diproses", "Selesai"],
                datasets: [{
                    backgroundColor: [g1, g2, g3],
                    data: [data.total_semua || 0, data.total_proses || data.belum_proses || 0, data.total_selesai || 0]
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'bottom' } }
            }
        });

        if (selectors.all) $(selectors.all).text(data.total_semua || 0);
        if (selectors.proses) $(selectors.proses).text(data.total_proses || 0);
        if (selectors.belum) $(selectors.belum).text(data.belum_proses || 0);
        if (selectors.on) $(selectors.on).text(data.on_process || 0);
        if (selectors.selesai) $(selectors.selesai).text(data.total_selesai || 0);
    });
}

function loadStatistik(url, elementId, elementTotal) {
    if (!$(elementId).length) return;

    $.getJSON(url, function (response) {
        let total = 0;
        const dataSparkline = [];
        for (let i = 1; i <= 12; i++) {
            const bulanData = response.find(item => parseInt(item.bulan) === i);
            const jumlah = bulanData ? parseInt(bulanData.total) : 0;
            dataSparkline.push(jumlah);
            total += jumlah;
        }
        $(elementId).sparkline(dataSparkline, {
            type: 'bar', width: '80', height: '40',
            lineWidth: '2', lineColor: '#fff', fillColor: 'transparent', spotColor: '#fff'
        });
        $(elementTotal).text(total + ' Permohonan');
    });
}