<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-sidebar :user="'Moranguinha'"></x-sidebar>
    <x-navbar> </x-navbar>

    <section class="content"> 
        <div class="container-fluid">
            <form>
                <div class="title">Novo usuário</div> 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Nome completo</label>
                        <input type="text" class="form-control" id="input_nome_completo" placeholder="Digite seu nome completo">
                    </div> 
                    <div class="form-group col-md-12">
                        <label>Nome de usuário</label>
                        <input type="text" class="form-control" id="input_nome_usuario" placeholder="Digite seu nome de usuário">
                    </div> 
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" id="input_email" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <label>CPF/RG</label>
                        <input type="text" class="form-control" id="input_CPF_RG" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <label>Nascimento</label>
                        <input type="date" class="form-control" id="input_data_nasc" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-6">
                        <label>Senha</label>
                        <input type="password" class="form-control" id="input_senha" placeholder="Digite sua senha">
                    </div> 
                    <div class="form-group col-md-6">
                        <label>Confirmar senha</label>
                        <input type="password" class="form-control" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                    </div> 
                </div>
                <div class="text-md-right text-center">
                    <button type="reset" class="btn cancel-CM shadow-none">Cancelar</button>
                    <button type="submit" class="btn save-CM shadow-none">Salvar</button>
                </div>
            </form>
        </div> 
    </section>
    <section class="teste">
    </section>
</body>
</html>