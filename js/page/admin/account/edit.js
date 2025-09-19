import { SUCCESS } from "../constant.js";
import { backend } from "../../request_model.js";

const form = document.getElementById("account-edit");
const account = document.getElementById("account");
const accountError = document.getElementById('account-error')
const passwordLB = document.getElementById('password-mask')
const openPassword = document.getElementById('password-btn')
const closePassword = document.getElementById('close-password')
const submitPassword = document.getElementById('submit-password')
const newPassword = document.getElementById("new-password");
const newPasswordError = document.getElementById('new-password-error')
const confirmPassword = document.getElementById('confirm-password')
const comfirmPasswordError = document.getElementById('confirm-password-error')
const cancel = document.getElementById("cancel");
const loading = document.getElementById("loading-mask");
const alertLB = document.getElementById("alert-mask");
const alertMessage = document.getElementById("alert-message");
const alertBtn = document.getElementById("submit-alert");
const query = new URLSearchParams(location.search)
const id = query.get('id')



account.addEventListener('change',checkAccount);
newPassword.addEventListener('change',checkNewPassword);
confirmPassword.addEventListener('change',checkConfirmPassword)

form.addEventListener("submit", async function (e) {
    e.preventDefault();
    checkAccount()
   
    if(!account.value)return;
   
  try {
    const param = {
      id:id,  
      account: account.value,
      manage: "account",
      task: "edit",
    };
   loading.style.display = 'block';
      const response = await backend(param);
      loading.style.display = 'none';
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
    console.log(error)
  }
});

submitPassword.addEventListener('click',async function(e){
    e.preventDefault()
    checkNewPassword()
    checkConfirmPassword()
    if(!newPassword.value||!confirmPassword.value||newPassword.value!=confirmPassword.value)return;
    try {
        const param = {
          id:id,  
          newPassword:newPassword.value,
          confirmPassword:confirmPassword.value,  
          manage: "account",
          task: "edit-password",
        };
        passwordLB.style.display = 'none'
       loading.style.display = 'block';
          const response = await editPassword(param);
          loading.style.display = 'none';
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
        console.log(error)
      }
})

openPassword.addEventListener('click',function(e){
    e.preventDefault()
    passwordLB.style.display = 'block'
})

closePassword.addEventListener('click',function(e){
    e.preventDefault()
    passwordLB.style.display = 'none'
    newPassword.value = ''
    confirmPassword.value = ''
    newPasswordError.style.display = 'none'
    comfirmPasswordError.style.display = 'none'
})

cancel.addEventListener("click", function (e) {
    e.preventDefault();
    location.href = "list.php";
  });
  
  function checkAccount() {
    if (!account.value) {
      accountError.style.display = "inline";
      return;
    }
    accountError.style.display = "none";
  }

  function checkNewPassword(){
    if (!newPassword.value) {
      newPasswordError.style.display = "inline";
      return;
    }
    newPasswordError.style.display = "none";
  }

  function checkConfirmPassword(){
    if (!confirmPassword.value||newPassword.value!=confirmPassword.value) {
      comfirmPasswordError.style.display = "inline";
      return;
    }
    comfirmPasswordError.style.display = "none";
  }