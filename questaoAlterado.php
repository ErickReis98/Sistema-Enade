<!DOCTYPE html>
<html>

	<head>
	<title>Alteração da questão</title>
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
			<div class='textSup'><h1>Alteração da Questão</h1></div>
			
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
			
			$codQuestao = $_POST['codigoQuestao'];
			$pastaimg ='imgQuest/';
			$edicao =			 $_POST['edicao'];
			$tipoQuestao = 		 $_POST['tipoQuestao'];
			$numeroQuestao =	 $_POST['numeroQuestao'];
			$nivel =			 $_POST['nivel'];
			$enunciado =		 $_POST['enunciado'];
			
		
			
					
					
			// bloco para inserir questão alternativa
				
					if($tipoQuestao == "Alternativa"){
						$alternativaA =		 $_POST['alternativaA'];
						$alternativaB =		 $_POST['alternativaB'];
						$alternativaC =		 $_POST['alternativaC'];
						$alternativaD =		 $_POST['alternativaD'];
						$alternativaE =		 $_POST['alternativaE'];
						
						if(isset($_FILES['altA'])){
						$nomeAltA = $_FILES['altA']['name'];
						$tmp_name = $_FILES['altA']['tmp_name'];
						
						$error = $_FILES['altA']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
							}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAltA);
							
							}
						}else{$altA = "";}
					
						if(isset($_FILES['altB'])){
						$nomeAltB = $_FILES['altB']['name'];
						$tmp_name = $_FILES['altB']['tmp_name'];
						
						$error = $_FILES['altB']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
						}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAltB);
							
						}
					}else{$altB = "";}
					
					if(isset($_FILES['altC'])){
						$nomeAltC = $_FILES['altC']['name'];
						$tmp_name = $_FILES['altC']['tmp_name'];
						
						$error = $_FILES['altC']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
						}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAltC);
							
						}
					}else{$altC = "";}
					
					if(isset($_FILES['altD'])){
						$nomeAltD = $_FILES['altD']['name'];
						$tmp_name = $_FILES['altD']['tmp_name'];
						
						$error = $_FILES['altD']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
						}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAltD);
							
						}
					}else{$altD = "";}
					
					if(isset($_FILES['altE'])){
						$nomeAltE = $_FILES['altE']['name'];
						$tmp_name = $_FILES['altE']['tmp_name'];
						
						$error = $_FILES['altE']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
						}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAltE);
							
						}
					}	else{$altE = "";}
					
						$alternativaCorreta = $_POST['alternativaCorreta'];
						
					// Atualizar a questão na tabela tbquestao
						if(empty($anexo)){
							if($altA == "" and $altB == '' and $altC == '' and $altD == '' and $altE ==''){
						$sql = 
						"update tbquestao set
							edicao = '$edicao',
							numeroQuestao = '$numeroQuestao',
							tipoQuestao = '$tipoQuestao',
							nivel ='$nivel',
							enunciado = '$enunciado',
							alternativaA = '$alternativaA',
							alternativaB = '$alternativaB',
							alternativaC = '$alternativaC',
							alternativaD = '$alternativaD',
							alternativaE = '$alternativaE',
							alternativaCorreta = '$alternativaCorreta'
							 where 
								codQuestao = '$codQuestao'";
						
						
							
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados 1" . mysqli_error($conn));
						
								}else{
									$sql = 
						"update tbquestao set
							edicao = '$edicao',
							numeroQuestao = '$numeroQuestao',
							tipoQuestao = '$tipoQuestao',
							nivel ='$nivel',
							enunciado = '$enunciado',
							alternativaA = '$alternativaA',
							alternativaB = '$alternativaB',
							alternativaC = '$alternativaC',
							alternativaD = '$alternativaD',
							alternativaE = '$alternativaE',
							alternativaCorreta = '$alternativaCorreta'
							altA = '$altA', altB = '$altB', altC = '$altC', altD = '$altD', altE = '$altE'
							 where 
								codQuestao = '$codQuestao'";
						
						
							
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados 1" . mysqli_error($conn));
						
								}
								
							} else{
								if($altA == "" and $altB == '' and $altC == '' and $altD == '' and $altE ==''){
								$sql = 
								"update tbQuestao set
									edicao = '$edicao',
									numeroQuestao = '$numeroQuestao',
									tipoQuestao = '$tipoQuestao',
									nivel ='$nivel',
									enunciado = '$enunciado',
									anexo = '$nomeAnexo';
									alternativaA = '$alternativaA',
									alternativaB = '$alternativaB',
									alternativaC = '$alternativaC',
									alternativaD = '$alternativaD',
									alternativaE = '$alternativaE',
									alternativaCorreta = '$alternativaCorreta',
									 where 
										codQuestao = '$codQuestao'";
						
						
							
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados" . mysqli_error($conn));
						
								} else{
									$sql = 
								"update tbQuestao set
									edicao = '$edicao',
									numeroQuestao = '$numeroQuestao',
									tipoQuestao = '$tipoQuestao',
									nivel ='$nivel',
									enunciado = '$enunciado',
									anexo = '$nomeAnexo';
									alternativaA = '$alternativaA',
									alternativaB = '$alternativaB',
									alternativaC = '$alternativaC',
									alternativaD = '$alternativaD',
									alternativaE = '$alternativaE',
									alternativaCorreta = '$alternativaCorreta',
									altA = '$altA', altB = '$altB', altC = '$altC', altD = '$altD', altE = '$altE'
									 where 
										codQuestao = '$codQuestao'";
						
						
							
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados" . mysqli_error($conn));
								}
							}
							
						}
						
						// bloco para alterar questão dissertativa 
					
					else{
						
						
						if(isset($_FILES['anexoA'])){
							$nomeAnexo = $_FILES['anexoA']['name'];
							$tmp_name = $_FILES['anexoA']['tmp_name'];
							echo 'A';
							$error = $_FILES['anexoA']['error'];
							if($error !== UPLOAD_ERR_OK){
								echo 'B';
								
							}else{
								move_uploaded_file($tmp_name, $pastaimg.$nomeAnexo);
								echo 'C';
							}
						}else {
							echo '';
						}
						
						$dissertativa =		 $_POST['dissertativa'];
						
						if(empty($anexo)){
							$sql = 
							"update tbQuestao set
							edicao = '$edicao',
							numeroQuestao = '$numeroQuestao',
							tipoQuestao = '$tipoQuestao',
							nivel ='$nivel',
							enunciado = '$enunciado',
							dissertativa = '$dissertativa'
							where codQuestao = '$codQuestao'";
							echo "";
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados" . mysqli_error($conn));
						
						
						
					
						} else{
							$sql = 
							"update tbQuestao set
							edicao = '$edicao',
							numeroQuestao = '$numeroQuestao',
							tipoQuestao = '$tipoQuestao',
							nivel ='$nivel',
							enunciado = '$enunciado',
							anexo = '$nomeAnexo';
							dissertativa = '$dissertativa'
							where codQuestao = '$codQuestao'";
							echo "";
							mysqli_query($conn, $sql) or 
									die ("Erro na alteração de dados" . mysqli_error($conn));
						
						
							
						}
					}
			
			
		?>
			<div class='opcoesResult'>
				A questão foi alterada com sucesso. O que deseja fazer?
			</div>
			
		</div>
		
		<br>
		
		<div class='separaBox'>
			
			<a href='alterarCurso.php'><div class="botao"> 
				Alterar Curso
			</div></a>
			
			<a href='alterarDisciplina.php'><div class="botao"> 
				Alterar Disciplina
			</div></a>
			
			<a href='codAlterar.html'><div class="botao"> 
				Alterar outra questão
			</div></a>
			
		</div>


	</body>



</html>