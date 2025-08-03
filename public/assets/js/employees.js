// Định nghĩa các endpoint toàn cục
const BASE_URL = window.location.origin + "/QLDA/public";

const API_ENDPOINTS = {
    //employees.js
    EMP_CREATE: `${BASE_URL}/api/employees/create`,
    EMP_DELETE: (id) => `${BASE_URL}/api/employees/delete/${id}`,
    EMP_UPDATE: (id) => `${BASE_URL}/api/employees/update/${id}`,


    // Thêm các endpoint khác nếu có...
};

document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll('.employee-row');
    const searchInput = document.getElementById('searchInput');
    let currentEmployeeId = null;

    // Modal hiển thị chi tiết
    rows.forEach(row => {
        row.addEventListener('click', () => {
            document.getElementById('modalName').value = row.dataset.name;
            document.getElementById('modalEmail').value = row.dataset.email;
            document.getElementById('modalPhone').value = row.dataset.phone;
            document.getElementById('modalGender').value = row.dataset.gender;
            document.getElementById('modalAddress').value = row.dataset.address;
            document.getElementById('modalBirthday').value = row.dataset.birthday;
            currentEmployeeId = row.dataset.id; // Gán id khi click

            document.getElementById('modalStartDate').value = row.dataset.startdate;
            document.getElementById('modalDept').value = row.dataset.department;
            document.getElementById('modalPosition').value = row.dataset.position;
        });
    });

    // Sự kiện submit form "Thêm mới"
    document.getElementById('addEmployeeForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(API_ENDPOINTS.EMP_CREATE, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm nhân viên thành công');
                    location.reload();
                } else {
                    alert(data.message || 'Thêm thất bại');
                }
            })
            .catch(error => console.error('Lỗi khi thêm:', error));
    });

    // Tìm kiếm
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        rows.forEach(row => {
            const name = row.dataset.name.toLowerCase();
            const email = row.dataset.email.toLowerCase();
            row.style.display = (name.includes(keyword) || email.includes(keyword)) ? '' : 'none';
        });
    });

    // Xóa nhân viên
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
                const id = this.dataset.id;
                fetch(API_ENDPOINTS.EMP_DELETE(id), {
                    method: 'POST'
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Đã xóa');
                            location.reload();
                        } else {
                            alert(data.message || 'Không thể xóa');
                        }
                    })
                    .catch(error => console.error('Lỗi khi xóa:', error));
                // Loại bỏ alert lặp lại để tránh thông báo dư thừa
                // alert("Xóa nhân viên ID " + id); // Đã comment để tránh lặp
            }
        });
    });

    function enableEditMode() {
        $('#employeeModal input').prop('readonly', false);
        $('#employeeModal select').prop('disabled', false);
        $('#btnSaveEdit, #btnCancelEdit').removeClass('d-none');
        $('#btnEditMode').addClass('d-none');
    }

    function disableEditMode() {
        $('#employeeModal input').prop('readonly', true);
        $('#employeeModal select').prop('disabled', true);
        $('#btnSaveEdit, #btnCancelEdit').addClass('d-none');
        $('#btnEditMode').removeClass('d-none');
    }

    // Sự kiện cho nút "Huỷ"
    document.getElementById('btnCancelEdit').addEventListener('click', () => {
        disableEditMode();
    });

    // Sự kiện khi bấm nút "Chỉnh sửa"
    document.getElementById('btnEditMode').addEventListener('click', () => {
        enableEditMode();
    });

    // Sự kiện cho nút "Lưu"
    document.getElementById('btnSaveEdit').addEventListener('click', function () {
        if (!currentEmployeeId) {
            alert('Vui lòng chọn một nhân viên để chỉnh sửa!');
            return;
        }
        const form = document.getElementById('editEmployeeForm');
        const formData = new FormData(form);
        fetch(API_ENDPOINTS.EMP_UPDATE(currentEmployeeId), {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật thành công');
                    disableEditMode();
                    location.reload();
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => console.error('Lỗi khi cập nhật:', error));
    });
});