<?php

namespace App\Http\Controllers;

use App\Models\FormInputSubKlaster;
use App\Models\MasterKlaster;
use App\Models\ScheduleInput;
use App\Models\SubKlaster;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'page' => 'Dashboard',
            'user' => auth()->user(),
            'schedules' => ScheduleInput::all()
        ];
        return view('dashboard', $data);
    }
    public function adminOpd()
    {
        checkAdminLogin();
        $data = [
            'page' => 'Data OPD',
            'user' => auth()->user()
        ];
        return view('admin.opd', $data);
    }
    public function masterKlaster()
    {
        checkAdminLogin();
        $data = [
            'page' => 'Data Master Klaster',
            'user' => auth()->user()
        ];
        return view('admin.master.klaster', $data);
    }
    public function masterSubKlaster()
    {
        checkAdminLogin();
        $data = [
            'page' => 'Data Sub Klaster',
            'user' => auth()->user(),
            'klaster' => MasterKlaster::all()
        ];
        return view('admin.master.sub_klaster', $data);
    }
    public function adminSchedule()
    {
        checkAdminLogin();
        $data = [
            'page' => 'Data Schedule Pengisian',
            'user' => auth()->user(),
            'subklaster' => SubKlaster::all()
        ];
        return view('admin.schedule', $data);
    }
    public function pengisian($uuid)
    {
        $dataSubKlaster = getSubKlasterData($uuid);
        if (!$dataSubKlaster) {
            return back();
        } else {
            $data = [
                'page' => 'Pengisian',
                'user' => auth()->user(),
                'masterKlaster' => MasterKlaster::where('uuid', $dataSubKlaster['master_klaster_uuid'])->first(),
                'subKlaster' => $dataSubKlaster,
                'inputan' => FormInputSubKlaster::where('sub_klaster_uuid', $uuid)->get()
            ];
            return view('pengisian', $data);
        }
    }
}
