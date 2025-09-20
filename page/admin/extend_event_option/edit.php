<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/head.php'); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/extend_event_option.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';

$id =  Util::getIdOfModel();
$db = new Db();
$initialStoryController = new Initial_story(new Initial_story_model($db),new Account_model($db));
$info = $initialStoryController->get($id);
if(empty($info)){
  header('Location: ' . ROOT . '/page/admin/extend_event_option/list.php');
  exit;
}
?>
<div id="backend">
<h1 id="orientation-remind">僅支援直向模式</h1>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/component/side-menu.php' ;
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/confirmLB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/alertLB.php';
?>
<section id="main">
      <section id="form">
        <h1>編輯延伸事件選項</h1>
        <a href="list.php" id="back">返回</a>
         <form id="extend-event-option-edit">
          <label for="">延伸事件</label>
          <div>  <select name="" id="extend-event" disabled>
            <option value="">請選擇延伸事件</option>
            <?php foreach($extendEventList as $k=>$v):?>
              <option  <?php if(htmlspecialchars($info['extend_event_id'])==htmlspecialchars($v['id'])){?>selected<?php }?> value="<?=$v['id']?>"><?=$v['name']?></option>
              <?php endforeach;?>
          </select><label for="" id="extend-event-error" class="error">必填</label></div>
          <label for="">名稱</label>
          <div><input type="text" id="name" value="<?= htmlspecialchars($info['name'])?>"><label for="" id="name-error" class="error">必填</label></div>
          <label for="">旁白</label>
          <div><textarea  id="voice-over"><?=htmlspecialchars($info['voice_over'])?></textarea><label for="" id="voice-over-error" class="error">必填</label></div>
          <label for="">是否直接觸發結局</label>
           <section >
            <label for=""><input type="radio" name="is-end" <?php if($info['is_end']==2){?>checked <?php } ?> value="2">是<input type="radio" name="is-end" <?php if($info['is_end']==1){?>checked <?php } ?> value="1">否</label>
          </section>
          <label for="">清醒度調整</label>
          <div><input type="number" value="<?=$info['awake_degree_adjust']?>"  id="awake-degree-adjust"><label for="" id="awake-degree-adjust-error">必填</label></div>
          <section id="button">
            <button type="submit">提交</button>
           <button id="cancel">取消</button>
          </section>
        </form>
      </section>
      </section>
    </div>
    <script src="<?=ROOT.'/js/page/admin/extend_event_option/edit.js'?>" type="module"></script>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/component/foot.php'); ?>