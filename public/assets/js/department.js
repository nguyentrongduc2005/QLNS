// 1. Xử lý click vào card phòng ban để mở modal nhân viên
document.querySelectorAll('.department-card').forEach(card => {
    card.addEventListener('click', function (e) {
        // Nếu click vào menu ba chấm thì không xử lý
        if (e.target.closest('.department-options')) return;

        const deptId = this.dataset.id;
        const deptName = this.dataset.name;
        const filtered = employees.filter(emp => emp.department_id == deptId);

        // Gán tên phòng ban cho modal
        document.getElementById('modal-department-name').textContent = deptName;

        // Render nhân viên
        renderEmployees(filtered);

        // Hiển thị modal
        $('#modalEmployees').modal('show');

        // Bắt sự kiện tìm kiếm
        document.getElementById('searchEmployeeInput').oninput = function () {
            const keyword = this.value.toLowerCase();
            const results = filtered.filter(emp =>
                emp.ho_ten.toLowerCase().includes(keyword)
            );
            renderEmployees(results);
        };
    });
});

// 2. Hàm render danh sách nhân viên trong modal
function renderEmployees(data) {
    const tbody = document.getElementById('modal-employee-table-body');
    tbody.innerHTML = '';

    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Không có nhân viên</td></tr>`;
        return;
    }

    data.forEach((emp, i) => {
        tbody.innerHTML += `
            <tr>
                <td>${i + 1}</td>
                <td>${emp.ho_ten}</td>
                <td>${emp.email}</td>
                <td>${emp.chuc_vu}</td>
            </tr>
        `;
    });
}

// 3. Click nút "Sửa" phòng ban → mở modal sửa
document.querySelectorAll('.btn-edit-dept').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation(); // tránh lan ra card
        const deptId = this.dataset.id;
        const dept = departments.find(d => d.department_id == deptId);

        if (dept) {
            document.getElementById('editDepartmentId').value = dept.department_id;
            document.getElementById('editDepartmentName').value = dept.name;
            document.getElementById('editDepartmentDesc').value = dept.mo_ta || '';
            $('#modalEditDepartment').modal('show');
        }
    });
});

// 4. Click nút "Xoá" phòng ban
document.querySelectorAll('.btn-delete-dept').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation(); // tránh mở modal xem
        const deptId = this.dataset.id;

        if (confirm('Bạn có chắc muốn xoá phòng ban này?')) {
            deleteDepartment(deptId);
        }
    });
});
document.getElementById('addDepartmentForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const name = document.getElementById('addDepartmentName').value.trim();
    const mo_ta = document.getElementById('addDepartmentDesc').value.trim();

    if (!name) {
        alert('Tên phòng ban không được để trống!');
        return;
    }

    // TODO: Gọi API hoặc xử lý thêm vào danh sách phòng ban
    console.log('Phòng ban mới:', { name, mo_ta });

    // Reset form
    this.reset();
    $('#modalAddDepartment').modal('hide');
});

// Hàm giả lập xoá phòng ban (bạn thay bằng gọi API thực tế)
function deleteDepartment(id) {
    // TODO: Gọi API xoá phòng ban
    alert('Đã xoá phòng ban ID: ' + id);
}
