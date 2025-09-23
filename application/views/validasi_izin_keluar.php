<!--start page wrapper -->
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
                        <li class="breadcrumb-item active" aria-current="page">Validasi Izin Keluar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">VALIDASI IZIN KELUAR</h6>
        <hr />

        <div class="card radius-10">
            <div class="card-content">
                <div class="row row-group row-cols-1 row-cols-xl-3">
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Seluruh Permohonan</p>
                                    <h4 class="mb-0 text-primary" id="jum_izin_user"></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user font-35 text-primary"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Permohonan Setuju</p>
                                    <h4 class="mb-0 text-success" id="jum_izin_user_setuju"></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user-check font-35 text-success"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Permohonan Tolak</p>
                                    <h4 class="mb-0 text-danger" id='jum_izin_user_tolak'></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user-x font-35 text-danger"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-12">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelIzin">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="validasi" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <form method="POST" id="formValidasiIzinKeluar" class="modal-content">
                    <div class="modal-header">
                        <div>
                            <i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary" id="judul"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" name="id" id="id_keluar_" class="form-control" />
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_izin" class="form-label">Tanggal Izin </label>
                                    <input type="text" id="tgl_izin" name="tgl_izin" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="jam_mulai" class="form-label">Jam Mulai </label>
                                    <input type="text" id="jam_mulai" name="jam_mulai" class="form-control" disabled />
                                </div>
                                <div class="col-6">
                                    <label for="jam_selesai" class="form-label">Jam Selesai </label>
                                    <input type="text" class="form-control" id="jam_selesai"
                                        name="jam_selesai" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="alasan" class="form-label">Alasan Izin </label>
                                    <textarea id="alasan" class="form-control" rows="2" name="alasan"
                                        placeholder="Alasan Izin" disabled></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="status" class="form-label">PROSES IZIN <code>*</code></label>
                                    <select class="form-control" name="status" id="status"
                                        onchange="showHide(this.value)">
                                        <option value='0' selected disabled>Pilih Proses</option>
                                        <option value='1'>Setuju</option>
                                        <option value='2'>Tolak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-group" id="keterangan" style="display:none">
                                        <label for="ket" class="form-label">KETERANGAN <code>*</code></label>
                                        <textarea id="ket" class="form-control" rows="2" name="ket"
                                            placeholder="Keterangan Ditolak"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label for="submit" class="form-label"><code><i>* Wajib Diisi</i></code></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row justify-content-end">
                            <button id="submit" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="detil-modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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

    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelValidasiKeluar();
        loadStatistikValidasiKeluar();
    });
</script>