<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AgenceController extends Controller {
    public function index() {
        $doctors = DB::select('select u.co_usuario,no_usuario,dt_nascimento from cao_usuario u, permissao_sistema p where u.co_usuario=p.co_usuario and p.co_sistema=1 and p.in_ativo="S" and p.co_tipo_usuario in (0,1,2) order by no_usuario');
        return view('index', compact(['doctors']));
    }

    public function relatorio(Request $request) {
        $request->validate([
            'users' => 'array|required',
            'startdate' => 'required|date_format:Y-m',
            'enddate' => 'required|date_format:Y-m',
        ]);
        $users = str_replace(['[', ']'], '', json_encode($request->users));
        $relatorio = DB::select("select co_usuario,period,round(recliq,2) recliq,bruto,round(comision,2) comision,round(round(recliq,2)-(bruto+round(comision,2)),2) beneficio from v_relatorio where (period BETWEEN ? and ?) and co_usuario in ($users)", [$request->startdate, $request->enddate]);
        $result['rows'] = [];
        foreach ($relatorio as $rel) {
            $result['rows'][$rel->co_usuario][] = $rel;
        }
        foreach ($result['rows'] as $key => $value) {
            $initial = ['liq' => 0.0, 'costo' => 0.0, 'com' => 0.0, 'lucro' => 0.0];
            $sum = array_reduce($value, function ($res, $row) {
                $res['liq'] += $row->recliq;
                $res['costo'] += $row->bruto;
                $res['com'] += $row->comision;
                $res['lucro'] += $row->beneficio;
                return $res;
            }, $initial);
            $result['totals'][$key] = $sum;
        }
        return $result;
    }

    public function pizza(Request $request) {
        $request->validate([
            'users' => 'array|required',
            'startdate' => 'required|date_format:Y-m',
            'enddate' => 'required|date_format:Y-m',
        ]);
        $users = str_replace(['[', ']'], '', json_encode($request->users));
        $pizza = DB::select("select (select no_usuario from cao_usuario where co_usuario=p.co_usuario) name,sum(recliq) y from v_pizza p where (period BETWEEN ? and ?) and co_usuario in ($users) group by co_usuario", [$request->startdate, $request->enddate]);
        return $pizza;
    }

    public function grafico(Request $request) {
        $request->validate([
            'users' => 'array|required',
            'startdate' => 'required|date_format:Y-m',
            'enddate' => 'required|date_format:Y-m',
        ]);
        $users = str_replace(['[', ']'], '', json_encode($request->users));
        $grafico = DB::select("select (select no_usuario from cao_usuario where co_usuario=p.co_usuario) name,recliq,period from v_pizza p where (period BETWEEN ? and ?) and co_usuario in ($users)", [$request->startdate, $request->enddate]);
        $result = [];
        $name = '';
        $idx = -1;
        foreach ($grafico as $g) {
            if ($g->name !== $name) {
                $name = $g->name;
                $result[++$idx] = ['type' => 'column', 'name' => $name, 'data' => array_fill(0, 12, 0.0)];
            }
            $month = (int)substr($g->period, 5);
            $result[$idx]['data'][$month - 1] += $g->recliq;
        }
        $promedio = DB::selectOne("select round(IFNULL(AVG(brut_salario),0),2) avg from cao_salario where co_usuario in ($users)");
        $result[++$idx] = ['type' => 'spline', 'name' => 'Custo Fixo Médio', 'data' => array_fill(0, 12, $promedio->avg * 1.0)];
        return $result;
    }
}
