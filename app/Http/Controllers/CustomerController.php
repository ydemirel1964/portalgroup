<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Company;
use Artisaninweb\SoapWrapper\SoapWrapper;
use GuzzleHttp\Client;

interface ICustomerController
{
   public function index(); 
   public function create(Request $request);
   public function customerinsert($customerdata);
   public function mersiscontrol($customerdata);
   public function customervalidation($request);
   public function customers($request);
   public function getcompanyname();
   public function getauthid();
   public function getmernisstatus();
}

class CustomerController extends Controller 
{

    public function index(){
       
        return view('customer', ['companyname' => $this->getcompanyname()]);
    }

    public function create(Request $request) {
        $customerdata = $this->customers($request);
        $mernisstatus=$this->getmernisstatus();
        if($mernisstatus==true)
        {
            $mersiscontrolresult = $this->mersiscontrol($customerdata);
            if($mersiscontrolresult!=true)
            {
                return view('customer',['message'=>'Kaydınız Eklenmedi. Lütfen bilgilerinizi kontrol ediniz','companyname'=> $this->getcompanyname()]);
            }
        }
        $this->customerinsert($customerdata);
        return view('customer',['message'=>'Kaydınız Eklenmiştir','companyname'=> $this->getcompanyname()]);
    }

    public function customerinsert($customerdata){
        $customerinsert=Customer::create([
            'company_id'=>$this->getauthid(),
            'tc'=>$customerdata['tc'],
            'name'=>$customerdata['name'],
            'surname'=>$customerdata['surname'],
            'birthyear'=>$customerdata['birthyear']
        ]);
    }

    public function mersiscontrol($customerdata){
        $soapUrl = "https://tckimlik.nvi.gov.tr/service/kpspublic.asmx?op=TCKimlikNoDogrula"; 
        $post_data = "<?xml version='1.0' encoding='utf-8'?>   
		<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>
			<soap:Body>
				<TCKimlikNoDogrula xmlns='http://tckimlik.nvi.gov.tr/WS'>
					<TCKimlikNo>".$customerdata['tc']."</TCKimlikNo>
					<Ad>".$customerdata['name']."</Ad>
					<Soyad>".$customerdata['surname']."</Soyad>
					<DogumYili>".$customerdata['birthyear']."</DogumYili>
				</TCKimlikNoDogrula>
			</soap:Body>
		</soap:Envelope>";
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
        ); 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);    
        $response=(strip_tags($response) === 'true') ? true : false;
        curl_close($ch);
        return $response;
    }

    public function customervalidation($request) {
        $validated = $request->validate([
            'tc' => 'required|size:11',
            'name' => 'required',
            'surname' => 'required',
            'birthyear' => 'required'
        ]);
    }   

    public function customers($request){
        $validate=$this->customervalidation($request);
        $tc = $request['tc'];
        $name = $request['name'];
        $surname = $request['surname'];
        $birthyear = $request['birthyear'];
        $customerdata = array('tc'=>$tc,'name'=>$name,'surname'=>$surname,'birthyear'=>$birthyear);
        return $customerdata;
    }

    public function getcompanyname(){
        $companyresult = Company::select('company_name')->where(['id'=> $this->getauthid()])->get();
        $companyname=$companyresult[0]['company_name'];
        return $companyname;
    }

    public function getauthid(){
        return Auth::user()->id;
    }

    public function getmernisstatus(){
        $mernisstatus = Company::select('mernis')->where(['id'=> $this->getauthid()])->get();
        $mernisstatus=$mernisstatus[0]['mernis'];
        return $mernisstatus;
    }
}
