// profile.js
document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.querySelector('.btn-user');  // The "Edit" button
    const updateSection = document.querySelector('.update-section'); // Form section to update profile

    toggleButton.addEventListener('click', () => {
        if (updateSection.style.display === 'none') {
            updateSection.style.display = 'block';
        } else {
            updateSection.style.display = 'none';
        }
    });
});
