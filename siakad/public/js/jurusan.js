function getDataJurusan() {

    var table = $('#dataTablejrs').DataTable( {
       "info": false,
       "language": {
           "zeroRecords": "Data tidak ditemukan",
           "lengthMenu": "Menampilkan _MENU_ data per halaman",
       },
       "ajax": {
           "url": "/api/jurusan",
           "type": "GET",
           "dataType": "json",
           "headers": {
               'X-CSRF-TOKEN':`${csrf}`,
               'Authorization': 'Bearer ' + cookieVal,
               'Accept':'application/json'
           },
       },
       "columns": [
           { "data": "nama_jurusan" },
           {"data": "id", "width": "20%", orderable: false, render: function (data) {
               return '<div class="text-center"><button type="button" id="editJurusan" data-edit="'+data+'" class="btn btn-primary" onclick="editJurusan()"><i class="fas fa-pen"></i></button> <button type="button" id="viewJurusan" data-view="'+data+'" class="btn btn-info center" onclick="viewJurusan()"><i class="far fa-eye"></i></button> <button type="button" id="deleteJurusan" data-delete="'+data+'" class="btn btn-danger" onclick="deleteJurusan()"><i class="fas fa-trash"></i></button></div>'
               // return '<a type="button" data-view="123" id="viewData"><i class="far fa-eye"></i></a>'
           }}
       ]
   } );

   oTable = table;
}

function simpanJurusan() {
    var jurusan = document.getElementById('nama_jurusan').value;

    $.ajax({
        url: "/api/jurusan",
        type: "POST",
        dataType: "json",
        data: {
            'nama_jurusan':jurusan
        },
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
            $(".modalTambahJurusan").modal('hide');
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
}

function viewJurusan() {
    $(".modalViewJurusan").modal('show');
    $(document).on('click', '#viewJurusan', function () {
    var idView = $(this).data('view');

        $.ajax({
            url: "/api/jurusan/"+idView,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function (data) {
                document.getElementById("nama_jurusanview").value = data.data.nama_jurusan;
            }
        });
    });

}

function editJurusan() {
    $(".modalEditJurusan").modal('show');
    $(document).on('click', '#editJurusan', function () {
        var idView = $(this).data('edit');
    
            $.ajax({
                url: "/api/jurusan/"+idView,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN':`${csrf}`,
                    'Authorization': 'Bearer ' + cookieVal,
                    'Accept':'application/json'
                },
                success:function (data) {
                    document.getElementById("idjrsn").value = data.data.id;
                    document.getElementById("nama_jurusanedit").value = data.data.nama_jurusan;
                }
            });
    });

}

// Simpan Edit Data Nama Jurusan
$('#editFormJurusan').submit(function (e) {
    e.preventDefault();

    var id = document.getElementById('idjrsn').value;
    let formData = new FormData($('#editFormJurusan')[0]);
    $.ajax({
                url: '/api/jurusan/'+id,
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN':`${csrf}`,
                    'Authorization': 'Bearer ' + cookieVal,
                    'Accept':'application/json'
                },
                success:function (data) {
                    console.log(data.success + 'Berhasil Diupdate');
                    $(".modalEditJurusan").modal('hide');
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

function deleteJurusan() {

    $(".modalDeleteJurusan").modal('show');
    
    $(document).on('click', '#deleteJurusan', function (e) {
        e.preventDefault();
        var idDelete = $(this).data('delete');
        $('#idDeletejrsn').val(idDelete);

    });

    $(document).on('click', '#hapus', function (e) {
        e.preventDefault();
        var idDelete = document.getElementById('idDeletejrsn').value;
        
        $.ajax({
            url: "/api/jurusan/"+idDelete,
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function () {
                console.log('data berhasil dihapus');
                $(".modalDeleteJurusan").modal('hide');
                window.location.reload();
            }
        });
    });
}