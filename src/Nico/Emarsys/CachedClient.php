<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 15:50
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


use GuzzleHttp\ClientInterface;

class CachedClient extends Client
{
    private $cache;

    private $cacheTime;

    public function __construct(ClientInterface $client, $username = "", $secret = "", $baseUrl="", $lang="fr",$cache = "", $cacheTime = 86400)
    {
        $this->cache = $cache;
        $this->cacheTime = $cacheTime;
        parent::__construct($client, $username, $secret, $baseUrl, $lang);
    }

    public function getFields($translate=true)
    {

        if(file_exists($this->cache) && (time() < filemtime($this->cache) + $this->cacheTime)){
            $response = new Response();
            $response->setFullResponse(json_decode(file_get_contents($this->cache), true));
            if($response->getData() != null){
                $this->fields = $response->getData();
            }
            return $response;
        } else {
            $response = $this->send(self::METHOD_GET, "field",[],$translate);
            if($response->getData() != null){
                $this->fields = $response->getData();
            }

            if($response->isOk()){
                $data = $response->getFullResponse();
                $jsondata = json_encode($data);

                if(false === file_put_contents($this->cache, $jsondata)){

                }
            }
            return $response;
        }

    }
}
