<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dokumentasi</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dokumentasi Teknis</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <!-- Sidebar Menu -->
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bx bx-book-open me-2"></i>Daftar Isi</h5>
                        <div class="list-group list-group-flush">
                            <a href="javascript:;" onclick="loadSection('pendahuluan')" class="list-group-item list-group-item-action active" id="menu-pendahuluan">
                                <i class="bx bx-info-circle me-2"></i>1. Pendahuluan
                            </a>
                            <a href="javascript:;" onclick="loadSection('arsitektur')" class="list-group-item list-group-item-action" id="menu-arsitektur">
                                <i class="bx bx-sitemap me-2"></i>2. Arsitektur Sistem
                            </a>
                            <a href="javascript:;" onclick="loadSection('struktur')" class="list-group-item list-group-item-action" id="menu-struktur">
                                <i class="bx bx-folder me-2"></i>3. Struktur Project
                            </a>
                            <a href="javascript:;" onclick="loadSection('konvensi')" class="list-group-item list-group-item-action" id="menu-konvensi">
                                <i class="bx bx-code-alt me-2"></i>4. Konvensi Kode
                            </a>
                            <a href="javascript:;" onclick="loadSection('flow')" class="list-group-item list-group-item-action" id="menu-flow">
                                <i class="bx bx-git-branch me-2"></i>5. Flow Aplikasi
                            </a>
                            <a href="javascript:;" onclick="loadSection('api')" class="list-group-item list-group-item-action" id="menu-api">
                                <i class="bx bx-network-chart me-2"></i>6. API/Endpoint
                            </a>
                            <a href="javascript:;" onclick="loadSection('setup')" class="list-group-item list-group-item-action" id="menu-setup">
                                <i class="bx bx-cog me-2"></i>7. Setup & Deployment
                            </a>
                            <a href="javascript:;" onclick="loadSection('development')" class="list-group-item list-group-item-action" id="menu-development">
                                <i class="bx bx-code-block me-2"></i>8. Development
                            </a>
                            <a href="javascript:;" onclick="loadSection('troubleshooting')" class="list-group-item list-group-item-action" id="menu-troubleshooting">
                                <i class="bx bx-error me-2"></i>9. Troubleshooting
                            </a>
                            <a href="javascript:;" onclick="loadSection('maintenance')" class="list-group-item list-group-item-action" id="menu-maintenance">
                                <i class="bx bx-wrench me-2"></i>10. Maintenance
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0" id="content-title">
                                    <i class='bx bx-book me-2'></i>Dokumentasi Teknis SEUDATI
                                </h4>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-light" onclick="printDoc()">
                                    <i class="bx bx-printer me-1"></i>Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="doc-content">
                            <!-- Initial Loading -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Memuat dokumentasi...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 40px;
}
.timeline-item {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item:before {
    content: '';
    position: absolute;
    left: -28px;
    top: 25px;
    width: 2px;
    height: calc(100% - 10px);
    background: #ddd;
}
.timeline-item:last-child:before {
    display: none;
}
.timeline-item .badge {
    position: absolute;
    left: -40px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.step-wizard {
    counter-reset: step;
}
.step {
    display: flex;
    margin-bottom: 20px;
    align-items: flex-start;
}
.step-number {
    width: 40px;
    height: 40px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    flex-shrink: 0;
    margin-right: 15px;
}
.step-content {
    flex-grow: 1;
}
.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
pre code {
    font-size: 13px;
}
</style>

<script>
$(document).ready(function () {
    // Load default section
    loadSection('pendahuluan');
});

function loadSection(section) {
    // Update active menu
    $('.list-group-item').removeClass('active');
    $('#menu-' + section).addClass('active');

    // Show loading
    $('#doc-content').html(
        '<div class="text-center py-5">' +
        '<div class="spinner-border text-primary" role="status">' +
        '<span class="visually-hidden">Loading...</span>' +
        '</div>' +
        '<p class="mt-3">Memuat konten...</p>' +
        '</div>'
    );

    // Load content via AJAX
    $.ajax({
        url: '<?= site_url("get_doc_content") ?>',
        type: 'GET',
        data: { section: section },
        dataType: 'json',
        success: function (response) {
            $('#content-title').html('<i class="bx bx-book me-2"></i>' + response.title);
            $('#doc-content').html(response.content);
            
            // Scroll to top
            $('.page-content').animate({ scrollTop: 0 }, 'fast');
        },
        error: function () {
            $('#doc-content').html(
                '<div class="alert alert-danger">' +
                '<i class="bx bx-error me-2"></i>Gagal memuat konten dokumentasi.' +
                '</div>'
            );
        }
    });
}

function printDoc() {
    window.print();
}
</script>

<style media="print">
.sidebar-wrapper,
.topbar,
.page-breadcrumb,
.card-header button,
.list-group {
    display: none !important;
}
.page-content {
    margin: 0 !important;
    padding: 0 !important;
}
.card {
    border: none !important;
    box-shadow: none !important;
}
</style>

