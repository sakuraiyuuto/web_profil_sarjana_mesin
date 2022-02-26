<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\LayananMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class LayananMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $layananMahasiswas = LayananMahasiswa::withTrashed()->get()
            ->sortDesc();
        return view('admin/layanan_mahasiswa.index', compact('layananMahasiswas', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/layanan_mahasiswa.create', compact('session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/layanan_mahasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/layanan_mahasiswa/';

            $originName = $request->thumbnail->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->thumbnail->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->thumbnail->move(public_path($path_url), $fileName);

            //Resize image here
            $thumbnailpath = public_path($path_url) . $fileName;
            $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            $slug = Str::slug($request->judul) . '_' . time();

            LayananMahasiswa::create([
                'thumbnail' => 'images/layanan_mahasiswa/' . $fileName,
                'judul' => $request->judul,
                'teks' => $request->teks,
                'slug' => 'layanan_mahasiswa/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LayananMahasiswa  $layananMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function show(LayananMahasiswa $layananMahasiswas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LayananMahasiswa  $layananMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function edit(LayananMahasiswa $layananMahasiswa)
    {
        $session_user = Auth::user();
        $layananMahasiswa = LayananMahasiswa::all()->firstWhere('slug', $layananMahasiswa->slug);

        return view('admin.layanan_mahasiswa.edit', compact('layananMahasiswa', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LayananMahasiswa  $layananMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/layanan_mahasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $layananMahasiswas = LayananMahasiswa::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $layananMahasiswas->thumbnail;

                LayananMahasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Diubah');
            } else {
                $file = $layananMahasiswas->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/layanan_mahasiswa/';

                $originName = $request->thumbnail->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->thumbnail->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->thumbnail->move(public_path($path_url), $fileName);

                //Resize image here
                $thumbnailpath = public_path($path_url) . $fileName;
                $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbnailpath);

                LayananMahasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/layanan_mahasiswa/' . $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LayananMahasiswa  $layananMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LayananMahasiswa::destroy($id);
        return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Dihapus');
    }

    public function restore($id)
    {
        $layananMahasiswa = LayananMahasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $layananMahasiswa->restore();
        return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Direstore');
    }

    public function delete($id)
    {
        $layananMahasiswa = LayananMahasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $layananMahasiswa->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $layananMahasiswa->forceDelete();
        return redirect('/admin/layanan_mahasiswa')->with('status', 'Layanan Mahasiswa Berhasil Dihapus Permanen');
    }

    public function menuLayananMahasiswa()
    {
        $layananMahasiswas = LayananMahasiswa::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->paginate(6);

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        $profilSingkat = ProfilSingkat::all()
            ->first();
        $kontak = Kontak::all()
            ->first();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.layanan_mahasiswa.index',  compact('layananMahasiswas', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailLayananMahasiswa($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $layananMahasiswa = LayananMahasiswa::where('slug', 'layanan_mahasiswa/' . $slug)
            ->firstOrFail();

        $layananMahasiswas = LayananMahasiswa::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'layanan_mahasiswa/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.layanan_mahasiswa.detail',  compact('layananMahasiswa', 'layananMahasiswas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
