<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Checks if user is authorized to access
     *
     * ModeratorController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now()->subDay()->format('d.m.Y');
        $query = Apartment::thisYear()
            ->selectRaw('MONTH(created_at) as month, count(id) as number')
            ->groupBY('month')
            ->get();


        return view('admin.report', ['range' => $query->pluck('month'), 'number' => $query->pluck('number'), 'dateStart'=>$date, 'dateEnd'=>$date, 'data'=>"Apartment", 'rangeType'=>"YEAR"]);
    }

    /**
     * Filter the data shown in graph.
     *
     * @param Request $request
     */
    public function graphFilter(Request $request)
    {
        $rangeType = $request->range;
        $data = $request->data;
        $dateEnd="";
        $operator="AND";


        for ($i=0;$i<strlen($request->daterange);$i++){
            $dateEnd .= $request->daterange[$i];
                if ($i == 9){
                    $dateStart=$dateEnd;
                    $dateEnd = "";
                    $i= $i+3;
                }
        }


        $passDateEnd = $dateEnd;
        $passDateStart = $dateStart;
        $dateEnd = Carbon::createFromFormat('d.m.Y', $dateEnd)->toDateString();
        $dateStart = Carbon::createFromFormat('d.m.Y', $dateStart)->toDateString();

        if($rangeType == "YEAR"){
            if ($dateEnd[0].$dateEnd[1].$dateEnd[2].$dateEnd[3] < $dateStart[0].$dateStart[1].$dateStart[2].$dateStart[3]){
                $operator="OR";
            }
        }elseif ($rangeType == "MONTH"){
            if ($dateEnd[5].$dateEnd[6] < $dateStart[5].$dateStart[6]){
                $operator="OR";
            }
        }else{
            if ($dateEnd[8].$dateEnd[9] < $dateStart[8].$dateStart[9]){
                $operator="OR";
            }
        }

        if ($data == "Apartment") {
            $query = Apartment::selectRaw('' . $rangeType . '(created_at) as type, count(id) as number')
                ->where('created_at', '>=', ''.$dateStart.'')
                ->where('created_at', '<=', ''.$dateEnd.'')
                ->whereRaw(''.$rangeType.'(created_at) >= '.$rangeType.'("'.$dateStart.'") '.$operator.' '.$rangeType.'(created_at) <= '.$rangeType.'("'.$dateEnd.'")')
                ->groupBY('type')
                ->get();
        } else {
            $query = User::selectRaw('' . $rangeType . '(created_at) as type, count(id) as number')
                ->where('created_at', '>=', ''.$dateStart.'')
                ->where('created_at', '<=', ''.$dateEnd.'')
                ->whereRaw(''.$rangeType.'(created_at) >= '.$rangeType.'("'.$dateStart.'") '.$operator.' '.$rangeType.'(created_at) <= '.$rangeType.'("'.$dateEnd.'")')
                ->groupBY('type')
                ->get();
        }


        /*$range = Apartment::selectRaw(''.$rangeType.'(created_at) as type, count(id) as number')
                    ->where('created_at', '>=', ''.$dateStart.'')
                    ->where('created_at', '<=', ''.$dateEnd.'')
                    ->groupBY('type')
                    ->pluck('type');*/

        return view('admin.report', ['range'=>$query->pluck('type'), 'number'=>$query->pluck('number'), 'dateStart'=>$passDateStart, 'dateEnd'=>$passDateEnd, 'data'=>$data, 'rangeType'=>$rangeType]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
