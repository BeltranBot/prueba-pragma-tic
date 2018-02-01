<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Operator\StoreOperatorRequest;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use App\Operator;

class OperatorController extends Controller
{
    public function get()
    {
        return Datatables::of(Operator::withTrashed())
            ->addcolumn('estado', function ($operator) {
                return ($operator->deleted_at === null) ? 'Activo' : 'Inactivo';
            })
            ->make(true);
    }

    public function getOperator(Operator $operator)
    {        
        return response()->json($operator, 200);
    }

    public function store(StoreOperatorRequest $request)
    {
        $operator = new Operator;
        $operator->name = $request->name;
        $operator->hour_cost = $request->hour_cost;
        $operator->save();

        return response()->json([
            'title' => 'Registro Exitoso',
            'message' => 'Operador registrado correctamente!'
        ], 200);
    }

    public function update(StoreOperatorRequest $request, Operator $operator)
    {
        $operator->name = $request->name;
        $operator->hour_cost = $request->hour_cost;
        $operator->save();

        return response()->json([
            'title' => 'Registro Actualizado',
            'message' => 'El Operador ha sido Actualizado Correctamente!'
        ], 200);
        
    }

    public function destroy(Operator $operator)
    {
        $operator->delete();

        return response()->json([
            'title' => 'Registro Desactivado',
            'message' => 'Registro del Operador Desactivado Correctamente.'
        ], 200);
    }

    public function restore($id)
    {
        $operator = Operator::where('id', $id)->withTrashed()->first();
        $operator->restore();

        return response()->json([
            'title' => 'Restauración Exitosa',
            'message' => 'Registro del Operador Restaurado Correctamente!'
        ], 200);
    }
}
