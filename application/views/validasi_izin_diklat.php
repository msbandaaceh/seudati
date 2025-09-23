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
                        <li class="breadcrumb-item active" aria-current="page">Permohonan Izin Diklat</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">VALIDASI IZIN DIKLAT</h6>
        <hr />

        <div class="card radius-10">
            <div class="card-content">
                <div class="row row-group row-cols-md-2 row-cols-xl-4">
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Seluruh Permohonan</p>
                                    <h4 class="mb-0 text-primary" id="jum_diklat_user"></h4>
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
                                    <h4 class="mb-0 text-warning" id="jum_diklat_user_setuju"></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user-voice font-35 text-warning"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Permohonan Selesai</p>
                                    <h4 class="mb-0 text-success" id="jum_diklat_user_selesai"></h4>
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
                                    <h4 class="mb-0 text-danger" id='jum_diklat_user_tolak'></h4>
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
                        <div class="card-body" id="tabelValidasiDiklat">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="proses" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <form method="POST" id="formValidasiIzinDiklat" class="modal-content">
                    <div class="modal-header">
                        <div>
                            <i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary" id="judul"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" name="id" id="id_diklat_" class="form-control" />
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label for="nama" class="form-label">Nama Pegawai </label>
                                    <input type="text" class="form-control" id="nama" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="jenis" class="form-label">Jenis Permohonan </label>
                                    <input type="text" class="form-control mt-2" id="jenis" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama_diklat" class="form-label">Nama Diklat/Bimtek </label>
                                    <input type="text" class="form-control" id="nama_diklat" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai </label>
                                    <input type="text" id="tgl_mulai" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_selesai" class="form-label">Tanggal Mulai </label>
                                    <input type="text" id="tgl_selesai" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="status" class="form-label">Proses Permohonan <code>*</code></label>
                                    <select class="form-control" name="status" id="status"
                                        onchange="showHide(this.value)">
                                        <option value='1'>Setuju</option>
                                        <option value='2'>Belum Setuju</option>
                                    </select>
                                </div>
                            </div>

                            <div id="keterangan" style="display:none">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="ket" id="label_ket" name="label_ket" class="form-label">Keterangan
                                            <code>*</code></label>
                                        <textarea id="ket" class="form-control" rows="2" name="ket"
                                            placeholder="Berikan Keterangan Ditolak"></textarea>
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
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelValidasiDiklat();
        loadStatistikValidasiDiklat();
    });
</script>