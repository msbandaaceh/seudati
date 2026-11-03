<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SEUDATI</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h5 class="mb-0 text-uppercase">Beranda SEUDATI (Sistem Elektronik untuk Administrasi Izin dan Cuti)</h5>
        <hr />
        <?php if ($this->session->userdata('peran') == 'admin') { ?>
            <div class="row row-cols-1 row-sm-3 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3">
                <div class="col">
                    <div class="card radius-10 bg-gradient-ibiza">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto">
                                    <p class="mb-0 text-white">Izin Keluar</p>
                                    <h4 class="my-1 text-white" id="izin_keluar"></h4>
                                </div>
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-gradient-ohhappiness">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto">
                                    <p class="mb-0 text-white">Izin Diklat</p>
                                    <h4 class="my-1 text-white" id="izin_diklat"></h4>
                                </div>
                                <div id="chart3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-gradient-kyoto">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto">
                                    <p class="mb-0 text-dark">Cuti</p>
                                    <h4 class="my-1 text-dark" id="cuti"></h4>
                                </div>
                                <div id="chart4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-uppercase">Statistik Izin Keluar <?= date('Y') ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart16"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Seluruh
                                <span class="badge bg-gradient-quepal rounded-pill" id="stat_all_izin_keluar"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Proses
                                <span class="badge bg-gradient-ibiza rounded-pill" id="stat_proses_izin_keluar"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Selesai
                                <span class="badge bg-gradient-deepblue rounded-pill" id="stat_done_izin_keluar"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-uppercase">Statistik Izin Diklat <?= date('Y') ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart17"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Seluruh
                                <span class="badge bg-gradient-quepal rounded-pill" id="stat_all_izin_diklat"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Belum Proses
                                <span class="badge bg-gradient-ibiza rounded-pill"
                                    id="stat_belum_proses_izin_diklat"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Sedang Proses
                                <span class="badge bg-gradient-blooker rounded-pill"
                                    id="stat_sedang_proses_izin_diklat"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Selesai
                                <span class="badge bg-gradient-deepblue rounded-pill" id="stat_done_izin_diklat"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-uppercase">Statistik Cuti <?= date('Y') ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart18"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Seluruh
                                <span class="badge bg-gradient-quepal rounded-pill" id="stat_all_cuti"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Belum Proses
                                <span class="badge bg-gradient-ibiza rounded-pill" id="stat_belum_proses_cuti"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Sedang Proses
                                <span class="badge bg-gradient-blooker rounded-pill" id="stat_sedang_proses_cuti"></span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                Selesai
                                <span class="badge bg-gradient-deepblue rounded-pill" id="stat_done_cuti"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <?php if (isset($hari_kerja)) { ?>
                <div class="col">
                    <div class="card radius-10 bg-gradient-cosmic">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto">
                                    <p class="mb-0 text-white">Hari Kerja</p>
                                    <h4 class="my-1 text-white" id="labelHariKerja"></h4>
                                    <small class="text-white-50" id="labelBulan"></small>
                                </div>
                                <div>
                                    <i class="bx bx-calendar-x font-50 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Kalender Hari Libur -->
        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">
                            <i class="bx bx-calendar-heart"></i> KALENDER HARI LIBUR
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="kalenderHariLibur"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #kalenderHariLibur {
        padding: 10px;
    }

    /* Styling untuk tanggal merah (hari libur, Sabtu, Minggu) */
    #kalenderHariLibur .fc-day.fc-day-holiday,
    #kalenderHariLibur .fc-day.fc-day-sat,
    #kalenderHariLibur .fc-day.fc-day-sun {
        background-color: #ffe6e6 !important;
    }

    #kalenderHariLibur .fc-day.fc-day-holiday .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-holiday .fc-daygrid-day-number,
    #kalenderHariLibur .fc-day.fc-day-sat .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sat .fc-daygrid-day-number,
    #kalenderHariLibur .fc-day.fc-day-sun .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number {
        color: #dc3545 !important;
        font-weight: bold !important;
        font-size: 1.1em !important;
        text-shadow: 0 0 2px rgba(255, 255, 255, 0.8) !important;
    }

    /* Styling untuk event background hari libur, Sabtu, Minggu */
    #kalenderHariLibur .fc-daygrid-day.fc-day-holiday,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sat,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sun {
        background-color: #ffe6e6 !important;
    }

    /* Styling untuk semua teks di dalam hari libur, Sabtu, Minggu */
    #kalenderHariLibur .fc-day.fc-day-holiday .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-holiday .fc-daygrid-day-number,
    #kalenderHariLibur .fc-day.fc-day-holiday a,
    #kalenderHariLibur .fc-daygrid-day.fc-day-holiday a,
    #kalenderHariLibur .fc-day.fc-day-sat .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sat .fc-daygrid-day-number,
    #kalenderHariLibur .fc-day.fc-day-sat a,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sat a,
    #kalenderHariLibur .fc-day.fc-day-sun .fc-daygrid-day-number,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number,
    #kalenderHariLibur .fc-day.fc-day-sun a,
    #kalenderHariLibur .fc-daygrid-day.fc-day-sun a {
        color: #dc3545 !important;
    }

    /* Styling untuk event hari libur */
    #kalenderHariLibur .fc-event {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
</style>

<script src="assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="assets/js/dashboard.js"></script>
<script>
    $(function () {
        var el = document.getElementById('kalenderHariLibur');
        if (!el || typeof FullCalendar === 'undefined') return;

        var cal = new FullCalendar.Calendar(el, {
            initialView: 'dayGridMonth',
            firstDay: 1,
            locale: 'id',
            headerToolbar: { left: 'prev,next today', center: 'title', right: '' },
            events: function (fetchInfo, success, failure) {
                $.getJSON('get_hari_libur_kalender', {
                    start: fetchInfo.startStr,
                    end: fetchInfo.endStr
                }).done(success).fail(failure);
            },
            datesSet: function (info) {
                let tahun = info.view.currentStart.getFullYear();
                let bulan = info.view.currentStart.getMonth() + 1;
                $.post('hitung_hari_kerja_ajax', { tahun: tahun, bulan: bulan }, function (res) {
                    const data = typeof res === 'string' ? JSON.parse(res) : res;
                    $("#labelHariKerja").text(data.hari_kerja);
                    $("#labelBulan").text(data.bulan);
                }, 'json');
            }
        });
        cal.render();
    });
</script>