<?php

use App\Models\FormInputSubKlaster;
use App\Models\ScheduleInput;
use App\Models\User;
use App\Models\UserInput;
use App\Models\UserInputDetail;
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
        return \App\Models\SubKlaster::where('master_klaster_uuid', $uuid)->get();
    }
}
if (!function_exists('getInputData')) {
    function countInputData($subKlasterUuid)
    {
        $getData = FormInputSubKlaster::where('sub_klaster_uuid', $subKlasterUuid)->count();
        return $getData;
    }
}
if (!function_exists('getInputData')) {
    function countFormInput($subKlasterUuid, $scheduleUuid)
    {
        $getData = UserInput::where([
            ['sub_klaster_uuid', $subKlasterUuid],
            ['user_id', auth()->user()->id],
            ['schedule_input_uuid', $scheduleUuid]
        ])->count();
        return $getData;
    }
}
if (!function_exists('render_button_shortcut')) {
    function render_button_shortcut($uuid)
    {
        $carbon = Carbon::now()->format('Y-m-d');
        $data = DB::table('schedule')->where('id', $uuid)->count();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getInputUser')) {
    function getInputUser($uuid, $subkUuid)
    {
        $dataNew = [];
        $userInput = UserInput::where([
            ['schedule_input_uuid', $uuid],
            ['sub_klaster_uuid', $subkUuid]
        ])->get();
        foreach ($userInput as $ui) {
            $getUser = User::where('id', $ui['user_id'])->first();
            $getDetail = UserInputDetail::where([
                ['user_input_uuid', $ui['uuid']],
            ])->get();
            $labelValue = "<ul>";
            foreach ($getDetail as $gd) {
                $label = $gd['label'];
                $value = $gd['value'];
                $labelValue .= "<li><b>$label</b> : $value</li>";
            }
            $labelValue .= "</ul>";
            array_push($dataNew, array(
                'id' => $ui['id'],
                'user' => $getUser ? $getUser['name'] : 'User Sudah Dihapus',
                'label' => $labelValue
            ));
        }
        return $dataNew;
    }
}
