<?php

namespace CreatyDev\Http\Webhook\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Request as Input;

use CreatyDev\App\Controllers\Controller;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\NameValuePair;

use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use CreatyDev\Domain\Voter_logs;
use CreatyDev\Domain\Account\Contest;
use CreatyDev\Domain\Account\Contestant;

use Redirect;
use Session;
use URL;
use Paystack;
use Rave;
use Auth;

class PaymentController extends Controller
{
    private $_apiContext;
    private $pscallbackpending = true;
    private $paymentDetails ;
    private $fpk ;
    private $fsk ;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_apiContext = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_apiContext->setConfig($paypal_conf['settings']);
        $this->fpk = env('FLUTTERWAVE_PUBLIC_KEY');
        $this->fsk = env('FLUTTERWAVE_SECRET_KEY');
    }
// //////////////// PAY STACK /////////////////////////////////////////////
    public function paystackpay(Request $request)
    {
        $contest = Contest::where('id',$request->contest_id)->first();
        $amount = $contest->vote_amount*$request->no_of_votes*100;

        $data = [
            'amount' => $amount,
            'email' => $request->email,
            'callback_url' => "http://localhost:8000/payment/callback",
            'currency' => $contest->contest_currency,
            'metadata' => json_encode($array = [
                'contest_id'=>$request->contest_id , 
                'contestent_id'=>$request->contestant_id,
                'no_of_votes'=>$request->no_of_votes
            ]),
            'reference' => Paystack::genTranxRef(),
            
        ];
        // dd($data);
        $response = Paystack::getAuthorizationResponse($data);
        Session::put('paystackpaid',false);
        return $response['data']['authorization_url'];
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return ['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error'];
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    // public function checkPaystackStatus()
    // {
    //     return Session::get('paystackpaid')?true:false;
    // }

    public function waitForPayment()
    {
        $count = date("Y-m-d H:i:s", strtotime("+30 sec"));
        $status = "not-paid";
        while (true){
            if(Session::get('paystackpaid')){
                $status = "paid";
                break;
            }elseif(date("Y-m-d H:i:s") > $count){
                $status = "time expired";
                break;
            }else{
                sleep(2);
                // $count++;
            }
        }
        Session::forget('paystackpaid');
        return $status;
    }

    public function handleGatewayCallback()
    {
        $data = Paystack::getPaymentData();
        if($data['data']['status'] == "success" )
        {
            $vlog = new Voter_logs;
            $vlog->contest_id = $data['data']['metadata']['contest_id'];
            $vlog->contestent_id = $data['data']['metadata']['contestent_id'];
            $vlog->voter_email = $data['data']['customer']['email'];
            $vlog->no_of_votes = $data['data']['metadata']['no_of_votes'];
            $vlog->gateway = "paystack";
            $vlog->amount = $data['data']['amount']/100;
            $vlog->currency = $data['data']['currency'];
            $vlog->no_of_votes = $data['data']['metadata']['no_of_votes'];

            $vlog->payment_info = json_encode($data);
            $vlog->save();

            $contestent = Contestant::where('id',$data['data']['metadata']['contestent_id'])->first();
            $contestent->votes = $contestent->votes + $data['data']['metadata']['no_of_votes'];
            $contestent->save();
        }
        // Session::put('paystackpaid', true);
        return redirect()->route('contest.publish',$data['data']['metadata']['contest_id']);
        // return redirect($this->previousurl)->with($data['data']['metadata']['contest_id']);
        
        // return redirect()->route('duespaid');$this->previousurl
        
    }


// //////////////////////// PAY PAL ///////////////////////////////////////// 
    public function paypalpay(Request $request)
    {
        # code...
    }

    // public function paystackcallback()
    // {
    //     while($this->pscallbackpending){
    //         sleep(3);
    //     }
    //     return $paymentDetails;
    // }

    public function payWithPaypal(Request $request )
    {
        // dd(Session::get('current_transaction'));
        Session::forget('current_transaction');
        // dd(Session::get('current_transaction'));
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $sku = substr(str_shuffle($permitted_chars), 0, 9999);

        $contestant = Contestant::where('id',$request->contestant_id)->first();
        $form_data=json_decode($contestant->form_data , false);
        $contestant_name = $form_data->firstName." ".$form_data->lastName;

        $contest = Contest::where('id',$request->contest_id)->first();
        $amount = $contest->vote_amount;
        $total_amount = $amount*$request->no_of_votes;

        $paypaldata = collect([
            'sku' => $sku,
            'contest_id'=>$request->contest_id , 
            'contestent_id'=>$request->contestant_id,
            'voter_email' => $request->email,
            'no_of_votes'=>$request->no_of_votes
        ]);
        Session::push('current_transaction',$paypaldata);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('vote for '.$contestant_name) /** item name **/
                    ->setSku($sku)
                    ->setCurrency('USD')
                    ->setQuantity($request->no_of_votes)
                    ->setPrice($amount); /** unit price **/
        $item_list = new ItemList();
                $item_list->setItems(array($item_1));
        $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($total_amount);
        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Pay $'.$total_amount.' to vote for contestent '.$contestant_name);
        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('paypalcallback')) /**status Specify return URL **/
                    ->setCancelUrl(URL::route('contest.publish',$paypaldata['contest_id']));
        $payment = new Payment();
                $payment->setIntent('authorize')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/
                try {
        $payment->create($this->_apiContext);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
        if (\Config::get('app.debug')) {
        \Session::put('error', 'Connection timeout');
                        return Redirect::route('paywithpaypal');
        } else {
        \Session::put('error', 'Some error occur, sorry for inconvenient');
                        return Redirect::route('paywithpaypal');
        }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                            break;
                // return $link->getHref();
            }
        }
        /** add payment ID to session **/
                Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
        /** redirect to paypal **/
                    // return Redirect::away($redirect_url);
                    return $redirect_url;
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('paywithpaypal');
    }

    public function paypalCallback()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::input('PayerID')) || empty(Input::input('token'))) {
            \Session::PUT('error','Payment failed');
            return redirect('/account/subscription/swap');
        }
        $payment = Payment::get($payment_id, $this->_apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::input('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            $session_data = Session::get('current_transaction')[0];
            // $transaction_data = $result;
            // dd(json_decode($transaction_data));
            // dd($session_data['sku'] , $transaction_data->transactions[0]->item_list->items[0]->sku);
            if($session_data['sku'] == $result->transactions[0]->item_list->items[0]->sku){
                $vlog = new Voter_logs;
                $vlog->contest_id = $session_data['contest_id'];
                $vlog->contestent_id = $session_data['contestent_id'];
                $vlog->voter_email = $session_data['voter_email'];
                $vlog->no_of_votes = $session_data['no_of_votes'];
                $vlog->gateway = "paypal";
                $vlog->amount = $result->transactions[0]->amount->total;
                $vlog->currency = $result->transactions[0]->amount->currency;

                $vlog->payment_info = $result;
                $vlog->save();

                $contestent = Contestant::where('id',$session_data['contestent_id'])->first();
                $contestent->votes = $contestent->votes + $session_data['no_of_votes'];
                $contestent->save();

                Session::forget('current_transaction');
                // dd($transaction_data , Session::get('current_transaction'));

                return redirect()->route('contest.publish',$session_data['contest_id']);
            }else{
                \Session::put('error', 'Payment failed cannot save data');
                return redirect('/account/subscription/swap');
            }
        }
        \Session::put('error', 'Payment failed');
        return redirect('/account/subscription/swap');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty(Input::input('PayerID')) || empty(Input::input('token'))) {
            \Session::PUT('error','Payment failed');
            return redirect('/account/subscription/swap');
        }

        $payment = Payment::get($payment_id, $this->_apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::input('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
            return redirect('/account/subscription/swap');
        }
        \Session::put('error', 'Payment failed');
        return redirect('/account/subscription/swap');
    }

// ///////////////////// FLUTTER //////////////////////////////////////////////
     /**
   * Initialize Rave payment process
   * @return void
   */
  public function flutterpay(Request $request)
  {
    Session::forget('flutterdatasession');

    $contest = Contest::where('id',$request->contest_id)->first();
    $amount = $contest->vote_amount*$request->no_of_votes;

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $referenceno = substr(str_shuffle($permitted_chars), 0, 9999);

    $currency = $contest->contest_currency;
    $payment_option = "account";
    $redirect_url = "http://localhost:8000/payment/flutter/callback";
    $authorization = 'Bearer'." ".$this->fsk;
    $data = collect([
        'amount' => $amount,
        'currency' => $currency,
        'voter_email' => $request->email,
        'contest_id'=>$request->contest_id , 
        'contestent_id'=>$request->contestant_id,
        'no_of_votes'=>$request->no_of_votes,
        'tx_ref' => $referenceno,
    ]);
    // dd($data);
    // $flutterdata = collect($data);
    Session::push('flutterdatasession',$data);

    $client = new \GuzzleHttp\Client();
    $url = "https://api.flutterwave.com/v3/payments/";

    $request = $client->request('POST',$url,  [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => $authorization,
        ],
        'json' => [
                "tx_ref"=>$referenceno,
                "amount"=>$amount,
                "currency"=>$currency,
                "redirect_url"=>$redirect_url,
                'customer'=>[
                    'email' => $request->email,
                ],
                'customizations' =>[
                    'title' => 'Vote Express',
                    'description'  => 'Pay to vote',
                ]
        ]
    ]);
    $response = json_decode($request->getBody()->getContents());
    return $response->data->link;
  }

  /**
   * Obtain Rave callback information
   * @return void
   */

    public function flutterCallback(Request $request)
    {
        $flutterdata = Session::get('flutterdatasession')[0];
        $flutterpaymentdata = $request->all();
        // dd($flutterdata['tx_ref'],$flutterpaymentdata['tx_ref']);
        if($flutterdata['tx_ref'] == $flutterpaymentdata['tx_ref'] && $flutterpaymentdata['status'] == 'successful'){

            $vlog = new Voter_logs;
            $vlog->contest_id = $flutterdata['contest_id'];
            $vlog->contestent_id = $flutterdata['contestent_id'];
            $vlog->voter_email = $flutterdata['voter_email'];
            $vlog->no_of_votes = $flutterdata['no_of_votes'];
            $vlog->gateway = "flutterwave";
            $vlog->amount = $flutterdata['amount'];
            $vlog->currency = $flutterdata['currency'];

            $vlog->payment_info = json_encode($flutterpaymentdata);
            $vlog->save();

            $contestent = Contestant::where('id',$flutterdata['contestent_id'])->first();
            $contestent->votes = $contestent->votes + $flutterdata['no_of_votes'];
            $contestent->save();
        }
            Session::forget('flutterdatasession');
            return redirect()->route('contest.publish',$flutterdata['contest_id']);
    }

    public function getPaymentDetails()
    {
        $contestids = Auth::user()->contests->pluck('id')->toArray();
        
        $data = Voter_logs::selectRaw('gateway , currency , sum(amount) as totalamount')
                            ->join('contest','contest.id','voter_log.contest_id')
                            ->whereIn('contest.id',$contestids)
                            ->groupBy('gateway','currency')
                            ->get();
        return $data;
  }
  
}
