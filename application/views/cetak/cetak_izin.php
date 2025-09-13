<html>

<head>
    <link rel="icon" type="image/x-icon" href="<?= site_url('assets/images/icons/scroll.ico'); ?>" />
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
    </style>
</head>

<body>
    <table style="border:none;">
        <tr>
            <td style="width:100%;text-align:center;border:none" colspan=4><img style="height:100%; width: 100%;"
                    src="<?= $this->session->userdata('kop_satker') ?>"></td>
        </tr>
    </table>
    <br />
    <table width="100%" style="border:none;">

        <tr>
            <td style="text-align:center; border:none;" colspan=4>
                <h3>SURAT IZIN KELUAR</h3>
            </td>
        </tr>
        <br />
        <tr>
            <td colspan=4 style="text-align:center; border:none;"><strong>PEJABAT</strong></td>
        </tr>
        <tr>
            <td style="border:none;">NAMA</td>
            <td colspan=2 style="border:none;">: <?= $nama_atasan ?></td>
        </tr>
        <tr>
            <td style="border:none;">NIP</td>
            <td colspan=2 style="border:none;">: <?= $nip_atasan ?></td>
        </tr>
        <tr>
            <td style="border:none;">JABATAN</td>
            <td colspan=2 style="border:none;">: <?= $jabatan_atasan ?></td>
        </tr>
        <tr>
            <td style="border:none;">UNIT KERJA</td>
            <td colspan=2 style="border:none;">: MAHKAMAH SYAR'IYAH BANDA ACEH KELAS 1 A<br /><br /></td>
        </tr>

        <tr>
            <td colspan=4 style="text-align:center; border:none;"><strong>Memberi Izin KELUAR KANTOR Kepada</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none;">NAMA</td>
            <td colspan=2 style="border:none;">: <?= $nama ?></td>
        </tr>
        <tr>
            <td style="border:none;">NIP</td>
            <td colspan=2 style="border:none;">: <?= $nip ?></td>
        </tr>
        <tr>
            <td style="border:none;">JABATAN</td>
            <td colspan=2 style="border:none;">: <?= $jabatan ?></td>
        </tr>
        <tr>
            <td style="border:none;">UNIT KERJA</td>
            <td colspan=2 style="border:none;">: MAHKAMAH SYAR'IYAH BANDA ACEH KELAS 1 A</td>
        </tr>
        <tr>
            <td style="border:none;">UNTUK KEPERLUAN</td>
            <td colspan=2 style="border:none;">: <?= $alasan ?></td>
        </tr>
        <tr>
            <td style="border:none;">HARI, TANGGAL</td>
            <td colspan=2 style="border:none;">: <?= $tgl ?></td>
        </tr>
        <tr>
            <td style="border:none;">JAM KELUAR</td>
            <td colspan=2 style="border:none;">: <?= $jam_keluar ?></td>
        </tr>
        <tr>
            <td style="border:none;">JAM KEMBALI</td>
            <td colspan=2 style="border:none;">: <?= $jam_kembali ?></td>
        </tr>
    </table>
    <br />
    <table style="border:none;">
        <tr>
            <td style="text-align:center; border:none">Banda Aceh, <?= $tgl_setuju; ?></td>

            <td style="border:none;"></td>
        </tr>
        <tr>
            <td width="50%" style="text-align:center; border:none;">Pejabat yang memberi izin</td>

            <td style="border:none;"> </td>
        </tr>
        <tr>
            <td style="text-align:center; border:none;"><strong><?= $jabatan_atasan; ?></strong></td>
            <td style="text-align:center; border:none;"><strong>Pemohon</strong></td>
        </tr>
        <tr>
            <td style="text-align:center;border:none;">
                <?php if ($qr_atasan_image) { ?>
                    <img src="<?php echo $qr_atasan_image; ?>" width="40%" alt="<?= $nama_atasan ?>">
                <?php } ?>
            </td>
            <td style="text-align:center;border:none;">
                <?php if ($qr_pegawai_image) { ?>
                    <img src="<?php echo $qr_pegawai_image; ?>" width="40%" alt="<?= $nama ?>">
                <?php } ?>
            </td>
        </tr>
        <tr style="vertical-align:bottom">
            <td style="text-align:center; border:none;"><strong><?= $nama_atasan; ?></strong></td>
            <td style="text-align:center; border:none;"><strong><?= $nama; ?></strong></td>
        </tr>
    </table>

    <br />
    <em>catatan</em>
    <ul>
        <li>Dokumen izin ini diinput secara elektronik melalui aplikasi SSO Mahkamah Syar'iyah Banda Aceh</li>
        <li>Belum menggunakan sertifikat elektronik dari BSRE-BSSN karena bersifat internal</li>
    </ul>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>

</html>