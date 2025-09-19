<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/head.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/extend_event.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/initial_situation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';

$id =  Util::getIdOfModel();
$db = new Db();
$extendEventController = new Extend_event(new Extend_event_model($db),new Account_model($db));
$info = $extendEventController->get($id);
if(empty($info)){
  header('Location: ' . ROOT . '/page/admin/extend_event/list.php');
  exit;
}
$initialSituationController = new Joke_category(new Joke_category_model($db),new Account_model($db));
$initialSituationList = $initialSituationController->index(); 


?>
<div id="backend">
<h1 id="orientation-remind">僅支援直向模式</h1>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/component/slide-menu.php' ; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/confirmLB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/alertLB.php';
?>
<section id="main">
      <section id="form">
        <h1>編輯初始境遇</h1>
        <a href="list.php" id="back">返回</a>
        <form id="initial-situation-edit">
          <label for="">名稱</label>
          <div> <input type="text" id="name" value="<?=htmlspecialchars($info['name'])?>" placeholder="請輸入名稱"><label for="" id="name-error" class="error">必填</label></div>
          <label for="">旁白</label>
          <div><textarea name="" id="voice-over"><?=htmlspecialchars($info['voice_over'])?></textarea><label for="" id="voice-over-error" class="error">必填</label></div>
          <label for="">清醒度</label>
          <div><input type="number" min="2" value="<?=htmlspecialchars($info['awake_degree'])?>"  id="awake-degree"><label for="" id="awake-degree-error">必填</label></div>
          <label for="">圖片</label>
          <label for="image" id="upload-image">
            <img src="<?= empty($info['image'])? ROOT.'/image/upload-image.png':ROOT.$info['image']?>" id="upload-image-source" alt="upload-image">
          </label>
          <input type="file" name="" id="image" accept="image/png,image/jpg,image/jpeg,image/gif">
          <span id="image-remind">圖片格式：JPG,PNG,GIF</span>
          <section id="button">
            <button type="submit">提交</button>
           <button id="cancel">取消</button>
          </section>
        </form>
      </section>
      </section>
    </div>
    <script src="<?=ROOT.'/js/page/admin/initial_situation/edit.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>