function loadStatistikDiklat() {
    $.post('statistik_izin_diklat', function (response) {
        const json = JSON.parse(response);

        $('#jum_diklat_user').html('');
        $('#jum_diklat_user_setuju').html('');
        $('#jum_diklat_user_selesai').html('');
        $('#jum_diklat_user_tolak').html('');

        $('#jum_diklat_user').append(json.jum_diklat_user + ' Permohonan');
        $('#jum_diklat_user_setuju').append(json.jum_diklat_user_setuju + ' Permohonan');
        $('#jum_diklat_user_selesai').append(json.jum_diklat_user_selesai + ' Permohonan');
        $('#jum_diklat_user_tolak').append(json.jum_diklat_user_tolak + ' Permohonan');

    });
}

function loadStatistikValidasiDiklat() {
    $.post('statistik_izin_diklat_validasi', function (response) {
        const json = JSON.parse(response);

        $('#jum_diklat_user').html('');
        $('#jum_diklat_user_setuju').html('');
        $('#jum_diklat_user_selesai').html('');
        $('#jum_diklat_user_tolak').html('');

        $('#jum_diklat_user').append(json.jum_diklat_user + ' Permohonan');
        $('#jum_diklat_user_setuju').append(json.jum_diklat_user_setuju + ' Permohonan');
        $('#jum_diklat_user_selesai').append(json.jum_diklat_user_selesai + ' Permohonan');
        $('#jum_diklat_user_tolak').append(json.jum_diklat_user_tolak + ' Permohonan');

    });
}

function loadTabelDiklat() {
    $.post('show_tabel_permohonan_izin_diklat', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelDiklat').html(''); // kosongkan wrapper

            if (!json.data_diklat || json.data_diklat.length === 0) {
                // Kalau kosong
                $('#tabelDiklat').html(`
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
                <table id="tabelDiklatData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_diklat.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (row.status == '1') {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Disetujui, Menunggu Dokumen Pendukung</span>';
                } else if (row.status == '2') {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Belum Selesai</span>';
                } else if (row.status == '3') {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Selesai</span>';
                } else if (row.status == '4') {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Tolak</span>';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailDiklat('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['2', '3'].includes(row.status)) {
                    if (row.status == '2') {
                        tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#proses"
                            onclick="BukaModalProgresDiklat('${row.id}')" data-bs-toggle="modal" title="Proses">
                            <i class="bx bxs-pencil"></i>
                        </button>
                    `;
                    }
                    tombolAksi += `
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" title="Lihat Dokumen"
                                data-bs-target="#dok_diklat"
                                onclick="BukaDokumen('${row.id}')"
                                data-bs-toggle="modal"><i class="bx bxs-receipt"></i>
                            </button>
                    `;
                } else if (row.status == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalDiklat('${row.id}')" data-bs-toggle="modal" title="Edit Data">
                            <i class="bx bxs-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="hapusDiklat" data-id="${row.id}" title="Hapus Data">
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
                            ${row.nama} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_selesai}</td>
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
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelDiklat').append(data);

            // Aktifkan DataTables
            $("#tabelDiklatData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelDiklat').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
        }
    });
}

function BukaModalDiklat(id) {
    $.post('show_izin_diklat', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            var tglDiklatPicker; // simpan global

            tglDiklatPicker = flatpickr("#tgl_mulai, #tgl_selesai", {
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

            $("#judul").html("");
            $("#id_diklat_").val('');
            $("#jenis_").html('');
            $("#tujuan_").html('');
            $("#nama").val('');
            tglDiklatPicker[0].clear();
            tglDiklatPicker[1].clear();

            $("#judul").append(json.judul);
            $("#id_diklat_").val(json.id);
            $("#jenis_").append(json.jenis);
            $("#tujuan_").append(json.tujuan);
            $("#nama").val(json.nama);
            tglDiklatPicker[0].setDate(json.tgl_mulai, true, "Y-m-d");
            tglDiklatPicker[1].setDate(json.tgl_selesai, true, "Y-m-d");
        }
    });
}

function BukaModalProgresDiklat(id) {
    $.post('show_progres_diklat', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul_proses").html("");
            $("#id_proses").val('');

            $("#judul_proses").append(json.judul);
            $("#id_proses").val(json.id);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function BukaModalValidasiDiklat(id) {
    $.post('show_diklat_detil', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id_diklat_").val('');
            $("#jenis").val('');
            $("#nama").val('');
            $("#nama_diklat").val('');
            $("#tgl_mulai").val('');
            $("#tgl_selesai").val('');

            $("#judul").append(json.judul);
            $("#id_diklat_").val(json.id);
            $("#jenis").val(json.jenis);
            $("#nama").val(json.nama);
            $("#nama_diklat").val(json.nama_diklat);
            $("#tgl_mulai").val(json.tgl_mulai);
            $("#tgl_selesai").val(json.tgl_selesai);

        }
    });
}

function BukaModalDetailDiklat(id) {
    $.post('show_diklat_detil', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#v_judul").html("");
            $("#v_nama").val('');
            $("#v_jenis").val('');
            $("#v_nama_diklat").val('');
            $("#v_tgl_mulai").val('');
            $("#v_tgl_selesai").val('');
            $("#v_proses").html('');
            $("#v_progres").html('');
            $("#v_ket").val('');
            $("#sertifikat").html('');

            $("#v_judul").append(json.judul);
            $("#v_nama").val(json.nama);
            $("#v_jenis").val(json.jenis);
            $("#v_nama_diklat").val(json.nama_diklat);
            $("#v_tgl_mulai").val(json.tgl_mulai);
            $("#v_tgl_selesai").val(json.tgl_selesai);
            if (json.ket) {
                $("#v_ket").val(json.ket);
            } else {
                $("#v_ket").val('-');
            }

            if (json.progres == '1') {
                $("#v_progres").append('<span class="btn radius-30 btn-outline-success">Lulus</span>');
                $('#v_sertifikat').show();
                $('#sertifikat').append(json.sertifikat);
            } else if (json.progres == '2') {
                $("#v_progres").append('<span class="btn radius-30 btn-outline-danger">Tidak Lulus</span>');
            } else {
                $("#v_progres").append('<span class="btn btn-outline-info">Belum Diproses</span>');
            }

            if (json.status == '1') {
                $("#v_proses").append('<span class="btn radius-30 btn-outline-warning text-dark">Disetujui, Menunggu ST</span>');
            } else if (json.status == '2') {
                $("#v_proses").append('<span class="btn radius-30 btn-outline-warning text-dark">Belum Selesai</span>');
            } else if (json.status == '3') {
                $("#v_proses").append('<span class="btn radius-30 btn-outline-success">Diklat Selesai</span>');
            } else if (json.status == '4') {
                $("#v_proses").append('<span class="btn radius-30 btn-outline-danger">Tidak Disetujui</span>');
            } else {
                $("#v_proses").append('<span class="btn radius-30 btn-outline-info">Belum Diproses</span>');
            }
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function showInputLainnya() {
    let jenis = document.getElementById('jenis').value;
    if (jenis == 'Lainnya') {
        $('#jenis_nama').show();
    } else {
        $('#jenis_nama').hide();
    }
}

function loadTabelVerifikasiDiklat() {
    $.post('show_tabel_verifikasi_izin_diklat', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelVerifikasi').html(''); // kosongkan wrapper

            if (!json.data_diklat || json.data_diklat.length === 0) {
                // Kalau kosong
                $('#tabelVerifikasi').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Diklat Yang Harus Diverifikasi. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelVerifikasiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_diklat.forEach((row, index) => {

                // Tombol aksi
                let tombolAksi = `
                        <button type="button" class="btn btn-info" title="Input Dokumen"
                            data-bs-target="#nomor-modal"
                            onclick="BukaModalUploadST('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bx-upload"></i>
                        </button>
                `;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.nama_pegawai}</td>
                        <td>${row.nama}</td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_selesai}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelVerifikasi').append(data);

            // Aktifkan DataTables
            $("#tabelVerifikasiData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelVerifikasi').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
        }
    });
}

function BukaModalUploadST(id) {
    $.post('show_upload_st', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id").val('');
            $("#nama").val('');
            $("#nip").val('');
            $("#jabatan").val('');
            $("#nama_diklat").val('');
            $("#tgl_mulai").val('');
            $("#tgl_selesai").val('');
            $("#jenis").val('');

            $("#judul").append(json.judul);
            $("#id").val(json.id);
            $("#nama").val(json.nama);
            $("#nip").val(json.nip);
            $("#jabatan").val(json.jabatan);
            $("#nama_diklat").val(json.nama_diklat);
            $("#tgl_mulai").val(json.tgl_mulai);
            $("#tgl_selesai").val(json.tgl_selesai);
            $("#jenis").val(json.jenis);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function loadTabelValidasiDiklat() {
    $.post('show_tabel_validasi_izin_diklat', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelValidasiDiklat').html(''); // kosongkan wrapper

            if (!json.data_diklat || json.data_diklat.length === 0) {
                // Kalau kosong
                $('#tabelValidasiDiklat').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pegawai Yang Mengajukan Permohonan Dibuat. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelDiklatData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>STATUS</th>
                            <th>NAMA PEGAWAI</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_diklat.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (row.status == '1') {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Disetujui, Menunggu Dokumen Pendukung</span>';
                } else if (row.status == '2') {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Belum Selesai</span>';
                } else if (row.status == '3') {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Selesai</span>';
                } else if (row.status == '4') {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Tolak</span>';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailDiklat('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['2', '3'].includes(row.status)) {
                    tombolAksi += `
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" title="Lihat Dokumen"
                                data-bs-target="#dok_diklat"
                                onclick="BukaDokumen('${row.id}')"
                                data-bs-toggle="modal"><i class="bx bxs-receipt"></i>
                            </button>
                    `;
                } else if (row.status == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#proses"
                            onclick="BukaModalValidasiDiklat('${row.id}')" data-bs-toggle="modal" title="Proses">
                            <i class="bx bxs-pencil"></i>
                        </button>
                    `;
                }

                tombolAksi += `</div>`;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${statusBadge}</td>
                        <td>
                            ${row.nama_pegawai} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${row.nama}</td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_selesai}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>STATUS</th>
                            <th>NAMA PEGAWAI</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelValidasiDiklat').append(data);

            // Aktifkan DataTables
            $("#tabelDiklatData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelValidasiDiklat').html('<div class="alert alert-danger">Gagal memuat data permohonan izin.</div>');
        }
    });
}