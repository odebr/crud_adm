<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

use App\Models\Imovel;
use App\Models\Pagamentos;


class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if (Auth::check()) {
            // The user is logged in...
        }

        $username = Auth::user()->username;
        $imovel = Imovel::all();

        return view('payments.list_payments', compact('username', 'imovel'));
    }

    public function getPaymentsList(Request $request) {
        $id_imovel = $request->id_imovel;
        $offset = $request->start;
        $limit = $request->length;
        $search_val = $request['search']['value'];
        $order_col = $request->order[0]['column'];
        $order_dir = $request->order[0]['dir'];

        $data = [];

        $data = DB::table('pagamentos');

        if($id_imovel != 0) {
            $data = $data->where('id_imovel', $id_imovel);
        }
        $data = $data->leftJoin('imovel', 'pagamentos.id_imovel', '=', 'imovel.id')
                ->leftJoin('proprietario', 'pagamentos.id_proprietario', '=', 'proprietario.id')
                ->leftJoin('inquilino', 'pagamentos.id_inquilino', '=', 'inquilino.id')
                ->leftJoin('imobiliaria', 'pagamentos.id_imobiliaria', '=', 'imobiliaria.id')
                ->select(
                    DB::raw('pagamentos.*'), 
                    DB::raw('imovel.endereco_resumido as imovel_name'),
                    DB::raw('proprietario.nome as proprietario_name'),
                    DB::raw('inquilino.nome as inquilino_name'),
                    DB::raw('imobiliaria.nome as imobiliaria_name')
                );
        
        $order_sql = 'pagamentos.data_vencimento';
        switch($order_col) {
            case 0:
                $order_sql = 'imovel.endereco_resumido';
                break;
            case 1:
                $order_sql = 'pagamentos.tipo';
                break;
            case 2:
                $order_sql = 'proprietario.nome';
                break;
            case 3:
                $order_sql = 'inquilino.nome';
                break;
            case 4:
                $order_sql = 'imobiliaria.nome';
                break;
            case 5:
                $order_sql = 'pagamentos.valor';
                break;
            case 6:
                $order_sql = 'pagamentos.data_vencimento';
                break;
            case 7:
                $order_sql = 'pagamentos.data_pagamento';
                break;
        }

        if($search_val != null && isset($search_val) && trim($search_val) != '') {
            $data = $data->where('imobiliaria.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('proprietario.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('inquilino.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('imobiliaria.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('pagamentos.valor', 'like', '%'.$search_val.'%')
                        ->orWhere('pagamentos.data_vencimento', 'like', '%'.$search_val.'%')
                        ->orWhere('pagamentos.data_pagamento', 'like', '%'.$search_val.'%');
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

        foreach($data as $row) {
            if(isset($row->tipo) && $row->tipo  != null) {
                $row->tipo_name = config('constants.tipo')[$row->tipo];
            } else {
                $row->tipo_name = '';
            }

            $row->actions = null;
        }

        $data = [
            'data' => $data,
            'recordsTotal' => count($data),
            'recordsFiltered' => $total_cnt,
        ];

        return response()->json($data);
    }

    public function createPayment() {
        $username = Auth::user()->username;
        $imovel = Imovel::leftJoin('proprietario', 'imovel.id_proprietario', '=', 'proprietario.id')
                    ->leftJoin('inquilino', 'imovel.id_inquilino', '=', 'inquilino.id')
                    ->leftJoin('imobiliaria', 'imovel.id_imobiliaria', '=', 'imobiliaria.id')
                    ->select(
                        'imovel.id',
                        'imovel.endereco_resumido',
                        DB::raw('proprietario.nome as proprietario'),
                        DB::raw('inquilino.nome as inquilino'),
                        DB::raw('imobiliaria.nome as imobiliaria'),
                    )
                    ->get();

        return view('payments.create_payment', compact('username', 'imovel'));
    }

    public function savePayment(Request $request) {
        $all = $request->all();
        $imovel = $all['imovel'];
        $data = [];
        foreach($all as $idx => $val) {
            if($idx == 'imovel') {
                continue;
            }
            
            $buff = explode('_', $idx);
            $type = $buff[0];
            $cur_idx = $buff[1];

            if($request->hasFile($idx)) {
                $data[$cur_idx][$type] = $idx;
                continue;
            }
            if(!isset($val) || $val == 'null') {
                $val = null;
            }

            $data[$cur_idx][$type] = $val;
        }

        $imovel_info = Imovel::where('id', $imovel)
                            ->first();
        
        foreach($data as $row) {   
            $pagamentos = new Pagamentos();
            $pagamentos->id_imovel = $imovel;
            $pagamentos->id_proprietario = $imovel_info->id_proprietario;
            $pagamentos->id_inquilino = $imovel_info->id_inquilino;
            $pagamentos->id_imobiliaria = $imovel_info->id_imobiliaria;
            $pagamentos->tipo = $row['type'];
            $pagamentos->valor = $row['value'];
            $pagamentos->data_vencimento = $row['date'];
            $pagamentos->save();
            $id_imovel = $pagamentos->id;

            if($request->hasFile($row['file'])) {
                $file = $request->file($row['file']);
                $id_imovel = $payment_info->id_imovel;
                $date_vencimento = $row['date'];
                $ano = substr($date_vencimento, 0, 4);
                $mes = substr($date_vencimento, 5, 2);

                $filename = $ano.$mes.$id.'c.pdf';

                $dir = explode('/', app_path());
                array_pop($dir);            
                $dir = join('/', $dir);
                $dir .= '/data/intelipag/boletos/id_im_'.$id_imovel;
                
                if(file_exists($dir.'/'.$filename)) {
                    unlink($dir.'/'.$filename);
                }
                $file->move($dir, $filename);
            }  
        }

        return response()->json(true);
    }

    public function deletePayment(Request $request) {
        $id = $request->id;

        $result = Pagamentos::where('id', $id)
            ->delete();

        return response()->json($result);
    }

    public function uploadFile(Request $request) {
        $id = $request->id;        
        
        $result = true;
        if($request->hasFile('file')) {
            $payment_info = Pagamentos::where('id', $id)->first();
            $id_imovel = $payment_info->id_imovel;
            $date_vencimento = $payment_info->date_vencimento;
            $ano = substr($date_vencimento, 0, 4);
            $mes = substr($date_vencimento, 5, 2);

            $filename = $ano.$mes.$id.'c.pdf';

            $dir = explode('/', app_path());
            array_pop($dir);            
            $dir = join('/', $dir);
            $dir .= '/data/intelipag/boletos/id_im_'.$id_imovel;

            $file = $request->file('file');
            
            if(file_exists($dir.'/'.$filename)) {
                unlink($dir.'/'.$filename);
            }

            $file->move($dir, $filename);
        }

        return response()->json($result);
    }

    public function editPayment(Request $request) {
        $id = $request->id;
        $type = $request->type;
        $value = $request->value;
        $date = $request->date;

        $result = Pagamentos::where('id', $id)
                    ->update([
                        'tipo' => $type,
                        'valor' => $value,
                        'data_vencimento' => $date
                    ]);

        return response()->json($result);
    }
}
