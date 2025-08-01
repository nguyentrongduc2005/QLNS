document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#changePasswordForm");
    const errorBox = document.getElementById("errorAlert");

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Prevent form submission

        // Clear previous error message
        errorBox.classList.add("d-none");
        errorBox.textContent = "";

        // Get form data
        const currentPassword = document.querySelector('#current_password').value.trim();
        const newPassword = document.querySelector('#new_password').value.trim();
        const confirmPassword = document.querySelector('#confirm_password').value.trim();
        const otp = document.querySelector('#otp').value.trim();

        // Validate passwords
        if (newPassword !== confirmPassword) {
            errorBox.classList.remove("d-none");
            errorBox.textContent = "Mật khẩu mới và xác nhận mật khẩu không khớp";
            return;
        }

        if (!currentPassword || !newPassword || !confirmPassword || !otp) {
            errorBox.classList.remove("d-none");
            errorBox.textContent = "Vui lòng điền đầy đủ thông tin";
            return;
        }

        // Prepare the data for the request
        const data = {
            current_password: currentPassword,
            new_password: newPassword,
            otp: otp
        };

        try {
            // Send request to the server
            const response = await fetch('/api/change-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                // Password changed successfully
                alert("Đổi mật khẩu thành công!");
                // You can redirect to the profile or any other page if needed
                window.location.href = "/profile"; // Redirect to profile page
            } else {
                // Show error message from the server
                errorBox.classList.remove("d-none");
                errorBox.textContent = result.message || "Có lỗi xảy ra, vui lòng thử lại";
            }

        } catch (error) {
            // If request fails
            errorBox.classList.remove("d-none");
            errorBox.textContent = "Không thể kết nối tới máy chủ. Vui lòng thử lại.";
        }
    });
});
