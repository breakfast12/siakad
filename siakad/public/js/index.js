// Logout
const cookieVal = document.cookie
        .split('; ')
        .find(row => row.startsWith('bearerToken'))
        .split('=')[1];

var csrf = $("meta[name='csrf-token']").attr("content");

function logout() {
    $.ajax({
        url: "/api/logout",
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN':`${csrf}`,
            'Authorization': 'Bearer ' + cookieVal,
            'Accept':'application/json'
        },
        success:function () {
            location.replace('/');
            document.cookie="bearerToken=";
            document.cookie="siakad_session=";
            document.cookie="XSRF-TOKEN=";
        }
    });
}

var oTable;
$(document).ready(function() {
    getDataMahasiswa();
    getDataJurusan();
    getNamaMatkul();
    getDataDosen();
});

//Mahasiswa

function getDataMahasiswa() {

     var table = $('#dataTable').DataTable( {
        "info": false,
        "language": {
            "zeroRecords": "Data tidak ditemukan",
            "lengthMenu": "Menampilkan _MENU_ data per halaman",
        },
        "ajax": {
            "url": "/api/mahasiswa",
            "type": "GET",
            "dataType": "json",
            "headers": {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
        },
        "columns": [
            { "data": "nama_mahasiswa" },
            { "data": "nim" },
            { "data": "images", orderable: false, render: function (data) {
                return '<img src="storage/foto/'+data+'" class="img-thumbnail rounded" alt="gambar">'
            }},
            {"data": "id", "width": "20%", orderable: false, render: function (data) {
                return '<div class="text-center"><button type="button" id="editData" data-edit="'+data+'" class="btn btn-primary" onclick="editData()"><i class="fas fa-pen"></i></button> <button type="button" id="viewData" data-view="'+data+'" class="btn btn-info center" onclick="viewData()"><i class="far fa-eye"></i></button> <button type="button" id="deleteData" data-delete="'+data+'" class="btn btn-danger" onclick="deleteData()"><i class="fas fa-trash"></i></button></div>'
                // return '<a type="button" data-view="123" id="viewData"><i class="far fa-eye"></i></a>'
            }}
        ]
    } );

    oTable = table;
}

// Simpan mahasiswa
// function Simpan() {

    $(document).on('submit', '#addFormMahasiswa', function (e) {
        e.preventDefault();
        let formData = new FormData($('#addFormMahasiswa')[0]);
        $.ajax({
            url: "/api/mahasiswa",
            type: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            beforeSend:function(){
                $(document).find('div.error-text').text('');
            },
            success:function (data) {
                
                console.log(data.success + 'Berhasil Simpan');
                $(".modalTambah").modal('hide');
                oTable.ajax.reload();
                $('#alertStatus').append(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!!</strong> Data Berhasil disimpan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();
                    });
                }, 4000);
            
            },
            error:function (xhr, ajaxOptions, thrownError){
                if(xhr.status==404) {
                    // alert(thrownError);
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.message);


                    $.each(err.message, function(prefix, val){
                        $('#err'+prefix).text(val[0])
                       
                    });
                }
            }
            
        });
    });
// }

function viewData() {
    var laki = document.getElementById('jenis_kelaminLaki-Lakiview').value;
    var perempuan = document.getElementById('jenis_kelaminPerempuanview').value;
    $(".modalView").modal('show');
    $(document).on('click', '#viewData', function () {
    var idView = $(this).data('view');

        $.ajax({
            url: "/api/mahasiswa/"+idView,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function (data) {
                document.getElementById("nama_mahasiswaview").value = data.data.nama_mahasiswa;
                document.getElementById("nimview").value = data.data.nim;
                document.getElementById("tempat_lahirview").value = data.data.tempat_lahir;
                document.getElementById("tanggal_lahirview").value = data.data.tanggal_lahir;

                if (data.data.jenis_kelamin == laki) {
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', true);
                    $("#jenis_kelaminPerempuanview").prop('checked', false);
                } else if (data.data.jenis_kelamin == perempuan) {
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', false);
                    $("#jenis_kelaminPerempuanview").prop('checked', true);
                }else{
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', false);
                    $("#jenis_kelaminPerempuanview").prop('checked', false);
                }
                document.getElementById("imagesview").src = "storage/foto/"+data.data.images;
            }
        });
    });

}

function editData() {
    var laki = document.getElementById('jenis_kelaminLaki-Lakiview').value;
    var perempuan = document.getElementById('jenis_kelaminPerempuanview').value;
    $(".modalEdit").modal('show');
    $(document).on('click', '#editData', function () {
        var idView = $(this).data('edit');
    
            $.ajax({
                url: "/api/mahasiswa/"+idView,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN':`${csrf}`,
                    'Authorization': 'Bearer ' + cookieVal,
                    'Accept':'application/json'
                },
                success:function (data) {
                    document.getElementById("idmhs").value = data.data.id;
                    document.getElementById("nama_mahasiswaedit").value = data.data.nama_mahasiswa;
                    document.getElementById("nimedit").value = data.data.nim;
                    document.getElementById("tempat_lahiredit").value = data.data.tempat_lahir;
                    document.getElementById("tanggal_lahiredit").value = data.data.tanggal_lahir;
                    if (data.data.jenis_kelamin == laki) {
                        $("#jenis_kelaminLaki-Lakiedit").prop('checked', true);
                        $("#jenis_kelaminPerempuanedit").prop('checked', false);
                    } else if (data.data.jenis_kelamin == perempuan) {
                        $("#jenis_kelaminLaki-Lakiedit").prop('checked', false);
                        $("#jenis_kelaminPerempuanedit").prop('checked', true);
                    }else{
                        $("#jenis_kelaminLaki-Lakiedit").prop('checked', false);
                        $("#jenis_kelaminPerempuanedit").prop('checked', false);
                    }
                    document.getElementById("imagesedit").src = "storage/foto/"+data.data.images;
                }
            });
    });

}

// Simpan Edit Data Mahasiswa
$('#editFormMahasiswa').submit(function (e) {
    e.preventDefault();

    var id = document.getElementById('idmhs').value;
    let formData = new FormData($('#editFormMahasiswa')[0]);
    $.ajax({
                url: '/api/mahasiswa/'+id,
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN':`${csrf}`,
                    'Authorization': 'Bearer ' + cookieVal,
                    'Accept':'application/json'
                },
                success:function (data) {
                    console.log(data.success + 'Berhasil Diupdate');
                    $(".modalEdit").modal('hide');
                    oTable.ajax.reload();
                    $('#alertStatus').append(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!!</strong> Data Berhasil diupdate
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                        });
                    }, 4000);
                }
            });
});


function deleteData() {

    $(".modalDelete").modal('show');
    
    $(document).on('click', '#deleteData', function (e) {
        e.preventDefault();
        var idDelete = $(this).data('delete');
        $('#idDelete').val(idDelete);

    });

    $(document).on('click', '#hapus', function (e) {
        e.preventDefault();
        var idDelete = document.getElementById('idDelete').value;
        
        $.ajax({
            url: "/api/mahasiswa/"+idDelete,
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function () {
                console.log('data berhasil dihapus');
                $(".modalDelete").modal('hide');
                window.location.reload();
            }
        });
    });
}



