<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\SubsequenceResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\StreamDataService;
class StreamController extends Controller
{
    protected StreamDataService $streamDataService;

    public function __construct(StreamDataService $streamDataService){
        $this->streamDataService = $streamDataService;
    }
    public function analyze(Request $request){

        try{
    
                $validator = Validator::make($request->all(),[
                    'stream' => 'required|string',
                    'k' => 'required|integer|min:1',
                    'top' => 'required|integer|min:1',
                    'exclude' => 'nullable|array'
                ]);

                if($validator->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'Validation Error',
                        'data' => $validator->errors()
                    ],400);
                }

                $stream = new Stream;
                $stream->data = $request->stream;
                $stream->save();

                
                $data = $request->stream;
                $k = $request->k;
                if(isset($request->exclude)){
                    $exclude = $request->exclude;
                }else{
                    $exclude = null;
                }
                

                $map_data = $this->streamDataService->findMatchingData($data,$k,$exclude);

                foreach($map_data as $key=>$value){
                    if($value!=$request->exclude){
                        $sequence_result = SubsequenceResult::updateOrCreate([
                            'stream_id' => $stream->id,
                            'subsequence'=>$key,
                            'count' => $value
                        ]);   
                    }
                    
                }
                
                $result = SubsequenceResult::where('stream_id',$stream->id)->orderBy('count','desc')->limit(5)->pluck('count','subsequence');
                return response()->json([
                    'status' => true,
                    'message' => 'Analysis Data',
                    'data' => $result
                ],200);



            } catch (\InvalidArgumentException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ], 400);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'An error occurred during the analysis.',
                    'error' => $e->getMessage(),
                ], 500);
            }

    }

    
}
