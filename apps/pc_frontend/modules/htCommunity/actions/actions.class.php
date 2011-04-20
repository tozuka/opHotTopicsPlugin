<?php

/**
 * htCommunity actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Naoya Tozuka <tozuka@tejimaya.com>
 */
class htCommunityActions extends sfActions
{
  public function executeHotTopics($request)
  {
    $this->communityId = $request->getParameter('id');
    $this->forward404Unless($this->communityId);

    $community = Doctrine::getTable('Community')->find($this->communityId);
    $this->forward404Unless($community);

    $this->title = $community->getName();
    $limit       = 9999;
    $expiration  = 300;

    $this->topics = opHotTopicsUtil::getHotTopicsInCommunity($this->communityId, $limit, $expiration);
  }
}
