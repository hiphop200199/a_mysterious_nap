<?php
$manage = $path_array[3];//從head.php取得path_array變數
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/loading.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/account.php';
$account = new Account(new Account_model(new Db()));
?>
<button id="hamburger-menu">☰</button>
<section id="side-menu">
  <div id="img-box">
    <h1 id="logo">A Mysterious Nap</h1>
  </div>
  <h4>Hi!<?= htmlspecialchars($account->data['account']['name'])?></h4>
  <a class="<?= htmlspecialchars($manage) == 'account' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/account/list.php' ?>">帳號管理</a>
 <a class="<?= htmlspecialchars($manage) == 'initial_story' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/initial_story/list.php' ?>">初始故事管理</a>
  <a class="<?= htmlspecialchars($manage) == 'initial_situation' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/initial_situation/list.php' ?>">初始境遇管理</a>
  <a class="<?= htmlspecialchars($manage) == 'extend_event' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/extend_event/list.php' ?>">延伸事件管理</a>
 <a class="<?= htmlspecialchars($manage) == 'extend_event_option' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/extend_event_option/list.php' ?>">延伸事件選項管理</a>
 <a class="<?= htmlspecialchars($manage) == 'extend_event_result' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/extend_event_result/list.php' ?>">延伸事件結果管理</a>
 <a class="<?= htmlspecialchars($manage) == 'ending' ? 'active' : ''; ?> " href="<?= ROOT . '/page/admin/ending/list.php' ?>">結局管理</a>
  <a id="logout">登出</a>
</section>
<script>
  const hamburgerMenu = document.getElementById('hamburger-menu')
  const sideMenu = document.getElementById('side-menu')
  const logoutBtn = document.getElementById('logout')
  const loading = document.getElementById("loading-mask");
  const SUCCESS = 1;
  

  hamburgerMenu.addEventListener('click', function() {
    this.classList.toggle('open')
    sideMenu.classList.toggle('open')
  })

  logoutBtn.addEventListener('click', async function() {

    try {
      const param = {
        manage: "index",
        task: "logout",
      };
     
      loading.style.display = "block";
      const response = await logout(param);
     
      console.log(response);
      if(response.data.errCode === SUCCESS){
        location.href = response.data.redirect
      }
    } catch (error) {
      console.log(error);
    }
  })

  async function logout(param){
     const response = await  axios.post('https://a-mysterious-nap.infinityfreeapp.com/controller/admin/index.php',param);
    return response;
  }
</script>