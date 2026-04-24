import './bootstrap';
import.meta.glob([
    '../images/**'
]);

const themeStorageKey = 'theme';
const root = document.documentElement;
const darkMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

const readStoredTheme = () => {
    try {
        const storedTheme = window.localStorage.getItem(themeStorageKey);

        return storedTheme === 'dark' || storedTheme === 'light'
            ? storedTheme
            : null;
    } catch (error) {
        return null;
    }
};

const resolveTheme = () => readStoredTheme() ?? (darkMediaQuery.matches ? 'dark' : 'light');

const updateThemeControls = (theme) => {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');

        const label = button.querySelector('[data-theme-label]');

        if (label) {
            label.textContent = theme === 'dark' ? 'Dark' : 'Light';
        }
    });
};

const applyTheme = (theme) => {
    const isDark = theme === 'dark';

    root.classList.toggle('dark', isDark);
    root.classList.toggle('theme-dark', isDark);
    root.classList.toggle('theme-light', !isDark);
    root.style.colorScheme = isDark ? 'dark' : 'light';

    updateThemeControls(theme);
};

const persistTheme = (theme) => {
    try {
        window.localStorage.setItem(themeStorageKey, theme);
    } catch (error) {
        // Ignore storage errors and keep the in-memory theme state.
    }
};

applyTheme(resolveTheme());

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.classList.contains('theme-dark') ? 'light' : 'dark';

        persistTheme(nextTheme);
        applyTheme(nextTheme);
    });
});

const handleSystemThemeChange = (event) => {
    if (readStoredTheme() !== null) {
        return;
    }

    applyTheme(event.matches ? 'dark' : 'light');
};

if (typeof darkMediaQuery.addEventListener === 'function') {
    darkMediaQuery.addEventListener('change', handleSystemThemeChange);
} else if (typeof darkMediaQuery.addListener === 'function') {
    darkMediaQuery.addListener(handleSystemThemeChange);
}
