import { API_ENDPOINTS } from "./endpoint.js";

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector('form.user');
    const errorBox = document.getElementById("errorAlert");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errorBox.classList.add("d-none");
        errorBox.textContent = "";

        const username = document.querySelector('input[name="username"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        try {
            const response = await fetch(API_ENDPOINTS.login, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (response.ok) {
                console.log("sdfsdfdsfdsfdsf")
                // Đăng nhập thành công
                window.location.href = API_ENDPOINTS.local; // hoặc route khác
            } else {
                // Hiển thị lỗi trả về từ server
                errorBox.textContent = data.message || "Đăng nhập thất bại!";
                errorBox.classList.remove("d-none");
            }
        } catch (error) {
            console.error("Lỗi khi gọi API:", error);
            errorBox.textContent = "Không thể kết nối tới máy chủ.";
            errorBox.classList.remove("d-none");
        }
    });
});