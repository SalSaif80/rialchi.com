const translations = JSON.parse(document.querySelector('#rialchi-translations')?.textContent || '{}');
export function t(key, replacements = {}) {
    return (translations[key] ?? key).replace(/:([a-z_]+)/g, (match, name) => String(replacements[name] ?? match));
}
