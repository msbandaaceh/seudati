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
        <h6 class="mb-0 text-uppercase">SEUDATI (Sistem Elektronik untuk Administrasi Izin dan Cuti)</h6>
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
                        <div class="card-header text-end">
                            <button type="button" class="btn btn-outline-primary px-5" data-bs-toggle="modal"
                                data-bs-target="#tambah-modal"
                                onclick="BukaModalDiklat('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                                    class="bx bx-user mr-1"></i>Tambah</button>
                        </div>
                        <div class="card-body" id="tabelDiklat">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tambah-modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" id="formIzinDiklat" class="modal-content">
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
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tujuan" class="form-label">Tujuan Permohonan </label><code>*</code>
                                    <div id="tujuan_"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="jenis" class="form-label">Jenis Permohonan </label><code>*</code>
                                    <div id="jenis_"></div>
                                    <input type="text" style="display: none" name="jenis_nama" class="form-control mt-2"
                                        id="jenis_nama" placeholder="Masukkan Jenis Permohonan Lainnya"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama" class="form-label">Nama Diklat/Bimtek </label><code>*</code>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Masukkan Nama Diklat/Bimtek" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai </label><code>*</code>
                                    <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control"
                                        placeholder="Pilih Tanggal..." />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_selesai" class="form-label">Tanggal Mulai </label><code>*</code>
                                    <input type="text" id="tgl_selesai" name="tgl_selesai" class="form-control"
                                        placeholder="Pilih Tanggal..." />
                                </div>
                            </div>

                            <div class="row">
                                <label class="form-label"><code><i>* Wajib Diisi</i></code></label>
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

        <div class="modal fade" id="proses">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" id="formProgresDiklat" class="modal-content" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul_proses"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id_proses" class="form-control" />
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">PROSES DIKLAT/BIMTEK <code>*</code></label>
                            <select class="form-control" name="status" id="status">
                                <option value='1'>Lulus</option>
                                <option value='2'>Tidak Lulus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dokumen" class="form-label">SERTIFIKAT (JIKA LULUS)</label>
                            <input class="form-control" type="file" id="dokumen" accept="application/pdf" name="dokumen">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row justify-content-end">
                            <button id="submit" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelDiklat();
        loadStatistikDiklat();
    });
</script>