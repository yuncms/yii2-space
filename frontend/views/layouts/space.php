<?php

/**
 * @var \yii\web\View $this
 * @var string $content
 * @var \yuncms\user\models\User $user
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use yuncms\user\models\Profile;


$user = $this->params['user'];
$appLayouts = Yii::$app->layout;

?>
<?php $this->beginBlock('jumbotron'); ?>
<header class="space-header">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?= Html::a(Html::img($user->getAvatar('big'), ['alt' => Yii::t('space', 'Avatar'), 'class' => 'img-responsive img-circle']), ['/user/space/view', 'id' => $user->id]) ?>
            </div>
            <div class="col-md-7">
                <div class="space-header-name h3">
                    <?= $user->nickname; ?>
                </div>
                <hr>
                <div class="space-header-social">
                        <span class="space-header-item"><?= Yii::t('space', 'Gender') ?>：
                            <?php if ($user->profile->gender == Profile::GENDER_UNCONFIRMED): ?>
                                <i class="fa fa-genderless"></i>
                            <?php elseif ($user->profile->gender == Profile::GENDER_MALE): ?>
                                <i class="fa fa-mars"></i>
                            <?php elseif ($user->profile->gender == Profile::GENDER_FEMALE): ?>
                                <i class="fa fa-venus"></i>
                            <?php endif; ?>
                        </span>
                    <?php if (!empty($user->profile->location)): ?>
                        <span class="space-header-item">
                            <i class="fa fa-map-marker"></i> <?= Html::encode($user->profile->location) ?> </span>
                    <?php endif; ?>

                    <?php if (!empty($user->profile->website)): ?>
                        <span class="space-header-item">
                            <i class="fa fa-link"></i> <a href="<?= $user->profile->website ?>"
                                                          rel="nofollow"><?= Html::encode($user->profile->website) ?></a></span>
                    <?php endif; ?>
                    <?php if (!empty($user->profile->email)): ?>
                        <span class="space-header-item">
                            <i class="fa fa-envelope-o"></i> <?= Html::mailto(Html::encode($user->profile->email), Html::encode($user->profile->email)) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="space-header-desc mt-15">
                    <?php if (!empty($user->profile->bio)): ?>
                        <p><?= Html::encode($user->profile->bio) ?></p>
                    <?php endif; ?>
                </div>

                <div class="space-header-social mt-15">
                    <?= Url::to(['/space/space/show', 'username' => $user->profile->user->username], true); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mt-10">
                    <?php if (Yii::$app->hasModule('attention')): ?>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isFollowed(get_class($user), $user->id)): ?>
                            <button type="button" class="btn mr-10 btn-success active" data-target="follow-button"
                                    data-source_type="user"
                                    data-source_id="<?= $user->id; ?>" data-show_num="true"
                                    data-toggle="tooltip" data-placement="right" title=""
                                    data-original-title="<?= Yii::t('space', 'Follow will be updated to remind') ?>"><?= Yii::t('space', 'Followed') ?>
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn mr-10 btn-success" data-target="follow-button"
                                    data-source_type="user"
                                    data-source_id="<?= $user->id; ?>" data-show_num="true"
                                    data-toggle="tooltip" data-placement="right" title=""
                                    data-original-title="<?= Yii::t('space', 'Follow will be updated to remind') ?>"><?= Yii::t('space', 'Follower') ?>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->hasModule('message')) {
                        Modal::begin([
                            'header' => Yii::t('space', 'Send message to') . '  ' . $user->nickname,
                            'toggleButton' => [
                                'tag' => 'button',
                                'class' => 'btn btn-default btnMessageTo',
                                'label' => Yii::t('space', 'Message'),
                            ],
                        ]);
                        ?>
                        <?= \yuncms\message\widgets\SendMessage::widget(['nickname' => $user->nickname]); ?>
                        <?php Modal::end();
                    } ?>

                </div>
                <div class="space-header-info row mt-30">
                    <?php if (Yii::$app->hasModule('coin')): ?>
                        <div class="col-md-4">
                            <span class="h3">
                                <a href="<?= Url::to(['/coin/space/index', 'id' => $user->id]) ?>"><?= $user->extend->coins; ?></a>
                            </span>
                            <span><?= Yii::t('space', 'Coins') ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (Yii::$app->hasModule('credit')): ?>
                        <div class="col-md-4">
                            <span class="h3"><a
                                        href="<?= Url::to(['/credit/space/index', 'id' => $user->id]) ?>"><?= $user->extend->credits; ?></a></span>
                            <span><?= Yii::t('space', 'Credits') ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (Yii::$app->hasModule('attention')): ?>
                        <div class="col-md-4">
                            <span class="h3">
                                <a id="follower-num"
                                   href="<?= Url::to(['/attention/space/follower', 'id' => $user->id]) ?>"><?= $user->extend->followers; ?></a>
                            </span>
                            <span><?= Yii::t('space', 'Fans') ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-10 border-top" style="color:#999;padding-top:10px; ">
                    <i class="fa fa-paw"></i> <?= Yii::t('space', '{n, plural, =0{No visitors} =1{One visitor} other{# visitors}}', ['n' => $user->extend->views]); ?>
                </div>
                <div class="mt-10 border-top" style="color:#999;">
                    <i class="fa fa-clock-o"></i> <?= Yii::t('space', 'Joined on {0, date}', $user->created_at) ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock(); ?>

<?php $this->beginContent('@app/views/layouts/' . $appLayouts . '.php') ?>
<div class="row mt-30">
    <div class="col-md-2">
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $user->id) {//Me
            $menuItems = [
                ['label' => Yii::t('space', 'My Page'), 'url' => ['/space/space/index']],
                //问答
                [
                    'label' => Yii::t('space', 'My Answers'),
                    'url' => ['/question/space/answer', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('question')
                ],
                [
                    'label' => Yii::t('space', 'My Questions'),
                    'url' => ['/question/space/question', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('question')
                ],
                //笔记
                [
                    'label' => Yii::t('space', 'My Notes'),
                    'url' => ['/note/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('note'),
                    'active' => Yii::$app->controller->module->id == "note" ? true : false],
                //文章
                [
                    'label' => Yii::t('space', 'My Articles'),
                    'url' => ['/article/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('article'),
                    'active' => Yii::$app->controller->module->id == "article" ? true : false],
                //代码
                [
                    'label' => Yii::t('space', 'My Codes'),
                    'url' => ['/code/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('code'),
                    'active' => Yii::$app->controller->module->id == "code" ? true : false
                ],
                //直播
                [
                    'label' => Yii::t('space', 'My Streams'),
                    'url' => ['/live/space/join', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('live'),
                    'active' => Yii::$app->controller->module->id == "live" ? true : false
                ],
                '<li role="separator" class="divider"></li>',
                ['label' => Yii::t('space', 'My Coin'), 'url' => ['/coin/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'My Credit'), 'url' => ['/credit/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'My Follower'), 'url' => ['/attention/space/follower', 'id' => $user->id]],
                ['label' => Yii::t('space', 'I\'m Following'), 'url' => ['/attention/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'My Favorites'), 'url' => ['/collection/space/index', 'id' => $user->id]],
            ];
        } else {//he
            $menuItems = [
                ['label' => Yii::t('space', 'His Page'), 'url' => ['/space/space/view', 'id' => $user->id]],
                //问答
                [
                    'label' => Yii::t('space', 'His Answer'),
                    'url' => ['/question/space/answer', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('question')
                ],
                [
                    'label' => Yii::t('space', 'His Questions'),
                    'url' => ['/question/space/question', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('question'),
                    'active' => Yii::$app->controller->action->id == "question" || Yii::$app->controller->action->id == "collected" ? true : false
                ],
                //笔记
                [
                    'label' => Yii::t('space', 'His Notes'),
                    'url' => ['/note/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('note'),
                    'active' => Yii::$app->controller->module->id == "note" ? true : false
                ],
                //文章
                [
                    'label' => Yii::t('space', 'His Articles'),
                    'url' => ['/article/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('article'),
                    'active' => Yii::$app->controller->module->id == "article" ? true : false
                ],
                //代码
                [
                    'label' => Yii::t('space', 'His Codes'),
                    'url' => ['/code/space/started', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('code'),
                    'active' => Yii::$app->controller->module->id == "code" ? true : false
                ],
                //直播
                [
                    'label' => Yii::t('space', 'His Streams'),
                    'url' => ['/live/space/join', 'id' => $user->id],
                    'visible' => Yii::$app->hasModule('live'),
                    'active' => Yii::$app->controller->module->id == "live" ? true : false
                ],
                '<li role="separator" class="divider"></li>',

                ['label' => Yii::t('space', 'His Coin'), 'url' => ['/coin/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'His Credit'), 'url' => ['/credit/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'His Follower'), 'url' => ['/attention/space/follower', 'id' => $user->id]],
                ['label' => Yii::t('space', 'His Followed'), 'url' => ['/attention/space/index', 'id' => $user->id]],
                ['label' => Yii::t('space', 'His Collect'), 'url' => ['/collection/space/index', 'id' => $user->id]],
            ];
        } ?>
        <?= Nav::widget([
            'options' => ['class' => 'nav nav-pills nav-stacked space-nav'],
            'activateParents' => true,
            'items' => $menuItems,
        ]); ?>
    </div>
    <div class="col-md-10">
        <?= $content ?>
    </div>
</div>


<?php $this->endContent() ?>
