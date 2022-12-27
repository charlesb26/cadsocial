<?php 
$tabela = 'arquivos';
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$id = $_POST['id-arquivo'];
$nome = $_POST['nome-arq'];

$query = $pdo->query("SELECT * FROM receber where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$cliente = $res[0]['pessoa'];
}else{
	$cliente = "";
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['arquivo_conta']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../images/arquivos/' .$nome_img;

$imagem_temp = @$_FILES['arquivo_conta']['tmp_name']; 

if(@$_FILES['arquivo_conta']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip' or $ext == 'doc' or $ext == 'docx' or $ext == 'txt' or $ext == 'xlsx' or $ext == 'xlsm' or $ext == 'xls' or $ext == 'xml' ){ 

		if (@$_FILES['arquivo_conta']['name'] != ""){			

			$foto = $nome_img;
		}

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}else{
	echo 'Insira um Arquivo!';
	exit();
}

$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, setor = '1', categoria = '1',  cliente = '$cliente', data_cad = curDate(), usuario_cad = '$id_usuario', arquivo = '$foto', tipo = 'Conta à Receber', id_reg = '$id'");
	$acao = 'inserção';

$query->bindValue(":nome", "$nome");
$query->execute();
$ult_id = $pdo->lastInsertId();

echo 'Inserido com Sucesso';

//inserir log
$acao = 'inserção';
$descricao = $nome;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

?>