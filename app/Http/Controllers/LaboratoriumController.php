<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\LinkProdi;
use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $laboratoriums = Laboratorium::withTrashed()->get()
            ->sortDesc();
        return view('admin/laboratorium.index', compact('laboratoriums', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/laboratorium.create', compact('session_user'));
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
            'nama' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/laboratorium')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/laboratorium/';

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

            $slug = Str::slug($request->nama) . '_' . time();

            Laboratorium::create([
                'thumbnail' => 'images/laboratorium/' . $fileName,
                'nama' => $request->nama,
                'teks' => $request->teks,
                'slug' => 'laboratorium/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laboratorium  $laboratoriums
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratorium $laboratoriums)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laboratorium  $laboratoriums
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratorium $laboratorium)
    {
        $session_user = Auth::user();
        $laboratorium = Laboratorium::all()->firstWhere('slug', $laboratorium->slug);

        return view('admin.laboratorium.edit', compact('laboratorium', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laboratorium  $laboratoriums
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/laboratorium')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $laboratoriums = Laboratorium::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $laboratoriums->thumbnail;

                Laboratorium::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Diubah');
            } else {
                $file = $laboratoriums->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/laboratorium/';

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

                Laboratorium::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/laboratorium/' . $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laboratorium  $laboratoriums
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Laboratorium::destroy($id);
        return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Dihapus');
    }

    public function restore($id)
    {
        $laboratorium = Laboratorium::withTrashed()
            ->where('id', $id)
            ->first();

        $laboratorium->restore();
        return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Direstore');
    }

    public function delete($id)
    {
        $laboratorium = Laboratorium::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $laboratorium->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $laboratorium->forceDelete();
        return redirect('/admin/laboratorium')->with('status', 'Laboratorium Berhasil Dihapus Permanen');
    }

    public function menuLaboratorium()
    {
        $kontak = Kontak::all()->first();
        $profilSingkat = ProfilSingkat::all()->first();
        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $laboratoriumPaginates = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->paginate(6);
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()->take(6)->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.laboratorium.index',  compact('laboratoriumPaginates', 'laboratoriumHeaders', 'aplikasiIntegrasis', 'informasiTerbarus', 'linkProdis', 'profilSingkat', 'kontak'));
    }

    public function menuDetailLaboratorium($slug)
    {
        $kontak = Kontak::all()->first();
        $profilSingkat = ProfilSingkat::all()->first();
        $laboratorium = Laboratorium::where('slug', 'laboratorium/' . $slug)
            ->firstOrFail();
        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $laboratoriums = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'laboratorium/' . $slug)
            ->orderBy('release_date', 'DESC')
            ->take(2)
            ->get();
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()->take(6)->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.laboratorium.detail',  compact('laboratorium', 'laboratoriums', 'laboratoriumHeaders', 'aplikasiIntegrasis', 'informasiTerbarus', 'linkProdis', 'profilSingkat', 'kontak'));
    }
}
