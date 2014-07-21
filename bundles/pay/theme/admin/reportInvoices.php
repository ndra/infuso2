<? 

admin::header("Счета (отчет)");

exec("invoices");
exec("acount");
exec("lastAccountOperations");

admin::footer();