<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Response;

use App\Models\Imovel;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $username = Auth::user()->username;

        return view('uploads.index', compact('username'));
    }

    public function showUploadFiles(Request $request) {
        $id = $request->id;
        $username = Auth::user()->username;

        return view('uploads.upload_files', compact('username', 'id'));
    }

    public function uploadContrato(Request $request) {
        $id = $request->id_imovel;
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $dir = "/data/intelipag/docs/id_im_".$id;
            $file->move($dir, 'contrato.pdf');
        }

        return response()->json(true);
    }

    public function uploadLaudo(Request $request) {
        $id = $request->id_imovel;
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $dir = "/data/intelipag/docs/id_im_".$id;
            $file->move($dir, 'vistoria.pdf');
        }

        return response()->json(true);
    }
}
