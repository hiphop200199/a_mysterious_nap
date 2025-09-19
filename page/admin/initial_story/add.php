<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/head.php');?>
<div id="backend">
<h1 id="orientation-remind">僅支援直向模式</h1>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/component/side-menu.php' ; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/confirmLB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/alertLB.php';
?>
<section id="main">
      <section id="form">
        <h1>新增初始故事</h1>
        <a href="list.php" id="back">返回</a>
        <form id="initial-story-add">
          <label for="">名稱</label>
          <div><input type="text" id="name"><label for="" id="name-error" class="error">必填</label></div>
          <label for="">旁白</label>
          <div><textarea name="" id="voice-over"></textarea><label for="" id="voice-over-error" class="error">必填</label></div>
          <section id="button">
            <button type="submit">提交</button>
           <button id="cancel">取消</button>
          </section>
        </form>
      </section>
      </section>
    </div>
    <script src="<?=ROOT.'/js/page/admin/initial_story/add.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>