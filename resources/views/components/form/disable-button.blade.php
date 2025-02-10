<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const submitButton = form.querySelector("button[type='submit']");

        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Отменяем стандартное поведение

            // Проверяем, была ли уже выполнена отправка
            if (submitButton.disabled) return;

            submitButton.disabled = true;
            submitButton.classList.add("opacity-50", "cursor-not-allowed");
            submitButton.innerText = "Сохраняется...";

            // Отправляем форму
            form.submit(); // Ручная отправка формы
        });
    });
</script>

