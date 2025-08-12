<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

use App\WebsiteSetting;
use App\Slider;
use App\Blog;
use App\Contact;
use App\BlogCategory;
use App\OurService;
use App\Testimonial;
use App\WhyChooseus;
use App\HomeContent;
use App\CmsPage;
use App\Mail\CommonMail;

use Illuminate\Support\Facades\Session;
use Config;
use Cookie;

use Mail;
use Swift_SmtpTransport;
use Swift_Mailer;
use Helper;

use Stripe;


class HomeController extends Controller
{
	public function __construct(Request $request)
    {
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);
	}

    public function coming_soon()
    {
        return view('coming_soon');
    }

	public function sicaptcha(Request $request)
    {
		 $code=$request->code;

		$im = imagecreatetruecolor(50, 24);
		$bg = imagecolorallocate($im, 37, 37, 37); //background color blue
		$fg = imagecolorallocate($im, 255, 241, 70);//text color white
		imagefill($im, 0, 0, $bg);
		imagestring($im, 5, 5, 5,  $code, $fg);
		header("Cache-Control: no-cache, must-revalidate");
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);

    }

	public static function hextorgb ($hexstring){
		$integar = hexdec($hexstring);
					return array( "red" => 0xFF & ($integar >> 0x10),
		"green" => 0xFF & ($integar >> 0x8),
		"blue" => 0xFF & $integar
		);
	}


    public function myprofile(Request $request)
    {
		return view('profile');
    }


	public function refresh_captcha() {
		$vals = array(
			'img_path' => public_path().'/captcha/',
			'img_url' => asset('public/captcha'),
			'expiration' => 7200,
			'word_lenght' => 6,
			'font_size' => 15,
			'img_width'	=> '110',
			'img_height' => '40',
			'colors'	=> array('background' => array(255,175,2),'border' => array(255,175,2),	'text' => array(255,255,255),	'grid' => array(255,255,255))
		);

		$cap = $this->create_captcha($vals);
		$captcha = $cap['image'];
		session()->put('captchaWord', $cap['word']);
		echo $cap['image'];
	}

	public function contact(Request $request){

		$this->validate($request, [
                'fullname' => 'required',
                'email' => 'required',
               // 'g-recaptcha-response' => 'required|recaptcha'
            ]);

			$set = \App\Admin::where('id',1)->first();

			$obj = new Contact;
			$obj->name = $request->fullname;
			$obj->contact_email = $request->email;
			$obj->contact_phone = $request->phone;
			$obj->subject = $request->subject;
			$obj->message = $request->message;
			$saved = $obj->save();
			// dd($set->primary_email);
			// $mailmessage = '<b>Hi Admin,</b><br> You have a New Query<br><b>Name:</b> '.$request->fullname.'<br><b>Email:</b> '.$request->email.'<br><b>Phone:</b> '.$request->phone.'<br><b>Subject:</b> '.$request->subject.'<br><b>Message:</b> '.$request->message;


			// $message = '<html><body>';
			// 	$message .= '<p>Hi Admin,</p>';
			// 	$message .= '<p>You have a New Query<br><b> '.$request->fullname.' </b></p>';
			// 	$message .= '<table><tr>
			// 		<td><b>Email: </b>'.$request->email.'</td></tr>
			// 		<tr><td><b>Name: </b>'.$request->fullname.'</td></tr>
			// 		<tr><td><b>Description: </b>'.$description.'</td></tr>
			// 		<tr><td><b>Phone: </b>'.$request->phone.'</td></tr>
			// 		<tr><td><b>Apoimtment Date/Time: </b>'.$requestData['date'].'/'.$requestData['time'].'</td></tr>
			// 	</table>';
			// $message .= '</body></html>';
			$subject = 'You have a New Query  from  '.$request->fullname;
			// $this->send_compose_template('test@gmail.com', $subject, 'test@gmail.com', $mailmessage,'test mail');


			$details = [
				'title' => 'You have a New Query  from  '.$request->fullname,
				'body' => 'This is for testing email using smtp',
				'subject'=>$subject,
				'fullname' => 'Admin',
				'from' =>$request->fullname,
				'email'=> $request->email,
				'phone' => $request->phone,
				'description' => $request->message
			];

			\Mail::to('test@gmail.com')->send(new \App\Mail\ContactUsMail($details));

			return back()->with('success', 'Thanks for sharing your interest. our team will respond to you with in 24 hours.');

	}


     public function getdatetime(Request $request)
    {   //dd($request->all());
        $enquiry_item = $request->enquiry_item;
        $req_service_id = $request->id;
        //echo $enquiry_item."===".$req_service_id; die;
        if(isset($request->inperson_address) && $request->inperson_address == 1 ) { //Adelaide
            if( $enquiry_item != "" && $req_service_id != "") {
                if( $req_service_id == 1 ) { //Paid service
                    $person_id = 5; //Adelaide
                    $service_type = $req_service_id; //Paid service
                }
                else if( $req_service_id == 2 ) { //Free service
                    $person_id = 5; //Adelaide
                    $service_type = $req_service_id; //Free service
                }
            }
        }
        else { //Melbourne

            if( $enquiry_item != "" && $req_service_id != "") {
                if( $req_service_id == 1 ) { //Paid service
                    $person_id = 1; //Ajay
                    $service_type = $req_service_id; //Paid service
                }
                else if( $req_service_id == 2 ) { //Free service
                    if( $enquiry_item == 1 || $enquiry_item == 6 || $enquiry_item == 7 ){
                        //1 => Permanent Residency Appointment
                        //6 => Complex matters: AAT, Protection visa, Federal Cas
                        //7 => Visa Cancellation/ NOICC/ Visa refusals
                        $person_id = 1; //Ajay
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 2 || $enquiry_item == 3 ){
                        //2 => Temporary Residency Appointment
                        //3 => JRP/Skill Assessment
                        $person_id = 2; //Shubam
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 4 ){ //Tourist Visa
                        $person_id = 3; //Tourist
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 5 ){ //Education/Course Change/Student Visa/Student Dependent Visa (for education selection only)
                        $person_id = 4; //Education
                        $service_type = $req_service_id; //Free service
                    }
                }
            }
        }
        //echo $person_id."===".$service_type; die;
        $bookservice = \App\BookService::where('id', $req_service_id)->first();//dd($bookservice);
        $service = \App\BookServiceSlotPerPerson::where('person_id', $person_id)->where('service_type', $service_type)->first();//dd($service);
	    if( $service ){
		   $weekendd  =array();
		    if($service->weekend != ''){
				$weekend = explode(',',$service->weekend);
				foreach($weekend as $e){
					if($e == 'Sun'){
						$weekendd[] = 0;
					}else if($e == 'Mon'){
						$weekendd[] = 1;
					}else if($e == 'Tue'){
						$weekendd[] = 2;
					}else if($e == 'Wed'){
						$weekendd[] = 3;
					}else if($e == 'Thu'){
						$weekendd[] = 4;
					}else if($e == 'Fri'){
						$weekendd[] = 5;
					}else if($e == 'Sat'){
						$weekendd[] = 6;
					}
				}
			}
			$start_time = date('H:i',strtotime($service->start_time));
			$end_time = date('H:i',strtotime($service->end_time));

            if($service->disabledates != ''){
                $disabledatesarray =  array();
                if( strpos($service->disabledates, ',') !== false ) {
                    $disabledatesArr = explode(',',$service->disabledates);
                    $disabledatesarray = $disabledatesArr;
                } else {
                    $disabledatesarray = array($service->disabledates);
                }
            } else {
                $disabledatesarray =  array();
            }

            // Add the current date to the array
            $disabledatesarray[] = date('d/m/Y'); //dd($disabledatesarray);
            if(isset($request->inperson_address) && $request->inperson_address == 1 ) { //Adelaide
                $duration = $bookservice->duration;
            } else { //Melbourne
                if( isset($req_service_id) && $req_service_id == 1){ //Paid
                    $duration = 15; //In melbourne case paid service = 15
                } else if( isset($req_service_id) && $req_service_id == 2){ //Free
                    $duration = $bookservice->duration; //In melbourne case free service = 15
                }
            }
            return json_encode(array('success'=>true, 'duration' =>$duration,'weeks' => $weekendd,'start_time' =>$start_time,'end_time'=>$end_time,'disabledatesarray'=>$disabledatesarray));
	    } else {
		 return json_encode(array('success'=>false, 'duration' =>0));
	    }
    }

    public function getdisableddatetime(Request $request)
    {
		$requestData = $request->all(); //dd($requestData);
		$date = explode('/', $requestData['sel_date']);
		$datey = $date[2].'-'.$date[1].'-'.$date[0];

        //Adelaide
        if( isset($request->inperson_address) && $request->inperson_address == 1 )
        {
            if( isset($request->service_id) && $request->service_id == 1  ){ //Adelaide Paid Service
                $book_service_slot_per_person_tbl_unique_id = 6;
            } else if( isset($request->service_id) && $request->service_id == 2  ){ //Adelaide Free Service
                $book_service_slot_per_person_tbl_unique_id = 8;
            }

            $service = \App\Appointment::select('id','date','time')
            ->where('inperson_address', '=', 1)
            ->where('status', '!=', 7)
            ->whereDate('date', $datey)
            ->exists();

            $servicelist = \App\Appointment::select('id','date','time')
            ->where('inperson_address', '=', 1)
            ->where('status', '!=', 7)
            ->whereDate('date', $datey)
            ->get();
        }

        //Melbourne
        else
        {
            if
            (
                ( isset($request->service_id) && $request->service_id == 1  )
                ||
                (
                    ( isset($request->service_id) && $request->service_id == 2 )
                    &&
                    ( isset($request->enquiry_item) && ( $request->enquiry_item == 1 || $request->enquiry_item == 6 || $request->enquiry_item == 7) )
                )
            ) { //Paid
                if( isset($request->service_id) && $request->service_id == 1  ){ //Ajay Paid Service
                    $book_service_slot_per_person_tbl_unique_id = 1;
                } else if( isset($request->service_id) && $request->service_id == 2  ){ //Ajay Free Service
                    $book_service_slot_per_person_tbl_unique_id = 2;
                }

                $service = \App\Appointment::select('id', 'date', 'time')
                ->where(function ($query) {
                    $query->whereNull('inperson_address')
                        ->orWhere('inperson_address', '')
                        ->orWhere('inperson_address', 2); //For Melbourne
                })
                ->where('status', '!=', 7)
                ->whereDate('date', $datey)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('noe_id', [1, 2, 3, 4, 5, 6, 7, 8])
                        ->where('service_id', 1);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('noe_id', [1, 6, 7])
                        ->where('service_id', 2);
                    });
                })->exists();

                $servicelist = \App\Appointment::select('id', 'date', 'time')
                ->where(function ($query) {
                    $query->whereNull('inperson_address')
                        ->orWhere('inperson_address', '')
                        ->orWhere('inperson_address', 2); //For Melbourne
                })
                ->where('status', '!=', 7)
                ->whereDate('date', $datey)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('noe_id', [1, 2, 3, 4, 5, 6, 7, 8])
                        ->where('service_id', 1);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('noe_id', [1, 6, 7])
                        ->where('service_id', 2);
                    });
                })->get();
            }
            else if( isset($request->service_id) && $request->service_id == 2) { //Free
                if( isset($request->enquiry_item) && ( $request->enquiry_item == 2 || $request->enquiry_item == 3 ) ) { //Temporary and JRP

                    if( isset($request->service_id) && $request->service_id == 2  ){ //Shubam Free Service
                        $book_service_slot_per_person_tbl_unique_id = 3;
                    }

                    $service = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [2,3])
                        ->Where('service_id', 2);
                    })->exists();

                    $servicelist = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [2,3])
                        ->Where('service_id', 2);
                    })->get();
                }
                else if( isset($request->enquiry_item) && ( $request->enquiry_item == 4 ) ) { //Tourist Visa

                    if( isset($request->service_id) && $request->service_id == 2  ){ //Tourist Free Service
                        $book_service_slot_per_person_tbl_unique_id = 4;
                    }

                    $service = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [4])
                        ->Where('service_id', 2);
                    })->exists();

                    $servicelist = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [4])
                        ->Where('service_id', 2);
                    })->get();
                }
                else if( isset($request->enquiry_item) && ( $request->enquiry_item == 5 ) ) { //Education/Course Change
                    if( isset($request->service_id) && $request->service_id == 2  ){ //Education Free Service
                        $book_service_slot_per_person_tbl_unique_id = 5;
                    }
                    $service = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [5])
                        ->Where('service_id', 2);
                    })->exists();

                    $servicelist = \App\Appointment::select('id','date','time')
                    ->where(function ($query) {
                        $query->whereNull('inperson_address')
                            ->orWhere('inperson_address', '')
                            ->orWhere('inperson_address', 2); //For Melbourne
                    })
                    ->where('status', '!=', 7)
                    ->whereDate('date', $datey)
                    ->where(function ($query) {
                        $query->whereIn('noe_id', [5])
                        ->Where('service_id', 2);
                    })->get();
                }
            }
        }
        //dd($servicelist);
        $disabledtimeslotes = array();
	    if($service){
            foreach($servicelist as $list){
                $disabledtimeslotes[] = date('g:i A', strtotime($list->time)); //'H:i A'
			}
            $disabled_slot_arr = \App\BookServiceDisableSlot::select('id','slots')->where('book_service_slot_per_person_id', $book_service_slot_per_person_tbl_unique_id)->whereDate('disabledates', $datey)->get();
            //dd($disabled_slot_arr);
            if(!empty($disabled_slot_arr) && count($disabled_slot_arr) >0 ){
                $newArray = explode(",",$disabled_slot_arr[0]->slots); //dd($newArray);
            } else {
                $newArray = array();
            }
            $disabledtimeslotes = array_merge($disabledtimeslotes, $newArray); //dd($disabledtimeslotes);
		    return json_encode(array('success'=>true, 'disabledtimeslotes' =>$disabledtimeslotes));
	    } else {
            $disabled_slot_arr = \App\BookServiceDisableSlot::select('id','slots')->where('book_service_slot_per_person_id', $book_service_slot_per_person_tbl_unique_id)->whereDate('disabledates', $datey)->get();
            //dd($disabled_slot_arr);
            if(!empty($disabled_slot_arr) && count($disabled_slot_arr) >0 ){
                $newArray = explode(",",$disabled_slot_arr[0]->slots); //dd($newArray);
            } else {
                $newArray = array();
            }
            $disabledtimeslotes = array_merge($disabledtimeslotes, $newArray); //dd($disabledtimeslotes);
		    return json_encode(array('success'=>true, 'disabledtimeslotes' =>$disabledtimeslotes));
	    }
    }


    public function getdatetimebackend(Request $request)
    {   //dd($request->all());
        $enquiry_item = $request->enquiry_item;
        $req_service_id = $request->id;
        //echo $enquiry_item."===".$req_service_id; die;
        if(isset($request->inperson_address) && $request->inperson_address == 1 ) { //Adelaide
            if( $enquiry_item != "" && $req_service_id != "") {
                if( $req_service_id == 1 ) { //Paid service
                    $person_id = 5; //Adelaide
                    $service_type = $req_service_id; //Paid service
                }
                else if( $req_service_id == 2 ) { //Free service
                    $person_id = 5; //Adelaide
                    $service_type = $req_service_id; //Free service
                }
            }
        }
        else { //Melbourne

            if( $enquiry_item != "" && $req_service_id != "")
            {
                if( $req_service_id == 1 ) { //Paid service
                    $person_id = 1; //Ajay
                    $service_type = $req_service_id; //Paid service
                }
                else if( $req_service_id == 2 ) { //Free service
                    if( $enquiry_item == 1 || $enquiry_item == 6 || $enquiry_item == 7 ){
                        //1 => Permanent Residency Appointment
                        //6 => Complex matters: AAT, Protection visa, Federal Cas
                        //7 => Visa Cancellation/ NOICC/ Visa refusals
                        $person_id = 1; //Ajay
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 2 || $enquiry_item == 3 ){
                        //2 => Temporary Residency Appointment
                        //3 => JRP/Skill Assessment
                        $person_id = 2; //Shubam
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 4 ){ //Tourist Visa
                        $person_id = 3; //Tourist
                        $service_type = $req_service_id; //Free service
                    }
                    else if( $enquiry_item == 5 ){ //Education/Course Change/Student Visa/Student Dependent Visa (for education selection only)
                        $person_id = 4; //Education
                        $service_type = $req_service_id; //Free service
                    }
                }
            }
        }
        //echo $person_id."===".$service_type; die;
        $bookservice = \App\BookService::where('id', $req_service_id)->first();//dd($bookservice);
        $service = \App\BookServiceSlotPerPerson::where('person_id', $person_id)->where('service_type', $service_type)->first();//dd($service);
	    if( $service ){
		   $weekendd  =array();
		    if($service->weekend != ''){
				$weekend = explode(',',$service->weekend);
				foreach($weekend as $e){
					if($e == 'Sun'){
						$weekendd[] = 0;
					}else if($e == 'Mon'){
						$weekendd[] = 1;
					}else if($e == 'Tue'){
						$weekendd[] = 2;
					}else if($e == 'Wed'){
						$weekendd[] = 3;
					}else if($e == 'Thu'){
						$weekendd[] = 4;
					}else if($e == 'Fri'){
						$weekendd[] = 5;
					}else if($e == 'Sat'){
						$weekendd[] = 6;
					}
				}
			}
			$start_time = date('H:i',strtotime($service->start_time));
			$end_time = date('H:i',strtotime($service->end_time));

            if($service->disabledates != ''){
                $disabledatesarray =  array();
                if( strpos($service->disabledates, ',') !== false ) {
                    $disabledatesArr = explode(',',$service->disabledates);
                    $disabledatesarray = $disabledatesArr;
                } else {
                    $disabledatesarray = array($service->disabledates);
                }
            } else {
                $disabledatesarray =  array();
            }
            // Add the current date to the array
            //$disabledatesarray[] = date('d/m/Y'); //dd($disabledatesarray);
            if(isset($request->inperson_address) && $request->inperson_address == 1 ) { //Adelaide
                $duration = $bookservice->duration;
            } else { //Melbourne
                if( isset($req_service_id) && $req_service_id == 1){ //Paid
                    $duration = 15; //In melbourne case paid service = 15
                } else if( isset($req_service_id) && $req_service_id == 2){ //Free
                    $duration = $bookservice->duration; //In melbourne case free service = 15
                }
            }
            return json_encode(array('success'=>true, 'duration' =>$duration,'weeks' => $weekendd,'start_time' =>$start_time,'end_time'=>$end_time,'disabledatesarray'=>$disabledatesarray));
	    }else{
		 return json_encode(array('success'=>false, 'duration' =>0));
	   }
    }
}

