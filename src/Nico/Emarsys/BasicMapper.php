<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 15:23
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


class BasicMapper implements ContactMapperInteface
{
    private $sourceId;

    private $keyId;
    /**
     * @var
     */
    private $dataProvider;

    /**
     * BasicMapper constructor.
     * @param $dataProvider
     * @param $sourceId
     * @param $keyId
     */
    public function __construct($dataProvider, $sourceId = null, $keyId = null)
    {
        $this->sourceId = $sourceId;
        $this->keyId = $keyId;
        $this->dataProvider = $dataProvider;
    }


    public function getBody()
    {
        $body = [];
        if($this->sourceId){
            $body["source_id"] = (string) $this->sourceId;
        }
        if($this->keyId){
            $body["key_id"] = (string) $this->keyId;
        }
        // ici mapping des données

        return $body;
    }

    public function setSourceId($id)
    {
        $this->sourceId = $id;
    }

    public function setKeyId($id)
    {
        $this->keyId = $id;
    }
}
