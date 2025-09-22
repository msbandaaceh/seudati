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
                        <li class="breadcrumb-item active" aria-current="page">Daftar Izin Diklat Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">REGISTER IZIN DIKLAT</h6>
        <hr />

        <div class="row row-cols-12">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelRegisterDiklat">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detil-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-show me-1 font-22 text-info"></i>
                </div>
                <h5 class="mb-0 text-info" id="v_judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_nama" class="form-label">NAMA PEGAWAI </label>
                        <input type="text" class="form-control" id="v_nama" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_jenis" class="form-label">JENIS PERMOHONAN </label>
                        <input type="text" class="form-control" id="v_jenis" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_nama_diklat" class="form-label">NAMA DIKLAT/BIMTEK </label>
                        <input type="text" class="form-control" id="v_nama_diklat" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_tgl_mulai" class="form-label">TANGGAL MULAI DIKLAT/BIMTEK </label>
                        <input type="text" class="form-control" id="v_tgl_mulai" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_tgl_selesai" class="form-label">TANGGAL SELESAI DIKLAT/BIMTEK </label>
                        <input type="text" class="form-control" id="v_tgl_selesai" readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_proses" class="form-label">PROSES PERIZINAN
                            <code>*</code></label>
                        <div id="v_proses"></div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_progres" class="form-label">PROGRES DIKLAT/BIMTEK
                            <code>*</code></label>
                        <div id="v_progres"></div>
                    </div>
                </div>

                <div class="row g-3 mb-3" id="v_sertifikat" style="display: none">
                    <div class="col-12">
                        <label for="v_progres" class="form-label">DOKUMEN SERTIFIKAT
                            <code>*</code></label>
                        <div id="sertifikat"></div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_ket" id="label_ket">KETERANGAN <code>*</code></label>
                        <textarea id="v_ket" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="dok_diklat">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPegawai" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_dok"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dokumen"></div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelRegisterDiklat();
    });
</script>