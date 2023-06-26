<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\storage;
class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listados['registro'] = Registro::paginate(5);
        return view('registro.index', $listados);



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('registro.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Registro
        $moliRegistro = request()->except('_token');
       
        if($request->hasfile('foto')){
            $moliRegistro['foto']=$request->file('foto')->store('uploads','public');
        }
        registro::insert($moliRegistro);
        return redirect('registro')->with('mensaje','registro ingresado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(registro $registro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $registro = Registro::findOrfail($id);
        return view('registro.update', compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $moli = request()->except(['_token','_method']);
        if($request->hasfile('foto')){
            $moli['foto'] =$request->file('foto')->store('uploads','public');
            
        }
        registro::where('id','=',$id)->update($moli);
        $registro = Registro::findOrfail($id);
        return view('registro.update', compact('registro'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)

    {
        //
        registro::destroy($id);
        if(storage::delete('public/'.$registro->foto)){
            registro::destroy($id);

        }
        return redirect('registro');
    }
}
