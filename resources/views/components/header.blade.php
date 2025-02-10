<header class="bg-blue-950 text-white px-4 py-3 mt-2 relative z-50">
    <x-navigation>
        <!-- Лого -->
        <x-logo></x-logo>
        <!-- Ссылки -->
        <x-header-links>

            <!-- ОИПБА РТ -->
            <x-dropdown buttonHref="/oipba" buttonText="ОИПБА РТ">
                <x-dropdown-link href="/oipba/work" text="Деятельность"/>
                <x-dropdown-link href="/oipba/membership" text="Членство"/>
                <x-dropdown-link href="/oipba/partners" text="Партнеры"/>
                <x-dropdown-link href="/oipba/customers" text="Клиенты"/>
                <x-dropdown-link href="/oipba/collective" text="Сотрудники"/>
                <x-dropdown-link href="/oipba/gallery" text="Фотогалерея"/>
{{--                <x-dropdown-link href="/oipba/in-our-memory" text="В память о Нашем Абире Хушбахтовиче"/>--}}
            </x-dropdown>

            <!-- КУРСЫ -->
            <x-dropdown buttonHref="/courses" buttonText="КУРСЫ">
                <x-dropdown-link href="/courses/list" text="Перечень курсов"/>
                <x-dropdown-link href="/courses/schedule" text="Расписание"/>
                <x-dropdown-link href="/courses/reviews" text="Отзывы"/>
                <x-dropdown-link href="/courses/registration" text="Онлайн регистрация"/>
                <x-dropdown-link href="/courses/training-centers" text="Учебные центры"/>
            </x-dropdown>

            <!-- CIPA -->
            <x-dropdown buttonHref="/cipa" buttonText="CIPA">
                <x-dropdown-link href="/cipa/schedule" text="Расписание"/>
                <x-dropdown-link href="/cipa/registration" text="Регистрация"/>
                <x-dropdown-link href="/cipa/appeal" text="Апелляция"/>
                <x-dropdown-link href="/cipa/rules" text="Правила проведения экзаменов CIPA"/>
                <x-dropdown-link href="/cipa/id" text="ИД (ID)"/>
                <x-dropdown-link href="/cipa/certification" text="Сертификация"/>
                <x-dropdown-link href="/cipa/certificates" text="Реестр Сертификатов"/>
            </x-dropdown>

            <!-- GARP -->
            <x-dropdown buttonHref="/garp" buttonText="GARP">
                <x-dropdown-link href="/garp/schedule" text="Расписание"/>
                <x-dropdown-link href="/garp/registration" text="Регистрация"/>
                <x-dropdown-link href="/garp/certification" text="Сертификация"/>
                <x-dropdown-link href="/garp/topic" text="Тематика"/>
            </x-dropdown>

            <!-- А&М -->
            <x-dropdown buttonHref="/am" buttonText="A&M">
                <x-dropdown-link href="/am/" text="Пункт 1"/>
                <x-dropdown-link href="/am/" text="Пункт 2"/>
                <x-dropdown-link href="/am/" text="Пункт 3"/>
                <x-dropdown-link href="/am/" text="Пункт 4"/>
            </x-dropdown>

            <!-- БИБЛИОТЕКА -->
            <x-dropdown buttonHref="/library" buttonText="БИБЛИОТЕКА">
                <x-dropdown-link href="/library/docs" text="Нормативные документы"/>
                <x-dropdown-link href="/library/books" text="Книги"/>
                <x-dropdown-link href="/library/for-cipa" text="Материалы для экзамена CIPA"/>
                <x-dropdown-link href="/library/links" text="Полезные ссылки"/>
            </x-dropdown>

            <!-- ВАКАНСИИ -->
            <x-dropdown buttonHref="/job" buttonText="ВАКАНСИИ">
                <x-dropdown-link href="/library/need-worker" text="Требуется"/>
                <x-dropdown-link href="/library/need-job" text="Ищу работу"/>
            </x-dropdown>

            <!-- НОВОСТИ -->
            <x-dropdown buttonHref="/news/list" buttonText="НОВОСТИ"></x-dropdown>

            <!-- КОНТАКТЫ -->
            <x-dropdown buttonHref="/contacts" buttonText="КОНТАКТЫ">
                <x-dropdown-link href="/contacts/info" text="Адреса, социальные сети и телефоны"/>
                <x-dropdown-link href="/contacts/message" text="Написать нам"/>
            </x-dropdown>

        </x-header-links>
    </x-navigation>
</header>
