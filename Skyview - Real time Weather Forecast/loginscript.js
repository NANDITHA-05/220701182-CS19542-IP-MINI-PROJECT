document.getElementById("loginForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const errorMessage = document.getElementById("errorMessage");

  if (email === "test@example.com" && password === "password123") {
      alert("Login successful!");
      errorMessage.style.display = "none";
  } else {
      errorMessage.textContent = "Invalid email or password.";
      errorMessage.style.display = "block";
  }
  const gifs = [
    'snow.gif',
    'rain.gif',
    'sunny.gif',
    'autumn.gif'
  ];

  let currentGifIndex = 0;

  function changeBackground() {
      document.getElementById('background').style.backgroundImage = `url(${gifs[currentGifIndex]})`;
      currentGifIndex = (currentGifIndex + 1) % gifs.length; // Loop through the GIFs
  }

  // Change background every 3 seconds (3000 milliseconds)
  setInterval(changeBackground, 2000);

  // Initial call to set the first background GIF immediately
  changeBackground();
});
