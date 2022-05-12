<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<title>Alterar Questão</title>
		
		<style>

			.submit{
			margin-left: 50px;
			}
			
			.Sub{
				background-color: #DADADA;
				min-height: 300px;
				width: auto;
				float: left;
				padding-bottom: 20px;
				min-width: 1123px;
			}
			
			.ab{
				width: 350px;
				height 20px;
				
				float: left;
			}
			.codref{
				height: 15px;
				padding-left: 850px;
				color: white;
			}
			
			.pai{
				background-color: #093850;
				padding: 5px;
				border-radius: 15px;
				border: 1px solid black;	
				margin-bottom: 3px;
			}
			
			.filha{
				margin-top: 6px;
				border: 1px solid black;
				border-radius: 8px;
				padding: 5px;
				background-color: white;
				
			}
			
			.inputAlternativas{
				float: left;
				height: auto;
				padding-left: 5px;
			}
			
		
		
		</style>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	</head>

	<body>
		<?php
		include("conexao.php");
		
		$codQuestao = $_POST['codQuestao'];
		
		$sql = "select * from tbquestao 
			where codQuestao = $codQuestao;" ;
		
		
		$registros = mysqli_query($conn, $sql) or 
			die ("Erro" . mysqli_error($conn));
			
		$linhas = mysqli_num_rows($registros);
			if($linhas == 0){
				die("
				<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Alteração de Questão</h1></div>
			
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
			
		<div class='Sub'>
				<div class='filha'>Nehuma questão foi encontrada</div><br>
				<a href='codAlterar.html'>
				<div class='back' >
					<img src='./img/voltar.png' height='29px' width='29px'> 
					<div class='voltar'>Voltar</div>
				</div></a>
				</div>");
			}
		
		?>
	
	
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Alteração de Questão</h1></div>
			
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
			
		<div class='Sub'>
					
			
				<form action='questaoAlterado.php' method='POST'>
				
				<input type='hidden' name='codigoQuestao' value="<?php echo $codQuestao?>">
		
		<!-- ////////////// abrindo while para chamar os dados do DB -->
									
		<?php 
			$cont = 0;				
			while ($cont < $linhas){
				$dados = mysqli_fetch_array($registros);
			
		?>
					
				
				
			
			<div class='pai'>
				
				<?php 
					/*//////////////////////////////////////////////////////////////*/
					$tipo = $dados['tipoQuestao'];
					
					if($tipo == 'Alternativa'){
					
					?>
				<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
				
				<div class='filha'>
					Em qual edição essa questão foi publicada?<br>
					<input	type='text'	name='edicao'
							id='edicao'	placeholder='Digite apenas numeros'
							value="<?php echo $dados['edicao'];?>">
				</div><br>
				
				<div class='filha'>
					Qual o número da questão no caderno de prova?<br>
					<input	type='text'	name='numeroQuestao'
							id='edicao'	placeholder='Digite apenas números'
							value='<?php echo $dados['numeroQuestao'];?>'>
				</div><br>
				
				<div class='filha'>
					Qual o nivel de dificuldade dessa questão?<br>
					<input type='radio'	name='nivel' value='Facil' <?php if($dados['nivel'] == 'Facil'){echo "checked";} ?>>Facil<br>
					<input type='radio' name='nivel' value='Medio' <?php if($dados['nivel'] == 'Medio'){echo "checked";} ?>>Médio<br>
					<input type='radio' name='nivel' value='Dificil' <?php if($dados['nivel'] == 'Dificil'){echo "checked";} ?>>Difícil
					
				</div><br>
			
				<div class='filha'>
					Escreva o enunciado:<br>
					<textarea 	id="enunciado" name="enunciado" rows="4" cols="100"
							maxlength="20000" placeholder="Escreva aqui"
							><?php echo $dados['enunciado'];?></textarea>
					<br><br>
				</div>
				<br>
				
				<div class='filha'>
					<div class='anexo'>
						Anexo da questão:<b> <?php echo " ".$dados['anexo'];?> </b>
						<br>
						<br>
						<input 	type='file' name='anexoAlternativa' >
					</div>
					
					
				</div>
					
					<input type='hidden'  name='tipoQuestao' value='Alternativa'>
					
					<div id='box_alternativas'>
						<div class='filha'>
						Digite as alternativas:<br><br>
						Alternativa A: <br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaA" name="alternativaA" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa A"><?php echo "".$dados['alternativaA'];?></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaA' value='A' <?php if($dados['alternativaCorreta'] == 'A'){echo "checked";} ?>><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
						Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altA'>
						<br><br>
						</div>
					</div>
					
					<div class='filha'><br>
						Alternativa B: <br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaB" name="alternativaB" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa B"><?php echo "".$dados['alternativaB'];?></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaB' value='B' <?php if($dados['alternativaCorreta'] == 'B'){echo "checked";} ?>><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
						Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altB'>
						<br><br>
						</div>
					</div>
						
					<div class='filha'><br>
						Alternativa C:<br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaC" name="alternativaC" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa C"><?php echo "".$dados['alternativaC'];?></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaC' value='C' <?php if($dados['alternativaCorreta'] == 'C'){echo "checked";} ?>><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
						Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altC'>
						<br><br>
						</div>
					</div>
						
					<div class='filha'><br>
						Alternativa D: <br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaD" name="alternativaD" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa D"><?php echo "".$dados['alternativaD'];?></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaD' value='D' <?php if($dados['alternativaCorreta'] == 'D'){echo "checked";} ?>><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
							Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altD'>
						<br><br>
						</div>
					</div>
						
					<div class='filha'><br>
						Alternativa E: <br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaE" name="alternativaE" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa E"><?php echo "".$dados['alternativaE'];?></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaE' value='E' <?php if($dados['alternativaCorreta'] == 'E'){echo "checked";} ?>><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
						Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altE'>
						<br><br>
						</div>
					</div> <br>
					
					<div class='filha'>
						
						<div class='submit'>
							Deseja alterar essa questão ?<br><br>
							<input type='submit' value='Alterar'>
						</div>
						
					</div>
					
					
					<?php 
					
					} else if($tipo =='Dissertativa'){
					
					?>
					
					
					<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
				
				<div class='filha'>
					Em qual edição essa questão foi publicada?<br>
					<input	type='text'	name='edicao'
							id='edicao'	placeholder='Digite apenas numeros'
							value="<?php echo $dados['edicao'];?>">
				</div><br>
				
				<div class='filha'>
					Qual o número da questão no caderno de prova?<br>
					<input	type='text'	name='numeroQuestao'
							id='edicao'	placeholder='Digite apenas números'
							value='<?php echo $dados['numeroQuestao'];?>'>
				</div><br>
				
				<div class='filha'>
					Qual o nivel de dificuldade dessa questão?<br>
					<input type='radio'	name='nivel' value='Facil' <?php if($dados['nivel'] == 'Facil'){echo "checked";} ?>>Facil<br>
					<input type='radio' name='nivel' value='Medio' <?php if($dados['nivel'] == 'Medio'){echo "checked";} ?>>Médio<br>
					<input type='radio' name='nivel' value='Dificil'<?php if($dados['nivel'] == 'Dificil'){echo "checked";} ?>>Difícil
					
				</div><br>
			
				<div class='filha'>
					Escreva o enunciado:<br>
					<textarea 	id="enunciado" name="enunciado" rows="4" cols="100"
							maxlength="20000" placeholder="Escreva aqui"
							value=""><?php echo $dados['enunciado'];?></textarea>
					<br><br>
				</div>
				<br>
				
				<div class='filha'>
					<div class='anexo'>
						Anexo da questão: <?php echo " ".$dados['anexo'];?> 
						<br>
						<input 	type="file" name="anexo">
					</div>
					<br>
				</div>
				
				<div class='filha'>
					<div id='boxDissertativa' >
						<input type='hidden' name='tipoQuestao' value='Dissertativa'>
						Resposta Dissertativa
						<br>
						<textarea 	id="dissertativa" name="dissertativa" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a resposta dissertativa"><?php echo $dados['dissertativa'];?></textarea>
					</div><br>
				</div><br>
				
				<div class='filha'>
					
					<div class='submit'>
						Deseja alterar essa questão ?<br><br>
						<input type='submit' value='Alterar'>
					</div>
					
				</div>
					
					
					<?php 
					} else { ?>
						<div class='filha'>Erro ao encontrar questão</div><br>
					<?php }
					?>
					<br>
					
					
					
					</div><br>
					
				
				<a href='codAlterar.html'>
					<div class="back" bgcolor='pink'>
						<img src='./img/voltar.png' height='29px' width='29px'> 
						<div class='voltar'>Voltar</div>
					</div>
				</a>
				
				</div>
				

				
			</form>
			
			
				
			
			
		<?php 
					
	//encerra o laço while
	
	$cont++; } ?>
				
				
				</div>
			</div>
		</div>
		</div>
	</body>



</html>
