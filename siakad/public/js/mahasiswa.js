function getDataMahasiswa() {
    // var bodyData = document.getElementById('bodyData');
    // $.ajax({
    //     url: "http://127.0.0.1:8000/api/mahasiswa",
    //     dataType: "json",
    //     headers: {
    //         'X-CSRF-TOKEN':`${csrf}`,
    //         'Authorization': 'Bearer ' + cookieVal,
    //         'Accept':'application/json'
    //     },
    //     success:function (data) {
    //         for (let i = 0; i < data.data.length; i++) {
    //             bodyData.innerHTML += 
    //         `
            
    //                 <td>${data.data[i].nama_mahasiswa}</td>
    //                 <td>${data.data[i].nim}</td>
    //                 <td><img src="storage/foto/${data.data[i].images}" class="rounded" height="100" width="100" alt="gambar"></td>
    //                 <td><button type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button> <span>|</span> 
    //                 <button type="button" class="btn btn-info"><i class="far fa-eye"></i></button></td>
    //             `;
                
    //         }

    //         // for (let i = 0; i < data.data.length; i++) {
    //         //     console.log(data.data[i].nama_mahasiswa);
                
    //         // }
            
    //     }
    // });
}



// $(document).ready(function() {
//     getData();
//     // Simpan();
// } );

// function getData() {
//     var body = document.getElementById('dataTable');
//     $.ajax({
//         url: "http://127.0.0.1:8000/api/mahasiswa",
//         type: "GET",
//         dataType: "json",
//         headers: {
//             'X-CSRF-TOKEN':`${csrf}`,
//             'Authorization': 'Bearer ' + cookieVal,
//             'Accept':'application/json'
//         },
//         success:function (data) {
//             body.innerHTML = 
//             `<tbody>
//                 <tr>
//                     <td>${data.data.nama_mahasiswa}</td>
//                 </tr>
//             </tbody>`;
//         }
//     });
// }

// function Simpan() {

//     $(document).on('submit', '#addFormMahasiswa', function (e) {
//         e.preventDefault();
//         let formData = new FormData($('#addFormMahasiswa')[0]);
//         $.ajax({
//             url: "http://127.0.0.1:8000/api/mahasiswa",
//             type: "POST",
//             dataType: "json",
//             contentType: false,
//             processData: false,
//             data: formData,
//             headers: {
//                 'X-CSRF-TOKEN':`${csrf}`,
//                 'Authorization': 'Bearer ' + cookieVal,
//                 'Accept':'application/json'
//             },
//             success:function (data) {
//                 console.log(data.success + 'Berhasil Simpan');
//                 // getData();
//                 // $("#dataTable").dataTable().fnDestroy();
//                 $(".modalku").modal('hide');
//                 window.location.reload();
//             }
//         });
//     });
// }