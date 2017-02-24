<table border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td>Hi <?= $model['first_name']; ?>,</td>
    </tr>
    <tr>
        <td>Thanks for signing up!</td>
    </tr>
    <tr>
        <td>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</td>
    </tr>
    <tr><td>-----------------------------------------------</td></tr>
    <tr>
        <td>Email : <?= $model['email']; ?></td>
    </tr>
    <tr>
        <td>Password : <?= $model['password']; ?></td>
    </tr>
    <tr><td>------------------------------------------------</td></tr>
    <tr>
        <td>Please click this link to active your account: <a href="<?= Yii::$app->urlManagerFront->baseUrl.'/customer/activate?key='.$model['auth_key']; ?>"><?= Yii::$app->urlManagerFront->baseUrl.'/customer/activate?key='.$model['auth_key']; ?></a></td>
    </tr>
</table>