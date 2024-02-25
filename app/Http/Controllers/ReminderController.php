<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\PoliModel;
use App\Models\ReminderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class ReminderController extends Controller
{
    public function index(Request $request) {
        $param['title'] = 'List Data Reminder';
        $query = ReminderModel::latest();
        if (Auth::user()->role == 'admin' || auth()->user()->role == 'petugas-rm'){
            $param['data'] = $query->where('user_id',Auth::user()->id)->paginate(10);
        }else{
            $param['data'] = $query->paginate(10);

        }
        return view('reminder.index',$param);

    }

    public function sendWhatsAppMessage()
    {
        try {
            $twilioSid = config('app.twilio_sid');
            $twilioToken = config('app.twilio_auth_token');
            $twilioWhatsAppNumber = config('app.twilio_whatsapp_number');
            $reminder = PeminjamanModel::with('pasien','user')->whereDate('tanggal_pengembalian','<',Carbon::today())->where('status_pengembalian','!=','sukses')->get();
            if (count($reminder) > 0) {
                foreach ($reminder as $key => $value) {
                    $poli = PoliModel::find($value->pasien->poli_id)->poli_name;
                    $update_status = PeminjamanModel::find($value->id);
                    $update_status->status_pengembalian = 'terlambat';
                    $update_status->update();
                    $recipientNumber = 'whatsapp:+'.$value->user->no_hp; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
                    $message = "RM".$value->pasien->no_rm." Dengan Nama ".$value->pasien->nama_pasien." pada poli ".$poli." untuk segera dikembalikan.";

                    $tambah_reminder = new ReminderModel;
                    $tambah_reminder->keterangan_reminder = $message;
                    $tambah_reminder->user_id = $value->user_id;
                    $tambah_reminder->save();

                    $twilio = new Client($twilioSid, $twilioToken);
                    $twilio->messages->create(
                        $recipientNumber,
                        [
                            "from" => 'whatsapp:'.$twilioWhatsAppNumber,
                            "body" => $message,
                        ]
                    );
                }
            }

            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
