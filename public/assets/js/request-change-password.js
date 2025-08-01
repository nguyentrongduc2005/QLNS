// request-change-password.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const errorBox = document.getElementById('errorAlert');
    const successBox = document.getElementById('successAlert');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errorBox.classList.add('d-none');
        successBox.classList.add('d-none');
        errorBox.textContent = '';
        successBox.textContent = '';

        const email = document.querySelector('input[name="email"]').value.trim();

        try {
            const response = await fetch("/request-change-password", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (response.ok) {
                successBox.textContent = 'OTP đã được gửi tới email của bạn';
                successBox.classList.remove('d-none');
            } else {
                errorBox.textContent = data.message || 'Có lỗi xảy ra';
                errorBox.classList.remove('d-none');
            }
        } catch (error) {
            console.error('Lỗi khi gọi API:', error);
            errorBox.textContent = 'Không thể kết nối tới máy chủ.';
            errorBox.classList.remove('d-none');
        }
    });
});
