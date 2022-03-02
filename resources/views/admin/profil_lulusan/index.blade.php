@extends('admin/layout/main')

@section('title', 'Profil Lulusan')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil Lulusan</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Alert Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('alert'))
            <div class="alert alert-danger">
                {{ session('alert') }}
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Profil Lulusan</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Profil Lulusan
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_profil_lulusan" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Periode Kelulusan</th>
                                                <th>Tahun Lulus</th>
                                                <th>PDF</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profilLulusans as $profilLulusan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $profilLulusan->nama }}</td>
                                                    <td>{{ $profilLulusan->nim }}</td>
                                                    <td>{{ $profilLulusan->periode_kelulusan }}</td>
                                                    <td>{{ $profilLulusan->tahun_lulus }}</td>
                                                    <td>
                                                        <a href="{{ url($profilLulusan->nama_file) }}" download
                                                            target="_blank">
                                                            <div class="btn btn-success">
                                                                Download
                                                            </div>
                                                        </a>
                                                    </td>
                                                    @if ($profilLulusan->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $profilLulusan->id }}"
                                                                data-nama="{{ $profilLulusan->nama }}"
                                                                data-nim="{{ $profilLulusan->nim }}"
                                                                data-periode_kelulusan="{{ $profilLulusan->periode_kelulusan }}"
                                                                data-tahun_lulus="{{ $profilLulusan->tahun_lulus }}"
                                                                data-old_file="{{ $profilLulusan->nama_file }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ route('profil_lulusan.destroy', $profilLulusan) }}"
                                                                method="post">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><i
                                                                        class="fa fa-trash"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <form
                                                                action="{{ url('/admin/profil_lulusan/' . $profilLulusan->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/profil_lulusan/' . $profilLulusan->id . '/delete') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="nama_file"
                                                                    value="{{ $profilLulusan->nama_file }}">
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus permanen data?')"><i
                                                                        class="fa fa-trash"></i> Delete Permanent
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="formModalAdd" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Profil Lulusan</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/profil_lulusan') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control mt-0" name="nama" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control mt-0" name="nim" required maxlength="15"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="periode_kelulusan">Periode Kelulusan</label>
                            <input type="text" class="form-control mt-0" name="periode_kelulusan" required maxlength="15"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="tahun_lulus">Tahun Lulus</label>
                            <input type="number" class="form-control mt-0" min="1900" max="2199" step="1" name="tahun_lulus"
                                required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="nama_file">PDF (Maksimal 2MB)</label>
                            <input type="file" id="input_file_add" class="form-control" name="nama_file" required
                                accept="application/pdf">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                aria-label="Close">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($profilLulusans as $profilLulusan)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Profil Lulusan</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('profil_lulusan.update', $profilLulusan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control mt-0" name="nama" id="nama" required maxlength="255"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control mt-0" name="nim" id="nim" required maxlength="15"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="periode_kelulusan">Periode Kelulusan</label>
                                <input type="text" class="form-control mt-0" name="periode_kelulusan" id="periode_kelulusan"
                                    required maxlength="15" placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="tahun_lulus">Tahun Lulus</label>
                                <input type="number" class="form-control mt-0" min="1900" max="2199" step="1"
                                    id="tahun_lulus" name="tahun_lulus" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="nama_file">PDF (Maksimal 2MB)</label>
                                <input type="file" id="input_file_edit" class="form-control mt-0" name="nama_file"
                                    accept="application/pdf">
                                <input type="hidden" name="old_file" id="old_file">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    aria-label="Close">Batal</button>
                                <button type="submit" class="btn btn-primary">Ubah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_profil_lulusan").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_profil_lulusan_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var nim = $(this).data('nim');
            var periode_kelulusan = $(this).data('periode_kelulusan');
            var tahun_lulus = $(this).data('tahun_lulus');
            var old_file = $(this).data('old_file');
            var nama_file = "";

            $(".modal-body #id").val(id);
            $(".modal-body #nama").val(nama);
            $(".modal-body #nim").val(nim);
            $(".modal-body #periode_kelulusan").val(periode_kelulusan);
            $(".modal-body #tahun_lulus").val(tahun_lulus);
            $(".modal-body #old_file").val(old_file);
            $(".modal-body #nama_file").val(nama_file);
        });
    </script>

    <!-- Validasi Tombol -->
    <script type="text/javascript">
        var $formAdd = $("#formAdd");
        $formAdd.submit(function() {
            $formAdd.submit(function() {
                return false;
            });
        });

        var $formEdit = $("#formEdit");
        $formEdit.submit(function() {
            $formEdit.submit(function() {
                return false;
            });
        });
    </script>

    <!-- Validasi File 2MB -->
    <script>
        var uploadField = document.getElementById("input_file_add");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
            }
        };

        //Form edit image validation
        var uploadField = document.getElementById("input_file_edit");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
            }
        };
    </script>
@endsection
