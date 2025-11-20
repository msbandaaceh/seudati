<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SEUDATI</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;" data-page="dashboard"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Kalender Cuti</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">KALENDER CUTI DAN IZIN KELUAR PEGAWAI</h6>
        <hr />

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Legenda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="badge" style="background-color: #28a745; padding: 8px 15px;">Cuti
                                    Tahunan</span>
                                <span class="badge" style="background-color: #dc3545; padding: 8px 15px;">Cuti
                                    Sakit</span>
                                <span class="badge" style="background-color: #ffc107; padding: 8px 15px;">Cuti
                                    Melahirkan</span>
                                <span class="badge" style="background-color: #17a2b8; padding: 8px 15px;">Cuti
                                    Besar</span>
                                <span class="badge" style="background-color: #6f42c1; padding: 8px 15px;">Cuti Alasan
                                    Penting</span>
                                <span class="badge" style="background-color: #6c757d; padding: 8px 15px;">Cuti di Luar
                                    Tanggungan Negara</span>
                                <span class="badge" style="background-color: #fd7e14; padding: 8px 15px;">Izin Keluar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="kalenderCuti"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fc-day-today {
        background-color: #fff3cd !important;
        border: 2px solid #ffc107 !important;
    }
    .fc-day-today .fc-daygrid-day-number {
        background-color: #ffc107;
        color: #000;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 3px;
        position: relative;
    }
    .fc-day-today .fc-daygrid-day-number::after {
        content: " (Hari Ini)";
        font-size: 0.75em;
        font-weight: normal;
    }
</style>

<script>
    $(document).ready(function () {
        var calendarEl = document.getElementById('kalenderCuti');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            firstDay: 1,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                console.log(fetchInfo);
                $.ajax({
                    url: 'get_cuti_kalender',
                    method: 'GET',
                    data: {
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr
                    },
                    success: function (response) {
                        var events = JSON.parse(response);
                        successCallback(events);
                    },
                    error: function () {
                        failureCallback();
                    }
                });
            },
            eventClick: function (info) {
                var event = info.event;
                var extendedProps = event.extendedProps;
                var title = extendedProps.tipe === 'izin_keluar' ? 'Detail Izin Keluar' : 'Detail Cuti';
                var htmlContent = '';

                if (extendedProps.tipe === 'izin_keluar') {
                    // Format untuk Izin Keluar
                    var tanggal = event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    var jamMulai = event.start.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                    var jamAkhir = event.end.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                    
                    htmlContent = `
                        <div class="text-start">
                            <p><strong>Nama:</strong> ${extendedProps.nama}</p>
                            <p><strong>Jenis:</strong> ${extendedProps.jenis}</p>
                            <p><strong>Tanggal:</strong> ${tanggal}</p>
                            <p><strong>Jam Mulai:</strong> ${jamMulai}</p>
                            <p><strong>Jam Akhir:</strong> ${jamAkhir}</p>
                            <p><strong>Alasan:</strong> ${extendedProps.alasan || '-'}</p>
                        </div>
                    `;
                } else {
                    // Format untuk Cuti
                    htmlContent = `
                        <div class="text-start">
                            <p><strong>Nama:</strong> ${extendedProps.nama}</p>
                            <p><strong>Jenis Cuti:</strong> ${extendedProps.jenis}</p>
                            <p><strong>Nomor Cuti:</strong> ${extendedProps.nomor_cuti || '-'}</p>
                            <p><strong>Tanggal Mulai:</strong> ${event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Tanggal Selesai:</strong> ${new Date(event.end.getTime() - 86400000).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Alasan:</strong> ${extendedProps.alasan || '-'}</p>
                        </div>
                    `;
                }

                Swal.fire({
                    title: title,
                    html: htmlContent,
                    icon: 'info',
                    confirmButtonText: 'Tutup',
                    width: '600px'
                });
            },
            eventDisplay: 'block',
            dayMaxEvents: 3,
            moreLinkClick: 'popover'
        });

        calendar.render();
    });
</script>