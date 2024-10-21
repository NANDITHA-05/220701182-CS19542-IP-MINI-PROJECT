document.addEventListener("DOMContentLoaded", function() {
function typeTitle(text, elementId, speed) {
    let i = 0;
    function type() {
        if (i < text.length) {
            document.getElementById(elementId).innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    type();
}

// Show the front page after 5 seconds
setTimeout(function() {
    // Hide loading screen
    document.getElementById('loading-screen').style.display = 'none';

    // Show the main content
    document.getElementById('main-content').style.display = 'flex'; // Display the main content

    // Start typing the title
    typeTitle('Welcome to Skyview!', 'animated-title', 100); // Title will be typed in real-time
}, 2000); // 2 seconds (5,000 milliseconds)
function setActiveLink(event) {
    // Remove the active class from all links
    const links = document.querySelectorAll('.nav-link');
    links.forEach(link => {
        link.classList.remove('active');
    });
    
    // Add the active class to the clicked link
    event.target.classList.add('active');
}
})
