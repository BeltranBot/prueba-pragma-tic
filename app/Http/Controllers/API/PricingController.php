<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Pricing\StorePricingRequest;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use App\Pricing;
use App\Printer;
use App\Operator;
use App\Client;
use App\Paper;
use App\PricingTagQuantity;
use DB;

class PricingController extends Controller
{
    public function get()
    {
        $pricings = Pricing::select([
            'pricings.id as id',
            'printing_types.name as pricing_type_name',
            DB::raw('concat(clients.nit, " ", clients.name) as client_name'),
            'printers.model as printer_model',
            'operators.name as operator_name',
            'operators.hour_cost as operator_hour_cost',
            'papers.name as paper_name',
            'pricings.paper_cost as pricing_paper_cost',
            'pricings.tag_width as pricing_tag_width',
            'pricings.tag_height as pricing_tag_height',
            'pricings.printing_time as pricing_printing_time'  
        ])
        ->join('printing_types', 'printing_types.id', '=', 'pricings.printing_type_id')
        ->join('clients', 'clients.id', '=', 'pricings.client_id')
        ->join('printers', 'printers.id', '=', 'pricings.printer_id')
        ->join('operators', 'operators.id', '=', 'pricings.operator_id')
        ->join('papers', 'papers.id', '=', 'pricings.paper_id');
        
        return Datatables::of($pricings)
            ->addcolumn('quantities', function ($pricing) {
                $output = '';
                foreach ($pricing->pricing_tag_quantities as $quantity) {
                    $output .= $quantity->quantity . ', ';
                }                
                return substr($output, 0, -2);
            })
            ->addcolumn('estado', function ($pricing) {
                return ($pricing->deleted_at === null) ? 'Activo' : 'Inactivo';
            })
            ->make(true);
    }

    public function getPricing(Pricing $pricing)
    {        
        return response()->json($pricing, 200);
    }

    public function store(StorePricingRequest $request)
    {
        $pricing = new Pricing;
        $pricing->printing_type_id = $request->printing_type_id;
        $pricing->client_id = $request->client_id;
        $pricing->printer_id = $request->printer_id;
        $pricing->operator_id = $request->operator_id;
        $pricing->paper_id = $request->paper_id;
        
        $pricing->tag_width = $request->tag_width;
        $pricing->tag_height = $request->tag_height;
        $pricing->tag_area = ($request->tag_width * 0.0393701) * ($request->tag_height * 0.0393701);
        
        $pricing->paper_cost = $request->paper_cost;

        $pricing->operator_id = $request->operator_id;
        $operator = Operator::find($request->operator_id);
        $pricing->operator_cost = $operator->hour_cost;

        $pricing->printing_time = $request->printing_time;

        $printer = Printer::find($request->printer_id);
        if ($request->printing_type_id > 1) {
            $pricing->prep_time = $printer->prep_time;

            if ($request->printing_type_id == 2) {
                $pricing->wasted_paper = $operator->wasted_paper;                
                $pricing->inks_number = $operator->inks_number;
            }
        }
        $pricing->utility = $request->utility;

        $pricing->save();

        if (!is_array($request->quantities)){
            $quantities = [$request->quantities];
        } else {
            $quantities = $request->quantities;
        }

        foreach ($quantities as $quantity) {
            $pricing_tag_quantity = new PricingTagQuantity;
            $pricing_tag_quantity->pricing_id = $pricing->id;
            $pricing_tag_quantity->quantity = $quantity;

            if ($pricing->printing_type_id == 1) {
                $subtotal = ($pricing->tag_area * $quantity * $pricing->paper_cost) +
                    ($pricing->printing_time * $pricing->operator_cost);

            } else if ($pricing->printing_type_id == 2) {
                $subtotal = (($pricing->tag_area + ($pricing->tag_area * $pricing->wasted_paper)) *
                    $quantity * $pricing->paper_cost) + (($pricing->prep_time * $pricing->inks_number) *
                    $pricing->operator_cost) + ($pricing->printing_time * $pricing->operator_cost);

            } else if ($pricing->printing_type_id == 3) {
                $subtotal = ($pricing->tag_area * $quantity * $pricing->paper_cost) +
                    ($pricing->prep_time * $pricing->operator_cost) + ($pricing->printing_time *
                    $pricing->operator_cost);
            }

            info('test', [
                'type' => $pricing->printing_type_id]);

            info('subtotal', [
                'subtotal' => $subtotal]);


            $pricing_tag_quantity->subtotal = $subtotal;
            $pricing_tag_quantity->total = $subtotal * (1 * $pricing->utility);
            $pricing_tag_quantity->save();
        }

        return response()->json([
            'title' => 'Registro Exitoso',
            'message' => 'Cotización registrada correctamente!'
        ], 200);
    }

    public function update(StorePricingRequest $request, Pricing $pricing)
    {
        $pricing->name = $request->name;
        $pricing->hour_cost = $request->hour_cost;
        $pricing->save();

        return response()->json([
            'title' => 'Registro Actualizado',
            'message' => 'La Cotización ha sido Actualizado Correctamente!'
        ], 200);
        
    }

    public function destroy(Pricing $pricing)
    {
        $pricing->delete();

        return response()->json([
            'title' => 'Registro Desactivado',
            'message' => 'Registro de la Cotización Desactivado Correctamente.'
        ], 200);
    }

    public function restore($id)
    {
        $pricing = Pricing::where('id', $id)->withTrashed()->first();
        $pricing->restore();

        return response()->json([
            'title' => 'Restauración Exitosa',
            'message' => 'Registro la Cotizacion Restaurado Correctamente!'
        ], 200);
    }
}
