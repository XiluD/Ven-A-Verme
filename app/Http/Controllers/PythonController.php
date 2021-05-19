<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\IdeaInnerCardImages;
use App\Models\IdealistaCards;
use App\Models\IdealistaInnerCard;
use App\Models\IdealistaInnerCardFeatures;
use App\Models\Place;
use App\Models\PlaceInfo;
use App\Models\TripadvisorCards;
use DateInterval;
use DateTime;
use Exception;
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
 *      path="/api/trip/{provincia}/{municipio}",
 *      operationId="getTrip",
 *      tags={"Tripadvisor"},
 *      summary="Get tripadvisor main content",
 *      description="Get tripadvisor content based on place info",
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
 *          name="municipio",
 *          description="Nombre del municipio",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
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
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *     )
 */


 
/**
 * @OA\Get(
 *      path="/api/idea/{provincia}/{municipio}",
 *      operationId="getTrip",
 *      tags={"Idealista"},
 *      summary="Get Idealista main content",
 *      description="Get idealista content based on place info",
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
 *          name="municipio",
 *          description="Nombre del municipio",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
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
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *     )
 */

class PythonController extends Controller
{
    public function getTrip($provincia, $municipio)
    {
        $py_path = 'resources\py\tripadvisor.py';
        $query_result = PlaceInfo::where('provincia', 'like', $provincia)->where('municipio', 'like', $municipio)->where('linkType', 'tripadvisor')->first();
        if (is_null($query_result)) {

            /*
            ***TODO***
            Find closest place(based on coordinates) and show its placeLink (it must have a placeLink)
            */

            
            //return response()->json(['error' => 'Nothing found'], JsonResponse::HTTP_NOT_FOUND);
        } else {
            //If there is content for placeLink in TripadvisorCards
            if (count(TripadvisorCards::where('placeLink', $query_result->placeLink)->get()) != 0) {
                $currentDate = new DateTime("now");
                $expirationDate = PlaceInfo::select('expirationDate')->where('placeLink', $query_result->placeLink)->first();

                //If expiration date "expired" (scrapeData but updating the database)
                if ($expirationDate >= $currentDate) {
                }
                else {
                    $result = (object)[
                        'queVisitar' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                        where('placeLink', $query_result->placeLink)->
                        where('cardType', 'queVisitar')->get(),
    
                        'alojamiento' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                        where('placeLink', $query_result->placeLink)->
                        where('cardType', 'alojamiento')->get(),
    
                        'dondeComer' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                        where('placeLink', $query_result->placeLink)->
                        where('cardType', 'dondeComer')->get(),
    
                        'otros' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                        where('placeLink', $query_result->placeLink)->
                        where('cardType', 'otros')->get(),
                    ];
                    return response()->json($result, JsonResponse::HTTP_OK);
                }

            } else {
                $this->scrapeData($py_path, $query_result->placeLink);
                $result = (object)[
                    'queVisitar' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                    where('placeLink', $query_result->placeLink)->
                    where('cardType', 'queVisitar')->get(),

                    'alojamiento' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                    where('placeLink', $query_result->placeLink)->
                    where('cardType', 'alojamiento')->get(),

                    'dondeComer' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                    where('placeLink', $query_result->placeLink)->
                    where('cardType', 'dondeComer')->get(),

                    'otros' => TripadvisorCards::select('cardLink', 'placeLink', 'cardTitle', 'cardSubtitle', 'cardImage')->
                    where('placeLink', $query_result->placeLink)->
                    where('cardType', 'otros')->get(),

                ];
                return response()->json($result, JsonResponse::HTTP_OK);
                //return response()->json(TripadvisorCards::where('placeLink', $query_result->placeLink)->get(), JsonResponse::HTTP_OK);
            }
        }
    }

    public function getTripCard(Request $request)
    {
        $py_path = 'resources\py\tripadvisor_card.py';
        $search_param = '/Attraction_Review-g562662-d10021149-Reviews-Burrolandia-Tres_Cantos.html';
        $this->scrapeData($py_path, $search_param);
    }

    public function getIdea($provincia, $municipio)
    {
        $py_path = 'resources\py\idealista.py';
        $query_result = PlaceInfo::where('provincia', 'like', $provincia)->where('municipio', 'like', $municipio)->where('linkType', 'idealista')->first();
        if (is_null($query_result)) {

            /*
            ***TODO***
            Find for a result(scrapeData), if no result was found -> Find closest place(based on coordinates) and show its placeLink (it must have a placeLink)
            */
            //$search_param = 'tres-cantos-madrid';
            $search_param = $this->normalize(str_replace(' ', '-', ($municipio . ' ' . $provincia)));
            $currentDate = new DateTime("now");
            $expirationDate = date_format($currentDate->add(new DateInterval('P15D')), 'Y-m-d');

            PlaceInfo::insert([
                [
                    'placeLink' => '/' . 'alquiler-viviendas/' . $search_param . '/',
                    'provincia' => $provincia,
                    'municipio' => $municipio,
                    'linkType' => 'idealista',
                    'expirationDate' => $expirationDate
                ],
                [
                    'placeLink' => '/' . 'venta-viviendas/' . $search_param . '/',
                    'provincia' => $provincia,
                    'municipio' => $municipio,
                    'linkType' => 'idealista',
                    'expirationDate' => $expirationDate
                ]
            ]);

            // Temporal fix
            try {
                $this->scrapeData($py_path, $search_param);
                $result = (object)[
                    'onRent'=> PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->
                    where('placeinfo.municipio',$municipio)->
                    select('idealistacards.cardLink', 'idealistacards.placeLink', 'idealistacards.cardTitle', 'idealistacards.cardPrice',
                    'idealistacards.cardDetail', 'idealistacards.cardDescription', 'idealistacards.cardContact', 'idealistacards.cardImage')->
                    where('idealistacards.cardType', 'onRent')->get(),

                    'onSale'=> PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->
                    where('placeinfo.municipio',$municipio)->
                    select('idealistacards.cardLink', 'idealistacards.placeLink', 'idealistacards.cardTitle', 'idealistacards.cardPrice',
                    'idealistacards.cardDetail', 'idealistacards.cardDescription', 'idealistacards.cardContact', 'idealistacards.cardImage')->
                    where('idealistacards.cardType', 'onSale')->get(),
                ];
                return response()->json($result, JsonResponse::HTTP_OK);
                /*
                return response()->json(PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->
                where('placeinfo.municipio',$municipio)->
                select('idealistacards.*')->get(), JsonResponse::HTTP_OK);
                */

            } catch (Exception $e) {
                PlaceInfo::where('municipio', $municipio)->where('linkType', 'idealista')->delete();
                dd($e->getMessage());
            }
        } else {
            $result = (object)[
                'onRent'=> PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->
                where('placeinfo.municipio',$municipio)->
                select('idealistacards.cardLink', 'idealistacards.placeLink', 'idealistacards.cardTitle', 'idealistacards.cardPrice',
                'idealistacards.cardDetail', 'idealistacards.cardDescription', 'idealistacards.cardContact', 'idealistacards.cardImage')->
                where('idealistacards.cardType', 'onRent')->get(),

                'onSale'=> PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->
                where('placeinfo.municipio',$municipio)->
                select('idealistacards.cardLink', 'idealistacards.placeLink', 'idealistacards.cardTitle', 'idealistacards.cardPrice',
                'idealistacards.cardDetail', 'idealistacards.cardDescription', 'idealistacards.cardContact', 'idealistacards.cardImage')->
                where('idealistacards.cardType', 'onSale')->get(),
            ];
            return response()->json($result, JsonResponse::HTTP_OK);
        }
    }

    public function getIdeaCard(Request $request)
    {
        $py_path = 'resources\py\idealista_card.py';
        
        $cardLink = $request->query('cardLink');
        //dd($cardLink);
        //$search_param = 'https://www.idealista.com/inmueble/91763008/';
        
        //If these is existing idealista cardLink content for incoming cardLink
        $query_result = IdealistaInnerCard::where('cardLink', $cardLink)->first();
        if($query_result){

            $result = (object)[
                'cardLink' => $query_result->cardLink,
                'innerCardTitle' => $query_result->innerCardTitle,
                'innerCardPlace' => $query_result->innerCardPlace,
                'innerCardDetail' => $query_result->innerCardDetail,
                'innerCardPrice' => $query_result->innerCardPrice,
                'innerCardDescription' => $query_result->innerCardDescription,
                'innerCardContact' => $query_result->innerCardContact,
                'innerCardFeatures' => [
                    'basic' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'basic')->get()->pluck('featureData'),
                    'building' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'building')->get()->pluck('featureData'),
                    'equipment' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'equipment')->get()->pluck('featureData')
                ],
                'innerCardImages' => IdeaInnerCardImages::select('imageLink')->where('cardLink', $cardLink)->get()->pluck('imageLink')
            ];
            return response()->json($result, JsonResponse::HTTP_OK);
            
        }
        //If there is not (else)
        else{
            $this->scrapeData($py_path, $cardLink);
            $query_result = IdealistaInnerCard::where('cardLink', $cardLink)->first();
            $result = (object)[
                'cardLink' => $query_result->cardLink,
                'innerCardTitle' => $query_result->innerCardTitle,
                'innerCardPlace' => $query_result->innerCardPlace,
                'innerCardDetail' => $query_result->innerCardDetail,
                'innerCardPrice' => $query_result->innerCardPrice,
                'innerCardDescription' => $query_result->innerCardDescription,
                'innerCardContact' => $query_result->innerCardContact,
                'innerCardFeatures' => [
                    'basic' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'basic')->get()->pluck('featureData'),
                    'building' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'building')->get()->pluck('featureData'),
                    'equipment' => IdealistaInnerCardFeatures::select('featureData')->where('cardLink', $cardLink)->where('featureType', 'equipment')->get()->pluck('featureData')
                ],
                'innerCardImages' => IdeaInnerCardImages::select('imageLink')->where('cardLink', $cardLink)->get()->pluck('imageLink')
            ];
            return response()->json($result, JsonResponse::HTTP_OK);
        }
    }

    private function scrapeData(string $py_path, string $search_param)
    {
        $python = "python";

        $cmd = $python . ' ' . base_path($py_path) . ' ' . $search_param;
        //dd($cmd);
        shell_exec($cmd);

        //$data = shell_exec($cmd);
        //dd($data);
        //return response()->json(json_decode($data), JsonResponse::HTTP_OK);

    }

    private function normalize($string)
    {
        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
        );

        return strtr($string, $table);
    }
}
