@extends('admin/layout/main')

@section('title', 'Unduhan')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Unduhan</h1>
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
                                <h3 class="card-title">Data Unduhan</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Unduhan
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_unduhan" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>File</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unduhans as $unduhan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $unduhan->judul }}</td>
                                                    <td><a href="{{ url($unduhan->nama_file) }}" download
                                                            target="_blank">{{ $unduhan->nama_file }}</a></td>
                                                    <td>{{ $unduhan->release_date }}</td>
                                                    @if ($unduhan->deleted_at == '')
                                                        @if ($unduhan->release_date <= date('Y-m-d'))
                                                            <td>Rilis</td>
                                                        @else
                                                            <td>Belum Rilis</td>
                                                        @endif
                                                    @else
                                                        <td>Terhapus</td>
                                                    @endif
                                                    @if ($unduhan->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $unduhan->id }}"
                                                                data-judul="{{ $unduhan->judul }}"
                                                                data-nama_file="{{ $unduhan->nama_file }}"
                                                                data-release_date="{{ $unduhan->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form action="{{ route('unduhan.destroy', $unduhan) }}"
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
                                                                action="{{ url('/admin/unduhan/' . $unduhan->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/unduhan/' . $unduhan->id . '/delete') }}"
                                                                method="post">
                                                                @csrf
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Unduhan</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/unduhan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control mt-0" name="judul" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group">
                            <label for="nama_file">File Unduhan (Maksimal 2MB)</label>
                            <input type="file" id="input_file_add" class="form-control mt-0" name="nama_file" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="release_date">Jadwal Rilis</label>
                            <input type="date" class="form-control mt-0" name="release_date" required>
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

    @foreach ($unduhans as $unduhan)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Unduhan</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('unduhan.update', $unduhan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="judul">Nama</label>
                                <input type="text" class="form-control mt-0" name="judul" id="judul" required
                                    maxlength="255" placeholder=". . .">
                            </div>
                            <div class="form-group">
                                <label for="nama_file">File Unduhan (Maksimal 2MB)</label>
                                <input type="file" id="input_file_edit" class="form-control mt-0" name="nama_file"
                                    id="nama_file">
                            </div>
                            <div class=" form-group mt-2">
                                <label for="release_date">Jadwal Rilis</label>
                                <input type="date" class="form-control mt-0" name="release_date" id="release_date" required>
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
            $("#tabel_unduhan").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_unduhan_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var nama_file = $(this).data('nama_file');
            var release_date = $(this).data('release_date');

            $(".modal-body #id").val(id);
            $(".modal-body #judul").val(judul);
            $(".modal-body #release_date").val(release_date);
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
