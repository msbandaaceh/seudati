<?php

class HalamanPanduan extends MY_Controller
{
    public function index()
    {
        $data['peran'] = $this->session->userdata('peran');
        $data['page'] = 'panduan';

        $this->load->view('panduan', $data);
    }

    public function get_panduan_content()
    {
        $peran = $this->session->userdata('peran');
        
        // Konten panduan berdasarkan peran
        $panduan = $this->get_panduan_by_role($peran);
        
        echo json_encode($panduan);
    }

    private function get_panduan_by_role($peran)
    {
        $panduan = [];

        // Panduan untuk Admin
        if ($peran == 'admin') {
            $panduan = [
                'judul' => 'Panduan Penggunaan - Administrator',
                'deskripsi' => 'Sebagai Administrator, Anda memiliki akses penuh ke seluruh fitur sistem SEUDATI.',
                'menu' => [
                    [
                        'nama' => 'Dashboard',
                        'icon' => 'bx bx-home-circle',
                        'deskripsi' => 'Halaman utama yang menampilkan statistik dan ringkasan data permohonan izin dan cuti.',
                        'langkah' => [
                            'Klik menu "Beranda" di sidebar',
                            'Lihat grafik dan statistik permohonan',
                            'Monitor status permohonan yang pending'
                        ]
                    ],
                    [
                        'nama' => 'Verifikasi Dokumen',
                        'icon' => 'bx bx-fingerprint',
                        'deskripsi' => 'Memverifikasi dan memberikan nomor pada dokumen izin diklat dan cuti yang sudah disetujui.',
                        'sub_menu' => [
                            [
                                'nama' => 'Verifikasi Diklat',
                                'langkah' => [
                                    'Klik menu "Verifikasi" > "Verifikasi Diklat"',
                                    'Pilih permohonan yang sudah disetujui',
                                    'Upload dokumen ST (Surat Tugas)',
                                    'Klik "Simpan" untuk menyelesaikan verifikasi'
                                ]
                            ],
                            [
                                'nama' => 'Verifikasi Cuti',
                                'langkah' => [
                                    'Klik menu "Verifikasi" > "Verifikasi Cuti"',
                                    'Pilih permohonan cuti yang sudah disetujui PPK',
                                    'Input nomor surat cuti',
                                    'Klik "Simpan" untuk legalisasi'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Laporan',
                        'icon' => 'bx bx-folder',
                        'deskripsi' => 'Mengakses laporan dan register dari semua permohonan izin dan cuti.',
                        'sub_menu' => [
                            [
                                'nama' => 'Register Izin/Cuti',
                                'langkah' => [
                                    'Klik menu "Register" > pilih jenis (Izin Keluar/Diklat/Cuti)',
                                    'Lihat daftar semua permohonan',
                                    'Gunakan filter untuk mencari data spesifik',
                                    'Untuk Register Cuti, admin dapat menambah cuti langsung dengan klik tombol "Tambah"'
                                ]
                            ],
                            [
                                'nama' => 'Laporan Periodik',
                                'langkah' => [
                                    'Klik menu "Laporan" > pilih jenis laporan',
                                    'Tentukan rentang tanggal',
                                    'Klik "Cari" untuk menampilkan data',
                                    'Export data jika diperlukan'
                                ]
                            ],
                            [
                                'nama' => 'Kalender Cuti',
                                'langkah' => [
                                    'Klik menu "Laporan" > "Kalender Cuti"',
                                    'Lihat kalender dengan semua cuti yang sudah tervalidasi',
                                    'Gunakan tombol di kanan atas untuk beralih antara tampilan bulanan, mingguan, dan harian',
                                    'Klik pada event cuti untuk melihat detail lengkap',
                                    'Event berwarna hijau = Cuti Tahunan, Merah = Cuti Sakit, Kuning = Cuti Melahirkan, dll',
                                    'Event berwarna orange = Izin Keluar (hanya tampil di view mingguan dan harian)',
                                    'Tanggal hari ini ditandai dengan background kuning dan label "Hari Ini"'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Pengaturan',
                        'icon' => 'bx bx-cog',
                        'deskripsi' => 'Mengelola pengaturan sistem seperti hari libur dan sisa cuti pegawai.',
                        'sub_menu' => [
                            [
                                'nama' => 'Libur Nasional',
                                'langkah' => [
                                    'Klik menu "Libur Nasional"',
                                    'Klik tombol "Tambah" untuk menambah hari libur',
                                    'Input tanggal dan keterangan',
                                    'Klik "Simpan"'
                                ]
                            ],
                            [
                                'nama' => 'Sisa Cuti',
                                'langkah' => [
                                    'Klik menu "Sisa Cuti"',
                                    'Lihat daftar sisa cuti semua pegawai',
                                    'Tabel menampilkan: Sisa Tahun Ini, Sisa Tahun Lalu, Sisa 2 Tahun Lalu',
                                    'Tabel juga menampilkan: Cuti Sakit Tahun Ini dan Cuti Alasan Penting Tahun Ini',
                                    'Klik "Generate" untuk tahun baru (awal tahun)',
                                    'Edit sisa cuti dengan klik langsung pada cell yang ingin diubah',
                                    'Tekan Enter atau klik di luar cell untuk menyimpan perubahan'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Manajemen Peran',
                        'icon' => 'bx bx-group',
                        'deskripsi' => 'Mengelola hak akses pengguna sistem.',
                        'langkah' => [
                            'Klik icon kategori (bx-category) di header',
                            'Pilih "Peran"',
                            'Klik "Tambah" untuk menambah peran baru',
                            'Pilih pegawai dan peran yang sesuai',
                            'Klik "Simpan"'
                        ]
                    ]
                ]
            ];
        }
        // Panduan untuk Operator
        elseif ($peran == 'operator') {
            $panduan = [
                'judul' => 'Panduan Penggunaan - Operator',
                'deskripsi' => 'Sebagai Operator, Anda dapat mengakses laporan dan register permohonan izin serta cuti.',
                'menu' => [
                    [
                        'nama' => 'Dashboard',
                        'icon' => 'bx bx-home-circle',
                        'deskripsi' => 'Halaman utama yang menampilkan statistik permohonan.',
                        'langkah' => [
                            'Klik menu "Beranda" untuk melihat dashboard',
                            'Monitor grafik dan statistik bulanan',
                            'Lihat ringkasan permohonan'
                        ]
                    ],
                    [
                        'nama' => 'Register',
                        'icon' => 'bx bx-list-ol',
                        'deskripsi' => 'Melihat daftar register semua permohonan izin dan cuti.',
                        'sub_menu' => [
                            [
                                'nama' => 'Register Izin Keluar',
                                'langkah' => [
                                    'Klik menu "Register" > "Izin Keluar"',
                                    'Lihat daftar semua permohonan izin keluar',
                                    'Gunakan fitur pencarian dan filter',
                                    'Cetak dokumen jika diperlukan'
                                ]
                            ],
                            [
                                'nama' => 'Register Izin Diklat',
                                'langkah' => [
                                    'Klik menu "Register" > "Izin Diklat"',
                                    'Lihat daftar permohonan diklat/bimtek',
                                    'Monitor status permohonan',
                                    'Lihat dokumen pendukung'
                                ]
                            ],
                            [
                                'nama' => 'Register Cuti',
                                'langkah' => [
                                    'Klik menu "Register" > "Cuti"',
                                    'Lihat daftar semua permohonan cuti',
                                    'Filter berdasarkan jenis cuti atau status',
                                    'Admin dapat menambah cuti langsung dengan klik tombol "Tambah"',
                                    'Untuk cuti sakit dan cuti alasan penting, wajib upload dokumen pendukung (maks 5MB)',
                                    'Cetak formulir cuti'
                                ]
                            ],
                            [
                                'nama' => 'Kalender Cuti',
                                'langkah' => [
                                    'Klik menu "Laporan" > "Kalender Cuti"',
                                    'Lihat kalender dengan semua cuti dan izin keluar',
                                    'Gunakan tombol di kanan atas untuk beralih tampilan',
                                    'Klik pada event untuk melihat detail lengkap'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Laporan',
                        'icon' => 'bx bx-folder',
                        'deskripsi' => 'Membuat laporan periodik berdasarkan rentang tanggal.',
                        'sub_menu' => [
                            [
                                'nama' => 'Laporan Izin Keluar',
                                'langkah' => [
                                    'Klik menu "Laporan" > "Izin Keluar"',
                                    'Pilih tanggal awal dan akhir',
                                    'Klik "Cari" untuk menampilkan data',
                                    'Export atau cetak laporan'
                                ]
                            ],
                            [
                                'nama' => 'Laporan Izin Diklat',
                                'langkah' => [
                                    'Klik menu "Laporan" > "Izin Diklat"',
                                    'Tentukan periode laporan',
                                    'Klik "Cari" untuk generate laporan'
                                ]
                            ],
                            [
                                'nama' => 'Laporan Cuti',
                                'langkah' => [
                                    'Klik menu "Laporan" > "Cuti"',
                                    'Input rentang tanggal',
                                    'Klik "Cari" untuk menampilkan laporan'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Pengaturan',
                        'icon' => 'bx bx-cog',
                        'deskripsi' => 'Mengelola data hari libur dan sisa cuti.',
                        'sub_menu' => [
                            [
                                'nama' => 'Libur Nasional',
                                'langkah' => [
                                    'Klik menu "Libur Nasional"',
                                    'Tambah atau edit data hari libur nasional',
                                    'Data ini akan mempengaruhi perhitungan cuti'
                                ]
                            ],
                            [
                                'nama' => 'Sisa Cuti',
                                'langkah' => [
                                    'Klik menu "Sisa Cuti"',
                                    'Monitor sisa cuti semua pegawai',
                                    'Lakukan koreksi jika diperlukan'
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        // Panduan untuk Pegawai Biasa
        else {
            $panduan = [
                'judul' => 'Panduan Penggunaan - Pegawai',
                'deskripsi' => 'Sebagai Pegawai, Anda dapat mengajukan permohonan izin dan cuti serta memvalidasi permohonan bawahan (jika ada).',
                'menu' => [
                    [
                        'nama' => 'Dashboard',
                        'icon' => 'bx bx-home-circle',
                        'deskripsi' => 'Halaman utama untuk melihat ringkasan permohonan Anda.',
                        'langkah' => [
                            'Login ke sistem SEUDATI',
                            'Anda akan langsung masuk ke halaman Dashboard',
                            'Lihat statistik permohonan Anda'
                        ]
                    ],
                    [
                        'nama' => 'Pengajuan Izin',
                        'icon' => 'bx bx-edit',
                        'deskripsi' => 'Mengajukan permohonan izin keluar kantor atau izin diklat/bimtek.',
                        'sub_menu' => [
                            [
                                'nama' => 'Izin Keluar Kantor',
                                'langkah' => [
                                    'Klik menu "Izin" > "Keluar Kantor"',
                                    'Klik tombol "Tambah Permohonan"',
                                    'Isi form: tanggal izin, jam mulai, jam selesai, dan alasan',
                                    'Klik "Simpan"',
                                    'Permohonan akan dikirim ke atasan langsung Anda',
                                    'Tunggu persetujuan dan cek status di halaman yang sama'
                                ]
                            ],
                            [
                                'nama' => 'Izin Diklat/Bimtek',
                                'langkah' => [
                                    'Klik menu "Izin" > "Diklat/Bimtek"',
                                    'Klik tombol "Tambah Permohonan"',
                                    'Pilih tujuan permohonan (Ketua/Sekretaris)',
                                    'Pilih jenis diklat',
                                    'Isi nama diklat, tanggal mulai dan selesai',
                                    'Klik "Simpan"',
                                    'Setelah disetujui, upload sertifikat setelah diklat selesai'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Pengajuan Cuti',
                        'icon' => 'bx bx-calendar-event',
                        'deskripsi' => 'Mengajukan permohonan cuti (tahunan, sakit, melahirkan, dll).',
                        'langkah' => [
                            'Klik menu "Cuti"',
                            'Klik tombol "Tambah Permohonan Cuti"',
                            'Lihat informasi sisa cuti tahunan, sisa cuti sakit, dan sisa cuti alasan penting di bagian atas form',
                            'Pilih jenis cuti (Tahunan, Sakit, Melahirkan, Besar, Alasan Penting, dll)',
                            'Untuk Cuti Sakit dan Cuti Alasan Penting, field "Dokumen Pendukung" akan muncul',
                            'Upload dokumen pendukung (PDF/JPG/PNG, maksimal 5MB) jika jenis cuti Sakit atau Alasan Penting',
                            'Isi tanggal mulai dan selesai cuti',
                            'Sistem akan otomatis menghitung lama cuti',
                            'Isi alamat selama cuti dan alasan',
                            'Klik "Simpan"',
                            'Permohonan akan diproses oleh atasan dan PPK',
                            'Cek status permohonan di tabel yang tersedia',
                            'Setelah disetujui, Anda dapat mencetak formulir cuti'
                        ]
                    ],
                    [
                        'nama' => 'Validasi Izin (Untuk Atasan)',
                        'icon' => 'bx bx-user-check',
                        'deskripsi' => 'Jika Anda adalah atasan, Anda dapat memvalidasi permohonan izin bawahan.',
                        'sub_menu' => [
                            [
                                'nama' => 'Validasi Izin Keluar',
                                'langkah' => [
                                    'Klik menu "Izin" (di bagian Validasi Permohonan) > "Keluar Kantor"',
                                    'Lihat daftar permohonan yang menunggu validasi',
                                    'Klik tombol "Validasi" pada permohonan yang ingin diproses',
                                    'Pilih status: Setuju atau Tolak',
                                    'Isi keterangan jika diperlukan',
                                    'Klik "Simpan"',
                                    'Notifikasi akan dikirim ke pemohon'
                                ]
                            ],
                            [
                                'nama' => 'Validasi Izin Diklat',
                                'langkah' => [
                                    'Klik menu "Izin" (di bagian Validasi Permohonan) > "Diklat/Bimtek"',
                                    'Lihat permohonan yang perlu divalidasi',
                                    'Klik "Proses" untuk memberikan persetujuan',
                                    'Pilih status dan isi keterangan',
                                    'Klik "Simpan"'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Validasi Cuti (Untuk Atasan & PPK)',
                        'icon' => 'bx bx-calendar-check',
                        'deskripsi' => 'Memvalidasi permohonan cuti bawahan (untuk atasan langsung atau PPK).',
                        'sub_menu' => [
                            [
                                'nama' => 'Validasi Cuti - Atasan',
                                'langkah' => [
                                    'Klik menu "Cuti" (di bagian Validasi Permohonan) > "Atasan"',
                                    'Lihat daftar permohonan cuti bawahan',
                                    'Klik tombol "Validasi"',
                                    'Pilih status: Setuju, Perubahan, Ditangguhkan, atau Ditolak',
                                    'Isi alasan jika diperlukan',
                                    'Klik "Simpan"',
                                    'Jika disetujui, permohonan akan diteruskan ke PPK'
                                ]
                            ],
                            [
                                'nama' => 'Validasi Cuti - PPK',
                                'langkah' => [
                                    'Klik menu "Cuti" (di bagian Validasi Permohonan) > "PPK"',
                                    'Lihat permohonan yang sudah disetujui atasan',
                                    'Klik tombol "Validasi"',
                                    'Pilih status validasi',
                                    'Isi keterangan jika ada',
                                    'Klik "Simpan"',
                                    'Sistem akan otomatis mengurangi kuota cuti pegawai'
                                ]
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tips Penggunaan',
                        'icon' => 'bx bx-bulb',
                        'deskripsi' => 'Tips dan informasi penting',
                        'langkah' => [
                            'Pastikan Anda sudah memilih atasan langsung di sistem kepegawaian',
                            'Cek sisa kuota cuti Anda sebelum mengajukan cuti tahunan',
                            'Untuk Cuti Sakit dan Cuti Alasan Penting, siapkan dokumen pendukung (surat dokter, dll)',
                            'Format dokumen pendukung: PDF, JPG, JPEG, atau PNG dengan ukuran maksimal 5MB',
                            'Untuk cuti tahunan > 3 hari berturut-turut, pastikan sudah koordinasi dengan atasan',
                            'Upload sertifikat diklat maksimal 7 hari setelah diklat selesai',
                            'Simpan/cetak formulir cuti yang sudah disetujui untuk arsip',
                            'Gunakan Kalender Cuti untuk melihat jadwal cuti rekan kerja',
                            'Pastikan koneksi internet stabil saat mengajukan permohonan'
                        ]
                    ]
                ]
            ];
        }

        return $panduan;
    }
}

