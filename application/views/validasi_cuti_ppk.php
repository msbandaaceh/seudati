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
                        <li class="breadcrumb-item active" aria-current="page"> Validasi Permohonan Cuti</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">VALIDASI PERMOHONAN CUTI</h6>
        <hr />

        <div class="card radius-10">
            <div class="card-content">
                <div class="row row-group row-cols-2 row-cols-xl-2">
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Seluruh Permohonan</p>
                                    <h4 class="mb-0 text-primary" id="jum_validasi_cuti"></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user font-35 text-primary"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-primary" id="pgrs_all" role="progressbar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Permohonan Sudah Proses</p>
                                    <h4 class="mb-0 text-success" id="jum_validasi_cuti_proses"></h4>
                                </div>
                                <div class="ms-auto"><i class="bx bx-user-check font-35 text-success"></i>
                                </div>
                            </div>
                            <div class="progress radius-10 my-2" style="height:4px;">
                                <div class="progress-bar bg-success" id="pgrs_proses" role="progressbar"></div>
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
                        <div class="card-body" id="tabelValidasiCutiPPK">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tambah-modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form method="POST" id="formValidasiCutiPPK" class="modal-content">
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
                                    <label for="nama" class="form-label">Nama Pegawai </label>
                                    <input type="text" id="nama" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nip" class="form-label">NIP Pegawai </label>
                                    <input type="text" id="nip" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="jabatan" class="form-label">Jabatan Pegawai </label>
                                    <input type="text" id="jabatan" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="jenis" class="form-label">Jenis Cuti </label>
                                    <input type="text" id="jenis" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai Cuti </label>
                                    <input type="text" id="tgl_mulai" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tgl_selesai" class="form-label">Tanggal Selesai Cuti</label>
                                    <input type="text" id="tgl_selesai" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="alamat" class="form-label">Alamat Selama Cuti </label>
                                    <input type="text" id="alamat" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="alasan" class="form-label">Alasan Cuti </label>
                                    <textarea id="alasan" class="form-control" rows="2" readonly></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="status_valid" class="form-label">Proses Cuti <code>*</code></label>
                                    <select class="form-control" name="status_valid"
                                        id="status_valid_cuti" onchange="showHide(this.value)">
                                        <option value='0' selected disabled>Pilih Jenis Proses</option>
                                        <option value='1'>Setuju</option>
                                        <option value='2'>Perubahan</option>
                                        <option value='3'>Tangguhkan</option>
                                        <option value='4'>Tidak Setuju</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-group" id="keterangan" style="display:none">
                                        <label for="ket" class="form-label">KETERANGAN <code>*</code></label>
                                        <textarea id="ket" class="form-control" rows="2" name="ket"
                                            placeholder="Isi Keterangan Tidak Setuju"></textarea>
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
        loadTabelValidasiCutiPPK();
        loadStatistikValidasiCutiPPK();
    });
</script>