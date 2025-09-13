<style>
    .disabled-date {
        background-color: #eee !important;
        color: #888 !important;
        pointer-events: none;
        /* tidak bisa diklik langsung */
    }

    .tanggal-merah {
        background-color: #ffcccc !important;
        color: red !important;
        font-weight: bold;
    }
</style>
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
                        <li class="breadcrumb-item active" aria-current="page">Permohonan Cuti</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">SEUDATI (Sistem Elektronik untuk Administrasi Izin dan Cuti)</h6>
        <hr />

        <div class="card radius-10">
            <div class="card-content">
                <div class="row row-group row-cols-1 row-cols-xl-3">
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Seluruh Permohonan</p>
                                    <h4 class="mb-0 text-primary" id="jum_cuti_user"></h4>
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
                                    <h4 class="mb-0 text-success" id="jum_cuti_user_setuju"></h4>
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
                                    <h4 class="mb-0 text-danger" id='jum_cuti_user_tolak'></h4>
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
                        <div class="card-header text-end">
                            <button type="button" class="btn btn-outline-primary px-5" data-bs-toggle="modal"
                                data-bs-target="#tambah-modal"
                                onclick="BukaModalCuti('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                                    class="bx bx-user mr-1"></i>Tambah</button>
                        </div>
                        <div class="card-body" id="tabelCuti">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tambah-modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form method="POST" id="formCuti" class="modal-content">
                    <div class="modal-header">
                        <div>
                            <i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary" id="judul"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id_cuti_" class="form-control" />
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="card radius-10">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div
                                                    class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3">
                                                    <i class="bx bx-calendar-check"></i>
                                                </div>
                                                <h4 class="my-1" id="kuota_show"></h4>
                                                <p class="mb-0 text-secondary">Cuti Bisa Diambil</p>
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
                                        <input type="text" id="alamat" name="alamat" class="form-control"
                                            autocomplete="off" placeholder="Alamat Selama Cuti"></input>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="alasan" class="form-label">Alasan Cuti </label><code>*</code>
                                        <textarea id="alasan" class="form-control" rows="2" name="alasan"
                                            placeholder="Alasan Cuti"></textarea>
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

    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelCuti();
        loadStatistikCuti();
    });

    var config = {
        masa_kerja: '<?= $this->session->userdata('masa_kerja') ?>',
        id_grup: '<?= $this->session->userdata('id_grup') ?>',
        jk: '<?= $this->session->userdata('jk') ?>'
    };
</script>