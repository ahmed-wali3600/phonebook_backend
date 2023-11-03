<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class phone_book extends Model
{
    use HasFactory;


    public function get_user_profile($id){

        return DB::table('user_profile')->where('user_id',$id)->get();
    }

    public function signin($username){

        return DB::table('user_profile')
                ->select('user_password')
                ->where('username',$username)
                ->limit(1)->get();


            
    }


    public function get_all_contacts_of_specified_user($id){

        return DB::table('user_profile AS up')
            ->select("cd.contact_id AS Contact_Id,   
                    cn.contact_number_id AS Contact_Number_Id, 
                    cn.contact_number AS Contact_Number")
            ->leftJoin('contact_details AS cd','up.user_id','=','cd.user_id')
            ->leftJoin('contact_numbers AS cn','cd.contact_id','=','cn.contact_id')
            ->where('up.user_id',$id)
            ->orderBy('cd.contact_name')
            ->get();

    }


}
