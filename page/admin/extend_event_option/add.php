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
        <h1>新增延伸事件選項</h1>
        <a href="list.php" id="back">返回</a>
        <form id="extend-event-option-add">
          <label for="">延伸事件</label>
          <div>  <select name="" id="extend-event">
            <option value="">請選擇延伸事件</option>
            <?php foreach($extendEventList as $k=>$v):?>
              <option value="<?=$v['id']?>"><?=$v['name']?></option>
              <?php endforeach;?>
          </select><label for="" id="extend-event-error" class="error">必填</label></div>
          <label for="">名稱</label>
          <div><input type="text" id="name"><label for="" id="name-error" class="error">必填</label></div>
          <label for="">旁白</label>
          <div><textarea name="" id="voice-over"></textarea><label for="" id="voice-over-error" class="error">必填</label></div>
          <label for="">是否直接觸發結局</label>
           <section >
            <label for=""><input type="radio" name="is-end"  value="2">是<input type="radio" name="is-end" checked value="1">否</label>
          </section>
          <label for="">清醒度調整</label>
          <div><input type="number"  id="awake-degree-adjust"><label for="" id="awake-degree-adjust-error">必填</label></div>
          <section id="button">
            <button type="submit">提交</button>
           <button id="cancel">取消</button>
          </section>
        </form>
      </section>
      </section>
    </div>
    <script src="<?=ROOT.'/js/page/admin/extend_event_option/add.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>