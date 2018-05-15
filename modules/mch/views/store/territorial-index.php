<?php
defined('YII_RUN') or exit('Access Denied');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 11:14
 */

$urlManager = Yii::$app->urlManager;
$this->title = '区域限制购买';
$this->params['active_nav_group'] = 1;
?>
<div class="panel mb-3">
    <div class="panel-header">
        <span><?= $this->title ?></span>
    </div>
    <div class="panel-body">
        <table class="table table-bordered bg-white">
            <tr>
                <th style="width:20%;">是否开启</th>
                <th>操作</th>
            </tr>
                <tr>
                    <td>
                        <?php if ($model->is_enable == 0): ?>
                            <span>关闭</span>
                        <?php else: ?>
                            <span>开启</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary"
                           href="<?= $urlManager->createUrl(['mch/store/territorial-limitation', 'id' => $model->id]) ?>">修改</a>
                    </td>
                </tr>
        </table>
    </div>
</div>
<script>

    $(document).on('change', '.default-rule-checkbox', function () {
        $.loading();
        location.href = $(this).attr('data-url');
    });

    $(document).on('click', '.rules-del', function () {
        var a = $(this);
        $.confirm({
            content: "是否删除该规则？",
            confirm: function () {
                $.loading({
                    content: "正在处理",
                });
                $.ajax({
                    url: a.attr("href"),
                    dataType: "json",
                    success: function (res) {
                        $.loadingHide();
                        $.alert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            }
        });
        return false;
    });
</script>