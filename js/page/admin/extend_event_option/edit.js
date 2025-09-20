import { SUCCESS } from "../constant.js";
import { backend } from "../../request_model.js";


const form = document.getElementById("extend-event-option-edit");
const name = document.getElementById("name");
const nameError = document.getElementById("name-error");
const voiceOver = document.getElementById("voice-over");
const voiceOverError = document.getElementById("voice-over-error");
const awakeDegreeAdjust = document.getElementById("awake-degree-adjust");
const awakeDegreeAdjustError = document.getElementById("awake-degree-adjust-error");
const cancel = document.getElementById("cancel");
const loading = document.getElementById("loading-mask");
const alertLB = document.getElementById("alert-mask");
const alertMessage = document.getElementById("alert-message");
const alertBtn = document.getElementById("submit-alert");
const query = new URLSearchParams(location.search);
const id = query.get("id");
let isEnd = 1;


name.addEventListener("change", checkName);
voiceOver.addEventListener("change", checkVoiceOver);
awakeDegreeAdjust.addEventListener("change",checkAwakeDegreeAdjust);



form.addEventListener("submit", async function (e) {
  e.preventDefault();
  checkName();
  checkVoiceOver();
  checkAwakeDegreeAdjust();
  if (!name.value||!voiceOver.value||!awakeDegreeAdjust.value) return;
 let radios = document.querySelectorAll('input[name="is-end"]');
  for (let i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      isEnd = radios[i].value;
      break;
    }
  }
  try {
    const param = {
      id: id,
      name: name.value,
      voice_over: voiceOver.value,
      is_end:isEnd,
      awake_degree_adjust:awakeDegreeAdjust.value,
      manage: "extend_event_option",
      task: "edit",
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

function checkVoiceOver() {
  if (!voiceOver.value) {
    voiceOverError.style.display = "inline";
    return;
  }
  voiceOverError.style.display = "none";
}

function checkAwakeDegreeAdjust() {
  if (!awakeDegreeAdjust.value) {
    awakeDegreeAdjustError.style.display = "inline";
    return;
  }
  awakeDegreeAdjustError.style.display = "none";
}