<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\Penelitian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $penelitians = Penelitian::withTrashed()->get()
            ->sortDesc();
        return view('admin/penelitian.index', compact('penelitians', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/penelitian.create', compact('session_user'));
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
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/penelitian')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/penelitian/';

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

            Penelitian::create([
                'thumbnail' => 'images/penelitian/' . $fileName,
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => 'penelitian/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penelitian  $penelitians
     * @return \Illuminate\Http\Response
     */
    public function show(Penelitian $penelitians)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penelitian  $penelitians
     * @return \Illuminate\Http\Response
     */
    public function edit(Penelitian $penelitian)
    {
        $session_user = Auth::user();
        $penelitian = Penelitian::all()->firstWhere('slug', $penelitian->slug);

        return view('admin.penelitian.edit', compact('penelitian', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penelitian  $penelitians
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/penelitian')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $penelitians = Penelitian::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $penelitians->thumbnail;

                Penelitian::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Diubah');
            } else {
                $file = $penelitians->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/penelitian/';

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

                Penelitian::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/penelitian/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penelitian  $penelitians
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penelitian::destroy($id);
        return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Dihapus');
    }

    public function restore($id)
    {
        $penelitian = Penelitian::withTrashed()
            ->where('id', $id)
            ->first();

        $penelitian->restore();
        return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Direstore');
    }

    public function delete($id)
    {
        $penelitian = Penelitian::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $penelitian->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $penelitian->forceDelete();
        return redirect('/admin/penelitian')->with('status', 'Penelitian Berhasil Dihapus Permanen');
    }

    public function menuPenelitian()
    {
        $penelitians = Penelitian::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('tahun', 'DESC')
            ->get();

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

        return view('portal.penelitian.index',  compact('penelitians', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak'));
    }

    public function menuDetailPenelitian($slug)
    {
        $kontak = Kontak::all()->first();



        $profilSingkat = ProfilSingkat::all()->first();
        $penelitian = Penelitian::where('slug', 'penelitian/' . $slug)
            ->firstOrFail();

        $penelitians = Penelitian::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'penelitian/' . $slug)
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

        return view('portal.penelitian.detail',  compact('penelitian', 'penelitians', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
