@extends('admin.layouts.main')

@section('title', 'Mata Kuliah')

@section('container')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Data Nama Mata Kuliah</h1>
   </div>

   <!-- Content Row -->
   <div class="row">

    <div id="alertStatus"></div>

       <div class="col-lg-6 mb-4">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Tambah Data  <span class="fas fa-plus"></span>
            </button>

            <!-- Modal Tambah Data -->
            <div class="modal fade modalTambahMatkul" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title fw-bold judul-text" id="staticBackdropLabel">Tambah Data Nama Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label judul-text">NAMA MATA KULIAH</label>
                                <input type="text" class="form-control" id="nama_mata_kuliah" name="nama_mata_kuliah">
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errnama_mata_kuliah"></div></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JURUSAN</label><br>
                                <select class="form-select form-control" id="jurusan_nama" name="jurusan_id[]" style="width: 100%"></select>
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errjurusan1_id"></div></span>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="simpan" onclick="simpanMatkul()">Simpan</button>
                    </div>
                </div>
                </div>
            </div>


            <!-- Modal View -->
            <div class="modal fade modalViewMatkul" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title judul-text" id="staticBackdropLabel">Data Nama Mata Kuliah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label judul-text">NAMA MATA KULIAH</label>
                                <input type="text" class="form-control" id="nama_mata_kuliahview" name="nama_mata_kuliah" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JURUSAN</label>
                                <select class="form-select form-control" id="jurusan_namaView" name="jurusan_id[]" style="width: 100%"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                <!-- Modal Edit-->
            <div class="modal fade modalEditMatkul" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Data Nama Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFormMatkul" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" id="idmatkul" name="idmatkul">
                                <label class="form-label judul-text">NAMA MATA KULIAH</label>
                                <input type="text" class="form-control" id="nama_mata_kuliahedit" name="nama_mata_kuliah">
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JURUSAN</label>
                                <select class="form-select form-control" id="jurusan_namaedit" name="jurusan_id[]" style="width: 100%"></select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" id="simpanEdit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade modalDeleteMatkul" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title judul-text" id="staticBackdropLabel">Apakah anda ingin menghapus data ini?</h5>
                    <input type="hidden" id="idDeletematkul">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-danger" id="hapus">Hapus</button>
                    </div>
                </div>
                </div>
            </div>
       </div>

       <!-- DataTales -->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Nama Mata Kuliah</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTablematkul" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <th>Jurusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
   </div>
@endsection