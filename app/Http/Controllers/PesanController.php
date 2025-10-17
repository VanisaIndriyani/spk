<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $pesan = DB::table('pesan')
            ->join('users as pengirim', 'pesan.pengirim_id', '=', 'pengirim.id')
            ->join('users as penerima', 'pesan.penerima_id', '=', 'penerima.id')
            ->where('pesan.penerima_id', $userId)
            ->select('pesan.*', 'pengirim.full_name as nama_pengirim', 'penerima.full_name as nama_penerima')
            ->orderBy('pesan.created_at', 'desc')
            ->get();
        
        return view('roles.pesan.index', compact('pesan'));
    }

    public function create()
    {
        $users = DB::table('users')
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', Auth::user()->role)
            ->get();
        
        return view('roles.pesan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'isi_pesan' => 'required|string'
        ]);

        $data['pengirim_id'] = Auth::id();
        
        DB::table('pesan')->insert([
            ...$data,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('pesan.index')->with('success', 'Pesan berhasil dikirim.');
    }

    public function show($id)
    {
        $pesan = DB::table('pesan')
            ->join('users as pengirim', 'pesan.pengirim_id', '=', 'pengirim.id')
            ->join('users as penerima', 'pesan.penerima_id', '=', 'penerima.id')
            ->where('pesan.id', $id)
            ->where('pesan.penerima_id', Auth::id())
            ->select('pesan.*', 'pengirim.full_name as nama_pengirim', 'penerima.full_name as nama_penerima')
            ->first();

        if (!$pesan) {
            abort(404);
        }

        // Mark as read
        DB::table('pesan')
            ->where('id', $id)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now()
            ]);

        return view('roles.pesan.show', compact('pesan'));
    }

    public function destroy($id)
    {
        DB::table('pesan')
            ->where('id', $id)
            ->where('penerima_id', Auth::id())
            ->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
