<?php

namespace App\Http\Controllers;

use App\Models\FormInputSubKlaster;
use App\Models\MasterKlaster;
use App\Models\ScheduleInput;
use App\Models\SubKlaster;
use App\Models\User;
use App\Models\UserInput;
use App\Models\UserInputDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AjaxController extends Controller
{
    public function opd(Request $request)
    {
        try {
            if ($request['status'] == "add") {
                $validate = $this->validate($request, [
                    // 'status' => 'required|in:add,edit,delete',
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'sometimes'
                ], [
                    'status.required' => 'Mohon Hubungi Tim Pengembang',
                    'status.in' => 'Gagal Kode #1',
                    'name.required' => 'Anda belum menginputkan nama',
                    'email.required' => 'Anda belum menginputkan email',
                    // 'password.required' => 'Anda belum menginputkan password',
                ]);
                $validate['is_admin'] = 0;
                $validate['password'] = $validate['password'] ? Hash::make($validate['password']) : Hash::make('password');
                $insert = User::create($validate);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan OPD Baru');
                $message = "Berhasil Menambahkan OPD Baru";
            } else if ($request['status'] == "edit") {
                $validate = $this->validate($request, [
                    // 'status' => 'required|in:add,edit,delete',
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'sometimes'
                ], [
                    'status.required' => 'Mohon Hubungi Tim Pengembang',
                    'status.in' => 'Gagal Kode #1',
                    'name.required' => 'Anda belum menginputkan nama',
                    'email.required' => 'Anda belum menginputkan email',
                    // 'password.required' => 'Anda belum menginputkan password',
                ]);
                $getOld = User::where('id', $request['id'])->first();
                $validate['is_admin'] = 0;
                $validate['password'] = $validate['password'] ? Hash::make($validate['password']) : $getOld['password'];
                $update = User::where('id', $request['id'])->update($validate);
                if (!$update) throw new \ErrorException('Gagal Memperbaharui OPD');
                $message = "Berhasil Memperbaharui OPD";
            } else if ($request['status'] == "hapus") {
                $validate['is_admin'] = 0;
                $update = User::where('id', $request['id'])->delete();
                if (!$update) throw new \ErrorException('Gagal Menghapus OPD');
                $message = "Berhasil Menghapus OPD";
            } else {
                throw new \ErrorException('Aksi tidak ditemukan');
            }
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function klaster(Request $request)
    {
        try {
            if ($request['status'] == "add") {
                $validate = $this->validate($request, [
                    'name' => 'required',
                ], [
                    'name.required' => 'Anda belum menginputkan nama Master Klaster'
                ]);
                $validate['uuid'] = genUUID();
                $insert = MasterKlaster::create($validate);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Master Klaster Baru');
                $message = "Berhasil Menambahkan Master Klaster Baru";
            } else if ($request['status'] == "edit") {
                $validate = $this->validate($request, [
                    'name' => 'required',
                ], [
                    'name.required' => 'Anda belum menginputkan nama Master Klaster'
                ]);
                $update = MasterKlaster::where('id', $request['id'])->update($validate);
                if (!$update) throw new \ErrorException('Gagal Memperbaharui Master Klaster');
                $message = "Berhasil Memperbaharui Master Klaster";
            } else if ($request['status'] == "hapus") {
                $update = MasterKlaster::where('id', $request['id'])->delete();
                if (!$update) throw new \ErrorException('Gagal Menghapus Master Klaster');
                $message = "Berhasil Menghapus Master Klaster";
            } else {
                throw new \ErrorException('Aksi tidak ditemukan');
            }
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function subKlaster(Request $request)
    {

        DB::beginTransaction();
        try {
            if ($request['status'] == "add") {
                $validate = $this->validate($request, [
                    'name' => 'required',
                    'master_klaster_uuid' => 'required'
                ], [
                    'name.required' => 'Anda belum menginputkan Nama Sub Klaster',
                    'master_klaster_uuid.required' => 'Terjadi kesalahan'
                ]);
                $validate['uuid'] = genUUID();
                $validate['master_klaster_uuid'] = $request['master_klaster_uuid'];
                $insert = SubKlaster::create($validate);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Sub Klaster Baru');
                if (count($request['field']) > 1) {
                    foreach ($request['field'] as $field) {
                        $insertForm = FormInputSubKlaster::create([
                            'sub_klaster_uuid' => $insert['uuid'],
                            'label' => ucfirst(preg_replace('/[^a-zA-Z0-9]/', "_", $field)),
                            'name' => $field,
                        ]);
                        if (!$insertForm) throw new \ErrorException('Gagal Menambahkan Data Inputan');
                    }
                }
                $message = "Berhasil Menambahkan Sub Klaster Baru";
            } else if ($request['status'] == "edit") {
                $validate = $this->validate($request, [
                    'name' => 'required',
                    'master_klaster_uuid' => 'required'
                ], [
                    'name.required' => 'Anda belum menginputkan Nama Sub Klaster',
                    'master_klaster_uuid.required' => 'Terjadi kesalahan'
                ]);
                $getData = SubKlaster::where('id', $request['id'])->first();
                $update = SubKlaster::where('id', $request['id'])->update($validate);
                if (!$update) throw new \ErrorException('Gagal Menambahkan Sub Klaster Baru');
                foreach ($request['field'] as $field) {
                    $checkBefore = FormInputSubKlaster::where([
                        ['sub_klaster_uuid', $getData['uuid']],
                        ['name', $field]
                    ])->first();
                    if (!empty($checkBefore)) {
                        $updateForm = FormInputSubKlaster::where('id', $checkBefore['id'])->update([
                            'sub_klaster_uuid' => $getData['uuid'],
                            'label' => ucfirst(preg_replace('/[^a-zA-Z0-9]/', "_", $field)),
                            'name' => $field,
                        ]);
                        if (!$updateForm) throw new \ErrorException('Gagal Menambahkan Data Inputan');
                    } else {
                        $insertForm = FormInputSubKlaster::create([
                            'sub_klaster_uuid' => $getData['uuid'],
                            'label' => ucfirst(preg_replace('/[^a-zA-Z0-9]/', "_", $field)),
                            'name' => $field,
                        ]);
                        if (!$insertForm) throw new \ErrorException('Gagal Menambahkan Data Inputan');
                    }
                }
                if (isset($request['old'])) {
                    foreach ($request['old'] as $old) {
                        $checkBefore = FormInputSubKlaster::where([
                            ['sub_klaster_uuid', $getData['uuid']],
                            ['name', $old]
                        ])->delete();
                    }
                }
                if (!$update) throw new \ErrorException('Gagal Memperbaharui Sub Klaster');
                $message = "Berhasil Memperbaharui Sub Klaster";
            } else if ($request['status'] == "hapus") {
                $getData = SubKlaster::where('id', $request['id'])->first();
                $update = SubKlaster::where('id', $request['id'])->delete();
                $checkBefore = FormInputSubKlaster::where([
                    ['sub_klaster_uuid', $getData['uuid']],
                ])->delete();
                if (!$update) throw new \ErrorException('Gagal Menghapus Sub Klaster');
                $message = "Berhasil Menghapus Sub Klaster";
            } else {
                throw new \ErrorException('Aksi tidak ditemukan');
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
    public function scheduleInput(Request $request)
    {
        try {
            if ($request['status'] == "add") {
                $validate = $this->validate($request, [
                    'date_start' => 'required',
                    'date_end' => 'required'
                ], [
                    'date_start.required' => 'Anda belum menginputkan Tanggal Dimulai',
                    'date_end.required' => 'Anda belum menginputkan Tanggal Diakhiri',
                ]);
                $insert = ScheduleInput::create($validate);
                if (!$insert) throw new \ErrorException('Terjadi kesalahan saat Tambah Jadwal Input');
                $message = "Berhasil menambahkan Jadwal Input";
            } else if ($request['status'] == "edit") {
                $validate = $this->validate($request, [
                    'date_start' => 'required',
                    'date_end' => 'required'
                ], [
                    'date_start.required' => 'Anda belum menginputkan Tanggal Dimulai',
                    'date_end.required' => 'Anda belum menginputkan Tanggal Diakhiri',
                ]);
                $insert = ScheduleInput::where('id', $request['id'])->update($validate);
                if (!$insert) throw new \ErrorException('Terjadi kesalahan saat Merubah Jadwal Input');
                $message = "Berhasil Merubah Jadwal Input";
            } else if ($request['status'] == "hapus") {
                $validate = $this->validate($request, [
                    'date_start' => 'required',
                    'date_end' => 'required'
                ], [
                    'date_start.required' => 'Anda belum menginputkan Tanggal Dimulai',
                    'date_end.required' => 'Anda belum menginputkan Tanggal Diakhiri',
                ]);
                $insert = ScheduleInput::where('id', $request['id'])->delete();
                if (!$insert) throw new \ErrorException('Terjadi kesalahan saat Menghapus Jadwal Input');
                $message = "Berhasil Menghapus Jadwal Input";
            }
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
    public function userInput(Request $request)
    {
        DB::beginTransaction();
        try {

            $getInput = FormInputSubKlaster::where('sub_klaster_uuid', $request['sub_klaster_uuid'])->get();
            $uuid = genUUID();
            UserInput::create([
                'uuid' => $uuid,
                'user_id' => auth()->user()->id,
                'sub_klaster_uuid' => $request['sub_klaster_uuid']
            ]);
            foreach ($getInput as $check) {
                if (empty($request[$check['name']])) {
                    throw new \ErrorException('Anda belum mengisi kolom ' . $check['label']);
                } else {
                    UserInputDetail::create([
                        'user_input_uuid' => $uuid,
                        'label' => $check['label'],
                        'value' => $request[$check['name']]
                    ]);
                }
            }
            $message = "Berhasil mengisi";
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
}
