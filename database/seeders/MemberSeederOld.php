<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeederOld extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $customersJson = json_decode(file_get_contents(dirname(__DIR__ ) . '/customers.json') , true);
     
       foreach($customersJson as $js)
       {
        if($js['email'] == "" || $js['name'] == "") continue;
        $email = $js['email'] == "" ? $js['phone'].'@c.us' : $js['email'];
        $name = $js['name'] == "" ? 'user'.time() : $js['name'];
        $address = implode(" , " , [$js['address'] , $js['city'] , $js['states'],$js['country']]);
        $point = $js['point'] == "" ? 1 : $js['point'];
        $total_transactions = $js['total_transaction'] == "" ? 0 : $js['total_transaction'];
        $password = bcrypt("password123");
        $phone = $js['phone'];

        $insert = [
            'email' => $email,
            'password'=> $password,
            'username' => $name,
            'point' => $point,
            'total_transactions' => $total_transactions,
            'address' => $address,
            'phone' => $phone,
            'status' => 'active',
            'image' => 'https://ui-avatars.com/api/?name='.urlencode($name)
        ];

        $member = \App\Models\Member::where('email' , $email)->first();
        if($member)
        {
            echo "$member->email => SKIP \n";
        }else{
            \App\Models\Member::create($insert);
            echo "{$insert['email']} => DONE \n";
        }
       }
    }
}
