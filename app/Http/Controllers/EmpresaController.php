<?php


namespace App\Http\Controllers;


use App\Models\WPCliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;



class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @OA\Post(
     * path="/api/saveEmpresa",
     * summary="Guardar Empresa",
     * description="Guardar Empresa en la db",
     * operationId="saveEmpresa",
     * tags={"Empresas"},
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
    public function saveEmpresa($empresaReq){
          $cliente = new Cliente;
          $cliente->estado = $empresaReq->estado;
          $user = new User;
          $user->name = $empresaReq->name;
          $user->email = $empresaReq->email;
          $user->save();
          $cliente->user = $user;
          $cliente->save();
    }

    /**
     * @OA\Post(
     * path="/api/updateEmpresas",
     * summary="Actualizar Empresas",
     * description="Actualizar empresa en la db",
     * operationId="updateEmpresa",
     * tags={"Empresas"},
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
    public function updateEmpresa($clienteReq){
        $cliente = new Cliente;
        $cliente->estado = $clienteReq->estado;
        $user = new User;
        $user->name = $clienteReq->name;
        $user->email = $clienteReq->email;
        $user->save();
        $cliente->user = $user;
        $cliente->save();
    }

    /**
     * @OA\Post(
     * path="/api/removerEmpresa",
     * summary="Eliminar Empresa",
     * description="Eliminar Empresa en la db",
     * operationId="removeEmpresa",
     * tags={"Empresas"},
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
    public function removeEmpresa($clienteReq){
        $cliente = new Cliente;
        $cliente->estado = $clienteReq->estado;
        $user = new User;
        $user->name = $clienteReq->name;
        $user->email = $clienteReq->email;
        $user->save();
        $cliente->user = $user;
        $cliente->save();
    }

    /**
     * @OA\Get(
     * path="/api/empresas",
     * summary="Get Empresas",
     * description="Obtiene todas las empresas",
     * operationId="getEmpresas",
     * tags={"Empresas"},
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
     *             @OA\Property(property="razonSocial", type="string", example="Dimension Comercial S.A"),
     *             @OA\Property(property="cliente a Cargo", type="string", example="Luis Ventocilla"),
     *             @OA\Property(property="created", type="string", example="2020-09-17 03:21:05"),
     *          ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function getEmpresas(){
        $today = Carbon::today()->toDayDateTimeString();
        Log::debug('today => '.$today);
        $empresas = Empresas::where('empresas')->get();
        return response()->json($empresas);
    }

}
