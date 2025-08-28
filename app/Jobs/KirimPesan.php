<?php

namespace App\Jobs;

use App\Modules\Device\Models\Device;
use App\Modules\FilePesan\Models\FilePesan;
use App\Modules\Pesan\Models\Pesan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KirimPesan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pesan = Pesan::whereStatus(0)->orderBy('created_at', 'asc')->limit(1)->get();

        foreach ($pesan as $kirim) {
            $device = Device::orderBy('last_used', 'asc')->first();

            if ($kirim->id_file != null) {

                $file = FilePesan::find($kirim->id_file);


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'appkey' => $device->app_key,
                        'authkey' => $device->auth_key,
                        'to' => $kirim->nomor,
                        'message' => $kirim->isi_pesan,
                        'file' => 'https://apps.smkn2semarang.sch.id/file_pesan/' . $file->nama_file,
                        'sandbox' => 'false'
                    ),
                ));

                $response = json_decode(curl_exec($curl));

                curl_close($curl);
                // echo $response;
            } else {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                            'appkey' => $device->app_key,
                            'authkey' => $device->auth_key,
                            'to' => $kirim->nomor,
                            'message' => $kirim->isi_pesan,
                            'sandbox' => 'false'
                        ),
                ));

                $response = json_decode(curl_exec($curl));

                curl_close($curl);
                // echo $response;
            }




            if (isset($response->message_status) && ($response->message_status == 'Success')) {
                $update = Pesan::find($kirim->id);
                $update->status = 1;
                $update->save();
            }

            if (isset($response->error) && ($response->error == 'Request Failed')) {
                $update = Pesan::find($kirim->id);
                $update->created_at = date('Y-m-d H:i:s');
                $update->save();
                // dd($update);
            }

            $update_device = Device::find($device->id);
            $update_device->last_used = date('Y-m-d H:i:s');
            $update_device->save();
        }
    }
}
