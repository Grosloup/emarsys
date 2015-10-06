<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 03/10/2015
 * Time: 15:16
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


interface ContactMapperInteface
{
    public function getBody();

    public function setSourceId($id);

    public function setKeyId($id);
}
