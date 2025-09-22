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
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan Sisa Cuti Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">REGISTER SISA CUTI PEGAWAI</h6>
        <hr />

        <div class="col">
            <div class="card border-primary border-top border-3 border-0">
                <div class="card-header text-end">
                    <button type="button" class="btn btn-outline-primary px-5" onclick="GenerateCuti()"><i
                            class="bx bx-add-to-queue mr-1"></i>Inisialisasi Cuti</button>
                </div>
                <div class="card-body">
                    <div class="card-body" id="tabelSisaCuti">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fetchSisaCuti();
    });
</script>