$('#jurusan_nama').select2({
    dropdownParent: $('.modalTambahMatkul'),
    placeholder: 'Pilih Jurusan',
    ajax: {
      url: '/api/jurusancombo',
      dataType: 'json',
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  $('#jurusan_nama').on('select2:opening select2:closing', function( event ) {
    var $searchfield = $(this).parent().find('.select2-search__field');
    $searchfield.prop('disabled', true);
});

$('#jurusan_namaView').select2({
    dropdownParent: $('.modalViewMatkul'),
    placeholder: 'Pilih Jurusan',
    ajax: {
      url: '/api/jurusancombo',
      dataType: 'json',
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  $('#jurusan_namaView').on('select2:opening select2:closing', function( event ) {
    var $searchfield = $(this).parent().find('.select2-search__field');
    $searchfield.prop('disabled', true);
    
});

$('#jurusan_namaedit').select2({
    dropdownParent: $('.modalEditMatkul'),
    placeholder: 'Pilih Jurusan',
    ajax: {
      url: '/api/jurusancombo',
      dataType: 'json',
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  $('#jurusan_namaView').on('select2:opening select2:closing', function( event ) {
    var $searchfield = $(this).parent().find('.select2-search__field');
    $searchfield.prop('disabled', true);
    
});





function getNamaMatkul() {
    var table = $('#dataTablematkul').DataTable( {
        "info": false,
        "language": {
            "zeroRecords": "Data tidak ditemukan",
            "lengthMenu": "Menampilkan _MENU_ data per halaman",
        },
        "ajax": {
            "url": "/api/matkul",
            "type": "GET",
            "dataType": "json",
            "headers": {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
        },
        "columns": [
            { "data": "nama_mata_kuliah" },
            { "data": "jurusan.nama_jurusan" },
            {"data": "id", "width": "20%", orderable: false, render: function (data) {
                return '<div class="text-center"><button type="button" id="editMatkul" data-edit="'+data+'" class="btn btn-primary" onclick="editMatkul()"><i class="fas fa-pen"></i></button> <button type="button" id="viewMatkul" data-view="'+data+'" class="btn btn-info center" onclick="viewMatkul()"><i class="far fa-eye"></i></button> <button type="button" id="deleteMatkul" data-delete="'+data+'" class="btn btn-danger" onclick="deleteMatkul()"><i class="fas fa-trash"></i></button></div>'
                // return '<a type="button" data-view="123" id="viewData"><i class="far fa-eye"></i></a>'
            }}
        ]
    } );
 
    oTable = table;
}

function simpanMatkul() {
    var nmkuliah = document.getElementById('nama_mata_kuliah').value;
    var nmjur = $('#jurusan_nama').val();

    console.log(nmjur);
    console.log(nmkuliah);


    $.ajax({
        url: "/api/matkul",
        type: "POST",
        dataType: "json",
        data: {
            'nama_mata_kuliah':nmkuliah,
            'jurusan_id':nmjur
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
            $(".modalTambahMatkul").modal('hide');
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

            document.getElementById('nama_mata_kuliah').value = '';
            $('#jurusan_nama').val(null).trigger('change');

        
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

function viewMatkul() {
    $(".modalViewMatkul").modal('show');
    $(document).on('click', '#viewMatkul', function () {
    var idEdit = $(this).data('view');

        $.ajax({
            url: "/api/matkul/"+idEdit,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function (data) {
                document.getElementById("nama_mata_kuliahview").value = data.data.nama_mata_kuliah;
                $("#jurusan_namaView").prop("disabled", true);
                $("#jurusan_namaView").html('<option value = "'+data.data.jurusan.id+'" selected >'+data.data.jurusan.nama_jurusan+'</option>');
            }
        });
    });

}

function editMatkul() {
    $(".modalEditMatkul").modal('show');
    $(document).on('click', '#editMatkul', function () {
        var idEdit = $(this).data('edit');

        $.ajax({
            url: "/api/matkul/"+idEdit,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function (data) {
                document.getElementById("idmatkul").value = data.data.id;
                document.getElementById("nama_mata_kuliahedit").value = data.data.nama_mata_kuliah;
                $("#jurusan_namaedit").html('<option value = "'+data.data.jurusan.id+'" selected >'+data.data.jurusan.nama_jurusan+'</option>');
            }
        });
    })
}

// Simpan Edit Data Mata Kuliah
$('#editFormMatkul').submit(function (e) {
    e.preventDefault();

    var id = document.getElementById('idmatkul').value;
    let formData = new FormData($('#editFormMatkul')[0]);
    $.ajax({
                url: '/api/matkul/'+id,
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
                    $(".modalEditMatkul").modal('hide');
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
                    document.getElementById('nama_mata_kuliah').value = '';
                    $('#jurusan_namaedit').val(null).trigger('change');
                }
            });
});

function deleteMatkul() {

    $(".modalDeleteMatkul").modal('show');
    
    $(document).on('click', '#deleteMatkul', function (e) {
        e.preventDefault();
        var idDelete = $(this).data('delete');
        $('#idDeletematkul').val(idDelete);

    });

    $(document).on('click', '#hapus', function (e) {
        e.preventDefault();
        var idDelete = document.getElementById('idDeletematkul').value;
        
        $.ajax({
            url: "/api/matkul/"+idDelete,
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function () {
                console.log('data berhasil dihapus');
                $(".modalDeleteMatkul").modal('hide');
                window.location.reload();
            }
        });
    });
}