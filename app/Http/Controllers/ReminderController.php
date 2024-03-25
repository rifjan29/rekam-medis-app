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
            $reminder = PeminjamanModel::with('pasien','user')->whereDate('tanggal_pengembalian','<',Carbon::today())->where('status_pengembalian','!=','sukses')->get();
            if (count($reminder) > 0) {
                foreach ($reminder as $key => $value) {
                    if ($value->unit == 'rawat-inap') {
                        $poli = $value->kamar;
                    }else{
                        $poli = PoliModel::find($value->poli_id)->poli_name;
                    }
                    $update_status = PeminjamanModel::find($value->id);
                    $update_status->status_pengembalian = 'terlambat';
                    $update_status->update();
                    $recipientNumber = $value->user->no_hp; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
                    $message = "RM".$value->pasien->no_rm." Dengan Nama ".$value->pasien->nama_pasien." untuk segera dikembalikan.";

                    $tambah_reminder = new ReminderModel;
                    $tambah_reminder->keterangan_reminder = $message;
                    $tambah_reminder->user_id = $value->user_id;
                    $tambah_reminder->save();

                    // $twilio = new Client($twilioSid, $twilioToken);
                    // $twilio->messages->create("whatsapp:+6289516325685",
                    //     [
                    //         "from" => 'whatsapp:'.$twilioWhatsAppNumber,
                    //         "body" => $message,
                    //     ]
                    // );
                     $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                    'target' => $recipientNumber,
                    'message' => $message, 
                    'countryCode' => '62', //optional
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: TtVrUiuoYKgYU!GvS+df' //change TOKEN to your actual token
                    ),
                    ));

                    $response = curl_exec($curl);
                    if (curl_errno($curl)) {
                    $error_msg = curl_error($curl);
                    }
                    curl_close($curl);

                    if (isset($error_msg)) {
                    echo $error_msg;
                    }
                    echo $response;
                }
            }

            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
