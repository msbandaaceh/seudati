$(function () {
    $(document).off('submit', '#formCuti').on('submit', '#formCuti', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        // Cara 2: Convert ke object biasa supaya gampang dilihat
        // console.log(Object.fromEntries(formData));

        $.ajax({
            url: 'simpan_cuti',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-modal').modal('hide');
                    loadTabel();
                    loadStatistik()
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('click', '#hapusCuti').on('click', '#hapusCuti', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('hapus_cuti', { id: id }, function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.success == 1) {
                        notifikasi(json.message, json.success);
                        loadTabel();
                        loadStatistik()
                    } else {
                        notifikasi(json.message, json.success);
                    }
                });
            }
        });
    });

    $(document).off('click', '#cetakCuti').on('click', '#cetakCuti', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah akan mencetak data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, cetak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('cetak_cuti/' + id, '_blank');
            }
        });
    });
});