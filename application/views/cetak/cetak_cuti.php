<html>

<head>
    <link href="<?= site_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?= site_url('assets/css/app.css')?>" rel="stylesheet">
    <link href="<?= site_url('assets/css/icons.css')?>" rel="stylesheet">
    <style>
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        div {
            border-bottom-style: none;
        }

        @media print {
            body {
                zoom: 0.8;
            }
        }
    </style>
</head>

<body>
    <table style="border:none;">
        <tr>
            <td style="border: none; width: 60%"></td>
            <td style="width:100%; border:none">Banda Aceh,
                <?= $this->tanggalhelper->konversiTanggal($modified_on) ?>
            </td>
        </tr>
        <tr>
            <td style="border: none; width: 60%"></td>
            <?php
            if (in_array($id_grup, ['3', '6'])) { ?>
                <td style="width:100%; border:none">Yth. Sekretaris Mahkamah Syar'iyah Banda Aceh
                </td>
            <?php } else { ?>
                <td style="width:100%; border:none">Yth. Ketua Mahkamah Syar'iyah Banda Aceh
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td style="border: none; width: 60%"></td>
            <td style="width:100%; border:none">Di</td>
        </tr>
        <tr>
            <td style="border: none; width: 60%"></td>
            <td style="width:100%; border:none">Banda Aceh</td>
        </tr>
    </table>
    <br />
    <br />
    <table style="border:none;">
        <tr>
            <td style="width:100%;text-align:center;border:none" colspan=4><strong>FORMULIR PERMINTAAN DAN PEMBERIAN
                    CUTI</strong></td>
        </tr>
        <tr>
            <td style="width:100%;text-align:center;border:none" colspan=4>
                NOMOR : <?php if ($nomor_cuti) {
                    echo $nomor_cuti;
                } else {
                    echo "_________________________________________________";
                } ?>
            </td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=4>
                <strong>I. DATA PEGAWAI</strong>
            </td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td><?= $nama ?></td>
            <td>NIP</td>
            <td><?= $nip ?></td>
        </tr>
        <tr>
            <td>JABATAN</td>
            <td><?= $jabatan ?></td>
            <td>PANGKAT/GOL. RUANG</td>
            <td><?= $pangkat ?></td>
        </tr>
        <tr>
            <td>UNIT KERJA</td>
            <td>MAHKAMAH SYAR'IYAH BANDA ACEH</td>
            <td>MASA KERJA</td>
            <td><?= $masa_kerja ?></td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=4>
                <strong>II. JENIS CUTI YANG DIAMBIL</strong>
            </td>
        </tr>
        <tr>
            <td>1. CUTI TAHUNAN</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 1) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
            <td>2. CUTI BESAR</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 4) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
        </tr>
        <tr>
            <td>3. CUTI SAKIT</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 2) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
            <td>4. CUTI MELAHIRKAN</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 3) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
        </tr>
        <tr>
            <td>5. CUTI ALASAN PENTING</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 5) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
            <td>6. CUTI LUAR TANGGUNGAN NEGARA</td>
            <td style="width:10%;text-align:center;"><?php
            if ($jenis == 6) {
                echo '<i class="nav-icon fas fa-check"></i>';
            }
            ?></td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=4>
                <strong>III. ALASAN CUTI</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan=4><?= $alasan ?></td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=6>
                <strong>IV. LAMANYA CUTI</strong>
            </td>
        </tr>
        <tr>
            <td>SELAMA</td>
            <td style="text-align:center; width: 30%;"><?= $lama ?></td>
            <td style="text-align:center">MULAI TANGGAL</td>
            <td style="text-align:center"><?= $tgl_awal ?></td>
            <td style="text-align:center">s/d</td>
            <td style="text-align:center"><?= $tgl_akhir ?></td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=5>
                <strong>V. CATATAN CUTI</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                1. CUTI TAHUNAN
            </td>
            <td>2. CUTI BESAR</td>
            <td style="text-align:center; width: 10%">
                <?php
                if ($cat_cuti_besar) {
                    $cat_cuti_besar;
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                TAHUN
            </td>
            <td style="text-align:center">SISA</td>
            <td style="text-align:center">KETERANGAN</td>
            <td>3. CUTI SAKIT</td>
            <td style="text-align:center; width: 10%">
                <?php
                if ($cat_cuti_sakit) {
                    $cat_cuti_sakit;
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <?= date('Y') ?>
            </td>
            <td style="text-align:center"><?= $n1 ?></td>
            <td style="text-align:center"></td>
            <td>4. CUTI MELAHIRKAN</td>
            <td style="text-align:center; width: 10%">
                <?php
                if ($cat_cuti_lahir) {
                    $cat_cuti_lahir;
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <?= date('Y') - 1 ?>
            </td>
            <td style="text-align:center"><?= $n2 ?></td>
            <td style="text-align:center"></td>
            <td>5. CUTI ALASAN PENTING</td>
            <td style="text-align:center; width: 10%">
                <?php
                if ($cat_cuti_ap) {
                    $cat_cuti_ap;
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <?= date('Y') - 2 ?>
            </td>
            <td style="text-align:center"><?= $n3 ?></td>
            <td style="text-align:center"></td>
            <td>6. CUTI LUAR TANGGUNGAN NEGARA</td>
            <td style="text-align:center; width: 10%">
                <?php
                if ($cat_cuti_ltn) {
                    $cat_cuti_ltn;
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=3>
                <strong>VI. ALAMAT SELAMA MENJALANKAN CUTI</strong>
            </td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center; width: 60%; height: 100px"><?= $alamat ?></td>
            <td>Telp.</td>
            <td><?= $nohp ?></td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center">
                Hormat Saya,
                <br />
                <img src="<?= $ttd ?>" width="30%">
                <br />
                (<?= $nama ?>)<br />
                NIP. <?= $nip ?>
            </td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td colspan=5>
                <strong>VII. PERTIMBANGAN ATASAN LANGSUNG</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width: 20%">DISETUJUI</td>
            <td style="text-align:center; width: 20%">PERUBAHAN</td>
            <td style="text-align:center; width: 20%">DITANGGUHKAN</td>
            <td style="text-align:center; width: 20%">TIDAK DISETUJUI</td>
            <td rowspan=2 style="text-align:center">
                <br />
                <br />
                <img src="<?= $ttd_validator ?>" width="60%">
                <br /><br />
                (<?= $nama_validator ?>)<br />
                NIP. <?= $nip_validator ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_validator, ['1', '5'])) {
                    echo '<i class="bx bx-check"></i>';
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_validator, ['2', '6'])) {
                    echo '<i class="bx bx-check"></i><br/>';
                    echo '<br/>Alasan : ' . $alasan_validator;
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_validator, ['3', '7'])) {
                    echo '<i class="bx bx-check"></i><br/>';
                    echo '<br/>Alasan : ' . $alasan_validator;
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px"><?php
            if (in_array($status_validator, ['4', '8'])) {
                echo '<i class="bx bx-check"></i><br/>';
                echo '<br/>Alasan : ' . $alasan_validator;
            }
            ?>
            </td>
        </tr>
    </table>

    <br />
    <table width="100%">
        <tr>
            <td colspan=5>
                <strong>VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width: 20%">DISETUJUI</td>
            <td style="text-align:center; width: 20%">PERUBAHAN</td>
            <td style="text-align:center; width: 20%">DITANGGUHKAN</td>
            <td style="text-align:center; width: 20%">TIDAK DISETUJUI</td>
            <td rowspan=2 style="text-align:center">
                <br />
                <br />
                <img src="<?= $ttd_ppk ?>" width="60%">
                <br /><br />
                (<?= $nama_ppk ?>)<br />
                NIP. <?= $nip_ppk ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_ppk, ['1', '5'])) {
                    echo '<i class="bx bx-check"></i>';
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_ppk, ['2', '6'])) {
                    echo '<i class="bx bx-check"></i><br/>';
                    echo '<br/>Alasan : ' . $alasan_ppk;
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px">
                <?php
                if (in_array($status_ppk, ['3', '7'])) {
                    echo '<i class="bx bx-check"></i><br/>';
                    echo '<br/>Alasan : ' . $alasan_ppk;
                }
                ?>
            </td>
            <td style="text-align:center; height: 100px"><?php
            if (in_array($status_ppk, ['4', '8'])) {
                echo '<i class="bx bx-check"></i><br/>';
                echo '<br/>Alasan : ' . $alasan_ppk;
            }
            ?>
            </td>
        </tr>
    </table>
    <br />
    Di-<i>generated</i> melalui LITERASI MS Banda Aceh (<?= date('Y-m-d H:i:s') ?>)

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>

</html>