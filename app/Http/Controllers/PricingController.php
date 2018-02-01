<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PrintingType;
use App\Client;
use App\Printer;
use App\Operator;
use App\Paper;
use App\Pricing;

class PricingController extends Controller
{
    public function index()
    {
        $printing_types = PrintingType::all();
        $clients = Client::all();
        $printers = Printer::all();
        $operators = Operator::all();
        $papers = Paper::all();

        return view('pricings.index', compact(
            'printing_types', 'clients', 'printers',
            'operators', 'papers'
        ));
    }

    public function show(Pricing $pricing)
    {
        return view('pricings.show', compact('pricing'));
    }
}
