<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $quotes = Quote::withTrashed()->get()
            ->sortDesc();
        return view('admin/quote.index', compact('quotes', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/quote.create', compact('session_user'));
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
            'nama_foto' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'sumber' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/quote')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/quote/';

            $originName = $request->nama_foto->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_foto->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_foto->move(public_path($path_url), $fileName);

            //Resize image here
            $nama_fotopath = public_path($path_url) . $fileName;
            $img = Image::make($nama_fotopath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($nama_fotopath);

            Quote::create([
                'nama_foto' => 'images/quote/' . $fileName,
                'teks' => $request->teks,
                'sumber' => $request->sumber,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/quote')->with('status', 'Quote Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quotes
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quotes
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        $session_user = Auth::user();
        $quote = Quote::all()->firstWhere('slug', $quote->slug);

        return view('admin.quote.edit', compact('quote', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quotes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_foto' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'sumber' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/quote')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $quotes = Quote::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_foto == "") {
                $fileName = $quotes->nama_foto;

                Quote::where('id', $request->id)
                    ->update([
                        'nama_foto' => $fileName,
                        'teks' => $request->teks,
                        'sumber' => $request->sumber,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/quote')->with('status', 'Quote Berhasil Diubah');
            } else {
                $file = $quotes->nama_foto;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/quote/';

                $originName = $request->nama_foto->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_foto->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_foto->move(public_path($path_url), $fileName);

                //Resize image here
                $nama_fotopath = public_path($path_url) . $fileName;
                $img = Image::make($nama_fotopath)->resize(720, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($nama_fotopath);

                Quote::where('id', $request->id)
                    ->update([
                        'nama_foto' => 'images/quote/' . $fileName,
                        'teks' => $request->teks,
                        'sumber' => $request->sumber,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/quote')->with('status', 'Quote Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quotes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quote::destroy($id);
        return redirect('/admin/quote')->with('status', 'Quote Berhasil Dihapus');
    }

    public function restore($id)
    {
        $quote = Quote::withTrashed()
            ->where('id', $id)
            ->first();

        $quote->restore();
        return redirect('/admin/quote')->with('status', 'Quote Berhasil Direstore');
    }

    public function delete($id)
    {
        $quote = Quote::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $quote->nama_foto;

        if (file_exists($file)) {
            @unlink($file);
        }

        $quote->forceDelete();
        return redirect('/admin/quote')->with('status', 'Quote Berhasil Dihapus Permanen');
    }
}
