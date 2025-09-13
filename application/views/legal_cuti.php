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
                        <li class="breadcrumb-item active" aria-current="page">Verifikasi Cuti</li>
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
                        <div class="card-body" id="tabelLegalisasi">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="nomor-modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="card card-default">
                    <form method="POST" id="formLegalCuti" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judul"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" class="form-control" />
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="nama" class="form-label">Nama Pegawai</label>
                                        <input type="text" name="nama" id="nama" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="nip" class="form-label">NIP Pegawai</label>
                                        <input type="text" name="nip" id="nip" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="jabatan" class="form-label">Jabatan Pegawai</label>
                                        <input type="text" name="jabatan" id="jabatan" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="jenis" class="form-label">Jenis Pegawai</label>
                                        <input type="text" name="jenis" id="jenis" class="form-control" disabled />
                                    </div>
                                </div>
                                <br />
                                <dt>PERHATIAN :</dt>
                                <dd>
                                    <ul>
                                        <li>Berikan Kode .../KMS.W...-A.../KP5.3/.../... untuk Jenis Pegawai Hakim, PNS,
                                            dan Calon Hakim</li>
                                        <li>Berikan Kode .../SEK.MS.W...-A.../KP5.3/.../... untuk Jenis Pegawai PPPK dan
                                            PPNPN</li>
                                    </ul>
                                </dd>

                                <div class="row g-2">
                                    <div class="col">
                                        <label for="nomor_cuti" class="form-label">Masukkan Nomor Surat Cuti</label><code> *</code>
                                        <input type="text" name="nomor_cuti" id="nomor_cuti" class="form-control" autocomplete="off"/>
                                    </div>
                                </div>
                                <label for="emailBackdrop" class="form-label"><code><i>* Wajib Diisi</i></code></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        loadTabelLegalisasi();
    });
</script>