<div id="hotTopicsInCommunity_00" class="dparts box hotTopicsInCommunity">
<div class="parts">

<div class="partsHeading">
<h3><?php echo $title ?></h3>
</div>

<div style="font-size: small">
<?php 
$tags = array();
foreach ($topics as $topic)
{
  $tags[] = link_to(sprintf('%s (%d)', $topic[1], $topic[2]), '@communityTopic_show?id='.$topic[0]);
}
echo join(' / ', $tags);
?>

/
<?php echo link_to(__('More'), '@htCommunity_hotTopics?id='.$communityId) ?>
</div>

</div>
</div>
