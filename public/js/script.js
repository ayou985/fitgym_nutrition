const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
  navLinks.classList.toggle('active');
});


function togglePassword() {
  const pwd = document.getElementById("password");
  pwd.type = pwd.type === "password" ? "text" : "password";
}


function toggleConfirmPassword() {
    const confirmPwd = document.getElementById("confirm-password");
    confirmPwd.type = confirmPwd.type === "password" ? "text" : "password";
}

document.querySelector("form").addEventListener("submit", function(e) {
    const pwd = document.getElementById("password").value;
    const confirm = document.getElementById("confirm-password").value;

    if (pwd !== confirm) {
        e.preventDefault();
        alert("❌ Les mots de passe ne correspondent pas !");
    }
});



