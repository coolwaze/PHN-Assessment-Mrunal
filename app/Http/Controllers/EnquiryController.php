<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnquiryConfirmationMail;
use Mews\Captcha\Facades\Captcha;



class EnquiryController extends Controller
{
    public function index()
    {
        return view('enquiry_form');
    }
 

    public function submitForm(Request $request)
    {
        try {
 
            //Check if mobile number already exists
            $existingEnquiry = Enquiry::where('mobile', $request['mobile'])->first();
            if ($existingEnquiry) {
                return redirect()->back()->with('error', 'Mobile number already exists. Please try with another mobile number.');
            }

        // Validate form fields
            $validatedData = $request->validate([
                'name' => 'required|regex:/^[A-Za-z\s]+$/',
                'email' => 'required|email',
                'mobile' => 'required|numeric|digits:10|unique:enquiries,mobile',
                'state' => 'required',
                'district' => 'required',
                'captcha' => 'required|captcha'
            ]);
            // Save the enquiry to the database
            $enquiry = new Enquiry();
            $enquiry->name = $validatedData['name'];
            $enquiry->email = $validatedData['email'];
            $enquiry->mobile = $validatedData['mobile'];
            $enquiry->state = $validatedData['state'];
            $enquiry->district = $validatedData['district'];
            // Set any additional fields here
            $enquiry->save();

            // Send confirmation email
            Mail::to($enquiry->email)->send(new EnquiryConfirmationMail($enquiry));

            //Redirect to a success page or display a success message
            return redirect()->route('enquiry.success')->with('success', 'Enquiry submitted successfully.');
        }catch (\Exception $e) {
            
           if($e->getMessage() == 'validation.captcha'){
            return back()->withError('Please  enter Valid captcha !')->withInput();
           }
           return back()->withError($e->getMessage())->withInput();
        }
      
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('math')]);
    }
 
}
