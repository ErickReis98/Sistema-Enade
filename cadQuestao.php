<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<title>Cadastrar Questão</title>
		
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
			
			.tipo{
				height: 25px;
				width: 1100px;
				margin-top: 6px;
				
				border-radius: 8px;
				padding: 5px;
				background-color: white;
				
			}
			.ab{
				width: 350px;
				height 20px;
				
				float: left;
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
			
			.botao{
				
				padding-top: 5px;
				padding-left: 10px;
				width: auto;
				height: 30px;
				float:left;
				
			}
			.retorno{
				background-color: #DADADA;
				min-height: 300px;
				width: auto;
				float: left;
				padding-bottom: 20px;
				min-width: 1123px;

			}
			
			
			.inputAlternativas{
				float: left;
				height: auto;
				padding-left: 5px;
			}
			
			.content{
				display: none;
			}
		</style>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		
	</head>

	<body>
	
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Qual questão deseja cadastrar?</h1></div>
			
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
				<div class='retorno'>
			
				<form action='incluirQuestao.php' method='post' enctype="multipart/form-data">
				
		<!-- ////////////// chamada php para puxar os dados sql do banco para tornar os resultados dinamicos -->
		
				<div class='pai'>
					<div id='dynamic_field_curso' class='filha'>
						
							
									<label>Qual curso pertece essa questão?</label><br>
									<?php include_once("conexao.php");?>
										
										<select name='codCurso' required>
											<option value="">Selecione</option>
											<?php 
												$select_curso = "select * from tbcurso order by nomeCurso";
												$result_curso = mysqli_query($conn, $select_curso);
												while($linha_curso = mysqli_fetch_assoc($result_curso)){
													echo'<option value="'.$linha_curso['codCurso'].'">'.$linha_curso['nomeCurso'].'</option>';
													}
											?>
											
										</select>
										
							
							
						
					</div>
				
					
						
		<!-- ////////////// chamada php para puxar os dados sql do banco para tornar os resultados dinamicos -->
		
		
					<br>
						<div id='dynamic_field_disciplina'class='filha'>
							
									<label>Qual(is) disciplina(s) pertece essa questão?</label><br>
									
										
										<select name="codDisciplina[]" required>
											<option value="">Selecione</option>
											<?php 
												$select_disciplina = "select * from tbdisciplina order by nomeDisciplina";
												$result_disciplina = mysqli_query($conn, $select_disciplina);
												while($linha_disciplina = mysqli_fetch_assoc($result_disciplina)){
													echo'<option value="'.$linha_disciplina['codDisciplina'].'">'.$linha_disciplina['nomeDisciplina'].'</option>';
													}
											?>
											
										</select>
										<button type='button' name="addDisciplina" id="addDisciplina">+ Disciplina</button>
							
							
						
						</div>
				
				
				
			<br>
		
			<div class='filha'>
				Em qual edição essa questão foi publicada?<br>
				<input	type='number'	name='edicao' required
						id='edicao'	placeholder='Digite apenas números'>
			</div><br>
			
			<div class='filha'>
				Qual o número da questão no caderno de prova?<br>
				<input	type='number'	name='numeroQuestao' required
						id='edicao'	placeholder='Digite apenas números'>
			</div><br>
			
			<div class='filha'>
				Qual o nivel de dificuldade dessa questão?<br>
				<input type='radio'	name='nivel' value='Facil' required>Facil<br>
				<input type='radio' name='nivel' value='Medio' required>Médio<br>
				<input type='radio' name='nivel' value='Dificil'required>Difícil
				
			</div><br>
			
				<div class='filha'>
					Descreva o enunciado:<br>
					<textarea 	id="enunciado" name="enunciado" rows="4" required cols="100"
							maxlength="20000" placeholder="Escreva aqui"></textarea></textarea>
					<br><br>
				</div>
				<br>
				
				<div class='filha'>
					Anexe uma imagem para o enunciado (opcional):
					<br>
					<input 	type='file' name='anexo'>
				</div>
				
				<br>
				
				<div class='tipo'>
					<div class='ab'>Escolha o tipo de questão que deseja cadastrar:<br></div>
					<div class='ab'>
						<div class='botao' >
							<input type='radio' id='bt1' name='tipoQuestao' required value='Alternativa'>Alternativa
						</div>
						
						<div class='botao' >
							<input type='radio' id='bt2' name='tipoQuestao' required value='Dissertativa'>Dissertativa
						</div>
					</div>
				</div>
				
				<br>
				
				<div id='boxAlternativas'>
					<div class='filha'>
						Digite as alternativas:<br><br>
						Alternativa A: <br><br>
						<div class='separaBotao'>
							<div class='inputAlternativas'>
								<textarea 	id="alternativaA" name="alternativaA" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a alternativa A"></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaA' value='A' ><br>
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
									maxlength="20000" placeholder="Escreva aqui a alternativa B"></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaB' value='B'><br>
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
									maxlength="20000" placeholder="Escreva aqui a alternativa C"></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaC' value='C'><br>
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
									maxlength="20000" placeholder="Escreva aqui a alternativa D"></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaD' value='D'><br>
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
									maxlength="20000" placeholder="Escreva aqui a alternativa E"></textarea>
							</div>
							
							<div class='inputAlternativas'>
								<br>Clique no botão<br>para escolher a<br>alternativa correta<br>
								<input type='radio' name='alternativaCorreta' id='corretaE' value='E'><br>
							</div>
						</div><br><br><br><br><br><br>
						<div class=''>
						Caso a resposta tenha uma imagem voce pode anexar abaixo:<br>
						<input type='file' name='altE'>
						<br><br>
						</div>
					</div>
					
				</div>
					
					<div id='boxDissertativa' class='filha'>
						Resposta Dissertativa
						<br>
						<textarea 	id="dissertativa" name="dissertativa" rows="6" cols="120"
									maxlength="20000" placeholder="Escreva aqui a resposta dissertativa"></textarea>
					</div>
					
					<div class='submit'>
						<input type='submit' value='cadastrar' ><br><br>
						<input type="reset" value="Limpar Campos">
					</div>
					
					</form>		
				
					</div>
							
						<a href='cadastrar.html'>
						<div class="back" bgcolor='pink'>
						<img src='./img/voltar.png' height='29px' width='29px'> 
						<div class='voltar'>Voltar</div>
						</div></a>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>



</html>

			
	<!-- ///////////// JQuery adicionando a função de selects dinamicos das disciplinas-->
			
			<script type="text/javascript">
				$(document).ready(function(){
					var i = 1;
					$('#addDisciplina').click(function(){
						i++;
						
						
						$( '#dynamic_field_disciplina' ).append( '<tr id="linha'+i+'"><td><label> <select name="codDisciplina[]"> <option> Selecione...</option><?php $cont = 0; $select_disciplina = "select * from tbdisciplina order by nomeDisciplina";$result_disciplina = mysqli_query($conn, $select_disciplina); while($linha_disciplina = mysqli_fetch_assoc($result_disciplina)){echo'<option value="'.$linha_disciplina['codDisciplina'].'">'.$linha_disciplina['nomeDisciplina'].'</option>'; $cont ++;}
						?><td> &nbsp<button type="button" name="remove" id="'+i+'" class="btn_remove">remover</button></td></tr>' );
						});
					})
					
					$(document).on('click','.btn_remove', function(){
						var button_id = $(this).attr('id');
						$('#linha'+button_id+'').remove();
					});
				
				
				
				
				
				
				var div1;
				var div2;
				
				window.onload = function(){
					div1 = document.getElementById("boxAlternativas");
					div2 = document.getElementById("boxDissertativa");
					
					
					var bt1 = document.getElementById("bt1");
					bt1.onclick = mostrarDiv1;
					
					var bt2 = document.getElementById("bt2");
					bt2.onclick = mostrarDiv2;
				
					
					div1.classList.add("content");
					div2.classList.add("content");
				}
					
				function mostrarDiv1(){
					div1.classList.remove("content");
					div2.classList.add("content");
					document.getElementById("dissertativa").value = "";
					
				}
				
				function mostrarDiv2(){
					div1.classList.add("content");
					div2.classList.remove("content");
					document.getElementById("alternativaA").value = "";
					document.getElementById("alternativaB").value = "";
					document.getElementById("alternativaC").value = "";
					document.getElementById("alternativaD").value = "";
					document.getElementById("alternativaE").value = "";	
					document.getElementById("corretaA").checked = false;
					document.getElementById("corretaB").checked = false;
					document.getElementById("corretaC").checked = false;
					document.getElementById("corretaD").checked = false;
					document.getElementById("corretaE").checked = false;
					
				}
				
				 
				
				
				
				
				
			</script>
