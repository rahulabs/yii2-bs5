<?php


namespace common\models;

use Yii;
use yii\base\Model;

class Library extends Model
{
    public $parties = [
        'DEM' => 'Democratic',
        'GRE' => 'Green',
        'LIB' => 'Libertarian',
        'REP' => 'Republican',
        'UNA' => 'Unaffiliated',
    ];

    public function getVoterInfo($data)
    {
        if (!$data) {
            return '';
        }
        $html = '<p>'. $data['first_name'].' '.$data['middle_name'].' '.$data['last_name'].' '.$data['name_suffix_lbl'].'</p>';
        $html .= '<p>'. $data['res_street_address'].'</p>';
        $html .= '<p>'. $data['res_city_desc'].', '. $data['state_cd'].' '.$data['zip_code'].'</p><br/>';
        $html .= '<p class="text-uppercase">'. $this->parties[$data['party_cd']] ?? null.'</p><br/>';
        $html .= '<p class="text-uppercase">'. $data['county_desc'].' county</p>';
        $html .= '<p class="text-uppercase">Precinct: '. $data['precinct_desc'].'</p>';
        return $html;
    }

    /**
     * Send email
     * @param $to_email string|array
     * @param $message string
     * @param $subject string
     * @return bool
     */
    public function sendEmail($to_email, string $message, string $subject): bool
    {
        return Yii::$app->mailer->compose()->setFrom([Yii::$app->params['adminEmail'] => config_name])
            ->setTo($to_email)
            ->setHtmlBody($message)
            ->setSubject($subject)->send();
    }

    /**
     * Send email
     * @param $address string
     * @return array
     */
    public function getDataFromAddress($address)
    {
        $response = [];
        $api_key = Yii::$app->params['google_api_key'];
        $query_array = [
            'address' => $address,
            'sensor' => 'false',
            'key' => $api_key
        ];
        $query = http_build_query($query_array);
        $link = 'https://maps.googleapis.com/maps/api/geocode/json?'.$query;
        $geocode = file_get_contents($link);
        $output= json_decode($geocode,true);

        if ($output['results']) {
            $response['latitude'] = $output['results'][0]['geometry']['location']['lat'] ?? null;
            $response['longitude'] = $output['results'][0]['geometry']['location']['lng'] ?? null;
            $response['all_info'] = serialize($output);
        }

        return $response;
    }

    public function getTimeSlot($start_time,$end_time,$interval=7200){
        $i=0;
        $time = [];
        while($start_time <= $end_time){
            $start = date('h:iA',$start_time);
            $end = date('h:iA',($start_time+$interval));
            $start_time = $start_time+$interval;
            $i++;
            if($start_time <= $end_time){
                $time[$i]['start_time'] = $start;
                $time[$i]['end_time'] = $end;
            }
        }
        return $time;
    }
}