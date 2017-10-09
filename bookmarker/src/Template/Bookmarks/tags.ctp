
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css
',['block'=>true]) ?>
<small> Aranılan Tag :
    <?= $this->Text->toList(h($tags)) ?></small>
<div class="container">
    <div class="row">
        <?php foreach ($bookmarks as $bookmark): ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong><?= $this->Html->link($bookmark->title, $bookmark->url,['class'=>'post-title'])?></strong></div>
                <div class="panel-body">
                    <?= $this->Text->autoParagraph(h($bookmark->description)); ?>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>