<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UpdateController extends Controller
{

    public function get_status()
    {
        $get = DB::table('admin_set')->where('id', 1)->first();
        return $get->status;
    }

    public function led_on($code, $led_no, $change = 'n', $status = '0')
    {
        if ($change == 'y') {
            $db = DB::table('tbl_led')
                ->where('code', $code)
                ->where('led_num', $led_no)->update(['status' => $status]);
        }
        $db = DB::table('tbl_led')
            ->where('code', $code)
            ->where('led_num', $led_no)->first();
        return $db->status == '1' ? 'on' : 'off';
    }

    public function sensordata(Request $request)
    {
        $lim = $request->query()['limit'] ?? null;
        if ($lim) {
            $data = DB::table('tbl_temperature')->limit($lim)
                ->orderBy('created_date', 'desc')->get();
        } else {
            $data = DB::table('tbl_temperature')
                ->orderBy('created_date', 'desc')->get();
        }
        return $data;
    }

    public function generate_token()
    {
        $hour = date('H');
        if ($hour > 12 && $hour < 20) {
            $groups = Group::where('parent_id', '=', null)->get();

            foreach ($groups as $group) {
                $accountId = $group->account_id;
                $clientId = $group->client_id;
                $clientSecret = $group->client_secret;

                $oauthUrl = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId;
                try {
                    $authHeader = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);
                    $ch = curl_init($oauthUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $authHeader));
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200) {
                        $parent = Group::find($group->id);
                        $parent->api = json_decode($response)->access_token;
                        $parent->save();
                        foreach ($group->children as $child) {
                            $get = Group::find($child->id);
                            $get->api = json_decode($response)->access_token;
                            $get->save();
                        }
                    } else return redirect()->back()->with('error', 'API калитлар билан боғлиқ қандайдир муаммолар мавжуд!');
                } catch (Exception $e) {
                    return redirect()->back()->with('error', 'API калитларни янгилаб бўлмади!');
                }
            }

            $botApi = '5684948299:AAHa3NhGYHfxVcXemExopbJYPDEOG-3ytuw';
            $data_telegram = [
                'chat_id' => 310857127,
                'text' => '🔑 <b>Токен ўзгартирилди!</b>',
                'parse_mode' => 'html'
            ];
            $context = stream_context_create(['http' => ['ignore_errors' => true]]);
//            file_get_contents("https://api.telegram.org/bot$botApi/sendMessage?" . http_build_query($data_telegram), false, $context);

            return json_encode(['status' => 'OK']);
        }
    }

    public function generate_token_now()
    {

        $groups = Group::where('parent_id', '=', null)->get();

        foreach ($groups as $group) {
            $accountId = $group->account_id;
            $clientId = $group->client_id;
            $clientSecret = $group->client_secret;

            $oauthUrl = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId;
            try {
                $authHeader = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);
                $ch = curl_init($oauthUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $authHeader));
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode == 200) {
                    $parent = Group::find($group->id);
                    $parent->api = json_decode($response)->access_token;
                    $parent->save();
                    foreach ($group->children as $child) {
                        $get = Group::find($child->id);
                        $get->api = json_decode($response)->access_token;
                        $get->save();
                    }
                } else return redirect()->back()->with('error', 'API калитлар билан боғлиқ қандайдир муаммолар мавжуд!');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'API калитларни янгилаб бўлмади!');
            }
        }

        $botApi = '5684948299:AAHa3NhGYHfxVcXemExopbJYPDEOG-3ytuw';
        $data_telegram = [
            'chat_id' => 310857127,
            'text' => '🔑 <b>Токен ўзгартирилди!</b>',
            'parse_mode' => 'html'
        ];
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        file_get_contents("https://api.telegram.org/bot$botApi/sendMessage?" . http_build_query($data_telegram), false, $context);

        return json_encode(['status' => 'OK']);
    }
}
