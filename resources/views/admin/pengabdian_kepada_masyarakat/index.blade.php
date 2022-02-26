@extends('admin/layout/main')

@section('title', 'Pengabdian Kepada Masyarakat')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pengabdian Kepada Masyarakat</h1>
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
                                <h3 class="card-title">Data Pengabdian Kepada Masyarakat</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a href="{{ url('/admin/pengabdian_kepada_masyarakat/create') }}" type="button"
                                            class="btn btn-success mb-3">
                                            <i class="fa fa-plus-circle mr-2"></i>Tambah Data
                                        </a>
                                    </div>
                                </div>

                                <table id="tabel_pengabdian_kepada_masyarakat" class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Pelaku PKM</th>
                                            <th>Tahun</th>
                                            <th>Thumbnail</th>
                                            <th>Teks</th>
                                            <th>Jadwal Rilis</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($pengabdianKeMasyarakats as $pengabdianKeMasyarakat)
                                            <tr id="{{ $pengabdianKeMasyarakat->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pengabdianKeMasyarakat->judul }}</td>
                                                <td>{{ $pengabdianKeMasyarakat->author }}</td>
                                                <td>{{ $pengabdianKeMasyarakat->tahun }}</td>
                                                <td><img src="{{ url($pengabdianKeMasyarakat->thumbnail) }}"
                                                        style="width:100px"></td>
                                                @if (strlen($pengabdianKeMasyarakat->teks) > 100)
                                                    <td>
                                                        {{ str_replace("&nbsp;", "",substr(strip_tags($pengabdianKeMasyarakat->teks), 0, 100) . '...' )}}
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ str_replace("&nbsp;", "",substr(strip_tags($pengabdianKeMasyarakat->teks), 0, 100))}}
                                                    </td>
                                                @endif
                                                <td>{{ $pengabdianKeMasyarakat->release_date }}</td>
                                                @if ($pengabdianKeMasyarakat->deleted_at == '')
                                                    @if ($pengabdianKeMasyarakat->release_date <= date('Y-m-d'))
                                                        <td>Rilis</td>
                                                    @else
                                                        <td>Belum Rilis</td>
                                                    @endif
                                                @else ($pengabdianKeMasyarakat->deleted_at != "")
                                                    <td>Terhapus</td>
                                                @endif
                                                @if ($pengabdianKeMasyarakat->deleted_at == '')
                                                    <td>
                                                        <a href="{{ route('pengabdian_kepada_masyarakat.edit', $pengabdianKeMasyarakat) }}"
                                                            class="btn btn-warning open-formModalEdit"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                        <form
                                                            action="{{ route('pengabdian_kepada_masyarakat.destroy', $pengabdianKeMasyarakat) }}"
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
                                                            action="{{ url('/admin/pengabdian_kepada_masyarakat/' . $pengabdianKeMasyarakat->id . '/restore') }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                    class="fas fa-trash-restore"></i> Restore
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/admin/pengabdian_kepada_masyarakat/' . $pengabdianKeMasyarakat->id . '/delete') }}"
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
            $("#tabel_pengabdian_kepada_masyarakat").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_pengabdian_kepada_masyarakat_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
