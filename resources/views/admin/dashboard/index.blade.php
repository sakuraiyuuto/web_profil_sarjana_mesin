@extends('admin/layout/main')

@section('title', 'Dashboard')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
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
                <div class="col-12">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-12 text-left">
                                <button type="button" class="btn btn-warning mb-3 open-formModalEditData"
                                    data-toggle="modal" data-target="#modal-edit-data" data-id="{{ $session_user->id }}"
                                    data-name="{{ $session_user->name }}" data-email="{{ $session_user->email }}"
                                    data-posisi_jabatan="{{ $session_user->posisi_jabatan }}"
                                    data-telepon="{{ $session_user->telepon }}">
                                    <i class="fa fa-list mr-2"></i>Ubah Data
                                </button>
                                <button type="button" class="btn btn-warning mb-3 ml-2 open-formModalEditPassword"
                                    data-toggle="modal" data-target="#modal-edit-password"
                                    data-id="{{ $session_user->id }}" data-name="{{ $session_user->name }}"
                                    data-email="{{ $session_user->email }}"
                                    data-posisi_jabatan="{{ $session_user->posisi_jabatan }}"
                                    data-telepon="{{ $session_user->telepon }}">
                                    <i class="fa fa-key mr-2"></i>Ubah Password
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>Nama</h3>
                                        <p>{{ $session_user->name }}</p>
                                    </div>
                                    <div class="icon">
                                        <i class="far fa-user"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Email</h3>
                                        <p>{{ $session_user->email }}</p>
                                    </div>
                                    <div class="icon">
                                        <i class="far fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="modal-edit-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('dashboard') }}/{{ $session_user->id }}" method="post"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id" id="id">

                        <div class="form-group mt-2">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control mt-0" id="name" name="name" maxlength="50" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control mt-0" id="email" name="email" maxlength="50" required>
                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah Data</button>
                    </div>

                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal Edit Password -->
    <div class="modal fade" id="modal-edit-password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Password Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('dashboard') }}/{{ $session_user->id }}" method="post"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id" id="id">

                        <input type="hidden" name="name" id="name">

                        <input type="hidden" name="email" id="email">

                        <div class="form-group mt-2">
                            <label for="name">Password Baru</label>
                            <input type="password" class="form-control mt-0" placeholder="Masukkan Password Baru"
                                name="password" id="password_edit" maxlength="255" required onchange="check_pass1()">
                            <input type="checkbox" onclick="myFunction1()">Tampilkan Password
                        </div>

                        <div class="form-group mt-2">
                            <label for="email">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control mt-0" placeholder="Konfirmasi Password Baru"
                                name="password_confirm" id="password_confirm_edit" maxlength="255" required
                                onchange="check_pass1()">
                            <input type="checkbox" onclick="myFunction2()">Tampilkan Password
                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submit_edit">Ubah Password</button>
                    </div>

                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("click", ".open-formModalEditData", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var telepon = $(this).data('telepon');

            $(".modal-body #id").val(id);
            $(".modal-body #name").val(name);
            $(".modal-body #email").val(email);
            $(".modal-body #telepon").val(telepon);
        });

        $(document).on("click", ".open-formModalEditPassword", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var telepon = $(this).data('telepon');

            $(".modal-body #id").val(id);
            $(".modal-body #name").val(name);
            $(".modal-body #email").val(email);
            $(".modal-body #telepon").val(telepon);
        });
    </script>

    <script>
        function myFunction1() {
            var x = document.getElementById("password_edit");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <script>
        function myFunction2() {
            var x = document.getElementById("password_confirm_edit");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <script>
        function check_pass1() {
            if (document.getElementById('password_edit').value ===
                document.getElementById('password_confirm_edit').value) {
                document.getElementById('submit_edit').disabled = false;
            } else {
                document.getElementById('submit_edit').disabled = true;
            }
        }
    </script>
@endsection
