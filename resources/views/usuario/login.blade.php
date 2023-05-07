<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container p-6 vh-100 d-flex justify-content-center align-items-center">
        <div class="container-fluid CM min-w-CM py-5">
            <div class="row my-4 pr-4">
                <div class="col px-2 pb-2 d-xl-none">
                    <div class="logo-login-CM-md d-flex justify-content-center">
                        <img src="{{ URL::asset('/img/logo-pm-sc.png') }}" alt="Logo-SC">
                    </div>
                </div> 
            </div>
            <div class="row my-4 pr-4">
                <div class="col border-right border-gray px-2 d-none d-xl-block">
                    <div class="logo-login-CM-lg d-flex justify-content-center">
                        <img src="{{ URL::asset('/img/logo-pm-sc.png') }}" alt="Logo-SC">
                    </div>
                </div> 
                <div class="col d-flex justify-content-center align-items-center px-4">
                    <form>
                        <div class="title-login-CM d-flex justify-content-center"> Login </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-10 my-4">
                                <input type="text" class="form-control CM" id="input_nome_login" placeholder="Nome">
                            </div>
                            <div class="form-group col-10 mb-4">  
                                <input type="password" class="form-control CM" id="input_nome_login" placeholder="Senha">
                            </div>
                            <div class="form-group col-10">
                                <button type="reset" class="btn btn-lg CM save-CM btn-block shadow-none">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>