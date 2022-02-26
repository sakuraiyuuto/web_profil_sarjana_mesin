@extends('admin/layout/main')

@section('title', 'Banner')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Banner</h1>
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
                                <h3 class="card-title">Data Banner</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Banner
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_banner" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Foto</th>
                                                <th>Teks</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($banners as $banner)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ url($banner->nama_foto) }}"
                                                            style="width:300px;height:auto;object-fit:cover"></td>
                                                    <td>{{ $banner->teks }}</td>
                                                    <td>{{ $banner->release_date }}</td>
                                                    @if ($banner->deleted_at == '')
                                                        @if ($banner->release_date <= date('Y-m-d'))
                                                            <td>Rilis</td>
                                                        @else
                                                            <td>Belum Rilis</td>
                                                        @endif
                                                    @else ($banner->deleted_at != "")
                                                        <td>Terhapus</td>
                                                    @endif
                                                    @if ($banner->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $banner->id }}"
                                                                data-teks="{{ $banner->teks }}"
                                                                data-nama_foto="{{ url($banner->nama_foto) }}"
                                                                data-sumber="{{ $banner->sumber }}"
                                                                data-release_date="{{ $banner->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form action="{{ route('banner.destroy', $banner) }}"
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
                                                                action="{{ url('/admin/banner/' . $banner->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/banner/' . $banner->id . '/delete') }}"
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Banner</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/banner') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_foto">Foto (Maksimal 2MB)</label>
                            <div class="form-group">
                                <img id="img_preview_add" style="max-width: 200px;" class="mt-2" />
                            </div>
                            <input type="file" accept="image/*" class="form-control mt-0" name="nama_foto"
                                id="input_foto_add" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="teks">Teks</label>
                            <input type="text" class="form-control mt-0" name="teks" required maxlength="255"
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

    @foreach ($banners as $banner)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Banner</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('banner.update', $banner->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="nama_foto">Foto (Maksimal 2MB)</label>
                                <div class="form-group">
                                    <img src="" alt="Image Missing" id="old_nama_foto" style="max-width: 200px;"
                                        class="mt-2" />
                                </div>
                                <input type="file" accept="image/*" class="form-control mt-0" name="nama_foto"
                                    id="input_foto_edit">
                            </div>
                            <div class="form-group mt-2">
                                <label for="teks">Teks</label>
                                <input type="text" class="form-control mt-0" name="teks" id="teks" required maxlength="255"
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
    <script type="text/javascript">
        var $formAdd = $("#formAdd");
        $formAdd.submit(function() {
            $formAdd.submit(function() {
                return false;
            });
        });
    </script>

    <script type="text/javascript">
        var $formEdit = $("#formEdit");
        $formEdit.submit(function() {
            $formEdit.submit(function() {
                return false;
            });
        });
    </script>

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_banner").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_banner_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var teks = $(this).data('teks');
            var nama_foto = $(this).data('nama_foto');
            var release_date = $(this).data('release_date');

            $(".modal-body #id").val(id);
            $(".modal-body #teks").val(teks);
            $(".modal-body #release_date").val(release_date);
            $(".modal-body #old_nama_foto").attr('src', nama_foto);
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
                    var output = document.getElementById('old_nama_foto');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            };
        };
    </script>
@endsection
