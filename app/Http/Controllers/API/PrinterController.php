<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Printer\PrinterStoreRequest;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use App\Printer;

class PrinterController extends Controller
{
    public function get()
    {
        return Datatables::of(Printer::withTrashed())
            ->addcolumn('estado', function ($printer) {
                return ($printer->deleted_at === null) ? 'Activa' : 'Inactiva';
            })
            ->make(true);
    }

    public function getPrinter(Printer $printer)
    {        
        return response()->json($printer, 200);
    }

    public function store(PrinterStoreRequest $request)
    {
        $printer = new Printer;
        $printer->model = $request->model;
        $printer->prep_time = $request->prep_time;
        $printer->max_width = $request->max_width;
        $printer->printing_speed = $request->printing_speed;
        $printer->save();

        return response()->json([
            'title' => 'Registro Exitoso',
            'message' => 'Impresora registrada correctamente!'
        ], 200);
    }

    public function update(PrinterStoreRequest $request, Printer $printer)
    {
        $printer->model = $request->model;
        $printer->prep_time = $request->prep_time;
        $printer->max_width = $request->max_width;
        $printer->printing_speed = $request->printing_speed;
        $printer->save();

        return response()->json([
            'title' => 'Registro Actualizado',
            'message' => 'La Impresora ha sido Actualizada Correctamente!'
        ], 200);
        
    }

    public function destroy(Printer $printer)
    {
        $printer->delete();

        return response()->json([
            'title' => 'Registro Desactivado',
            'message' => 'Registro de Impresora Desactivado Correctamente.'
        ], 200);
    }

    public function restore($id)
    {
        $printer = Printer::where('id', $id)->withTrashed()->first();
        $printer->restore();

        return response()->json([
            'title' => 'Restauración Exitosa',
            'message' => 'Registro de Impresora Restaurado Correctamente!'
        ], 200);
    }
}
