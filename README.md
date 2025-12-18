# WP.Kit 🧰  
**WordPress Tools & Security Kit**

WP.Kit is a lightweight utility plugin providing reusable functions and security hardening features for your WordPress sites and other custom plugins. It’s designed to act as a shared “standard library” you can safely call from anywhere — perfect for developers managing multiple custom plugins or themes.

---

## 🚀 Features

### WordPress Support:  
- 6.8.3+

### 🔐 Security
- Disables all XML-RPC requests.
- Disables all RSS and Atom feeds site-wide.
- Removes RSS/Discovery meta tags from `<head>`.
- Provides helpers for input sanitization and visitor fingerprinting.

### 🧱 Utilities
- `wptk_saferinput()` — sanitize user input safely.
- `wptk_get_user_ip_and_browser()` — retrieve client IP and browser info.
- `wptk_get_id_by_slug()` — get a page/post ID by slug.
- `wptk_table_exists()` — check if a custom DB table exists.
- `wptk_reload_me()` — reload the current page via JavaScript.
- `wptk_get_state_options()` — generate a `<select>` list of U.S. states.

### 🎨 UX Enhancements
- Friendlier login error messaging.
- Removes “— WordPress” from the `<title>` tag.
- `wptk_remove_dashboard_widgets()` - removes WP admin dashboard widgets

---

## 🧩 Structure

```
wpkit/
│
├── wpkit.php          # Main plugin bootstrap
├── security.inc.php       # Disable RSS & XML-RPC, sanitization, IP detection
├── seo.inc.php            # Helpers related to SEO and page meta
├── tools.inc.php          # General tools helpful for WP
└── ux.inc.php             # UI/UX helpers and tweaks, state dropdown
```

Each file focuses on a single responsibility and uses the `wptk_` function prefix to avoid naming collisions.

---

## 💡 Usage

Activate **WP.Kit** like any other plugin.  
Once active, its functions are globally available in PHP.

### Example – Direct calls
```php
if (function_exists('wptk_saferinput')) {
    $email = wptk_saferinput($_POST['email'] ?? '');
    $ipinfo = wptk_get_user_ip_and_browser();
    echo 'Your IP: ' . esc_html($ipinfo['ip']);
}
```

### Example – Wait for the ready signal
Other plugins can safely wait for WP.Kit to finish loading:
```php
add_action('wptk/ready', function () {
    $slug_id = wptk_get_id_by_slug('about-us');
});
```

---

## 🧰 Developer Notes

- All functions are prefixed with `wptk_` to ensure global safety.
- Hooks and filters are applied during `init` and `plugins_loaded`.
- Functions are split into `.inc.php` modules for easy organization.
- No external dependencies — zero bloat.

If you add new helpers, keep the `wptk_` prefix and document them in this README for consistency.

---

## 🧑‍💻 Contributing

Pull requests and ideas are welcome.  
If you use WP.Kit across multiple sites, consider it your common baseline for small custom tools — security tweaks, helper functions, and admin utilities.

---

## 🪪 License

Apache License © Richard Zack <r@zack.to>
Free to use, modify, and distribute with attribution.
