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
                        <li class="breadcrumb-item active" aria-current="page">Daftar Izin Keluar Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">SEUDATI (Sistem Elektronik untuk Administrasi Izin dan Cuti)</h6>
        <hr />

        <div class="row row-cols-12">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelRegisterKeluar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detil-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-show me-1 font-22 text-info"></i>
                </div>
                <h5 class="mb-0 text-info" id="v_judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <dl>
                        <dt>TANGGAL IZIN</dt>
                        <dd>
                            <div id="v_tgl_izin">
                        </dd>
                        <dt>JAM MULAI</dt>
                        <dd>
                            <div id="v_jam_mulai">
                        </dd>
                        <dt>JAM SELESAI</dt>
                        <dd>
                            <div id="v_jam_selesai">
                        </dd>
                        <dt>ALASAN IZIN</dt>
                        <dd>
                            <div id="v_alasan">
                        </dd>
                        <dt>STATUS IZIN</dt>
                        <dd>
                            <div id="v_status">
                        </dd>
                        <dt>KETERANGAN</dt>
                        <dd>
                            <div id="v_ket">
                        </dd>
                    </dl>
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
        loadTabelRegisterKeluar();
    });
</script>