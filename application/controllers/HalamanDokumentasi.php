<?php

class HalamanDokumentasi extends MY_Controller
{
    public function index()
    {
        $data['peran'] = $this->session->userdata('peran');
        $data['page'] = 'dokumentasi';

        $this->load->view('dokumentasi', $data);
    }

    public function get_content()
    {
        $section = $this->input->get('section');
        
        $content = $this->get_documentation_content($section);
        
        echo json_encode($content);
    }

    private function get_documentation_content($section)
    {
        switch ($section) {
            case 'pendahuluan':
                return $this->section_pendahuluan();
            case 'arsitektur':
                return $this->section_arsitektur();
            case 'struktur':
                return $this->section_struktur();
            case 'konvensi':
                return $this->section_konvensi();
            case 'flow':
                return $this->section_flow();
            case 'api':
                return $this->section_api();
            case 'setup':
                return $this->section_setup();
            case 'development':
                return $this->section_development();
            case 'troubleshooting':
                return $this->section_troubleshooting();
            case 'maintenance':
                return $this->section_maintenance();
            default:
                return $this->section_pendahuluan();
        }
    }

    private function section_pendahuluan()
    {
        return [
            'title' => '1. PENDAHULUAN',
            'content' => '
                <h3>1.1 Tentang SEUDATI</h3>
                <p>SEUDATI (Sistem Elektronik Urusan Data Absensi dan Izin) adalah aplikasi berbasis web yang digunakan untuk mengelola permohonan izin (keluar kantor dan diklat/bimtek) serta cuti pegawai di lingkungan Mahkamah Syar\'iyah Banda Aceh.</p>
                
                <h3>1.2 Fitur Utama</h3>
                <ul>
                    <li><strong>Manajemen Izin Keluar Kantor</strong>: Pengajuan dan validasi izin keluar kantor</li>
                    <li><strong>Manajemen Izin Diklat/Bimtek</strong>: Pengajuan, validasi, dan verifikasi izin diklat/bimtek</li>
                    <li><strong>Manajemen Cuti</strong>: Pengajuan dan validasi cuti (tahunan, sakit, melahirkan, besar, dll)</li>
                    <li><strong>Upload Dokumen Pendukung</strong>: Upload dokumen untuk cuti sakit dan cuti alasan penting (maks 5MB)</li>
                    <li><strong>Kalender Cuti & Izin Keluar</strong>: Visualisasi cuti dan izin keluar dalam bentuk kalender interaktif</li>
                    <li><strong>Informasi Sisa Cuti</strong>: Menampilkan sisa cuti tahunan, cuti sakit, dan cuti alasan penting</li>
                    <li><strong>Sistem Notifikasi</strong>: Notifikasi otomatis via sistem</li>
                    <li><strong>Laporan & Register</strong>: Laporan periodik dan register permohonan</li>
                    <li><strong>Manajemen Peran</strong>: Pengelolaan hak akses berdasarkan peran</li>
                    <li><strong>Single Sign-On (SSO)</strong>: Terintegrasi dengan sistem SSO pusat</li>
                </ul>

                <h3>1.3 Peran Pengguna</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Peran</th>
                                <th>Deskripsi</th>
                                <th>Hak Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">Admin</span></td>
                                <td>Administrator sistem</td>
                                <td>Akses penuh, verifikasi dokumen, manajemen peran</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">Operator</span></td>
                                <td>Operator sistem</td>
                                <td>Akses laporan dan register</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">Pegawai</span></td>
                                <td>Pegawai biasa</td>
                                <td>Pengajuan izin/cuti, validasi (jika atasan)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info">Atasan</span></td>
                                <td>Pejabat atasan</td>
                                <td>Validasi permohonan bawahan</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">PPK</span></td>
                                <td>Pejabat Pembina Kepegawaian</td>
                                <td>Validasi final cuti</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>1.4 Teknologi yang Digunakan</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Komponen</th>
                                <th>Teknologi</th>
                                <th>Versi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Framework Backend</td>
                                <td>CodeIgniter</td>
                                <td>3.x</td>
                            </tr>
                            <tr>
                                <td>Frontend Framework</td>
                                <td>Bootstrap</td>
                                <td>5.x</td>
                            </tr>
                            <tr>
                                <td>JavaScript Library</td>
                                <td>jQuery</td>
                                <td>3.x</td>
                            </tr>
                            <tr>
                                <td>Database</td>
                                <td>MySQL/MariaDB</td>
                                <td>5.7+</td>
                            </tr>
                            <tr>
                                <td>QR Code Generator</td>
                                <td>Endroid QR Code</td>
                                <td>Latest</td>
                            </tr>
                            <tr>
                                <td>PDF Viewer</td>
                                <td>PDF.js</td>
                                <td>Latest</td>
                            </tr>
                            <tr>
                                <td>Calendar Library</td>
                                <td>FullCalendar.js</td>
                                <td>6.x</td>
                            </tr>
                            <tr>
                                <td>Date Picker</td>
                                <td>Flatpickr</td>
                                <td>Latest</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            '
        ];
    }

    private function section_arsitektur()
    {
        return [
            'title' => '2. ARSITEKTUR SISTEM',
            'content' => '
                <h3>2.1 Arsitektur Umum</h3>
                <p>SEUDATI menggunakan arsitektur <strong>MVC (Model-View-Controller)</strong> yang merupakan pola desain standar dari framework CodeIgniter.</p>
                
                <div class="alert alert-info">
                    <h5><i class="bx bx-info-circle"></i> Komponen Utama:</h5>
                    <ul class="mb-0">
                        <li><strong>Model</strong>: Menangani logika data dan interaksi dengan database</li>
                        <li><strong>View</strong>: Menampilkan user interface (HTML/CSS/JavaScript)</li>
                        <li><strong>Controller</strong>: Mengatur alur aplikasi dan business logic</li>
                    </ul>
                </div>

                <h3>2.2 Komponen Aplikasi</h3>
                <h4>A. Controllers</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>File</th>
                                <th>Fungsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>HalamanUtama.php</code></td>
                                <td>Dashboard, statistik, manajemen peran</td>
                            </tr>
                            <tr>
                                <td><code>HalamanIzin.php</code></td>
                                <td>Izin keluar kantor dan diklat/bimtek</td>
                            </tr>
                            <tr>
                                <td><code>HalamanCuti.php</code></td>
                                <td>Manajemen cuti (pengajuan & validasi)</td>
                            </tr>
                            <tr>
                                <td><code>HalamanLaporan.php</code></td>
                                <td>Laporan dan register</td>
                            </tr>
                            <tr>
                                <td><code>HalamanPengaturan.php</code></td>
                                <td>Pengaturan sistem (libur, sisa cuti)</td>
                            </tr>
                            <tr>
                                <td><code>HalamanPanduan.php</code></td>
                                <td>Panduan penggunaan</td>
                            </tr>
                            <tr>
                                <td><code>MY_Controller.php</code></td>
                                <td>Base controller dengan SSO authentication</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>B. Libraries</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Library</th>
                                <th>Fungsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>ApiHelper.php</code></td>
                                <td>Komunikasi HTTP dengan SSO Server (GET, POST, PATCH)</td>
                            </tr>
                            <tr>
                                <td><code>TanggalHelper.php</code></td>
                                <td>Manipulasi dan format tanggal Indonesia</td>
                            </tr>
                            <tr>
                                <td><code>QRHelper.php</code></td>
                                <td>Generate QR Code untuk tanda tangan digital</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>2.3 Database Architecture</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Database Lokal (SEUDATI)</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Menyimpan data transaksi:</strong></p>
                                <ul>
                                    <li><code>register_izin_keluar</code> - Data izin keluar kantor</li>
                                    <li><code>register_izin_diklat</code> - Data izin diklat/bimtek</li>
                                    <li><code>register_cuti</code> - Data permohonan cuti (termasuk kolom dokumen_pendukung)</li>
                                    <li><code>register_sisa_cuti_tahunan</code> - Sisa cuti tahunan pegawai</li>
                                    <li><code>register_catatan_cuti</code> - Catatan cuti (cuti_sakit, cuti_alasan_penting, dll)</li>
                                    <li><code>register_hari_libur</code> - Data hari libur nasional</li>
                                    <li><code>peran</code> - Manajemen peran pengguna</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Database SSO (Remote)</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Data master via API:</strong></p>
                                <ul>
                                    <li><code>v_users</code> (VIEW)</li>
                                    <li><code>v_pegawai</code> (VIEW)</li>
                                    <li><code>v_plh</code> (VIEW)</li>
                                    <li><code>ref_jabatan</code></li>
                                    <li><code>sys_notif</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            '
        ];
    }

    private function section_struktur()
    {
        return [
            'title' => '3. STRUKTUR PROJECT',
            'content' => '
                <h3>3.1 Struktur Direktori</h3>
                <pre class="bg-light p-3 border rounded"><code>seudati/
├── application/
│   ├── config/           # File konfigurasi
│   ├── controllers/      # Controller files
│   ├── core/            # Core extensions
│   ├── libraries/       # Custom libraries
│   ├── models/          # Model files
│   └── views/           # View templates
├── assets/
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript
│   ├── plugins/        # Third-party plugins
│   └── dokumen/        # Upload dokumen (cuti, diklat)
│       ├── cuti/       # Dokumen pendukung cuti sakit & alasan penting
│       └── diklat/     # Dokumen diklat (ST, sertifikat)
├── system/             # CodeIgniter core
└── vendor/             # Composer packages</code></pre>

                <h3>3.2 File Konfigurasi Penting</h3>
                <div class="accordion" id="accordionConfig">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConfig">
                                <i class="bx bx-file me-2"></i> application/config/config.php
                            </button>
                        </h2>
                        <div id="collapseConfig" class="accordion-collapse collapse show" data-bs-parent="#accordionConfig">
                            <div class="accordion-body">
                                <pre class="bg-dark text-light p-3 rounded"><code>$config[\'base_url\'] = \'http://\' .$_SERVER[\'SERVER_NAME\'].\'/\';
$config[\'sso_server\'] = \'http://sso.ms-bandaaceh.local/\';
$config[\'id_app\'] = \'4\';  // ID aplikasi di SSO Server
$config[\'encryption_key\'] = \'M4hk4m4h@Bn4\';</code></pre>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRoutes">
                                <i class="bx bx-file me-2"></i> application/config/routes.php
                            </button>
                        </h2>
                        <div id="collapseRoutes" class="accordion-collapse collapse" data-bs-parent="#accordionConfig">
                            <div class="accordion-body">
                                <p>File ini mendefinisikan URL routing aplikasi.</p>
                                <p><strong>Format:</strong> <code>$route[\'url\'] = \'Controller/method\';</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            '
        ];
    }

    private function section_konvensi()
    {
        return [
            'title' => '4. KONVENSI PENULISAN KODE',
            'content' => '
                <h3>4.1 Naming Convention</h3>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Controllers</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Format:</strong> PascalCase dengan prefix "Halaman"</p>
                                <p><strong>Contoh:</strong></p>
                                <ul>
                                    <li><code>HalamanCuti</code></li>
                                    <li><code>HalamanIzin</code></li>
                                    <li><code>HalamanUtama</code></li>
                                </ul>
                                <p><strong>Methods:</strong> snake_case</p>
                                <ul>
                                    <li><code>show_cuti()</code></li>
                                    <li><code>simpan_cuti()</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Models</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Format:</strong> PascalCase</p>
                                <p><strong>Methods:</strong> snake_case</p>
                                <p><strong>Contoh:</strong></p>
                                <ul>
                                    <li><code>get_seleksi()</code></li>
                                    <li><code>simpan_data()</code></li>
                                    <li><code>pembaharuan_data()</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Variables</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Format:</strong> snake_case</p>
                                <p><strong>Contoh:</strong></p>
                                <ul>
                                    <li><code>$id_user</code></li>
                                    <li><code>$tgl_izin</code></li>
                                    <li><code>$status_permohonan</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Database Tables</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Prefix:</strong></p>
                                <ul>
                                    <li><code>register_</code> - transaksi</li>
                                    <li><code>v_</code> - view SSO</li>
                                    <li><code>ref_</code> - referensi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">4.2 Response Format</h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                Success (Code: 1)
                            </div>
                            <div class="card-body">
                                <pre class="mb-0"><code>{
  "success": 1,
  "message": "Berhasil"
}</code></pre>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                Validation Error (Code: 2)
                            </div>
                            <div class="card-body">
                                <pre class="mb-0"><code>{
  "success": 2,
  "message": "Field error"
}</code></pre>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                System Error (Code: 3)
                            </div>
                            <div class="card-body">
                                <pre class="mb-0"><code>{
  "success": 3,
  "message": "Gagal"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">4.3 Security Practices</h3>
                <div class="alert alert-danger">
                    <h5><i class="bx bx-shield"></i> ID Encryption</h5>
                    <p>Untuk keamanan, semua ID yang dikirim melalui URL atau AJAX di-encrypt:</p>
                    <pre class="bg-white text-dark p-2 rounded mb-0"><code>// Encrypt
$encrypted = base64_encode($this->encryption->encrypt($id));

// Decrypt  
$id = $this->encryption->decrypt(base64_decode($encrypted));</code></pre>
                </div>

                <div class="alert alert-warning">
                    <h5><i class="bx bx-trash"></i> Soft Delete</h5>
                    <p>Semua penghapusan data menggunakan soft delete (update field <code>hapus = 1</code>):</p>
                    <pre class="bg-white text-dark p-2 rounded mb-0"><code>$data = [
    \'hapus\' => \'1\',
    \'modified_by\' => $this->session->userdata(\'fullname\'),
    \'modified_on\' => date(\'Y-m-d H:i:s\')
];</code></pre>
                </div>
            '
        ];
    }

    private function section_flow()
    {
        return [
            'title' => '5. FLOW APLIKASI',
            'content' => '
                <h3>5.1 Flow Pengajuan Izin Keluar Kantor</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <span class="badge bg-primary">1</span>
                                <p>Pegawai membuka menu "Izin Keluar Kantor"</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-primary">2</span>
                                <p>Pegawai mengisi form (tanggal, jam mulai, jam selesai, alasan)</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-primary">3</span>
                                <p>Sistem validasi input dan cek atasan langsung</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-success">4</span>
                                <p>Data disimpan, notifikasi dikirim ke atasan</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-info">5</span>
                                <p>Atasan membuka "Validasi Izin Keluar" dan memvalidasi</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-success">6</span>
                                <p>Status diupdate, notifikasi ke pemohon</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-warning">7</span>
                                <p>Jika disetujui, pegawai dapat cetak surat izin</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">5.2 Flow Pengajuan Cuti</h3>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Proses 3 Tahap Validasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">Tahap 1: Atasan Langsung</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol class="small mb-0">
                                            <li>Pegawai ajukan cuti</li>
                                            <li>Atasan validasi</li>
                                            <li>Jika setuju → lanjut</li>
                                            <li>Jika tolak → selesai</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Tahap 2: PPK</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol class="small mb-0">
                                            <li>PPK terima permohonan</li>
                                            <li>PPK validasi</li>
                                            <li>Jika setuju → potong kuota</li>
                                            <li>Notif ke Admin</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">Tahap 3: Legalisasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol class="small mb-0">
                                            <li>Admin buka verifikasi</li>
                                            <li>Admin beri nomor cuti</li>
                                            <li>Status menjadi selesai</li>
                                            <li>Pegawai cetak formulir</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">5.3 Flow Pengajuan Cuti dengan Dokumen Pendukung</h3>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Cuti Sakit & Cuti Alasan Penting</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <span class="badge bg-primary">1</span>
                                <p>Pegawai membuka menu "Cuti" dan klik "Tambah Permohonan Cuti"</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-primary">2</span>
                                <p>Pegawai memilih jenis cuti: "Cuti Sakit" atau "Cuti Alasan Penting"</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-warning">3</span>
                                <p>Field "Dokumen Pendukung" muncul (wajib diisi)</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-primary">4</span>
                                <p>Pegawai upload dokumen (PDF/JPG/PNG, maks 5MB)</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-success">5</span>
                                <p>Sistem validasi file dan simpan ke folder assets/dokumen/cuti/</p>
                            </div>
                            <div class="timeline-item">
                                <span class="badge bg-info">6</span>
                                <p>Permohonan diproses seperti cuti biasa (validasi atasan → PPK → legalisasi)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">5.4 Flow Pengajuan Izin Diklat/Bimtek</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tahap</th>
                                <th>Actor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pengajuan</td>
                                <td>Pegawai</td>
                                <td>Mengisi form dan pilih tujuan (Ketua/Sekretaris)</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Validasi</td>
                                <td>Ketua/Sekretaris</td>
                                <td>Setuju/tolak permohonan</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Upload ST</td>
                                <td>Admin</td>
                                <td>Upload Surat Tugas</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Upload Sertifikat</td>
                                <td>Pegawai</td>
                                <td>Upload sertifikat setelah diklat selesai</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            '
        ];
    }

    private function section_api()
    {
        return [
            'title' => '6. DOKUMENTASI API/ENDPOINT',
            'content' => '
                <h3>6.1 SSO API Endpoints</h3>
                <div class="alert alert-info">
                    <strong>Base URL:</strong> <code>http://sso.ms-bandaaceh.local/</code>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <strong>GET</strong> /api/cek_token
                    </div>
                    <div class="card-body">
                        <p><strong>Parameter:</strong> <code>sso_token={token}</code></p>
                        <p><strong>Response:</strong></p>
                        <pre class="bg-light p-2"><code>{
  "status": "success",
  "user": {
    "userid": "...",
    "status_plh": 0,
    "status_plt": 0
  }
}</code></pre>
                    </div>
                </div>

                <h3>6.2 SEUDATI Internal Routes</h3>
                <div class="accordion" id="accordionRoutes">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIzin">
                                Izin Keluar Kantor
                            </button>
                        </h2>
                        <div id="collapseIzin" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <ul>
                                    <li><code>GET /show_izin_keluar</code> - Form izin keluar</li>
                                    <li><code>POST /simpan_izin_keluar</code> - Simpan permohonan</li>
                                    <li><code>POST /simpan_validasi_izin_keluar</code> - Validasi atasan</li>
                                    <li><code>GET /cetak_izin/{id}</code> - Cetak surat izin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuti">
                                Cuti
                            </button>
                        </h2>
                        <div id="collapseCuti" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <ul>
                                    <li><code>POST /show_cuti</code> - Form cuti</li>
                                    <li><code>POST /simpan_cuti</code> - Simpan permohonan</li>
                                    <li><code>POST /simpan_validasi_cuti_atasan</code> - Validasi atasan</li>
                                    <li><code>POST /simpan_validasi_cuti_ppk</code> - Validasi PPK</li>
                                    <li><code>POST /simpan_nomor</code> - Legalisasi nomor</li>
                                    <li><code>GET /cetak_cuti/{id}</code> - Cetak formulir</li>
                                    <li><code>POST /simpan_cuti_admin</code> - Simpan cuti dari admin (dengan upload dokumen)</li>
                                    <li><code>GET /get_cuti_kalender</code> - Ambil data cuti dan izin keluar untuk kalender (AJAX)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKalender">
                                Kalender Cuti
                            </button>
                        </h2>
                        <div id="collapseKalender" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <ul>
                                    <li><code>GET /kalender_cuti</code> - Halaman kalender cuti</li>
                                    <li><code>GET /get_cuti_kalender?start={date}&end={date}</code> - API untuk mengambil data event kalender</li>
                                </ul>
                                <p class="mt-2"><strong>Response Format:</strong></p>
                                <pre class="bg-light p-2"><code>[{
  "id": "cuti-123",
  "title": "Nama Pegawai - Cuti Tahunan",
  "start": "2024-01-15",
  "end": "2024-01-20",
  "color": "#28a745",
  "extendedProps": {
    "tipe": "cuti",
    "nama": "Nama Pegawai",
    "jenis": "Cuti Tahunan",
    "nomor_cuti": "001/CUTI/2024",
    "alasan": "Alasan cuti"
  }
}]</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            '
        ];
    }

    private function section_setup()
    {
        return [
            'title' => '7. SETUP & DEPLOYMENT',
            'content' => '
                <h3>7.1 System Requirements</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Software Requirements</h5>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>PHP >= 7.4</li>
                                    <li>MySQL/MariaDB >= 5.7</li>
                                    <li>Apache/Nginx Web Server</li>
                                    <li>Composer</li>
                                    <li>PHP Extensions: mbstring, openssl, pdo_mysql, gd, curl</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Hardware Requirements</h5>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>RAM: 2GB (minimum)</li>
                                    <li>Storage: 10GB</li>
                                    <li>CPU: 2 Core</li>
                                    <li>Network: Stable internet connection</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">7.2 Installation Steps</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="step-wizard">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h5>Clone Project</h5>
                                    <pre class="bg-dark text-light p-2 rounded"><code>cd /var/www/html/
git clone [repository-url] seudati
cd seudati</code></pre>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h5>Install Dependencies</h5>
                                    <pre class="bg-dark text-light p-2 rounded"><code>composer install</code></pre>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h5>Create & Import Database</h5>
                                    <pre class="bg-dark text-light p-2 rounded"><code>CREATE DATABASE seudati;
mysql -u root -p seudati < database/schema.sql</code></pre>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h5>Configure Application</h5>
                                    <p>Edit <code>application/config/config.php</code> dan <code>database.php</code></p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">5</div>
                                <div class="step-content">
                                    <h5>Set Permissions</h5>
                                    <pre class="bg-dark text-light p-2 rounded"><code>chmod -R 755 /var/www/html/seudati
chmod -R 777 application/cache
chmod -R 777 application/logs
chmod -R 777 dokumen</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    <h5><i class="bx bx-info-circle"></i> Production Checklist</h5>
                    <ul class="mb-0">
                        <li>✅ Ubah <code>encryption_key</code> di config</li>
                        <li>✅ Set <code>log_threshold = 0</code></li>
                        <li>✅ Disable error display</li>
                        <li>✅ Enable HTTPS/SSL</li>
                        <li>✅ Set proper file permissions</li>
                        <li>✅ Setup automated backup</li>
                        <li>✅ Set permission 755 untuk folder assets/dokumen/cuti/</li>
                        <li>✅ Pastikan folder assets/dokumen/cuti/ dapat diakses untuk upload</li>
                        <li>✅ Jalankan script SQL untuk menambahkan kolom dokumen_pendukung</li>
                    </ul>
                </div>
            '
        ];
    }

    private function section_development()
    {
        return [
            'title' => '8. PANDUAN DEVELOPMENT',
            'content' => '
                <h3>8.1 Menambah Fitur Baru</h3>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Langkah-langkah Menambah Fitur</h5>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li><strong>Buat Controller Method</strong>
                                <pre class="bg-light p-2 mt-2"><code>// application/controllers/HalamanBaru.php
public function fitur_baru()
{
    // Logic di sini
}</code></pre>
                            </li>
                            <li><strong>Buat Route</strong>
                                <pre class="bg-light p-2 mt-2"><code>// application/config/routes.php
$route[\'fitur_baru\'] = \'HalamanBaru/fitur_baru\';</code></pre>
                            </li>
                            <li><strong>Buat View</strong>
                                <p class="mt-2">Buat file <code>application/views/fitur_baru.php</code></p>
                            </li>
                            <li><strong>Tambah Menu di Sidebar</strong>
                                <p class="mt-2">Edit <code>application/views/layout.php</code></p>
                            </li>
                            <li><strong>Tambah ke Allowed Pages</strong>
                                <p class="mt-2">Edit <code>HalamanUtama.php</code> method <code>page()</code></p>
                            </li>
                        </ol>
                    </div>
                </div>

                <h3 class="mt-4">8.2 Debugging</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Common Issues</h5>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li><strong>404 Not Found</strong>
                                        <ul class="small">
                                            <li>Cek .htaccess</li>
                                            <li>Cek mod_rewrite</li>
                                            <li>Cek route</li>
                                        </ul>
                                    </li>
                                    <li><strong>Blank Page</strong>
                                        <ul class="small">
                                            <li>Cek error di log</li>
                                            <li>Cek permission</li>
                                            <li>Cek syntax error</li>
                                        </ul>
                                    </li>
                                    <li><strong>SSO Login Loop</strong>
                                        <ul class="small">
                                            <li>Cek cookie domain</li>
                                            <li>Cek sso_token</li>
                                            <li>Cek koneksi SSO</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Enable Error Display</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Development Environment:</strong></p>
                                <pre class="bg-light p-2"><code>// index.php
error_reporting(E_ALL);
ini_set(\'display_errors\', 1);</code></pre>
                                <p class="mt-3"><strong>Check Logs:</strong></p>
                                <pre class="bg-light p-2"><code># Linux
tail -f application/logs/log-*.php

# Windows
# Cek folder: application/logs/</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">8.3 Git Workflow</h3>
                <div class="card">
                    <div class="card-body">
                        <pre class="bg-dark text-light p-3 rounded"><code># Create feature branch
git checkout -b feature/nama-fitur

# Develop & Commit
git add .
git commit -m "Add: nama fitur"

# Push
git push origin feature/nama-fitur

# Create Pull Request & Merge</code></pre>
                        <p class="mt-3"><strong>Commit Message Convention:</strong></p>
                        <ul>
                            <li><code>Add:</code> untuk fitur baru</li>
                            <li><code>Fix:</code> untuk bug fix</li>
                            <li><code>Update:</code> untuk improvement</li>
                            <li><code>Refactor:</code> untuk refactoring</li>
                            <li><code>Docs:</code> untuk dokumentasi</li>
                        </ul>
                    </div>
                </div>
            '
        ];
    }

    private function section_troubleshooting()
    {
        return [
            'title' => '9. TROUBLESHOOTING',
            'content' => '
                <h3>9.1 Common Problems & Solutions</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Problem</th>
                                <th>Penyebab</th>
                                <th>Solusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">Cannot login / SSO Loop</span></td>
                                <td>Cookie domain tidak match</td>
                                <td>Cek config cookie_domain harus sama dengan SSO</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">Upload file gagal</span></td>
                                <td>Permission folder salah</td>
                                <td>Set permission 777 untuk folder dokumen/</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">Database connection error</span></td>
                                <td>Kredensial salah</td>
                                <td>Cek file config/database.php</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">404 Not Found</span></td>
                                <td>mod_rewrite tidak aktif</td>
                                <td>Aktifkan mod_rewrite Apache</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">Blank page</span></td>
                                <td>PHP error</td>
                                <td>Cek error log di application/logs/</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="mt-4">9.2 Status Codes Reference</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Status Izin Keluar</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td><span class="badge bg-warning">0</span></td>
                                        <td>Diproses (pending)</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-success">1</span></td>
                                        <td>Disetujui (normal)</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">2</span></td>
                                        <td>Ditolak (normal)</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-success">3</span></td>
                                        <td>Disetujui (PLH/PLT)</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">4</span></td>
                                        <td>Ditolak (PLH/PLT)</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Jenis Cuti</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td><span class="badge bg-primary">1</span></td>
                                        <td>Cuti Tahunan</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">2</span></td>
                                        <td>Cuti Sakit</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">3</span></td>
                                        <td>Cuti Melahirkan</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">4</span></td>
                                        <td>Cuti Besar</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">5</span></td>
                                        <td>Cuti Alasan Penting</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">6</span></td>
                                        <td>Cuti Luar Tanggungan Negara</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">9.3 Database Schema Updates</h3>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Kolom Baru di Tabel register_cuti</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kolom</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>dokumen_pendukung</code></td>
                                    <td>VARCHAR(255)</td>
                                    <td>Nama file dokumen pendukung untuk cuti sakit dan cuti alasan penting</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-3"><strong>Script SQL:</strong></p>
                        <pre class="bg-light p-2"><code>ALTER TABLE `register_cuti` 
ADD COLUMN `dokumen_pendukung` VARCHAR(255) NULL DEFAULT NULL 
COMMENT \'Nama file dokumen pendukung untuk cuti sakit dan cuti alasan penting\' 
AFTER `alasan`;</code></pre>
                    </div>
                </div>

                <h3 class="mt-4">9.4 Upload File Configuration</h3>
                <div class="card">
                    <div class="card-body">
                        <p><strong>Konfigurasi Upload Dokumen Pendukung Cuti:</strong></p>
                        <ul>
                            <li><strong>Path:</strong> <code>./assets/dokumen/cuti/</code></li>
                            <li><strong>Allowed Types:</strong> pdf, jpg, jpeg, png</li>
                            <li><strong>Max Size:</strong> 5MB (5120 KB)</li>
                            <li><strong>File Naming:</strong> Encrypted (menggunakan CodeIgniter upload library dengan encrypt_name = TRUE)</li>
                            <li><strong>Auto Create Folder:</strong> Folder dibuat otomatis jika belum ada</li>
                        </ul>
                        <p class="mt-3"><strong>Contoh Kode:</strong></p>
                        <pre class="bg-light p-2"><code>$config[\'upload_path\'] = \'./assets/dokumen/cuti/\';
$config[\'allowed_types\'] = \'pdf|jpg|jpeg|png\';
$config[\'max_size\'] = 5120; // 5MB
$config[\'encrypt_name\'] = TRUE;</code></pre>
                    </div>
                </div>
            '
        ];
    }

    private function section_maintenance()
    {
        return [
            'title' => '10. MAINTENANCE & UPDATE',
            'content' => '
                <h3>10.1 Regular Maintenance</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5><i class="bx bx-time"></i> Daily</h5>
                                <ul class="small mb-0">
                                    <li>Monitor error logs</li>
                                    <li>Check disk space</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5><i class="bx bx-calendar"></i> Weekly</h5>
                                <ul class="small mb-0">
                                    <li>Backup database</li>
                                    <li>Review pending requests</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5><i class="bx bx-calendar-week"></i> Monthly</h5>
                                <ul class="small mb-0">
                                    <li>Clear old logs</li>
                                    <li>Update dependencies</li>
                                    <li>Optimize database</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5><i class="bx bx-calendar-star"></i> Yearly</h5>
                                <ul class="small mb-0">
                                    <li>Generate sisa cuti</li>
                                    <li>Input libur nasional</li>
                                    <li>Archive old data</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4">10.2 Backup Procedures</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bx bx-data"></i> Database Backup</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Manual Backup:</strong></p>
                                <pre class="bg-light p-2"><code>mysqldump -u root -p seudati > backup/seudati_$(date +%Y%m%d).sql</code></pre>
                                <p class="mt-3"><strong>Automated (Crontab):</strong></p>
                                <pre class="bg-light p-2"><code>0 2 * * * mysqldump -u root -ppassword seudati > /backup/seudati_$(date +\%Y\%m\%d).sql</code></pre>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bx bx-folder"></i> File Backup</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Backup Dokumen:</strong></p>
                                <pre class="bg-light p-2"><code>tar -czf backup/dokumen_$(date +%Y%m%d).tar.gz dokumen/</code></pre>
                                <p class="mt-3"><strong>Full Backup:</strong></p>
                                <pre class="bg-light p-2"><code>tar -czf backup/seudati_full_$(date +%Y%m%d).tar.gz .</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-danger mt-4">
                    <h5><i class="bx bx-shield"></i> Security Best Practices</h5>
                    <ul class="mb-0">
                        <li>✓ Gunakan HTTPS/SSL untuk production</li>
                        <li>✓ Update dependencies secara berkala</li>
                        <li>✓ Set strong encryption key</li>
                        <li>✓ Disable error display di production</li>
                        <li>✓ Implement rate limiting</li>
                        <li>✓ Regular security audit</li>
                    </ul>
                </div>

                <div class="alert alert-success">
                    <h5><i class="bx bx-info-circle"></i> Kontak & Support</h5>
                    <p><strong>Developer Contact:</strong></p>
                    <ul class="mb-0">
                        <li>Email: dev@ms-bandaaceh.go.id</li>
                        <li>Helpdesk: IT Support Mahkamah Syar\'iyah Banda Aceh</li>
                    </ul>
                </div>
            '
        ];
    }
}

