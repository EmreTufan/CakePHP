<?= $this->Html->css('style.css',['block'=>true]) ?>

<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css
',['block'=>true]) ?>
<div class="container">
    <div class="card card-container">

        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card">Giriş Ekranı</p>
        <p><?= $this->Flash->render()?></p>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('email',['id'=>'inputEmail','class'=>'form-control']) ?>
        <?= $this->Form->control('password',['id'=>'inputPassword','class'=>'form-control'])?>
        <?= $this->Form->button('Giriş Yap',['class'=>'btn btn-lg btn-primary btn-block btn-signin'])?>
        <?= $this->Form->end()?>
    </div><!-- /card-container -->
</div><!-- /container -->