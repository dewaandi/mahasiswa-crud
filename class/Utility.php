<?php
// class/Utility.php
class Utility {
    public static function redirect(string $url, string $msg = ''): void {
        if ($msg) {
            $_SESSION['flash'] = $msg;
        }
        // if BASE_URL set, prepend
        $target = BASE_URL ? rtrim(BASE_URL, '/') . '/' . ltrim($url, '/') : $url;
        header("Location: " . $target);
        exit;
    }

    public static function showFlash(): void {
        if (!empty($_SESSION['flash'])) {
            echo '<p class="flash-message">' . htmlspecialchars($_SESSION['flash']) . '</p>';
            unset($_SESSION['flash']);
        }
    }

    public static function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
