<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class ApiController extends Controller
{
    private $clientId, $clientSecret, $redirectUri, $code, $accessToken, $refreshToken;

    public function __construct()
    {
        $this->clientId = env('MENV_CLIENT_ID');
        $this->clientSecret = env('MENV_CLIENT_SECRET');
        $this->redirectUri = env('MENV_REDIRECT_URI');
        $this->code = env('MENV_CODE');
        $this->accessToken = env('MENV_ACCESS_TOKEN');
        $this->refreshToken = env('MENV_REFRESH_TOKEN');
    }

    public function getToken()
    {
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.melhorenvio.com.br/oauth/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('grant_type' => 'authorization_code','client_id' => $this->clientId,'client_secret' => $this->clientSecret,'redirect_uri' => $this->redirectUri,'code' => $this->code),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'User-Agent: Teste API (sara.novaalianca@gmail.com)'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);


    }

    public function sendLoja()
    {
        $return = [];
        $tmp_name = $_FILES['csv']["tmp_name"];

        if (($handle = fopen($tmp_name, "r")) !== FALSE) {
            $csvs = [];
            while(! feof($handle)) {
               $csvs[] = fgetcsv($handle);
            }
            
            $obj = new stdClass();
            for($i = 1; $i < count($csvs); $i++){
                $obj->$i = [ 
                    $csvs[0][0] => array_key_exists(0, $csvs[$i]) ? $csvs[$i][0] : $i, 
                    $csvs[0][1] => array_key_exists(1, $csvs[$i]) ? $csvs[$i][1] : $i, 
                    $csvs[0][2] => array_key_exists(2, $csvs[$i]) ? $csvs[$i][2] : $i
                ];
            }

            foreach($obj as $json){
                $jsonString = json_encode($json);

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.melhorenvio.com.br/api/v2/me/companies',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $jsonString,
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Content-type: application/json',
                        'Authorization: Bearer ' . $this->accessToken,
                        'User-Agent: Teste API (sara.novaalianca@gmail.com)'
                    ),
                ));

                $response = curl_exec($curl);
                
                $response = json_decode($response);
                if(isset($response->message)){
                    $return[] = $response;
                }

                curl_close($curl);
            }
        }

        return view('welcome', ["return" => $return]);
    }

    public function getLojas()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.melhorenvio.com.br/api/v2/me/companies',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 20,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer ' . $this->accessToken,
                'User-Agent: Teste API (sara.novaalianca@gmail.com)'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return view('welcome', ["lojas" => $response]);
    }

    public function sendEndereco()
    {
        $store_id = $_POST['storeId'];
        $return = [];
        $tmp_name = $_FILES['csv']["tmp_name"];

        if (($handle = fopen($tmp_name, "r")) !== FALSE) {
            $csvs = [];
            while(! feof($handle)) {
               $csvs[] = fgetcsv($handle);
            }
            
            $obj = new stdClass();
            for($i = 1; $i < count($csvs); $i++){
                $obj->$i = [ 
                    $csvs[0][0] => array_key_exists(0, $csvs[$i]) ? $csvs[$i][0] : $i, 
                    $csvs[0][1] => array_key_exists(1, $csvs[$i]) ? $csvs[$i][1] : $i, 
                    $csvs[0][2] => array_key_exists(2, $csvs[$i]) ? $csvs[$i][2] : $i,
                    $csvs[0][3] => array_key_exists(3, $csvs[$i]) ? $csvs[$i][3] : $i,
                    $csvs[0][4] => array_key_exists(4, $csvs[$i]) ? $csvs[$i][4] : $i,
                    $csvs[0][5] => array_key_exists(5, $csvs[$i]) ? $csvs[$i][5] : $i
                ];
            }

            foreach($obj as $json){
                $jsonString = json_encode($json);

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.melhorenvio.com.br/api/v2/me/companies/' . $store_id . '/addresses',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $jsonString,
                CURLOPT_HTTPHEADER => array(
                        'Content-type: application/json',
                        'Accept: application/json',
                        'Authorization: Bearer ' . $this->accessToken,
                        'User-Agent: Teste API (sara.novaalianca@gmail.com)'
                    ),
                ));

                $response = curl_exec($curl);
                $response = json_decode($response);
                if(isset($response->message)){
                    $return[] = $response;
                }

                curl_close($curl);
            }
        }

        // $json = '{
        //     "postal_code": "01010010",
        //     "address": "Av. Teste",
        //     "number": "123",
        //     "complement": "ABC",
        //     "city": "São Paulo",
        //     "state": "SP"
        // }';

        return view('welcome', ["return" => $return]);
    }
}
