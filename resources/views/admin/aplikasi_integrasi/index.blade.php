@extends('admin/layout/main')

@section('title', 'Aplikasi Terintegrasi')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Aplikasi Terintegrasi</h1>
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
                                <h3 class="card-title">Data Aplikasi Terintegrasi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Aplikasi Terintegrasi
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_aplikasi_integrasi" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Nama</th>
                                                <th>Thumbnail</th>
                                                <th>Teks</th>
                                                <th>Link</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($aplikasiIntegrasis as $aplikasiIntegrasi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $aplikasiIntegrasi->nama }}</td>
                                                    <td><img src="{{ url($aplikasiIntegrasi->thumbnail) }}"
                                                            style="width:100px"></td>
                                                    <td>{{ $aplikasiIntegrasi->teks }}</td>
                                                    <td>{{ $aplikasiIntegrasi->url }}</td>
                                                    <td>{{ $aplikasiIntegrasi->release_date }}</td>
                                                    @if ($aplikasiIntegrasi->deleted_at == '')
                                                        @if ($aplikasiIntegrasi->release_date <= date('Y-m-d'))
                                                            <td>Rilis</td>
                                                        @else
                                                            <td>Belum Rilis</td>
                                                        @endif
                                                    @else ($aplikasiIntegrasi->deleted_at != "")
                                                        <td>Terhapus</td>
                                                    @endif
                                                    @if ($aplikasiIntegrasi->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $aplikasiIntegrasi->id }}"
                                                                data-nama="{{ $aplikasiIntegrasi->nama }}"
                                                                data-thumbnail="{{ url($aplikasiIntegrasi->thumbnail) }}"
                                                                data-teks="{{ $aplikasiIntegrasi->teks }}"
                                                                data-url="{{ $aplikasiIntegrasi->url }}"
                                                                data-release_date="{{ $aplikasiIntegrasi->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ route('aplikasi_integrasi.destroy', $aplikasiIntegrasi) }}"
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
                                                                action="{{ url('/admin/aplikasi_integrasi/' . $aplikasiIntegrasi->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/aplikasi_integrasi/' . $aplikasiIntegrasi->id . '/delete') }}"
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Aplikasi Terintegrasi</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/aplikasi_integrasi') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nama">Nama Aplikasi</label>
                            <input type="text" class="form-control mt-0" name="nama" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Logo (Maksimal 2MB)</label>
                            <div class="form-group">
                                <img id="img_preview_add" style="max-width: 200px;" class="mt-2" />
                            </div>
                            <input type="file" accept="image/*" class="form-control mt-0" name="thumbnail"
                                id="input_foto_add" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="url">Teks</label>
                            <input type="text" class="form-control mt-0" name="teks" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="url">Link Aplikasi</label>
                            <input type="text" class="form-control mt-0" name="url" required maxlength="255"
                                placeholder=". . .">
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

    @foreach ($aplikasiIntegrasis as $aplikasiIntegrasi)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Aplikasi Terintegrasi</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('aplikasi_integrasi.update', $aplikasiIntegrasi->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control mt-0" name="nama" id="nama" required maxlength="255"
                                    placeholder=". . .">
                            </div>
                            <div class="form-group">
                                <label for="thumbnail">Logo (Maksimal 2MB)</label>
                                <div class="form-group">
                                    <img src="" alt="Image Missing" id="old_thumbnail" style="max-width: 200px;"
                                        class="mt-2" />
                                </div>
                                <input type="file" accept="image/*" class="form-control mt-0" name="thumbnail"
                                    id="input_foto_edit">
                            </div>
                            <div class="form-group">
                                <label for="teks">Teks</label>
                                <input type="text" class="form-control mt-0" placeholder=". . ." name="teks" id="teks"
                                    required maxlength="255">
                            </div>
                            <div class="form-group mt-2">
                                <label for="url">Link Aplikasi</label>
                                <input type="text" class="form-control mt-0" name="url" id="url" required maxlength="255"
                                    placeholder=". . .">
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
            $("#tabel_aplikasi_integrasi").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_aplikasi_integrasi_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var url = $(this).data('url');
            var thumbnail = $(this).data('thumbnail');
            var teks = $(this).data('teks');
            var release_date = $(this).data('release_date');

            $(".modal-body #id").val(id);
            $(".modal-body #old_thumbnail").attr("src", thumbnail);
            $(".modal-body #teks").val(teks);
            $(".modal-body #nama").val(nama);
            $(".modal-body #url").val(url);
            $(".modal-body #release_date").val(release_date);
        });

        var uploadField = document.getElementById("input_foto_add");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
            } else {
                //Ubah Img Preview
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('img_preview_add');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            };
        };
        //Form edit image validation
        var uploadField = document.getElementById("input_foto_edit");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
            } else {
                //Ubah Img Preview
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('old_thumbnail');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            };
        };
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
