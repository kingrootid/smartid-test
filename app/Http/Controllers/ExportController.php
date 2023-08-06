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
        $getInfoData = ScheduleInput::where('sub_klaster_uuid', $uuid)->first();
        $userInput = UserInput::where('sub_klaster_uuid', $uuid);
        $subKlaster = SubKlaster::where('uuid', $uuid)->first();
        $masterKlaster = MasterKlaster::where('uuid', $subKlaster['master_klaster_uuid'])->first();
        $section = $phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        $start = 1;
        $row_start = 2;
        $rows = 3;
        $cols = $userInput->count();
        $section->addText(htmlspecialchars('Input Data User'), $header);
        $section->addText($masterKlaster['name']);
        $section->addText($subKlaster['name']);
        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );
        $firstRowStyle = array('bgColor' => '66BBFF');
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section->addTable('myTable');
        $table->addRow();
        $table->addCell(1750)->addText('No');
        $table->addCell(1750)->addText('Nama User');
        $table->addCell(1750)->addText('Input');
        for ($d = 0; $d < $rows; $d++) {
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
        // $rows = 10;
        // $cols = 5;
        // $section->addText(htmlspecialchars('Basic table'), $header);

        // $table = $section->addTable();
        // for ($r = 1; $r <= $userInput->count(); $r++) {
        //     $table->addRow();
        //     for ($c = 1; $c <= 3; $c++) {
        //         $user = User::where('id', $input['user_id'])->first();
        //         $inputan = UserInputDetail::where('user_input_uuid', $input['uuid'])->get();
        //         $html = "<ul>";
        //         foreach ($inputan as $dInput) {
        //             $html .= "<li>Label : " . $dInput['label'] . " Value : " . $dInput['value'] . "</li>";
        //         }
        //         $html .= "</ul>";
        //         $table->addCell("A$row_start", $start);
        //         $table->addCell("B$row_start", $user['name']);
        //         $table->addCell("C$row_start", $html);
        //         $table->addCell(1750)->addText(htmlspecialchars("Row {$r}, Cell {$c}"));
        //     }
        // }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (\Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }
}
