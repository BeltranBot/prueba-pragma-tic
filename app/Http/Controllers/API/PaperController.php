<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Paper\StorePaperRequest;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use App\Paper;

class PaperController extends Controller
{
    public function get()
    {
        return Datatables::of(Paper::withTrashed())
            ->addcolumn('estado', function ($paper) {
                return ($paper->deleted_at === null) ? 'Activo' : 'Inactivo';
            })
            ->make(true);
    }

    public function getPaper(Paper $paper)
    {        
        return response()->json($paper, 200);
    }

    public function store(StorePaperRequest $request)
    {
        $paper = new Paper;
        $paper->name = $request->name;
        $paper->save();

        return response()->json([
            'title' => 'Registro Exitoso',
            'message' => 'Tipo de Papel registrado correctamente!'
        ], 200);
    }

    public function update(StorePaperRequest $request, Paper $paper)
    {
        $paper->name = $request->name;
        $paper->save();

        return response()->json([
            'title' => 'Registro Actualizado',
            'message' => 'El Tipo de Papel ha sido Actualizado Correctamente!'
        ], 200);
        
    }

    public function destroy(Paper $paper)
    {
        $paper->delete();

        return response()->json([
            'title' => 'Registro Desactivado',
            'message' => 'Registro del Tipo de Papel Desactivado Correctamente.'
        ], 200);
    }

    public function restore($id)
    {
        $paper = Paper::where('id', $id)->withTrashed()->first();
        $paper->restore();

        return response()->json([
            'title' => 'Restauración Exitosa',
            'message' => 'Registro del Tipo de Papel Restaurado Correctamente!'
        ], 200);
    }
}
