<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use App\Client;

class ClientController extends Controller
{
    public function get()
    {
        return Datatables::of(Client::withTrashed())
            ->addcolumn('estado', function ($client) {
                return ($client->deleted_at === null) ? 'Activo' : 'Inactivo';
            })
            ->make(true);
    }

    public function getClient(Client $client)
    {        
        return response()->json($client, 200);        
    }

    public function store(ClientStoreRequest $request)
    {
        $client = new Client;
        $client->nit = $request->nit;
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->save();

        return response()->json([
            'title' => 'Registro Exitoso',
            'message' => 'Cliente registrado correctamente!'
        ], 200);
    }

    public function update(ClientStoreRequest $request, Client $client)
    {
        $client->nit = $request->nit;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->save();

        return response()->json([
            'title' => 'Cliente Actualizado',
            'message' => 'El cliente ha sido Actualizado Correctamente!'
        ], 200);
        
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'title' => 'Desactivación Exitosa',
            'message' => 'Registro de Cliente Desactivado Correctamente.'
        ], 200);
    }

    public function restore($id)
    {
        $client = Client::where('id', $id)->withTrashed()->first();
        $client->restore();

        return response()->json([
            'title' => 'Restauraciòn Exitosa',
            'message' => 'Registro de Cliente Restaurado Correctamente!'
        ], 200);
    }
}
