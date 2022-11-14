$(document).ready(function() {
    $('.form-check-input').on('click', function () {
        let harga = 0;
        let ongkir = 0;
        let data_arr = [];
        $('#ongkir').html('Rp 0');
        $(".form-check-input").each(function () {
            if($(this).is(':checked')) {
                harga += $(this).data('harga');
                if($(this).data('paket') != 'a') {
                    $('#ongkir').html('Rp 75.000');
                    ongkir = 90000;
                }

                data_arr.push({
                    "nama_tes" : $(this).data('tes'),
                    "paket" : $(this).data('paket'),
                    "harga" : $(this).data('harga'),
                });
            }
        });
        // console.log(data_arr);
        let total = harga + ongkir;
        $('#item_val').val(harga);
        $('#ongkir_val').val(ongkir);
        $('#total_val').val(total);
        $('#detail_paket').val(JSON.stringify(data_arr));
        $('#item').html(formatRupiah(''+harga, 'Rp '));
        $('#total').html(formatRupiah(''+total, 'Rp '));
    });
});

function formatRupiah(angka, prefix) 
{
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
}