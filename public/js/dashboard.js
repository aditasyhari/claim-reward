$(document).ready(function() {
    $('#propinsi').change(function() {
        var provID = $(this).val();  
        $("#kotakab").empty();
        $("#kotakab").append('<option>Pilih Kab/Kota</option>');
        $("#kecamatan").empty();
        $("#kecamatan").append('<option>Pilih Kecamatan</option>');
        if(provID) {
            $.ajax({
                type:"GET",
                url:"/lokasi/getkabupaten?provID="+provID,
                dataType: 'JSON',
                success:function(res) {               
                    if(res){
                        $.each(res.data,function(nama, id){
                            $("#kotakab").append('<option value="'+id+'">'+nama+'</option>');
                        });
                    } else {
                        $("#kotakab").empty();
                    }
                }
            });

            $.ajax({
                type:"GET",
                url:"/lokasi/ongkir-provinsi?provID="+provID,
                dataType: 'JSON',
                success:function(res) {    
                    let ongkir = res.data; 
                    let include_ongkir = $('#include_ongkir').val();
                    let diskon = $("#diskon_val").val();       
                    let item = $("#item_val").val();       
                    let total = 0;
                    $("#ongkir_val2").val(ongkir);

                    if(include_ongkir == "no") {
                        $("#ongkir").html(formatRupiah('0', 'Rp '));
                        $("#ongkir_val").val(0);
                        total = parseInt(item) - parseInt(diskon);
                    } else {
                        total = parseInt(item) + parseInt(ongkir) - parseInt(diskon);
                        $("#ongkir").html(formatRupiah(''+ongkir, 'Rp '));
                        $("#ongkir_val").val(res.data);
                    }

                    $("#total").html(formatRupiah(''+total, 'Rp '));
                    $("#total_val").val(total);
                }
            });
        }
    });

    $('#kotakab').change(function() {
        var kotakab = $(this).val();
        $("#kecamatan").empty();
        $("#kecamatan").append('<option>Pilih Kecamatan</option>');
        if(kotakab) {
            $.ajax({
                type:"GET",
                url:"/lokasi/getkecamatan?kabID="+kotakab,
                dataType: 'JSON',
                success:function(res) {               
                    $.each(res.data,function(nama, id){
                        $("#kecamatan").append('<option value="'+id+'">'+nama+'</option>');
                    });
                }
            });
        }
    });

    $('.form-check-input').on('click', function () {
        let harga = 0;
        let ongkir = 0;
        let diskon = $('#diskon_val').val();
        let data_arr = [];
        $('#include_ongkir').val("no");
        $('#ongkir').html('Rp 0');
        $(".form-check-input").each(function () {
            if($(this).is(':checked')) {
                harga += $(this).data('harga');
                if($(this).data('paket').toLowerCase() != 'a') {
                    $('#include_ongkir').val("yes")
                    ongkir = $('#ongkir_val2').val();
                    $('#ongkir').html(formatRupiah(''+ongkir, 'Rp '));
                }

                data_arr.push({
                    "nama_tes" : $(this).data('tes'),
                    "paket" : $(this).data('paket'),
                    "harga" : $(this).data('harga'),
                });
            }
        });
        // console.log(data_arr);
        let total = parseInt(harga) + parseInt(ongkir) - parseInt(diskon);
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