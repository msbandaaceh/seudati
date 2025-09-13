<?php

class Model extends CI_Model
{
    private $db_sso;

    public function __construct()
    {
        parent::__construct();

        // Inisialisasi variabel private dengan nilai dari session
        $this->db_sso = $this->session->userdata('sso_db');
    }

    private function add_audittrail($action, $title, $table, $descrip)
    {

        $params = [
            'tabel' => 'sys_audittrail',
            'data' => [
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'action' => $action,
                'title' => $title,
                'tablename' => $table,
                'description' => $descrip,
                'username' => $this->session->userdata('username')
            ]
        ];

        $this->apihelper->post('apiclient/simpan_data', $params);
    }

    public function cek_aplikasi($id)
    {
        $params = [
            'tabel' => 'ref_client_app',
            'kolom_seleksi' => 'id',
            'seleksi' => $id
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            $this->session->set_userdata(
                [
                    'nama_client_app' => $user_data['nama_app'],
                    'deskripsi_client_app' => $user_data['deskripsi']
                ]
            );
        }
    }

    public function kirim_notif($data)
    {
        $params = [
            'tabel' => 'sys_notif',
            'data' => $data
        ];

        $this->apihelper->post('apiclient/simpan_data', $params);
    }

    public function get_data_peran()
    {
        $this->db->select('l.id AS id, u.userid AS userid, u.fullname AS nama, l.role AS peran, l.hapus AS hapus');
        $this->db->from('peran l');
        $this->db->join($this->db_sso . '.v_users u', 'l.userid = u.userid', 'left');
        $this->db->order_by('l.id', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_seleksi($tabel, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi2($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi_array($tabel, $where = [], $order_by = [])
    {
        try {
            $this->db->where('hapus', '0');

            // multiple where
            if (!empty($where)) {
                foreach ($where as $kolom => $nilai) {
                    $this->db->where($kolom, $nilai);
                }
            }

            // multiple order by
            if (!empty($order_by)) {
                foreach ($order_by as $kolom => $arah) {
                    $this->db->order_by($kolom, $arah); // ASC / DESC
                }
            }

            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }


    public function get_seleksi3($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2, $kolom_seleksi3, $seleksi3)
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->where($kolom_seleksi3, $seleksi3);
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi2_in($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->where_in($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi_in($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->where_in($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi_order($tabel, $kolom_seleksi, $seleksi, $kolom_order, $order)
    {
        try {
            $this->db->order_by($kolom_order, $order);
            $this->db->where('hapus', '0');
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi2_order($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2, $kolom_order, $order)
    {
        try {
            $this->db->order_by($kolom_order, $order);
            $this->db->where('hapus', '0');
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_data($tabel)
    {
        try {
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function simpan_data($tabel, $data)
    {
        try {
            $this->db->insert($tabel, $data);
            $title = "Simpan Data <br />Update tabel <b>" . $tabel . "</b>[]";
            $descrip = null;
            $this->add_audittrail("INSERT", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pembaharuan_data($tabel, $data, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            $this->db->update($tabel, $data);
            $title = "Pembaharuan Data <br />Update tabel <b>" . $tabel . "</b>[Pada kolom<b>" . $kolom_seleksi . "</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    # MODEL PERIZINAN
    public function statistik_bulanan($tabel)
    {
        $this->db->select('MONTH(created_on) AS bulan, COUNT(*) AS total');
        $this->db->from($tabel);
        $this->db->where('YEAR(created_on) = YEAR(NOW())');
        $this->db->where('hapus = "0"');
        $this->db->group_by('MONTH(created_on)');
        $this->db->order_by('MONTH(created_on)', 'ASC');
        return $this->db->get();
    }

    public function get_izin_keluar_statistik()
    {
        $query = $this->db->query("
        SELECT 
            COUNT(*) AS total_semua,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS total_proses,
            SUM(CASE WHEN status > 0 THEN 1 ELSE 0 END) AS total_selesai
        FROM register_izin_keluar
        WHERE YEAR(created_on) = YEAR(CURDATE()) AND hapus = '0'
        ");
        return $query->row_array();
    }

    public function get_izin_diklat_statistik()
    {
        $query = $this->db->query("
        SELECT 
            COUNT(*) AS total_semua,
            SUM(CASE WHEN status_permohonan = '0' THEN 1 ELSE 0 END) AS belum_proses,
            SUM(CASE WHEN status_permohonan IN ('1','2') THEN 1 ELSE 0 END) AS on_process,
            SUM(CASE WHEN status_permohonan >= '3' THEN 1 ELSE 0 END) AS total_selesai
        FROM register_izin_diklat
        WHERE YEAR(created_on) = YEAR(CURDATE()) AND hapus = '0';
        ");
        return $query->row_array();
    }

    public function proses_simpan_izin_keluar($data)
    {
        // Cek apakah user sudah pilih atasan
        $atasan = $this->get_seleksi($this->db_sso . '.sys_users', 'userid', $data['id_user'])->row()->atasan_id;
        if (!$atasan || $atasan == '0') {
            return ['status' => false, 'message' => 'Anda Belum Memilih Atasan Langsung.'];
        }

        if (!empty($data['id'])) {
            // UPDATE
            $update = [
                'id_user' => $data['id_user'],
                'tgl_izin' => $data['tgl_izin'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_akhir' => $data['jam_selesai'],
                'alasan' => $data['alasan'],
                'modified_by' => $data['fullname'],
                'modified_on' => date('Y-m-d H:i:s')
            ];
            $this->pembaharuan_data('register_izin_keluar', $update, 'id', $data['id']);
            return ['status' => true, 'message' => 'Permohonan Izin Berhasil di Perbarui'];
        } else {

            $cekMohonIzin = $this->get_seleksi2('register_izin_keluar', 'id_user', $data['id_user'], 'status', '0');
            if ($cekMohonIzin->num_rows() > '0') {
                return ['status' => false, 'message' => 'Anda memiliki permohonan izin yang belum diproses. Silakan hubungi atasan langsung anda.'];
            }
            // LOGIKA LAMA UNTUK PEMBUATAN BARU
            // Ambil semua data user
            $user = $this->get_seleksi($this->db_sso . '.v_users', 'userid', $data['id_user'])->row();
            $id_pemohon = $user->pegawai_id;
            $id_jab = $user->jab_id;
            $id_jab_atasan = $user->atasan_id;
            $jabatan_atasan = $user->atasan_jabatan;
            $nama = $user->fullname;

            if (in_array($id_jab, ['4', '5'])) {
                # Jika Pemohon adalah Panitera/Sekretaris
                # Cek apakah Atasan ada PLH/PLT
                $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '1');
                if ($queryPlhAtasan->row()->pegawai_id != null) {
                    # Ketua Ada PLH/PLT
                    $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                    if ($queryPlhAtasan->row()->jabatan == 'Wakil Ketua') {
                        # Jika PLH/PLT adalah Wakil Ketua
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Wakil Ketua MS Banda Aceh, ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $jabatan_atasan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    } else {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Ketua MS Banda Aceh, ada permohonan izin keluar kantor, atas nama ' . $nama . ' . Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $jabatan_atasan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    }
                } else {
                    # Ketua Tidak ada Plh
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. Ketua MS Banda Aceh, ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $jabatan_atasan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', '1', 'status_pegawai', '1');
                    if ($queryTujuanNotif->num_rows() > 0)
                        $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                    else
                        return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                }
            } else {
                # Pemohon bukan Panitera/Sekretaris
                # Cek apakah atasan langsung sedang di-PLH/PLT-kan
                $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_jab_atasan);
                if ($queryPlhAtasan->row()->pegawai_id != null) {
                    # Jika atasan langsung ada PLH/PLT
                    if ($queryPlhAtasan->row()->pegawai_id == $this->session->userdata('pegawai_id')) {
                        # Jika Pemohon adalah PLH/PLT dari Atasannya
                        if (in_array($id_jab_atasan, ['10', '11', '12'])) {
                            $id_jab_atasan = '5';
                        } elseif (in_array($id_jab_atasan, ['6', '7', '8', '9'])) {
                            $id_jab_atasan = '4';
                        } else {
                            $id_jab_atasan = '1';
                        }

                        $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_jab_atasan);
                        if ($queryPlhAtasan->row()->pegawai_id != null) {
                            $queryJabatan = $this->get_seleksi($this->db_sso . '.ref_jabatan', 'id', $id_jab_atasan);
                            if ($queryPlhAtasan->row()->pegawai_id == '2') {
                                $pesan = 'Assalamualaikum Wr. Wb., Yth. *Wakil Ketua MS Banda Aceh* Ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $queryJabatan->row()->nama_jabatan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                            } else {
                                $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $queryJabatan->row()->nama_jabatan . ' MS Banda Aceh* Ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $queryJabatan->row()->nama_jabatan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                            }
                            $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                        } else {
                            $qryJabatan = $this->get_seleksi($this->db_sso . '.ref_jabatan', 'id', $id_jab_atasan);
                            $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $qryJabatan->row()->nama_jabatan . ' MS Banda Aceh* Ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Pemohon merupakan Plh/Plt dari Atasan Langsungnya, Terima Kasih ';
                            $queryTujuanNotif = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', $id_jab_atasan);
                            $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                        }
                    } else {
                        # Jika Pemohon bukan PLH/PLT dari Atasannya
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $jabatan_atasan . ' MS Banda Aceh* Ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $jabatan_atasan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                        $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                    }
                } else {
                    # Atasan langsung tidak PLH/PLT
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $jabatan_atasan . ' MS Banda Aceh* Ada permohonan izin keluar kantor, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                    $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', $id_jab_atasan, 'status_pegawai', '1');
                    if ($queryTujuanNotif->num_rows() > 0)
                        $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                    else
                        return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                }
            }

            // Simpan izin
            $izinData = [
                'id_user' => $data['id_user'],
                'tgl_izin' => $data['tgl_izin'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_akhir' => $data['jam_selesai'],
                'jab_tujuan' => $id_jab_atasan,
                'alasan' => $data['alasan'],
                'created_by' => $data['fullname'],
                'created_on' => date('Y-m-d H:i:s')
            ];
            $this->simpan_data('register_izin_keluar', $izinData);

            // Simpan notifikasi
            $notifData = [
                'jenis_pesan' => 'izin',
                'id_pemohon' => $id_pemohon,
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $data['fullname'],
                'created_on' => date('Y-m-d H:i:s')
            ];
            $this->kirim_notif($notifData);

            return ['status' => true, 'message' => 'Permohonan Izin Berhasil di Buat'];
        }
    }

    public function proses_simpan_validasi_izin_keluar($data)
    {
        $jabatan_as = '';
        if ($data['ket'] == '') {
            $data['ket'] = '-';
        }

        $queryCekPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $this->session->userdata('jab_id'));
        if ($queryCekPlh->row()->pegawai_id != NULL) {
            $data['nama_penandatangan'] = $queryCekPlh->row()->nama_pegawai;
            $jabatan_as = $queryCekPlh->row()->nama;
            $data['id_penandatangan'] = $queryCekPlh->row()->pegawai_id;
            if ($data['status'] == 1) {
                $data['status'] = 3;
            } else {
                $data['status'] = 4;
            }
        } else {
            $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', $this->session->userdata('jab_id'), 'status_pegawai', '1');
            if ($queryTujuanNotif->num_rows() == 0)
                return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
        }

        $dataPengguna = array(
            'status' => $data['status'],
            'ket' => $data['ket'],
            'validator' => $data['id_penandatangan'],
            'validator_as' => $jabatan_as,
            'modified_by' => $data['nama_penandatangan'],
            'modified_on' => date('Y-m-d H:i:s')
        );

        $querySimpan = $this->pembaharuan_data('register_izin_keluar', $dataPengguna, 'id', $data['id']);

        if ($querySimpan == 1) {
            $queryUser = $this->get_seleksi('v_izin_keluar', 'id', $data['id']);
            $id_pegawai = $queryUser->row()->id_pegawai;
            $nama = $queryUser->row()->nama_pegawai;
            $alasan = $queryUser->row()->alasan;

            if ($data['status'] == '1' || $data['status'] == '3') {
                $pesans = 'Assalamualaikum Wr. Wb., Yth. *' . $nama . '* Permohonan izin keluar kantor anda dengan alasan "*' . $alasan . '*" sudah disetujui atasan. Terima Kasih';
            } else {
                $pesans = 'Assalamualaikum Wr. Wb., Yth. *' . $nama . '* Permohonan izin keluar kantor anda dengan alasan "*' . $alasan . '*" ditolak atasan, karena ' . $data['ket'] . '. Silakan akses LITERASI MS Banda Aceh apabila ingin mengajukan permohonan ulang. Terima Kasih';
            }

            $dataNotif = array(
                'jenis_pesan' => 'izin',
                'id_pemohon' => $data['id_penandatangan'],
                'pesan' => $pesans,
                'id_tujuan' => $id_pegawai,
                'created_by' => $data['nama_penandatangan'],
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->kirim_notif($dataNotif);

            return ['status' => true, 'message' => 'Permohonan Izin Berhasil Anda Validasi, Notifikasi akan dikirim'];
        } else {
            return ['status' => false, 'message' => 'Permohonan Izin Gagal Validasi, Periksa kembali atau hubungi Administrator'];
        }
    }

    public function proses_simpan_izin_diklat($data)
    {
        if ($data['jenis'] == 'Lainnya') {
            $jenis = $data['jenis_nama'];
        } else {
            $jenis = $data['jenis'];
        }

        if ($data['id']) {
            $dataPermohonan = array(
                'pegawai_id' => $this->session->userdata('pegawai_id'),
                'tujuan_permohonan' => $data['tujuan'],
                'jenis' => $jenis,
                'nama_diklat' => $data['nama'],
                'tgl_mulai' => $data['tgl_mulai'],
                'tgl_selesai' => $data['tgl_selesai'],
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $queryIzin = $this->get_seleksi('register_izin_diklat', 'id', $data['id']);
            $tujuan = $queryIzin->row()->tujuan_permohonan;
            if ($data['tujuan'] != $tujuan) {
                if ($data['tujuan'] == '1') {
                    $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '1');
                    if ($queryPlhAtasan->row()->pegawai_id != null) {
                        # Ketua Ada PLH/PLT
                        $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                        if ($queryPlhAtasan->row()->jabatan == 'Wakil Ketua') {
                            # Jika PLH/PLT adalah Wakil Ketua
                            $pesan = 'Assalamualaikum Wr. Wb., Yth. Wakil Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                        } else {
                            $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                        }
                    } else {
                        # Ketua Tidak ada Plh
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                        $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', '1', 'status_pegawai', '1');
                        if ($queryTujuanNotif->num_rows() > 0)
                            $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                        else
                            return ['status' => false, 'message' => 'Pejabat tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                    }
                } else {
                    $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '5');
                    if ($queryPlhAtasan->row()->pegawai_id != null) {
                        # Sekretaris Ada PLH/PLT
                        $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Sekretaris MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Sekretaris sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    } else {
                        # Sekretaris Tidak ada Plh
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Sekretaris MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                        $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', '5', 'status_pegawai', '1');
                        if ($queryTujuanNotif->num_rows() > 0)
                            $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                        else
                            return ['status' => false, 'message' => 'Pejabat tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                    }
                }

                $dataNotif = array(
                    'jenis_pesan' => 'izin',
                    'id_pemohon' => $this->session->userdata('pegawai_id'),
                    'pesan' => $pesan,
                    'id_tujuan' => $tujuanNotif,
                    'created_by' => $this->session->userdata('fullname'),
                    'created_on' => date('Y-m-d H:i:s')
                );

                $this->kirim_notif($dataNotif);
            }

            $querySimpan = $this->pembaharuan_data('register_izin_diklat', $dataPermohonan, 'id', $data['id']);
            if ($querySimpan > 0)
                return ['status' => true, 'message' => 'Permohonan Izin Berhasil di Perbarui'];
            else
                return ['status' => false, 'message' => 'Ada Masalah Dengan Data, Silakan Coba Lagi atau Hubungi Admin'];
        } else {

            $queryCekPermohonan = $this->get_seleksi2_in('register_izin_diklat', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_permohonan', [0, 1, 2]);
            if ($queryCekPermohonan->num_rows() > 0) {
                return ['status' => false, 'message' => 'Anda Sudah Memiliki Permohonan Diklat/Bimtek Yang Sudah Diajukan namun Belum Selesai.'];
            }
            # Permohonan Izin Baru
            $dataPermohonan = array(
                'pegawai_id' => $this->session->userdata('pegawai_id'),
                'tujuan_permohonan' => $data['tujuan'],
                'jenis' => $jenis,
                'nama_diklat' => $data['nama'],
                'tgl_mulai' => $data['tgl_mulai'],
                'tgl_selesai' => $data['tgl_selesai'],
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            if ($data['tujuan'] == '1') {
                $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '1');
                if ($queryPlhAtasan->row()->pegawai_id != null) {
                    # Ketua Ada PLH/PLT
                    $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                    if ($queryPlhAtasan->row()->jabatan == 'Wakil Ketua') {
                        # Jika PLH/PLT adalah Wakil Ketua
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Wakil Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    } else {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                    }
                } else {
                    # Ketua Tidak ada Plh
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. Ketua MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                    $queryTujuanNotif = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', '1');
                    $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                }
            } else {
                $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '5');
                if ($queryPlhAtasan->row()->pegawai_id != null) {
                    # Sekretaris Ada PLH/PLT
                    $tujuanNotif = $queryPlhAtasan->row()->pegawai_id;
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Sekretaris MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Sekretaris sedang melakukan Dinas Luar Kantor, Terima Kasih.';
                } else {
                    # Sekretaris Tidak ada Plh
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. Sekretaris MS Banda Aceh, ada permohonan izin Diklat/Bimtek. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                    $queryTujuanNotif = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', '5');
                    $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                }
            }

            $dataNotif = array(
                'jenis_pesan' => 'izin',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->kirim_notif($dataNotif);
            $querySimpan = $this->simpan_data('register_izin_diklat', $dataPermohonan);
            if ($querySimpan > 0)
                return ['status' => true, 'message' => 'Permohonan Izin Berhasil di Simpan'];
            else
                return ['status' => false, 'message' => 'Ada Masalah Dengan Data, Silakan Coba Lagi atau Hubungi Admin'];
        }
    }

    public function proses_simpan_st($data)
    {
        $dataDiklat = $this->get_seleksi('v_izin_diklat', 'id', $data['id']);
        $tujuanNotif = $dataDiklat->row()->pegawai_id; //Id Pegawai Pemohon Cuti
        $nama = $dataDiklat->row()->nama;

        $dataPengguna = array(
            'dok_st' => $data['dok_st'],
            'status_permohonan' => '2',
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $dataNotif = array(
            'jenis_pesan' => 'diklat',
            'id_pemohon' => $this->session->userdata('pegawai_id'),
            'pesan' => ('Assalamualaikum Wr. Wb. Yth. ' . $nama . ' Izin Diklat/Bimtek anda sudah diberikan persetujuan, anda dapat mengambilnya di LITERASI MS BANDA ACEH. Jangan lupa untuk mengupdate dan mengupload sertifikat ketika Diklat/Bimtek telah selesai. Terima Kasih'),
            'id_tujuan' => $tujuanNotif,
            'created_by' => $this->session->userdata('fullname'),
            'created_on' => date('Y-m-d H:i:s')
        );

        $querySimpan = $this->pembaharuan_data('register_izin_diklat', $dataPengguna, 'id', $data['id']);
        $this->kirim_notif($dataNotif);

        if ($querySimpan > 0)
            return ['status' => true, 'message' => 'Verifikasi Izin Diklat Berhasil di Simpan'];
        else
            return ['status' => false, 'message' => 'Ada Masalah Dengan Data, Silakan Coba Lagi atau Hubungi Admin'];
    }

    public function getDetailIzin($idDecrypt)
    {
        $query = $this->get_seleksi('v_izin_keluar', 'id', $idDecrypt);
        if (!$query || !$query->row()) {
            return null;
        }
        $izin = $query->row();

        $data['nip_atasan'] = $izin->nip_validator;
        $data['nama_atasan'] = $izin->validator;
        $data['jabatan_validator'] = $izin->validator_as;
        $data['nama'] = $izin->nama_pegawai;
        $data['jabatan'] = $izin->jabatan_pegawai;
        $data['nip'] = $izin->nip;
        $data['tgl'] = $this->tanggalhelper->convertDayDate($izin->tgl_izin);
        $data['jam_keluar'] = $izin->jam_mulai;
        $data['jam_kembali'] = $izin->jam_akhir;
        $data['alasan'] = $izin->alasan;
        $data['tgl_setuju'] = $this->tanggalhelper->convertDayDate(date('Y-m-d', strtotime($izin->modified_on)));

        if ($izin->status == 3) {
            $data['nama_atasan'] = $izin->validator;
            $data['nip_atasan'] = $izin->nip_validator;
        }

        if ($data['jabatan_validator'] == "") {
            $data['jabatan_atasan'] = $izin->jabatan_validator;
        } else {
            $data['jabatan_atasan'] = ($izin->jabatan_validator == 'Wakil Ketua')
                ? 'Wakil Ketua'
                : $izin->validator_as;
        }

        $data['userid_pegawai'] = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $izin->id_pegawai)->row()->userid;
        $data['userid_validator'] = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $izin->id_validator)->row()->userid;

        return $data;
    }

    # MODEL CUTI
    public function cek_sisa_cuti($tahun, $pegawai_id)
    {
        try {
            $this->db->where('pegawai_id', $pegawai_id);
            $this->db->where('tahun', $tahun);
            return $this->db->get('register_sisa_cuti_tahunan');
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_tgl_merah()
    {
        try {
            $this->db->where('YEAR(tgl) = YEAR(CURDATE())');
            return $this->db->get('register_hari_libur');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function cuti_legalisasi_data()
    {
        $this->db->order_by('created_on', 'ASC');
        $this->db->where('(status_ppk = 1 OR status_ppk = 5)');
        $this->db->where('(status_validator = 1 OR status_validator = 5)');
        $this->db->where('nomor_cuti', NULL);
        return $this->db->select('*')->from('v_cuti')->get();
    }

    public function proses_simpan_nomor_cuti($data)
    {
        $dataCuti = $this->get_seleksi('v_cuti', 'id', $data['id']);
        $tujuanNotif = $dataCuti->row()->pegawai_id; //Id Pegawai Pemohon Cuti
        $nama = $dataCuti->row()->pegawai_nama;

        $dataPengguna = array(
            'nomor_cuti' => $data['nomor'],
            'status_cuti' => '1',
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $dataNotif = array(
            'jenis_pesan' => 'cuti',
            'id_pemohon' => $this->session->userdata('pegawai_id'),
            'pesan' => ('Assalamualaikum Wr. Wb. Yth. ' . $nama . ' Cuti anda sudah disetujui dan diberi nomor, anda dapat membuka LITERASI MS BANDA ACEH untuk melihat Formulir Cuti anda, Terima Kasih'),
            'id_tujuan' => $tujuanNotif,
            'created_by' => $this->session->userdata('fullname'),
            'created_on' => date('Y-m-d H:i:s')
        );

        $querySimpan = $this->pembaharuan_data('register_cuti', $dataPengguna, 'id', $data['id']);
        $this->kirim_notif($dataNotif);

        if ($querySimpan == 1) {
            return ['status' => true, 'message' => 'Permohonan Cuti Berhasil diberikan Nomor, Notifikasi Akan Segera Dikirim'];
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan, ' . $querySimpan];
        }
    }

    public function get_cuti_statistik()
    {
        $query = $this->db->query("
        SELECT 
            COUNT(*) AS total_semua,
            SUM(CASE WHEN status_cuti = 0 THEN 1 ELSE 0 END) AS belum_proses,
            SUM(CASE WHEN status_cuti > 0 AND nomor_cuti IS NULL THEN 1 ELSE 0 END) AS on_process,
            SUM(CASE WHEN status_cuti > 0 AND nomor_cuti IS NOT NULL THEN 1 ELSE 0 END) AS total_selesai
        FROM register_cuti
        WHERE YEAR(created_on) = YEAR(CURDATE()) AND hapus = '0';
        ");
        return $query->row_array();
    }

    public function proses_simpan_cuti($data)
    {
        $nama = $this->session->userdata('fullname');

        if ($data['id']) {
            $dataPengguna = array(
                'pegawai_id' => $data['pegawai_id'],
                'jenis_cuti' => $data['jenis'],
                'tgl_awal' => $data['tgl_awal'],
                'tgl_akhir' => $data['tgl_akhir'],
                'lama' => $data['lama'],
                'alamat' => $data['alamat'],
                'alasan' => $data['alasan'],
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $querySimpan = $this->pembaharuan_data('register_cuti', $dataPengguna, 'id', $data['id']);
        } else {
            if ($data['jenis'] == '1') {
                $queryCuti = $this->get_seleksi3('register_cuti', 'pegawai_id', $data['pegawai_id'], 'jenis_cuti', $data['jenis'], 'status_cuti', '0');
                if ($queryCuti->num_rows() > 0) {
                    return ['status' => false, 'message' => 'Ada permohonan Cuti Tahunan Anda yang dalam proses permohonan, mohon diperiksa kembali sebelum mengajukan permohonan baru.'];
                }
            } elseif ($data['jenis'] == '4') {
                $queryCatatanCuti = $this->get_seleksi2('register_catatan_cuti', 'pegawai_id', $data['pegawai_id'], 'tahun', date('Y', strtotime($data['tgl_awal'])));
                $cuti_besar = $queryCatatanCuti->row()->cuti_besar;
                if ($cuti_besar || $cuti_besar != '') {
                    return ['status' => false, 'message' => 'Anda sudah pernah menjalankan Cuti Besar tahun ini. Anda tidak boleh mengambil Cuti Besar lagi untuk tahun ini'];
                }
            }

            $dataPegawai = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $data['pegawai_id']);
            $id_jabatan_atasan = $dataPegawai->row()->atasan_id;
            $jabatan_atasan = $dataPegawai->row()->jabatan_atasan;

            # Cek apakah atasan langsung ada plh
            $queryPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_jabatan_atasan);
            if ($queryPlh->row()->pegawai_id != null) {
                # Jika Atasan langsung ada plh
                # Cek siapa atasan langsung
                if (in_array($id_jabatan_atasan, ['4', '5'])) {
                    # Jika Atasan adalah Panitera atau Sekretaris
                    # Cek apakah atasan langsung Panitera dan Sekretaris ada Plh
                    $jab_tujuan = '1';
                    $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '1');
                    if ($queryPlhAtasan->row()->pegawai_id != null) {
                        # Ada Plh
                        if ($queryPlhAtasan->row()->jabatan == 'Wakil Ketua') {
                            $pesan = 'Assalamualaikum Wr. Wb., Yth. *Wakil Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama *' . $nama . '*. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh sebagai *Plh/Plt Ketua* dikarenakan Atasan Langsung Pegawai (*' . $jabatan_atasan . '*) sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                        } else {
                            $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama *' . $nama . '*. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Atasan Langsung Pegawai (*' . $jabatan_atasan . '*) sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                        }
                        $id_pegawai = $queryPlhAtasan->row()->pegawai_id;
                    } else {
                        # Tidak ada Plh
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama *' . $nama . '*. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Atasan Langsung Pegawai (*' . $jabatan_atasan . '*) sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                        $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', $jab_tujuan, 'status_pegawai', '1');
                        if ($queryTujuanNotif->num_rows() > 0)
                            $id_pegawai = $queryTujuanNotif->row()->pegawai_id;
                        else
                            return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                    }
                } elseif (in_array($id_jabatan_atasan, ['6', '7', '8', '9', '10', '11', '12'])) {
                    # Jika Atasan adalah Panmud Kasub
                    if ($queryPlh->row()->pegawai_id == $data['pegawai_id']) {
                        # Pemohon adalah Pegawai yang di PLH/PLT kan
                        if (in_array($id_jabatan_atasan, ['10', '11', '12'])) {
                            $id_jabatan_atasan = '5';
                        } elseif (in_array($id_jabatan_atasan, ['6', '7', '8', '9'])) {
                            $id_jabatan_atasan = '4';
                        }

                        $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_jabatan_atasan);
                        if ($queryPlhAtasan->row()->pegawai_id != null) {
                            $queryJabatan = $this->get_seleksi($this->db_sso . '.ref_jabatan', 'id', $id_jabatan_atasan);
                            if ($queryPlhAtasan->row()->pegawai_id == '2') {
                                $pesan = 'Assalamualaikum Wr. Wb., Yth. *Wakil Ketua MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $queryJabatan->row()->nama_jabatan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                            } else {
                                $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $queryJabatan->row()->nama_jabatan . ' MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan ' . $queryJabatan->row()->nama_jabatan . ' sedang melakukan Dinas Luar Kantor, Terima Kasih ';
                            }
                            $id_pegawai = $queryPlhAtasan->row()->pegawai_id;
                        } else {
                            $qryJabatan = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', $id_jabatan_atasan, 'status_pegawai', '1');
                            if ($qryJabatan->num_rows() > 0) {
                                $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $qryJabatan->row()->jabatan . ' MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Pemohon merupakan Plh/Plt dari Atasan Langsungnya, Terima Kasih ';
                                $id_pegawai = $qryJabatan->row()->pegawai_id;
                            } else {
                                return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                            }
                        }

                        $jab_tujuan = $id_jabatan_atasan;

                    } else {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $jabatan_atasan . ' MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                        $jab_tujuan = $id_jabatan_atasan;
                        $id_pegawai = $queryPlh->row()->pegawai_id;
                    }
                } else {
                    # Jika Atasan adalah Ketua
                    if ($queryPlh->row()->jabatan == 'Wakil Ketua') {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Wakil Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh sebagai *Plh/Plt Ketua* dikarenakan Ketua sedang Dinas Luar, Terima Kasih ';
                    } else {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $jabatan_atasan . ' MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                    }
                    $jab_tujuan = $id_jabatan_atasan;
                    $id_pegawai = $queryPlh->row()->pegawai_id;
                }

                $tujuanNotif = $id_pegawai;
            } else {
                # Atasan langsung tidak ada plh
                $queryTujuanNotif = $this->get_seleksi2($this->db_sso . '.v_users', 'jab_id', $id_jabatan_atasan, 'status_pegawai', '1');
                if ($queryTujuanNotif->num_rows() > 0) {
                    $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                    $jab_tujuan = $id_jabatan_atasan;
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $queryTujuanNotif->row()->jabatan . ' MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                } else {
                    return ['status' => false, 'message' => 'Atasan langsung anda tidak ada dan tidak ada plh atau pltnya, silakan hubungi bagian kepegawaian.'];
                }
            }

            $dataPengguna = array(
                'pegawai_id' => $data['pegawai_id'],
                'jenis_cuti' => $data['jenis'],
                'tgl_awal' => $data['tgl_awal'],
                'tgl_akhir' => $data['tgl_akhir'],
                'lama' => $data['lama'],
                'alamat' => $data['alamat'],
                'alasan' => $data['alasan'],
                'id_validator' => $jab_tujuan,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $dataNotif = array(
                'jenis_pesan' => 'cuti',
                'id_pemohon' => $data['pegawai_id'],
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            # die(var_dump($dataPengguna += $dataNotif));
            $querySimpan = $this->simpan_data('register_cuti', $dataPengguna);
            $this->kirim_notif($dataNotif);
        }

        if ($querySimpan == 1) {
            if ($data['id']) {
                return ['status' => true, 'message' => 'Permohonan Cuti Berhasil di Perbarui'];
            } else {
                return ['status' => true, 'message' => 'Permohonan Cuti Berhasil di Buat, Notifikasi Akan Segera Dikirim'];
            }
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan, ' . $querySimpan];
        }
    }

    public function proses_simpan_validasi_cuti_atasan($data)
    {
        $dataCuti = $this->get_seleksi('v_cuti', 'id', $data['id']);
        $nama = $dataCuti->row()->pegawai_nama;
        $id_pemohon = $dataCuti->row()->pegawai_id;
        $id_grup = $dataCuti->row()->id_grup;

        switch ($data['status']) {
            case 2:
                $status_valid_notif = "Perubahan";
                break;
            case 3:
                $status_valid_notif = "Ditangguhkan";
                break;
            case 4:
                $status_valid_notif = "Ditolak";
                break;
        }

        if ($data['status'] == '1') {
            if (in_array($id_grup, ['3', '6'])) {
                $id_ppk = '5';
                //Cek apakah PPK ada plh
                $queryPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_ppk);
                if ($queryPlh->row()->pegawai_id != null) {
                    //PPK ada plh
                    $status_validator = '5';
                    $id_pegawai = $queryPlh->row()->pegawai_id;
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt Sekretaris MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                } else {
                    //PPK tidak ada plh
                    $queryTujuanNotif = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', $id_ppk);
                    $id_pegawai = $queryTujuanNotif->row()->pegawai_id;
                    $status_validator = $data['status'];
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *Sekretaris MS Banda Aceh* Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih ';
                }

                $tujuanNotif = $id_pegawai;
            } else {
                $id_ppk = '1';
                $queryPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_ppk);
                if ($queryPlhAtasan->row()->pegawai_id != null) {
                    //Ada Plh
                    if ($queryPlhAtasan->row()->jabatan == 'Wakil Ketua') {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Wakil Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih';
                    } else {
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh dikarenakan Ketua sedang melakukan Dinas Luar Kantor, Terima Kasih';
                    }

                    $status_validator = '5';
                    $id_pegawai = $queryPlhAtasan->row()->pegawai_id;
                } else {
                    //Tidak ada Plh
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *Ketua MS Banda Aceh*, Ada permohonan cuti, atas nama ' . $nama . '. Mohon untuk ditindaklanjuti melalui LITERASI MS Banda Aceh, Terima Kasih';
                    $queryTujuanNotif = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', $id_ppk);
                    $id_pegawai = $queryTujuanNotif->row()->pegawai_id;
                    $status_validator = $data['status'];
                }
                $tujuanNotif = $id_pegawai;
            }
        } else {
            $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $nama . '*, permohonan cuti anda, diberikan status *' . $status_valid_notif . '* dengan alasan *' . $data['alasan'] . '*. Terima Kasih ';
            $tujuanNotif = $id_pemohon;
            if ($this->session->userdata('status_plh') == 1 || $this->session->userdata('status_plt') == 1) {
                switch ($data['status']) {
                    case 2:
                        $status_validator = '6';
                        break;
                    case 3:
                        $status_validator = '7';
                        break;
                    case 4:
                        $status_validator = '8';
                        break;
                }
            } else {
                $status_validator = $data['status'];
            }
        }

        if (in_array($data['status'], ['1', '5'])) {
            $dataPengguna = array(
                'status_validator' => $status_validator,
                'alasan_validator' => $data['alasan'],
                'id_ttd_validator' => $this->session->userdata('pegawai_id'),
                'id_ppk' => $id_ppk,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $dataNotif = array(
                'jenis_pesan' => 'cuti',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );
        } else {
            $dataPengguna = array(
                'status_validator' => $status_validator,
                'alasan_validator' => $data['alasan'],
                'id_ttd_validator' => $tujuanNotif,
                'status_cuti' => $data['status'],
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $dataNotif = array(
                'jenis_pesan' => 'cuti',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesan,
                'id_tujuan' => $id_pemohon,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );
        }

        $querySimpan = $this->pembaharuan_data('register_cuti', $dataPengguna, 'id', $data['id']);
        $this->kirim_notif($dataNotif);

        if ($querySimpan == 1) {
            return ['status' => true, 'message' => 'Permohonan Cuti Berhasil di Validasi, Notifikasi Akan Segera Dikirim'];
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan Validasi, ' . $querySimpan];
        }
    }

    public function proses_simpan_validasi_cuti_ppk($data)
    {
        switch ($data['status']) {
            case 2:
                $status_valid_notif = "Perubahan";
                break;
            case 3:
                $status_valid_notif = "Ditangguhkan";
                break;
            case 4:
                $status_valid_notif = "Ditolak";
                break;
        }

        $dataCuti = $this->get_seleksi('v_cuti', 'id', $data['id']);
        $tujuanNotif = $dataCuti->row()->pegawai_id; //Id Pegawai Pemohon Cuti
        $nama = $dataCuti->row()->pegawai_nama;
        $id_ppk = $dataCuti->row()->id_ppk; //Id Jabatan PPK
        $mulai = $dataCuti->row()->tgl_awal; //Tanggal mulai cuti
        $lama = $dataCuti->row()->lama; //Lama Cuti
        $jenis = $dataCuti->row()->jenis_cuti; //Jenis Cuti
        $id_grup = $dataCuti->row()->id_grup; //Id Grup Pegawai

        $cekPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $id_ppk);
        if ($cekPlh->row()->pegawai_id != NULL) {
            //ada PLH
            switch ($data['status']) {
                case 1:
                    $status_ppk = '5';
                    break;
                case 2:
                    $status_ppk = '6';
                    break;
                case 3:
                    $status_ppk = '7';
                    break;
                case 4:
                    $status_ppk = '8';
                    break;
            }
            $id_ttd_ppk = $cekPlh->row()->pegawai_id;
        } else {
            //Tidak ada PLH
            $id_ttd_ppk = $this->session->userdata('pegawai_id');
            $status_ppk = $data['status'];
        }

        $queryn1 = $this->get_seleksi2('register_sisa_cuti_tahunan', 'tahun', date("Y"), 'pegawai_id', $tujuanNotif);
        $queryn2 = $this->get_seleksi2('register_sisa_cuti_tahunan', 'tahun', date("Y") - 1, 'pegawai_id', $tujuanNotif);
        $queryn3 = $this->get_seleksi2('register_sisa_cuti_tahunan', 'tahun', date("Y") - 2, 'pegawai_id', $tujuanNotif);

        //die(var_dump($this->session->userdata('id_pegawai')));
        if ($queryn1->num_rows() > 0) {
            $n1 = $queryn1->row()->sisa;
        } else {
            $n1 = 0;
        }

        if ($queryn2->num_rows() > 0) {
            $n2 = $queryn2->row()->sisa;
        } else {
            $n2 = 0;
        }

        if ($queryn3->num_rows() > 0) {
            $n3 = $queryn3->row()->sisa;
        } else {
            $n3 = 0;
        }

        # Cek validasi atas permohonan
        if (in_array($status_ppk, ['1', '3', '5', '7'])) { //Permohonan Disetujui atau Ditangguhkan
            if ($jenis == '1') { // Cuti Tahunan
                if ($id_grup != '3') {
                    //Selain PPNPN
                    if ($n3 == 12 && $n2 == 12 && $n1 == 12) {
                        //kuota cuti = 24
                        if ($lama > $n2) {
                            $selisih = $lama - $n2;
                            $sisa_n2 = 0;
                            $sisa_n1 = $n1 - $selisih;
                        } else {
                            $sisa_n1 = $n1;
                            $sisa_n2 = $n2 - $lama;

                        }
                        $sisa_n3 = $n3;
                    } elseif ((($n2 < 12 && $n2 > 6) && $n1 == 12) || ($n2 <= 6 && $n1 == 12)) {
                        //kuota cuti = 18 atau kurang dari 18
                        if ($n2 > 6) {
                            $n2 = 6;
                        }

                        #$kuota_cuti = $n1 + $n2;
                        if ($lama > $n2) {
                            $selisih = $lama - $n2;
                            $sisa_n2 = 0;
                            $sisa_n1 = $n1 - $selisih;
                        } else {
                            $sisa_n2 = $n2 - $lama;
                            $sisa_n1 = $n1;
                        }

                        $sisa_n3 = $n3;
                    } else {
                        //kuota cuti = sisa tahun ini
                        $sisa_n1 = $n1 - $lama;
                        $sisa_n2 = $n2;
                        $sisa_n3 = $n3;
                    }
                } else {
                    //PPNPN
                    $sisa_n1 = $n1 - $lama;
                    $sisa_n2 = $n2;
                    $sisa_n3 = $n3;
                }

                $dataCuti = array($sisa_n1, $sisa_n2, $sisa_n3);

                for ($i = 0; $i < 3; $i++) {
                    $this->update_sisa_cuti('register_sisa_cuti_tahunan', array('sisa' => $dataCuti[$i]), 'tahun', date("Y") - $i, 'pegawai_id', $tujuanNotif);
                }

                if (in_array($status_ppk, ['1', '5'])) {
                    $dataPengguna = array(
                        'status_ppk' => $status_ppk,
                        'alasan_ppk' => $data['alasan'],
                        'id_ttd_ppk' => $id_ttd_ppk,
                        'n1' => $n1,
                        'n2' => $n2,
                        'n3' => $n3,
                        'modified_by' => $this->session->userdata('fullname'),
                        'modified_on' => date('Y-m-d H:i:s')
                    );

                    # Start Notifikasi Atasan Langsung/PLH
                    $query = $this->get_seleksi('v_cuti', 'id', $data['id'])->row();
                    $idAtasan = $query->id_validator;
                    $jabAtasan = $query->jab_validator;
                    $nama_pegawai = $query->pegawai_nama;
                    $cekPlhAtasan = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', $idAtasan);
                    if ($cekPlhAtasan->row()->pegawai_id != NULL) {
                        $tujuanNotif = $cekPlhAtasan->row()->pegawai_id;
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt ' . $jabAtasan . '*, Permohonan cuti staf pegawai atas nama ' . $nama_pegawai . ' telah disetujui oleh Pejabat Pembina Kepegawaian.';
                    } else {
                        $queryPegawai = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', $idAtasan);
                        $tujuanNotif = $queryPegawai->row()->pegawai_id;
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $jabAtasan . '*, Permohonan cuti staf pegawai atas nama ' . $nama_pegawai . ' telah disetujui oleh Pejabat Pembina Kepegawaian.';
                    }

                    $dataNotifAtasan = array(
                        'jenis_pesan' => 'cuti',
                        'id_pemohon' => $this->session->userdata('pegawai_id'),
                        'pesan' => $pesan,
                        'id_tujuan' => $tujuanNotif,
                        'created_by' => $this->session->userdata('fullname'),
                        'created_on' => date('Y-m-d H:i:s')
                    );

                    $this->kirim_notif($dataNotifAtasan);
                    # End Notifikasi Atasan Langsung/PLH

                    # Kirim notif ke Bagian Kepegawaian
                    # Cek apakah Kasub Kepegawaian ada PLH
                    $queryPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '11');
                    if ($queryPlh->row()->pegawai_id != NULL) {
                        $tujuanNotif = $queryPlh->row()->pegawai_id;
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt Kepala Sub Bagian Kepegawaian MS Banda Aceh*, Ada permohonan cuti yang disetujui oleh Pejabat Pembina Kepegawaian, silakan berikan nomor untuk legalisasi Cuti Tahunan melalui LITERASI MS Banda Aceh. Terima Kasih.';
                    } else {
                        $queryPegawai = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', '11');
                        $tujuanNotif = $queryPegawai->row()->pegawai_id;
                        $pesan = 'Assalamualaikum Wr. Wb., Yth. *Kepala Sub Bagian Kepegawaian MS Banda Aceh*, Ada permohonan cuti yang disetujui oleh Pejabat Pembina Kepegawaian, silakan berikan nomor untuk legalisasi Cuti Tahunan melalui LITERASI MS Banda Aceh. Terima Kasih.';
                    }

                    //die(var_dump($dataCuti[0]));

                } else {
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $nama . '*, permohonan cuti anda, diberikan status *' . $status_valid_notif . '* dengan alasan *' . $data['alasan'] . '* oleh Pejabat Pembina Kepegawaian. Terima Kasih ';
                    $queryCatatanCuti = $this->get_seleksi2('register_catatan_cuti', 'pegawai_id', $tujuanNotif, 'tahun', date("Y"));
                    if ($queryCatatanCuti->num_rows() > 0) {
                        $dataPenangguhan = array(
                            'cuti_penangguhan' => $lama,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );

                        $this->pembaharuan_data('register_catatan_cuti', $dataPenangguhan, 'id', $queryCatatanCuti->row()->id);
                    } else {
                        $dataPenangguhan = array(
                            'cuti_penangguhan' => $lama,
                            'pegawai_id' => $tujuanNotif,
                            'tahun' => date('Y'),
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );

                        $this->simpan_data('register_catatan_cuti', $dataPenangguhan);
                    }

                    $dataPengguna = array(
                        'status_ppk' => $status_ppk,
                        'alasan_ppk' => $data['alasan'],
                        'id_ttd_ppk' => $id_ttd_ppk,
                        'status_cuti' => $data['status'],
                        'modified_by' => $this->session->userdata('fullname'),
                        'modified_on' => date('Y-m-d H:i:s')
                    );
                }
            } else { # Untuk Cuti Selain Cuti Tahunan
                $pegawai_id = $tujuanNotif;
                # Kirim notif ke Bagian Kepegawaian
                # Cek apakah Kasub Kepegawaian ada PLH
                $queryPlh = $this->get_seleksi($this->db_sso . '.v_plh', 'plh_id_jabatan', '11');
                if ($queryPlh->row()->pegawai_id != NULL) {
                    $tujuanNotif = $queryPlh->row()->pegawai_id;
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *Plh/Plt Kepala Sub Bagian Kepegawaian MS Banda Aceh*, Ada permohonan cuti yang disetujui oleh Pejabat Pembina Kepegawaian, silakan berikan nomor untuk legalisasi Cuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                } else {
                    $queryPegawai = $this->get_seleksi($this->db_sso . '.v_users', 'jab_id', '11');
                    $tujuanNotif = $queryPegawai->row()->pegawai_id;
                    $pesan = 'Assalamualaikum Wr. Wb., Yth. *Kepala Sub Bagian Kepegawaian MS Banda Aceh*, Ada permohonan cuti yang disetujui oleh Pejabat Pembina Kepegawaian, silakan berikan nomor untuk legalisasi Cuti melalui LITERASI MS Banda Aceh. Terima Kasih.';
                }

                $dataPengguna = array(
                    'status_ppk' => $status_ppk,
                    'alasan_ppk' => $data['alasan'],
                    'id_ttd_ppk' => $id_ttd_ppk,
                    'n1' => $n1,
                    'n2' => $n2,
                    'n3' => $n3,
                    'modified_by' => $this->session->userdata('fullname'),
                    'modified_on' => date('Y-m-d H:i:s')
                );

                $queryCatatanCuti = $this->get_seleksi2('register_catatan_cuti', 'pegawai_id', $pegawai_id, 'tahun', date('Y', strtotime($mulai)));
                if ($queryCatatanCuti->num_rows() > 0) {
                    $idCatCuti = $queryCatatanCuti->row()->id;
                    if ($jenis == '2') {
                        $cuti_sakit = $queryCatatanCuti->row()->cuti_sakit;
                        $cuti_sakit = $cuti_sakit + $lama;
                        $dataCuti = array(
                            'cuti_sakit' => $cuti_sakit,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                    } elseif ($jenis == '3') {
                        $cuti_lahir = $queryCatatanCuti->row()->cuti_lahir;
                        $cuti_lahir = $cuti_lahir + $lama;
                        $dataCuti = array(
                            'cuti_lahir' => $cuti_lahir,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                    } elseif ($jenis == '4') {
                        $cuti_besar = $queryCatatanCuti->row()->cuti_besar;
                        $cuti_besar = $cuti_besar + $lama;
                        $dataCuti = array(
                            'cuti_besar' => $cuti_besar,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );

                        $dataCatatanCuti = array(0, 0, 0);
                        for ($i = 0; $i < 3; $i++) {
                            $data = array(
                                'sisa' => $dataCatatanCuti[$i],
                                'modified_by' => $this->session->userdata('fullname'),
                                'modified_on' => date('Y-m-d H:i:s')
                            );
                            $this->update_sisa_cuti('register_cuti_sisa_tahunan', $data, 'tahun', date("Y") - $i, 'pegawai_id', $pegawai_id);
                        }
                    } elseif ($jenis == '5') {
                        $cuti_ap = $queryCatatanCuti->row()->cuti_alasan_penting;
                        $cuti_ap = $cuti_ap + $lama;
                        $dataCuti = array(
                            'cuti_alasan_penting' => $cuti_ap,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                    } else {
                        $cuti_ltn = $queryCatatanCuti->row()->cuti_ltn;
                        $cuti_ltn = $cuti_ltn + $lama;
                        $dataCuti = array(
                            'cuti_ltn' => $cuti_ltn,
                            'modified_by' => $this->session->userdata('fullname'),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                    }

                    $this->pembaharuan_data('cuti_catatan', $dataCuti, 'id', $idCatCuti);
                } else {
                    if ($jenis == '2') {
                        $dataCuti = array(
                            'pegawai_id' => $pegawai_id,
                            'tahun' => date('Y', strtotime($mulai)),
                            'cuti_sakit' => $lama,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    } elseif ($jenis == '3') {
                        $dataCuti = array(
                            'pegawai_id' => $pegawai_id,
                            'tahun' => date('Y', strtotime($mulai)),
                            'cuti_lahir' => $lama,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    } elseif ($jenis == '4') {
                        $dataCuti = array(
                            'pegawai_id' => $pegawai_id,
                            'tahun' => date('Y', strtotime($mulai)),
                            'cuti_besar' => $lama,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );

                        $dataCatatanCuti = array('0', '0', '0');
                        for ($i = 0; $i < 3; $i++) {
                            $data = array(
                                'sisa' => $dataCatatanCuti[$i],
                                'modified_by' => $this->session->userdata('fullname'),
                                'modified_on' => date('Y-m-d H:i:s')
                            );

                            $this->update_sisa_cuti('cuti_sisa_tahunan', $data, 'tahun', date("Y") - $i, 'pegawai_id', $pegawai_id);
                        }
                    } elseif ($jenis == '5') {
                        $dataCuti = array(
                            'pegawai_id' => $pegawai_id,
                            'tahun' => date('Y', strtotime($mulai)),
                            'cuti_alasan_penting' => $lama,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    } else {
                        $dataCuti = array(
                            'pegawai_id' => $pegawai_id,
                            'tahun' => date('Y', strtotime($mulai)),
                            'cuti_ltn' => $lama,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    }

                    $this->simpan_data('register_catatan_cuti', $dataCuti);
                }
            }

            $dataNotif = array(
                'jenis_pesan' => 'cuti',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            //die(var_dump($dataPengguna));
        } else {
            $pesan = 'Assalamualaikum Wr. Wb., Yth. *' . $nama . '*, permohonan cuti anda, diberikan status *' . $status_valid_notif . '* dengan alasan *' . $data['alasan'] . '* oleh Pejabat Pembina Kepegawaian. Terima Kasih ';
            $dataPengguna = array(
                'status_ppk' => $status_ppk,
                'alasan_ppk' => $data['alasan'],
                'id_ttd_ppk' => $id_ttd_ppk,
                'n1' => $n1,
                'n2' => $n2,
                'n3' => $n3,
                'status_cuti' => $data['status'],
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $dataNotif = array(
                'jenis_pesan' => 'cuti',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );
        }

        $querySimpan = $this->pembaharuan_data('register_cuti', $dataPengguna, 'id', $data['id']);
        $this->kirim_notif($dataNotif);

        if ($querySimpan == 1) {
            return ['status' => true, 'message' => 'Permohonan Cuti Berhasil di Validasi, Notifikasi Akan Segera Dikirim'];
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan Validasi, ' . $querySimpan];
        }
    }

    public function getDetailCuti($idDecrypt)
    {
        $query = $this->get_seleksi('v_cuti', 'id', $idDecrypt);
        if (!$query || !$query->row()) {
            return null;
        }
        $cuti = $query->row();

        $data['nomor_cuti'] = $cuti->nomor_cuti;
        $data['nama'] = $cuti->pegawai_nama;
        $data['nip'] = $cuti->nip;
        $data['jabatan'] = $cuti->pegawai_jabatan;
        $data['pangkat'] = $cuti->golongan . ' | ' . $cuti->pangkat;
        $data['id_grup'] = $cuti->id_grup;
        $jml_hari = $this->tanggalhelper->getSelisihHari($cuti->tmt, date('Y-m-d'));
        $data['masa_kerja'] = $this->tanggalhelper->konversiMasaKerja($jml_hari);
        $data['jenis'] = $cuti->jenis_cuti;
        $data['alasan'] = $cuti->alasan;
        $lama_hari = $cuti->lama;
        if ($lama_hari > 30 && $lama_hari <= 365) {
            $data['lama'] = $this->tanggalhelper->konversiMasaKerjaBulan($lama_hari) . ' Bulan';
        } elseif ($lama_hari > 365) {
            $data['lama'] = $this->tanggalhelper->konversiMasaKerjaTahun($lama_hari) . ' Tahun';
        } else {
            $data['lama'] = $lama_hari . ' Hari';
        }
        $data['tgl_awal'] = $this->tanggalhelper->convertDayDate($cuti->tgl_awal);
        $data['tgl_akhir'] = $this->tanggalhelper->convertDayDate($cuti->tgl_akhir);
        $data['n1'] = $cuti->n1;
        $data['n2'] = $cuti->n2;
        $data['n3'] = $cuti->n3;

        $queryCatatanCuti = $this->get_seleksi2('register_catatan_cuti', 'pegawai_id', $cuti->pegawai_id, 'tahun', date('Y'));
        if ($queryCatatanCuti->num_rows > 0) {
            $data['cat_cuti_besar'] = $queryCatatanCuti->row()->cuti_besar;
            $data['cat_cuti_sakit'] = $queryCatatanCuti->row()->cuti_sakit;
            $data['cat_cuti_lahir'] = $queryCatatanCuti->row()->cuti_lahir;
            $data['cat_cuti_ap'] = $queryCatatanCuti->row()->cuti_alasan_penting;
            $data['cat_cuti_ltn'] = $queryCatatanCuti->row()->cuti_tln;
        } else {
            $data['cat_cuti_besar'] = NULL;
            $data['cat_cuti_sakit'] = NULL;
            $data['cat_cuti_lahir'] = NULL;
            $data['cat_cuti_ap'] = NULL;
            $data['cat_cuti_ltn'] = NULL;
        }

        $data['alamat'] = $cuti->alamat;
        $data['nohp'] = $cuti->nohp;
        $data['nama_validator'] = $cuti->nama_ttd_validator;
        $data['nip_validator'] = $cuti->nip_ttd_validator;
        $data['status_validator'] = $cuti->status_validator;
        $data['alasan_validator'] = $cuti->alasan_validator;
        $data['nama_ppk'] = $cuti->nama_ttd_ppk;
        $data['nip_ppk'] = $cuti->nip_ttd_ppk;
        $data['status_ppk'] = $cuti->status_ppk;
        $data['alasan_ppk'] = $cuti->alasan_ppk;
        $data['modified_on'] = date('Y-m-d', strtotime($cuti->modified_on));

        $data['userid_pegawai'] = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $cuti->pegawai_id)->row()->userid;
        $data['userid_validator'] = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $cuti->id_ttd_validator)->row()->userid;
        $data['userid_ppk'] = $this->get_seleksi($this->db_sso . '.v_users', 'pegawai_id', $cuti->id_ttd_ppk)->row()->userid;

        return $data;
    }

    public function cek_tanggal($awal, $akhir)
    {
        $this->db->distinct();
        $this->db->select('a.pegawai_nama, lama, tgl_awal, tgl_akhir');
        $this->db->from('v_cuti a');
        $this->db->join($this->db_sso . '.v_pegawai c', 'a.pegawai_id = c.id', 'left outer');
        $this->db->where("(('$awal' BETWEEN tgl_awal AND tgl_akhir) OR (tgl_awal BETWEEN '$awal' AND '$akhir'))");
        $this->db->where('jenis_cuti', '1');
        $this->db->where_in('status_cuti', [0, 1]);

        $query = $this->db->get();
        return $query->result();
    }

    public function update_sisa_cuti($tabel, $data, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            $this->db->update($tabel, $data);
            $title = "PERBARUI DATA [Tabel=<b>" . $tabel . "</b> oleh " . $this->session->userdata('fullname') . "]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function cari_data_keluar($tgl_awal, $tgl_akhir)
    {
        $this->db->order_by('created_on', 'ASC');
        return $this->db->select('*')->from('v_izin_keluar')->where('Date(created_on) BETWEEN "' . $tgl_awal . '" AND "' . $tgl_akhir . '"')->get()->result();
    }

    public function cari_data_diklat($tgl_awal, $tgl_akhir)
    {
        $this->db->order_by('created_on', 'ASC');
        return $this->db->select('*')->from('v_izin_diklat')->where('Date(created_on) BETWEEN "' . $tgl_awal . '" AND "' . $tgl_akhir . '"')->get()->result();
    }

    public function cari_data_cuti($tgl_awal, $tgl_akhir)
    {
        $this->db->order_by('created_on', 'ASC');
        return $this->db->select('*')->from('v_cuti')->where('Date(created_on) BETWEEN "' . $tgl_awal . '" AND "' . $tgl_akhir . '"')->get()->result();
    }

    public function get_tahun_terakhir()
    {
        try {
            $this->db->select('YEAR(tgl) as year');
            $this->db->from('register_hari_libur');
            $this->db->order_by('tgl', 'DESC');
            $this->db->limit(1);
            return $this->db->get();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function proses_simpan_hari_libur($data)
    {
        $dataLibur = array(
            'tgl' => $data['tgl'],
            'ket' => $data['ket']
        );

        if ($data['id'] != '-1') {
            $dataLibur['modified_on'] = date('Y-m-d H:i:s');
            $dataLibur['modified_by'] = $this->session->userdata('fullname');

            $querySimpan = $this->pembaharuan_data('register_hari_libur', $dataLibur, 'id', $data['id']);
        } else {
            $dataLibur['created_on'] = date('Y-m-d H:i:s');
            $dataLibur['created_by'] = $this->session->userdata('fullname');

            $querySimpan = $this->simpan_data('register_hari_libur', $dataLibur);
        }

        if ($querySimpan == 1) {
            if ($data['id'])
                return ['status' => true, 'message' => 'Hari Libur Berhasil di Perbarui'];
            else
                return ['status' => true, 'message' => 'Hari Libur Berhasil di Tambah'];
        } else
            return ['status' => false, 'message' => 'Gagal Simpan, ' . $querySimpan];
    }

    public function proses_simpan_sisa_cuti($tahun)
    {
        $active_pegawai = $this->model->get_seleksi($this->db_sso . '.pegawai', 'status_pegawai', '1');
        $data = array();

        foreach ($active_pegawai as $pegawai) {
            //proses penginputan ke tabel sisa cuti
            $data[] = array(
                'pegawai_id' => $pegawai->id,
                'tahun' => $tahun,
                'sisa' => '12',
                'created_by' => $this->session->userdata("fullname"),
                'created_on' => date('Y-m-d H:i:s')
            );
        }

        $query = $this->simpan_data('register_sisa_cuti_tahunan', $data);
        if ($query) {
            return ['status' => true, 'message' => 'Sisa Cuti Tahunan Berhasil Diinisialisasi'];
        } else {
            return ['status' => false, 'message' => 'Sisa Cuti Tahunan Gagal Diinisialisasi. Periksa Kembali atau Hubungi Admin'];
        }
    }

    public function show_all_sisa_cuti()
    {
        $this->db->select('p.id AS pegawai_id, 
                   p.nama_gelar AS nama,
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) THEN s.id ELSE NULL END) AS id_n1, 
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) - 1 THEN s.id ELSE NULL END) AS id_n2, 
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) - 2 THEN s.id ELSE NULL END) AS id_n3, 
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) THEN s.sisa ELSE NULL END) AS n1, 
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) - 1 THEN s.sisa ELSE NULL END) AS n2, 
                   MAX(CASE WHEN s.tahun = YEAR(CURDATE()) - 2 THEN s.sisa ELSE NULL END) AS n3');

        $this->db->from($this->db_sso . '.pegawai p');
        $this->db->join('register_sisa_cuti_tahunan s', 'p.id = s.pegawai_id', 'left');
        $this->db->where('p.status_pegawai', 1);
        $this->db->where('p.jenis_pegawai <>', 5);
        $this->db->group_by('p.id');
        $this->db->order_by('p.jenis_pegawai', 'ASC');
        $this->db->order_by('p.jabatan_id', 'ASC');
        $this->db->order_by('p.id', 'ASC');
        return $this->db->get()->result_array();
    }
}