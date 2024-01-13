// 登录按钮
const signInBtn = document.getElementById("toSignIn");

//     注册按钮
const signUpBtn = document.getElementById("toSignUp");

const signUpForm = document.getElementById("signUpForm");

const container = document.querySelector(".container");


// 登录按钮监听器
signInBtn.addEventListener("click", () => {//自上而下解析=>onload
    console.log(signInBtn); // 这应该输出相应的DOM元素
    container.classList.remove("right-panel-active");
    console.log("remove the class")
});

signUpBtn.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

// 假设你的登录表单中的输入字段有正确的id：'email'和'password'
signUpForm.addEventListener("submit", (e) => e.preventDefault());
// 提交登录表单
signUpForm.addEventListener("submit", (e) => {
    e.preventDefault(); // 阻止表单默认提交

    // 获取用户输入的邮箱和密码
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const formData = new FormData(signUpForm);
    fetch("login.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = 'index.html';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("登录请求错误:", error);
        })
        .then((response) => {
            alert('登录成功');
            window.location.href = 'index.html';
            if (data.error) {
                // 处理登录失败的情况
                alert(data.error);
            } else if (data.user) {
                console.log(data.user);

                // 登录成功，存储用户信息到 Session Storage
                sessionStorage.setItem("email", data.user.email);
                sessionStorage.setItem("name", data.user.name);

                // 在此处执行页面跳转等操作
                // 比如：window.location.href = 'userDashboard.html';
            }
        })
        .catch((error) => {
            console.error("登录请求错误:", error);
        })
});


// secondForm.addEventListener("submit", (e) => e.preventDefault());

function did_login() {
    history.back()
}
