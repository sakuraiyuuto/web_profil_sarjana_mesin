<?php

namespace App\Http\Controllers;

use App\Models\SidangAkhir;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SidangAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $sidangAkhir = SidangAkhir::all()->first();

        return view('admin.sidang_akhir.index', compact('sidangAkhir', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, SidangAkhir $sidangAkhir)
    {
        $this->validate($request, [
            'id'     => 'required',
            'teks'     => 'required'
        ]);

        $sidangAkhir = SidangAkhir::all()
            ->where('id', $request->id)
            ->first();

        if ($request->nama_file == "") {
            $fileName = $sidangAkhir->nama_file;

            SidangAkhir::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => $fileName,
                ]);
            return redirect('/admin/sidang_akhir')->with('status', 'Sidang Akhir Berhasil Diubah');
        } else {
            $file = $sidangAkhir->nama_file;
            if (file_exists($file)) {
                @unlink($file);
            }

            $path_url = 'files/sidang_akhir/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            SidangAkhir::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => 'files/sidang_akhir/' . $fileName,
                ]);
            return redirect('/admin/sidang_akhir')->with('status', 'Sidang Akhir Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SidangAkhir  $sidangAkhir
     * @return \Illuminate\Http\Response
     */

    public function menuSidangAkhir()
    {
        $sidangAkhir = SidangAkhir::all()
            ->first();

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

        return view('portal.sidang_akhir.index',  compact('sidangAkhir', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
