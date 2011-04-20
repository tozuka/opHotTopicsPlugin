<?php

/**
 * diary actions
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Naoya Tozuka <tozuka@tejimaya.com>
 */
class htDiaryActions extends sfActions
{
  public function executeHotDiaries($request)
  {
    $limit       = 9999;
    $expiration  = 300;

    $this->title = '人気の日記エントリ';
    $this->diaries = opHotTopicsUtil::getHotDiaries($limit, $expiration);
  }
}
