function BukaModalKeluar(id) {
    $.post('show_izin_keluar', { id: id }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            var tglIzinPicker; // simpan global

            tglIzinPicker = flatpickr("#tgl_izin", {
                dateFormat: "Y-m-d", // format yg dikirim ke server
                altInput: true,
                altFormat: "d F Y", // format tampilan
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    },
                    months: {
                        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    },
                }
            });

            // Kosongkan & isi ulang form
            $("#judul").html('');
            $("#id_keluar_").val('');
            tglIzinPicker.clear(); // pastikan instance global
            $("#jam_mulai").val('');
            $("#jam_selesai").val('');
            $("#alasan").val('');

            // Set tanggal (harus format Y-m-d dari server)
            if (json.tgl) {
                tglIzinPicker.setDate(json.tgl, true, "Y-m-d");
            }
            $("#judul").html(json.judul);
            $("#id_keluar_").val(json.id);
            $("#jam_mulai").val(json.mulai);
            $("#jam_selesai").val(json.akhir);
            $("#alasan").val(json.alasan);
        } else {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function BukaModalDetailKeluar(id) {
    $.post('show_izin_keluar_detil', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#v_judul").html("");
            //$("#id").val('');
            $("#v_tgl_izin").html('');
            $("#v_jam_mulai").html('');
            $("#v_jam_selesai").html('');
            $("#v_alasan").html('');
            $("#v_status").html('');
            $("#v_ket").html('');

            $("#v_judul").append(json.judul);
            //$("#id").val(json.id);
            $("#v_tgl_izin").append(json.tgl);
            $("#v_jam_mulai").append(json.mulai);
            $("#v_jam_selesai").append(json.akhir);
            $("#v_alasan").append(json.alasan);
            $("#v_status").append(json.proses);
            $("#v_ket").append(json.ket);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function loadStatistikKeluar() {
    $.post('statistik_izin_keluar', function (response) {
        const json = JSON.parse(response);

        $('#jum_izin_user').html('');
        $('#jum_izin_user_setuju').html('');
        $('#jum_izin_user_tolak').html('');

        $('#jum_izin_user').append(json.jum_izin_user + ' Permohonan');
        $('#jum_izin_user_setuju').append(json.jum_izin_user_setuju + ' Permohonan');
        $('#jum_izin_user_tolak').append(json.jum_izin_user_tolak + ' Permohonan');

    });
}

function loadStatistikValidasiKeluar() {
    $.post('statistik_izin_keluar_validasi', function (response) {
        const json = JSON.parse(response);

        $('#jum_izin_user').html('');
        $('#jum_izin_user_setuju').html('');
        $('#jum_izin_user_tolak').html('');

        $('#jum_izin_user').append(json.jum_izin_user + ' Permohonan');
        $('#jum_izin_user_setuju').append(json.jum_izin_user_setuju + ' Permohonan');
        $('#jum_izin_user_tolak').append(json.jum_izin_user_tolak + ' Permohonan');

    });
}

function loadTabelKeluar() {
    $.post('show_tabel_permohonan_izin_keluar', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelIzin').html(''); // kosongkan wrapper

            if (!json.data_izin || json.data_izin.length === 0) {
                // Kalau kosong
                $('#tabelIzin').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Izin Yang Dibuat. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelIzinData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>STATUS IZIN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_izin.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '3'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '4'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailKeluar('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['1', '3'].includes(row.status)) {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakIzin" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalKeluar('${row.id}')" data-bs-toggle="modal" title="Edit Data">
                            <i class="bx bxs-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="hapusIzin" data-id="${row.id}" title="Hapus Data">
                            <i class="bx bxs-trash"></i>
                        </button>
                    `;
                }

                tombolAksi += `</div>`;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.tgl_izin} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${row.alasan}</td>
                        <td>${statusBadge}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>STATUS IZIN</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelIzin').append(data);

            // Aktifkan DataTables
            $("#tabelIzinData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelIzin').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
        }
    });
}

function loadTabelValidasiKeluar() {
    $.post('show_tabel_validasi_izin_keluar', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelIzin').html(''); // kosongkan wrapper

            if (!json.data_izin || json.data_izin.length === 0) {
                // Kalau kosong
                $('#tabelIzin').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Izin Yang Harus Divalidasi. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelIzinData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>STATUS IZIN</th>
                            <th>NAMA PEGAWAI</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_izin.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '3'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '4'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailKeluar('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['1', '3'].includes(row.status)) {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakIzin" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#validasi"
                            onclick="BukaModalKeluar('${row.id}')" data-bs-toggle="modal" title="Proses">
                            <i class="bx bxs-message-check"></i>
                        </button>
                    `;
                }

                tombolAksi += `</div>`;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-center">${statusBadge}</td>
                        <td>${row.nama}</td>
                        <td>
                            ${row.tgl_izin} <br>
                            <span class="badge rounded-pill bg-info text-dark"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${row.alasan}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>STATUS IZIN</th>
                            <th>NAMA PEGAWAI</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelIzin').append(data);

            // Aktifkan DataTables
            $("#tabelIzinData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelIzin').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
        }
    });
}