<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\IdealistaCards;
use App\Models\Place;
use App\Models\PlaceInfo;
use App\Models\TripadvisorCards;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{   
    public function getTrip($provincia, $municipio){
        $py_path = 'resources\py\tripadvisor.py';
        $query_result = PlaceInfo::where('provincia', 'like', $provincia)->where('municipio', 'like', $municipio)->where('linkType', 'tripadvisor')->first();
        if(is_null($query_result)){

            /*
            ***TODO***
            Find closest place(based on coordinates) and show its placeLink (it must have a placeLink)
            */
            return response()->json(['error' => 'Nothing found'], JsonResponse::HTTP_OK);
        }
        else{
            //If there is content (3 rows == 'que visitar', 'alojamiento' y 'donde comer') for placeLink in TripadvisorCards
            if (count(TripadvisorCards::where('placeLink', $query_result->placeLink)->get()) != 0){
                $currentDate = new DateTime("now");
                $expirationDate = PlaceInfo::select('expirationDate')->where('placeLink', $query_result->placeLink)->first();

                //If expiration date "expired" (scrapeData but updating the database)
                if($expirationDate >= $currentDate){
                    
                }
                else{
                    return response()->json(TripadvisorCards::where('placeLink', $query_result->placeLink)->get(), JsonResponse::HTTP_OK);
                }
            }
            else{
                $this->scrapeData($py_path, $query_result->placeLink);
                return response()->json(TripadvisorCards::where('placeLink', $query_result->placeLink)->get(), JsonResponse::HTTP_OK);
            }
        }        
    }

    public function getTripCard(Request $request){
        $py_path = 'resources\py\tripadvisor_card.py';
        $search_param = '/Attraction_Review-g562662-d10021149-Reviews-Burrolandia-Tres_Cantos.html';
        $this->scrapeData($py_path, $search_param);
    }

    /*
    ***TODO***
    Transform ñ or accents
    */
    public function getIdea($provincia, $municipio){
        $py_path = 'resources\py\idealista.py';
        $query_result = PlaceInfo::where('provincia', 'like', $provincia)->where('municipio', 'like', $municipio)->where('linkType', 'idealista')->first();
        if(is_null($query_result)){

            /*
            ***TODO***
            Find for a result(scrapeData), if no result was found -> Find closest place(based on coordinates) and show its placeLink (it must have a placeLink)
            */
            //$search_param = 'tres-cantos-madrid';
            $search_param = $this->normalize(str_replace(' ', '-', ($municipio.' '.$provincia)));
            $currentDate = new DateTime("now");
            $expirationDate = date_format($currentDate->add(new DateInterval('P15D')), 'Y-m-d');

            PlaceInfo::insert([[
                'placeLink' => '/'.'alquiler-viviendas/'.$search_param.'/',
                'provincia' => $provincia,
                'municipio' => $municipio,
                'linkType' => 'idealista',
                'expirationDate' => $expirationDate
            ],
            [
                'placeLink' => '/'.'venta-viviendas/'.$search_param.'/',
                'provincia' => $provincia,
                'municipio' => $municipio,
                'linkType' => 'idealista',
                'expirationDate' => $expirationDate
            ]]);
            

            // Temporal fix
            try{
                $this->scrapeData($py_path, $search_param);
                return response()->json(PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->where(
                    'placeinfo.municipio', $municipio
                )->select('idealistacards.*')->get(), JsonResponse::HTTP_OK);
            }catch(Exception $e){
                PlaceInfo::where('municipio', $municipio)->where('linkType', 'idealista')->delete();
                dd($e->getMessage());
            }
            
        }
        else{
            return response()->json(PlaceInfo::join('idealistacards', 'placeinfo.placeLink', '=', 'idealistacards.placeLink')->where(
                'placeinfo.municipio', $municipio
            )->select('idealistacards.*')->get(), JsonResponse::HTTP_OK);
        }

    }

    public function getIdeaCard(Request $request){
        $py_path = 'resources\py\idealista_card.py';
        $search_param = 'https://www.idealista.com/inmueble/91560963/';
        return $this->scrapeData($py_path, $search_param);
    }

    private function scrapeData(string $py_path, string $search_param){
        $python = "python";

        $cmd = $python.' '.base_path($py_path).' '.$search_param;
        shell_exec($cmd);
        
        //$data = shell_exec($cmd);
        //dd($data);
        //return response()->json(json_decode($data), JsonResponse::HTTP_OK);
        

    }
    
    private function fetchData(){

    }

    private function normalize ($string) {
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );
       
        return strtr($string, $table);
    }

    
    public function show_py(Request $request)
    {
        $python = "python";
            
        //$cmd = $python.' '.base_path('resources\py\tripadvisor.py')." /Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html";
        $cmd = $python.' '.base_path('resources\py\idealista.py')." tres-cantos-madrid";
        //$cmd = $python.' '.base_path('resources\py\idealista_card.py')." https://www.idealista.com/inmueble/93804698/";
        $data = shell_exec($cmd);

        return response()->json(json_decode($data), JsonResponse::HTTP_OK);
        /*
        $request->validate([
            'api_token' => 'required'
        ]);
        
        if(in_array($request->query('api_token'), Admin::all('api_token')->pluck('api_token')->toArray())){
            $python = "python";
            
            //$cmd = $python.' '.base_path('resources\py\tripadvisor.py')." /Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html";
            //$cmd = $python.' '.base_path('resources\py\idealista.py')." tres-cantos-madrid";
            $cmd = $python.' '.base_path('resources\py\idealista_card.py')." https://www.idealista.com/inmueble/93804698/";
            $data = shell_exec($cmd);

            return response()->json(json_decode($data), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error' => 'API Token not valid', 'Supplied Token ' => $request->query('api_token')], JsonResponse::HTTP_OK);
        }
        */
        /*
        if (in_array($token, $this->api_tokens)){
            $python = "python";
        
            //$cmd = $python.' '.base_path('resources\py\tripadvisor.py')." /Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html";
            //$cmd = $python.' '.base_path('resources\py\idealista.py')." tres-cantos-madrid";
            $cmd = $python.' '.base_path('resources\py\idealista_card.py')." https://www.idealista.com/inmueble/93804698/";
            $data = shell_exec($cmd);
    
            return response()->json(json_decode($data), JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error' => 'API Token not valid'], JsonResponse::HTTP_OK);
        }
        */
        // Shell Working! (Execution time returning 1000 rows === 0.19 seg +-0.01)

        //return response()->json(['Output'=>$ans], JsonResponse::HTTP_OK);
        

        /*
        //passthru — Execute an external program and display raw output (Execution time returning 1000 rows === 0.19 seg +-0.02)
        $python = "C:\Users\PC-Casa\AppData\Local\Programs\Python\Python37\python.exe";
        $cmd = $python.' '.base_path('resources\py\prueba.py');

        $time_start = microtime(true);

        ob_start();
        passthru($cmd);

        $time_end = microtime(true);
        return response()->json(["result" => json_decode(ob_get_clean()), "execution_time" => ($time_end - $time_start)], JsonResponse::HTTP_OK);
        */
        /*
        $process = new Process([
            "C:\Users\PC-Casa\AppData\Local\Programs\Python\Python37\python.exe",
            base_path('resources\py\prueba.py'),
            ]);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
            //return response()->json(["error" => "Error en la ejecucion del script Python"], JsonResponse::HTTP_BAD_REQUEST);
        }

        $data = $process->getOutput();
        
        return response()->json(json_decode($data), JsonResponse::HTTP_OK);
        */
        //return response()->json($output, 200);
        //return response()->json(['Result'=>$output], JsonResponse::HTTP_OK);
        
    }
}
