<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class htCommunityComponents extends sfComponents
{
  public function executeHotTopicsInCommunity(sfWebRequest $request)
  {
    $this->communityId = $this->gadget->getConfig('communityId');
    if (!$this->communityId) return sfView::NONE;

    $this->title = $this->gadget->getConfig('title', 'トピック一覧');
    $this->limit = $this->gadget->getConfig('limit', 20);

    $sql = <<<EOS
SELECT id, name, (SELECT count(*) FROM community_topic_comment WHERE community_topic_id = ct.id) as cnt
  FROM community_topic ct
 WHERE community_id = ?
 ORDER BY updated_at DESC
 LIMIT 20
EOS;

    $conn = Doctrine::getTable('CommunityTopic')->getConnection();
    $stmt = $conn->execute($sql, array($this->communityId));

    $this->topics = array();
    while ($r = $stmt->fetch(Doctrine::FETCH_ASSOC))
    {
      $ad = Doctrine::getTable('ActivityData')->find($r['id']);
      $this->topics[] = array($r['id'], $r['name'], $r['cnt']);
    }
  }

}
