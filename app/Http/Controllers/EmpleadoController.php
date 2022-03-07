<?php


namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;

class EmpleadoController extends Controller
{   
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::orderBy('id','Desc')->paginate(3);
        return view('Empleado.index',compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados=$this->wsObtenerEstado();
        $monedas=$this->wsObtenerMoneda();
        return view('Empleado.create',compact('estados','monedas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($this->validate($request,['nombre'=>'required','puesto'=>'required','edad'=>'required', 'estado_residencia'=>'required','sueldo'=>'required', 'tipo_moneda'=>'required'])){
            Empleado::create(
                ['nombre' => $request->get('nombre'),
                'edad' => $request->get('edad'),
                'puesto' => $request->get('puesto'),
                'activo' => $request->has('activo')? $request->get('activo'):0,
                'estado_residencia' => $request->get('estado_residencia'),
                'sueldo' => $request->get('sueldo'),
                'tipo_moneda' => $request->get('tipo_moneda')]
            );
        return redirect()->route('empleado.index') -> with ('success','Registro creado correctamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $empleados = Empleado::find($id);
        return view('empleado.show',compact('empleados'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $estados=$this->wsObtenerEstado();
        $monedas=$this->wsObtenerMoneda();
        $empleado = Empleado::find($id);
        return view('empleado.edit',compact('empleado','estados','monedas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[ 'nombre'=>'required', 'puesto'=>'required', 'edad'=>'required', 'estado_residencia'=>'required','sueldo'=>'required', 'tipo_moneda'=>'required']);

        Empleado::find($id)->update(['nombre' => $request->get('nombre'),
            'edad' => $request->get('edad'),
            'puesto' => $request->get('puesto'),
            'estado_residencia' => $request->get('estado_residencia'),
            'sueldo' => $request->get('sueldo'),
            'tipo_moneda' => $request->get('tipo_moneda'),
            'activo' => $request->has('activo')? $request->get('activo'):0]);
        return redirect()->route('empleado.index')->with('success','Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Empleado::find($id)->delete();
        return redirect()->route('empleado.index')->with('success','Registro eliminado correctamente');
    }

    /**
     * Api de Estados.
    */
    private function wsObtenerEstado(){
        $client = new HttpClient([
            'base_uri' => 'https://beta-bitoo-back.azurewebsites.net/api/'
        ]);
        $response = $client->request('POST',"proveedor/obtener/lista_estados");
         
        return (((array)json_decode($response->getBody())->data)['lst_estado_proveedor']);
    }
    /**
     * Api de Moneda.
    */
    private function wsObtenerMoneda(){
        $client = new HttpClient([
            'base_uri' => 'https://fx.currencysystem.com/webservices/CurrencyServer5.asmx/'
        ]);
        $client = new HttpClient(); 
        $result = $client->post('https://fx.currencysystem.com/webservices/CurrencyServer5.asmx/AllCurrencies', [
            'form_params' => [
                'licenseKey' => ''
            ]
        ]);
        return explode(';',xmlrpc_decode($result->getBody()->getContents()) );
    }

    
}

