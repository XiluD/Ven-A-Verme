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
 *      path="/api/provsMunsBasic",
 *      operationId="getProvMunsBasicData",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get provincia and municipio basic data",
 *      description="Get provincia and municipio basic data 
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/provsMunsUltraBasic",
 *      operationId="getProvMunsUltraBasicData",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get provincia and municipio ultra basic data",
 *      description="Get provincia and municipio ultra basic data (provincias and municipios)
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *     )
 **/

/**
 * @OA\Get(
 *      path="/api/munsBasic",
 *      operationId="getMunicipiosBasic",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get municipios basic data",
 *      description="Get municipios basic data
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/provsBasic",
 *      operationId="getProvinciasBasic",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get provincias basic data",
 *      description="Get provincias basic data",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munsOf/{provincia}",
 *      operationId="getMunsFromProv",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get 'Municipios' basic data from a given 'Provincia'",
 *      description="Get 'Municipios' basic data from a given 'Provincia'
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munBasicOf/{municipio}",
 *      operationId="getMunData",
 *      tags={"Provincia Municipio Basic"},
 *      summary="Get 'Municipio' basic data from a given 'Municipio'",
 *      description="Get 'Municipio' basic data from a given 'Municipio'",
 *      @OA\Parameter(
 *          name="municipio",
 *          description="Nombre del municipio",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

/**
 * @OA\Get(
 *      path="/api/munsPoblationOrdered/{poblacion}",
 *      operationId="getMunsPoblacionBasedOrdered",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Municipios' ordered by given 'Population'",
 *      description="Get 'Municipios' ordered by given 'Population'
 *      WARNING! Large body response, so it could take a while depending of the number supplied. Instead is recommended to see the API endpoint directly on the URL.",  
 *      @OA\Parameter(
 *          name="poblacion",
 *          description="Numero de habitantes maximos",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request. Invalid format.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munsOfPoblationOrdered/{provincia}/{poblacion}",
 *      operationId="getMunsFromProvPoblacionBasedOrdered",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Municipios' from given 'PROVINCIA' ordered by given 'Population' with optional consider of 'España Vacia'",
 *      description="Get 'Municipios' from given 'PROVINCIA' ordered by given 'Population'
 *      WARNING! Large body response depending of the parameters entered, so please note that it may take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),        
 *      @OA\Parameter(
 *          name="poblacion",
 *          description="Numero de habitantes maximos",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="ev",
 *          description="Optional parameter to consider also based on the base parameters, show only the places considered from 'España Vacia' or not ",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="boolean"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request. Invalid format.",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munsEv",
 *      operationId="getMunsEv",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Municipios' considered from 'España Vacia'",
 *      description="Get 'Municipios' considered from 'España Vacia'
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munsEvOf/{provincia}",
 *      operationId="getMunsFromProvEV",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Municipios' from a given 'Provincia' considered from 'España Vacia'",
 *      description="Get 'Municipios' from a given 'Provincia' considered from 'España Vacia'",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/munsEvOrderedOf/{provincia}",
 *      operationId="getMunsFromProvEVOrdered",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Municipios' from a given 'Provincia' considered from 'España Vacia' ordered by 'Poblacion'",
 *      description="Get 'Municipios' from a given 'Provincia' considered from 'España Vacia' ordered by 'Poblacion'
 *      WARNING! Large body response, so it could take a while. Instead is recommended to see the API endpoint directly on the URL.",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/provMunCodesOf/{provincia}",
 *      operationId="getCodesFromMun",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Provincia' and 'Municipios' 'Codes' from given 'Provincia'",
 *      description="Get 'Provincia' and 'Municipios' 'Codes' from given 'Provincia'",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

 /**
 * @OA\Get(
 *      path="/api/provMunCoordinatesOf/{provincia}",
 *      operationId="getCoordinatesFromMun",
 *      tags={"Provincia Municipio Advance"},
 *      summary="Get 'Provincia' and 'Municipios' 'Coordinates' from given 'Provincia'",
 *      description="Get 'Provincia' and 'Municipios' 'Coordinates' from given 'Provincia'",
 *      @OA\Parameter(
 *          name="provincia",
 *          description="Nombre de la provincia",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *      @OA\Response(
 *          response=406,
 *          description="No information was found with those names.",
 *      ),
 *     )
 **/

class DevApisController extends Controller
{
    //Return Place basic data
    public function getProvMunsBasic(){
        return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio', 'poblacion', 'imagenMunicipio', 'despoblacion')->get(), JsonResponse::HTTP_OK);
    }

    //Return Place ultra basic data (provincias and municipios of database)
    public function getProvMunsUltraBasic(){
        return response()->json(Place::select('provincia', 'municipio')->get(), JsonResponse::HTTP_OK);
    }

    //Return Place "MUNCIPIOS" basic data
    public function getMunicipiosBasic(){
        return response()->json(Place::select('municipio', 'codigoMunicipio', 'poblacion', 'imagenMunicipio', 'cLatitud', 'cLongitud')->get(), JsonResponse::HTTP_OK);
    }

    //Return Place "PROVINCIAS" basic data
    public function getProvinciasBasic(){
        return response()->json(Place::select('provincia', 'codigoProvincia')->distinct()->get(), JsonResponse::HTTP_OK);
    }

    //Return "MUNICIPIOS" from a given "PROVINCIA"
    public function getMunsFromProvAll($provincia){
        if(Place::where('provincia', $provincia)->first()){
            return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio', 'poblacion', 'imagenMunicipio', 'cLatitud', 'cLongitud')->
            where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
    }

    //Return 'MUNICIPIO' basic data from a given 'MUNICIPIO'
    public function getMunData($municipio){
        if(Place::where('municipio', $municipio)->first()){
            return response()->json(Place::where('municipio', $municipio)->first(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'municipio' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
    }

    //Return "MUNICIPIOS" ordered by given population
    public function getMunsPoblacionBasedOrdered($poblacion){
        if ($poblacion > 0){
            return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('poblacion', '<=', $poblacion)->orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>'Invalid number supplied'], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    //Return "MUNICIPIOS" from given 'PROVINCIA' ordered by given population
    /*
        If "España Vaciada" query, then it will return also the "MUNICIPIOS" considered from "España Vaciada" if query 'ev' == 1, or not
        considered from "España Vaciada" if 'ev' query == 0.
    */
    public function getMunsFromProvPoblacionBasedOrdered(Request $request, $provincia, $poblacion){
        if ((Place::where('provincia', $provincia)->first()) && ($poblacion > 0)){
            if ($request->query('ev')){
                if ($request->query('ev') == "true"){
                    return response()->json(Place::select('provincia', 'municipio', 'poblacion', 'imagenMunicipio')->where('provincia', $provincia)->where('poblacion', '<=', $poblacion)->
                    where('despoblacion', 1)->orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
                }
                else{
                    return response()->json(Place::select('provincia', 'municipio', 'poblacion', 'imagenMunicipio')->where('provincia', $provincia)->where('poblacion', '<=', $poblacion)->
                    where('despoblacion', 0)->orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
                }
            }
            else{
                return response()->json(Place::select('provincia', 'municipio', 'poblacion', 'imagenMunicipio')->where('provincia', $provincia)->where('poblacion', '<=', $poblacion)->
                orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
            }

        }
        else if(!Place::where('provincia', $provincia)->first()){
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
        else if($poblacion <= 0){
            return response()->json(['error'=>"Invalid number supplied"], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    //Return "MUNICIPIOS" considered from "España Vacia"
    public function getMunsEV(){
        return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('despoblacion', 1)->get(), JsonResponse::HTTP_OK);
    }

    //Return "MUNICIPIOS" from a given "PROVINCIA" considered from "España Vacia"
    public function getMunsFromProvEV($provincia){
        if(Place::where('provincia', $provincia)->first()){
            return response()->json(Place::select('provincia', 'municipio', 'poblacion')->where('provincia', $provincia)->where('despoblacion', 1)->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
    }

    //Return "MUNICIPIOS" from a given "PROVINCIA" considered from "España Vacia" ordered by "Poblacion"
    public function getMunsFromProvEVOrdered($provincia){
        if(Place::where('provincia', $provincia)->first()){
            return response()->json(Place::select('provincia', 'municipio', 'poblacion','codigoProvincia', 'codigoMunicipio','imagenMunicipio', 'cLatitud', 'cLongitud')->
            where('provincia', $provincia)->where('despoblacion', 1)->
            orderBy('poblacion')->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
    }

    //Return "PROVINCIA AND MUNICIPIOS CODES" from given "PROVINCIA"
    public function getCodesFromMun($provincia){
        if(Place::where('provincia', $provincia)->first()){
            return response()->json(Place::select('provincia', 'municipio', 'codigoProvincia', 'codigoMunicipio')->where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }
    }

    //Return "MUNICIPIOS" "COORDINATES" from a given "PROVINCIA"
    public function getCoordinatesFromMun($provincia){
        if(Place::where('provincia', $provincia)->first()){
            return response()->json(Place::select('provincia', 'municipio', 'cLatitud', 'cLongitud')->where('provincia', $provincia)->get(), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>"We couldn't find any place with that 'provincia' name in our application."], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }

    }
}
