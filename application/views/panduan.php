<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Panduan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Panduan Penggunaan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h4 class="mb-0" id="judul-panduan">
                                    <i class='bx bx-book-open me-2'></i>Panduan Penggunaan
                                </h4>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 bg-light-info alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-20 text-info"><i class='bx bx-info-circle'></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-info">Informasi</h6>
                                    <div id="deskripsi-panduan">Panduan penggunaan sistem SEUDATI berdasarkan peran Anda.</div>
                                </div>
                            </div>
                        </div>

                        <div id="konten-panduan">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Memuat panduan...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        loadPanduan();
    });

    function loadPanduan() {
        $.ajax({
            url: '<?= site_url("get_panduan_content") ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                renderPanduan(response);
            },
            error: function () {
                $('#konten-panduan').html(
                    '<div class="alert alert-danger">' +
                    '<i class="bx bx-error me-2"></i>Gagal memuat panduan. Silakan refresh halaman.' +
                    '</div>'
                );
            }
        });
    }

    function renderPanduan(data) {
        $('#judul-panduan').html('<i class="bx bx-book-open me-2"></i>' + data.judul);
        $('#deskripsi-panduan').text(data.deskripsi);

        let html = '';

        data.menu.forEach(function (menu, index) {
            html += '<div class="card border shadow-none mb-3">';
            html += '<div class="card-header bg-light">';
            html += '<h5 class="mb-0">';
            if (menu.icon) {
                html += '<i class="' + menu.icon + ' me-2 text-primary"></i>';
            }
            html += '<strong>' + (index + 1) + '. ' + menu.nama + '</strong>';
            html += '</h5>';
            html += '</div>';
            html += '<div class="card-body">';
            
            if (menu.deskripsi) {
                html += '<p class="text-muted mb-3">' + menu.deskripsi + '</p>';
            }

            // Jika ada langkah langsung
            if (menu.langkah && menu.langkah.length > 0) {
                html += '<div class="ms-3">';
                html += '<h6 class="mb-2">Langkah-langkah:</h6>';
                html += '<ol class="mb-0">';
                menu.langkah.forEach(function (langkah) {
                    html += '<li class="mb-2">' + langkah + '</li>';
                });
                html += '</ol>';
                html += '</div>';
            }

            // Jika ada sub menu
            if (menu.sub_menu && menu.sub_menu.length > 0) {
                menu.sub_menu.forEach(function (sub, subIndex) {
                    html += '<div class="ms-3 mb-3">';
                    html += '<h6 class="text-primary mb-2">';
                    html += '<i class="bx bx-chevron-right"></i>' + (index + 1) + '.' + (subIndex + 1) + '. ' + sub.nama;
                    html += '</h6>';
                    
                    if (sub.langkah && sub.langkah.length > 0) {
                        html += '<ol type="a" class="mb-0">';
                        sub.langkah.forEach(function (langkah) {
                            html += '<li class="mb-2">' + langkah + '</li>';
                        });
                        html += '</ol>';
                    }
                    html += '</div>';
                });
            }

            html += '</div>';
            html += '</div>';
        });

        // Tambahkan informasi tambahan
        html += '<div class="card border-primary shadow-none">';
        html += '<div class="card-header bg-light-primary">';
        html += '<h5 class="mb-0 text-primary">';
        html += '<i class="bx bx-help-circle me-2"></i>Butuh Bantuan?';
        html += '</h5>';
        html += '</div>';
        html += '<div class="card-body">';
        html += '<p class="mb-2">Jika Anda mengalami kesulitan atau memiliki pertanyaan:</p>';
        html += '<ul class="mb-0">';
        html += '<li>Hubungi Administrator Sistem</li>';
        html += '<li>Hubungi Bagian Kepegawaian untuk masalah terkait cuti dan izin</li>';
        html += '<li>Pastikan browser Anda sudah update ke versi terbaru</li>';
        html += '</ul>';
        html += '</div>';
        html += '</div>';

        $('#konten-panduan').html(html);
    }
</script>

