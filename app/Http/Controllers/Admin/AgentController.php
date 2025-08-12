<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ImportUser;
use App\Admin;
use App\RepresentingPartner;

use Auth;
use Config;

class AgentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
	/**
     * All Vendors.
     *
     * @return \Illuminate\Http\Response
     */
	public function active(Request $request)
	{
		$query 		= Admin::where('status', '=', 1)->where('role', 16); //migration agent
        $totalData 	= $query->count();	//for all data
        $lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit')); //dd($lists);
        return view('Admin.agents.active',compact(['lists', 'totalData']));
	}

	public function inactive(Request $request)
	{
		$query 		= Admin::where('status', '=', 0)->where('role', 16);
        $totalData 	= $query->count();	//for all data
        $lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit'));
        return view('Admin.agents.inactive',compact(['lists', 'totalData']));
	}

	public function create(Request $request){
		return view('Admin.agents.create');
	}

	public function store(Request $request)
	{
		//check authorization end
		if ($request->isMethod('post'))
		{
			$this->validate($request, [
                //'email' => 'required|email',
                'email' => 'required|email|unique:admins,email',
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

			$requestData 		= 	$request->all();
            $obj				= 	new Admin;
            $obj->role	=	16; //migration agent
            $obj->gender	=	@$requestData['gender'];
            $obj->company_name	=	@$requestData['company_name'];
            $obj->first_name	=	@$requestData['first_name'];
            $obj->last_name	=	@$requestData['last_name'];
            $obj->marn_number	=	@$requestData['marn_number'];
            $obj->legal_practitioner_number	=	@$requestData['legal_practitioner_number'];
            //$obj->exempt_person_reason	=	@$requestData['exempt_person_reason'];
            $obj->ABN_number	=	@$requestData['ABN_number'];
            $obj->email	=	@$requestData['email'];
            $obj->phone	=	@$requestData['phone'];
            $obj->business_mobile	=	@$requestData['business_mobile'];
            $obj->business_fax	=	@$requestData['business_fax'];
            $obj->address	=	@$requestData['address'];
			$saved				=	$obj->save();

			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/agents/active')->with('success', 'Agents Added Successfully');
			}
		}

		return view('Admin.agents.create');
	}

	public function edit(Request $request, $id = NULL)
	{
        //check authorization end
        if ($request->isMethod('post'))
		{
			$requestData = $request->all(); //dd($requestData);
            $this->validate($request, [
                'email' => 'required|email|unique:admins,email,' . $request->id,
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

			$obj				= 	Admin::find(@$requestData['id']);
            $obj->company_name	=	@$requestData['company_name'];
            $obj->first_name	=	@$requestData['first_name'];
            $obj->last_name	=	@$requestData['last_name'];
            $obj->marn_number	=	@$requestData['marn_number'];
            $obj->legal_practitioner_number	=	@$requestData['legal_practitioner_number'];
            //$obj->exempt_person_reason	=	@$requestData['exempt_person_reason'];
            $obj->ABN_number	=	@$requestData['ABN_number'];
            $obj->email	=	@$requestData['email'];
            $obj->phone	=	@$requestData['phone'];
            $obj->business_mobile	=	@$requestData['business_mobile'];
            $obj->business_fax	=	@$requestData['business_fax'];
            $obj->address	=	@$requestData['address'];
            $obj->gender	=	@$requestData['gender'];
            $obj->role	=	16;
            $saved				=	$obj->save();
            if(!$saved) {
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			} else {
				return Redirect::to('/admin/agents/active')->with('success', 'Agents Edited Successfully');
			}
		}
        else
		{
			if(isset($id) && !empty($id)) {
                $id = $this->decodeString($id);
				if(Admin::where('id', '=', $id)->exists()) {
					$fetchedData = Admin::find($id);
					return view('Admin.agents.edit', compact(['fetchedData']));
				} else {
					return Redirect::to('/admin/agents/active')->with('error', 'Agents Not Exist');
				}
			}
			else
			{
				return Redirect::to('/admin/agents/active')->with('error', Config::get('constants.unauthorized'));
			}
		}

	}

	/* public function show(Request $request, $id = NULL){
		if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);
				if(User::where('id', '=', $id)->exists())
				{
					$fetchedData = User::where('id',$id)->first();

					return view('Admin.agents.show', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/agents/index')->with('error', 'Agent Not Exist');
				}
			}
			else
			{
				return Redirect::to('/admin/agents/index')->with('error', Config::get('constants.unauthorized'));
			}
	} */

	public function detail(Request $request, $id = NULL){
		if(isset($id) && !empty($id)) {
			$id = $this->decodeString($id);
			if(Admin::where('id', '=', $id)->exists()) {
				$fetchedData = Admin::find($id);
				return view('Admin.agents.detail', compact(['fetchedData']));
			} else {
				return Redirect::to('/admin/agents/active')->with('error', 'Agents Not Exist');
			}
		}
		else
		{
			return Redirect::to('/admin/agents/active')->with('error', Config::get('constants.unauthorized'));
		}
	}

	public function savepartner(Request $request)
	{
		//check authorization end
		if ($request->isMethod('post'))
		{
			$requestData 		= 	$request->all();

			$obj				= 	new RepresentingPartner;
			$obj->partner_id	=	@$requestData['represent_partner'];
			$obj->agent_id	=	@$requestData['client_id'];

			$saved				=	$obj->save();

			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/agent/detail/'.base64_encode(convert_uuencode(@$requestData['client_id'])))->with('success', 'Partner Added Successfully');
			}
		}
	}


	public function businessimport(Request $request){
		if ($request->isMethod('post'))
		{

			 Excel::import(new ImportUser,
                      $request->file('uploadfile')->store('files'), $request);
			return redirect()->back()->with('success', 'Agents Imported successfully');
		}else{
			return view('Admin.agents.importbusiness');
		}
	}

	public function individualimport(Request $request){
		return view('Admin.agents.importindividual');
	}
}
