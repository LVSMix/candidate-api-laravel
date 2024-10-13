<?php


namespace App\Http\Controllers;


use App\Models\Concepto;
use App\Models\Cliente;
use App\Models\WPCliente;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Mail\Cotizacion;


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @OA\Get(
     * path="/api/clientesIngresados",
     * summary="Get Clientes Ingresados",
     * description="Obtiene todos los clientes migrados",
     * operationId="getClientes",
     * tags={"Clientes"},
     *   @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Internal Server Error")
     *     ),
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *          @OA\Items(
     *             @OA\Property(property="nombre", type="string", example="Luis Ventocilla"),
     *             @OA\Property(property="email", type="string", example="lvsmix@gmail.com"),
     *             @OA\Property(property="estado", type="string", example="INGRESADO"),
     *             @OA\Property(property="created", type="string", example="2020-09-17 03:21:05"),
     *          ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function getClientesIngresados(){
        $today = Carbon::today()->toDayDateTimeString();
        Log::debug('today => '.$today);
        $clientes = Cliente::whereIn('estado',[Cliente::ESTADO_INGRESADO,Cliente::ESTADO_COTIZADO])->get();
        return response()->json($clientes);
    }


    /**
     * @OA\Get(
     * path="/api/wp_clientes",
     * summary="Get Clientes From Contact Form",
     * description="Obtiene todos los clientes del contact form",
     * operationId="getWPClientes",
     * tags={"Clientes"},
     *   @OA\Response(
     *    response=401,
     *    description="Wrong credentials response",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="No Autorizado")
     *     ),
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *          @OA\Items(
     *             @OA\Property(property="nombre", type="string", example="Luis Ventocilla"),
     *             @OA\Property(property="email", type="string", example="lvsmix@gmail.com"),
     *             @OA\Property(property="topic", type="string", example="Consulta"),
     *             @OA\Property(property="message", type="string", example="Prueba"),
     *             @OA\Property(property="created", type="string", example="2020-09-17 03:21:05"),
     *          ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function getWPClientes(){

        $today = Carbon::today()->toDayDateTimeString();
        Log::debug('today => '.$today);
        $wp_clientes = WPCliente::all();
        $clientes = array();

        foreach ($wp_clientes as $client)
            array_push($clientes,unserialize($client->form_value));

        foreach ($clientes as $index=>$client){
            $clientes[$index]['estado'] = Cliente::ESTADO_INGRESADO;
            $clientes[$index]['created'] = $wp_clientes[$index]->form_date;
        }

        return response()->json($clientes);
    }

    /**
     * @OA\Post(
     * path="/api/migrarclientes",
     * summary="Migrar Clientes",
     * description="Migrar todos los clientes obtenidos desde el contact form",
     * operationId="migrarClientes",
     * tags={"Clientes"},
     *   @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Internal Server Error")
     *     ),
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Process Succesfull"),
     *     ),
     *   ),
     * ),
     */
    public function migrarClientes(){
        $referenceFieldToCheck = "email";
        $clientesEnDB = Cliente::all()->pluck($referenceFieldToCheck)->toArray();
        $clientesWP   = $this->getWPClientes()->getData();
        $flag         = false;

        foreach ($clientesWP as $wpClient)
            if(!in_array($wpClient->$referenceFieldToCheck,$clientesEnDB)) {
                $cliente            = new Cliente;
                $cliente->estado    = $wpClient->estado;
                $cliente->user_id   = 0;
                $cliente->nombre    = $wpClient->name;
                $cliente->email     = $wpClient->email;
                $cliente->topic     = $wpClient->topic;
                $cliente->mensaje   = $wpClient->message;
                $cliente->conceptos = "pending to do";
                $cliente->save();
                $flag = true;
            }
        $this->jsonMessage('newClients',$flag);
    }


    public function enviarCotizacion($id){
        $cliente = Cliente::where('id',$id)->first();
        if($cliente){
            \Mail::to($cliente->email)->send(New Cotizacion($cliente));
            Log::debug('Enviando mail de cotizacion a '.$cliente->email);
            $cliente->estado = Cliente::ESTADO_COTIZADO;
            $cliente->save();
            $this->jsonMessage("sended",true);
        }else{
            $this->jsonMessage("sended",false);
        }

    }

    public function getConceptos(){
        $conceptos = Concepto::all();
        return response()->json($conceptos);
    }

    public function jsonMessage($key,$value){
        $message = [$key=>$value];
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($message);
        exit();
    }
}
