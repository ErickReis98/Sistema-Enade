<!DOCTYPE html>
<html>

	<head>
		<title>Alterar Disciplina</title>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>	
	<style>
		
		
		.botao{
			float: left;
			background-color: gray;
			margin-top: 80px;
			margin-left: 11%;
			padding: 10px;
			border: 1px solid black;
			border-radius: 10px;
			color: white;
		}
		
		.separaBox{
			width: auto;
			height: 40px;
		}
	</style>
	
	
	
	
	</head>

	<body>		
	<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Alteração da disciplina</h1></div>
			
		</div>
		
		<div class='container'>
			<div class='menulateral'>
				<div class='boxMenu'>
					<a href='cadastrar.html'>Cadastrar</a><br>
						&nbsp;&nbsp; <a href='cadCurso.html'>Cadastrar Curso</a><br>
						&nbsp;&nbsp; <a href='cadDisciplina.html'>Cadastrar Disciplina</a><br>
						&nbsp;&nbsp; <a href='cadQuestao.php'>Cadastrar Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='escolherAlteracao.html'>Alterar</a><br>
						&nbsp;&nbsp; <a href='alterarCurso.php'>Alterar Curso</a><br>
						&nbsp;&nbsp; <a href='alterarDisciplina.php'>Alterar Disciplina</a><br>
						&nbsp;&nbsp; <a href='codAlterar.html'>Alterar Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='escolherExclusao.html'>Excluir</a><br>	
						&nbsp;&nbsp; <a href='excluirCurso.php'>Excluir Curso</a><br>
						&nbsp;&nbsp; <a href='excluirDisciplina.php'>Excluir Disciplina</a><br>
						&nbsp;&nbsp; <a href='codExcluir.html'>Excluir Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='consultaFiltro.php'>Consultar</a><br>
					
				</div>
			</div>
			
			
	<div class='divSub'>
			
		<div class='retorno'>
		<?php 
			include('conexao.php');
			
			$codDisciplina = $_POST["codDisciplina"];
			$nomeDisciplina = $_POST['nomeDisciplina'];
			
			$sql = 
			"update tbdisciplina set nomeDisciplina = '$nomeDisciplina'
				where codDisciplina = $codDisciplina";
		
				
				mysqli_query($conn, $sql) or 
						die ("Erro na alteração de dados" . mysqli_error($conn));
			
			
		?>
			<div class='opcoesResult'>
				A disciplina foi alterada com sucesso. O que deseja fazer?
			</div>
			
		</div>
		
		<br>
		
		<div class='separaBox'>
			
			<a href='alterarCurso.php'><div class="botao"> 
				Alterar Curso
			</div></a>
			
			<a href='alterarDisciplina.php'><div class="botao"> 
				Alterar outra disciplina
			</div></a>
			
			<a href='codAlterar.html'><div class="botao"> 
				Alterar Questão
			</div></a>
			
		</div>


	</body>



</html>