<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/head.php'); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/extend_event_option.php';
$db = new Db();
$endingController = new Initial_story(new Initial_story_model($db),new Account_model($db));
$list = $endingController->index();
?>
    <div id="backend">
    <h1 id="orientation-remind">僅支援直向模式</h1>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/component/side-menu.php' ;
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/confirmLB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/alertLB.php';
?>
      <section id="list">
      <div id="function">
        <a href="add.php">新增延伸事件選項</a>
       </div>
        <table>
          <thead>
            <tr>
              <th>id</th>
              <th>名稱</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($list as $k=>$v):?> 
            <tr>
              <td><?=htmlspecialchars($v['id'])?></td>
              <td><?=htmlspecialchars($v['name'])?></td>
              <td class="operation">        
                <a href="edit.php?id=<?=htmlspecialchars($v['id'])?>" class="edit">🖊</a> <a data-id="<?=htmlspecialchars($v['id'])?>" class="delete">🗑</a>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <div id="grid">
        <?php foreach($list as $k=>$v):?>
          <div class="item">        
            <p>id:<?=htmlspecialchars($v['id'])?></p>
            <p>名稱:<?=htmlspecialchars($v['name'])?></p>
            <section class="button">
                <a href="edit.php?id=<?=htmlspecialchars($v['id'])?>" class="edit">🖊</a> <a data-id="<?=htmlspecialchars($v['id'])?>" class="delete">🗑</a>
            </section>
          </div>
          <?php endforeach;?>
        </div>
      </section>
    </div>
    <script src="<?=ROOT.'/js/page/admin/extend_event_option/list.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>
