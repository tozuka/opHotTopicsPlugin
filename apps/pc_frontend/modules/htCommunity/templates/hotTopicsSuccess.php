<div id="communityTopics_00" class="dparts box communityTopics">
<div class="parts">

<div class="partsHeading">
<h3><?php echo $title . ' コミュニティのトピック' ?></h3>
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
</div>

</div>
</div>

