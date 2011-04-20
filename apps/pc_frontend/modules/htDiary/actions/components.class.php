<?php

class htDiaryComponents extends sfComponents
{
  public function executeHotDiaries(sfWebRequest $request)
  {
    $this->title = $this->gadget->getConfig('title', 'Popular diary entries');
    $limit       = $this->gadget->getConfig('limit', 20);
    $expiration  = 60 * 3; // 3 minutes

    $this->diaries = opHotTopicsUtil::getHotDiaries($limit, $expiration);
  }

}
