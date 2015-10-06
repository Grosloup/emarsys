<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 12:16
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
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Client
{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    /**
     * @var string
     */
    protected $secret;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var ClientInterface
     */
    protected $client;
    /**
     * @var string
     */
    protected $baseUrl;
    /**
     * @var string
     */
    protected $lang;
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * Client constructor.
     * @param ClientInterface $client
     * @param string $secret
     * @param string $username
     * @param string $baseUrl
     * @param string $lang
     */
    public function __construct(ClientInterface $client, $username = "", $secret = "", $baseUrl="", $lang="fr")
    {
        $this->secret = $secret;
        $this->username = $username;
        $this->client = $client;
        if(substr($baseUrl, -1) !== "/"){
            $baseUrl = $baseUrl . "/";
        }
        $this->baseUrl = $baseUrl;
        $this->lang = $lang;
    }

    public function getFields($translate=true)
    {
        $response = $this->send(self::METHOD_GET, "field",[],$translate);
        if($response->getData() != null){
            $this->fields = $response->getData();
        }
        return $response;
    }

    public function getFieldChoices($fieldId, $translate=true)
    {
        $uri = sprintf("field/%d/choice", (int)$fieldId);
        return $this->send(self::METHOD_GET, $uri,[],$translate);
    }

    public function getFieldName($id, $translate=true)
    {
        if(!$this->fields){
            $this->getFields($translate);
        }
        $fieldname = null;
        if($this->fields){

            foreach($this->fields as $field){
                if($field["id"] == $id){
                    $fieldname = $field["name"];
                    break;
                }
            }
        }
        return $fieldname;
    }

    public function getFieldId($name, $translate=true)
    {
        if(!$this->fields){
            $this->getFields($translate);
        }
        $fieldid = null;
        if($this->fields){

            foreach($this->fields as $field){
                if($field["id"] == $name){
                    $fieldid = $field["id"];
                    break;
                }
            }
        }
        return $fieldid;
    }

    public function createField($name, $type)
    {
        $body = FieldFactory::create($name, $type);
        $respone = $this->send(self::METHOD_POST, "field", $body);
        return $respone;
    }

    public function createContact(ContactMapperInteface $mapper)
    {
        $respone = $this->send(self::METHOD_POST, "contact", $mapper->getBody());
        return $respone;
    }

    protected function send($method = 'GET', $uri, array $body = array(), $translate=true)
    {
        $headers = array('Content-Type'=>'application/json', 'X-WSSE'=>$this->getSignature());
        $uri = $this->baseUrl . $uri;
        if($translate == true && $this->lang != null){
            $uri .= "/translate/" . $this->lang;
        }
        $options = ["headers"=>$headers];
        if(in_array(strtolower($method), ["put","post","patch"])){
            $options["body"] = json_encode($body);
        } else {
            $options["query"] = $body;
        }
        try{
            $response = $this->client->request($method, $uri, $options);
        } catch (ClientException $e) {
            return new Response($e->getResponse());
        } catch (ServerException $e) {
            return new Response($e->getResponse());
        }
        return new Response($response);

    }

    private function getSignature()
    {
        $created = new \DateTime();
        $iso8601 = $created->format(\DateTime::ISO8601);
        $nonce = md5($created->modify('next friday')->getTimestamp());
        $digest = base64_encode(sha1($nonce . $iso8601 . $this->secret));
        $signature = sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $this->username,
            $digest,
            $nonce,
            $iso8601
        );
        return $signature;
    }


}
