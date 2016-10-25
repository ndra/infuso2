<?

if(\Infuso\Core\Superadmin::check()) {
    exec("admin");
} else {
    exec("user");
}