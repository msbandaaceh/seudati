let tglCutiPicker;
var result = config.result;
var pesan = config.pesan;
if (result != '-1') {
    notifikasi(pesan, result);
}

$(document).ready(function () {
    fetchRequestIzin();
    var legal = document.getElementById('jum_req_legal');
    if (legal) {
        fetchRequestLegalisasi();
    }
});

$(function () {
    $(document).off('click', '#hapusIzin').on('click', '#hapusIzin', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('hapus_izin_keluar', { id: id }, function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.success == 1) {
                        notifikasi(json.message, json.success);
                        loadTabelKeluar();
                        loadStatistikKeluar();
                    } else {
                        notifikasi(json.message, json.success);
                    }
                });
            }
        });
    });

    $(document).off('click', '#cetakIzin').on('click', '#cetakIzin', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah akan mencetak data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, cetak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('cetak_izin/' + id, '_blank');
            }
        });
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        date: false,
        format: 'HH:mm'
    });

    $(document).off('submit', '#formIzinKeluar').on('submit', '#formIzinKeluar', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_izin_keluar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == 1) {
                    $('#tambah-modal').modal('hide');
                    loadTabelKeluar();
                    loadStatistikKeluar();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formValidasiIzinKeluar').on('submit', '#formValidasiIzinKeluar', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_validasi_izin_keluar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == 1) {
                    $('#validasi').modal('hide');
                    loadTabelValidasiKeluar();
                    loadStatistikValidasiKeluar();
                    fetchRequestIzin();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('click', '#hapusDiklat').on('click', '#hapusDiklat', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('hapus_izin_diklat', { id: id }, function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.success == 1) {
                        notifikasi(json.message, json.success);
                        loadTabelDiklat();
                        loadStatistikDiklat()
                    } else {
                        notifikasi(json.message, json.success);
                    }
                });
            }
        });
    });

    $(document).off('submit', '#formIzinDiklat').on('submit', '#formIzinDiklat', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_izin_diklat',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabelDiklat();
                    loadStatistikDiklat();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formValidasiIzinDiklat').on('submit', '#formValidasiIzinDiklat', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_validasi_izin_diklat',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#proses').modal('hide');
                    loadTabelValidasiDiklat();
                    loadStatistikValidasiDiklat();
                    fetchRequestIzin();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formLegalDiklat').on('submit', '#formLegalDiklat', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_st',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#nomor-modal').modal('hide');
                    loadTabelVerifikasiDiklat();
                    fetchRequestIzin();
                    fetchRequestLegalisasi();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formProgresDiklat').on('submit', '#formProgresDiklat', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_progres_diklat',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#proses').modal('hide');
                    loadTabelDiklat();
                    loadStatistikDiklat();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formCuti').on('submit', '#formCuti', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_cuti',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabelCuti();
                    loadStatistikCuti();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('click', '#hapusCuti').on('click', '#hapusCuti', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('hapus_cuti', { id: id }, function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.success == 1) {
                        notifikasi(json.message, json.success);
                        loadTabelCuti();
                        loadStatistikCuti()
                    } else {
                        notifikasi(json.message, json.success);
                    }
                });
            }
        });
    });

    $(document).off('click', '#cetakCuti').on('click', '#cetakCuti', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah akan mencetak data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, cetak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('cetak_cuti/' + id, '_blank');
            }
        });
    });

    $(document).off('submit', '#formValidasiCutiAtasan').on('submit', '#formValidasiCutiAtasan', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        // Cara 2: Convert ke object biasa supaya gampang dilihat
        // console.log(Object.fromEntries(formData));

        $.ajax({
            url: 'simpan_validasi_cuti_atasan',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabelValidasiCutiAtasan();
                    loadStatistikValidasiCutiAtasan();
                    fetchRequestIzin();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formLegalCuti').on('submit', '#formLegalCuti', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_nomor',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#nomor-modal').modal('hide');
                    loadTabelLegalisasi();
                    fetchRequestIzin();
                    fetchRequestLegalisasi();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formValidasiCutiPPK').on('submit', '#formValidasiCutiPPK', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_validasi_cuti_ppk',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabelValidasiCutiPPK();
                    loadStatistikValidasiCutiPPK();
                    fetchRequestIzin();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $('#tblSisaCuti').on('change', 'td.editable', function (evt, newValue) {
        var id = $(this).data('id');
        var pegawai_id = $(this).data('user');
        var sisa = newValue;
        var kelas = $(this).data('kelas');
        switch (kelas) {
            case 1:
                var tahun = new Date().getFullYear(); break;
            case 2:
                var tahun = new Date().getFullYear() - 1; break;
            case 3:
                var tahun = new Date().getFullYear() - 2; break;
        }

        $.post("simpan_sisa_cuti", {
            id: id,
            pegawai_id: pegawai_id,
            tahun: tahun,
            sisa: sisa
        }, function (response) {
            //console.log(response);
            fetchSisaCuti();
        }, 'json');
    });

    $('#tblLibur').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $(document).on('submit', '#formPeran', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_peran',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                ModalRole('-1');
            },
            error: function () {
                toastr.error('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusIzinDiklat').attr('href', 'hapus_izin_diklat/' + id);
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusLibur').attr('href', 'hapus_libur/' + id);
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusCuti').attr('href', 'hapus_cuti/' + id);
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusDataCuti').attr('href', 'hapus_data_cuti/' + id);
    });

    $(document).on("click", "#cetak", function () {
        var id = $(this).data('id');
        $('#cetakCuti').attr('href', 'cetak_cuti/' + id);
    });

    $(document).off('submit', '#formLaporanKeluar').on('submit', '#formLaporanKeluar', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'cari_izin_keluar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // biar res langsung jadi object JSON
            success: function (json) {
                notifikasi(json.message, json.success);

                if (json.success == 1) {
                    document.getElementById('hasilCariKeluar').style.display = "block";

                    $('#tabelLaporanKeluar').html(''); // kosongkan wrapper

                    if (!json.data_izin || json.data_izin.length === 0) {
                        // Kalau kosong
                        $('#tabelLaporanKeluar').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Tidak Ada Data Izin Keluar Ditemukan. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                        return;
                    }

                    // Kalau ada data, buat tabelnya
                    let data = `
                <div class="table-responsive">
                <table id="tabelLaporanKeluarData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>PEMBERI IZIN</th>
                            <th>STATUS</th>
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

                        if (row.validator == null) {
                            row.validator = '-';
                            row.jabatan_validator = '-';
                        }

                        // Baris tabel
                        data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama}<br>
                            <small>${row.jabatan}</small>
                        </td>
                        <td>${row.tgl_izin}</td>
                        <td>${row.alasan}</td>
                        <td>
                            ${row.validator}<br>
                            <small>${row.jabatan_validator}</small>
                        </td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
                    });

                    data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>TANGGAL IZIN</th>
                            <th>ALASAN IZIN</th>
                            <th>PEMBERI IZIN</th>
                            <th>STATUS</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

                    $('#tabelLaporanKeluar').append(data);

                    // Aktifkan DataTables
                    $("#tabelLaporanKeluarData").DataTable({
                        lengthChange: true,
                        buttons: ['excel', 'pdf', 'print']
                    }).buttons().container().appendTo('#tabelLaporanKeluarData_wrapper .col-md-6:eq(0)');
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat mencari data.', 4);
            }
        });
    });

    $(document).off('submit', '#formLaporanDiklat').on('submit', '#formLaporanDiklat', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'cari_izin_diklat',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // biar res langsung jadi object JSON
            success: function (json) {
                notifikasi(json.message, json.success);

                if (json.success == 1) {
                    document.getElementById('hasilCariDiklat').style.display = "block";

                    $('#tabelLaporanDiklat').html(''); // kosongkan wrapper

                    if (!json.data_izin || json.data_izin.length === 0) {
                        // Kalau kosong
                        $('#tabelLaporanDiklat').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Tidak Ada Data Izin Diklat Ditemukan. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                        return;
                    }

                    // Kalau ada data, buat tabelnya
                    let data = `
                <div class="table-responsive">
                <table id="tabelLaporanDiklatData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                    json.data_izin.forEach((row, index) => {
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

                        // Baris tabel
                        data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama}<br>
                            <small>${row.jabatan}</small>
                        </td>
                        <td>${row.nama_diklat}</td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_selesai}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
                    });

                    data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

                    $('#tabelLaporanDiklat').append(data);

                    // Aktifkan DataTables
                    $("#tabelLaporanDiklatData").DataTable({
                        lengthChange: true,
                        buttons: ['excel', 'pdf', 'print']
                    }).buttons().container().appendTo('#tabelLaporanDiklatData_wrapper .col-md-6:eq(0)');
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat mencari data.', 4);
            }
        });
    });

    $(document).off('submit', '#formLaporanCuti').on('submit', '#formLaporanCuti', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'cari_cuti',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // biar res langsung jadi object JSON
            success: function (json) {
                notifikasi(json.message, json.success);

                if (json.success == 1) {
                    document.getElementById('hasilCariCuti').style.display = "block";

                    $('#tabelLaporanCuti').html(''); // kosongkan wrapper

                    if (!json.data_cuti || json.data_cuti.length === 0) {
                        // Kalau kosong
                        $('#tabelLaporanCuti').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Tidak Ada Data Cuti Pegawai Ditemukan. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                        return;
                    }

                    // Kalau ada data, buat tabelnya
                    let data = `
                <div class="table-responsive">
                <table id="tabelLaporanCutiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL AWAL</th>
                            <th>TANGGAL AKHIR</th>
                            <th>LAMA CUTI</th>
                            <th>ALASAN CUTI</th>
                            <th>VALIDASI ATASAN</th>
                            <th>VALIDASI PPK</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                    json.data_cuti.forEach((row, index) => {
                        // Tentukan badge status
                        let statusBadge = '';
                        if (row.status_cuti == '0') {
                            statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                        } else if (['1', '5'].includes(row.status_cuti)) {
                            statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                        } else if (['2', '6'].includes(row.status_cuti)) {
                            statusBadge = '<span class="btn btn-outline-warning radius-30">Perubahan</span>';
                        } else if (['3', '7'].includes(row.status_cuti)) {
                            statusBadge = '<span class="btn btn-outline-warning radius-30">DItangguhkan</span>';
                        } else if (['4', '8'].includes(row.status_cuti)) {
                            statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                        }

                        let jenisBadge = '';
                        if (row.jenis == '1') {
                            jenisBadge = 'Cuti Tahunan';
                        } else if (row.jenis == '2') {
                            jenisBadge = 'Cuti Sakit';
                        } else if (row.jenis == '3') {
                            jenisBadge = 'Cuti Melahirkan';
                        } else if (row.jenis == '4') {
                            jenisBadge = 'Cuti Besar';
                        } else if (row.jenis == '5') {
                            jenisBadge = 'Cuti Alasan Penting';
                        } else if (row.jenis == '6') {
                            jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                        }

                        // Baris tabel
                        data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama}<br>
                            <small>${row.jabatan}</small>
                        </td>
                        <td>${jenisBadge}</td>
                        <td>${row.tgl_awal}</td>
                        <td>${row.tgl_akhir}</td>
                        <td>${row.lama}</td>
                        <td>${row.alasan}</td>
                        <td>
                            ${row.nama_validator}<br>
                            <small>${row.jabatan_validator}</small>
                        </td>
                        <td>
                            ${row.nama_ppk}<br>
                            <small>${row.jabatan_ppk}</small>
                        </td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
                    });

                    data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL AWAL</th>
                            <th>TANGGAL AKHIR</th>
                            <th>LAMA CUTI</th>
                            <th>ALASAN CUTI</th>
                            <th>VALIDASI ATASAN</th>
                            <th>VALIDASI PPK</th>
                            <th>STATUS</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

                    $('#tabelLaporanCuti').append(data);

                    // Aktifkan DataTables
                    $("#tabelLaporanCutiData").DataTable({
                        lengthChange: true,
                        buttons: ['excel', 'pdf', 'print']
                    }).buttons().container().appendTo('#tabelLaporanCutiData_wrapper .col-md-6:eq(0)');
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat mencari data.', 4);
            }
        });
    });

    $(document).off('submit', '#formTanggalMerah').on('submit', '#formTanggalMerah', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_hari_libur',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabelHariLibur();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });
});

function loadPage(page) {
    cekToken();
    $('#app').html('<div class="text-center p-4">Memuat...</div>');
    $.get("halamanutama/page/" + page, function (data) {
        $('#app').html(data);
    }).fail(function () {
        $('#app').html('<div class="text-danger">Halaman tidak ditemukan.</div>');
    });
}

function cekToken() {
    $.ajax({
        url: 'cek_token',
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (!res.valid) {
                alert(res.message);
                window.location.href = res.url;
            }
        }
    });
}

function showHide(elm) {
    if (elm == "1") {
        //hide textbox
        document.getElementById('keterangan').style.display = "none";

        var statusCuti = document.getElementById('status_valid_cuti');
        if (statusCuti) {
            var id = document.getElementById('id_cuti_');
            $.post('cek_tanggal', {
                id: id.value
            }, function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    info(json.pesan);
                }
            });
        }
    } else {
        //display textbox
        document.getElementById('keterangan').style.display = 'block';
    }
}

function notifikasi(pesan, result) {
    let icon;
    if (result == '1') {
        result = 'success';
        icon = 'bx bx-check-circle';
    } else if (result == '2') {
        result = 'warning';
        icon = 'bx bx-error';
    } else if (result == '3') {
        result = 'error';
        icon = 'bx bx-x-circle';
    } else {
        result = 'info';
        icon = 'bx bx-info-circle';
    }

    Lobibox.notify(result, {
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        icon: icon,
        sound: false,
        msg: pesan
    });
}

function info(pesan) {
    Swal.fire({
        title: '<h4>Perhatian</h4>',
        html: pesan,
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function BukaDokumen(id) {
    $.post('show_dokumen_diklat', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul_dok").html("");
            $("#dokumen").html('');

            $("#judul_dok").append(json.judul);
            $("#dokumen").append(json.dokumen);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function BukaModalLibur(id) {
    $.post('show_libur', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id").val('');
            $("#tgl_libur").val('');
            $("#ket").val('');

            $("#judul").append(json.judul);
            $("#id").val(json.id);
            $("#tgl_libur").val(json.tgl);
            $("#ket").val(json.ket);

        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function fetchRequestIzin() {
    $('#jum_req_izin').html('');
    $('#jum_req_cuti').html('');
    $('#jum_req_izin_keluar').html('');
    $('#jum_req_izin_diklat').html('');
    $('#jum_req_cuti_atasan').html('');
    $('#jum_req_cuti_ppk').html('');
    var jum_req_izin = $('#jum_req_izin');
    var jum_req_cuti = $('#jum_req_cuti');
    var notifIzin = 0;
    var notifcuti = 0;

    // Gunakan $.when untuk menunggu semua AJAX selesai
    $.when(
        $.ajax({
            url: 'ambil_permohonan_izin_keluar',
            method: 'GET'
        }),
        $.ajax({
            url: 'ambil_permohonan_izin_diklat',
            method: 'GET'
        }),
        $.ajax({
            url: 'ambil_permohonan_cuti_atasan',
            method: 'GET'
        }),
        $.ajax({
            url: 'ambil_permohonan_cuti_ppk',
            method: 'GET'
        })
    ).done(function (dataIzinKeluar, dataIzinDiklat, dataCutiAtasan, dataCutiPPK) {
        // Handle hasil dari 'ambil_permohonan_izin'
        try {
            var izinKeluar = JSON.parse(dataIzinKeluar[0]);  // Access the first element (the response text)

            if (Array.isArray(izinKeluar) && izinKeluar.length > 0) {
                var req_izin_keluar = $('#jum_req_izin_keluar');
                req_izin_keluar.empty();
                notifIzin += izinKeluar.length;
                req_izin_keluar.append(izinKeluar.length);
            }
        } catch (e) {
            console.error("Error parsing izin data:", e);
        }

        try {
            var izinDiklat = JSON.parse(dataIzinDiklat[0]);  // Access the first element (the response text)

            if (Array.isArray(izinDiklat) && izinDiklat.length > 0) {
                var req_izin_diklat = $('#jum_req_izin_diklat');
                req_izin_diklat.empty();
                notifIzin += izinDiklat.length;
                req_izin_diklat.append(izinDiklat.length);
            }
        } catch (e) {
            console.error("Error parsing izin data:", e);
        }

        // Handle hasil dari 'ambil_permohonan_cuti_atasan'
        try {
            var cutiAtasan = JSON.parse(dataCutiAtasan[0]);  // Access the first element (the response text)

            if (Array.isArray(cutiAtasan) && cutiAtasan.length > 0) {
                var req_cuti_atasan = $('#jum_req_cuti_atasan');
                req_cuti_atasan.empty();
                notifcuti += cutiAtasan.length;
                req_cuti_atasan.append(cutiAtasan.length);
            }
        } catch (e) {
            console.error("Error parsing cuti atasan data:", e);
        }

        // Handle hasil dari 'ambil_permohonan_cuti_ppk'
        try {
            var cutiPPK = JSON.parse(dataCutiPPK[0]);
            if (Array.isArray(cutiPPK) && cutiPPK.length > 0) {
                var req_cuti_ppk = $('#jum_req_cuti_ppk');
                req_cuti_ppk.empty();
                notifcuti += cutiPPK.length;
                req_cuti_ppk.append(cutiPPK.length);
            }
        } catch (e) {
            console.error("Error parsing cuti ppk data:", e);
        }

        // Perbarui elemen setelah semua request selesai
        jum_req_izin.empty();
        jum_req_cuti.empty();

        if (notifIzin > 0) {
            jum_req_izin.append('<span class="badge rounded-pill shake-badge bg-danger">Baru</span>');
        }

        if (notifcuti > 0) {
            jum_req_cuti.append('<span class="badge rounded-pill shake-badge bg-danger">Baru</span>');
        }
    }).fail(function (xhr, status, error) {
        console.error("AJAX request failed:", status, error);
    });
}

function fetchSisaCuti() {
    $.ajax({
        url: 'show_tabel_sisa_cuti',
        method: 'GET',
        success: function (response) {
            var sisa = JSON.parse(response);

            $('#tabelSisaCuti').html('');

            let dataTabel = `
                <div class="table-responsive">
                <table id="tabelSisaCutiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>SISA TAHUN INI</th>
                            <th>SISA TAHUN LALU</th>
                            <th>SISA 2 TAHUN LALU</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            sisa.forEach((row, index) => {
                if (row.n1 == null) {
                    row.n1 = '';
                }
                if (row.n2 == null) {
                    row.n2 = '';
                }
                if (row.n3 == null) {
                    row.n3 = '';
                }

                // Baris tabel
                dataTabel += `
                    <tr data-pegawai="${row.pegawai_id}">
                        <td>${index + 1}</td>
                        <td>${row.nama}</td>
                        <td contenteditable="true" data-kelas="1" data-id="${row.id_n1}">${row.n1}</td>
                        <td contenteditable="true" data-kelas="2" data-id="${row.id_n2}">${row.n2}</td>
                        <td contenteditable="true" data-kelas="3" data-id="${row.id_n3}">${row.n3}</td>
                    </tr>
                `;
            });

            dataTabel += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>SISA TAHUN INI</th>
                            <th>SISA TAHUN LALU</th>
                            <th>SISA 2 TAHUN LALU</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelSisaCuti').append(dataTabel);

            // Aktifkan DataTables
            var tabel = $("#tabelSisaCutiData").DataTable();

            // Inline editing event
            $('#tabelSisaCutiData').on('blur', 'td[contenteditable=true]', function () {
                var cell = tabel.cell(this);
                var id = $(this).data('id');
                var sisa = $(this).text().trim();
                var pegawai_id = $(this).closest('tr').data('pegawai');
                var kelas = $(this).data('kelas');
                switch (kelas) {
                    case 1:
                        var tahun = new Date().getFullYear(); break;
                    case 2:
                        var tahun = new Date().getFullYear() - 1; break;
                    case 3:
                        var tahun = new Date().getFullYear() - 2; break;
                }

                // Update di DataTables
                cell.data(sisa).draw(false);

                // Kirim ke server
                $.ajax({
                    url: 'simpan_sisa_cuti', // endpoint update di server
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        pegawai_id: pegawai_id,
                        tahun: tahun,
                        sisa: sisa
                    },
                    success: function (res) {
                        notifikasi(res.message, res.success);
                    },
                    error: function () {
                        notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
                    }

                    
                });
            });
        }
    });
}

function fetchRequestLegalisasi() {
    $('#jum_req_legal').html('');
    $('#jum_req_legal_cuti').html('');
    $('#jum_req_legal_diklat').html('');
    var jum_req_legal = $('#jum_req_legal');
    var notifLegal = 0;

    // Gunakan $.when untuk menunggu semua AJAX selesai
    $.when(
        $.ajax({
            url: 'ambil_permohonan_nomor',
            method: 'GET',
        }),
        $.ajax({
            url: 'ambil_permohonan_dokumen_diklat',
            method: 'GET'
        })
    ).done(function (dataNomorCuti, dataDokumenDiklat) {
        // Handle hasil dari 'ambil_permohonan_izin'
        try {
            var nomorCuti = JSON.parse(dataNomorCuti[0]);  // Access the first element (the response text)

            if (Array.isArray(nomorCuti) && nomorCuti.length > 0) {
                var req_nomor_cuti = $('#jum_req_legal_cuti');
                req_nomor_cuti.empty();
                notifLegal += nomorCuti.length;
                req_nomor_cuti.append(nomorCuti.length);
            }
        } catch (e) {
            console.error("Error parsing izin data:", e);
        }

        try {
            var dokDiklat = JSON.parse(dataDokumenDiklat[0]);  // Access the first element (the response text)

            if (Array.isArray(dokDiklat) && dokDiklat.length > 0) {
                var req_dok_diklat = $('#jum_req_legal_diklat');
                req_dok_diklat.empty();
                notifLegal += dokDiklat.length;
                req_dok_diklat.append(dokDiklat.length);
            }
        } catch (e) {
            console.error("Error parsing izin data:", e);
        }

        // Perbarui elemen setelah semua request selesai
        jum_req_legal.empty();

        if (notifLegal > 0) {
            jum_req_legal.append('<span class="badge bg-danger shake-badge">New</span>');
        }

    }).fail(function (xhr, status, error) {
        console.error("AJAX request failed:", status, error);
    });
}

function BukaModalKeluar(id) {
    $.post('show_izin_keluar', { id: id }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            var tglIzinPicker; // simpan global

            tglIzinPicker = flatpickr("#tgl_izin", {
                dateFormat: "Y-m-d", // format yg dikirim ke server
                altInput: true,
                disableMobile: true,
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

function loadTabelRegisterKeluar() {
    $.post('show_tabel_register_izin_keluar', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelRegisterKeluar').html(''); // kosongkan wrapper

            if (!json.data_izin || json.data_izin.length === 0) {
                // Kalau kosong
                $('#tabelRegisterKeluar').html(`
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
                <table id="tabelRegisterKeluarData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>PEMBERI IZIN</th>
                            <th>STATUS</th>
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
                }

                tombolAksi += `</div>`;

                if (row.validator == null) {
                    row.validator = '-';
                    row.jabatan_validator = '-';
                }

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama} </br>
                            <small>${row.jabatan}</small>    
                        </td>
                        <td>
                            ${row.validator} </br>
                            <small>${row.jabatan_validator}</small>
                        </td>
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
                            <th>NAMA</th>
                            <th>PEMBERI IZIN</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelRegisterKeluar').append(data);

            // Aktifkan DataTables
            $("#tabelRegisterKeluarData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelRegisterKeluar').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
        }
    });
}

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
                disableMobile: true,
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

function loadTabelRegisterDiklat() {
    $.post('show_tabel_register_izin_diklat', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelRegisterDiklat').html(''); // kosongkan wrapper

            if (!json.data_izin || json.data_izin.length === 0) {
                // Kalau kosong
                $('#tabelRegisterDiklat').html(`
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
                <table id="tabelRegisterDiklatData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>NAMA DIKLAT</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
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
                }

                tombolAksi += `</div>`;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama} </br>
                            <small>${row.jabatan}</small>    
                        </td>
                        <td>${row.nama_diklat}</td>
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
                            <th>NAMA</th>
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

            $('#tabelRegisterDiklat').append(data);

            // Aktifkan DataTables
            $("#tabelRegisterDiklatData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelRegisterDiklat').html('<div class="alert alert-danger">Gagal memuat data izin.</div>');
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

function loadTabelLegalisasi() {
    $.post('show_tabel_legalisasi_cuti', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelLegalisasi').html(''); // kosongkan wrapper

            if (!json.data_cuti || json.data_cuti.length === 0) {
                // Kalau kosong
                $('#tabelLegalisasi').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Cuti Yang Harus Diberi Nomor. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelLegalisasiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENIS CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_cuti.forEach((row, index) => {

                let jenisBadge = '';
                if (row.jenis == '1') {
                    jenisBadge = 'Cuti Tahunan';
                } else if (row.jenis == '2') {
                    jenisBadge = 'Cuti Sakit';
                } else if (row.jenis == '3') {
                    jenisBadge = 'Cuti Melahirkan';
                } else if (row.jenis == '4') {
                    jenisBadge = 'Cuti Besar';
                } else if (row.jenis == '5') {
                    jenisBadge = 'Cuti Alasan Penting';
                } else if (row.jenis == '6') {
                    jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                }

                // Tombol aksi
                let tombolAksi = `
                        <button type="button" class="btn btn-info" title="Input Nomor Surat Cuti"
                            data-bs-target="#nomor-modal"
                            onclick="BukaModalPenomoranCuti('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bx-upload"></i>
                        </button>
                `;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.nama}</td>
                        <td>${jenisBadge}</td>
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
                            <th>JENIS CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelLegalisasi').append(data);

            // Aktifkan DataTables
            $("#tabelLegalisasiData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelLegalisasi').html('<div class="alert alert-danger">Gagal memuat data cuti.</div>');
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

function loadStatistikCuti() {
    $.post('statistik_cuti', function (response) {
        const json = JSON.parse(response);

        $('#jum_cuti_user').html('');
        $('#jum_cuti_user_setuju').html('');
        $('#jum_cuti_user_tolak').html('');

        $('#jum_cuti_user').append(json.jum_cuti_user + ' Permohonan');
        $('#jum_cuti_user_setuju').append(json.jum_cuti_user_setuju + ' Permohonan');
        $('#jum_cuti_user_tolak').append(json.jum_cuti_user_tolak + ' Permohonan');

    });
}

function loadTabelCuti() {
    $.post('show_tabel_permohonan_cuti', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelCuti').html(''); // kosongkan wrapper

            if (!json.data_cuti || json.data_cuti.length === 0) {
                // Kalau kosong
                $('#tabelCuti').html(`
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
                <table id="tabelCutiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>JENIS CUTI</th>
                            <th>LAMA CUTI</th>
                            <th>STATUS CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_cuti.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status_cuti == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '5'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '6'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Perubahan</span>';
                } else if (['3', '7'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">DItangguhkan</span>';
                } else if (['4', '8'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                let jenisBadge = '';
                if (row.jenis == '1') {
                    jenisBadge = 'Cuti Tahunan';
                } else if (row.jenis == '2') {
                    jenisBadge = 'Cuti Sakit';
                } else if (row.jenis == '3') {
                    jenisBadge = 'Cuti Melahirkan';
                } else if (row.jenis == '4') {
                    jenisBadge = 'Cuti Besar';
                } else if (row.jenis == '5') {
                    jenisBadge = 'Cuti Alasan Penting';
                } else if (row.jenis == '6') {
                    jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailCuti('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (row.status_cuti != '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakCuti" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status_cuti == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalCuti('${row.id}')" data-bs-toggle="modal" title="Edit Data">
                            <i class="bx bxs-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="hapusCuti" data-id="${row.id}" title="Hapus Data">
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
                            ${jenisBadge} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${row.lama} Hari</td>
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
                            <th>JENIS CUTI</th>
                            <th>LAMA CUTI</th>
                            <th>STATUS CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelCuti').append(data);

            // Aktifkan DataTables
            $("#tabelCutiData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelCuti').html('<div class="alert alert-danger">Gagal memuat data cuti.</div>');
        }
    });
}

function BukaModalCuti(id) {
    document.getElementById('detil_cuti').style.display = "none";
    $.post('show_cuti', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            // reset data form
            $("#judul").html("");
            $("#id_cuti_").val('');
            $('#jenis_').html('');
            $('#kuota').val('');
            $('#kuota_show').html('');
            $('#lama').val('');
            $('#alasan').val('');
            $('#alamat').val('');

            // isi data dari response
            $("#judul").append(json.judul);
            $("#id_cuti_").val(json.id);
            $('#jenis_').append(json.jenis);
            $('#kuota_show').append(json.kuota + ' HARI');
            $('#kuota').val(json.kuota);
            $('#lama').val(json.lama);
            $('#alasan').val(json.alasan);
            $('#alamat').val(json.alamat);

            // kalau tgl_mulai dan tgl_selesai ada, set value
            if (json.id && json.tgl_awal && json.tgl_akhir) {
                window.tglAwalSet = json.tgl_awal;
                window.tglAkhirSet = json.tgl_akhir;

                let jenis = document.getElementById('jenis').value;
                if (jenis == 1 || jenis == 2) {
                    HariKerja();
                } else {
                    HariKalender();
                }

                $('#detil_cuti').show();
            }

        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function loadTabelValidasiCutiAtasan() {
    $.post('show_tabel_validasi_cuti_atasan', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelValidasiCutiAtasan').html(''); // kosongkan wrapper

            if (!json.data_cuti || json.data_cuti.length === 0) {
                // Kalau kosong
                $('#tabelValidasiCutiAtasan').html(`
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
                <table id="tabelValidasiCutiAtasanData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>STATUS VALIDASI</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL MULAI CUTI</th>
                            <th>TANGGAL SELESAI CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_cuti.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '5'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '6'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Perubahan</span>';
                } else if (['3', '7'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Penangguhan</span>';
                } else if (['4', '8'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                let jenisBadge = '';
                if (row.jenis == '1') {
                    jenisBadge = 'Cuti Tahunan';
                } else if (row.jenis == '2') {
                    jenisBadge = 'Cuti Sakit';
                } else if (row.jenis == '3') {
                    jenisBadge = 'Cuti Melahirkan';
                } else if (row.jenis == '4') {
                    jenisBadge = 'Cuti Besar';
                } else if (row.jenis == '5') {
                    jenisBadge = 'Cuti Alasan Penting';
                } else if (row.jenis == '6') {
                    jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailCuti('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['1', '5'].includes(row.status_cuti)) {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakCuti" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status_cuti == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalValidasiCuti('${row.id}')" data-bs-toggle="modal" title="Proses">
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
                            ${row.nama} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${jenisBadge}</td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_akhir}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>STATUS VALIDASI</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL MULAI CUTI</th>
                            <th>TANGGAL SELESAI CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelValidasiCutiAtasan').append(data);

            // Aktifkan DataTables
            $("#tabelValidasiCutiAtasanData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelCuti').html('<div class="alert alert-danger">Gagal memuat data cuti.</div>');
        }
    });
}

function loadStatistikValidasiCutiAtasan() {
    $.post('statistik_validasi_cuti_atasan', function (response) {
        const json = JSON.parse(response);

        $('#jum_validasi_cuti_atasan').html('');
        $('#jum_validasi_cuti_atasan_proses').html('');

        $('#jum_validasi_cuti_atasan').append(json.jum_validasi_cuti_atasan + ' Permohonan');
        $('#jum_validasi_cuti_atasan_proses').append(json.jum_validasi_cuti_atasan_proses + ' Permohonan');
        document.getElementById('pgrs_all').style.width = json.pgrs_all + '%';
        document.getElementById('pgrs_proses').style.width = json.pgrs_proses + '%';
    });
}

function loadTabelValidasiCutiPPK() {
    $.post('show_tabel_validasi_cuti_ppk', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelValidasiCutiPPK').html(''); // kosongkan wrapper

            if (!json.data_cuti || json.data_cuti.length === 0) {
                // Kalau kosong
                $('#tabelValidasiCutiPPK').html(`
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
                <table id="tabelValidasiCutiPPKData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>STATUS VALIDASI</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL MULAI CUTI</th>
                            <th>TANGGAL SELESAI CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_cuti.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '5'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '6'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Perubahan</span>';
                } else if (['3', '7'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Penangguhan</span>';
                } else if (['4', '8'].includes(row.status)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                let jenisBadge = '';
                if (row.jenis == '1') {
                    jenisBadge = 'Cuti Tahunan';
                } else if (row.jenis == '2') {
                    jenisBadge = 'Cuti Sakit';
                } else if (row.jenis == '3') {
                    jenisBadge = 'Cuti Melahirkan';
                } else if (row.jenis == '4') {
                    jenisBadge = 'Cuti Besar';
                } else if (row.jenis == '5') {
                    jenisBadge = 'Cuti Alasan Penting';
                } else if (row.jenis == '6') {
                    jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailCuti('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (['1', '5'].includes(row.status_cuti)) {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakCuti" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status_cuti == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalValidasiCuti('${row.id}')" data-bs-toggle="modal" title="Proses">
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
                            ${row.nama} <br>
                            <span class="badge rounded-pill bg-info"><i>Dibuat pada ${row.created_on}</i></span>
                        </td>
                        <td>${jenisBadge}</td>
                        <td>${row.tgl_mulai}</td>
                        <td>${row.tgl_akhir}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>STATUS VALIDASI</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENIS CUTI</th>
                            <th>TANGGAL MULAI CUTI</th>
                            <th>TANGGAL SELESAI CUTI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelValidasiCutiPPK').append(data);

            // Aktifkan DataTables
            $("#tabelValidasiCutiPPKData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelCuti').html('<div class="alert alert-danger">Gagal memuat data cuti.</div>');
        }
    });
}

function loadStatistikValidasiCutiPPK() {
    $.post('statistik_validasi_cuti_ppk', function (response) {
        const json = JSON.parse(response);

        $('#jum_validasi_cuti').html('');
        $('#jum_validasi_cuti_proses').html('');

        $('#jum_validasi_cuti').append(json.jum_validasi_cuti + ' Permohonan');
        $('#jum_validasi_cuti_proses').append(json.jum_validasi_cuti_proses + ' Permohonan');
        document.getElementById('pgrs_all').style.width = json.pgrs_all + '%';
        document.getElementById('pgrs_proses').style.width = json.pgrs_proses + '%';
    });
}

function loadTabelRegisterCuti() {
    $.post('show_tabel_register_cuti', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelRegisterCuti').html(''); // kosongkan wrapper

            if (!json.data_cuti || json.data_cuti.length === 0) {
                // Kalau kosong
                $('#tabelRegisterCuti').html(`
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
                <table id="tabelRegisterCutiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>JENIS CUTI</th>
                            <th>LAMA CUTI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_cuti.forEach((row, index) => {
                // Tentukan badge status
                let statusBadge = '';
                if (row.status_cuti == '0') {
                    statusBadge = '<span class="btn btn-outline-primary radius-30">Menunggu Diproses</span>';
                } else if (['1', '5'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-success radius-30">Disetujui</span>';
                } else if (['2', '6'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">Perubahan</span>';
                } else if (['3', '7'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-warning radius-30">DItangguhkan</span>';
                } else if (['4', '8'].includes(row.status_cuti)) {
                    statusBadge = '<span class="btn btn-outline-danger radius-30">Ditolak</span>';
                }

                let jenisBadge = '';
                if (row.jenis == '1') {
                    jenisBadge = 'Cuti Tahunan';
                } else if (row.jenis == '2') {
                    jenisBadge = 'Cuti Sakit';
                } else if (row.jenis == '3') {
                    jenisBadge = 'Cuti Melahirkan';
                } else if (row.jenis == '4') {
                    jenisBadge = 'Cuti Besar';
                } else if (row.jenis == '5') {
                    jenisBadge = 'Cuti Alasan Penting';
                } else if (row.jenis == '6') {
                    jenisBadge = 'Cuti Di Luar Tanggungan Negara';
                }

                // Tombol aksi
                let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" title="Lihat"
                            data-bs-target="#detil-modal"
                            onclick="BukaModalDetailCuti('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                if (row.status_cuti != '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-success" id="cetakCuti" data-id="${row.id}" title="Cetak Blangko">
                            <i class="bx bxs-printer"></i>
                        </button>
                    `;
                } else if (row.status_cuti == '0') {
                    tombolAksi += `
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalCuti('${row.id}')" data-bs-toggle="modal" title="Edit Data">
                            <i class="bx bxs-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="hapusCuti" data-id="${row.id}" title="Hapus Data">
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
                            ${row.nama} </br>
                            <small>${row.jabatan}</small>    
                        </td>
                        <td>${jenisBadge}</td>
                        <td>${row.lama} Hari</td>
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
                            <th>NAMA</th>
                            <th>JENIS CUTI</th>
                            <th>LAMA CUTI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelRegisterCuti').append(data);

            // Aktifkan DataTables
            $("#tabelRegisterCutiData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelRegisterCuti').html('<div class="alert alert-danger">Gagal memuat data cuti.</div>');
        }
    });
}

function HariKalender() {
    tglCutiPicker = flatpickr('#tgl_cuti', {
        mode: 'range',
        altInput: true,
        altFormat: 'd F Y',
        locale: {
            firstDayOfWeek: 7,
            rangeSeparator: " sampai ",
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
        },
        onReady: function (selectedDates, dateStr, instance) {
            // Kalau ada tanggal dari JSON, set langsung di sini
            if (window.tglAwalSet && window.tglAkhirSet) {
                instance.setDate([window.tglAwalSet, window.tglAkhirSet], true);
            }
        },
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                var start = selectedDates[0];
                var end = selectedDates[1];

                // Hitung jumlah hari valid
                var validDays = 0;
                var currentDate = new Date(start);

                while (currentDate <= end) {
                    validDays++;
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                document.getElementById('lama').value = validDays;
                document.getElementById('tgl_awal').value = start.toISOString().split('T')[0];
                document.getElementById('tgl_akhir').value = end.toISOString().split('T')[0];
            }
        }
    });
}

function HariKerja() {
    var disabledDates = []; // Untuk menyimpan tanggal yang dinonaktifkan

    // AJAX untuk mengambil tanggal dari database
    $.ajax({
        url: 'get_tgl_merah', // URL ke script PHP yang dibuat
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            disabledDates = response; // Menyimpan tanggal dari respons ke array
            //console.log(disabledDates); // Cek data yang diterima (optional)

            // Inisialisasi daterangepicker setelah data diterima
            tglCutiPicker = flatpickr('#tgl_cuti', {
                mode: 'range',
                altFormat: 'd F Y',
                altInput: true,
                dateFormat: 'Y-m-d',
                locale: {
                    firstDayOfWeek: 7,
                    rangeSeparator: " sampai ",
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
                },
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    var day = dayElem.dateObj.getDay();
                    var dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");

                    // Disable Sabtu & Minggu + tanggal merah (tidak bisa diklik langsung)
                    if (day === 0 || day === 6 || disabledDates.includes(dateStr)) {
                        dayElem.classList.add("disabled-date");
                    }

                    // Highlight merah untuk tanggal merah
                    if (disabledDates.includes(dateStr)) {
                        dayElem.classList.add("tanggal-merah");
                    }
                },
                onReady: function (selectedDates, dateStr, instance) {
                    // Cegah klik langsung di tanggal disable
                    instance.calendarContainer.addEventListener("click", function (e) {
                        if (e.target.closest(".disabled-date")) {
                            e.stopPropagation();
                        }
                    }, true);

                    if (window.tglAwalSet && window.tglAkhirSet) {
                        instance.setDate([window.tglAwalSet, window.tglAkhirSet], true);
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        var start = selectedDates[0];
                        var end = selectedDates[1];

                        // Hitung jumlah hari valid
                        var validDays = 0;
                        var currentDate = new Date(start);

                        while (currentDate <= end) {
                            var day = currentDate.getDay();
                            var formatted = instance.formatDate(currentDate, 'Y-m-d');

                            if (day !== 0 && day !== 6 && !disabledDates.includes(formatted)) {
                                validDays++;
                            }
                            currentDate.setDate(currentDate.getDate() + 1);
                        }

                        var jenis = document.getElementById('jenis').value;
                        var kuota = parseInt(document.getElementById('kuota').value);

                        if (jenis == 1 && validDays > kuota) {
                            notifikasi('Sisa Cuti Tahunan Anda Tidak Mencukupi, Silakan Periksa Kembali Sisa Cuti Anda Sebelum Mengajukan Permohonan', '2');
                        } else {
                            document.getElementById('lama').value = validDays;
                            document.getElementById('tgl_awal').value = start.toISOString().split('T')[0];
                            document.getElementById('tgl_akhir').value = end.toISOString().split('T')[0];
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error in fetching dates: ", error);
        }
    });
}

function format(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        //return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
        return date.getFullYear() + '-' + date.getMonth() + 1 + '-' + date.getDate();
    }
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function UbahKalender(id) {
    var masa_kerja = parseInt(config.masa_kerja);
    var id_grup = config.id_grup;
    var jk = config.jk;

    switch (parseInt(id.value)) {
        case 1:
            if (masa_kerja < 1 && id_grup != 6) {
                var pesan = 'Masa Kerja anda belum genap 1 Tahun. Anda belum diperbolehkan untuk melakukan permohonan Cuti Tahunan';
                notifikasi(pesan, '2');
            } else {
                $('#detil_cuti').show();
                HariKerja();
            }
            break;
        case 2:
            $('#detil_cuti').show();
            HariKerja();
            break;
        case 3:
            //console.log("Masuk Sini " + jk);
            if (jk == '1') {
                var pesan = 'Anda Bukan Wanita, Anda Tidak Melahirkan';
                notifikasi(pesan, '2');
            } else {
                $('#detil_cuti').show();
                HariKalender();
            }
            break;
        case 4:
            if (masa_kerja < 5) {
                var pesan = 'Masa Kerja anda belum genap 5 Tahun. Anda belum diperbolehkan untuk melakukan permohonan Cuti Besar';
                notifikasi(pesan, '2');
            } else {
                $('#detil_cuti').show();
                HariKalender();
            }
            break;
        case 5:
            $('#detil_cuti').show();
            HariKalender();
            break;
        case 6:
            if (masa_kerja < 5) {
                var pesan = 'Masa Kerja anda belum genap 5 Tahun. Anda belum diperbolehkan untuk melakukan permohonan Cuti di Luar Tanggungan Negara';
                notifikasi(pesan, '2');
            } else {
                $('#detil_cuti').show();
                HariKalender();
            }
            break;
    }

}

function BukaModalDetailCuti(id) {
    $.post('show_cuti_detil', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#v_judul").html("");
            $("#v_jenis_cuti").val('');
            $("#v_tgl_mulai").val('');
            $("#v_tgl_akhir").val('');
            $("#v_lama").val('');
            $("#v_alamat").val('');
            $("#v_alasan").val('');
            $("#v_status_atasan").html('');
            $("#v_alasan_atasan").val('');
            $("#v_status_ppk").html('');
            $("#v_alasan_ppk").val('');

            $("#v_judul").append(json.judul);
            $("#v_jenis_cuti").val(json.jenis_cuti);
            $("#v_tgl_mulai").val(json.tgl_awal);
            $("#v_tgl_akhir").val(json.tgl_akhir);
            $("#v_lama").val(json.lama + ' Hari');
            $("#v_alamat").val(json.alamat);
            $("#v_alasan").val(json.alasan);
            if (json.status_validator == '1' || json.status_validator == '5') {
                $("#v_status_atasan").append('<span class="btn radius-30 btn-outline-success">Disetujui</span>');
            } else if (json.status_validator == '2' || json.status_validator == '6') {
                $("#v_status_atasan").append('<span class="btn radius-30 btn-outline-warning">Perubahan</span>');
            } else if (json.status_validator == '3' || json.status_validator == '7') {
                $("#v_status_atasan").append('<span class="btn radius-30 btn-outline-warning">Ditangguhkan</span>');
            } else if (json.status_validator == '4' || json.status_validator == '8') {
                $("#v_status_atasan").append('<span class="btn radius-30 btn-outline-danger">Tidak Disetujui</span>');
            } else {
                $("#v_status_atasan").append('<span class="btn radius-30 btn-outline-info">Belum Diproses</span>');
            }
            $("#v_alasan_atasan").val(json.alasan_validator);
            if (json.status_ppk == '1' || json.status_ppk == '5') {
                $("#v_status_ppk").append('<span class="btn radius-30 btn-outline-success">Disetujui</span>');
            } else if (json.status_ppk == '2' || json.status_ppk == '6') {
                $("#v_status_ppk").append('<span class="btn radius-30 btn-outline-warning">Perubahan</span>');
            } else if (json.status_ppk == '3' || json.status_ppk == '7') {
                $("#v_status_ppk").append('<span class="btn radius-30 btn-outline-warning">Ditangguhkan</span>');
            } else if (json.status_ppk == '4' || json.status_ppk == '8') {
                $("#v_status_ppk").append('<span class="btn radius-30 btn-outline-danger">Tidak Disetujui</span>');
            } else {
                $("#v_status_ppk").append('<span class="btn radius-30 btn-outline-info">Belum Diproses</span>');
            }
            $("#v_alasan_ppk").val(json.alasan_ppk);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function BukaModalPenomoranCuti(id) {
    $.post('show_nomor', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id").val('');
            $("#nama").val('');
            $("#nip").val('');
            $("#jabatan").val('');
            $("#jenis").val('');

            $("#judul").append(json.judul);
            $("#id").val(json.id);
            $("#nama").val(json.nama);
            $("#nip").val(json.nip);
            $("#jabatan").val(json.jabatan);
            $("#jenis").val(json.grup);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function BukaModalValidasiCuti(id) {
    $.post('show_cuti_validasi', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id_cuti_").val('');
            $("#nama").val('');
            $("#nip").val('');
            $("#jabatan").val('');
            $("#jenis").val('');
            $("#tgl_mulai").val('');
            $("#tgl_selesai").val('');
            $("#alamat").val('');
            $("#alasan").val('');

            $("#judul").append(json.judul);
            $("#id_cuti_").val(json.id);
            $("#nama").val(json.nama);
            if (json.nip) {
                $("#nip").val(json.nip);
            } else {
                $("#nip").val('-');
            }
            $("#jabatan").val(json.jabatan);
            $("#jenis").val(json.jenis_cuti);
            $("#tgl_mulai").val(json.tgl_awal);
            $("#tgl_selesai").val(json.tgl_akhir);
            $("#alamat").val(json.alamat);
            $("#alasan").val(json.alasan);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function ModalRole(id) {
    $('#role-pegawai').modal('show');
    $('#btnBatal').hide();
    if (id != '-1') {
        $('#tabel-role').html('');
        $('#btnBatal').show();
    }

    $.post('show_role',
        { id: id },
        function (response) {
            try {
                const json = JSON.parse(response); // pastikan response valid JSON
                $('#pegawai_').html('');

                let html = `<select class="form-control select2" id="pegawai" name="pegawai" style="width:100%">`;
                json.pegawai.forEach(row => {
                    html += `<option value="${row.userid}" data-nama="${row.fullname}" data-jabatan="${row.jabatan}">${row.fullname}</option>`;
                });
                html += `</select>`;
                $('#pegawai_').append(html);

                $('#peran_').html('');
                let role = `<select class="form-control select2" id="peran" name="peran" style="width:100%">`;
                role += `<option value="operator">Operator Kepegawaian</option>`;
                role += `</select>`;
                $('#peran_').append(role);

                $('#overlay').hide();

                $('#pegawai').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#role-pegawai'),
                    width: '100%',
                    placeholder: "Pilih pegawai",
                    templateResult: formatPegawaiOption,
                    templateSelection: formatPegawaiSelection
                });

                $('#peran').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#role-pegawai'),
                    width: '100%',
                    placeholder: "Pilih Peran"
                });

                if (id != '-1') {
                    $('#id').val('');

                    $('#id').val(json.id);
                    $('#pegawai').val(json.editPegawai).trigger('change');
                    $('#peran').val(json.editPeran).trigger('change');

                    $('#pegawai').on('select2:opening select2:selecting', function (e) {
                        e.preventDefault(); // mencegah dropdown terbuka
                    });
                } else {
                    $('#tabel-role').html('');

                    let data = `
                    <div class="table-responsive">
                    <table id="tabelPeran" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead><tbody>`;
                    json.data_peran.forEach(row => {
                        if (`${row.peran}` == 'operator') {
                            var peran = 'Operator Kepegawaian';
                        }
                        data += `
                        <tr>
                            <td>${row.nama}</td>
                            <td>`;

                        if (`${row.hapus}` == '0') {
                            data += `<span class='badge bg-success'>${peran}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" id="editPeran" onclick="ModalRole('${row.id}')" title="Edit Peran">
                                    <i class="bx bx-pencil me-0"></i>
								</button>

                                <button type="button" class="btn btn-outline-danger" id="hapusPeran" onclick="blokPeran('${row.id}')" title="Blok Pegawai">
                                    <i class="bx bx-block me-0"></i>
								</button>`;
                        } else {
                            data += `<span class='badge bg-secondary'>${peran}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success" id="hapusPeran" onclick="aktifPeran('${row.id}')" title="Aktifkan Pegawai">
                                    <i class="bx bx-check me-0"></i>
								</button>`;
                        }
                        data += `
                            </td>
                        </tr>`;
                    });
                    data += `
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <span class='badge bg-success'>Aktif</span>
                        <span class='badge bg-secondary'>Non-aktif</span>
                    </div>
                    </div>`;
                    $('#tabel-role').append(data);
                    $("#tabelPeran").DataTable();
                }
            } catch (e) {
                console.error("Gagal parsing JSON:", e);
                $('#pegawai_').html('<div class="alert alert-danger">Gagal memuat data pegawai.</div>');
            }
        }
    );
}

function aktifPeran(id) {
    Swal.fire({
        title: "Yakin ingin mengaktifkan kembali peran pegawai?",
        text: "Data peran ini akan diaktifkan perannya.",
        icon: "warning", // ⬅️ gunakan 'icon' bukan 'type'
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, aktifkan!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Eksekusi penghapusan setelah konfirmasi
            $.post('aktif_peran', { id: id }, function (response) {
                Swal.fire("Berhasil!", "Peran telah diaktifkan.", "success");
                ModalRole('-1');
            }).fail(function () {
                Swal.fire("Gagal", "Terjadi kesalahan saat mengaktifkan data.", "error");
            });
        }
    });
}

function blokPeran(id) {
    Swal.fire({
        title: "Yakin ingin menonaktifkan peran pegawai?",
        text: "Data peran ini akan dinonaktifkan perannya.",
        icon: "warning", // ⬅️ gunakan 'icon' bukan 'type'
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, nonaktifkan!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Eksekusi penghapusan setelah konfirmasi
            $.post('blok_peran', { id: id }, function (response) {
                Swal.fire("Berhasil!", "Peran telah dinonaktifkan.", "success");
                ModalRole('-1');
            }).fail(function () {
                Swal.fire("Gagal", "Terjadi kesalahan saat menghapus data.", "error");
            });
        }
    });
}

function formatPegawaiOption(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return $(`
        <div style="line-height:1.2">
            <div style="font-weight:bold;">${nama}</div>
            <div style="font-size:12px; color:#555;">${jabatan}</div>
        </div>
    `);
}

function formatPegawaiSelection(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return `${nama} > ${jabatan}`;
}

function loadTabelHariLibur() {
    $.post('show_tabel_hari_libur', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelTanggalMerah').html(''); // kosongkan wrapper

            if (!json.data_libur || json.data_libur.length === 0) {
                // Kalau kosong
                $('#tabelTanggalMerah').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Daftar Hari Libur. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat accordionnya
            let data = `
                <div class="accordion" id="accordionLibur">
            `;

            for (var a = json.tahun; a >= json.tahun - 2; a--) {
                let isActive = (a == json.tahun);
                data += `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${a}">
							<button class="accordion-button ${isActive ? "" : "collapsed"}" type="button" data-bs-toggle="collapse"
								data-bs-target="#collapse${a}" aria-expanded="${isActive ? "true" : "false"}" aria-controls="collapse${a}">
								Tahun ${a}
							</button>
						</h2>
                        <div id="collapse${a}" class="accordion-collapse collapse ${isActive ? "show" : ""}"
							aria-labelledby="heading${a}" data-bs-parent="#accordionLibur">
							<div class="accordion-body">
                                <div class="table-responsive">
                                    <table id="tabelLibur${a}" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>TANGGAL</th>
                                                <th>KETERANGAN</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                `;

                let no = 1;
                json.data_libur.forEach((row, index) => {
                    // Tombol aksi
                    let tombolAksi = `
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning" data-bs-target="#tambah-modal"
                            onclick="BukaModalLibur('${row.id}')" data-bs-toggle="modal" title="Edit Data">
                            <i class="bx bxs-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="hapusLibur" data-id="${row.id}" title="Hapus Data">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </div>
                    `;

                    let tahunRow = row.tgl.substring(0, 4);

                    // Baris tabel
                    if (tahunRow == a) {
                        data += `
                        <tr>
                            <td>${no}</td>
                            <td>${row.tanggal}</td>
                            <td>${row.ket}</td>
                            <td>${tombolAksi}</td>
                        </tr>
                        `;
                        no++; // increment hanya kalau baris ditampilkan
                    }
                });

                data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>KETERANGAN</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
                `;

                data += `
                            </div>
						</div>
                    </div> 
                `;
            }

            data += `</div>`;

            $('#tabelTanggalMerah').append(data);

            // Aktifkan DataTables
            for (var a = json.tahun; a >= json.tahun - 2; a--) {
                $("#tabelLibur" + a).DataTable({
                    stateSave: true
                });
            }
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelCuti').html('<div class="alert alert-danger">Gagal memuat data hari libur.</div>');
        }
    });
}

function BukaModalLibur(id) {
    $.post('show_libur', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            let disabledDates = {}; // gunakan object
            var tglPicker;

            // AJAX untuk mengambil tanggal dari database
            $.ajax({
                url: 'get_hari_libur', // URL ke script PHP yang dibuat
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    //disabledDates = response; // Menyimpan tanggal dari respons ke array
                    //console.log(disabledDates); // Cek data yang diterima (optional)
                    response.forEach(item => {
                        disabledDates[item.date] = item.keterangan;
                    });

                    // Inisialisasi daterangepicker setelah data diterima
                    tglPicker = flatpickr('#tgl_libur', {
                        dateFormat: "Y-m-d", // format yg dikirim ke server
                        altInput: true,
                        disableMobile: true,
                        altFormat: "d F Y", // format tampilan
                        locale: {
                            firstDayOfWeek: 7,
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
                        },
                        disable: [
                            function (date) {
                                // disable sabtu minggu
                                let dateStr = flatpickr.formatDate(date, "Y-m-d");
                                if (json.tgl && dateStr === json.tgl) {
                                    return false;
                                }
                                return (date.getDay() === 0 || date.getDay() === 6);
                            },
                            function (date) {
                                // disable tanggal merah dari database
                                let dateStr = flatpickr.formatDate(date, "Y-m-d");
                                if (json.tgl && dateStr === json.tgl) {
                                    return false;
                                }
                                return !!disabledDates[dateStr]; // true = disable
                            }
                        ],
                        onDayCreate: function (dObj, dStr, fp, dayElem) {
                            var dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");

                            // styling merah
                            if (disabledDates[dateStr]) {
                                dayElem.classList.add("tanggal-merah");
                                dayElem.setAttribute("title", disabledDates[dateStr]);
                            }
                        },
                        onReady: function (selectedDates, dateStr, instance) {
                            // set default value setelah flatpickr siap
                            if (json.tgl) {
                                console.log(json.tgl);
                                instance.setDate(json.tgl, true);
                            }
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error in fetching dates: ", error);
                }
            });

            $("#judul").html("");
            $("#id").val('');
            $("#ket").val('');

            $("#judul").append(json.judul);
            $("#id").val(json.id);
            $("#ket").val(json.ket);

        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function GenerateCuti() {
    $.post('generate_cuti', function (response) {
        var json = jQuery.parseJSON(response);
        if (json.success) {
            notifikasi(json.message, json.success);
        }
    });
}