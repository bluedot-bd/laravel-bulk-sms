<?php

namespace Bluedot\LaravelBulkSms;
use Log;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Http;
use Bluedot\LaravelBulkSms\BulkSms;

class LaravelBulkSmsFacade extends Facade
{   
    /**
     * The phone number notifications should be sent to.
     *
     * @var string
     */
    protected $to;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Full Message
     *
     * @var string
     */
    protected $message;

    /**
     * Message Lines
     *
     * @var array
     */
    protected $lines;

    /**
     * Create a new LaravelBulkSms instance
     * @param array $lines
     * @return void
     */
    function __construct($lines = [])
    {
        $this->lines = $lines;
        $this->provider = config('laravel-bulk-sms.provider');
        $this->base_url = config('laravel-bulk-sms.endpoint');
        $this->method = strtolower(config('laravel-bulk-sms.method'));
        $this->params[config('laravel-bulk-sms.username_param')] = config('laravel-bulk-sms.username');
        $this->params[config('laravel-bulk-sms.password_param')] = config('laravel-bulk-sms.password');
        $this->params['api_key'] = config('laravel-bulk-sms.api_key');
        $this->params['api_secret'] = config('laravel-bulk-sms.api_secret');
        $this->params['from'] = config('laravel-bulk-sms.from');
        $this->params = array_filter($this->params);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-bulk-sms';
    }

    /**
     * SMS to Number
     * @param  string  $to
     */
    public function to($to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * SMS from Number
     * @param  string  $from
     */
    public function from($from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * SMS Text
     * @param  string  $message
     */
    public function message($message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Add new Line
     * @param  string  $line
     */
    public function line($line=''): self
    {
        $this->lines[] = $line;
        return $this;
    }

    /**
     * Send SMS
     * @param  string  $to
     * @param  string  $sms
     * @param  string/boolean $from
     * @return JSON    
     */
    public function send(){
        if(!$this->from){
            $this->params['from'] = config('laravel-bulk-sms.from');
        }
        $this->params['to'] = $this->to;

        $lines = implode("\n", $this->lines);
        if($lines){
            $this->params[config('laravel-bulk-sms.message_param')] = $lines;
        }else{
            $this->params[config('laravel-bulk-sms.message_param')] = $this->message;
        }
        return $this->send_or_dry_run();
    }

    /**
     * Real or Demo Send
     * @return [type] [description]
     */
    public function send_or_dry_run(){
        $dry = config('laravel-bulk-sms.dry');
        $authorization = config('laravel-bulk-sms.authorization');
        if($dry){
            Log::info(['type'=>'sending demo sms', 'params'=>$this->params, 'url'=> $this->base_url . "?" . http_build_query($this->params)]);
            return true;
        }else{
            
            $http = new Http();
            if($authorization){
                $http->withHeaders(['Authorization' => $authorization]);
            }
            
            if($this->method=='get'){
                $response = $http->get($this->base_url, $this->params);
            }else{
                $response = $http->post($this->base_url, $this->params);
            }
            
            return $response->json();
        }
    }
}
