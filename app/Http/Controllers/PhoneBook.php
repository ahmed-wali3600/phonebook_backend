<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\phone_book;
use Illuminate\Support\Facades\Hash;

class PhoneBook extends Controller
{
    //

    private $pb_model;

    public function __construct()
    {
        $this->pb_model = new phone_book();
    }

    public function get_user_profile($id){
        $userProfileData= $this->pb_model->get_user_profile($id);

        if (!$userProfileData) {
            return response()->json(['message' => 'User profile not found'], 404);
        }
    
        // Return the data as a JSON response
        return response()->json($userProfileData);

    }

    public function signin(Request $request){

        

        $username = $request->input('username');
        $password = $request->input('password');

        $db_response = $this->pb_model->signin($username);

        if($db_response){


            if (password_verify($password, $db_response[0]->user_password)){
            

                return response()->json([
                    "singin_status"=>1,
                    "msg" => "Login Successfull"
                ]);
                
            }
            else
            {
                return response()->json([
                    "singin_status"=>2,
                    "msg" => "Incorrect Password"
                ]);
            }
        }
        else
        {
            return response()->json([
                "singin_status"=>3,
                "msg" => "Incorrect Username"
            ]);
        }

    }



    public function get_all_contacts_of_specified_user($id){

        $db_response = $this->pb_model->get_all_contacts_of_specified_user($id);
        if(!empty($db_response)){

        
            return response()->json([
                'status'=>1,
                'response_data'=>$db_response
            ]);
        }
        else
        {
            return response()->json([
                'status'=>2,
                'msg'=>"No Records Found"
            ]);
        }
    }

    public function test_msg(){

        return response()->json(['msg',"Testing"]);
    }


}
