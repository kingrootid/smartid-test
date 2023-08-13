<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function __construct()
    {
        if (!request()->ajax()) {
            exit('Not allowed direct access >.<');
        }
        Carbon::setLocale('id');
    }
    public function user()
    {
        $model = \App\Models\User::query()->where('is_admin', 0);
        return datatables()->of($model)->addIndexColumn()->editColumn('email', function ($row) {
            return obfuscate_email($row['email']);
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['email', 'action'])->make(true);
    }
    public function getUser($id)
    {
        return \App\Models\User::where('id', $id)->first();
    }
    public function klaster()
    {
        $model = \App\Models\MasterKlaster::query();
        return datatables()->of($model)->addIndexColumn()->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }
    public function getKlaster($id)
    {
        return \App\Models\MasterKlaster::where('id', $id)->first();
    }
    public function subKlaster()
    {
        $model = \App\Models\SubKlaster::query();
        return datatables()->of($model)->addIndexColumn()->editColumn('master_klaster_uuid', function ($row) {
            $data = \App\Models\MasterKlaster::where('uuid', $row['master_klaster_uuid'])->first();
            return empty($data) ? 'Data Master Klaster telah dihapus' : $data['name'];
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }
    public function getSubKlaster($id)
    {
        $subklaster = \App\Models\SubKlaster::where('id', $id)->first();
        $input = \App\Models\FormInputSubKlaster::where('sub_klaster_uuid', $subklaster['uuid'])->get();
        return ['subklaster' => $subklaster, 'input' => $input];
    }
    public function scheduleInput()
    {
        $model = \App\Models\ScheduleInput::query();
        return datatables()->of($model)->addIndexColumn()->editColumn('sub_klaster_uuid', function ($row) {
            $data = \App\Models\SubKlaster::where('uuid', $row['sub_klaster_uuid'])->first();
            return empty($data) ? 'Data Sub Klaster telah dihapus' : $data['name'];
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger mr-3' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-info' href='" . url('export/' . $row['uuid'] . '') . "'><i class='fa fa-file''></i></a>";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-success' href='" . url('export/show/' . $row['uuid'] . '') . "'><i class='fa fa-magnifying-glass''></i></a>";
            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }
    public function getScheduleInput($id)
    {
        return \App\Models\ScheduleInput::where('id', $id)->first();
    }
    public function getFormInputUUID($uuid)

    {
        return \App\Models\FormInputSubKlaster::where('sub_klaster_uuid', $uuid)->get();
    }
}
