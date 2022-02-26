@extends('admin/layout/main')

@section('title', 'Kontak')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kontak</h1>
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
                                <h3 class="card-title">Edit Menu Kontak</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <!-- form start -->
                                    <form class="from-prevent-multiple-submits"
                                        action="{{ route('kontak.update', $kontak->id) }}" method="POST">
                                        @method('patch')
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email"
                                                    value="{{ $kontak->email }}" required maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="fax">Fax</label>
                                                <input type="text" class="form-control" id="fax" name="fax"
                                                    value="{{ $kontak->fax }}" required maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    value="{{ $kontak->alamat }}" required maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="nomor_telepon">Nomor Telepon</label>
                                                <input type="number" class="form-control" id="nomor_telepon"
                                                    name="nomor_telepon" value="{{ $kontak->nomor_telepon }}" required
                                                    maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="youtube">Nama Channel Youtube</label>
                                                <input type="text" class="form-control" id="youtube" name="youtube"
                                                    value="{{ $kontak->youtube }}" maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="url_youtube">Link Channel Youtube</label>
                                                <input type="text" class="form-control" id="url_youtube"
                                                    name="url_youtube" value="{{ $kontak->url_youtube }}" maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="twitter">Nama Pengguna Twitter</label>
                                                <input type="text" class="form-control" id="twitter" name="twitter"
                                                    value="{{ $kontak->twitter }}" maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="url_twitter">Link Twitter</label>
                                                <input type="text" class="form-control" id="url_twitter"
                                                    name="url_twitter" value="{{ $kontak->url_twitter }}"
                                                    maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="facebook">Nama Pengguna Facebook</label>
                                                <input type="text" class="form-control" id="facebook" name="facebook"
                                                    value="{{ $kontak->facebook }}" maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="url_facebook">Link Facebook</label>
                                                <input type="text" class="form-control" id="url_facebook"
                                                    name="url_facebook" value="{{ $kontak->url_facebook }}"
                                                    maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="instagram">Nama Pengguna Instagram</label>
                                                <input type="text" class="form-control" id="instagram" name="instagram"
                                                    value="{{ $kontak->instagram }}" maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="url_instagram">Link Instagram</label>
                                                <input type="text" class="form-control" id="url_instagram"
                                                    name="url_instagram" value="{{ $kontak->url_instagram }}"
                                                    maxlength="255">
                                            </div>

                                            <div class="form-group">
                                                <label for="whatsapp">Nomor Whatsapp</label>
                                                <div class="row">
                                                    <input type="text" value="+62" readonly
                                                        class="form-control ml-2 col-lg-2">
                                                    <input type="number" class="form-control mt-0 ml-2 col-lg-9"
                                                        id="whatsapp" name="whatsapp" value="{{ $kontak->whatsapp }}"
                                                        maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
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

    <!-- Validasi Tombol -->
    <script type="text/javascript">
        (function() {
            $('.from-prevent-multiple-submits').on('submit', function() {
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
            })
        })();
    </script>
@endsection
