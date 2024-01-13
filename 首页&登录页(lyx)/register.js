//btn的id是register  form的id是signInForm
const signupBtn = document.getElementById("toSignUp");

// 绑定注册按钮事件
document.getElementById("signInForm").addEventListener("submit", handleSignUp);


// 绑定失去焦点事件
const usernameInput = document.getElementById("username");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const confirmInput = document.getElementById("confirm_password");

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
    document.getElementById("s_username").innerText = flag_username ? "" : "用户名格式有误";
    return flag_username;
}

function validateEmail(email) {
    var reg_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    var flag_email = reg_email.test(email);
    document.getElementById("s_email").innerText = flag_email ? "" : "邮箱格式有误,请输入真实邮箱";
    return flag_email;
}

function validatePassword(password) {
    var reg_password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,16}$/;
    var flag_password = reg_password.test(password);
    document.getElementById("s_password").innerText = flag_password ? "" : "密码格式有误";
    return flag_password;
}

function validateConfirmPassword(confirm_password) {
    var password = document.getElementById("password").value;
    var flag_confirm_password = password === confirm_password;
    document.getElementById("s_confirm_password").innerText = flag_confirm_password ? "" : "密码不匹配";
    return flag_confirm_password;
}

//处理注册函数
//btn的id是register  form的id是signInForm

function handleSignUp(event) {
    console.log("ggggg");
    event.preventDefault(); // 阻止表单默认提交

    var username = usernameInput.value;
    var email = emailInput.value;
    var password = passwordInput.value;
    var confirm_password = confirmInput.value;

    // 执行所有验证
    let isValid =
        validateUsername(username) &&
        validateEmail(email) &&
        validatePassword(password) &&
        validateConfirmPassword(confirm_password);

    // 如果所有项都验证通过
    if (isValid) {
        alert("注册成功！");
// 创建一个 XMLHttpRequest 对象
        let xhr = new XMLHttpRequest();

// 指定请求的方法和URL
        xhr.open('POST', 'register.php');

// 设置请求头
        xhr.setRequestHeader('Content-Type', 'application/json');

// 设置响应事件
        xhr.onreadystatechange = function () {
// 如果请求完成并且成功
            if (xhr.readyState === 4 && xhr.status === 200) {
// 获取响应的数据
                let data = JSON.parse(xhr.responseText);
// 处理响应的数据
                console.log(data);

                xhr.send(JSON.stringify(data));
            }
        };

// 发送请求
    }
}