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
                    <div class="card-header text-end">
                        <button type="button" class="btn btn-outline-primary px-5" data-bs-toggle="modal"
                            data-bs-target="#tambah-modal"
                            onclick="BukaModalCutiAdmin('-1')"><i
                                class="bx bx-user mr-1"></i>Tambah</button>
                    </div>
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
                <div class="row g-3 mb-3" id="v_row_dokumen" style="display: none;">
                    <div class="col-12">
                        <label class="form-label">Dokumen Pendukung</label>
                        <div id="v_dokumen_pendukung_info"></div>
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

<div class="modal fade" id="tambah-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <form method="POST" id="formCutiAdmin" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-user me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary" id="judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <label for="pegawai" class="form-label">Pilih Pegawai </label><code>*</code>
                        <div id="pegawai_"></div>
                    </div>
                </div>
                <div class="form-group" id="isiform">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div
                                            class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3">
                                            <i class="bx bx-calendar-check"></i>
                                        </div>
                                        <h4 class="my-1" id="kuota_show"></h4>
                                        <p class="mb-0 text-secondary">Cuti Tahunan Bisa Diambil</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div
                                            class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3">
                                            <i class="bx bx-plus-medical"></i>
                                        </div>
                                        <h4 class="my-1" id="cuti_sakit_show_admin"></h4>
                                        <p class="mb-0 text-secondary">Sisa Cuti Sakit Tahun Ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div
                                            class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3">
                                            <i class="bx bx-info-circle"></i>
                                        </div>
                                        <h4 class="my-1" id="cuti_alasan_penting_show_admin"></h4>
                                        <p class="mb-0 text-secondary">Sisa Cuti Alasan Penting Tahun Ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="kuota" id="kuota" class="form-control" />
                    <div class="row mb-3">
                        <div class="col">
                            <label for="jenis" class="form-label">Jenis Cuti </label><code>*</code>
                            <div id="jenis_"></div>
                        </div>
                    </div>
                    <div id="detil_cuti">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="tgl_cuti" class="form-label">Tanggal Cuti </label><code>*</code>
                                <input type="text" id="tgl_cuti" name="tgl_cuti" class="form-control"
                                    placeholder="Pilih Tanggal..." />
                                <input type="hidden" name="tgl_awal" id="tgl_awal" />
                                <input type="hidden" name="tgl_akhir" id="tgl_akhir" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="lama" class="form-label">Lama Cuti </label><code>*</code>
                                <input type="text" id="lama" name="lama" class="form-control"
                                    placeholder="Lama Hari Cuti" readonly></input>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="alamat" class="form-label">Alamat Selama Cuti </label><code>*</code>
                                <input type="text" id="alamat" name="alamat" class="form-control" autocomplete="off"
                                    placeholder="Alamat Selama Cuti"></input>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="alasan" class="form-label">Alasan Cuti </label><code>*</code>
                                <textarea id="alasan" class="form-control" rows="2" name="alasan"
                                    placeholder="Alasan Cuti"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3" id="row_dokumen_pendukung_admin" style="display: none;">
                            <div class="col">
                                <label for="dokumen_pendukung_admin" class="form-label">Dokumen Pendukung </label><code>*</code>
                                <input type="file" id="dokumen_pendukung_admin" name="dokumen_pendukung" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB</small>
                                <div id="preview_dokumen_admin" class="mt-2" style="display: none;">
                                    <p class="mb-1"><strong>File saat ini:</strong></p>
                                    <p class="mb-0" id="nama_file_sekarang_admin"></p>
                                </div>
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

<script>
    $(document).ready(function () {
        loadTabelRegisterCuti();
    });
</script>