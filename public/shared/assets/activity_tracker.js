var inactivityTimeout = 120 * 1000; // 30 seconds of inactivity
var logoutUrl = '/logout'; // Replace with your logout URL

var logoutTimer;

function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(logoutUser, inactivityTimeout);
}

function logoutUser() {
    // Perform logout action here, e.g., redirect the user to the logout URL
    window.location.href = logoutUrl;
}

function handleUserActivity() {
    resetLogoutTimer();
}

// Reset the timer whenever there's user activity
document.addEventListener('mousemove', handleUserActivity);
document.addEventListener('keypress', handleUserActivity);

// Start the timer initially
resetLogoutTimer();
