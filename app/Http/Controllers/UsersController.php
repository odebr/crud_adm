<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

use App\User;
use App\Models\Inquilino;
use App\Models\Proprietario;
use App\Models\Imobiliaria;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $username = Auth::user()->username;

        return view('users.index', compact('username'));
    }

    public function getUserList(Request $request) {
        $role = $request->role;
        $offset = $request->start;
        $limit = $request->length;
        $search_val = $request['search']['value'];
        $order_col = $request->order[0]['column'];
        $order_dir = $request->order[0]['dir'];

        $data = DB::table('users');
        
        if($role != 0) {
            $data = $data->where('users.role', $role);            
        }

        $order_sql = 'users.id';
        switch($order_col) {
            case 0:
                $order_sql = 'users.username';
                break;
            case 1:
                $order_sql = 'users.role';
                break;
            case 2:
                $order_sql = 'union_qry.nome';
                break;
            case 3:
                $order_sql = 'users.role';
                break;
            case 4:
                $order_sql = 'union_qry.email';
                break;
            case 5:
                $order_sql = 'union_qry.telefone1';
                break;
            case 6:
                $order_sql = 'union_qry.telefone2';
                break;
            case 7:
                $order_sql = 'union_qry.reg';
                break;
            case 8:
                $order_sql = 'union_qry.url';
                break;
            case 9:
                $order_sql = 'union_qry.creci';
                break;
        }

        $union_query = "(SELECT 
                            * 
                        FROM (
                            SELECT 
                                p.*, 
                                '' AS `url`, 
                                '' AS creci, 
                                1 AS `role` 
                            FROM proprietario AS p 
                            UNION 
                            SELECT 
                                i.*, 
                                '' AS `url`, 
                                '' AS creci, 
                                2 AS `role` 
                            FROM inquilino AS i 
                            UNION 
                            SELECT 
                                im.*, 
                                3 AS `role` 
                            FROM imobiliaria AS im 
                        ) AS total ) AS union_qry";

        $data = $data->join(DB::raw($union_query), function($query) {
            $query->on('users.system_id', '=', 'union_qry.id')
                ->on('users.role', '=', 'union_qry.role');
        })
        ->select(
            DB::raw("
                users.id,
                users.username,
                IF(users.role = 1, 'proprietario', IF(users.role = 2, 'inquilino', IF(users.role = 3, 'imobiliaria', ''))) AS tipo_name,
                union_qry.nome,
                users.role,
                union_qry.email,
                union_qry.telefone1,
                union_qry.telefone2,
                union_qry.reg,
                union_qry.url,
                union_qry.creci,
                null as actions
            ")
        );

        $total_cnt = count($data->get());

        if($search_val != null && isset($search_val) && trim($search_val) != '') {
            $data = $data->where('users.id', '=', $search_val)
                        ->orWhere('union_qry.nome', 'like', '%'.$search_val.'%')
                        ->orWhere('users.role', '=', $search_val)
                        ->orWhere('union_qry.email', 'like', '%'.$search_val.'%')
                        ->orWhere('union_qry.telefone1', 'like', '%'.$search_val.'%')
                        ->orWhere('union_qry.telefone2', 'like', '%'.$search_val.'%')
                        ->orWhere('union_qry.reg', 'like', '%'.$search_val.'%')
                        ->orWhere('union_qry.url', 'like', '%'.$search_val.'%')
                        ->orWhere('union_qry.creci', 'like', '%'.$search_val.'%');
        }

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

    public function saveUser(Request $request) {
        $user_id = $request->user_id;
        $role = $request->role;
        $username = $request->username;
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;
        $telefone1 = $request->telefone1;
        $telefone2 = $request->telefone2;
        $reg = $request->reg;
        $url = $request->url;
        $creci = $request->creci;

        $result = true;
        if($user_id == null) {
            $system_id = 0;
            switch ($role) {
                case '1':
                    $detail = new Proprietario();
                    break;
                case '2':
                    $detail = new Inquilino();
                    break;
                case '3':
                    $detail = new Imobiliaria();
                    $detail->url = $url;
                    $detail->creci = $creci;
                    break;
            }
            $detail->nome = $name;
            $detail->email = $email;
            $detail->telefone1 = $telefone1;
            $detail->telefone2 = $telefone2;
            $detail->reg = $reg;
            $detail->save();

            $system_id = $detail->id;

            $user = new User();
            $user->username = $username;
            $user->password = Hash::make($password);            
            $user->role = $role;            
            $user->system_id = $system_id;  
            $result = $user->save();          
        } else {
            $user_info = User::where('id', $user_id)->first();
            $system_id = $user_info->system_id;
            $old_role = $user_info->role;

            if($old_role != $role) {
                switch ($old_role) {
                    case '1':
                        Proprietario::where('id', $system_id)->delete();
                        break;
                    case '2':
                        Inquilino::where('id', $system_id)->delete();
                        break;
                    case '3':
                        Imobiliaria::where('id', $system_id)->delete();
                        break;
                }
            }

            switch ($role) {
                case '1':  
                    if($role != $old_role) {
                        $proprietario = new Proprietario();
                        $proprietario->nome = $name;
                        $proprietario->email = $email;
                        $proprietario->telefone1 = $telefone1;
                        $proprietario->telefone2 = $telefone2;
                        $proprietario->reg = $reg;
                        $result = $proprietario->save();
                        $system_id = $proprietario->id;
                    } else {
                        $result = Proprietario::where('id', $system_id)
                            ->update([
                                'nome' => $name,
                                'email' => $email,
                                'telefone1' => $telefone1,
                                'telefone2' => $telefone2,
                                'reg' => $reg
                            ]);
                    }
                    break;
                case '2':
                    if($role != $old_role) {
                        $inquilino = new Inquilino();
                        $inquilino->nome = $name;
                        $inquilino->email = $email;
                        $inquilino->telefone1 = $telefone1;
                        $inquilino->telefone2 = $telefone2;
                        $inquilino->reg = $reg;
                        $result = $inquilino->save();
                        $system_id = $inquilino->id;
                    } else {
                        $result = Inquilino::where('id', $system_id)
                            ->update([
                                'nome' => $name,
                                'email' => $email,
                                'telefone1' => $telefone1,
                                'telefone2' => $telefone2,
                                'reg' => $reg
                            ]);
                    }
                    break;
                case '3':
                    if($role != $old_role) {
                        $imobiliaria = new Imobiliaria();
                        $imobiliaria->nome = $name;
                        $imobiliaria->email = $email;
                        $imobiliaria->telefone1 = $telefone1;
                        $imobiliaria->telefone2 = $telefone2;
                        $imobiliaria->reg = $reg;
                        $imobiliaria->url = $url;
                        $imobiliaria->creci = $creci;
                        $result = $imobiliaria->save();
                        $system_id = $imobiliaria->id;
                    } else {
                        $result = Imobiliaria::where('id', $system_id)
                            ->update([
                                'nome' => $name,
                                'email' => $email,
                                'telefone1' => $telefone1,
                                'telefone2' => $telefone2,
                                'reg' => $reg,
                                'url' => $url,
                                'creci' => $creci
                            ]);
                    }
                    break;
            }

            $update_arr = [
                'username' => $username,
                'role' => $role,
                'system_id' => $system_id
            ];
            if($password != '') {
                $update_arr['password'] = Hash::make($password);
            }

            User::where('id', $user_id)
                    ->update($update_arr);
        }

        return response()->json($result);
    }

    public function deleteUser(Request $request) {
        $id = $request->id;

        $user_info = User::where('id', $id)->first();
        User::where('id', $id)->delete();
        switch ($user_info->role) {
            case '1':
                $result = Proprietario::where('id', $user_info->system_id)->delete();
                break;
            case '2':
                $result = Inquilino::where('id', $user_info->system_id)->delete();
                break;
            case '3':
                $result = Imobiliaria::where('id', $user_info->system_id)->delete();
                break;
            default:
                $result = true;
                break;
        }

        return response()->json($result);
    }
}
