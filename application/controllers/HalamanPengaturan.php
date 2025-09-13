<?php

class HalamanPengaturan extends MY_Controller
{
    public function get_tanggal_merah()
    {
        $disabledDates = array();
        $data = $this->model->get_tgl_merah();

        foreach ($data->result() as $row) {
            $disabledDates[] = $row->tgl;
        }

        //die(var_dump($disabledDates));
        echo json_encode($disabledDates);
        return;
    }

    public function get_hari_libur()
    {
        $disabledDates = array();
        $data = $this->model->get_tgl_merah();

        foreach ($data->result() as $row) {
            // Misalnya di tabel ada kolom tgl dan keterangan
            $disabledDates[] = array(
                'date' => $row->tgl,
                'keterangan' => $row->ket
            );
        }

        echo json_encode($disabledDates);
        return;
    }

    public function show_tabel_hari_libur()
    {
        $tahun = $this->model->get_tahun_terakhir()->row()->year;
        $queryLibur = $this->model->get_seleksi_array('register_hari_libur', '', ['tgl' => 'DESC'])->result();
        $dataLibur = [];
        foreach ($queryLibur as $row) {
            $dataLibur[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tanggal' => $this->tanggalhelper->convertDayDate($row->tgl),
                'tgl' => $row->tgl,
                'ket' => $row->ket
            ];
        }

        echo json_encode(['data_libur' => $dataLibur, 'tahun' => $tahun]);
    }

    public function show_libur()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $tgl = '';
        $ket = '';
        if ($id == '-1') {
            $judul = "TAMBAH DATA HARI LIBUR & CUTI BERSAMA";
        } else {
            $judul = "EDIT DATA HARI LIBUR & CUTI BERSAMA";
            $cekLibur = $this->model->get_seleksi('register_hari_libur', 'id', $id);
            $tgl = $cekLibur->row()->tgl;
            $ket = $cekLibur->row()->ket;
        }


        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id,
                'tgl' => $tgl,
                'ket' => $ket
            )
        );
        return;
    }

    public function simpan_hari_libur()
    {
        $this->form_validation->set_rules('tgl_libur', 'Tanggal Hari Libur', 'trim|required');
        $this->form_validation->set_rules('ket', 'Keterangan Hari Libur', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $data = [
            'id' => $this->input->post('id'),
            'tgl' => $this->input->post('tgl_libur'),
            'ket' => $this->input->post('ket')
        ];

        $result = $this->model->proses_simpan_hari_libur($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function generate_cuti()
    {
        $tahun = date('Y');
        $cek = $this->model->get_seleksi('register_sisa_cuti_tahunan', 'tahun', $tahun);
        if ($cek->num_rows() > 0) {
            echo json_encode(['success' => 2, 'message' => 'Cuti Tahun ' . $tahun . ' Sudah Diinisialisasi']);
            return;
        } else {
            $result = $this->model->proses_generate_sisa_cuti($tahun);

            if ($result['status']) {
                echo json_encode(['success' => 1, 'message' => $result['message']]);
            } else {
                echo json_encode(['success' => 3, 'message' => $result['message']]);
            }
        }
    }

    public function show_tabel_sisa_cuti()
    {
        $sisa = $this->model->show_all_sisa_cuti();
        echo json_encode($sisa);
    }

    public function simpan_sisa_cuti()
    {
        $id = $this->input->post('id');
        $pegawai_id = $this->input->post('pegawai_id');
        $tahun = $this->input->post('tahun');
        $sisa = $this->input->post('sisa');

        if ($id == null) {
            $data = array(
                'pegawai_id' => $pegawai_id,
                'tahun' => $tahun,
                'sisa' => $sisa,
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata("fullname")
            );

            $query = $this->model->simpan_data('register_sisa_cuti_tahunan', $data);
        } else {
            $data = array(
                'sisa' => $sisa,
                'modified_on' => date('Y-m-d H:i:s'),
                'modified_by' => $this->session->userdata("fullname")
            );

            $query = $this->model->pembaharuan_data('register_sisa_cuti_tahunan', $data, 'id', $id);
        }

        if ($query == '1')
            echo json_encode(['success' => 1, 'message' => 'Simpan Sisa Cuti Berhasil']);
        else
            echo json_encode(['success' => 3, 'message' => 'Simpan SI\isa Cuti Gagal, '.$query]);
    }
}