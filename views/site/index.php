<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <?= Html::a('Move 1-1-1-2 > 1-1-1-10', ['site/move', 'id'=> 5, 'after_id'=> 13], ['class'=>'btn btn-success']);?>
    <?= Html::a('Move 1-1-1-2 > 1-1-1-1', ['site/move', 'id'=> 5, 'after_id'=> 4], ['class'=>'btn btn-success']);?>
    <div class="row">
        <div class="col-5">
            <ul id="ul">
                <?
                $lvl=0;
                foreach($categories as $category){
                    if($category['lvl'] == $lvl){
                        echo "</li>";
                    }else if($category['lvl'] > $lvl){
                        echo "<ul>";
                    }else{
                        echo "</li>";

                        for($i = $lvl-$category['lvl']; $i; $i--){
                            echo "</ul>";
                            echo "</li>";
                        }
                    }

                    echo "<li>";
                    echo Html::a($category['title'], ['site/index', 'id' => $category['id']]);

                    $lvl = $category['lvl'];
                }

                for($i=$lvl;$i;$i--){
                    echo "</li>";
                    echo "</ul>";
                }
                ?>
            </ul>
        </div>
        <div class="col-7">
            <? if(!empty($parents)){?>
                <? foreach($parents as $parent){?>
                    <?= $parent['title'];?> >
                <? } ?>
            <? } ?>
            <?= $category_active['title'];?>
        </div>
    </div>
</div>