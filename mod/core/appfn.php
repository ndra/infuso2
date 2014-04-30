<?

function app() {
    return \Infuso\Core\App::current();
}

function a() {
    return \Infuso\Core\App::current();
}

function service($serviceName) {
    return \mod::service($serviceName);
}



