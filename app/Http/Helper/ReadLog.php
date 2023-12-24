<?php

namespace App\Http\Helper;

use DateTime;
use SplFileObject;
use App\Models\Log\Log;
use FilesystemIterator;
use App\models\VirtualDj;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class ReadLog
{
    private static $data = [];
    private static $JazlerRecs = [];

    public static function player($type = null)
    {
        switch ($type) {
            case 'virtualdj':
                return self::VirtualDJ();
                break;
            case 'jazler':
                return self::Jazler();
                break;
            default:
                # code...
                break;
        }
    }

    public static function VirtualDJ($data_reset = null)
    {
        if ($data_reset) {
            self::$data = [];
            return;
        } else {

            $filepath = env('VIRTUAL_DJ');
            copy($filepath, public_path('/adverts/uploads/tracklist.txt'));

            $files = new FilesystemIterator(public_path('/adverts/uploads/'), FilesystemIterator::UNIX_PATHS);

            $GLOBALS['logDate'] = '';

            foreach ($files as $file) {
                // pick tracklist file from virtual dj
                if ($file->getFilename() === 'tracklist.txt') {
                    $open = $file->openFile('r+');
                    $open->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);
                    foreach ($open as $line) {
                        if ($line) {
                            $rec =  self::VirtualDjProcessLine(trim($line[0]));
                            if ($rec) {
                                array_push(self::$data, $rec);
                                unset($rec);
                            }
                        }
                        unset($line);
                    }
                    // clean the tracklist file
                    fopen($file, 'w');
                    return self::$data;
                }
                unset($file);
            }
        }
    }

    private static function VirtualDjProcessLine($line)
    {
        $string = preg_replace('/[^\p{L}\p{N}]/u', '', $line);
        $datep = substr($string, 0, 16);
        if ($datep == "VirtualDJHistory") {
            $GLOBALS['logDate'] = substr($line, -10);
        } elseif ($line == "------------------------------") {
        } else {
            $name = substr_replace($line, "", 0, 8);
            if ($name != "") {
                $time = substr($line, 0, 5);
                $dbdate = new DateTime($GLOBALS['logDate']);
                $dddate = $dbdate->format('Y-m-d');
                return ['name' => $name, 'date_played' => $dddate, 'time_played' => $time];
            }
        }
    }
    // Jazler
    public static function Jazler($data_reset = null)
    {
        if ($data_reset) {
            self::$JazlerRecs = [];
            return;
        } else {

            $filepath = env('JAZLER');
            $files = new FilesystemIterator($filepath, FilesystemIterator::UNIX_PATHS);

            $GLOBALS['logDate'] = '';
            $FileNames = [];
            foreach ($files as $file) {
                // pick tracklist file from virtual dj
                if ($file->getFilename()) {
                    // get date from the file name
                    $DateFromFile = substr($file->getFilename(), 0, -4);
                    $dbdate = new DateTime($DateFromFile);
                    // $dddate = $dbdate->format('Y-m-d');

                    $open = $file->openFile('r+');
                    $open->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);
                    foreach ($open as $line) {
                        if ($line) {

                            $data = explode('\\', current($line));

                            if(count($data) > 1) {
                                $newDateTime = new DateTime(substr($data[0], 0, 7));

                                $date = $dbdate->format('d-m-Y');
                                // $time = $newDateTime->format('H:i:s');
                                // $time = substr($data[0], 0, 7);
                                $time = date('h:i:s A', strtotime(substr($data[0], 0, 7)));
                                $name = substr(end($data), 0, -4);
                                $name = substr($name, 0, 45);

                                // if($time == '08:13:05 PM') {

                                //     dd($name . ' - ' . $time);
                                // }
                                array_push(self::$JazlerRecs,
                                    (object) ['name' => $name, 'date_played' => $date, 'time_played' => $time, 'created_at' => Carbon::now()]
                                );

                                try {
                                    $rec = Log::where('name', $name)->where('date_played', $date)->where('time_played', $time)->first();
                                    dd($rec);
                                    if(!$rec->first()) {

                                        DB::table('logs')->insertOrIgnore(
                                            ['name' => $name, 'date_played' => $date, 'time_played' => $time]
                                        );
                                    }

                                } catch (\Throwable $th) {
                                    // dd($th);
                                }
                            }
                        }

                    }
                    // clean the tracklist file
                    // fopen($file, 'w');
                    // if is only one file
                    // return self::$JazlerRecs;
                    // dd(self::$JazlerRecs);
                    // Log::insert(self::$JazlerRecs);

                    // dd(self::$JazlerRecs);

                    // $path = public_path('adverts/reports');
                    // $fileN = $dbdate->format('Y-m-d');
                    // $pdf = PDF::loadView('reports.media', ['logs' => self::$JazlerRecs, 'searchText' => $fileN]);
                    // $fileName =  $fileN . '_' . 'Log.pdf';

                    // $pdf->save($path . '/' . $fileName);
                    // self::$JazlerRecs = [];
                }
                // unset($file);
            }
            return self::$JazlerRecs;
        }
    }
}
