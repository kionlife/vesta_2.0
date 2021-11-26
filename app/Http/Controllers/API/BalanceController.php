<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
   
class BalanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	 public function index(Request $request)
    {
		$limit = 12;
		$user = Auth::user(); 
		$result = '';
		
		if ($request->page) {
			$page = $request->page;
			$offset = $page*$limit;
		} else {
			$offset = 0;
		}
		
		if ($user->hasAnyRole('admin', 'inspector')) {
			$counters = Counter::offset($offset)->limit($limit)->get();
			$total_count = Counter::all()->count();
			
			$result = CounterResource::collection($counters)->additional(['total_count' => $total_count, 'success' => true]);
		} else {
			//$abonent_id = Abonent::where('user_id', $user->id)->first();
			$abonent_id = Abonent::where('user_id', $user->id)->first();
			
			$counters = Counter::where('abonent_id', $abonent_id->id)->offset($offset)->limit($limit)->get();
			$total_count = Counter::where('abonent_id', $abonent_id->id)->get()->count();
			
			$result = CounterResource::collection($counters)->additional(['total_count' => $total_count, 'success' => true]);
		}
		
        return $result;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$user = Auth::user(); 
		if ($user->hasAnyRole('admin', 'inspector')) {
			$input = $request->all();
		} else {
			$input['abonent_id'] = Abonent::where('user_id', $user->id)->first()->id;
			$input['service_id'] = $request->service_id;
			$input['author_id'] = $user->id;
			$input['value'] = $request->value;
		}
		
        $validator = Validator::make($input, [
            'abonent_id' => 'required',
            'service_id' => 'required',
            'author_id'  => 'required',
            'value'      => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
   
        $counter = Counter::create($input);
   
        return $this->sendResponse(new CounterResource($counter), 'Показники додані успішно!');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		
        if (is_null($counter)) {
            return $this->sendError('Abonent not found.');
        }
   
        return CounterResource::collection(Counter::where('abonent_id', $id)->get());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abonent $abonent)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
   
        $abonent->name = $input['name'];
        $abonent->detail = $input['detail'];
        $abonent->save();
   
        return $this->sendResponse(new AbonentResource($abonent), 'Abonent updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abonent $abonent)
    {
        $abonent->delete();
   
        return $this->sendResponse([], 'Abonent deleted successfully.');
    }
}