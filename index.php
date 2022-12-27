<?php
require_once("conexao.php");

//verificar scripts para executar

//rotina para limpar os logs
$data_atual = date('Y-m-d');
$data_limpeza = date('Y-m-d', strtotime("-$dias_limpar_logs days", strtotime($data_atual)));
$pdo->query("DELETE FROM logs where data < '$data_limpeza'");



//INSERIR REGISTROS INICIAIS

//Criar um Usuário ADMIN
$query = $pdo->query("SELECT * FROM usuarios");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

$senha_cript = md5('123');

if ($total_reg == 0) {
	$pdo->query("INSERT INTO usuarios SET nome = 'Administrador', cpf = '000.000.000-00', email = '$email_adm', senha_crip = '$senha_cript', senha = '123', nivel = 'Administrador', foto = 'sem-perfil.jpg', ativo = 'Sim'");
}


//inserir os cargos que geram níveis de usuários
$query = $pdo->query("SELECT * FROM cargos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO cargos SET nome = 'Gerente'");
	$pdo->query("INSERT INTO cargos SET nome = 'Operador'");
	//$pdo->query("INSERT INTO cargos SET nome = 'Secretário'");
	$pdo->query("INSERT INTO cargos SET nome = 'Digitador'");
	$pdo->query("INSERT INTO cargos SET nome = 'Usuario'");
}


//inserir uma frequencia inicial para as contas
$query = $pdo->query("SELECT * FROM frequencias");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO frequencias SET frequencia = 'Uma Vez', dias = '0'");
}


//inserir um setor inicial para os arquivos
$query = $pdo->query("SELECT * FROM setor_arquivos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'Todos'");
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'Financeiro'");
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'Secretaria'");
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'RH'");
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'Gerencial'");
	$pdo->query("INSERT INTO setor_arquivos SET nome = 'Recepção'");
}


//inserir um setor inicial para os arquivos
$query = $pdo->query("SELECT * FROM cat_arquivos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO cat_arquivos SET nome = 'Todas', setor = 1");
}



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $nome_sistema; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="icon" href="img/<?php echo $favicon ?>" type="image/x-icon">
</head>

<body>
	<main class="d-flex align-items-center min-vh-100 py-3 py-md-0">

		<div class="area">
			<ul class="circles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>


			<section class="vh-100" style="background-color: #508bfc;">
				<div class="container py-5 h-100">
					<div class="row d-flex justify-content-center align-items-center h-100">
						<div class="col-12 col-md-8 col-lg-6 col-xl-5">
							<div class="card shadow-2-strong" style="border-radius: 1rem;">
								<div class="card-body p-5 text-center">

									<div class="brand-wrapper">
										<img src="img/<?php echo $logo ?>" alt="logo" class="logo">
									</div>

									<form class="" action="autenticar.php" method="post">

										<div class="form-outline mb-4">
											<input type="text" name="usuario" id="usuario" class="form-control"
												placeholder="Email ou CPF" required>

										</div>

										<div class="form-outline mb-4">
											<input type="password" name="senha" id="senha" class="form-control"
												placeholder="***********" required>

										</div>

										<input name="login" id="login" class="btn btn-primary login-btn" type="submit" value="login" style="width: 200px; height: 50px">

										<hr class="my-4">
									</form>

									<a href="#" data-toggle="modal" data-target="#exampleModal"
										class="forgot-password-link">Recuperar Senha?</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

	</main>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<p>Recuperar Senha</p>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<input type="text" name="usuario" class="form-control" placeholder="Email ou CPF">
						</div>
					</div>
					<div class="col-md-4">
						<input name="recuperar" id="recuperar" class="btn btn-block login-btn-2 mb-4" type="button"
							value="Recuperar">
					</div>
				</div>

			</div>

		</div>
	</div>
</div>