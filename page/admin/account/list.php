<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/component/head.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/account.php';
$accountController = new Account(new Account_model(new Db()));
$list = $accountController->index();
?>
<div class="backend">
  <h1 class="orientation-remind">僅支援直向模式</h1>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/component/side-menu.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/component/confirmLB.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/component/alertLB.php';
  ?>
  <section class="list">
    <div class="function">
    </div>
    <table>
      <thead>
        <tr>
          <th>id</th>
          <th>帳號</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $k => $v): ?>
          <tr>
            <td><?= htmlspecialchars($v['id']); ?></td>
            <td><?= htmlspecialchars($v['account']); ?></td>
            <td class="operation"><a href="edit.php?id=<?= htmlspecialchars($v['id']); ?>" class="edit">🖊</a> <?php if($accountController->data['account']['is_admin']==IS_ADMIN){?><a data-id="<?= htmlspecialchars($v['id']); ?>" class="delete">🗑</a><?php }?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="grid">
        <?php foreach ($list as $k => $v): ?>
      <div class="item">
          <p>id:<?= htmlspecialchars($v['id']); ?></p>
          <p>帳號:<?= htmlspecialchars($v['account']); ?></p>
          <section class="button">
            <a href="edit.php?id=<?= htmlspecialchars($v['id']); ?>" class="edit">🖊</a> <?php if($accountController->data['account']['is_admin']==IS_ADMIN){?><a data-id="<?= htmlspecialchars($v['id']); ?>" class="delete">🗑</a><?php }?>
          </section>
      </div>
    <?php endforeach; ?>
    </div>
  </section>
</div>
<script src="<?=ROOT.'/js/page/admin/account/list.js'?>" type="module"></script>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/component/foot.php'); ?>