@extends('admin/layout/main')

@section('title', 'Kerjasama Mitra Kolaborasi')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kerjasama Mitra Kolaborasi</h1>
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
                                <h3 class="card-title">Data Kerjasama Mitra Kolaborasi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="{{ url('/admin/kerjasama_mitra_kolaborasi/create') }}"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Kerjasama Mitra Kolaborasi
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_kerjasama_mitra_kolaborasi" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>Thumbnail</th>
                                                <th>Teks</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kerjasamaMitraKolaborasis as $kerjasamaMitraKolaborasi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kerjasamaMitraKolaborasi->judul }}</td>
                                                    <td>
                                                        <img src="{{ url($kerjasamaMitraKolaborasi->thumbnail) }}"
                                                            alt="Image Missing" style="width: 100px;">
                                                    </td>
                                                    @if (strlen($kerjasamaMitraKolaborasi->teks) > 100)
                                                        <td>
                                                        {{ str_replace("&nbsp;", "",substr(strip_tags($kerjasamaMitraKolaborasi->teks), 0, 100) . '...' )}}
                                                        </td>
                                                    @else
                                                        <td>
                                                        {{ str_replace("&nbsp;", "",substr(strip_tags($kerjasamaMitraKolaborasi->teks), 0, 100))}}
                                                        </td>
                                                    @endif
                                                    <td>{{ $kerjasamaMitraKolaborasi->release_date }}</td>
                                                    <td>
                                                        @if ($kerjasamaMitraKolaborasi->deleted_at != '')
                                                            Terhapus
                                                        @elseif ($kerjasamaMitraKolaborasi->release_date > date('Y-m-d'))
                                                            Belum Rilis
                                                        @else
                                                            Rilis
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($kerjasamaMitraKolaborasi->deleted_at != '')
                                                            <form
                                                                action="{{ url('/admin/kerjasama_mitra_kolaborasi/' . $kerjasamaMitraKolaborasi->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/kerjasama_mitra_kolaborasi/' . $kerjasamaMitraKolaborasi->id . '/delete_permanen') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="thumbnail"
                                                                    value="{{ $kerjasamaMitraKolaborasi->thumbnail }}">
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus permanen data?')"><i
                                                                        class="fa fa-trash"></i> Delete Permanent
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('kerjasama_mitra_kolaborasi.edit', $kerjasamaMitraKolaborasi) }}"
                                                                class="btn btn-warning open-formModalEdit">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <form
                                                                action="{{ route('kerjasama_mitra_kolaborasi.destroy', $kerjasamaMitraKolaborasi) }}"
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

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_kerjasama_mitra_kolaborasi").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_kerjasama_mitra_kolaborasi_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
