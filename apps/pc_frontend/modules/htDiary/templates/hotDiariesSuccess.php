<div id="diaries_00" class="dparts box diaries">
<div class="parts">

<div class="partsHeading">
<h3><?php echo $title ?></h3>
</div>

<div style="font-size: small">
<?php
$tags = array();
foreach ($diaries as $diary)
{
  $tags[] = link_to(sprintf('%s (%d)', $diary[1], $diary[2]), '@diary_show?id='.$diary[0]);
}
echo join(' / ', $tags);
?>
</div>

</div>
</div>

