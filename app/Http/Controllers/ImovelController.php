<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Response;

use App\Models\Imovel;
use App\Models\Inquilino;
use App\Models\Proprietario;
use App\Models\Imobiliaria;

class ImovelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $username = Auth::user()->username;
        $inquilino = Inquilino::get();
        $proprietario = Proprietario::get();
        $imobiliaria = Imobiliaria::get();

        return view('imovel.index', compact('username', 'inquilino', 'proprietario', 'imobiliaria'));
    }

    public function getImovelList(Request $request) {
        $offset = $request->start;
        $limit = $request->length;
        $search_val = $request['search']['value'];
        $order_col = $request->order[0]['column'];
        $order_dir = $request->order[0]['dir'];

        $data = Imovel::leftJoin('inquilino', 'imovel.id_inquilino', '=', 'inquilino.id')
                    ->leftJoin('proprietario', 'imovel.id_proprietario', '=', 'proprietario.id')
                    ->leftJoin('imobiliaria', 'imovel.id_imobiliaria', '=', 'imobiliaria.id')
                    ->select(
                        DB::raw('
                            imovel.*,
                            inquilino.nome as inquilino_name,
                            proprietario.nome as proprietario_name,
                            imobiliaria.nome as imobiliaria_name,
                            null as actions
                        ')
                    );

        $order_sql = 'imovel.id';
        switch($order_col) {
            case 0:
                $order_sql = 'imovel.id';
                break;
            case 1:
                $order_sql = 'imovel.endereco_resumido';
                break;
            case 2:
                $order_sql = 'inquilino.nome';
                break;
            case 3:
                $order_sql = 'proprietario.nome';
                break;
            case 4:
                $order_sql = 'imobiliaria.nome';
                break;
            case 5:
                $order_sql = 'imovel.data_contrato';
                break;
        }

        if($search_val != null && isset($search_val) && trim($search_val) != '') {
            $data = $data->where('imovel.id', '=', $search_val)
                        ->orWhere('proprietario.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('inquilino.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('imobiliaria.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('imovel.endereco_resumido', 'like', '%'.$search_val.'%')
                        ->orWhere('imovel.data_contrato', 'like', '%'.$search_val.'%');
        }

        $total_cnt = count($data->get());

        if($order_dir == 'asc') {
            $data = $data->orderBy($order_sql);
        } elseif($order_dir == 'desc') {
            $data = $data->orderByDesc($order_sql);
        }

        $data = $data->skip($offset)
        ->take($limit)
        ->get();
        
        $result = [
            'data' => $data,
            'recordsTotal' => count($data),
            'recordsFiltered' => $total_cnt,
        ];
        return response()->json($result);
    }

    public function editImovel(Request $request) {
        $id = $request->id;
        $inquilino = $request->inquilino;
        $proprietario = $request->proprietario;
        $imobiliaria = $request->imobiliaria;
        $data_contrato = $request->data_contrato;
        $data_vencimento = $request->data_vencimento;
        $tempo_contrato = $request->tempo_contrato;
        $contrato = $request->contrato;
        $endereco = $request->endereco;
        $endereco_resumido = $request->endereco_resumido;
        $cidade = $request->cidade;
        $estado = $request->estado;
        $extras = $request->extras;

        $result = true;
        if($id == null) {
            $imovel = new Imovel();
            $imovel->id_inquilino = $inquilino;
            $imovel->id_proprietario = $proprietario;
            $imovel->id_imobiliaria = $imobiliaria;
            $imovel->data_contrato = $data_contrato;
            $imovel->data_vencimento = $data_vencimento;
            $imovel->tempo_contrato = $tempo_contrato;
            $imovel->contrato = $contrato;
            $imovel->endereco = $endereco;
            $imovel->endereco_resumido = $endereco_resumido;
            $imovel->cidade = $cidade;
            $imovel->estado = $estado;
            $imovel->extras = $extras;

            $result = $imovel->save();
        } else {
            $result = Imovel::where('id', $id)
                ->update([
                    'id_inquilino' => $inquilino,
                    'id_proprietario' => $proprietario,
                    'id_imobiliaria' => $imobiliaria,
                    'data_contrato' => $data_contrato,
                    'data_vencimento' => $data_vencimento,
                    'tempo_contrato' => $tempo_contrato,
                    'contrato' => $contrato,
                    'endereco' => $endereco,
                    'endereco_resumido' => $endereco_resumido,
                    'cidade' => $cidade,
                    'estado' => $estado,
                    'extras' => $extras,
                ]);
        }

        return response()->json($result);
    }

    public function deleteImovel(Request $request) {
        $id = $request->id;

        $result = Imovel::where('id', $id)->delete();

        return response()->json($result);
    }
}
