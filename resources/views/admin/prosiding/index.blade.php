@extends('admin/layout/main')

@section('title', 'Prosiding')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Prosiding</h1>
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
                                <h3 class="card-title">Data Prosiding</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Prosiding
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_prosiding" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>Author</th>
                                                <th>Tahun</th>
                                                <th>Nomor/Volume</th>
                                                <th>Link File</th>
                                                <th>File</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prosidings as $prosiding)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $prosiding->judul }}</td>
                                                    <td>{{ $prosiding->author }}</td>
                                                    <td>{{ $prosiding->tahun }}</td>
                                                    <td>{{ $prosiding->nomor_volume }}</td>
                                                    <td><a href="{{ $prosiding->url }}">{{ $prosiding->url }}</a></td>
                                                    <td><a href="{{ url($prosiding->nama_file) }}" download
                                                            target="_blank">{{ $prosiding->nama_file }}</a></td>
                                                    <td>{{ $prosiding->release_date }}</td>
                                                    @if ($prosiding->deleted_at == '')
                                                        @if ($prosiding->release_date <= date('Y-m-d'))
                                                            <td>Rilis</td>
                                                        @else
                                                            <td>Belum Rilis</td>
                                                        @endif
                                                    @else ($prosiding->deleted_at != "")
                                                        <td>Terhapus</td>
                                                    @endif
                                                    @if ($prosiding->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $prosiding->id }}"
                                                                data-judul="{{ $prosiding->judul }}"
                                                                data-author="{{ $prosiding->author }}"
                                                                data-tahun="{{ $prosiding->tahun }}"
                                                                data-nomor_volume="{{ $prosiding->nomor_volume }}"
                                                                data-url="{{ $prosiding->url }}"
                                                                data-nama_file="{{ $prosiding->nama_file }}"
                                                                data-release_date="{{ $prosiding->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ route('prosiding.destroy', $prosiding) }}"
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
                                                                action="{{ url('/admin/prosiding/' . $prosiding->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/prosiding/' . $prosiding->id . '/delete') }}"
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Prosiding</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/prosiding') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control mt-0" name="judul" required
                                     placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="author">Author</label>
                                <input type="text" class="form-control mt-0" name="author" required 
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control mt-0" name="tahun" required maxlength="4"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="nomor_volume">Nomor/Volume</label>
                                <input type="text" class="form-control mt-0" name="nomor_volume" required 
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="url">Link File Prosiding</label>
                                <input type="text" class="form-control mt-0" name="url" required 
                                    placeholder=". . .">
                            </div>
                        <div class="form-group">
                            <label for="nama_file">File Prosiding</label>
                            <input type="file" class="form-control mt-0" name="nama_file"
                                onchange="Filevalidation()">
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

    @foreach ($prosidings as $prosiding)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Prosiding</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('prosiding.update', $prosiding->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control mt-0" name="judul" id="judul" required
                                     placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="author">Author</label>
                                <input type="text" class="form-control mt-0" name="author" id="author" required 
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control mt-0" name="tahun" id="tahun" required maxlength="4"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="nomor_volume">Nomor/Volume</label>
                                <input type="text" class="form-control mt-0" name="nomor_volume" id="nomor_volume" required 
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="url">Link File Prosiding</label>
                                <input type="text" class="form-control mt-0" name="url" id="url" required 
                                    placeholder=". . .">
                            </div>
                            <div class="form-group">
                                <label for="nama_file">File Prosiding</label>
                                <input type="file" class="form-control mt-0" name="nama_file" id="nama_file"
                                    onchange="Filevalidation()">
                            </div>
                            <div class="form-group mt-2">
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
            $("#tabel_prosiding").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_prosiding_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var author = $(this).data('author');
            var tahun = $(this).data('tahun');
            var nomor_volume = $(this).data('nomor_volume');
            var url = $(this).data('url');
            var nama_file = $(this).data('nama_file');
            var release_date = $(this).data('release_date');

            $(".modal-body #id").val(id);
            $(".modal-body #judul").val(judul);
            $(".modal-body #author").val(author);
            $(".modal-body #tahun").val(tahun);
            $(".modal-body #nomor_volume").val(nomor_volume);
            $(".modal-body #url").val(url);
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

        (function() {
            $('.from-prevent-multiple-submits').on('submit', function() {
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
            })
        })();
    </script>
@endsection
