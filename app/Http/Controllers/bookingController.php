<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class bookingController extends Controller
{
    public function index()
    {
        $rm = Room::all();
        // return view('dashboard',['rm'=>$rm]);
        return redirect('/detail/1');
    }

    public function detail(Request $request , $id)
    {
        // dd('ada');
        $rm = Room::where('id',$id)->first();
        $date_now = explode(' ',Carbon::now()->format('Y m d'));
        $dm1 = cal_days_in_month(CAL_GREGORIAN,$date_now[1],$date_now[0]);
        // $date_now[1] == 12 ? $dm2 = cal_days_in_month(CAL_GREGORIAN,1,$date_now[0]+1) : $dm2 = cal_days_in_month(CAL_GREGORIAN,$date_now[1]+1,$date_now[0]);
        if ($date_now[1] == 12) {
            $bln = 1;
            $thn = $date_now[0]+1;
        } else {
            $bln = $date_now[1]+1;
            $thn = $date_now[0];
        }
        return view('room',['dm1'=>$dm1,'bln'=>$bln,'thn'=>$thn,'d'=>$date_now[2],'m'=>$date_now[1],'y'=>$date_now[0],'rm'=>$rm]);
    }
    public function seeBook($id,$tgl)
    {
        $tgl = Crypt::decrypt($tgl);

        $bookers = Booking::where(['room_id'=>$id,'tanggal'=>date_create($tgl)])->get();
        return view('bookers',['bk'=>$bookers]);
    }
    public function booking($id,$tgl)
    {

            $tgl = Crypt::decrypt($tgl);

        return view('booking',['rm'=>$id,'tgl'=>$tgl]);
    }
    public function bookingPost(Request $request)
    {

        $users = DB::table('users')
                ->where('id', '=', Auth::id())->first();
                // dd($users);
        booking::create([
            'name'=>$users->name,
            'nis'=>$users->nis,
            'kelas'=>$users->kelas,
            'user_id'=>Auth::id(),
            'tanggal'=>date_create($request->tanggal),
            'room_id'=>$request->id
        ]);
        User::where('id', Auth::id())->update(
            [
                'token'=>Auth::user()->token - 1
            ]
            );
        return redirect()->route('seeBook',['id'=>$request->id,'tgl'=>Crypt::encrypt($request->tanggal)])->with(['status'=>'You has been booked !']);

    }

    public function add_room()
    {
        return view('add_room');
        // return redirect('/detail/3');

    }

    public function roomPost(Request $request)
    {
        Room::create([
            'name'=>$request->name,
            'limit'=>$request->limit,
        ]);
        return redirect()->back()->with(['status'=>'Room has been created !']);

    }
}
