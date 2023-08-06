<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('checkAdminLogin')) {
    function checkAdminLogin()
    {
        $user = auth()->user()->is_admin;
        if (!$user) {
            return redirect('dashboard');
        }
    }
}
if (!function_exists('obfuscate_email')) {
    function obfuscate_email($email)
    {
        $em   = explode("@", $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len  = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
}
if (!function_exists('genUUID')) {
    function genUUID()
    {
        return Str::uuid();
    }
}
if (!function_exists('getSubKlasterData')) {
    function getSubKlasterData($uuid)
    {
        return \App\Models\SubKlaster::where('uuid', $uuid)->first();
    }
}
if (!function_exists('render_button_shortcut')) {
    function render_button_shortcut($uuid)
    {
        $carbon = Carbon::now()->format('Y-m-d');
        $data = DB::statement("SELECT * FROM schedule_inputs WHERE sub_klaster_uuid = '$uuid' AND '$carbon' BETWEEN date_start AND date_end LIMIT 1");
        if (empty($data)) {
            return false;
        } else {
            return true;
        }
    }
}
