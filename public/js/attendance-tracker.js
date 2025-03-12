function formatTime(timeString) {
    if (!timeString) return;
    const [hours, minutes] = timeString.split(":"); // Extract hours and minutes
    const formattedTime = new Date(0, 0, 0, hours, minutes).toLocaleTimeString(
        "en-US",
        {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
        }
    );
    return formattedTime;
}

function isValidDate(dateString) {
    const date = new Date(dateString);

    // Check if the date object is valid
    if (isNaN(date.getTime())) {
        return false;
    }

    // Extract the year, month, and day from the input
    const [year, month, day] = dateString.split("-").map(Number);

    // Check if the reconstructed date matches the input
    return date.getFullYear() === year &&
        date.getMonth() + 1 === month && // Months are 0-based in JS
        date.getDate() === day
        ? date
        : false;
}
