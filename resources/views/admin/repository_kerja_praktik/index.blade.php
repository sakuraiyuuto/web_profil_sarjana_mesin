@extends('admin/layout/main')

@section('title', 'Repository Kerja Praktik')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Repository Kerja Praktik</h1>
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
                                <h3 class="card-title">Data Repository Kerja Praktik</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a href="{{ url('/admin/repository_kerja_praktik/create') }}" type="button"
                                            class="btn btn-success mb-3">
                                            <i class="fa fa-plus-circle mr-2"></i>Tambah Data
                                        </a>
                                    </div>
                                </div>

                                <table id="tabel_repository_kerja_praktik" class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Author</th>
                                            <th>Tahun</th>
                                            <th>Abstrak</th>
                                            <th>Jadwal Rilis</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($repositoryKerjaPraktiks as $repositoryKerjaPraktik)
                                            <tr id="{{ $repositoryKerjaPraktik->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $repositoryKerjaPraktik->judul }}</td>
                                                <td>{{ $repositoryKerjaPraktik->author }}</td>
                                                <td>{{ $repositoryKerjaPraktik->tahun }}</td>
                                                @if (strlen($repositoryKerjaPraktik->teks) > 100)
                                                    <td>
                                                        {!! substr($repositoryKerjaPraktik->teks, 0, 100) . '...' !!}
                                                    </td>
                                                @else
                                                    <td>
                                                        {!! substr($repositoryKerjaPraktik->teks, 0, 100) !!}
                                                    </td>
                                                @endif
                                                <td>{{ $repositoryKerjaPraktik->release_date }}</td>
                                                @if ($repositoryKerjaPraktik->deleted_at == '')
                                                    @if ($repositoryKerjaPraktik->release_date <= date('Y-m-d'))
                                                        <td>Rilis</td>
                                                    @else
                                                        <td>Belum Rilis</td>
                                                    @endif
                                                @else ($repositoryKerjaPraktik->deleted_at != "")
                                                    <td>Terhapus</td>
                                                @endif
                                                @if ($repositoryKerjaPraktik->deleted_at == '')
                                                    <td>
                                                        <a href="{{ route('repository_kerja_praktik.edit', $repositoryKerjaPraktik) }}"
                                                            class="btn btn-warning open-formModalEdit"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                        <form
                                                            action="{{ route('repository_kerja_praktik.destroy', $repositoryKerjaPraktik) }}"
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
                                                            action="{{ url('/admin/repository_kerja_praktik/' . $repositoryKerjaPraktik->id . '/restore') }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                    class="fas fa-trash-restore"></i> Restore
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/admin/repository_kerja_praktik/' . $repositoryKerjaPraktik->id . '/delete') }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_repository_kerja_praktik").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_repository_kerja_praktik_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
