import { SUCCESS } from "../constant.js";
import { backend } from "../../request_model.js";

const form = document.getElementById("extend-event-add");
const initialSituation = document.getElementById("initial-situation");
const initialSituationError = document.getElementById("initial-situation-error");
const name = document.getElementById("name");
const nameError = document.getElementById("name-error");
const voiceOver = document.getElementById("voice-over");
const voiceOverError = document.getElementById("voice-over-error");
const imageFile = document.getElementById('image');
const imageSource = document.getElementById('upload-image-source')
const cancel = document.getElementById("cancel");
const loading = document.getElementById("loading-mask");
const alertLB = document.getElementById("alert-mask");
const alertMessage = document.getElementById("alert-message");
const alertBtn = document.getElementById("submit-alert");


initialSituation.addEventListener("change", checkInitialSituationId);
name.addEventListener("change", checkName);
voiceOver.addEventListener("change",checkVoiceOver);


imageFile.addEventListener('change',function(e){
  const file = imageFile.files[0]
  const allowFileTypes = ['image/png','image/jpg','image/jpeg','image/gif']
  

  if(!allowFileTypes.includes(file.type)){
      imageFile.value = ''
    alertMessage.innerText = '檔案格式不符'
    alertBtn.onclick = function(){
      alertLB.style.display = 'none'
    }
    alertLB.style.display = 'block'
    return;
  }

  const reader = new FileReader()
  reader.onload = function(e){
    imageSource.src = e.target.result;
  }
  reader.readAsDataURL(file);

})


form.addEventListener("submit", async function (e) {
  e.preventDefault();
  checkInitialSituationId();
  checkName();
  checkVoiceOver();
  if(!initialSituation.value||!name.value||!voiceOver.value)return;
 
  try {
    const param = {
      initial_situation_id: initialSituation.value,
      name:name.value,
      voice_over:voiceOver.value,
      image:imageFile.files[0],
      manage: "extend_event",
      task: "create",
    };
    loading.style.display = "block";
    const response = await backend(param);
    loading.style.display = "none";
    console.log(response);

    if (response.data.errCode === SUCCESS) {
      alertMessage.innerText = "成功";
      alertBtn.onclick = function () {
        location.href = "list.php";
      };
      alertLB.style.display = "block";
      console.log(response);
    } else {
      alertMessage.innerText = "系統錯誤";
      alertBtn.onclick = function () {
        alertLB.style.display = "none";
      };
      alertLB.style.display = "block";
    }
  } catch (error) {
    console.log(error);
  }
});

cancel.addEventListener("click", function (e) {
  e.preventDefault();
  location.href = "list.php";
});

function checkName() {
  if (!name.value) {
    nameError.style.display = "inline";
    return;
  }
  nameError.style.display = "none";
}

function checkVoiceOver(){
  if (!voiceOver.value) {
    voiceOverError.style.display = "inline";
    return;
  }
  voiceOverError.style.display = "none";
}

function checkInitialSituationId(){
  if (!initialSituation.value) {
    initialSituationError.style.display = "inline";
    return;
  }
  initialSituationError.style.display = "none";
}