<?php

namespace App\Services;
use Illuminate\Http\Request;
use Log;

class StreamDataService{
    public function findMatchingData($data,$k,$exclude=null){
        try{

            if(strlen($data)<$k){
                
                throw new \InvalidArgumentException('insufficient input stream');
               
            }

            $matchingData = [];
            $n  = strlen($data);

            for($i=0; $i<=$n-$k; $i++){
                $sub_stream = substr($data,$i,$k);

                if(isset($matchingData[$sub_stream])){
                    $matchingData[$sub_stream] = $matchingData[$sub_stream] + 1;
                }else{
                    $matchingData[$sub_stream] = 1;
                }
                
                
            }

            arsort($matchingData);

            if(isset($exclude) && !empty($exclude)){
                $exclude = array_flip($exclude);
                
                return $result=array_diff_key($matchingData,$exclude);
                
            }else{
                return $matchingData;
            }

            

        }catch(\Exception $e){
            Log::info('Error:',[
                'status' => false,
                'message' => 'Exception Error',
                'data' => $e->getMessage()
            ],400);

        }
    }
}