document.addEventListener("DOMContentLoaded", function () {
    // Khi click vào card chức vụ để xem chi tiết
    document.querySelectorAll(".position-card").forEach(card => {
        card.addEventListener("click", function (e) {
            // Tránh bị trigger khi bấm vào nút ba chấm
            if (e.target.closest(".dropdown")) return;

            const name = card.getAttribute("data-name");
            const salary = card.getAttribute("data-salary");
            const description = card.getAttribute("data-description");

            document.getElementById("detailPositionName").innerText = name;
            document.getElementById("detailBaseSalary").innerText = salary + " VND";
            document.getElementById("detailDescription").innerText = description;

            $("#modalDetailPosition").modal("show");
        });
    });

    // Khi click nút Thêm chức vụ
    document.getElementById("btnAddPosition").addEventListener("click", function () {
        document.getElementById("modalPositionLabel").innerText = "Thêm chức vụ";
        document.getElementById("formPosition").reset();
        document.getElementById("positionId").value = "";
        $("#modalPosition").modal("show");
    });

    // Khi click nút Sửa
    document.querySelectorAll(".btn-edit").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const card = this.closest(".position-card");
            const id = this.getAttribute("data-id");
            const name = card.getAttribute("data-name");
            const salary = card.getAttribute("data-salary");
            const description = card.getAttribute("data-description");

            document.getElementById("modalPositionLabel").innerText = "Sửa chức vụ";
            document.getElementById("positionId").value = id;
            document.getElementById("positionName").value = name;
            document.getElementById("baseSalary").value = salary;
            document.getElementById("description").value = description;

            $("#modalPosition").modal("show");
        });
    });

    // Khi click nút Xoá
    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const id = this.getAttribute("data-id");
            const confirmed = confirm("Bạn có chắc chắn muốn xoá chức vụ này?");
            if (confirmed) {
                // TODO: gọi API xoá chức vụ theo id hoặc submit form
                console.log("Xoá chức vụ có ID:", id);
            }
        });
    });
});
