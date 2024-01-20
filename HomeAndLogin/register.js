const signUpForm = document.getElementById("signUpForm");

// 绑定失去焦点事件
const usernameInput = document.getElementById("registerUserName");
const emailInput = document.getElementById("registerEmail");
const passwordInput = document.getElementById("registerPassword");
const confirmInput = document.getElementById("registerConfirmPassword");

usernameInput.addEventListener("blur", () => {
  validateUsername(usernameInput.value);
});

emailInput.addEventListener("blur", () => {
  validateEmail(emailInput.value);
});

passwordInput.addEventListener("blur", () => {
  validatePassword(passwordInput.value);
});

confirmInput.addEventListener("blur", () => {
  validateConfirmPassword(confirmInput.value);
});

///////////////////// 以下为表单验证///////////////////////
function validateUsername(username) {
  var reg_username = /^\w{4,16}$/;
  var flag_username = reg_username.test(username);
  document.getElementById("s_username").innerText = flag_username
    ? ""
    : "用户名格式有误";
  return flag_username;
}

function validateEmail(email) {
  var reg_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  var flag_email = reg_email.test(email);
  document.getElementById("s_email").innerText = flag_email
    ? ""
    : "邮箱格式有误,请输入真实邮箱";
  return flag_email;
}

function validatePassword(password) {
  var reg_password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,16}$/;
  var flag_password = reg_password.test(password);
  document.getElementById("s_password").innerText = flag_password
    ? ""
    : "密码格式有误";
  return flag_password;
}

function validateConfirmPassword(confirm_password) {
  var flag_confirm_password =
    document.getElementById("registerPassword").value === confirm_password;
  document.getElementById("s_confirm_password").innerText =
    flag_confirm_password ? "" : "密码不匹配";
  return flag_confirm_password;
}
// const signUpForm = document.getElementById("signUpForm");

// ...（其他代码保持不变）

signUpForm.addEventListener("submit", (event) => {
  event.preventDefault(); // 阻止表单默认提交

  const username = usernameInput.value;
  const email = emailInput.value;
  const password = passwordInput.value;
  const confirm_password = confirmInput.value;

// 创建 XMLHttpRequest 对象
  const xhr = new XMLHttpRequest();

// 配置请求
  xhr.open("POST", "register.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        console.log("响应状态码:", xhr.status);
        console.log("响应内容:", xhr.responseText);

// 成功接收响应
        try {
          const data = JSON.parse(xhr.responseText);
          if (data.success) {
            alert("注册成功");
// 注册成功，执行成功操作，例如跳转页面
// window.location.href = "登录成功后跳转的页面URL";
          } else {
// 注册失败，显示错误消息或采取其他操作
            alert(data.message);
          }
        } catch (e) {
// 解析JSON出错，显示错误消息或采取其他操作
          console.error("解析JSON出错:", e);
          alert("注册响应出错，请重试");
        }
      } else {
// 请求出错，显示错误消息或采取其他操作
        console.error("注册请求错误:", xhr.status);
        alert("注册请求出错，请重试");
      }
    }
  };

// 设置请求头
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

// 构建表单数据
//   const formData = `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirm_password)}`;
  const formData = `register=true&username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirm_password)}`;

// 发送请求
  xhr.send(formData);
});
