<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 11:55
 */
defined('YII_RUN') or exit('Access Denied');
use yii\widgets\LinkPager;

/* @var \app\models\User $user */

$urlManager = Yii::$app->urlManager;
$statics = Yii::$app->request->baseUrl . '/statics';
$this->title = '分销订单';
$this->params['active_nav_group'] = 5;
$status = Yii::$app->request->get('status');
$order_type = Yii::$app->request->get('order_type');
$get = Yii::$app->request->get();
$parent_id = Yii::$app->request->get('parent_id');
$condition = ['parent_id' => $parent_id];
if ($status === '' || $status === null || $status == -1)
    $status = -1;
if($order_type === '' || $order_type === null || $order_type === -1){
    $order_type = -1;
}
$ignore = ['yy'];
$type = [
    's'=>'商城订单',
    'ms'=>'秒杀订单',
    'pt'=>'拼团订单',
    'yy'=>'预约订单',
];
?>
    <style>
        .order-item {
            border: 1px solid transparent;
            margin-bottom: 1rem;
        }

        .order-item table {
            margin: 0;
        }

        .order-item:hover {
            border: 1px solid #3c8ee5;
        }

        .goods-item {
            margin-bottom: .75rem;
        }

        .goods-item:last-child {
            margin-bottom: 0;
        }

        .goods-pic {
            width: 5.5rem;
            height: 5.5rem;
            display: inline-block;
            background-color: #ddd;
            background-size: cover;
            background-position: center;
            margin-right: 1rem;
        }

        .goods-name {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .order-tab-1 {
            width: 40%;
        }

        .order-tab-2 {
            width: 15%;
            text-align: center;
        }

        .order-tab-3 {
            width: 10%;
            text-align: center;
        }

        .order-tab-4 {
            width: 15%;
            text-align: center;
        }

        .order-tab-5 {
            width: 30%;
            text-align: center;
        }

        .status-item.active {
            color: inherit;
        }
    </style>
    <div class="panel mb-3">
        <div class="panel-header"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="mb-3 clearfix">
                <div class="p-4 bg-shaixuan">
                    <form method="get">
                        <?php $_s = ['keyword'] ?>
                        <?php foreach ($_GET as $_gi => $_gv):if (in_array($_gi, $_s)) continue; ?>
                            <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
                        <?php endforeach; ?>
                        <div flex="dir:left">
                            <div>
                                <div class="input-group">
                                    <input class="form-control"
                                           placeholder="订单号/用户"
                                           name="keyword"
                                           autocomplete="off"
                                           value="<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : null ?>">
                    <span class="input-group-btn">
                    <button class="btn btn-primary">搜索</button>
                </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mt-2">
                        <?php if ($user): ?>
                            <span class="status-item mr-3">分销商：<?= $user->nickname ?>的下级订单</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <ul class="nav nav-tabs status">
                    <li class="nav-item">
                        <a class="status-item nav-link <?= $order_type == -1 ? 'active' : null ?>"
                           href="<?= $urlManager->createUrl(array_merge([$_GET['r']])) ?>">全部</a>
                    </li>
                    <li class="nav-item">
                        <a class="status-item nav-link <?= $order_type == 's' ? 'active' : null ?>"
                           href="<?= $urlManager->createUrl(array_merge([$_GET['r']], $condition, ['order_type' => 's'])) ?>">商城订单</a>
                    </li>
                    <li class="nav-item">
                        <a class="status-item nav-link <?= $order_type == 'ms' ? 'active' : null ?>"
                           href="<?= $urlManager->createUrl(array_merge([$_GET['r']], $condition, ['order_type' => 'ms'])) ?>">秒杀订单</a>
                    </li>
                    <li class="nav-item">
                        <a class="status-item nav-link <?= $order_type == 'pt' ? 'active' : null ?>"
                           href="<?= $urlManager->createUrl(array_merge([$_GET['r']], $condition, ['order_type' => 'pt'])) ?>">拼团订单</a>
                    </li>
                    <li class="nav-item">
                        <a class="status-item nav-link <?= $order_type == 'yy' ? 'active' : null ?>"
                           href="<?= $urlManager->createUrl(array_merge([$_GET['r']], $condition, ['order_type' => 'yy'])) ?>">预约订单</a>
                    </li>
                </ul>
            </div>
            <table class="table table-bordered bg-white">
                <tr>
                    <th class="order-tab-1">商品信息</th>
                    <th class="order-tab-2">金额</th>
                    <th class="order-tab-4">订单状态</th>
                    <th class="order-tab-5" colspan="3">分销情况</th>
                </tr>
            </table>
            <?php foreach ($list as $order_item): ?>
                <div class="order-item">
                    <table class="table table-bordered bg-white">
                        <tr>
                            <td colspan="5">
                                <span class="mr-5"><?= date('Y-m-d H:i:s', $order_item['addtime']) ?></span>
                                <span class="mr-5">订单号：<?= $order_item['order_no'] ?></span>
                                <span class="mr-5">用户：<?= $order_item['nickname'] ?></span>
                                <span>订单类型：<?= $type[$order_item['order_type']] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="order-tab-1">
                                <?php foreach ($order_item['goods_list'] as $goods_item): ?>
                                    <div class="goods-item" flex="dir:left box:first">
                                        <div class="fs-0">
                                            <div class="goods-pic"
                                                 style="background-image: url('<?= $goods_item['pic'] ?>')"></div>
                                        </div>
                                        <div class="goods-info">
                                            <div class="goods-name"><?= $goods_item['name'] ?></div>
                                            <?php if (!in_array($order_item['order_type'], $ignore)): ?>
                                                <div class="fs-sm">
                                                    规格：
                                        <span class="text-danger">
                                            <?php $attr_list = json_decode($goods_item['attr']); ?>
                                            <?php if (is_array($goods_item['attr_list'])):foreach ($goods_item['attr_list'] as $attr): ?>
                                                <span class="mr-3"><?= $attr->attr_group_name ?>
                                                    :<?= $attr->attr_name ?></span>
                                            <?php endforeach;;endif; ?>
                                        </span>
                                                </div>
                                                <div class="fs-sm">数量：
                                                    <span class="text-danger"><?= $goods_item['num'] ?>件</span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="fs-sm">小计：
                                                <span class="text-danger"><?= $goods_item['total_price'] ?>元</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                            <td class="order-tab-2">
                                <div>实际付款：<?= $order_item['pay_price'] ?>元</div>
                            </td>
                            <td class="order-tab-4">
                                <div>
                                    付款状态：
                                    <?php if ($order_item['is_pay'] == 1): ?>
                                        <span class="badge badge-success">已付款</span>
                                    <?php else: ?>
                                        <span class="badge badge-default">未付款</span>
                                    <?php endif; ?>
                                </div>


                                <?php if ($order_item['apply_delete'] == 1): ?>
                                    <div>
                                        申请取消：
                                        <span class="badge badge-warning">申请中</span>
                                    </div>
                                <?php endif; ?>


                                <?php if (!in_array($order_item['order_type'], $ignore)): ?>
                                    <?php if ($order_item['is_pay'] == 1): ?>
                                        <div>
                                            发货状态：
                                            <?php if ($order_item['is_send'] == 1): ?>
                                                <span class="badge badge-success">已发货</span>
                                            <?php else: ?>
                                                <span class="badge badge-default">未发货</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($order_item['is_send'] == 1): ?>
                                        <div>
                                            收货状态：
                                            <?php if ($order_item['is_confirm'] == 1): ?>
                                                <span class="badge badge-success">已收货</span>
                                            <?php else: ?>
                                                <span class="badge badge-default">未收货</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($order_item['is_price'] == 1): ?>
                                        <div>
                                            佣金发放状态：<span class="badge badge-success">佣金已发放</span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($order_item['is_send'] == 1): ?>
                                        <?php if ($order_item['is_offline'] == 0): ?>
                                            <div>快递单号：<a
                                                    href="https://www.baidu.com/s?wd=<?= $order_item['express_no'] ?>"
                                                    target="_blank"><?= $order_item['express_no'] ?></a></div>
                                            <div>快递公司：<?= $order_item['express'] ?></div>
                                        <?php elseif ($order_item['is_offline'] == 1): ?>
                                            <div>核销员：<?= $order_item['clerk_name'] ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>

                                    <?php if ($order_item['is_pay'] == 1): ?>
                                        <?php if ($order_item['is_use'] == 0): ?>
                                            <div>
                                                使用状态：<span class="badge badge-default">未使用</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($order_item['is_use'] == 1): ?>
                                            <div>
                                                使用状态：<span class="badge badge-default">已使用</span>
                                            </div>
                                            <div>
                                                佣金发放状态：<span class="badge badge-success">佣金已发放</span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </td>
                            <td class="order-tab-5">
                                <div flex="dir:left">
                                    <div class="p-2 text-left">
                                        <div>昵称：<?= $order_item['share']['nickname'] ?></div>
                                        <div><?= $order_item['share']['name'] ? "姓名：" . $order_item['share']['name'] : "" ?></div>
                                        <div><?= $order_item['share']['mobile'] ? "电话：" . $order_item['share']['mobile'] : "" ?></div>
                                        <div>一级佣金：<?= floatval($order_item['first_price']) ?>元</div>
                                    </div>
                                    <?php if ($order_item['share_1']): ?>
                                        <div class="p-2 text-left">
                                            <div>昵称：<?= $order_item['share_1']['nickname'] ?></div>
                                            <div><?= $order_item['share_1']['name'] ? "姓名：" . $order_item['share_1']['name'] : "" ?></div>
                                            <div><?= $order_item['share_1']['mobile'] ? "电话：" . $order_item['share_1']['mobile'] : "" ?></div>
                                            <div>二级佣金：<?= floatval($order_item['second_price']) ?>元</div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($order_item['share_2']): ?>
                                        <div class="p-2 text-left">
                                            <div>昵称：<?= $order_item['share_2']['nickname'] ?></div>
                                            <div><?= $order_item['share_2']['name'] ? "姓名：" . $order_item['share_2']['name'] : "" ?></div>
                                            <div><?= $order_item['share_2']['mobile'] ? "电话：" . $order_item['share_2']['mobile'] : "" ?></div>
                                            <div>三级佣金：<?= floatval($order_item['third_price']) ?>元</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($order_item['rebate'] > 0): ?>
                                    <div class="p-2 text-left">
                                        <div>自购返利：<?= floatval($order_item['rebate']) ?>元</div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if (!in_array($order_item['order_type'], $ignore)): ?>
                            <tr>
                                <td colspan="5">
                                    <div>
                                        <span class="mr-3">收货人：<?= $order_item['name'] ?></span>
                                        <span class="mr-3">电话：<?= $order_item['mobile'] ?></span>
                                        <?php if ($order_item['is_offline'] == 0): ?>
                                            <span>地址：<?= $order_item['address'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($order_item['shop_id']): ?>
                                        <div>
                                            <span class="mr-3">门店名称：<?= $order_item['shop']['name'] ?></span>
                                            <span class="mr-3">门店地址：<?= $order_item['shop']['address'] ?></span>
                                            <span class="mr-3">电话：<?= $order_item['shop']['mobile'] ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div><span>备注：<?= $order_item['content'] ?></span></div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>
            <div class="text-center">
                <?= LinkPager::widget(['pagination' => $pagination,]) ?>
                <div class="text-muted"><?= $row_count ?>条数据</div>
            </div>
        </div>
    </div>
<?= $this->render('/layouts/ss'); ?>