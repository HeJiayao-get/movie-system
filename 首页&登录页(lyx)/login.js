// 去登录按钮
const toSignInButton = document.getElementById("toSignIn");

// 去注册按钮
const toSignUpButton = document.getElementById("toSignUp");

const signInForm = document.getElementById("signInForm");

const container = document.querySelector(".container");

// 登录按钮监听器
toSignInButton.addEventListener("click", () => {
  //自上而下解析=>onload
  container.classList.remove("right-panel-active");
});

toSignUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// 假设你的登录表单中的输入字段有正确的id：'email'和'password'
signInForm.addEventListener("submit", (e) => e.preventDefault());

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

  const formData = new FormData(signInForm);
  formData.append("email", email);
  formData.append("password", password);
  fetch("login.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json()) // 解析JSON响应
    .then((data) => {
      if (data.success) {
        // 登录成功，跳转页面或执行其他操作
        alert("登录成功");
        window.location.href = "index.html";
      } else {
        // 登录失败，显示错误消息
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error("登录请求错误:", error);
    });
});

// secondForm.addEventListener("submit", (e) => e.preventDefault());

function did_login() {
  history.back();
}
