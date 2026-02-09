<?php

/**
 * Created by ZBLOGPHP
 * User: zxasd
 * Date: 2026/02/9
 * Time: 17:00
 */

class ZbpAi
{

    public $text_url = null;
    public $text_model = null;
    public $text_apikey = null;
    public $image_url = null;
    public $image_model = null;
    public $image_apikey = null;
    public $video_url = null;
    public $video_model = null;
    public $video_apikey = null;


    public $temperature = null;//0.7;
    public $max_tokens = null;//1024;
    public $thinking = null;
    public $data = [];
    public $result = null;

    public function chat($prompt, $option = [])
    {
        global $zbp; 
        $array = array();
        if (is_null($this->text_url)) {
            $this->text_url = $zbp->option['ZC_TEXT_AI_API_URL'];
        }
        if (is_null($this->text_apikey)) {
            $this->text_apikey = $zbp->option['ZC_TEXT_AI_API_KEY'];
        }
        if (is_null($this->text_model)) {
            $this->text_model = $zbp->option['ZC_TEXT_AI_API_MODEL'];
        }

        $array['model'] = $this->text_model;

        foreach ($option as $key => $value) {
            $array[$key] = $value;
        }

        if (!is_array($prompt)) {
            $array['messages'] = array(); 
            $array['messages'][] = array(
                "role" => "user",
                "content" => $prompt
            );
        } else {
            $array['messages'] =  $prompt;
        }

        $this->data = json_encode($array);

        $this->send($this->text_url, $this->text_apikey, $this->data);

        return $this->result['choices'][0]['message']['content'] ?? null;
    }


    public function generateImage($prompt, $option = [])
    {
        global $zbp; 
        $array = array();
        if (is_null($this->image_url)) {
            $this->image_url = $zbp->option['ZC_IMAGE_AI_API_URL'];
        }
        if (is_null($this->image_apikey)) {
            $this->image_apikey= $zbp->option['ZC_IMAGE_AI_API_KEY'];
        }
        if (is_null($this->image_model)) {
            $this->image_model = $zbp->option['ZC_IMAGE_AI_API_MODEL'];
        }
    }

    public function generateVideo($prompt, $option = [])
    {
        global $zbp; 
        $array = array();
        if (is_null($this->video_url)) {
            $this->video_url = $zbp->option['ZC_VIDEO_AI_API_URL'];
        }
        if (is_null($this->video_apikey)) {
            $this->video_apikey= $zbp->option['ZC_VIDEO_AI_API_KEY'];
        }
        if (is_null($this->video_model)) {
            $this->video_model = $zbp->option['ZC_VIDEO_AI_API_MODEL'];
        }
    }

    public function send($url, $key, $data)
    {
        //var_dump($url, $key, $data);die;
        $ajax = Network::Create();
        $ajax->open('POST', $url);
        $ajax->setTimeOuts(120, 120, 0, 0);
        $ajax->setRequestHeader('Content-Type', 'application/json; charset=utf-8');
        $ajax->setRequestHeader('Authorization', 'Bearer ' . $key);
        $ajax->send($data);

        $json = $ajax->responseText;

        $this->result = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $this->result;
        }
    }

}
