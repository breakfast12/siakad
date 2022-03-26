@extends('admin.layouts.main')

@section('title', 'Mahasiswa')

@section('container')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
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
            <div class="modal fade modalTambah" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title fw-bold judul-text" id="staticBackdropLabel">Tambah Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="addFormMahasiswa" method="POST" enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label judul-text">NAMA MAHASISWA</label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa">
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errnama_mahasiswa"></div></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim">
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errnim"></div></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">TEMPAT TANGGAL LAHIR</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"><input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                </div>
                                <div class="input-group">
                                    <span class="error-text"><div class="error-text invalid-feedback d-block w-100" id="errtempat_lahir"></div></span> <div class="error-text tgl invalid-feedback d-block w-50" id="errtanggal_lahir"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JENIS KELAMIN</label>
                                <div class="input-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelamin" name="jenis_kelamin" value="Laki-Laki">
                                        <label class="form-check-label">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelamin" name="jenis_kelamin" value="Perempuan">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errjenis_kelamin"></div></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">FOTO MAHASISWA</label>
                                <input class="form-control" type="file" id="images" name="images">
                                <p class="fs-6">Ukuran file maksimal 2mb</p>
                                <span class="error-text"><div class="error-text invalid-feedback d-block" id="errimages"></div></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>


            <!-- Modal View -->
            <div class="modal fade modalView" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title judul-text" id="staticBackdropLabel">Data Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label judul-text">NAMA MAHASISWA</label>
                                <input type="text" class="form-control" id="nama_mahasiswaview" name="nama_mahasiswa" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">NIM</label>
                                <input type="text" class="form-control" id="nimview" name="nim" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">TEMPAT TANGGAL LAHIR</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tempat_lahirview" name="tempat_lahir" readonly><input type="date" class="form-control" id="tanggal_lahirview" name="tanggal_lahir" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JENIS KELAMIN</label>
                                <div class="input-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelaminLaki-Lakiview" name="jenis_kelamin" value="Laki-Laki">
                                        <label class="form-check-label">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelaminPerempuanview" name="jenis_kelamin" value="Perempuan">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">FOTO MAHASISWA</label>
                                <img id="imagesview" class="img-thumbnail rounded" height="100" width="100" alt="Gambar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                <!-- Modal Edit-->
            <div class="modal fade modalEdit" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFormMahasiswa" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" id="idmhs" name="idmhs">
                                <label class="form-label judul-text">NAMA MAHASISWA</label>
                                <input type="text" class="form-control" id="nama_mahasiswaedit" name="nama_mahasiswa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">NIM</label>
                                <input type="text" class="form-control" id="nimedit" name="nim">
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">TEMPAT TANGGAL LAHIR</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tempat_lahiredit" name="tempat_lahir"><input type="date" class="form-control" id="tanggal_lahiredit" name="tanggal_lahir">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">JENIS KELAMIN</label>
                                <div class="input-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelaminLaki-Lakiedit" name="jenis_kelamin" value="Laki-Laki">
                                        <label class="form-check-label">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jenis_kelaminPerempuanedit" name="jenis_kelamin" value="Perempuan">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label judul-text">FOTO MAHASISWA</label>
                                <img id="imagesedit" class="img-thumbnail rounded" height="100" width="100" alt="Gambar">
                                <input class="form-control" type="file" id="images" name="images">
                                <p class="fs-6">Ukuran file maksimal 2mb</p>
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
            <div class="modal fade modalDelete" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title judul-text" id="staticBackdropLabel">Apakah anda ingin menghapus data ini?</h5>
                    <input type="hidden" id="idDelete">
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
                <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
   </div>
@endsection