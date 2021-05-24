<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="dvicentevila@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="Ven a Verme",
 *     description="API Endpoints of Ven A Verme"
 * )
 */

 /**
 * @OA\Get(
 *      path="prueba",
 *      operationId="prueba",
 *      tags={"prueba"},
 *      summary="Get prueba",
 *      description="Get prueba",
 *      @OA\Parameter(
 *          name="api_token",
 *          description="API TOKEN Authentication",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          
 *       ),
 *     )
 */

class DevApisController extends Controller
{
    public function getProvMunsBasic(){
        return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio', 'poblacion', 'imagenMunicipio')->get(), JsonResponse::HTTP_OK);
    }
    public function getProvMunsUltraBasic(){
        return response()->json(Place::select('provincia', 'municipio')->get(), JsonResponse::HTTP_OK);
    }
    public function getMunicipiosBasic(){
        return response()->json(Place::select('municipio', 'codigoMunicipio', 'poblacion', 'imagenMunicipio', 'cLatitud', 'cLongitud')->get(), JsonResponse::HTTP_OK);
    }
    public function getProvinciasBasic(){
        return response()->json(Place::select('provincia', 'codigoProvincia')->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsFromProvAll($provincia){
        return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio', 'poblacion', 'imagenMunicipio', 'cLatitud', 'cLongitud')->
        where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsPoblacionBasedOrdered($poblacion){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('poblacion', '<=', $poblacion)->orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsFromProvPoblacionBasedOrdered($provincia, $poblacion){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('provincia', $provincia)->where('poblacion', '<=', $poblacion)->
        orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsEV(){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('despoblacion', 1)->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsFromProvEV($provincia){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('provincia', $provincia)->where('despoblacion', 1)->get(), JsonResponse::HTTP_OK);
    }
    public function getMunsFromProvEVOrdered($provincia){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion','codigoProvincia', 'codigoMunicipio','imagenMunicipio', 'cLatitud', 'cLongitud')->
        where('provincia', $provincia)->where('despoblacion', 1)->
        orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
    }
    public function getCodesFromMun($provincia){
        return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio')->where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
    }
    public function getCoordinatesFromMun($provincia){
        return response()->json(Place::select('provincia', 'municipio', 'cLatitud', 'cLongitud')->where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
    }
}
