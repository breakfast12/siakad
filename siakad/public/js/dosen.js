function getDataDosen() {

    var table = $('#dataTableDosen').DataTable( {
       "info": false,
       "language": {
           "zeroRecords": "Data tidak ditemukan",
           "lengthMenu": "Menampilkan _MENU_ data per halaman",
       },
       "ajax": {
           "url": "/api/dosen",
           "type": "GET",
           "dataType": "json",
           "headers": {
               'X-CSRF-TOKEN':`${csrf}`,
               'Authorization': 'Bearer ' + cookieVal,
               'Accept':'application/json'
           },
       },
       "columns": [
           { "data": "nama_dosen" },
           { "data": "nip" },
            { "data": "images", orderable: false, render: function (data) {
                return '<img src="storage/foto/'+data+'" class="img-thumbnail rounded" alt="gambar">'
            }},
           {"data": "id", "width": "20%", orderable: false, render: function (data) {
               return '<div class="text-center"><button type="button" id="editDosen" data-edit="'+data+'" class="btn btn-primary" onclick="editDosen()"><i class="fas fa-pen"></i></button> <button type="button" id="viewDosen" data-view="'+data+'" class="btn btn-info center" onclick="viewDosen()"><i class="far fa-eye"></i></button> <button type="button" id="deleteDosen" data-delete="'+data+'" class="btn btn-danger" onclick="deleteDosen()"><i class="fas fa-trash"></i></button></div>'
               // return '<a type="button" data-view="123" id="viewData"><i class="far fa-eye"></i></a>'
           }}
       ]
   } );

   oTable = table;
}

$('#matkul_id').select2({
    dropdownParent: $('.modalTambahDosen'),
    placeholder: 'Pilih Mata Kuliah',
    ajax: {
      url: '/api/matkulcombo',
      dataType: 'json',
      data: function (params) {
        return {
          q: (params.term)
        };
      },
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  $('#matkul_idview').select2({
    dropdownParent: $('.modalViewDosen'),
    placeholder: 'Pilih Mata Kuliah',
    ajax: {
      url: '/api/matkulcombo',
      dataType: 'json',
      data: function (params) {
        return {
          q: (params.term)
        };
      },
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  $('#matkul_idedit').select2({
    dropdownParent: $('.modalEditDosen'),
    placeholder: 'Pilih Mata Kuliah',
    ajax: {
      url: '/api/matkulcombo',
      dataType: 'json',
      data: function (params) {
        return {
          q: (params.term)
        };
      },
      processResults: function (data) {
          console.log(data);
          return {
              results: data.data
          }
      },
      cache: true
    }

  });

  //Simpan Data Dosen

  $(document).on('submit', '#addFormDosen', function (e) {
    e.preventDefault();
    let formData = new FormData($('#addFormDosen')[0]);
    $.ajax({
        url: "/api/dosen",
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
            $(".modalTambahDosen").modal('hide');
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

            document.getElementById('nama_dosen').value = '';
            document.getElementById('nip').value = '';
            document.getElementById('tempat_lahir').value = '';
            document.getElementById('tanggal_lahir').value = '';
            $("#jenis_kelamin").prop('checked', false);
            $('#matkul_id').val(null).trigger('change');
            document.getElementById("images").value= null;
        
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

function viewDosen() {
    var laki = document.getElementById('jenis_kelaminLaki-Lakiview').value;
    var perempuan = document.getElementById('jenis_kelaminPerempuanview').value;
    $(".modalViewDosen").modal('show');
    $(document).on('click', '#viewDosen', function () {
    var idView = $(this).data('view');

        $.ajax({
            url: "/api/dosen/"+idView,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN':`${csrf}`,
                'Authorization': 'Bearer ' + cookieVal,
                'Accept':'application/json'
            },
            success:function (data) {
                document.getElementById("nama_dosenview").value = data.data.nama_dosen;
                document.getElementById("nipview").value = data.data.nip;
                document.getElementById("tempat_lahirview").value = data.data.tempat_lahir;
                document.getElementById("tanggal_lahirview").value = data.data.tanggal_lahir;
                if (data.data.jenis_kelamin == laki) {
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', true);
                    $("#jenis_kelaminPerempuanview").prop('checked', false);
                    $("#jenis_kelaminPerempuanview").prop("disabled", true);
                    $("#jenis_kelaminLaki-Lakiview").prop("disabled", true);
                } else if (data.data.jenis_kelamin == perempuan) {
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', false);
                    $("#jenis_kelaminPerempuanview").prop('checked', true);
                    $("#jenis_kelaminLaki-Lakiview").prop("disabled", true);
                    $("#jenis_kelaminPerempuanview").prop("disabled", true);
                }else{
                    $("#jenis_kelaminLaki-Lakiview").prop('checked', false);
                    $("#jenis_kelaminPerempuanview").prop('checked', false);
                    $("#jenis_kelaminLaki-Lakiview").prop("disabled", true);
                    $("#jenis_kelaminPerempuanview").prop("disabled", true);
                    
                }

                $("#matkul_idview").prop("disabled", true);
                $("#matkul_idview").html('<option value = "'+data.data.matkul.id+'" selected >'+data.data.matkul.nama_mata_kuliah+' - '+data.data.matkul.jurusan.nama_jurusan+'</option>');
                document.getElementById("imagesview").src = "storage/foto/"+data.data.images;
            }
        });
    });

}

function editDosen() {
    var laki = document.getElementById('jenis_kelaminLaki-Lakiedit').value;
    var perempuan = document.getElementById('jenis_kelaminPerempuanedit').value;
    $(".modalEditDosen").modal('show');
    $(document).on('click', '#editDosen', function () {
        var idEdit = $(this).data('edit');
    
            $.ajax({
                url: "/api/dosen/"+idEdit,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN':`${csrf}`,
                    'Authorization': 'Bearer ' + cookieVal,
                    'Accept':'application/json'
                },
                success:function (data) {
                    document.getElementById("iddsn").value = data.data.id;
                    document.getElementById("nama_dosenedit").value = data.data.nama_dosen;
                    document.getElementById("nipedit").value = data.data.nip;
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

                    $("#matkul_idedit").html('<option value = "'+data.data.matkul.id+'" selected >'+data.data.matkul.nama_mata_kuliah+' - '+data.data.matkul.jurusan.nama_jurusan+'</option>');
                    document.getElementById("imagesedit").src = "storage/foto/"+data.data.images;
                }
            });
    });

}

// Simpan Edit Data Nama Jurusan
$('#editFormDosen').submit(function (e) {
    e.preventDefault();

    var id = document.getElementById('iddsn').value;
    let formData = new FormData($('#editFormDosen')[0]);
    $.ajax({
                url: '/api/dosen/'+id,
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
                    $(".modalEditDosen").modal('hide');
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