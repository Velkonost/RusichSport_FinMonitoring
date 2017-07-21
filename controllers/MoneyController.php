<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Leads;


class MoneyController extends Controller {

    private $startPeriod = 0;
    private $finishPeriod = 0;
    public $layout = 'money';
	
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    // вот жта штука отлючает проверку CSRF для POST запроса, который делает AMOCRM
    public function beforeAction($action)
    {
        if ($action->id == 'webhook') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
	
	public function actionGetpost(){
		return $this->render('getPosts',
        []);
	}
	

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        #Массив с параметрами, которые нужно передать методом POST к API системы
        $user=array(
          'USER_LOGIN'=>'kranfear@mail.ru', #Ваш логин (электронная почта)
          'USER_HASH'=>'38f2e3461e664db15032bcab8b7c26e8' #Хэш для доступа к API (смотрите в профиле пользователя)
        );
 
        $subdomain='new584549b112ca4'; #Наш аккаунт - поддомен
 
        #Формируем ссылку для запроса
        $link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';

        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
         
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL

        sleep(2);

        // First day of this month
        $d = strtotime(date('1-m-Y',strtotime('this month')));
        for ($offset = 1; $offset < 5; $offset ++) {
            // $offset = 1;

            $link2 = 'https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/list?limit_rows=500&limit_offset='.$offset;

            $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
            #Устанавливаем необходимые опции для сеанса cURL
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
            curl_setopt($curl,CURLOPT_URL,$link2);
            curl_setopt($curl,CURLOPT_HEADER,false);
            curl_setopt($curl,CURLOPT_COOKIEFILE,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
            curl_setopt($curl,CURLOPT_COOKIEJAR,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

            $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
            $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
            curl_close($curl);
            // $out = unparseLeadsIds($out);


            $data = json_decode($out);
            $leadsIds = [];

            $leadsDateCreate = [];
            $clientsIds = [];
            $amountLeads = count($data->{'response'}->{'leads'});

            for ($i = 0; $i < $amountLeads; $i ++) {
                    array_push($leadsIds, $data->{'response'}->{'leads'}[$i]->{'id'});
                    array_push($clientsIds, $data->{'response'}->{'leads'}[$i]->{'main_contact_id'});
                    array_push($leadsDateCreate, date("d/m/Y H:i:s", $data->{'response'}->{'leads'}[$i]->{'date_create'}));
            }
            
            $link3 = 'https://'.$subdomain.'.amocrm.ru/private/api/v2/json/contacts/';

            $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
            #Устанавливаем необходимые опции для сеанса cURL
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
            curl_setopt($curl,CURLOPT_URL,$link3);
            curl_setopt($curl,CURLOPT_HEADER,false);
            curl_setopt($curl,CURLOPT_COOKIEFILE,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
            curl_setopt($curl,CURLOPT_COOKIEJAR,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

            $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
            $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
            curl_close($curl);
            $data = json_decode($out);

            $amountContacts = count($data->{'response'}->{'contacts'});

            $clientsNames = [];
            $clientsPhones = [];
            $clientsCities = [];


            for ($i = 0; $i < count($clientsIds); $i ++) {
                array_push($clientsNames, $data->{'response'}->{'contacts'}[$i]->{'name'});
                array_push($clientsPhones, unparseContactPhone($data->{'response'}->{'contacts'}[$i]->{'custom_fields'}));
                
            }

            for ($i = 0; $i < count($clientsIds); $i ++) {
				
                $post = new Leads;
                $post->lead_id = $leadsIds[$i];
                $post->critical_acc = "Ответственный";
                $post->contact_name = $clientsNames[$i];
                $post->contact_phone = $clientsPhones[$i];
                $post->contact_city = "Город";

                $post->lead_date_create = $leadsDateCreate[$i];

                $post->save();

            }
        }

        return $this->render('index',
        [
            'c' => $d,
            'amount' => count($clientsIds),
            'dates' => $leadsDateCreate,
            'names' => $clientsNames,
            'phones' => $clientsPhones
        ]);
    }
    
    
}


  function unparseContactPhone($data){     
        
    
        return $data[0]->{'values'}[0]->{'value'};
    }