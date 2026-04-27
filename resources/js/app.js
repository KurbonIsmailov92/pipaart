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

const submitLockSelector = 'form[data-submit-lock]:not([data-submit-lock="false"]), form[method]:not([method="GET"]):not([method="get"]):not([data-submit-lock="false"])';

const lockSubmitButtons = (form) => {
    const loadingText = form.dataset.loadingText
        || document.body?.dataset.loadingText
        || 'Processing...';

    form.dataset.submitting = 'true';

    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach((button) => {
        button.dataset.originalDisabled = button.disabled ? 'true' : 'false';

        if (button instanceof HTMLButtonElement) {
            button.dataset.originalHtml = button.innerHTML;
            button.innerHTML = `<span aria-hidden="true" class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-current border-r-transparent align-[-0.125em]"></span><span class="ml-2">${loadingText}</span>`;
        } else if (button instanceof HTMLInputElement) {
            button.dataset.originalValue = button.value;
            button.value = loadingText;
        }

        button.disabled = true;
        button.setAttribute('aria-disabled', 'true');
        button.classList.add('cursor-not-allowed', 'opacity-70');
    });
};

const resetSubmitButtons = () => {
    document.querySelectorAll(`${submitLockSelector}[data-submitting="true"]`).forEach((form) => {
        form.dataset.submitting = 'false';

        form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach((button) => {
            if (button.dataset.originalDisabled !== 'true') {
                button.disabled = false;
                button.removeAttribute('aria-disabled');
            }

            if (button instanceof HTMLButtonElement && button.dataset.originalHtml) {
                button.innerHTML = button.dataset.originalHtml;
            } else if (button instanceof HTMLInputElement && button.dataset.originalValue) {
                button.value = button.dataset.originalValue;
            }

            button.classList.remove('cursor-not-allowed', 'opacity-70');
        });
    });
};

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || !form.matches(submitLockSelector)) {
        return;
    }

    if (form.dataset.submitting === 'true') {
        event.preventDefault();

        return;
    }

    lockSubmitButtons(form);
}, true);

window.addEventListener('pageshow', resetSubmitButtons);

document.querySelectorAll('[data-mobile-nav]').forEach((menu) => {
    if (!(menu instanceof HTMLDetailsElement)) {
        return;
    }

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            menu.open = false;
        });
    });
});

document.addEventListener('click', (event) => {
    document.querySelectorAll('[data-mobile-nav][open]').forEach((menu) => {
        if (menu instanceof HTMLDetailsElement && !menu.contains(event.target)) {
            menu.open = false;
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll('[data-mobile-nav][open]').forEach((menu) => {
        if (menu instanceof HTMLDetailsElement) {
            menu.open = false;
        }
    });
});
