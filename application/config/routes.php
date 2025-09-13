<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'HalamanUtama';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['cek_token'] = 'HalamanUtama/cek_token_sso';

$route['ambil_permohonan_nomor'] = 'HalamanUtama/ambil_permohonan_nomor';
$route['ambil_permohonan_dokumen_diklat'] = 'HalamanUtama/ambil_permohonan_dokumen';
$route['ambil_permohonan_izin_keluar'] = 'HalamanUtama/ambil_permohonan_izin_keluar';
$route['ambil_permohonan_izin_diklat'] = 'HalamanUtama/ambil_permohonan_izin_diklat';
$route['ambil_permohonan_cuti_atasan'] = 'HalamanUtama/ambil_permohonan_cuti_atasan';
$route['ambil_permohonan_cuti_ppk'] = 'HalamanUtama/ambil_permohonan_cuti_ppk';

$route['get_statistik_izin_keluar'] = 'HalamanUtama/statistik_bulanan_izin_keluar';
$route['get_statistik_izin_diklat'] = 'HalamanUtama/statistik_bulanan_izin_diklat';
$route['get_statistik_cuti'] = 'HalamanUtama/statistik_bulanan_cuti';

$route['get_chart_izin_keluar'] = 'HalamanUtama/chart_izin_keluar';
$route['get_chart_izin_diklat'] = 'HalamanUtama/chart_izin_diklat';
$route['get_chart_cuti'] = 'HalamanUtama/chart_cuti';

$route['statistik_izin_keluar'] = 'HalamanIzin/statistik_izin_keluar';
$route['statistik_izin_keluar_validasi'] = 'HalamanIzin/statistik_izin_keluar_validasi';
$route['show_izin_keluar'] = 'HalamanIzin/show_izin_keluar';
$route['show_validasi_izin_keluar'] = 'HalamanIzin/show_validasi_izin_keluar';
$route['show_tabel_permohonan_izin_keluar'] = 'HalamanIzin/show_tabel_permohonan_izin_keluar';
$route['show_tabel_validasi_izin_keluar'] = 'HalamanIzin/show_tabel_validasi_izin_keluar';
$route['show_izin_keluar_detil'] = 'HalamanIzin/show_izin_keluar_detil';
$route['simpan_izin_keluar'] = 'HalamanIzin/simpan_izin_keluar';
$route['simpan_validasi_izin_keluar'] = 'HalamanIzin/simpan_validasi_izin_keluar';
$route['hapus_izin_keluar'] = 'HalamanIzin/hapus_izin_keluar';
$route['cetak_izin/(:any)'] = 'HalamanIzin/cetak/$1';

$route['statistik_izin_diklat'] = 'HalamanIzin/statistik_izin_diklat';
$route['statistik_izin_diklat_validasi'] = 'HalamanIzin/statistik_izin_diklat_validasi';
$route['show_tabel_permohonan_izin_diklat'] = 'HalamanIzin/show_tabel_permohonan_izin_diklat';
$route['show_tabel_validasi_izin_diklat'] = 'HalamanIzin/show_tabel_validasi_izin_diklat';
$route['show_izin_diklat'] = 'HalamanIzin/show_izin_diklat';
$route['show_diklat_detil'] = 'HalamanIzin/show_diklat_detil';
$route['show_tabel_verifikasi_izin_diklat'] = 'HalamanIzin/show_tabel_verifikasi_izin_diklat';
$route['show_upload_st'] = 'HalamanIzin/show_upload_st';
$route['show_dokumen_diklat'] = 'HalamanIzin/show_dokumen';
$route['show_progres_diklat'] = 'HalamanIzin/show_progres_diklat';
$route['simpan_izin_diklat'] = 'HalamanIzin/simpan_izin_diklat';
$route['simpan_validasi_izin_diklat'] = 'HalamanIzin/simpan_validasi_izin_diklat';
$route['simpan_st'] = 'HalamanIzin/simpan_st';
$route['simpan_progres_diklat'] = 'HalamanIzin/simpan_progres_diklat';
$route['hapus_izin_diklat'] = 'HalamanIzin/hapus_izin_diklat';

# ROUTE CUTI
$route['show_cuti'] = 'HalamanCuti/show_cuti';
$route['statistik_cuti'] = 'HalamanCuti/statistik_cuti';
$route['show_tabel_permohonan_cuti'] = 'HalamanCuti/show_tabel_permohonan_cuti';
$route['simpan_cuti'] = 'HalamanCuti/simpan_cuti';
$route['hapus_cuti'] = 'HalamanCuti/hapus_cuti';
$route['show_cuti_detil'] = 'HalamanCuti/show_cuti_detil';
$route['cetak_cuti/(:any)'] = 'HalamanCuti/cetak/$1';

$route['statistik_validasi_cuti_atasan'] = 'HalamanCuti/statistik_validasi_cuti_atasan';
$route['show_tabel_validasi_cuti_atasan'] = 'HalamanCuti/show_tabel_validasi_cuti_atasan';
$route['show_cuti_validasi'] = 'HalamanCuti/show_cuti_validasi';
$route['simpan_validasi_cuti_atasan'] = 'HalamanCuti/simpan_validasi_cuti_atasan';

$route['statistik_validasi_cuti_ppk'] = 'HalamanCuti/statistik_validasi_cuti_ppk';
$route['show_tabel_validasi_cuti_ppk'] = 'HalamanCuti/show_tabel_validasi_cuti_ppk';
$route['simpan_validasi_cuti_ppk'] = 'HalamanCuti/simpan_validasi_cuti_ppk';

$route['show_tabel_legalisasi_cuti'] = 'HalamanCuti/show_tabel_legalisasi_cuti';
$route['show_nomor'] = 'HalamanCuti/show_nomor';
$route['simpan_nomor'] = 'HalamanCuti/simpan_nomor';

$route['cek_tanggal'] = 'HalamanCuti/cek_tanggal';

$route['show_tabel_register_izin_keluar'] = 'HalamanLaporan/show_tabel_register_izin_keluar';
$route['show_tabel_register_izin_diklat'] = 'HalamanLaporan/show_tabel_register_izin_diklat';
$route['show_tabel_register_cuti'] = 'HalamanLaporan/show_tabel_register_cuti';
$route['cari_izin_keluar'] = 'HalamanLaporan/cari_izin_keluar';
$route['cari_izin_diklat'] = 'HalamanLaporan/cari_izin_diklat';
$route['cari_cuti'] = 'HalamanLaporan/cari_cuti';

# ROUTE PROSES PERAN
$route['show_role'] = 'HalamanUtama/show_role';
$route['simpan_peran'] = 'HalamanUtama/simpan_peran';
$route['blok_peran'] = 'HalamanUtama/blok_peran';
$route['aktif_peran'] = 'HalamanUtama/aktif_peran';

# ROUTE PENGATURAN
$route['show_tabel_hari_libur'] = 'HalamanPengaturan/show_tabel_hari_libur';
$route['get_tgl_merah'] = 'HalamanPengaturan/get_tanggal_merah';
$route['get_hari_libur'] = 'HalamanPengaturan/get_hari_libur';
$route['show_libur'] = 'HalamanPengaturan/show_libur';
$route['simpan_hari_libur'] = 'HalamanPengaturan/simpan_hari_libur';

$route['generate_cuti'] = 'HalamanPengaturan/generate_cuti';
$route['show_tabel_sisa_cuti'] = 'HalamanPengaturan/show_tabel_sisa_cuti';
$route['simpan_sisa_cuti'] = 'HalamanPengaturan/simpan_sisa_cuti';

$route['keluar'] = 'HalamanUtama/keluar';