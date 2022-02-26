@extends('admin/layout/main')

@section('title', 'Dosen')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dosen</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

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
                                <h3 class="card-title">Data Kelompok Keahlian Dosen</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAddKelompokKeahlianDosen" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Kelompok Keahlian Dosen
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_dosen" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Kelompok Keahlian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kelompokKeahlianDosens as $kelompokKeahlianDosen)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kelompokKeahlianDosen->kelompok_keahlian }}</td>
                                                    @if ($kelompokKeahlianDosen->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEditKelompokKeahlianDosen" role="button"
                                                                data-toggle="modal"
                                                                data-id="{{ $kelompokKeahlianDosen->id }}"
                                                                data-kelompok_keahlian="{{ $kelompokKeahlianDosen->kelompok_keahlian }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ url('admin/dosen/' . $kelompokKeahlianDosen->id . '/destroyKelompoKeahlianDosen') }}"
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
                                                                action="{{ url('/admin/dosen/' . $kelompokKeahlianDosen->id . '/restoreKelompoKeahlianDosen') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/dosen/' . $kelompokKeahlianDosen->id . '/deleteKelompoKeahlianDosen') }}"
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Dosen</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Dosen
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_dosen" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Pangkat/Golongan</th>
                                                <th>Link Web Dosen</th>
                                                <th>Kelompok Keahlian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dosens as $dosen)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dosen->nama }}</td>
                                                    <td>{{ $dosen->nip }}</td>
                                                    <td>{{ $dosen->pangkat_golongan }}</td>
                                                    <td><a href="{{ $dosen->url }}">{{ $dosen->url }}</a></td>
                                                    <td>{{ $dosen->kelompokKeahlianDosen->kelompok_keahlian }}</td>
                                                    @if ($dosen->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $dosen->id }}"
                                                                data-nama="{{ $dosen->nama }}"
                                                                data-nip="{{ $dosen->nip }}"
                                                                data-pangkat_golongan="{{ $dosen->pangkat_golongan }}"
                                                                data-url="{{ $dosen->url }}"
                                                                data-kelompok_keahlian="{{ $dosen->kelompokKeahlianDosen->id }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form action="{{ route('dosen.destroy', $dosen) }}"
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
                                                                action="{{ url('/admin/dosen/' . $dosen->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/dosen/' . $dosen->id . '/delete') }}"
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

    <!-- Modal Add Kelompok Keahlian Dosen-->
    <div class="modal fade" id="formModalAddKelompokKeahlianDosen" tabindex="-1" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Kelompok Keahlian Dosen</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAddKK" action="{{ url('/admin/dosen/storeKelompoKeahlianDosen') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="kelompok_keahlian">Kelompok Keahlian</label>
                            <input type="text" class="form-control mt-0" name="kelompok_keahlian" required maxlength="255"
                                placeholder=". . .">
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

    <!-- Modal Add Dosen-->
    <div class="modal fade" id="formModalAdd" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Dosen</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAddDosen" action="{{ url('/admin/dosen') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control mt-0" name="nama" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control mt-0" name="nip" required maxlength="25"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="pangkat_golongan">Pangkat/Golongan</label>
                            <input type="text" class="form-control mt-0" name="pangkat_golongan" required maxlength="100"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="url">Link Web Dosen</label>
                            <input type="text" class="form-control mt-0" name="url" maxlength="100"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="kelompok_keahlian">Kelompok Keahlian</label>
                            <select class="form-control mt-0" name="kelompok_keahlian_dosen_id" required>
                                <option value="" selected disabled>Pilih Kelompok Keahlian</option>
                                @foreach ($kelompokKeahlianDosenPilihans as $kelompokKeahlianDosen)
                                    <option value="{{ $kelompokKeahlianDosen->id }}">
                                        {{ $kelompokKeahlianDosen->kelompok_keahlian }}</option>
                                @endforeach
                            </select>
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

    @foreach ($dosens as $dosen)
        <!-- Modal Edit Dosen-->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Dosen</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEditDosen" action="{{ route('dosen.update', $dosen->id) }}" method="POST">
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
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control mt-0" name="nip" id="nip" required maxlength="25"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="pangkat_golongan">Pangkat Golongan</label>
                                <input type="text" class="form-control mt-0" name="pangkat_golongan" id="pangkat_golongan"
                                    required maxlength="100" placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="url">Link Web Dosen</label></label>
                                <input type="text" class="form-control mt-0" name="url" id="url"
                                    maxlength="100" placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="kelompok_keahlian">Kelompok Keahlian</label>
                                <select class="form-control mt-0" name="kelompok_keahlian_dosen_id" id="kelompok_keahlian"
                                    required>
                                    <option value="" selected disabled>Pilih Kelompok Keahlian</option>
                                    @foreach ($kelompokKeahlianDosenPilihans as $kelompokKeahlianDosen)
                                        <option value="{{ $kelompokKeahlianDosen->id }}">
                                            {{ $kelompokKeahlianDosen->kelompok_keahlian }}</option>
                                    @endforeach
                                </select>
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

    @foreach ($kelompokKeahlianDosens as $kelompokKeahlianDosen)
        <!-- Modal Edit Kelompok Keahlian Dosen-->
        <div class="modal fade" id="formModalEditKelompokKeahlianDosen" tabindex="-1" aria-labelledby="formModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Kelompok Keahlian Dosen</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEditKK" action="{{ url('/admin/dosen/updateKelompoKeahlianDosen') }}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="kelompok_keahlian">Kelompok Keahlian</label>
                                <input type="text" class="form-control mt-0" name="kelompok_keahlian"
                                    id="kelompok_keahlian" required maxlength="255" placeholder=". . .">
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
            $("#tabel_dosen").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_dosen_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!--Modal Edit -->
    <script type="text/javascript">
        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var nip = $(this).data('nip');
            var pangkat_golongan = $(this).data('pangkat_golongan');
            var url = $(this).data('url');
            var kelompok_keahlian = $(this).data('kelompok_keahlian');

            $(".modal-body #id").val(id);
            $(".modal-body #nama").val(nama);
            $(".modal-body #nip").val(nip);
            $(".modal-body #pangkat_golongan").val(pangkat_golongan);
            $(".modal-body #url").val(url);
            $(".modal-body #kelompok_keahlian").val(kelompok_keahlian);
        });

        $(document).on("click", ".open-formModalEditKelompokKeahlianDosen", function() {
            var id = $(this).data('id');
            var kelompok_keahlian = $(this).data('kelompok_keahlian');

            $(".modal-body #id").val(id);
            $(".modal-body #kelompok_keahlian").val(kelompok_keahlian);
        });
    </script>

    <!-- Validasi Tombol -->
    <script type="text/javascript">
        var $formAddKK = $("#formAddKK");
        $formAddKK.submit(function() {
            $formAddKK.submit(function() {
                return false;
            });
        });

        var $formEditKK = $("#formEditKK");
        $formEditKK.submit(function() {
            $formEditKK.submit(function() {
                return false;
            });
        });

        var $formAddDosen = $("#formAddDosen");
        $formAddDosen.submit(function() {
            $formAddDosen.submit(function() {
                return false;
            });
        });

        var $formEditDosen = $("#formEditDosen");
        $formEditDosen.submit(function() {
            $formEditDosen.submit(function() {
                return false;
            });
        });
    </script>
@endsection
