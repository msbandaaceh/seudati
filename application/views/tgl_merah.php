<style>
    .disabled-date {
        background-color: #eee !important;
        color: #888 !important;
        /* tidak bisa diklik langsung */
    }

    .tanggal-merah {
        background-color: #ffcccc !important;
        color: red !important;
        font-weight: bold;
    }
</style>
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
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan Hari Libur Nasional</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">REGISTER TANGGAL MERAH</h6>
        <hr />

        <div class="col">
            <div class="card border-primary border-top border-3 border-0">
                <div class="card-header text-end">
                    <button type="button" class="btn btn-outline-primary px-5" data-bs-toggle="modal"
                        data-bs-target="#tambah-modal"
                        onclick="BukaModalLibur('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                            class="bx bx-user mr-1"></i>Tambah</button>
                </div>
                <div class="card-body">
                    <div class="card-body" id="tabelTanggalMerah">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formTanggalMerah" class="modal-content">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-user me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary" id="judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row mb-3">
                        <div class="col">
                            <label for="tgl_libur" class="form-label">Tanggal Hari Libur </label><code>*</code>
                            <input type="text" id="tgl_libur" name="tgl_libur" class="form-control"
                                placeholder="Pilih Tanggal..." />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="ket" class="form-label">Keterangan </label><code>*</code>
                            <textarea id="ket" class="form-control" rows="2" name="ket"
                                placeholder="contoh : Cuti Bersama Lebaran"></textarea>
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
        loadTabelHariLibur();
    });
</script>