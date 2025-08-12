<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\UploadChecklist; 
  
use Auth; 
use Config;

class UploadChecklistController extends Controller
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
		
	public function index(Request $request)
	{
		$query 		= UploadChecklist::where('id', '!=', ''); 
		$totalData 	= $query->count();	//for all data
		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit'));
		// Dropdown: Active Matter list
		$matterIds = DB::table('matters')->select('id','title','nick_name')->where('status','1')->orderBy('id', 'asc')->get();
		return view('Admin.uploadchecklist.index',compact(['lists', 'totalData','matterIds'])); 	
	}
	
	 
	public function store(Request $request)
	{		
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, ['name' => 'required|max:255']);
			$requestData 	= 	$request->all();
			$obj			= 	new UploadChecklist; 
			$obj->matter_id	=	@$requestData['matter_id'];
			$obj->name		=	@$requestData['name'];
			/* Profile Image Upload Function Start */						  
			if($request->hasfile('checklists')) 
			{	
				$checklists = $this->uploadFile($request->file('checklists'), Config::get('constants.checklists'));
			}
			else
			{
				$checklists = NULL;
			}		
			/* Profile Image Upload Function End */	
			$obj->file		=	@$checklists;
			$saved			=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/upload-checklists')->with('success', 'Record Added Successfully');
			}				
		}	
	}
}
