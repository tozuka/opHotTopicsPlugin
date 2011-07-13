<?php

/**
 * opHotTopicsUtil
 *
 * @package    OpenPNE
 * @subpackage util
 * @author     Naoya Tozuka <tozuka@tejimaya.com>
 */
class opHotTopicsUtil
{
  public static function getHotTopicsInCommunity($communityId, $limit, $expirationSec)
  {
    $memcache = null;
    if (class_exists('Memcache'))
    {
      $memcache = new Memcache();
      $memcache->connect('localhost', 11211, 30);
      $cacheKey = sprintf('htUtil:communityTopics:%d:%d', $communityId, $limit);
      $topics = $memcache->get($cacheKey, MEMCACHE_COMPRESSED);
      if (FALSE !== $topics)
      {
        error_log('FOUND IN CACHE: '.$cacheKey);
        $memcache->close();
        $memcache = null;

        return $topics;
      }
      else
      {
        error_log('NOT FOUND IN CACHE: '.$cacheKey);
      }
    }

    $sql = <<<EOS
SELECT id, name, (SELECT count(*) FROM community_topic_comment WHERE community_topic_id = ct.id) as cnt
  FROM community_topic ct
 WHERE community_id = ?
 ORDER BY updated_at DESC
EOS;
    if ($limit)
    {
      $sql .= ' LIMIT '.$limit;
    }

    $conn = Doctrine::getTable('CommunityTopic')->getConnection();
    $stmt = $conn->execute($sql, array($communityId));

    $topics = array();
    while ($r = $stmt->fetch(Doctrine::FETCH_ASSOC))
    {
      $topics[] = array($r['id'], $r['name'], $r['cnt']);
    }

    if ($memcache)
    {
      $res = $memcache->set($cacheKey, $topics, MEMCACHE_COMPRESSED, $expirationSec);
      $memcache->close();
    }

    return $topics;
  }

<<<<<<< HEAD

  public static function getHotDiaries($limit, $expirationSec)
  {
    $memcache = null;
    if (class_exists('Memcache') && false)
    {
      $memcache = new Memcache();
      $memcache->connect('localhost', 11211, 30);
      $cacheKey = sprintf('htUtil:diaries:%d', $limit);
      $diaries = $memcache->get($cacheKey, MEMCACHE_COMPRESSED);
      if (FALSE !== $diaries)
      {
        error_log('FOUND IN CACHE: '.$cacheKey);
        $memcache->close();
        $memcache = null;

        return $diaries;
      }
      else
      {
        error_log('NOT FOUND IN CACHE: '.$cacheKey);
      }
    }

    $sql = <<<EOS
SELECT diary.id, diary.title, IFNULL(MAX(diary_comment.created_at),diary.created_at) AS timestamp, COUNT(diary_comment.id) AS cnt
  FROM diary
  LEFT JOIN diary_comment ON diary.id = diary_comment.diary_id
 WHERE diary.public_flag = 1
 GROUP BY diary.id
 ORDER BY timestamp DESC 
EOS;
    if ($limit)
    {
      $sql .= ' LIMIT '.$limit;
    }

    $conn = Doctrine::getTable('DiaryComment')->getConnection();
    $stmt = $conn->execute($sql);//, array($communityId));

    $topics = array();
    while ($r = $stmt->fetch(Doctrine::FETCH_ASSOC))
    {
      //$ad = Doctrine::getTable('ActivityData')->find($r['id']);
      $diaries[] = array($r['id'], $r['title'], $r['cnt']);
    }

    if ($memcache)
    {
      $res = $memcache->set($cacheKey, $diaries, MEMCACHE_COMPRESSED, $expirationSec);
      $memcache->close();
    }

    return $diaries;
  }
}
