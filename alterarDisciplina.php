<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<title>Alterar Disciplina</title>
		<style>
			
			
			#box_disci{
			margin-top: 6px;
				border: 1px solid black;
				border-radius: 8px;
				padding: 5px;
				background-color: #dadada;
				margin-right: 3px;
			}
			
			.submit{
			margin-left: 50px;
			}
		</style>
	</head>

	<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Qual disciplina deseja alterar</h1></div>
			
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
			<form action='disciplinaAlterado.php' method='POST'>
				<div id='box_disci'>
					<label>Escolha a disciplina</label><br>
					<?php include_once("conexao.php");?>
					
						<select name='codDisciplina' required>
							<option value="">Selecione</option>
							<?php 
								$select_disci = "select * from tbdisciplina order by nomeDisciplina";
								$result_disci = mysqli_query($conn, $select_disci);
								while($linha_disci = mysqli_fetch_assoc($result_disci)){
									echo'<option value="'.$linha_disci['codDisciplina'].'">'.$linha_disci['nomeDisciplina'].'</option>';
									}
							?>
											
						</select><br><br>
							Alterar o nome para:<br>
							<input	type='text'			id='nomeDisciplina'
									name='nomeDisciplina'	maxlength='70'
									required			size='70'
									placeholder="Informe o nome da disciplina" >
				
				<br><br>
				<div class='submit'>
					<input type='submit' value='Alterar' >
				</div>
				
				</div><br>
				
			</form>
			
			<br>
				<a href='escolherAlteracao.html'>
				<div class="back" bgcolor='pink'>
					<img src='./img/voltar.png' height='29px' width='29px'> 
					<div class='voltar'>Voltar</div>
				</div></a>
				
			
			
		</div>	
		</div>
	</body>

</html>