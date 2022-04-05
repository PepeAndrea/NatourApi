<?php

namespace App\Http\Controllers;

use App\Mail\AccessoryAdv;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    use ApiResponser;


    public function sendEmail(Request $req)
    {
        if($req->user()->isAdmin){

            $validated = $req->validate([
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new AccessoryAdv($validated));
            }

            return $this->success(null,"Messaggio inviato");

        }else{
            return $this->error("Non disponi delle autorizzazioni necessarie",403);
        }
    }

}
