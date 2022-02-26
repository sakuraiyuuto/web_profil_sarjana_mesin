@extends('admin/layout/main')

@section('title', 'Kalender Akademik')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kalender Akademik</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

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
                                <h3 class="card-title">Data Kalender Akademik</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <a type="button" href="#formModalAdd" data-toggle="modal"
                                        class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                        Tambah Data Kalender Akademik
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_kalender_akademik" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>PDF</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kalenderAkademiks as $kalenderAkademik)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kalenderAkademik->judul }}</td>
                                                    <td>
                                                        <a href="{{ url($kalenderAkademik->nama_file) }}"
                                                            target="_blank">{{ $kalenderAkademik->nama_file }}</a>
                                                    </td>
                                                    <td>{{ $kalenderAkademik->release_date }}</td>
                                                    <td>
                                                        @if ($kalenderAkademik->deleted_at != '')
                                                            Terhapus
                                                        @elseif ($kalenderAkademik->release_date > date('Y-m-d'))
                                                            Belum Rilis
                                                        @else
                                                            Rilis
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($kalenderAkademik->deleted_at != '')
                                                            <form
                                                                action="{{ url('/admin/kalender_akademik/' . $kalenderAkademik->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/kalender_akademik/' . $kalenderAkademik->id . '/delete_permanen') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="nama_file"
                                                                    value="{{ $kalenderAkademik->nama_file }}">
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus permanen data?')"><i
                                                                        class="fa fa-trash"></i> Delete Permanent
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $kalenderAkademik->id }}"
                                                                data-judul="{{ $kalenderAkademik->judul }}"
                                                                data-release_date="{{ $kalenderAkademik->release_date }}"
                                                                data-old_file="{{ $kalenderAkademik->nama_file }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ route('kalender_akademik.destroy', $kalenderAkademik) }}"
                                                                method="post">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><i
                                                                        class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Staf</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/kalender_akademik') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul" value=""
                                required maxlength="255">
                        </div>
                        <div class="form-group mt-2">
                            <label for="nama_file">PDF</label>
                            <input type="file" class="form-control" name="nama_file" required accept="application/pdf">
                        </div>
                        <div class="form-group mt-2">
                            <label for="release_date">Tanggal Rilis</label>
                            <input type="date" class="form-control" name="release_date" required>
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

    @foreach ($kalenderAkademiks as $kalenderAkademik)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Staf</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('kalender_akademik.update', $kalenderAkademik->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control mt-0" id="judul" name="judul"
                                    placeholder="Masukkan Judul">
                            </div>
                            <div class="form-group">
                                <label for="nama_file">PDF</label>
                                <input type="file" class="form-control mt-0" name="nama_file" accept="application/pdf">
                                <input type="hidden" name="old_file" id="old_file"
                                    value="{{ $kalenderAkademik->nama_file }}">
                            </div>
                            <div class="form-group">
                                <label for="release_date">Tanggal Rilis</label>
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

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_kalender_akademik").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_kalender_akademik_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!--Modal Edit -->
    <script type="text/javascript">
        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var release_date = $(this).data('release_date');
            var old_file = $(this).data('old_file');

            $(".modal-body #id").val(id);
            $(".modal-body #judul").val(judul);
            $(".modal-body #release_date").val(release_date);
            $(".modal-body #old_file").val(old_file);
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
@endsection
