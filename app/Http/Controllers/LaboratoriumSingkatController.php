<?php

namespace App\Http\Controllers;

use App\Models\LaboratoriumSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class LaboratoriumSingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $laboratoriumSingkat = LaboratoriumSingkat::all()->first();

        return view('admin/laboratorium_singkat.index', compact('laboratoriumSingkat', 'session_user'));
    }

    public function update(Request $request, LaboratoriumSingkat $laboratoriumSingkat)
    {
        $validator = Validator::make($request->all(), [
            'teks' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/laboratorium_singkat')->with('alert', 'Ada kesalahan data, coba lagi.');
        } 
        else 
        {
            LaboratoriumSingkat::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                ]);
            return redirect('/admin/laboratorium_singkat')->with('status', 'Profil Singkat Berhasil Diubah');
        }
    }
}
