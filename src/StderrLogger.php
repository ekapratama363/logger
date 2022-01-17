<?php

namespace Majoo\Logger;

class StderrLogger
{

    public function write(string $message)
    {
        $stderr = fopen('php://stderr', 'wb');
        
        return fwrite($stderr, $message);
    }

    public function log($request, $response)
    {
        $server_params = $request->getServerParams(); 
        $success_code  = [200, 201];
        $response      = json_decode($response);
        $data          = isset($response->data) ? $response->data : "";

        $message = [
            'level'            => $this->level($server_params['REDIRECT_STATUS']),
            'time'             => date('Y-m-d H:i:s'),
            'unique_id'        => uniqid(),
            'service_name'     => $server_params['HTTP_HOST'],
            'uri'              => $server_params['REQUEST_URI'],
            'error_code'       => in_array($server_params['REDIRECT_STATUS'], $success_code) ? '' : $server_params['REDIRECT_STATUS'],
            'request_time'     => $this->convertIntegerToDate($server_params['REQUEST_TIME']),
            'response_time'    => date('Y-m-d H:i:s'),
            'processing_time'  => microtime(true) - $server_params['REQUEST_TIME_FLOAT'],
            'request_param'    => $request->getQueryParams(),
            'response_message' => $response,
            'data'             => $data,
            'message'          => $response->msg,

            'remote_ip'        => $server_params['REMOTE_ADDR'],
            'http_method'      => $request->getMethod(),
            'host'             => $server_params['HTTP_HOST'],
            'merchant_id'      => isset($data->merchant_id) ? $data->merchant_id : '',
            'outlet_id'        => isset($data->id_outlet) ? $data->id_outlet : '',
            'user_id'          => isset($data->id_user) ? $data->id_user : '',
            'ref_id'           => isset($data->id_ref) ? $data->id_ref : '',
            'http_code'        => in_array($server_params['REDIRECT_STATUS'], $success_code) ? $server_params['REDIRECT_STATUS'] : '',
            'request_header'   => $request->getHeaders(),
        ];

        return $this->write(json_encode($message));
    }

    private function convertIntegerToDate(int $date)
    {
        return date("Y-m-d H:i:s", $date);
    }

    private function level($code)
    {
        if($code == 200 || $code == 201) {
            $level = 'info';
        } else if($code == 400 || $code == 401 || $code == 403) {
            $level = 'warning';
        } else if($code == 500) {
            $level = 'error';
        } else {
            $level = '';
        }

        return $level;
    }

}