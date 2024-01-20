// 去登录按钮
const toSignInButton = document.getElementById("toSignIn");

// 去注册按钮
const toSignUpButton = document.getElementById("toSignUp");

const signInForm = document.getElementById("signInForm");

const container = document.querySelector(".container");

// 登录按钮监听器
toSignInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

toSignUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});
// 提交登录表单
signInForm.addEventListener("submit", (e) => {
  e.preventDefault(); // 阻止表单默认提交

  // 获取用户输入的邮箱和密码
  const email = document.getElementById("login_email").value;
  const password = document.getElementById("login_password").value;

  // 检查邮箱和密码是否都填写了
  if (email.trim() === "" || password.trim() === "") {
    // 如果邮箱或密码未填写，则禁用登录按钮
    alert("请输入邮箱和密码");
    return;
  }

  // 创建一个新的XMLHttpRequest对象
  const xhr = new XMLHttpRequest();

  // 配置请求
  xhr.open("POST", "login.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // 构建表单数据
  const formData = `login=true&login_email=${encodeURIComponent(email)}&login_password=${encodeURIComponent(password)}`;

  // 设置回调函数，处理响应
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        if (data.success) {
          // 登录成功，跳转页面或执行其他操作
          alert("登录成功");
          window.location.href = "index.html";
        } else {
          // 登录失败，显示错误消息
          alert(data.message);
        }
      } else {
        // 请求发生错误
        console.error("登录请求错误:", xhr.statusText);
      }
    }
  };

  // 发送请求
  xhr.send(formData);
});
