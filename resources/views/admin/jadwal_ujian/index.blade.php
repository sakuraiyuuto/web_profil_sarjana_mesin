@extends('admin/layout/main')

@section('title', 'Jadwal Ujian')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jadwal Ujian</h1>
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
                                <h3 class="card-title">Data Jadwal Ujian</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Jadwal Ujian
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_jadwal_ujian" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Tipe Ujian</th>
                                                <th>Semester</th>
                                                <th>Tahun Ajaran</th>
                                                <th>File</th>
                                                <th>Jadwal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jadwalUjians as $jadwalUjian)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $jadwalUjian->tipe_ujian }}</td>
                                                    <td>{{ $jadwalUjian->semester }}</td>
                                                    <td>{{ $jadwalUjian->tahun_ajaran }}</td>
                                                    <td><a href="{{ url($jadwalUjian->nama_file) }}" download
                                                            target="_blank">{{ $jadwalUjian->nama_file }}</a></td>
                                                    <td>{{ $jadwalUjian->release_date }}</td>
                                                    @if ($jadwalUjian->deleted_at == '')
                                                        @if ($jadwalUjian->release_date <= date('Y-m-d'))
                                                            <td>Rilis</td>
                                                        @else
                                                            <td>Belum Rilis</td>
                                                        @endif
                                                    @else ($jadwalUjian->deleted_at != "")
                                                        <td>Terhapus</td>
                                                    @endif
                                                    @if ($jadwalUjian->deleted_at == '')
                                                        <td>
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $jadwalUjian->id }}"
                                                                data-tipe_ujian="{{ $jadwalUjian->tipe_ujian }}"
                                                                data-semester="{{ $jadwalUjian->semester }}"
                                                                data-tahun_ajaran="{{ $jadwalUjian->tahun_ajaran }}"
                                                                data-nama_file="{{ $jadwalUjian->nama_file }}"
                                                                data-release_date="{{ $jadwalUjian->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form
                                                                action="{{ route('jadwal_ujian.destroy', $jadwalUjian) }}"
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
                                                                action="{{ url('/admin/jadwal_ujian/' . $jadwalUjian->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/jadwal_ujian/' . $jadwalUjian->id . '/delete') }}"
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
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Jadwal Ujian</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/jadwal_ujian') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="tipe_ujian">Tipe Ujian</label>
                            <select name="tipe_ujian" class="form-control" required>
                                <option selected disable>Pilih Tipe Ujian</option>
                                <option value="Ujian Tengah Semester">Ujian Tengah Semester</option>
                                <option value="Ujian Akhir Semester">Ujian Akhir Semester</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="semester">Semester</label>
                            <select name="semester" class="form-control" required>
                                <option selected disable>Pilih Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-control" required>
                                <option selected disable>Pilih Tahun Ajaran</option>
                                <option value="2017/2018">2017/2018</option>
                                <option value="2018/2019">2018/2019</option>
                                <option value="2019/2020">2019/2020</option>
                                <option value="2020/2021">2020/2021</option>
                                <option value="2021/2022">2021/2022</option>
                                <option value="2022/2023">2022/2023</option>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2024/2025">2024/2025</option>
                                <option value="2025/2026">2025/2026</option>
                                <option value="2026/2027">2026/2027</option>
                                <option value="2027/2028">2027/2028</option>
                                <option value="2028/2029">2028/2029</option>
                                <option value="2029/2030">2029/2030</option>
                                <option value="2030/2031">2030/2031</option>
                                <option value="2031/2032">2031/2032</option>
                                <option value="2032/2033">2032/2033</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_file">File Jadwal Ujian</label>
                            <input type="file" class="form-control mt-0" name="nama_file" required
                                onchange="Filevalidation()">
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

    @foreach ($jadwalUjians as $jadwalUjian)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Jadwal Ujian</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('jadwal_ujian.update', $jadwalUjian->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="tipe_ujian">Tipe Ujian</label>
                                <select name="tipe_ujian" id="tipe_ujian" class="form-control" required>
                                    <option selected disable>Pilih Tipe Ujian</option>
                                    <option value="Ujian Tengah Semester">Ujian Tengah Semester</option>
                                    <option value="Ujian Akhir Semester">Ujian Akhir Semester</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="semester">Semester</label>
                                <select name="semester" id="semester" class="form-control" required>
                                    <option selected disable>Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                                    <option selected disable>Pilih Tahun Ajaran</option>
                                    <option value="2017/2018">2017/2018</option>
                                    <option value="2018/2019">2018/2019</option>
                                    <option value="2019/2020">2019/2020</option>
                                    <option value="2020/2021">2020/2021</option>
                                    <option value="2021/2022">2021/2022</option>
                                    <option value="2022/2023">2022/2023</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2025/2026">2025/2026</option>
                                    <option value="2026/2027">2026/2027</option>
                                    <option value="2027/2028">2027/2028</option>
                                    <option value="2028/2029">2028/2029</option>
                                    <option value="2029/2030">2029/2030</option>
                                    <option value="2030/2031">2030/2031</option>
                                    <option value="2031/2032">2031/2032</option>
                                    <option value="2032/2033">2032/2033</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_file">File Jadwal Ujian</label>
                                <input type="file" class="form-control mt-0" name="nama_file" id="nama_file"
                                    onchange="Filevalidation()">
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
            $("#tabel_jadwal_ujian").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_jadwal_ujian_wrapper .col-md-6:eq(0)');
        });

        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var tipe_ujian = $(this).data('tipe_ujian');
            var semester = $(this).data('semester');
            var tahun_ajaran = $(this).data('tahun_ajaran');
            var nama_file = $(this).data('nama_file');
            var release_date = $(this).data('release_date');

            $(".modal-body #id").val(id);
            $(".modal-body #tipe_ujian").val(tipe_ujian);
            $(".modal-body #semester").val(semester);
            $(".modal-body #tahun_ajaran").val(tahun_ajaran);
            $(".modal-body #release_date").val(release_date);
            $(".modal-body #nama_file").val(nama_file);
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
