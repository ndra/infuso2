<?

if(\Infuso\Core\superadmin::check()) {
    exec("admin");
} else {
    exec("user");
}