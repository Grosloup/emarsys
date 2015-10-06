<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 14:09
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


class FieldFactory
{
    const TYPE_SHORTTEXT = 0;
    const TYPE_LONGTEXT = 1;
    const TYPE_LARGETEXT  = 2;
    const TYPE_DATE = 3;
    const TYPE_URL = 4;
    const TYPE_NUMERIC = 5 ;
    const TYPE_FAX = 6;
    const TYPE_BIRTHDATE = 7;
    const TYPE_SINGLECHOICE = 8;
    const TYPE_INTERESTS = 9;
    const TYPE_SPECIAL = 10;

    static $readOnly = [self::TYPE_INTERESTS,self::TYPE_SPECIAL];

    static $types = [
        self::TYPE_SHORTTEXT => "shorttext",
        self::TYPE_LONGTEXT => "longtext",
        self::TYPE_LARGETEXT => "largetext",
        self::TYPE_DATE => "date",
        self::TYPE_URL => "url",
        self::TYPE_NUMERIC => "numeric",
        self::TYPE_FAX => "fax",
        self::TYPE_BIRTHDATE => "birthdate",
        self::TYPE_SINGLECHOICE => "singlechoice",
        self::TYPE_INTERESTS => "interests",
        self::TYPE_SPECIAL => "special",
    ];

    public static function create($name = "", $type = 0)
    {
        if(in_array($type, self::$readOnly)){
            throw new \Exception("can't create this type of field, system type.");
        }
        if(in_array($type, [self::TYPE_SINGLECHOICE, self::TYPE_FAX, self::TYPE_BIRTHDATE])){
            throw new \Exception("This type of field cannot be created via API. " . self::$types[$type]);
        }
        return ["name"=>$name, "application_type"=>self::$types[$type]];
    }

    public static function createShortText($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_SHORTTEXT);
    }
    public static function createLongText($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_LONGTEXT);
    }
    public static function createLargeText($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_LARGETEXT);
    }
    public static function createNumeric($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_NUMERIC);
    }
    public static function createUrl($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_URL);
    }
    public static function createDate($name = "")
    {
        if(!$name){
            return false;
        }
        return self::create((string)$name, self::TYPE_DATE);
    }
}
