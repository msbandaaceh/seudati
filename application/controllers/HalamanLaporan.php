<?php

class HalamanLaporan extends MY_Controller {
    public function show_tabel_register_izin_keluar() {
        $queryIzin = $this->model->get_seleksi_array('v_izin_keluar', '', ['status' => 'ASC', 'created_on' => 'DESC'])->result();

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->nama_pegawai,
                'jabatan' => $row->jabatan_pegawai,
                'validator' => $row->validator,
                'jabatan_validator' => $row->jabatan_validator,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin]);
    }

    public function show_tabel_register_izin_diklat() {
        $queryIzin = $this->model->get_seleksi_array('v_izin_diklat', '', ['status' => 'ASC', 'created_on' => 'DESC'])->result();

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->nama,
                'nama_diklat' => $row->nama_diklat,
                'jabatan' => $row->jabatan,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($row->tgl_selesai),
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin]);
    }

    public function show_tabel_register_cuti() {
        $queryCuti = $this->model->get_seleksi_array('v_cuti', '', ['status_cuti' => 'ASC', 'created_on' => 'DESC'])->result();

        $dataCuti = [];
        foreach ($queryCuti as $row) {
            $dataCuti[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama' => $row->pegawai_nama,
                'jabatan' => $row->pegawai_jabatan,
                'jenis' => $row->jenis_cuti,
                'lama' => $row->lama,
                'status_cuti' => $row->status_cuti
            ];
        }

        echo json_encode(['data_cuti' => $dataCuti]);
    }

    public function cari_izin_keluar() {
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $queryIzin = $this->model->cari_data_keluar($tgl_awal, $tgl_akhir);

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'nama' => $row->nama_pegawai,
                'jabatan' => $row->jabatan_pegawai,
                'tgl_izin' => $this->tanggalhelper->convertDayDate($row->tgl_izin),
                'alasan' => $row->alasan,
                'validator' => $row->validator,
                'jabatan_validator' => $row->jabatan_validator,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin, 'success' => '1', 'message' => 'Pencarian Data Izin Keluar Berhasil']);
    }

    public function cari_izin_diklat() {
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $queryIzin = $this->model->cari_data_diklat($tgl_awal, $tgl_akhir);

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'nama' => $row->nama,
                'jabatan' => $row->jabatan,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($row->tgl_selesai),
                'nama_diklat' => $row->nama_diklat,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin, 'success' => '1', 'message' => 'Pencarian Data Izin Diklat Berhasil']);
    }

    public function cari_cuti() {
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $queryCuti = $this->model->cari_data_cuti($tgl_awal, $tgl_akhir);

        $dataCuti = [];
        foreach ($queryCuti as $row) {
            $dataCuti[] = [
                'nama' => $row->pegawai_nama,
                'jabatan' => $row->pegawai_jabatan,
                'tgl_awal' => $this->tanggalhelper->convertDayDate($row->tgl_awal),
                'tgl_akhir' => $this->tanggalhelper->convertDayDate($row->tgl_akhir),
                'lama' => $row->lama,
                'jenis' => $row->jenis_cuti,
                'nama_validator' => $row->nama_ttd_validator,
                'jabatan_validator' => $row->jabatan_ttd_validator,
                'nama_ppk' => $row->nama_ttd_ppk,
                'jabatan_ppk' => $row->jabatan_ttd_ppk,
                'status_cuti' => $row->status_cuti,
                'alasan' => $row->alasan
            ];
        }

        echo json_encode(['data_cuti' => $dataCuti, 'success' => '1', 'message' => 'Pencarian Data Cuti Berhasil']);
    }
}