// Toggle class
const navbara = document.querySelector('.navbar-a');

// Ketika hamburger-menu diklik
document.querySelector('#hamburger-menu').onclick = () => {
  navbara.classList.toggle('active');
};

// Klik di luar sidebar untuk menghilangkan sidebar
const hamburger = document.querySelector('#hamburger-menu');

document.addEventListener('click', function (e) {
  if (!hamburger.contains(e.target) && !navbara.contains(e.target)) {
    navbara.classList.remove('active');
  }
});
