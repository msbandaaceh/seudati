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
        $queryCuti = $this->model->get_seleksi_order('v_cuti', 'id_ppk', $this->session->userdata('jab_id'), 'status_ppk', 'ASC')->result();

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
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'alasan' => $alasan,
                'alamat' => $alamat
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

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'nip' => $nip,
                'jabatan' => $jabatan,
                'jenis_cuti' => $jenis_cuti,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'alamat' => $alamat,
                'alasan' => $alasan
            )
        );
        return;
    }

    public function show_nomor() {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "PENOMORAN CUTI";

        $cariCuti = $this->model->get_seleksi('v_cuti', 'id', $id);
        $nama = $cariCuti->row()->pegawai_nama;
        $jabatan = $cariCuti->row()->pegawai_jabatan;
        $nip = $cariCuti->row()->nip;
        $id_grup = $cariCuti->row()->id_grup;

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
                'grup' => $grup
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

        $data = [
            'id' => $this->input->post('id'),
            'pegawai_id' => $this->session->userdata('pegawai_id'),
            'jenis' => $this->input->post('jenis'),
            'tgl_awal' => $this->input->post('tgl_awal'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'lama' => $this->input->post('lama'),
            'alamat' => $this->input->post('alamat'),
            'alasan' => $this->input->post('alasan')
        ];

        $result = $this->model->proses_simpan_cuti($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
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

    public function cetak($id)
    {
        $idDecrypt = $this->encryption->decrypt(base64_decode($this->uri->segment(2)));

        $data = $this->model->getDetailCuti($idDecrypt);

        if (!$data) {
            show_404();
        }

        $logoPath = $this->session->userdata('logo_satker');
        $data['ttd'] = $this->qrhelper->create(site_url('halamankartupegawai/kartu_pegawai/' . $data['userid_pegawai']), $logoPath);
        $data['ttd_validator'] = $this->qrhelper->create(site_url('halamankartupegawai/kartu_pegawai/' . $data['userid_validator']), $logoPath);
        $data['ttd_ppk'] = $this->qrhelper->create(site_url('halamankartupegawai/kartu_pegawai/' . $data['userid_ppk']), $logoPath);

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
}