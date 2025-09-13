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
                        <li class="breadcrumb-item active" aria-current="page">Daftar Cuti Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">SEUDATI (Sistem Elektronik untuk Administrasi Izin dan Cuti)</h6>
        <hr />

        <div class="row row-cols-12">
            <div class="col">
                <div class="card card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <form id="formLaporanCuti">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <label for="tgl_awal" class="form-label">Tanggal Awal </label><code>*</code>
                                    <input type="text" id="tgl_awal" name="tgl_awal" class="form-control datepicker"
                                        placeholder="Pilih Tanggal Awal..." />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="tgl_akhir" class="form-label">Tanggal Akhir </label><code>*</code>
                                    <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control datepicker"
                                        placeholder="Pilih Tanggal Akhir..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-info btn-block px-5"><i
                                                class="bx bx-search mr-1"></i>Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="hasilCariCuti" class="row row-cols-12" style="display: none">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelLaporanCuti">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#tgl_awal, #tgl_akhir").flatpickr({
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
</script>