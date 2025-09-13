<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class HalamanIzin extends MY_Controller
{

    public function statistik_izin_keluar()
    {
        $data['jum_izin_user'] = $this->model->get_seleksi('register_izin_keluar', 'id_user', $this->session->userdata('userid'))->num_rows();
        $data['jum_izin_user_setuju'] = $this->model->get_seleksi_in('register_izin_keluar', 'id_user', $this->session->userdata('userid'), 'status', [1, 3])->num_rows();
        $data['jum_izin_user_tolak'] = $this->model->get_seleksi_in('register_izin_keluar', 'id_user', $this->session->userdata('userid'), 'status', [2, 4])->num_rows();

        echo json_encode($data);
    }

    public function statistik_izin_keluar_validasi()
    {
        $data['jum_izin_user'] = $this->model->get_seleksi('register_izin_keluar', 'jab_tujuan', $this->session->userdata('jab_id'))->num_rows();
        $data['jum_izin_user_setuju'] = $this->model->get_seleksi_in('register_izin_keluar', 'jab_tujuan', $this->session->userdata('jab_id'), 'status', [1, 3])->num_rows();
        $data['jum_izin_user_tolak'] = $this->model->get_seleksi_in('register_izin_keluar', 'jab_tujuan', $this->session->userdata('jab_id'), 'status', [2, 4])->num_rows();

        echo json_encode($data);
    }

    public function show_tabel_permohonan_izin_keluar()
    {
        $id = $this->session->userdata('userid');
        $queryIzin = $this->model->get_seleksi_order('register_izin_keluar', 'id_user', $id, 'status', 'ASC')->result();

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tgl_izin' => $this->tanggalhelper->convertDayDate($row->tgl_izin),
                'created_on' => $row->created_on,
                'alasan' => $row->alasan,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin]);
    }

    public function show_tabel_validasi_izin_keluar()
    {
        $queryIzin = $this->model->get_seleksi_array('v_izin_keluar', ['jab_tujuan' => $this->session->userdata('jab_id')], ['status' => 'ASC', 'created_on' => 'DESC'])->result();

        $dataIzin = [];
        foreach ($queryIzin as $row) {
            $dataIzin[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tgl_izin' => $this->tanggalhelper->convertDayDate($row->tgl_izin),
                'nama' => $row->nama_pegawai,
                'created_on' => $row->created_on,
                'alasan' => $row->alasan,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_izin' => $dataIzin]);
    }

    public function show_izin_keluar()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        if ($id == '-1') {
            $judul = "PERMOHONAN IZIN KELUAR BARU";
            $id = '';
            $tgl = '';
            $mulai = '';
            $akhir = '';
            $alasan = '';
        } else {
            $judul = "EDIT DATA PERMOHONAN IZIN KELUAR";

            $cariIzin = $this->model->get_seleksi('register_izin_keluar', 'id', $id);
            $tgl = $cariIzin->row()->tgl_izin;
            $mulai = $cariIzin->row()->jam_mulai;
            $akhir = $cariIzin->row()->jam_akhir;
            $alasan = $cariIzin->row()->alasan;
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'tgl' => $tgl,
                'mulai' => $mulai,
                'akhir' => $akhir,
                'alasan' => $alasan
            )
        );
        return;
    }

    public function show_izin_keluar_detil()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "DETAIL PERMOHONAN IZIN";

        $cariIzin = $this->model->get_seleksi('register_izin_keluar', 'id', $id);
        $tgl = $this->tanggalhelper->convertDayDate($cariIzin->row()->tgl_izin);
        $mulai = $cariIzin->row()->jam_mulai;
        $akhir = $cariIzin->row()->jam_akhir;
        $alasan = $cariIzin->row()->alasan;
        if ($cariIzin->row()->status == '0') {
            $status = 'Diproses';
        } elseif ($cariIzin->row()->status == '1' || $cariIzin->row()->status == '3') {
            $status = 'Disetujui';
        } elseif ($cariIzin->row()->status == '2' || $cariIzin->row()->status == '4') {
            $status = 'Ditolak';
        }
        $ket = $cariIzin->row()->ket;

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'tgl' => $tgl,
                'mulai' => $mulai,
                'akhir' => $akhir,
                'alasan' => $alasan,
                'proses' => $status,
                'ket' => $ket
            )
        );
        return;
    }

    public function simpan_izin_keluar()
    {
        $this->form_validation->set_rules('tgl_izin', 'Tanggal Izin', 'trim|required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai Izin', 'trim|required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai Izin', 'trim|required');
        $this->form_validation->set_rules('alasan', 'Alasan Izin', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $userid = $this->session->userdata('userid');
        $id = $this->input->post('id');

        $data = [
            'id' => $id,
            'id_user' => $userid,
            'tgl_izin' => $this->input->post('tgl_izin'),
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'alasan' => $this->input->post('alasan'),
            'fullname' => $this->session->userdata('fullname'),
            'pegawai_id' => $this->session->userdata('pegawai_id')
        ];

        $result = $this->model->proses_simpan_izin_keluar($data);

        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_validasi_izin_keluar()
    {
        $this->form_validation->set_rules('status', 'Proses Validasi', 'required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $data['id'] = $this->input->post('id');
        $data['status'] = $this->input->post('status');
        $data['ket'] = $this->input->post('ket');
        $data['nama_penandatangan'] = $this->session->userdata('fullname');
        $data['id_penandatangan'] = $this->session->userdata('pegawai_id');

        $result = $this->model->proses_simpan_validasi_izin_keluar($data);

        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function hapus_izin_keluar()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $data = [
            'hapus' => '1',
            'modified_on' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('fullname')
        ];

        $query = $this->model->pembaharuan_data('register_izin_keluar', $data, 'id', $id);
        if ($query == '1') {
            echo json_encode(['success' => 1, 'message' => 'Izin Keluar Berhasil Dihapus']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Izin Keluar Gagal Dihapus, Coba Lagi.']);
        }
    }

    public function cetak($id)
    {
        $idDecrypt = $this->encryption->decrypt(base64_decode($this->uri->segment(2)));

        $data = $this->model->getDetailIzin($idDecrypt);

        if (!$data) {
            show_404();
        }

        $logoPath = $this->session->userdata('logo_satker');
        $data['qr_pegawai_image'] = $this->qrhelper->create(site_url('halamankartupegawai/kartu_pegawai/' . $data['userid_pegawai']), $logoPath);
        $data['qr_atasan_image'] = $this->qrhelper->create(site_url('halamankartupegawai/kartu_pegawai/' . $data['userid_validator']), $logoPath);

        $this->load->view('cetak/cetak_izin', $data);
    }

    # FUNCTION IZIN DIKLAT
    public function statistik_izin_diklat()
    {
        $data['jum_diklat_user'] = $this->model->get_seleksi('register_izin_diklat', 'pegawai_id', $this->session->userdata('pegawai_id'))->num_rows();
        $data['jum_diklat_user_setuju'] = $this->model->get_seleksi2('register_izin_diklat', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_permohonan', '2')->num_rows();
        $data['jum_diklat_user_selesai'] = $this->model->get_seleksi2('register_izin_diklat', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_permohonan', '3')->num_rows();
        $data['jum_diklat_user_tolak'] = $this->model->get_seleksi2('register_izin_diklat', 'pegawai_id', $this->session->userdata('pegawai_id'), 'status_permohonan', '4')->num_rows();

        echo json_encode($data);
    }

    public function statistik_izin_diklat_validasi()
    {
        $data['jum_diklat_user'] = $this->model->get_seleksi('register_izin_diklat', ['tujuan_permohonan' => $this->session->userdata('jab_id')], null)->num_rows();
        $data['jum_diklat_user_setuju'] = $this->model->get_seleksi2_in('register_izin_diklat', 'tujuan_permohonan', $this->session->userdata('jab_id'), 'status_permohonan', ['1', '2'])->num_rows();
        $data['jum_diklat_user_selesai'] = $this->model->get_seleksi_array('register_izin_diklat', ['tujuan_permohonan' => $this->session->userdata('jab_id'), 'status_permohonan' => '3'], null)->num_rows();
        $data['jum_diklat_user_tolak'] = $this->model->get_seleksi_array('register_izin_diklat', ['tujuan_permohonan' => $this->session->userdata('jab_id'), 'status_permohonan' => '4'], null)->num_rows();

        echo json_encode($data);
    }

    public function show_tabel_permohonan_izin_diklat()
    {
        $id = $this->session->userdata('pegawai_id');
        $query = $this->model->get_seleksi_order('register_izin_diklat', 'pegawai_id', $id, 'status_permohonan', 'ASC')->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($row->tgl_selesai),
                'created_on' => $row->created_on,
                'nama' => $row->nama_diklat,
                'status' => $row->status_permohonan
            ];
        }

        echo json_encode(['data_diklat' => $data]);
    }

    public function show_tabel_validasi_izin_diklat()
    {
        $query = $this->model->get_seleksi_array('v_izin_diklat', ['tujuan' => $this->session->userdata('jab_id')], ['status' => 'ASC', 'created_on' => 'DESC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($row->tgl_selesai),
                'created_on' => $row->created_on,
                'nama' => $row->nama_diklat,
                'nama_pegawai' => $row->nama,
                'status' => $row->status
            ];
        }

        echo json_encode(['data_diklat' => $data]);
    }

    public function show_tabel_verifikasi_izin_diklat()
    {
        $query = $this->model->get_seleksi_array('v_izin_diklat', ['status' => '1'], ['created_on' => 'ASC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama_pegawai' => $row->nama,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($row->tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($row->tgl_selesai),
                'nama' => $row->nama_diklat,
            ];
        }

        echo json_encode(['data_diklat' => $data]);
    }

    public function show_diklat_detil()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "DETAIL PERMOHONAN IZIN DIKLAT/BIMTEK";

        $cariDiklat = $this->model->get_seleksi('v_izin_diklat', 'id', $id);
        $nama = $cariDiklat->row()->nama;
        $jenis = $cariDiklat->row()->jenis;
        $nama_diklat = $cariDiklat->row()->nama_diklat;
        $tgl_mulai = $this->tanggalhelper->convertDayDate($cariDiklat->row()->tgl_mulai);
        $tgl_selesai = $this->tanggalhelper->convertDayDate($cariDiklat->row()->tgl_selesai);
        $proses = $cariDiklat->row()->status;
        $progres = $cariDiklat->row()->status_diklat;
        $sertifikat = $cariDiklat->row()->sertifikat;
        $ket = $cariDiklat->row()->ket;

        $dokumen = null;
        if ($sertifikat) {
            $dokumen = '<iframe src="' . base_url('assets/pdfjs/web/viewer.html?file=' . base_url('dokumen/diklat/sertifikat/' . $sertifikat)) . '" width="100%" height="640"></iframe>';
        } else {
            $dokumen = '<object id="pdf" height="1024px" width="100%" type="application/pdf"><span align="center">Dokumen Belum Ada</span></object>';
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'jenis' => $jenis,
                'nama_diklat' => $nama_diklat,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'status' => $proses,
                'progres' => $progres,
                'sertifikat' => $dokumen,
                'ket' => $ket
            )
        );
        return;
    }

    public function show_izin_diklat()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $tujuan = array(
            '1' => 'Ketua',
            '5' => 'Sekretaris'
        );

        $jenis = array(
            'Diklat' => 'Diklat',
            'Bimtek' => 'Bimtek',
            'Lainnya' => 'Lainnya'
        );

        if ($id == '-1') {
            $judul = "PERMOHONAN IZIN DIKLAT BARU";
            $id = '';
            $nama = '';
            $tgl_mulai = '';
            $tgl_selesai = '';

            $jenis_diklat = form_dropdown('jenis', $jenis, '', 'class="form-control" onChange="showInputLainnya()" id="jenis"');
            $tujuan_permohonan = form_dropdown('tujuan', $tujuan, '', 'class="form-control" id="tujuan"');
        } else {
            $judul = "EDIT DATA PERMOHONAN DIKLAT";

            $cariIzin = $this->model->get_seleksi('register_izin_diklat', 'id', $id);
            $nama = $cariIzin->row()->nama_diklat;
            $tgl_mulai = $cariIzin->row()->tgl_mulai;
            $tgl_selesai = $cariIzin->row()->tgl_selesai;
            $jenis_ = $cariIzin->row()->jenis;
            $tujuan_ = $cariIzin->row()->tujuan_permohonan;

            $jenis_diklat = form_dropdown('jenis', $jenis, $jenis_, 'class="form-control" id="jenis"');
            $tujuan_permohonan = form_dropdown('tujuan', $tujuan, $tujuan_, 'class="form-control" id="tujuan"');
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'jenis' => $jenis_diklat,
                'tujuan' => $tujuan_permohonan
            )
        );
        return;
    }

    public function show_upload_st()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "UPLOAD DOKUMEN PENDUKUNG";

        $cariIzin = $this->model->get_seleksi('v_izin_diklat', 'id', $id);
        $nama = $cariIzin->row()->nama;
        $jabatan = $cariIzin->row()->jabatan;
        $nip = $cariIzin->row()->nip;
        $nama_diklat = $cariIzin->row()->nama_diklat;
        $tgl_mulai = $cariIzin->row()->tgl_mulai;
        $tgl_selesai = $cariIzin->row()->tgl_selesai;
        $jenis = $cariIzin->row()->jenis;

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'nip' => $nip,
                'nama_diklat' => $nama_diklat,
                'tgl_mulai' => $this->tanggalhelper->convertDayDate($tgl_mulai),
                'tgl_selesai' => $this->tanggalhelper->convertDayDate($tgl_selesai),
                'jenis' => $jenis,
            )
        );
        return;
    }

    public function show_dokumen()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "DOKUMEN PENDUKUNG IZIN DIKLAT/BIMTEK";
        $query = $this->model->get_seleksi('register_izin_diklat', 'id', $id);
        $dokumen = '<iframe src="' . base_url('assets/pdfjs/web/viewer.html?file=' . base_url('dokumen/diklat/pendukung/' . $query->row()->dok_st)) . '" width="100%" height="640"></iframe>';

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'dokumen' => $dokumen
            )
        );
        return;
    }

    public function show_progres_diklat()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $judul = "PROSES PROGRES DIKLAT/BIMTEK";

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id
            )
        );
        return;
    }

    public function simpan_izin_diklat()
    {
        $this->form_validation->set_rules('tujuan', 'Tujuan Permohonan', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis Permohonan', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Diklat/Bimtek', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai Diklat/Bimtek', 'trim|required');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai Diklat/Bimtek', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $data = [
            'id' => $this->input->post('id'),
            'tujuan' => $this->input->post('tujuan'),
            'nama' => $this->input->post('nama'),
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_selesai' => $this->input->post('tgl_selesai'),
            'jenis' => $this->input->post('jenis'),
            'jenis_nama' => $this->input->post('jenis_nama')
        ];

        $result = $this->model->proses_simpan_izin_diklat($data);

        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_st()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $id = $this->input->post('id');

        $upload_data = "";
        if (!empty($_FILES['dokumen']['name'])) {
            $max_size = 5000 * 1024;
            if ($_FILES['dokumen']['size'] > $max_size) {
                echo json_encode(['success' => 2, 'message' => 'Gagal simpan dokumen, file terlalu besar (Maksimal 5MB)']);
                return;
            } elseif ($_FILES['dokumen']['type'] != 'application/pdf') {
                echo json_encode(['success' => 2, 'message' => 'Gagal simpan dokumen, tipe dokumen harus pdf']);
                return;
            } else {
                $doc = time() . '-' . $_FILES["dokumen"]['name'];
                $upload_path = './dokumen/diklat/pendukung/';

                // cek apakah folder sudah ada
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true); // recursive = true, agar otomatis buat folder berjenjang
                }
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => "pdf",
                    'file_ext_tolower' => TRUE,
                    'file_name' => $doc,
                    'overwrite' => TRUE,
                    'remove_spaces' => TRUE,
                    'max_size' => "5000"
                );

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                $this->upload->do_upload('dokumen');
                $upload_data = $this->upload->data();
            }
        } else {
            echo json_encode(['success' => 2, 'message' => 'Gagal simpan, file pendukung belum dipilih']);
            return;
        }

        $data = [
            'id' => $id,
            'dok_st' => $upload_data['file_name']
        ];

        $result = $this->model->proses_simpan_st($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_validasi_izin_diklat()
    {
        $this->form_validation->set_rules('status', 'Proses Validasi', 'required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $ket = $this->input->post('ket');

        if ($status == '2') {
            $this->form_validation->set_rules('ket', 'Proses Validasi', 'required');
            $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

            if ($this->form_validation->run() == FALSE) {
                echo json_encode(['success' => 2, 'message' => validation_errors()]);
                return;
            }
        }

        if ($status == '2') {
            $status = '4';
        }

        $dataPengguna = array(
            'status_permohonan' => $status,
            'keterangan' => $ket,
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $querySimpan = $this->model->pembaharuan_data('register_izin_diklat', $dataPengguna, 'id', $id);

        if ($querySimpan == '1') {
            $queryCekPlh = $this->model->get_seleksi('sso_msbna.v_plh', 'plh_id_jabatan', '11');
            if ($queryCekPlh->row()->pegawai_id != null) {
                # Kepegawaian Ada PLH/PLT
                $tujuanNotif = $queryCekPlh->row()->pegawai_id;
                $pesan = 'Assalamualaikum Wr. Wb., Yth. Plh/Plt Kepala Sub Bagiana Kepegawaian MS Banda Aceh, ada permohonan izin Diklat/Bimtek yang disetujui. Mohon untuk ditindaklanjuti dengan mengupload Surat Tugas/Disposisi/Memo/Nota Dinas melalui LITERASI MS Banda Aceh dikarenakan Pejabat Yang Bersangkutan sedang melakukan Dinas Luar Kantor/Kosong, Terima Kasih.';
            } else {
                # Kepegawaian Tidak ada Plh
                $pesan = 'Assalamualaikum Wr. Wb., Yth. Kepala Sub Bagian Kepegawaian MS Banda Aceh, ada permohonan izin Diklat/Bimtek yang disetujui. Mohon untuk ditindaklanjuti dengan mengupload Surat Tugas/Disposisi/Memo/Nota Dinas melalui LITERASI MS Banda Aceh. Terima Kasih.';
                $queryTujuanNotif = $this->izin->get_seleksi2('v_users', 'jab_id', '11', 'status_pegawai', '1');
                if ($queryTujuanNotif->num_rows > 0)
                    $tujuanNotif = $queryTujuanNotif->row()->pegawai_id;
                else {
                    echo json_encode(['success' => 2, 'message' => 'Kepala Sub Bagian Kepegawai tidak ada dan tidak ada plh atau pltnya, silakan hubungi Admin.']);
                    return;
                }
            }

            $dataNotif = array(
                'jenis_pesan' => 'izin',
                'id_pemohon' => $this->session->userdata('id_pegawai'),
                'pesan' => $pesan,
                'id_tujuan' => $tujuanNotif,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->model->kirim_notif($dataNotif);

            echo json_encode(['success' => 1, 'message' => 'Permohonan Berhasil Divalidasi, Notifikasi Akan Dikirim']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Permohonan Gagal Divalidasi, Periksa Kembali atau Hubungi Admin']);
        }
    }

    public function simpan_progres_diklat()
    {
        $this->form_validation->set_rules('status', 'Progres Diklat/Bimtek', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $data = [
            'status_diklat' => $status,
            'status_permohonan' => '3',
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        ];

        if ($status == '1') {
            $upload_data = "";
            if (!empty($_FILES['dokumen']['name'])) {
                $max_size = 5000 * 1024;
                if ($_FILES['dokumen']['size'] > $max_size) {
                    echo json_encode(['success' => 2, 'message' => 'Gagal simpan sertifikat, file terlalu besar (Maksimal 5MB)']);
                    return;
                } elseif ($_FILES['dokumen']['type'] != 'application/pdf') {
                    echo json_encode(['success' => 2, 'message' => 'Gagal simpan sertifikat, tipe dokumen harus pdf']);
                    return;
                } else {
                    $upload_path = './dokumen/diklat/sertifikat/';
                    // cek apakah folder sudah ada
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, true); // recursive = true, agar otomatis buat folder berjenjang
                    }

                    $doc = time() . '-' . $_FILES["dokumen"]['name'];
                    $config = array(
                        'upload_path' => $upload_path,
                        'allowed_types' => "pdf",
                        'file_ext_tolower' => TRUE,
                        'file_name' => $doc,
                        'overwrite' => TRUE,
                        'remove_spaces' => TRUE,
                        'max_size' => "5000"
                    );

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    $this->upload->do_upload('dokumen');
                    $upload_data = $this->upload->data();
                }

                $data['dok_sertifikat'] = $upload_data['file_name'];
            } else {
                echo json_encode(['success' => 2, 'message' => 'Gagal simpan, file sertifikat belum dipilih']);
                return;
            }
        }

        $query = $this->model->pembaharuan_data('register_izin_diklat', $data, 'id', $id);
        if ($query > 0) {
            echo json_encode(['success' => 1, 'message' => 'Progres Diklat/Bimtek Berhasil di Simpan']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Gagal Simpan Progres, ' . $query]);
        }
    }

    public function hapus_izin_diklat()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $data = [
            'hapus' => '1',
            'modified_on' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('fullname')
        ];

        $query = $this->model->pembaharuan_data('register_izin_diklat', $data, 'id', $id);
        if ($query == '1') {
            echo json_encode(['success' => 1, 'message' => 'Izin Keluar Berhasil Dihapus']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Izin Keluar Gagal Dihapus, Coba Lagi.']);
        }
    }
}