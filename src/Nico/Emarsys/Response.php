<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 13:19
 */
/*
          ____________________
 __      /     ______         \
{  \ ___/___ /       }         \
 {  /       / #      }          |
  {/ ô ô  ;       __}           |
  /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
  (_ _(    |   |   |  |   |   /    #
   (_ (_   |   |   |  |   |   |
     (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace Nico\Emarsys;


use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var array
     */
    private $response = [];

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response = null)
    {
        if($response){
            $this->response = json_decode($response->getBody()->getContents(), true);
        }

    }

    public function getReplyCode()
    {
        if(!array_key_exists("replyCode", $this->response)){
            throw new \Exception("no reply code");
        }
        return $this->response["replyCode"];
    }

    public function getReplyText()
    {
        if(!array_key_exists("replyText", $this->response)){
            throw new \Exception("no reply text");
        }
        return $this->response["replyText"];
    }

    public function getData()
    {
        if(!array_key_exists("data", $this->response)){
            throw new \Exception("no datas");
        }
        return $this->response["data"];
    }

    public function getFullResponse()
    {
        return $this->response;
    }

    public function setFullResponse($datas)
    {
        $this->response = $datas;
    }

    public function isOk()
    {
        return strtolower($this->getReplyText()) == "ok";
    }
}
