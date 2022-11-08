<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'My Yii Application';

$active_ids = [];
if(!empty($parents)){
    foreach($parents as $parent){
        $active_ids[$parent['id']] = 1;
    }
}
if(!empty($category)){
    $active_ids[$category['id']] = 1;
}
?>
<div class="site-index">
    <!-- <pre>
        <?print_r($child);?>
    </pre> -->
    <div class="row">
        <div class="col-5">
            <ul id="ul">
                <?foreach($roots_arr as $root){?>
                    <li class="<?=(isset($active_ids[$root['id']]))?'active':'';?>">
                        <span class="caret <?=(isset($active_ids[$root['id']]))?'caret-down':'';?>"><?= Html::a($root['title'], ['site/index', 'id'=> $root['id']]);?></span>
                        <ul class="nested <?=(isset($active_ids[$root['id']]))?'active':'';?>">
                        <?if(isset($root['childrens'])){?>
                            <? foreach($root['childrens'] as $node){ ?>
                                <?if(isset($node['childrens'])){?>
                                    <li class="<?=(isset($active_ids[$node['id']]))?'active':'';?>">
                                        <span class="caret <?=(isset($active_ids[$node['id']]))?'caret-down':'';?>"><?= Html::a($node['title'], ['site/index', 'id'=> $node['id']]);?></span>
                                        <ul class="nested <?=(isset($active_ids[$node['id']]))?'active':'';?>">
                                            <?foreach($node['childrens'] as $child){?>
                                                <li class="<?=(isset($active_ids[$child['id']]))?'active':'';?>"><?= Html::a($child['title'], ['site/index', 'id'=> $child['id']]);?></li>
                                            <? } ?>
                                        </ul>
                                    </li>
                                <? }else{ ?>
                                    <li class="<?=(isset($active_ids[$node['id']]))?'active':'';?>"><?= Html::a($node['title'], ['site/index', 'id'=> $node['id']]);?></li>
                                <? } ?>
                            <? } ?>
                        <? } ?>
                        </ul>
                    </li>
                <? } ?>
            </ul>
        </div>
        <div class="col-7">
            <? if(!empty($parents)){?>
                <? foreach($parents as $parent){?>
                    <?= $parent['title'];?> /
                <? } ?>
            <? } ?>
            <?= $category['title'];?>
        </div>
    </div>
</div>
<style>
ul, #ul {
  list-style-type: none;
}
#ul {
  margin: 0;
  padding: 0;
}
.caret {
  cursor: pointer;
  user-select: none;
}
.caret::before {
  content: "+";
  font-weight: bold;
  color: black;
  display: inline-block;
  margin-right: 5px;
}
.caret-down::before {
    content: "-";
    margin-right: 10px;
}
.nested {
  display: none;
}
.active {
  display: block;
}
li.active > a { 
    font-weight: bold;
}
li.active > span > a { 
    font-weight: bold;
}
</style>
<script>
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
</script>