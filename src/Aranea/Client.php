<?php

namespace Aranea;


class Client{

    private $postExecute=[];
    private $preExecute;

    public function addPostExecute($callback){
        $this->postExecute[]=$callback;
    }

    public function addPreExecute($callback)
    {
        $this->preExecute[]=$callback;
    }

    public function requestGet($url,$headers=[]){

        $request=new HTTPRequest($url);
        return $this->execute($request);
    }


    private function execute(HTTPRequest $request){

        foreach($this->preExecute as $execute){
            call_user_func_array($execute,[$request]);
        }

        $curl=curl_init();
        try{
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl,CURLOPT_HEADER,1);
            curl_setopt($curl,CURLOPT_URL,$request->getUrl());
            if($request->isAuth()){
                curl_setopt($curl,CURLOPT_USERPWD,$request->getAuth());
            }

            if(HTTPRequest::METHOD_POST === $request->getMethod()){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$request->getBody());
            }

            $headers=[];
            foreach($request->getHeaders() as $header){
                $headers[]=$header->__toString();
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result=curl_exec($curl);
            $statusCode=curl_getinfo($curl, CURLINFO_HTTP_CODE);

            $response=new HTTPResponse($statusCode,$result);

            foreach($this->postExecute as $execute){
                $response=call_user_func_array($execute,[$response]);
            }

            return $response;
        }
        finally{
            curl_close($curl);
        }
    }

    public function requestPost($url, $attr)
    {
        $request=new HTTPRequest($url);
        $request->setMethod(HttpRequest::METHOD_POST);
        $request->setBody($attr);
        $request->setContentType(HTTPRequest::CONTENT_TYPE_JSON);
        return $this->execute($request);

    }

}