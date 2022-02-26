@extends('admin/layout/main')

@section('title', 'Akreditasi')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Akreditasi</h1>
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
                                <h3 class="card-title">Edit Menu Akreditasi Teks</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <form class="from-prevent-multiple-submits"
                                        action="{{ url('/admin/akreditasi/updateAkreditasiText') }}" method="POST">
                                        @method('patch')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $akreditasiText->id }}">
                                        <textarea id="teks" placeholder="Enter the Description"
                                            name="teks">{{ $akreditasiText->teks }}</textarea>
                                        <br>
                                        <button type="submit" class="btn btn-success"> Save </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Akreditasi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a type="button" href="#formModalAdd" data-toggle="modal"
                                            class="btn btn-success mb-3"><i class="fa fa-plus-circle"></i>
                                            Tambah Data Akreditasi
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel_akreditasi" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>PDF</th>
                                                <th>Tanggal Rilis</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($akreditasis as $akreditasi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $akreditasi->judul }}</td>
                                                    <td>
                                                        <a href="{{ url($akreditasi->nama_file) }}"
                                                            target="_blank">{{ $akreditasi->nama_file }}</a>
                                                    </td>
                                                    <td>{{ $akreditasi->release_date }}</td>
                                                    <td>
                                                        @if ($akreditasi->deleted_at != '')
                                                            Terhapus
                                                        @else
                                                            Rilis
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($akreditasi->deleted_at != '')
                                                            <form
                                                                action="{{ url('/admin/akreditasi/' . $akreditasi->id . '/restore') }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                        class="fas fa-trash-restore"></i> Restore
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/admin/akreditasi/' . $akreditasi->id . '/delete_permanen') }}"
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
                                                            <button href="#formModalEdit" role="button" data-toggle="modal"
                                                                data-id="{{ $akreditasi->id }}"
                                                                data-judul="{{ $akreditasi->judul }}"
                                                                data-release_date="{{ $akreditasi->release_date }}"
                                                                class="btn btn-warning open-formModalEdit"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                            <form action="{{ route('akreditasi.destroy', $akreditasi) }}"
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

    <!-- Modal Add -->
    <div class="modal fade" id="formModalAdd" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data Akreditasi</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="formAdd" action="{{ url('/admin/akreditasi') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control mt-0" name="judul" required maxlength="255"
                                placeholder=". . .">
                        </div>
                        <div class="form-group mt-2">
                            <label for="nama_file">PDF (Maksimal 2MB)</label>
                            <input type="file" id="input_pdf_add" class="form-control" name="nama_file" required
                                accept="application/pdf">
                        </div>
                        <div class="form-group mt-2">
                            <label for="release_date">Tanggal Rilis</label>
                            <input type="date" class="form-control" name="release_date" required>
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

    @foreach ($akreditasis as $akreditasi)
        <!-- Modal Edit -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Ubah Data Akreditasi</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="formEdit" action="{{ route('akreditasi.update', $akreditasi->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mt-2">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control mt-0" name="judul" id="judul" required
                                    maxlength="255" placeholder=". . .">
                            </div>
                            <div class="form-group">
                                <label for="nama_file">PDF (Maksimal 2MB)</label>
                                <input type="file" id="input_pdf_edit" class="form-control mt-0" name="nama_file"
                                    accept="application/pdf">
                                <input type="hidden" name="old_file" id="old_file" value="{{ $akreditasi->nama_file }}">
                            </div>
                            <div class="form-group">
                                <label for="release_date">Tanggal Rilis</label>
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

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_akreditasi").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_akreditasi_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!--Modal Edit -->
    <script type="text/javascript">
        $(document).on("click", ".open-formModalEdit", function() {
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var release_date = $(this).data('release_date');
            var old_file = $(this).data('old_file');

            $(".modal-body #id").val(id);
            $(".modal-body #judul").val(judul);
            $(".modal-body #release_date").val(release_date);
            $(".modal-body #input_pdf_edit").val("");
            $(".modal-body #old_file").val(old_file);
        });

        //Form add image validation
        var uploadField = document.getElementById("input_pdf_add");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
            };
        };

        //Form edit image validation
        var uploadField = document.getElementById("input_pdf_edit");
        uploadField.onchange = function() {
            if (this.files[0].size > 2000000) {
                alert("Batas maksimum 2MB!");
                this.value = "";
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

    <script>
            //Define an adapter to upload the files
            class MyUploadAdapter {
                constructor(loader) {
                    // The file loader instance to use during the upload. It sounds scary but do not
                    // worry — the loader will be passed into the adapter later on in this guide.
                    this.loader = loader;

                    // URL where to send files.
                    this.url = '{{ route('ckeditor.upload') }}';

                    //
                }
                // Starts the upload process.
                upload() {
                    return this.loader.file.then(
                        (file) =>
                        new Promise((resolve, reject) => {
                            this._initRequest();
                            this._initListeners(resolve, reject, file);
                            this._sendRequest(file);
                        })
                    );
                }
                // Aborts the upload process.
                abort() {
                    if (this.xhr) {
                        this.xhr.abort();
                    }
                }
                // Initializes the XMLHttpRequest object using the URL passed to the constructor.
                _initRequest() {
                    const xhr = (this.xhr = new XMLHttpRequest());
                    // Note that your request may look different. It is up to you and your editor
                    // integration to choose the right communication channel. This example uses
                    // a POST request with JSON as a data structure but your configuration
                    // could be different.
                    // xhr.open('POST', this.url, true);
                    xhr.open("POST", this.url, true);
                    xhr.setRequestHeader("x-csrf-token", "{{ csrf_token() }}");
                    xhr.responseType = "json";
                }
                // Initializes XMLHttpRequest listeners.
                _initListeners(resolve, reject, file) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = `Couldn't upload file: ${file.name}.`;
                    xhr.addEventListener("error", () => reject(genericErrorText));
                    xhr.addEventListener("abort", () => reject());
                    xhr.addEventListener("load", () => {
                        const response = xhr.response;
                        // This example assumes the XHR server's "response" object will come with
                        // an "error" which has its own "message" that can be passed to reject()
                        // in the upload promise.
                        //
                        // Your integration may handle upload errors in a different way so make sure
                        // it is done properly. The reject() function must be called when the upload fails.
                        if (!response || response.error) {
                            return reject(response && response.error ? response.error.message : genericErrorText);
                        }
                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        // This URL will be used to display the image in the content. Learn more in the
                        // UploadAdapter#upload documentation.
                        resolve({
                            default: response.url,
                        });
                    });
                    // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                    // properties which are used e.g. to display the upload progress bar in the editor
                    // user interface.
                    if (xhr.upload) {
                        xhr.upload.addEventListener("progress", (evt) => {
                            if (evt.lengthComputable) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        });
                    }
                }
                // Prepares the data and sends the request.
                _sendRequest(file) {
                    // Prepare the form data.
                    const data = new FormData();
                    data.append("upload", file);
                    // Important note: This is the right place to implement security mechanisms
                    // like authentication and CSRF protection. For instance, you can use
                    // XMLHttpRequest.setRequestHeader() to set the request headers containing
                    // the CSRF token generated earlier by your application.
                    // Send the request.
                    this.xhr.send(data);
                }
                // ...
            }

            function SimpleUploadAdapterPlugin(editor) {
                editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter(loader);
                };
            }

            //Initialize the ckeditor
            ClassicEditor.create(document.querySelector("#teks"), {
                extraPlugins: [SimpleUploadAdapterPlugin],
            }).catch((error) => {
                console.error(error);
            });
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
