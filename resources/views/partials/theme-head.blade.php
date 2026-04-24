<script>
    (() => {
        const storageKey = 'theme';
        const root = document.documentElement;
        let theme = 'light';

        try {
            const storedTheme = window.localStorage.getItem(storageKey);

            if (storedTheme === 'dark' || storedTheme === 'light') {
                theme = storedTheme;
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                theme = 'dark';
            }
        } catch (error) {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                theme = 'dark';
            }
        }

        const isDark = theme === 'dark';

        root.classList.toggle('dark', isDark);
        root.classList.toggle('theme-dark', isDark);
        root.classList.toggle('theme-light', !isDark);
        root.style.colorScheme = isDark ? 'dark' : 'light';
    })();
</script>
