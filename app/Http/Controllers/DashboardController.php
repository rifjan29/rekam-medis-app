<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\RekamMedisModel;
use App\Models\ReminderModel;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $param['total_medis'] = RekamMedisModel::count();
        $param['total_user'] = User::count();
        $param['total_data_peminjaman'] = PeminjamanModel::count();
        $param['total_peminjaman'] = PeminjamanModel::select('status_pengembalian',DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
                                    ,DB::raw("(count(id)) as total_data"))
                                    ->orderBy('created_at')
                                    ->where('status_pengembalian','sukses')
                                    ->groupBy('month','status_pengembalian')
                                    ->get();
        $param['total_terlambat'] = PeminjamanModel::select('status_pengembalian',DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
                                    ,DB::raw("(count(id)) as total_data"))
                                    ->where('status_pengembalian','terlambat')
                                    ->orderBy('created_at')
                                    ->groupBy('month','status_pengembalian')
                                    ->get();

        // Get the current date
        $currentDate = Carbon::now();

        $startDate = $currentDate->startOfMonth();

        // Set the end date to one year from the current date
        $endDate = $currentDate->copy()->addYear()->endOfMonth();

        $param['period'] = CarbonPeriod::create($startDate, '1 month', $endDate);
        $param['total_reminder'] = ReminderModel::count();
        return view('dashboard',$param);
    }
}
