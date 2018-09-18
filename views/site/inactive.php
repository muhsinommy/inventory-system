
<h2>
    Inactive Account for user: <?= $user->getUserProfile()->getUserFullName() ?><br>
    <small>(<?= $user->getRoleName() ?>)</small>
</h2>
<hr>
<img class="img img-circle" width="100px" height="100px" src="<?= $user->getUserProfile()->profile_picture ?>" title="<?= $user->getUserProfile()->getUserFullName() ?>"/>
<p>
    Sorry, your account seems to be deactivated,<br><br>
    <a href="<?= yii\helpers\Url::to(['/site/contact'])?>">Contact System Administrator</a> for an assistance!
</p>