<?php

class HalamanCuti extends MY_Controller
{

    public function statistik_cuti()
    {
        $data['jum_cuti_user'] = $this->model->get_seleksi('register_cuti', 'pegawai_id', $this->session->userdata('pegawai_id'))->num_rows();
        $data['jum_cuti_user_setuju'] = $this->model->get_seleksi_in('register_cuti', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_cuti', [1, 5])->num_rows();
        $data['jum_cuti_user_tolak'] = $this->model->get_seleksi_in('register_cuti', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_cuti', [4, 8])->num_rows();

        echo json_encode($data);
    }

    public function statistik_validasi_cuti_atasan()
    {
        $data['jum_validasi_cuti_atasan'] = $this->model->get_seleksi('register_cuti', 'id_validator', $this->session->userdata('jab_id'))->num_rows();
        $data['jum_validasi_cuti_atasan_proses'] = $this->model->get_seleksi_in('register_cuti', 'id_validator', $this->session->userdata('jab_id'), 'status_validator', [1, 2, 3, 4, 5, 6, 7, 8])->num_rows();
        $data['pgrs_all'] = round($data['jum_validasi_cuti_atasan'] / $data['jum_validasi_cuti_atasan'] * 100, 2);
        $data['pgrs_proses'] = round($data['jum_validasi_cuti_atasan_proses'] / $data['jum_validasi_cuti_atasan'] * 100, 2);

        echo json_encode($data);
    }

    public function statistik_validasi_cuti_ppk()
    {
        $data['jum_validasi_cuti'] = $this->model->get_seleksi('register_cuti', 'id_ppk', $this->session->userdata('jab_id'))->num_rows();
        $data['jum_validasi_cuti_proses'] = $this->model->get_seleksi_in('register_cuti', 'id_ppk', $this->session->userdata('jab_id'), 'status_ppk', [1, 2, 3, 4, 5, 6, 7, 8])->num_rows();
        $data['pgrs_all'] = round($data['jum_validasi_cuti'] / $data['jum_validasi_cuti'] * 100, 2);
        $data['pgrs_proses'] = round($data['jum_validasi_cuti_proses'] / $data['jum_validasi_cuti'] * 100, 2);

        echo json_encode($data);
    }

    public function show_tabel_permohonan_cuti()
    {
        $id = $this->session->userdata('pegawai_id');
        $queryCuti = $this->model->get_seleksi_order('register_cuti', 'pegawai_id', $id, 'status_cuti', 'ASC')->result();

        $dataCuti = [];
        foreach ($queryCuti as $row) {
            $dataCuti[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'created_on' => $row->created_on,
                'jenis' => $row->jenis_cuti,
                'lama' => $row->lama,
                'status_cuti' => $row->status_cuti
            ];
        }

        echo json_encode(['data_cuti' => $dataCuti]);
    }

    public function show_tabel_validasi_cuti_atasan()
    {
        $queryCuti = $this->model->get_seleksi_order('v_cuti', 'id_validator', $this->session->userdata('jab_id'), 'status_validator', 'ASC')->result();

        $dataCuti = [];
        foreach ($queryCuti as $row) {
            $dataCuti[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->pegawai_nama,
                'created_on' => $row->created_on,
                'jenis' => $row->jenis_cuti,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_awal),
                'tgl_akhir' => $this->tanggalhelper->convertDayDate($row->tgl_akhir),
                'status' => $row->status_validator,
                'status_cuti' => $row->status_cuti
            ];
        }

        echo json_encode(['data_cuti' => $dataCuti]);
    }

    public function show_tabel_validasi_cuti_ppk()
    {
        $queryCuti = $this->model->get_data_validasi_ppk()->result();

        $dataCuti = [];
        foreach ($queryCuti as $row) {
            $dataCuti[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->pegawai_nama,
                'created_on' => $row->created_on,
                'jenis' => $row->jenis_cuti,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_awal),
                'tgl_akhir' => $this->tanggalhelper->convertDayDate($row->tgl_akhir),
                'status' => $row->status_ppk,
                'status_cuti' => $row->status_cuti
            ];
        }

        echo json_encode(['data_cuti' => $dataCuti]);
    }

    public function show_tabel_legalisasi_cuti()
    {
        $query = $this->model->cuti_legalisasi_data()->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->pegawai_nama,
                'jenis' => $row->jenis_cuti
            ];
        }

        echo json_encode(['data_cuti' => $data]);
    }

    public function show_cuti_admin()
    {
        $id = $this->input->post('id');
        $id_cuti_edit = $this->encryption->decrypt(base64_decode($this->input->post('id_cuti_edit'))); // ID cuti untuk edit

        $n1 = 0;
        $n2 = 0;
        $n3 = 0;
        $kuota_cuti = 0;

        $queryn1 = $this->model->cek_sisa_cuti(date("Y"), $id);
        $queryn2 = $this->model->cek_sisa_cuti(date("Y") - 1, $id);
        $queryn3 = $this->model->cek_sisa_cuti(date("Y") - 2, $id);

        //die(var_dump($this->session->userdata('id_pegawai')));
        if ($queryn1->num_rows() > 0) {
            $n1 = $queryn1->row()->sisa;
        }

        if ($queryn2->num_rows() > 0) {
            $n2 = $queryn2->row()->sisa;
        }

        if ($queryn3->num_rows() > 0) {
            $n3 = $queryn3->row()->sisa;
        }

        $data = [
            "tabel" => "v_pegawai",
            "kolom_seleksi" => "id",
            "seleksi" => $id
        ];

        $users = $this->apihelper->get('apiclient/get_data_seleksi', $data);

        if ($users['status_code'] === 200 && $users['response']['status'] == 'success') {
            $id_grup = $users['response']['data'][0]['id_grup'];
        }

        if ($id_grup != '3') {
            //Selain PPNPN
            if ($n3 == 12 && $n2 == 12) {
                $kuota_cuti = $n1 + 12;
            } elseif ($n2 == 12 || ($n2 > 6 && $n2 < 12)) {
                $kuota_cuti = $n1 + 6;
            } elseif ($n2 <= 6) {
                $kuota_cuti = $n1 + $n2;
            }
        } else {
            //PPNPN
            $kuota_cuti = $n1;
        }

        $lama = '';
        $tgl_awal = '';
        $tgl_akhir = '';
        $alasan = '';
        $alamat = '';
        $jenis_cuti = '';
        $dokumen_pendukung = '';
        $id_cuti = '';

        // Ambil data cuti sakit dan cuti alasan penting dari register_catatan_cuti
        $cuti_sakit_sudah_diambil = 0;
        $cuti_alasan_penting_sudah_diambil = 0;
        $queryCatatanCuti = $this->model->cek_cuti_sakit_alasan_penting(date("Y"), $id);
        if ($queryCatatanCuti && $queryCatatanCuti->num_rows() > 0) {
            $cuti_sakit_sudah_diambil = $queryCatatanCuti->row()->cuti_sakit ?? 0;
            $cuti_alasan_penting_sudah_diambil = $queryCatatanCuti->row()->cuti_alasan_penting ?? 0;
        }

        // Hitung sisa cuti sakit (14 hari - yang sudah diambil)
        $sisa_cuti_sakit = 14 - $cuti_sakit_sudah_diambil;
        if ($sisa_cuti_sakit < 0) {
            $sisa_cuti_sakit = 0;
        }

        // Hitung sisa cuti alasan penting (10 hari - yang sudah diambil)
        $sisa_cuti_alasan_penting = 10 - $cuti_alasan_penting_sudah_diambil;
        if ($sisa_cuti_alasan_penting < 0) {
            $sisa_cuti_alasan_penting = 0;
        }

        // Jika mode edit, ambil data cuti
        if (!empty($id_cuti_edit)) {
            $cariCuti = $this->model->get_seleksi('register_cuti', 'id', $id_cuti_edit);
            if ($cariCuti->num_rows() > 0) {
                $cuti_data = $cariCuti->row();
                $id_cuti = $id_cuti_edit;
                $lama = $cuti_data->lama;
                $tgl_awal = $cuti_data->tgl_awal;
                $tgl_akhir = $cuti_data->tgl_akhir;
                $alasan = $cuti_data->alasan;
                $alamat = $cuti_data->alamat;
                $jenis_cuti = $cuti_data->jenis_cuti;
                $dokumen_pendukung = $cuti_data->dokumen_pendukung ?? '';
            }
        }

        if ($id_grup == '6') {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '2' => 'Cuti Sakit',
                '3' => 'Cuti Melahirkan'
            );
        } elseif ($id_grup == '3') {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '3' => 'Cuti Melahirkan'
            );
        } else {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '2' => 'Cuti Sakit',
                '3' => 'Cuti Melahirkan',
                '4' => 'Cuti Besar',
                '5' => 'Cuti Alasan Penting',
                '6' => 'Cuti di Luar Tanggungan Negara'
            );
        }

        $jenis = form_dropdown('jenis', $jenis, $jenis_cuti, 'onchange="UbahKalender(this)" class="form-control" id="jenis"');

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id_cuti,
                'jenis' => $jenis,
                'jenis_cuti' => $jenis_cuti,
                'lama' => $lama,
                'kuota' => $kuota_cuti,
                'sisa_cuti_sakit' => $sisa_cuti_sakit,
                'sisa_cuti_alasan_penting' => $sisa_cuti_alasan_penting,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'alasan' => $alasan,
                'alamat' => $alamat,
                'dokumen_pendukung' => $dokumen_pendukung
            )
        );
        return;
    }

    public function show_cuti()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $n1 = 0;
        $n2 = 0;
        $n3 = 0;
        $kuota_cuti = 0;

        $queryn1 = $this->model->cek_sisa_cuti(date("Y"), $this->session->userdata('pegawai_id'));
        $queryn2 = $this->model->cek_sisa_cuti(date("Y") - 1, $this->session->userdata('pegawai_id'));
        $queryn3 = $this->model->cek_sisa_cuti(date("Y") - 2, $this->session->userdata('pegawai_id'));

        //die(var_dump($this->session->userdata('id_pegawai')));
        if ($queryn1->num_rows() > 0) {
            $n1 = $queryn1->row()->sisa;
        }

        if ($queryn2->num_rows() > 0) {
            $n2 = $queryn2->row()->sisa;
        }

        if ($queryn3->num_rows() > 0) {
            $n3 = $queryn3->row()->sisa;
        }

        if ($this->session->userdata('id_grup') != '3') {
            //Selain PPNPN
            if ($n3 == 12 && $n2 == 12) {
                $kuota_cuti = $n1 + 12;
            } elseif ($n2 == 12 || ($n2 > 6 && $n2 < 12)) {
                $kuota_cuti = $n1 + 6;
            } elseif ($n2 <= 6) {
                $kuota_cuti = $n1 + $n2;
            }
        } else {
            //PPNPN
            $kuota_cuti = $n1;
        }

        // Ambil data cuti sakit dan cuti alasan penting dari register_catatan_cuti
        // Hitung sisa cuti sakit (14 hari - yang sudah diambil) dan sisa cuti alasan penting (10 hari - yang sudah diambil)
        $cuti_sakit_sudah_diambil = 0;
        $cuti_alasan_penting_sudah_diambil = 0;
        $queryCatatanCuti = $this->model->cek_cuti_sakit_alasan_penting(date("Y"), $this->session->userdata('pegawai_id'));
        if ($queryCatatanCuti && $queryCatatanCuti->num_rows() > 0) {
            $cuti_sakit_sudah_diambil = $queryCatatanCuti->row()->cuti_sakit ?? 0;
            $cuti_alasan_penting_sudah_diambil = $queryCatatanCuti->row()->cuti_alasan_penting ?? 0;
        }

        // Hitung sisa cuti sakit (14 hari - yang sudah diambil)
        $sisa_cuti_sakit = 14 - $cuti_sakit_sudah_diambil;
        if ($sisa_cuti_sakit < 0) {
            $sisa_cuti_sakit = 0;
        }

        // Hitung sisa cuti alasan penting (10 hari - yang sudah diambil)
        $sisa_cuti_alasan_penting = 10 - $cuti_alasan_penting_sudah_diambil;
        if ($sisa_cuti_alasan_penting < 0) {
            $sisa_cuti_alasan_penting = 0;
        }

        $lama = '';
        $tgl_awal = '';
        $tgl_akhir = '';
        $alasan = '';
        $alamat = '';
        $jenis_cuti = '';

        if ($this->session->userdata('id_grup') == '6') {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '2' => 'Cuti Sakit',
                '3' => 'Cuti Melahirkan'
            );
        } elseif ($this->session->userdata('id_grup') == '3') {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '3' => 'Cuti Melahirkan'
            );
        } else {
            $jenis = array(
                '' => "Pilih Jenis Cuti",
                '1' => 'Cuti Tahunan',
                '2' => 'Cuti Sakit',
                '3' => 'Cuti Melahirkan',
                '4' => 'Cuti Besar',
                '5' => 'Cuti Alasan Penting',
                '6' => 'Cuti di Luar Tanggungan Negara'
            );
        }

        $dokumen_pendukung = '';
        if ($id == '-1') {
            $judul = "PERMOHONAN CUTI BARU";
            $id = '';
            $jenis = form_dropdown('jenis', $jenis, '', 'onchange="UbahKalender(this)" class="form-control" id="jenis"');
        } else {
            $judul = "EDIT DATA PERMOHONAN CUTI";
            $cariCuti = $this->model->get_seleksi('register_cuti', 'id', $id);
            $lama = $cariCuti->row()->lama;
            $tgl_awal = $cariCuti->row()->tgl_awal;
            $tgl_akhir = $cariCuti->row()->tgl_akhir;
            $alasan = $cariCuti->row()->alasan;
            $alamat = $cariCuti->row()->alamat;
            $jenis_cuti = $cariCuti->row()->jenis_cuti;
            $dokumen_pendukung = $cariCuti->row()->dokumen_pendukung ?? '';
            $jenis = form_dropdown('jenis', $jenis, $jenis_cuti, 'onchange="UbahKalender(this)" class="form-control" id="jenis"');
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'jenis' => $jenis,
                'jenis_cuti' => $jenis_cuti,
                'lama' => $lama,
                'kuota' => $kuota_cuti,
                'sisa_cuti_sakit' => $sisa_cuti_sakit,
                'sisa_cuti_alasan_penting' => $sisa_cuti_alasan_penting,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'alasan' => $alasan,
                'alamat' => $alamat,
                'dokumen_pendukung' => $dokumen_pendukung
            )
        );
        return;
    }

    public function show_cuti_validasi()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "VALIDASI PERMOHONAN CUTI PEGAWAI";

        $cariCuti = $this->model->get_seleksi('v_cuti', 'id', $id);
        $nama = $cariCuti->row()->pegawai_nama;
        $nip = $cariCuti->row()->nip;
        $jabatan = $cariCuti->row()->pegawai_jabatan;
        switch ($cariCuti->row()->jenis_cuti) {
            case 1:
                $jenis_cuti = "Cuti Tahunan";
                break;
            case 2:
                $jenis_cuti = "Cuti Sakit";
                break;
            case 3:
                $jenis_cuti = "Cuti Melahirkan";
                break;
            case 4:
                $jenis_cuti = "Cuti Besar";
                break;
            case 5:
                $jenis_cuti = "Cuti Alasan Penting";
                break;
            case 6:
                $jenis_cuti = "Cuti di Luar Tanggungan Negara";
                break;
        }

        $tgl_awal = $this->tanggalhelper->convertDayDate($cariCuti->row()->tgl_awal);
        $tgl_akhir = $this->tanggalhelper->convertDayDate($cariCuti->row()->tgl_akhir);
        $alasan = $cariCuti->row()->alasan;
        $alamat = $cariCuti->row()->alamat;
        $jenis_cuti_id = $cariCuti->row()->jenis_cuti; // ID jenis cuti (angka)
        $dokumen_pendukung = $cariCuti->row()->dokumen_pendukung ?? '';

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'nip' => $nip,
                'jabatan' => $jabatan,
                'jenis_cuti' => $jenis_cuti,
                'jenis_cuti_id' => $jenis_cuti_id, // ID jenis cuti untuk cek apakah 2 atau 5
                'dokumen_pendukung' => $dokumen_pendukung,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'alamat' => $alamat,
                'alasan' => $alasan
            )
        );
        return;
    }

    public function show_nomor()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "PENOMORAN CUTI";

        $cariCuti = $this->model->get_seleksi('v_cuti', 'id', $id);
        $nama = $cariCuti->row()->pegawai_nama;
        $jabatan = $cariCuti->row()->pegawai_jabatan;
        $nip = $cariCuti->row()->nip;
        $id_grup = $cariCuti->row()->id_grup;
        $tgl = date('Y-m-d', strtotime($cariCuti->row()->created_on));
        switch ($cariCuti->row()->jenis_cuti) {
            case 1:
                $jenis_cuti = "Cuti Tahunan";
                break;
            case 2:
                $jenis_cuti = "Cuti Sakit";
                break;
            case 3:
                $jenis_cuti = "Cuti Melahirkan";
                break;
            case 4:
                $jenis_cuti = "Cuti Besar";
                break;
            case 5:
                $jenis_cuti = "Cuti Alasan Penting";
                break;
            case 6:
                $jenis_cuti = "Cuti di Luar Tanggungan Negara";
                break;
        }

        switch ($id_grup) {
            case 1:
                $grup = 'Hakim';
                break;
            case 2:
                $grup = 'PNS';
                break;
            case 3:
                $grup = 'PPNPN';
                break;
            case 4:
                $grup = 'Calon Hakim';
                break;
            case 5:
                $grup = 'Operator';
                break;
            case 6:
                $grup = 'PPPK';
                break;
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'nip' => $nip,
                'id_grup' => $id_grup,
                'grup' => $grup,
                'tanggal' => $this->tanggalhelper->convertDayDate($tgl),
                'jenis_cuti' => $jenis_cuti
            )
        );
        return;
    }

    public function simpan_cuti()
    {
        $this->form_validation->set_rules('jenis', 'Jenis Cuti', 'trim|required');
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('lama', 'Lama Cuti', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Selama Cuti', 'trim|required');
        $this->form_validation->set_rules('alasan', 'Alasan Cuti', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $jenis_cuti = $this->input->post('jenis');
        $id_cuti = $this->input->post('id');
        $dokumen_pendukung = '';

        // Cek apakah edit dan sudah ada dokumen
        $dokumen_lama = '';
        if (!empty($id_cuti)) {
            $cuti_lama = $this->model->get_seleksi('register_cuti', 'id', $id_cuti);
            if ($cuti_lama->num_rows() > 0) {
                $dokumen_lama = $cuti_lama->row()->dokumen_pendukung ?? '';
            }
        }

        // Validasi upload dokumen untuk cuti sakit (2) dan cuti alasan penting (5)
        if (in_array($jenis_cuti, ['2', '5'])) {
            // Jika edit dan sudah ada dokumen, tidak wajib upload ulang
            // Tapi jika upload file baru, proses upload
            if (!empty($_FILES['dokumen_pendukung']['name'])) {
                // Ada file baru yang diupload

                // Konfigurasi upload
                $config['upload_path'] = './dokumen/cuti/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB dalam KB
                $config['encrypt_name'] = TRUE;

                // Buat folder jika belum ada
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dokumen_pendukung')) {
                    $error = $this->upload->display_errors('', '');
                    echo json_encode(['success' => 2, 'message' => 'Upload Dokumen Gagal: ' . $error]);
                    return;
                }

                $upload_data = $this->upload->data();
                $dokumen_pendukung = $upload_data['file_name'];
            } elseif (empty($dokumen_lama)) {
                // Tidak ada file baru dan tidak ada file lama, wajib upload
                echo json_encode(['success' => 2, 'message' => 'Dokumen Pendukung Tidak Boleh Kosong untuk Cuti Sakit dan Cuti Alasan Penting']);
                return;
            } else {
                // Tidak ada file baru tapi ada file lama, gunakan file lama
                $dokumen_pendukung = $dokumen_lama;
            }
        }

        $data = [
            'id' => $this->input->post('id'),
            'pegawai_id' => $this->session->userdata('pegawai_id'),
            'jenis' => $jenis_cuti,
            'tgl_awal' => $this->input->post('tgl_awal'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'lama' => $this->input->post('lama'),
            'alamat' => $this->input->post('alamat'),
            'alasan' => $this->input->post('alasan'),
            'dokumen_pendukung' => $dokumen_pendukung
        ];

        $result = $this->model->proses_simpan_cuti($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            // Hapus file yang sudah diupload jika gagal simpan
            if (!empty($dokumen_pendukung) && file_exists($config['upload_path'] . $dokumen_pendukung)) {
                unlink($config['upload_path'] . $dokumen_pendukung);
            }
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_cuti_admin()
    {
        $this->form_validation->set_rules('pegawai', 'Pegawai', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis Cuti', 'trim|required');
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('lama', 'Lama Cuti', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Selama Cuti', 'trim|required');
        $this->form_validation->set_rules('alasan', 'Alasan Cuti', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $jenis_cuti = $this->input->post('jenis');
        $id_cuti = $this->input->post('id');
        $dokumen_pendukung = '';

        // Cek apakah edit dan sudah ada dokumen
        $dokumen_lama = '';
        if (!empty($id_cuti)) {
            $cuti_lama = $this->model->get_seleksi('register_cuti', 'id', $id_cuti);
            if ($cuti_lama->num_rows() > 0) {
                $dokumen_lama = $cuti_lama->row()->dokumen_pendukung ?? '';
            }
        }

        // Validasi upload dokumen untuk cuti sakit (2) dan cuti alasan penting (5)
        if (in_array($jenis_cuti, ['2', '5'])) {
            // Jika edit dan sudah ada dokumen, tidak wajib upload ulang
            // Tapi jika upload file baru, proses upload
            if (!empty($_FILES['dokumen_pendukung']['name'])) {
                // Ada file baru yang diupload
                // Konfigurasi upload
                $config['upload_path'] = './dokumen/cuti/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB dalam KB
                $config['encrypt_name'] = TRUE;

                // Buat folder jika belum ada
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dokumen_pendukung')) {
                    $error = $this->upload->display_errors('', '');
                    echo json_encode(['success' => 2, 'message' => 'Upload Dokumen Gagal: ' . $error]);
                    return;
                }

                $upload_data = $this->upload->data();
                $dokumen_pendukung = $upload_data['file_name'];
            } elseif (empty($dokumen_lama)) {
                // Tidak ada file baru dan tidak ada file lama, wajib upload
                echo json_encode(['success' => 2, 'message' => 'Dokumen Pendukung Tidak Boleh Kosong untuk Cuti Sakit dan Cuti Alasan Penting']);
                return;
            } else {
                // Tidak ada file baru tapi ada file lama, gunakan file lama
                $dokumen_pendukung = $dokumen_lama;
            }
        }

        $data = [
            'id' => $id_cuti,
            'pegawai_id' => $this->input->post('pegawai'),
            'jenis' => $jenis_cuti,
            'tgl_awal' => $this->input->post('tgl_awal'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'lama' => $this->input->post('lama'),
            'alamat' => $this->input->post('alamat'),
            'alasan' => $this->input->post('alasan'),
            'dokumen_pendukung' => $dokumen_pendukung
        ];

        $result = $this->model->proses_simpan_cuti($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            // Hapus file yang sudah diupload jika gagal simpan
            if (!empty($dokumen_pendukung) && file_exists($config['upload_path'] . $dokumen_pendukung)) {
                unlink($config['upload_path'] . $dokumen_pendukung);
            }
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_validasi_cuti_atasan()
    {
        $this->form_validation->set_rules('status_valid', 'Status Atasan', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Belum Dipilih']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $alasan_valid = '';

        $status_valid = $this->input->post('status_valid');
        if ($status_valid != 1) {
            $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
            $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

            if ($this->form_validation->run() == FALSE) {
                echo json_encode(['success' => 2, 'message' => validation_errors()]);
                return;
            }

            $alasan_valid = $this->input->post('ket');
        }

        $id = $this->input->post('id');
        $data = [
            'id' => $id,
            'status' => $status_valid,
            'alasan' => $alasan_valid
        ];

        $result = $this->model->proses_simpan_validasi_cuti_atasan($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_validasi_cuti_ppk()
    {
        $this->form_validation->set_rules('status_valid', 'Status Pejabat Pembina Kepegawaian', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Belum Dipilih']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $alasan_valid = '';

        $status_valid = $this->input->post('status_valid');
        if ($status_valid != 1) {
            $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
            $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

            if ($this->form_validation->run() == FALSE) {
                echo json_encode(['success' => 2, 'message' => validation_errors()]);
                return;
            }

            $alasan_valid = $this->input->post('ket');
        }

        $id = $this->input->post('id');
        $data = [
            'id' => $id,
            'status' => $status_valid,
            'alasan' => $alasan_valid
        ];

        $result = $this->model->proses_simpan_validasi_cuti_ppk($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_nomor()
    {
        $this->form_validation->set_rules('nomor_cuti', 'Nomor Cuti', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Belum diisi']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $nomor = $this->input->post('nomor_cuti');
        $id = $this->input->post('id');

        $data = [
            'nomor' => $nomor,
            'id' => $id
        ];

        $result = $this->model->proses_simpan_nomor_cuti($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function hapus_cuti()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $data = [
            'hapus' => '1',
            'modified_on' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('fullname')
        ];

        $query = $this->model->pembaharuan_data('register_cuti', $data, 'id', $id);
        if ($query == '1') {
            echo json_encode(['success' => 1, 'message' => 'Cuti Berhasil Dihapus']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Cuti Gagal Dihapus, Coba Lagi.']);
        }
    }

    public function show_cuti_detil()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "DETAIL PERMOHONAN CUTI";

        $cariCuti = $this->model->get_seleksi('register_cuti', 'id', $id);
        switch ($cariCuti->row()->jenis_cuti) {
            case 1:
                $jenis_cuti = "Cuti Tahunan";
                break;
            case 2:
                $jenis_cuti = "Cuti Sakit";
                break;
            case 3:
                $jenis_cuti = "Cuti Melahirkan";
                break;
            case 4:
                $jenis_cuti = "Cuti Besar";
                break;
            case 5:
                $jenis_cuti = "Cuti Alasan Penting";
                break;
            case 6:
                $jenis_cuti = "Cuti di Luar Tanggungan Negara";
                break;
        }

        $tgl_awal = $this->tanggalhelper->convertDayDate($cariCuti->row()->tgl_awal);
        $tgl_akhir = $this->tanggalhelper->convertDayDate($cariCuti->row()->tgl_akhir);
        $lama = $cariCuti->row()->lama;
        $alasan = $cariCuti->row()->alasan;
        $alamat = $cariCuti->row()->alamat;
        $status_validator = $cariCuti->row()->status_validator;
        $jenis_cuti_id = $cariCuti->row()->jenis_cuti; // ID jenis cuti (angka)
        $dokumen_pendukung = $cariCuti->row()->dokumen_pendukung ?? '';

        if ($cariCuti->row()->alasan_validator) {
            $alasan_validator = $cariCuti->row()->alasan_validator;
        } else {
            $alasan_validator = '-';
        }
        $status_ppk = $cariCuti->row()->status_ppk;

        if ($cariCuti->row()->alasan_ppk) {
            $alasan_ppk = $cariCuti->row()->alasan_ppk;
        } else {
            $alasan_ppk = '-';
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'jenis_cuti' => $jenis_cuti,
                'jenis_cuti_id' => $jenis_cuti_id, // ID jenis cuti untuk cek apakah 2 atau 5
                'dokumen_pendukung' => $dokumen_pendukung,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'lama' => $lama,
                'alamat' => $alamat,
                'alasan' => $alasan,
                'status_validator' => $status_validator,
                'alasan_validator' => $alasan_validator,
                'status_ppk' => $status_ppk,
                'alasan_ppk' => $alasan_ppk
            )
        );
        return;
    }

    public function get_pegawai_id_from_cuti()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $cariCuti = $this->model->get_seleksi('register_cuti', 'id', $id);

        $data = [
            "tabel" => "v_users",
            "kolom_seleksi" => "status_pegawai",
            "seleksi" => "1"
        ];

        $users = $this->apihelper->get('apiclient/get_data_seleksi', $data);

        $pegawai = array();
        if ($users['status_code'] === 200) {
            foreach ($users['response']['data'] as $item) {
                $pegawai[$item['pegawai_id']] = $item['fullname'];
            }
        }

        if ($cariCuti->num_rows() > 0) {
            $pegawai_ = form_dropdown('pegawai', $pegawai, $cariCuti->row()->pegawai_id, 'class = "form-control select2" onchange="inputCutiAdmin(this.value)" id="pegawai"');

            echo json_encode(
                array(
                    'st' => 1,
                    'judul' => 'EDIT REGISTER CUTI',
                    'pegawai' => $pegawai_,
                )
            );
            
        } else {
            echo json_encode(
                array(
                    'st' => 0,
                    'msg' => 'Data cuti tidak ditemukan'
                )
            );
        }
        return;
    }

    public function cetak($id)
    {
        $idDecrypt = $this->encryption->decrypt(base64_decode($this->uri->segment(2)));

        $data = $this->model->getDetailCuti($idDecrypt);

        if (!$data) {
            show_404();
        }

        $logoPath = $this->session->userdata('logo_satker');
        $sso_server = $this->config->item('sso_server');
        $data['ttd'] = $this->qrhelper->create($sso_server . 'halamankartupegawai/kartu_pegawai/' . $data['userid_pegawai'], $logoPath);
        $data['ttd_validator'] = $this->qrhelper->create($sso_server . 'halamankartupegawai/kartu_pegawai/' . $data['userid_validator'], $logoPath);
        $data['ttd_ppk'] = $this->qrhelper->create($sso_server . 'halamankartupegawai/kartu_pegawai/' . $data['userid_ppk'], $logoPath);

        $this->load->view('cetak/cetak_cuti', $data);
    }

    public function cek_tanggal()
    {
        $id = $this->input->post('id');
        $queryCuti = $this->model->get_seleksi('register_cuti', 'id', $id);
        $awal = $queryCuti->row()->tgl_awal;
        $akhir = $queryCuti->row()->tgl_akhir;

        $queryCekTgl = $this->model->cek_tanggal($awal, $akhir);
        //die(var_dump($queryCekTgl[0]->pegawai_nama));
        if (count($queryCekTgl) > 0) {
            $pesan = 'Ada Pegawai yang mengajukan cuti tahunan pada rentang tanggal tersebut, harap jadi perhatian.</br><ol>';
            for ($i = 0; $i < count($queryCekTgl); $i++) {
                $start = $this->tanggalhelper->convertDayDate($queryCekTgl[$i]->tgl_awal);
                $end = $this->tanggalhelper->convertDayDate($queryCekTgl[$i]->tgl_akhir);
                $pesan_list = '<li>' . $queryCekTgl[$i]->pegawai_nama . ' (' . $start . ' s/d ' . $end . ')</li>';
                $pesan = $pesan .= $pesan_list;
            }
            $pesan = $pesan .= '</ol>';
            //die(var_dump($pesan));
            echo json_encode(
                array(
                    'st' => 1,
                    'pesan' => $pesan
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => 0
                )
            );
        }

        return;
    }

    public function get_cuti_kalender()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $data_cuti = $this->model->get_cuti_kalender($start, $end);
        $data_izin_keluar = $this->model->get_izin_keluar_kalender($start, $end);

        $events = [];

        // Event Cuti
        foreach ($data_cuti as $cuti) {
            $jenis_cuti = '';
            $color = '';
            switch ($cuti['jenis_cuti']) {
                case '1':
                    $jenis_cuti = 'Cuti Tahunan';
                    $color = '#28a745'; // hijau
                    break;
                case '2':
                    $jenis_cuti = 'Cuti Sakit';
                    $color = '#dc3545'; // merah
                    break;
                case '3':
                    $jenis_cuti = 'Cuti Melahirkan';
                    $color = '#ffc107'; // kuning
                    break;
                case '4':
                    $jenis_cuti = 'Cuti Besar';
                    $color = '#17a2b8'; // biru
                    break;
                case '5':
                    $jenis_cuti = 'Cuti Alasan Penting';
                    $color = '#6f42c1'; // ungu
                    break;
                case '6':
                    $jenis_cuti = 'Cuti di Luar Tanggungan Negara';
                    $color = '#6c757d'; // abu-abu
                    break;
                default:
                    $jenis_cuti = 'Cuti Lainnya';
                    $color = '#343a40';
                    break;
            }

            $events[] = [
                'id' => 'cuti_' . $cuti['id'],
                'title' => $cuti['nama_pegawai'] . ' - ' . $jenis_cuti,
                'start' => $cuti['tgl_awal'],
                'end' => date('Y-m-d', strtotime($cuti['tgl_akhir'] . ' +1 day')), // FullCalendar end is exclusive
                'color' => $color,
                'extendedProps' => [
                    'tipe' => 'cuti',
                    'nama' => $cuti['nama_pegawai'],
                    'jenis' => $jenis_cuti,
                    'nomor_cuti' => $cuti['nomor_cuti'],
                    'alasan' => $cuti['alasan']
                ]
            ];
        }

        // Event Izin Keluar
        foreach ($data_izin_keluar as $izin) {
            $start_datetime = $izin['tgl_izin'] . 'T' . $izin['jam_mulai'];
            $end_datetime = $izin['tgl_izin'] . 'T' . $izin['jam_akhir'];

            // Jika jam_akhir lebih kecil dari jam_mulai, berarti sampai hari berikutnya
            if (strtotime($izin['jam_akhir']) < strtotime($izin['jam_mulai'])) {
                $end_date = date('Y-m-d', strtotime($izin['tgl_izin'] . ' +1 day'));
                $end_datetime = $end_date . 'T' . $izin['jam_akhir'];
            }

            $events[] = [
                'id' => 'izin_' . $izin['id'],
                'title' => $izin['nama_pegawai'] . ' - Izin Keluar',
                'start' => $start_datetime,
                'end' => $end_datetime,
                'color' => '#fd7e14', // orange
                'display' => 'block',
                'extendedProps' => [
                    'tipe' => 'izin_keluar',
                    'nama' => $izin['nama_pegawai'],
                    'jenis' => 'Izin Keluar',
                    'alasan' => $izin['alasan'],
                    'jam_mulai' => $izin['jam_mulai'],
                    'jam_akhir' => $izin['jam_akhir']
                ]
            ];
        }

        echo json_encode($events);
    }
}