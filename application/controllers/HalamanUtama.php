<?php

class HalamanUtama extends MY_Controller
{
    public function index()
    {
        #die(var_dump($this->session->all_userdata()));
        $data['peran'] = $this->session->userdata('peran');
        $data['page'] = 'dashboard';

        $this->load->view('layout', $data);
    }

    public function page($halaman)
    {
        // Amanin nama file view agar tidak sembarang file bisa diload
        $allowed = [
            'dashboard',
            'legal_cuti',
            'legal_diklat',
            'izin_keluar',
            'izin_diklat',
            'cuti',
            'validasi_izin_keluar',
            'validasi_izin_diklat',
            'validasi_cuti_atasan',
            'validasi_cuti_ppk',
            'register_izin_keluar',
            'register_izin_diklat',
            'register_cuti',
            'laporan_izin_keluar',
            'laporan_izin_diklat',
            'laporan_cuti',
            'tgl_merah',
            'sisa_cuti',
        ];

        if (in_array($halaman, $allowed)) {
            $data['peran'] = $this->session->userdata('peran');
            $data['page'] = $halaman;
            
            $this->load->view($halaman, $data);
        } else {
            show_404();
        }
    }

    public function cek_token_sso()
    {
        $token = $this->input->cookie('sso_token');
        $cookie_domain = $this->session->userdata('sso_server');
        $sso_api = $cookie_domain . "api/cek_token?sso_token={$token}";
        $response = file_get_contents($sso_api);
        $data = json_decode($response, true);

        if ($data['status'] == 'success') {
            echo json_encode(['valid' => true]);
        } else {
            echo json_encode(['valid' => false, 'message' => 'Token Expired, Silakan login ulang', 'url' => $cookie_domain . 'login']);
        }
    }

    public function keluar()
    {
        $sso_server = $this->session->userdata('sso_server');
        $this->session->sess_destroy();
        redirect($sso_server . '/keluar');
    }

    public function show_role()
    {
        $id = $this->input->post('id');
        $data = [
            "tabel" => "v_users",
            "kolom_seleksi" => "status_pegawai",
            "seleksi" => "1"
        ];

        $users = $this->apihelper->get('apiclient/get_data_seleksi', $data);

        $pegawai = array();
        if ($users['status_code'] === '200') {
            foreach ($users['response']['data'] as $item) {
                $pegawai[$item['userid']] = $item['fullname'];
            }
        }

        if ($id != '-1') {
            $query = $this->model->get_seleksi('peran', 'id', $id);

            echo json_encode(
                array(
                    'pegawai' => $users['response']['data'],
                    'role' => $pegawai,
                    'id' => $query->row()->id,
                    'editPegawai' => $query->row()->userid,
                    'editPeran' => $query->row()->role
                )
            );
        } else {
            $dataPeran = $this->model->get_data_peran();
            #die(var_dump($dataPeran));

            echo json_encode(
                array(
                    'pegawai' => $users['response']['data'],
                    'role' => $pegawai,
                    'data_peran' => $dataPeran
                )
            );
        }

        return;
    }

    public function simpan_peran()
    {
        $id = $this->input->post('id');
        $pegawai = $this->input->post('pegawai');
        $peran = $this->input->post('peran');

        if ($id) {
            $data = array(
                'userid' => $pegawai,
                'role' => $peran,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        } else {
            $query = $this->model->get_seleksi('peran', 'userid', $pegawai);
            if ($query->num_rows() > 0) {
                echo json_encode(['success' => 2, 'message' => 'Pegawai tersebut sudah memiliki peran']);
            }

            $data = array(
                'userid' => $pegawai,
                'role' => $peran,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->simpan_data('peran', $data);
        }

        if ($query === 1) {
            echo json_encode(['success' => 1, 'message' => 'Penunjukan Peran Pegawai Berhasil']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Gagal Menunjuk Peran Pegawai']);
        }
    }

    public function aktif_peran()
    {
        $id = $this->input->post('id');

        $data = array(
            'hapus' => '0',
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        if ($query == '1') {
            echo json_encode(
                array(
                    'st' => '1'
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => '0'
                )
            );
        }
    }

    public function blok_peran()
    {
        $id = $this->input->post('id');

        $data = array(
            'hapus' => '1',
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        if ($query == '1') {
            echo json_encode(
                array(
                    'st' => '1'
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => '0'
                )
            );
        }
    }

    public function statistik_bulanan_izin_keluar()
    {
        $data = $this->model->statistik_bulanan('register_izin_keluar')->result_array();
        echo json_encode($data);
    }

    public function statistik_bulanan_izin_diklat()
    {
        $data = $this->model->statistik_bulanan('register_izin_diklat')->result_array();
        echo json_encode($data);
    }

    public function statistik_bulanan_cuti()
    {
        $data = $this->model->statistik_bulanan('register_cuti')->result_array();
        echo json_encode($data);
    }

    public function chart_izin_keluar()
    {
        $data = $this->model->get_izin_keluar_statistik();
        echo json_encode($data);
    }

    public function chart_izin_diklat()
    {
        $data = $this->model->get_izin_diklat_statistik();
        echo json_encode($data);
    }

    public function chart_cuti()
    {
        $data = $this->model->get_cuti_statistik();
        echo json_encode($data);
    }

    public function ambil_permohonan_nomor()
    {
        $req_nomor = $this->model->cuti_legalisasi_data()->result_array();
        echo json_encode($req_nomor);
    }

    public function ambil_permohonan_dokumen()
    {
        $req_nomor = $this->model->get_seleksi('register_izin_diklat', 'status_permohonan', '1')->result_array();
        echo json_encode($req_nomor);
    }

    public function ambil_permohonan_izin_keluar()
    {
        $req_izin = $this->model->get_seleksi2('register_izin_keluar', 'jab_tujuan', $this->session->userdata('jab_id'), 'status', '0')->result_array();
        echo json_encode($req_izin);
    }

    public function ambil_permohonan_izin_diklat()
    {
        $req_izin = $this->model->get_seleksi2('register_izin_diklat', 'tujuan_permohonan', $this->session->userdata('jab_id'), 'status_permohonan', '0')->result_array();
        echo json_encode($req_izin);
    }

    public function ambil_permohonan_cuti_atasan()
    {
        $req_cuti = $this->model->get_seleksi2('register_cuti', 'id_validator', $this->session->userdata('jab_id'), 'status_validator', '0')->result_array();
        echo json_encode($req_cuti);
    }

    public function ambil_permohonan_cuti_ppk()
    {
        $req_cuti = $this->model->get_seleksi2('register_cuti', 'id_ppk', $this->session->userdata('jab_id'), 'status_ppk', '0')->result_array();
        echo json_encode($req_cuti);
    }
}