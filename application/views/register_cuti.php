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
        <h6 class="mb-0 text-uppercase">REGISTER CUTI</h6>
        <hr />

        <div class="row row-cols-12">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelRegisterCuti">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detil-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
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
                        <label for="v_jenis_cuti" class="form-label">Jenis Cuti </label>
                        <input type="text" class="form-control" id="v_jenis_cuti" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_tgl_mulai" class="form-label">Tanggal Mulai Cuti </label>
                        <input type="text" class="form-control" id="v_tgl_mulai" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_tgl_akhir" class="form-label">Tanggal Selesai Cuti </label>
                        <input type="text" class="form-control" id="v_tgl_akhir" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_lama" class="form-label">Lama Cuti </label>
                        <input type="text" class="form-control" id="v_lama" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_alamat" class="form-label">Alamat Selama Cuti </label>
                        <input type="text" class="form-control" id="v_alamat" readonly>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_alasan" class="form-label">Alasan Cuti </label>
                        <input type="text" class="form-control" id="v_alasan" readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_status_atasan" class="form-label">Status Proses Atasan
                            <code>*</code></label>
                        <div id="v_status_atasan"></div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_alasan_atasan" class="form-label">Alasan Proses Atasan </label>
                        <input type="text" class="form-control" id="v_alasan_atasan" readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_status_ppk" class="form-label">Status Proses PPK
                            <code>*</code></label>
                        <div id="v_status_ppk"></div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="v_alasan_ppk" class="form-label">Alasan Proses PPK </label>
                        <input type="text" class="form-control" id="v_alasan_ppk" readonly>
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

<script>
    $(document).ready(function () {
        loadTabelRegisterCuti();
    });
</script>