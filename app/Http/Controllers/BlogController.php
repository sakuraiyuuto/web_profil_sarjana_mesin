<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Blog;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $blogs = Blog::withTrashed()->get()
            ->sortDesc();
        return view('admin.blog.index', compact('blogs', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'release_date' => 'required'
        ]);

        Blog::create($request->all());

        return redirect('/admin/blog')->with('status', 'Blog Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        Blog::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'url' => $request->url,
                'release_date' => $request->release_date,
            ]);

        return redirect('/admin/blog')->with('status', 'Blog Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        Blog::destroy($blog->id);

        return redirect('/admin/blog')->with('status', 'Blog Berhasil Dihapus');
    }

    public function restore($id)
    {
        $blog = Blog::withTrashed()
            ->where('id', $id)
            ->first();

        $blog->restore();
        return redirect('/admin/blog')->with('status', 'Blog Berhasil Direstore');
    }

    public function delete($id)
    {
        $blog = Blog::withTrashed()
            ->where('id', $id)
            ->first();

        $blog->forceDelete();
        return redirect('/admin/blog')->with('status', 'Blog Berhasil Dihapus Permanen');
    }

    public function menuBlog()
    {
        $kontak = Kontak::all()->first();
        
        $profilSingkat = ProfilSingkat::all()->first();
        $blogs = Blog::latest()
            ->paginate(25);
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.blog.index',  compact('blogs', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak'));
    }
}
