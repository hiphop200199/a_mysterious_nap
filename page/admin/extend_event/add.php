<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/head.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/initial_situation.php';

$db = new Db();
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
        <h1>新增延伸事件</h1>
        <a href="list.php" id="back">返回</a>
        <form id="extend-event-add">
          <label for="">初始境遇</label>
          <div>  <select name="" id="initial-situation">
            <option value="">請選擇初始境遇</option>
            <?php foreach($initialSituationList as $k=>$v):?>
              <option value="<?=$v['id']?>"><?=$v['name']?></option>
              <?php endforeach;?>
          </select><label for="" id="initial-situation-error" class="error">必填</label></div>
          <label for="">名稱</label>
          <div> <input type="text" id="name" placeholder="請輸入名稱"><label for="" id="name-error" class="error">必填</label></div>
          <label for="">旁白</label>
          <div><textarea name="" id="voice-over"></textarea><label for="" id="voice-over-error" class="error">必填</label></div>
          <label>圖片</label>
          <label for="image" id="upload-image">
            <img src="<?=ROOT.'/image/upload-image.png'?>" id="upload-image-source" alt="upload-image">
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
    <script src="<?=ROOT.'/js/page/admin/extend_event/add.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>