<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopics actions.
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

    $sql = <<<EOS
SELECT id, name, (SELECT count(*) FROM community_topic_comment WHERE community_topic_id = ct.id) as cnt
  FROM community_topic ct
 WHERE community_id = ?
 ORDER BY updated_at DESC
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
