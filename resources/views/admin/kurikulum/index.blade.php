@extends('admin/layout/main')

@section('title', 'Kurikulum')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kurikulum</h1>
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
                                <h3 class="card-title">Data Mata Kuliah</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAddMataKuliah" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Mata Kuliah
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_mata_kuliah" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>SKS</th>
                                                <th>Semester</th>
                                                <th>Kelompok</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mataKuliahs as $mataKuliah)
                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{ $mataKuliah->kode }}</td>
                                                    <td>{{ $mataKuliah->nama }}</td>
                                                    <td>{{ $mataKuliah->sks }}</td>
                                                    <td>{{ $mataKuliah->semester }}</td>
                                                    <td>{{ $mataKuliah->kelompok }}</td>
                                                    <td>
                                                        @if ($mataKuliah->deleted_at != '')
                                                            Terhapus
                                                        @else
                                                            Rilis
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($mataKuliah->deleted_at != '')
                                                            <form
                                                                action="{{ url('/admin/kurikulum/mata_kuliah/' . $mataKuliah->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/kurikulum/mata_kuliah/' . $mataKuliah->id . '/delete_permanen') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="thumbnail"
                                                                    value="{{ $hasilKarya->thumbnail }}">
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus permanen data?')"><i
                                                                        class="fa fa-trash"></i> Delete Permanent
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button href="#formModalEditMataKuliah" role="button"
                                                                data-toggle="modal" data-id="{{ $mataKuliah->id }}"
                                                                data-kode="{{ $mataKuliah->kode }}"
                                                                data-nama="{{ $mataKuliah->nama }}"
                                                                data-sks="{{ $mataKuliah->sks }}"
                                                                data-semester="{{ $mataKuliah->semester }}"
                                                                data-kelompok="{{ $mataKuliah->kelompok }}"
                                                                class="btn btn-warning open-formModalEditMataKuliah"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ url('/admin/kurikulum/mata_kuliah/' . $mataKuliah->id) }}"
                                                                method="post">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><i
                                                                        class="fa fa-trash"></i> Delete</button>
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


    <!-- Modal Add Mata Kuliah-->
    <div class="modal fade" id="formModalAddMataKuliah" tabindex="-1" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Mata Kuliah</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/kurikulum/mata_kuliah/tambah') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control mt-0" name="kode" required maxlength="100"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control mt-0" name="nama" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="sks">SKS</label>
                            <input type="number" class="form-control mt-0" name="sks" required maxlength="2"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="semester">Semester</label>
                            <input type="number" class="form-control mt-0" name="semester" required maxlength="2"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="kelompok">Kelompok</label>
                            <select name="kelompok" class="form-control" required>
                                <option disable value>. . .</option>
                                <option value="Paket">Paket</option>
                                <option value="Wajib">Wajib</option>
                                <option value="Peminatan">Peminatan</option>
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

    @foreach ($mataKuliahs as $mataKuliah)
        <!-- Modal Edit Mata Kuliah-->
        <div class="modal fade" id="formModalEditMataKuliah" tabindex="-1" aria-labelledby="formModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Mata Kuliah</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ url('/admin/kurikulum/mata_kuliah/' . $mataKuliah->id) }}"
                        method="POST">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="kode">Kode</label>
                                <input type="text" class="form-control mt-0" name="kode" id="kode" required maxlength="100"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control mt-0" name="nama" id="nama" required maxlength="255"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="sks">SKS</label>
                                <input type="number" class="form-control mt-0" name="sks" id="sks" required maxlength="10"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="semester">Semester</label>
                                <input type="number" class="form-control mt-0" name="semester" id="semester" required
                                    maxlength="255" placeholder=". . .">
                            </div>
                            <div class="form-group mt-2">
                                <label for="kelompok">Kelompok</label>
                                <select name="kelompok" id="kelompok" class="form-control" required>
                                    <option disable value>. . .</option>
                                    <option value="Paket">Paket</option>
                                    <option value="Wajib">Wajib</option>
                                    <option value="Peminatan">Peminatan</option>
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

    <!--Data Table Mata Kuliah-->
    <script>
        $(function() {
            $("#tabel_mata_kuliah").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_mata_kuliah_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!--Modal Edit Mata Kuliah-->
    <script type="text/javascript">
        $(document).on("click", ".open-formModalEditMataKuliah", function() {
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            var sks = $(this).data('sks');
            var semester = $(this).data('semester');
            var kelompok = $(this).data('kelompok');

            $(".modal-body #id").val(id);
            $(".modal-body #kode").val(kode);
            $(".modal-body #nama").val(nama);
            $(".modal-body #sks").val(sks);
            $(".modal-body #semester").val(semester);
            $(".modal-body #kelompok").val(kelompok);
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
