<?php

namespace App\Http\Controllers;

use App\Models\MasterKlaster;
use App\Models\ScheduleInput;
use App\Models\SubKlaster;
use App\Models\User;
use App\Models\UserInput;
use App\Models\UserInputDetail;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export($uuid)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);
        $getInfoData = ScheduleInput::where('uuid', $uuid)->first();
        $masterKlaster = MasterKlaster::get();
        $section = $phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        $start = 1;
        $row_start = 2;
        $rows = 3;
        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );
        $section->addText(htmlspecialchars('Input Data User'), $header);
        foreach ($masterKlaster as $mk) {
            $section->addText($mk['name']);
            $subKlaster = SubKlaster::where('master_klaster_uuid', $mk['uuid'])->get();
            foreach ($subKlaster as $sk) {
                $section->addText($sk['name']);
                $userInput = UserInput::where('sub_klaster_uuid', $sk['uuid']);
                $cols = $userInput->count();
                $firstRowStyle = array('bgColor' => '66BBFF');
                $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
                $table = $section->addTable('myTable');
                $table->addRow();
                $table->addCell(1750)->addText('No');
                $table->addCell(1750)->addText('Nama User');
                $table->addCell(1750)->addText('Input');
                for ($d = 0; $d < $cols; $d++) {
                    $table->addRow();
                    foreach ($userInput->get() as $input) {
                        $user = User::where('id', $input['user_id'])->first();
                        $inputan = UserInputDetail::where('user_input_uuid', $input['uuid'])->get();
                        $html = "<ul>";
                        $html .= "</ul>";
                        $table->addCell(1750)->addText(htmlspecialchars($start));
                        $table->addCell(1750)->addText(htmlspecialchars($user['name']));
                        $text = "Inputan : ";
                        foreach ($inputan as $dInput) {
                            $text .= "<w:br/>Label : " . $dInput['label'] . " Value : " . $dInput['value'] . "<w:br/>";
                        }
                        $table->addCell(20000)->addText($text);
                        $start++;
                    }
                }
            }
        }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (\Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }
    public function show($uuid)
    {
        $dataSchedule = ScheduleInput::where('uuid', $uuid)->first();
        if (!$dataSchedule) {
            return back();
        } else {
            checkAdminLogin();
            $data = [
                'page' => 'Data Penginputan',
                'user' => auth()->user(),
                'masterKlaster' => MasterKlaster::get(),
                'schedule' => $dataSchedule
            ];
            return view('admin.input', $data);
        }
    }
}
