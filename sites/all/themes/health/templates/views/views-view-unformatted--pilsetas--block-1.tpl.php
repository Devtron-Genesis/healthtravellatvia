<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div id="pilseta_00" class="pilseta_punkts"><div id="p7" class="punkts pp264 pp839 pp822" style="top:67px;left:83px;">Baldone</div></div>
<div id="pilseta_0" class="pilseta_punkts"><div id="p8" class="punkts pp8 pp840 pp826" style="top:54px;left:85px;">Carnikava</div></div>
<div id="pilseta_1" class="pilseta_punkts"><div id="p9" class="punkts pp9 pp841 pp827" style="top:60px;left:76px;">Jūrmala</div></div>
<div id="pilseta_2" class="pilseta_punkts"><div id="p10" class="punkts pp10 pp750 pp828" style="top:76px;left:21px;">Liepāja</div></div>
<div id="pilseta_3" class="pilseta_punkts"><div id="p11" class="punkts pp11 pp843 pp829" style="top:52px;left:100px;">Līgatne</div></div>
<div id="pilseta_4" class="pilseta_punkts"><div id="p12" class="punkts pp12 pp844 pp830" style="top:64px;left:90px;">Ogre</div></div>
<div id="pilseta_5" class="pilseta_punkts"><div id="p13" class="punkts pp13 pp845 pp831" style="top:33px;left:86px;">Salacgrīva</div></div>
<div id="pilseta_6" class="pilseta_punkts"><div id="p14" class="punkts pp14 pp846 pp832" style="top:52px;left:86px;">Saulkrasti</div></div>
<div id="pilseta_7" class="pilseta_punkts"><div id="p15" class="punkts pp15 pp847 pp833" style="top:54px;left:94px;">Sigulda</div></div>

<?php foreach ($rows as $id => $row): ?>
  <div class="<?php print $classes_array[$id]; ?>">
    <?php print l($row, check_plain('jaunumi/p'), array('html' => TRUE, 'fragment' => 'pilsetas-block:'.$id)); ?>
  </div>
<?php endforeach; ?>
