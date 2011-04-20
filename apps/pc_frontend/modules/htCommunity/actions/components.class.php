<?php

class htCommunityComponents extends sfComponents
{
  public function executeHotTopicsInCommunity(sfWebRequest $request)
  {
    $this->communityId = $this->gadget->getConfig('communityId');
    if (!$this->communityId) return sfView::NONE;

    $community = Doctrine::getTable('Community')->find($this->communityId);
    if (!$community) return sfView::NONE;

    $this->title = $this->gadget->getConfig('title', $community->getName().'トピック一覧');
    $limit       = $this->gadget->getConfig('limit', 20);
    $expiration  = 60 * 3; // 3 minutes

    $this->topics = opHotTopicsUtil::getHotTopicsInCommunity($this->communityId, $limit, $expiration);
  }

}
