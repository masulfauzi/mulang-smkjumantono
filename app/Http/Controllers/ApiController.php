<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Users\Models\Users;
use Illuminate\Support\Facades\DB;
// require 'vendor/autoload.php';
use Mailgun\Mailgun;


class ApiController extends Controller
{
    public function login(Request $request, $username, $password)
    {
        return DB::table('users')
                    ->where('username', $username)
                    ->where('ids', $password)
                    ->first();
    }

    public function kirimemail()
    {
        $mgClient = Mailgun::create("8f99afc01dec95103fbafa0996a55757-d51642fa-bcca730d", 'https://api.mailgun.net/v3/apps.smkn2semarang.sch.id');
        $domain = "apps.smkn2semarang.sch.id";
        # Make the call to the client.
        $result = $mgClient->messages()->send($domain, array(
            'from'	=> 'mailgun@apps.smkn2semarang.sch.id',
            'to'	=> 'masul.fauzi@smkn2semarang.sch.id',
            'subject' => 'Hello',
            'text'	=> 'Testing some Mailgun awesomness!'
        ));
    }

    
}
