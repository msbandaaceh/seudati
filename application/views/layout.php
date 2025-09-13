<!DOCTYPE html>
<html lang="id" class="color-sidebar sidebarcolor5 color-header headercolor1">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi SEUDATI (Sistem Elektronik Untuk Administrasi Izin dan Cuti)">
    <title><?= $this->session->userdata('nama_client_app') ?> | <?= $this->session->userdata('deskripsi_client_app') ?>
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= site_url('assets/images/icons/scroll.ico'); ?>" />

    <!--plugins-->
    <link href="assets/plugins/notifications/css/lobibox.min.css" rel="stylesheet" />
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="assets/plugins/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/css/dark-theme.css" />
    <link rel="stylesheet" href="assets/css/semi-dark.css" />
    <link rel="stylesheet" href="assets/css/header-colors.css" />

    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            50% {
                transform: translateX(4px);
            }

            75% {
                transform: translateX(-4px);
            }
        }

        .shake-badge {
            animation: shake 0.5s infinite;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="assets/images/scroll.png" class="logo-icon" height="auto" width="100%" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">SEUDATI</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="javascript:;" data-page="dashboard">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Beranda</div>
                    </a>
                </li>

                <?php
                if (in_array($peran, ['admin'])) {
                    ?>
                    <li class="menu-label">Proses Verifikasi</li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class='bx bx-fingerprint'></i>
                            </div>
                            <div class="menu-title">Verifikasi</div>&nbsp;
                            <p class="mb-0" id="jum_req_legal"></p>
                        </a>

                        <ul>
                            <li><a href="javascript:;" data-page="legal_diklat">
                                    <i class="bx bx-paperclip"></i>Verifikasi
                                    Diklat
                                    <span class="badge bg-warning text-dark ms-auto" id="jum_req_legal_diklat"></span>
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="legal_cuti">
                                    <i class="bx bx-barcode-reader"></i>
                                    Verifikasi Cuti
                                    <span class="badge bg-warning text-dark ms-auto" id="jum_req_legal_cuti"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }

                if ($this->session->userdata('jab_id') != '1') {
                    ?>
                    <li class="menu-label">Pengajuan Permohonan</li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class='bx bx-edit'></i>
                            </div>
                            <div class="menu-title">Izin</div>
                        </a>

                        <ul>
                            <li><a href="javascript:;" data-page="izin_keluar">
                                    <i class="bx bx-log-out"></i>
                                    Keluar Kantor
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="izin_diklat">
                                    <i class="bx bx-book-reader"></i>Diklat/Bimtek</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:;" data-page="cuti">
                            <div class="parent-icon"><i class='bx bx-calendar-event'></i>
                            </div>
                            <div class="menu-title">Cuti</div>
                        </a>
                    </li>
                <?php } ?>

                <li class="menu-label">Validasi Permohonan</li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-user-check'></i>
                        </div>
                        <div class="menu-title">Izin</div>&nbsp;
                        <p class="mb-0" id="jum_req_izin"></p>
                    </a>

                    <ul>
                        <li><a href="javascript:;" data-page="validasi_izin_keluar">
                                <i class="bx bx-log-out"></i>
                                Keluar Kantor
                                <span class="badge bg-warning text-dark ms-auto" id="jum_req_izin_keluar"></span>
                            </a>
                        </li>
                        <li><a href="javascript:;" data-page="validasi_izin_diklat">
                                <i class="bx bx-book-reader"></i>
                                Diklat/Bimtek
                                <span class="badge bg-warning text-dark ms-auto" id="jum_req_izin_diklat"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-calendar-check'></i>
                        </div>
                        <div class="menu-title">Cuti</div>
                        <p class="mb-0" id="jum_req_cuti"></p>
                    </a>
                    <ul>
                        <li><a href="javascript:;" data-page="validasi_cuti_atasan">
                                <i class="bx bx-upvote"></i>
                                Atasan
                                <span class="badge bg-warning text-dark ms-auto" id="jum_req_cuti_atasan"></span>
                            </a>
                        </li>
                        <li><a href="javascript:;" data-page="validasi_cuti_ppk">
                                <i class="bx bx-user-circle"></i>
                                PPK
                                <span class="badge bg-warning text-dark ms-auto" id="jum_req_cuti_ppk"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                if (in_array($peran, ['admin', 'operator'])) {
                    ?>
                    <li class="menu-label">Laporan</li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class='bx bx-list-ol'></i>
                            </div>
                            <div class="menu-title">Register</div>
                        </a>
                        <ul>
                            <li><a href="javascript:;" data-page="register_izin_keluar">
                                    <i class="bx bx-log-out"></i>
                                    Izin Keluar
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="register_izin_diklat">
                                    <i class="bx bx-book-reader"></i>
                                    Izin Diklat
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="register_cuti">
                                    <i class="bx bx-calendar-check"></i>
                                    Cuti
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class='bx bx-folder'></i>
                            </div>
                            <div class="menu-title">Laporan</div>
                        </a>
                        <ul>
                            <li><a href="javascript:;" data-page="laporan_izin_keluar">
                                    <i class="bx bx-log-out"></i>
                                    Izin Keluar
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="laporan_izin_diklat">
                                    <i class="bx bx-book-reader"></i>
                                    Izin Diklat
                                </a>
                            </li>
                            <li><a href="javascript:;" data-page="laporan_cuti">
                                    <i class="bx bx-calendar-check"></i>
                                    Cuti
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }

                if (in_array($peran, ['admin', 'operator'])) {
                    ?>
                    <li class="menu-label">Pengaturan</li>
                    <li><a href="javascript:;" data-page="tgl_merah">
                            <div class="parent-icon"><i class="bx bx-calendar-event"></i></div>
                            <div class="menu-title">Libur Nasional</div>
                        </a>
                    </li>
                    <li><a href="javascript:;" data-page="sisa_cuti">
                            <div class="parent-icon"><i class="bx bx-bar-chart-alt-2"></i></div>
                            <div class="menu-title">Sisa Cuti</div>
                        </a>
                    </li>
                <?php } ?>
                <!--end navigation-->
            </ul>
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <?php
                    if (in_array($peran, ['admin'])) {
                        ?>
                        <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                        </div>
                        <div class="top-menu ms-auto">
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item dropdown dropdown-large">
                                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Click for Setting"> <i
                                            class='bx bx-category'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="row row-cols-3 g-3 p-3">
                                            <div class="col text-center">
                                                <div class="app-box mx-auto bg-gradient-cosmic text-white"><i
                                                        class='bx bx-group' onclick="ModalRole('-1')"></i>
                                                </div>
                                                <div class="app-title">Peran</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                        </div>
                        <div class="top-menu ms-auto">
                        </div>
                    <?php } ?>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $this->session->userdata('foto') ?>" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?= $this->session->userdata('fullname') ?></p>
                                <p class="designattion mb-0"><?= $this->session->userdata('jabatan') ?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="keluar"><i
                                        class='bx bx-log-out-circle'></i><span>Keluar</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->

        <div id="app">Memuat...</div>

        <div class="modal fade" id="role-pegawai" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="card card-default">
                    <div class="modal-content">
                        <div class="overlay" id="overlay">
                            <i class="fas fa-2x fa-sync fa-spin"></i>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="judul">Daftar Petugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form method="POST" id="formPeran">
                            <input type="hidden" id="id" name="id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-label">Pilih Pegawai : </label>
                                    <div id="pegawai_">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pilih Peran : </label>
                                    <div id="peran_"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" id="btnBatal" onclick="ModalRole('-1')"
                                    class="btn btn-danger">Batal</button>
                            </div>
                        </form>
                        <div class="modal-body" id="tabel-role"></div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2025. All right reserved.</p>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins JS-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js" defer></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/flatpickr/flatpickr.js"></script>
    <script src="assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>
    <script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>

    <!--app JS-->
    <script src="assets/js/app.js"></script>

    <?php
    if ($this->session->flashdata('info')) {
        $result = $this->session->flashdata('info');
        if ($result == '1') {
            $pesan = $this->session->flashdata('pesan_sukses');
        } elseif ($result == '2') {
            $pesan = $this->session->flashdata('pesan_gagal');
        } else {
            $pesan = $this->session->flashdata('pesan_gagal');
        }
    } else {
        $result = "-1";
        $pesan = "";
    }
    ?>

    <script>
        $(document).ready(function () {
            // Load page
            loadPage('dashboard');

            // Navigasi SPA
            $('[data-page]').on('click', function (e) {
                e.preventDefault();
                let page = $(this).data('page');
                fetchRequestIzin();
                var legal = document.getElementById('jum_req_legal');
                if (legal) {
                    fetchRequestLegalisasi();
                }
                loadPage(page);
            });

            let jabatan = '<?= $peran ?>';
            const peran = ['1', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

            //if (peran.includes(jabatan)) {
            //    getNotif();
            //    setInterval(getNotif, 50000);
            //}
        });
    </script>

    <script type="text/javascript">
        var config = {
            result: '<?= $result ?>',
            pesan: '<?= $pesan ?>'
        };
    </script>

    <script src="<?= site_url('assets/js/seudati.js'); ?>"></script>
</body>

</html>