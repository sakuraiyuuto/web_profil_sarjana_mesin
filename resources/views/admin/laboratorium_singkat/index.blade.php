@extends('admin/layout/main')

@section('title', 'Laboratorium Singkat')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Laboratorium Singkat</h1>
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
                                <h3 class="card-title">Edit Menu Laboratorium Singkat</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <form class="from-prevent-multiple-submits"
                                        action="{{ route('laboratorium_singkat.update', $laboratoriumSingkat->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('patch')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $laboratoriumSingkat->id }}">
                                        <div class="form-group">
                                            <textarea class="form-control" style="width : 40rem;height:20rem" type="text"
                                                id="teks" name="teks">{{ $laboratoriumSingkat->teks }}</textarea>
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
    
    <!-- Validasi Tombol -->
    <script type="text/javascript">
        (function() {
            $('.from-prevent-multiple-submits').on('submit', function() {
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
            })
        })();
    </script>
@endsection
