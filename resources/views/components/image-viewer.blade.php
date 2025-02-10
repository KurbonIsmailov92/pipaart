{{-- Модальное окно для просмотра изображения --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 bg-opacity-80 flex items-center justify-center hidden z-50">
    <!-- Кнопка закрытия -->
    <button class="absolute top-2 right-2 text-white text-3xl sm:text-4xl" onclick="closeImageModal()">×</button>

    <!-- Обертка модального окна с анимацией -->
    <div class="relative transform transition-all duration-500 ease-in-out max-w-full max-h-full sm:max-h-[90vh]" id="modalWrapper">
        <!-- Изображение -->
        <img id="modalImage" class="max-w-full max-h-full rounded-lg">
    </div>
</div>

<script>
    // Функция для открытия модального окна
    function showImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');

        // Увеличиваем изображение на 30%
        document.getElementById('modalWrapper').style.transform = 'scale(1.7)';
    }

    // Функция для закрытия модального окна
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        // Сбрасываем увеличение
        document.getElementById('modalWrapper').style.transform = 'scale(1)';
    }
</script>

