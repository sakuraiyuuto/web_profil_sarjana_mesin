@extends('admin/layout/main')

@section('title', 'Profil Singkat')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil Singkat</h1>
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
                                <h3 class="card-title">Edit Menu Profil Singkat</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <form class="from-prevent-multiple-submits"
                                        action="{{ route('profil_singkat.update', $profilSingkat->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('patch')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profilSingkat->id }}">
                                        <div class="form-group">
                                            <label for="nama_foto">Thumbnail (Maksimal 2MB)</label>
                                            <div class="form-group">
                                                <img src="{{ url($profilSingkat->nama_foto) }}" alt="Image Missing"
                                                    id="old_nama_foto" style="max-width: 200px;" class="mt-2" />
                                            </div>
                                            <input type="file" accept="image/*" class="form-control mt-0" name="nama_foto"
                                                id="input_foto_edit">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" style="width : 40rem;height:20rem" type="text"
                                                id="teks" name="teks">{{ $profilSingkat->teks }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"> Save </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
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

    <!-- Validasi Tombol -->
    <script type="text/javascript">
        (function() {
            $('.from-prevent-multiple-submits').on('submit', function() {
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
            })
        })();
    </script>
@endsection
