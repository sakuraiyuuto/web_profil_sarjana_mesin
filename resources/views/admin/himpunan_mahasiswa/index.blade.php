@extends('admin/layout/main')

@section('title', 'Himpunan Mahasiswa')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Himpunan Mahasiswa</h1>
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
                                <h3 class="card-title">Edit Menu Himpunan Mahasiswa</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <form class="from-prevent-multiple-submits"
                                        action="{{ route('himpunan_mahasiswa.update', $himpunanMahasiswa->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @method('patch')
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama">Nama Himpunan</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="Masukkan Nama Himpunan"
                                                value="{{ $himpunanMahasiswa->nama }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_foto">Thumbnail (Maksimal 2MB)</label>
                                            <div class="form-group">
                                                <img src="{{ url($himpunanMahasiswa->thumbnail) }}" alt="Image Missing"
                                                    id="old_nama_foto" style="max-width: 200px;" class="mt-2" />
                                            </div>
                                            <input type="file" accept="image/*" class="form-control mt-0" name="thumbnail"
                                                id="input_foto_edit">
                                        </div>
                                        <textarea id="teks" placeholder="Enter the Description"
                                            name="teks">{{ $himpunanMahasiswa->teks }}</textarea>
                                        <br>
                                        <div class="form-group">
                                            <label for="facebook">Nama Pengguna Facebook</label>
                                            <input type="text" class="form-control" id="facebook" name="facebook"
                                                placeholder="Masukkan Nama Pengguna Facebook"
                                                value="{{ $himpunanMahasiswa->facebook }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_facebook">Link Facebook</label>
                                            <input type="text" class="form-control" id="url_facebook" name="url_facebook"
                                                placeholder="Masukkan Link Facebook"
                                                value="{{ $himpunanMahasiswa->url_facebook }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="instagram">Nama Pengguna Instagram</label>
                                            <input type="text" class="form-control" id="instagram" name="instagram"
                                                placeholder="Masukkan Nama Pengguna Instagram"
                                                value="{{ $himpunanMahasiswa->instagram }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_instagram">Link Instagram</label>
                                            <input type="text" class="form-control" id="url_instagram"
                                                name="url_instagram" placeholder="Masukkan Link Instagram"
                                                value="{{ $himpunanMahasiswa->url_instagram }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="youtube">Nama Pengguna Youtube</label>
                                            <input type="text" class="form-control" id="youtube" name="youtube"
                                                placeholder="Masukkan Nama Pengguna Youtube"
                                                value="{{ $himpunanMahasiswa->youtube }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_youtube">Link Youtube</label>
                                            <input type="text" class="form-control" id="url_youtube" name="url_youtube"
                                                placeholder="Masukkan Link Youtube"
                                                value="{{ $himpunanMahasiswa->url_youtube }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="twitter">Nama Pengguna Twitter</label>
                                            <input type="text" class="form-control" id="twitter" name="twitter"
                                                placeholder="Masukkan Nama Pengguna Twitter"
                                                value="{{ $himpunanMahasiswa->twitter }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_twitter">Link Twitter</label>
                                            <input type="text" class="form-control" id="url_twitter" name="url_twitter"
                                                placeholder="Masukkan Link Twitter"
                                                value="{{ $himpunanMahasiswa->url_twitter }}">
                                        </div>
                                        <button type="submit" class="btn btn-success"> Save </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
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
