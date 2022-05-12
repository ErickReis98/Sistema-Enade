<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		
		<title>Consulta</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			
		<style>
	 
		.separar{
			width: 406px;
			height:auto;
			border: 1px solid black;
			border-radius: 20px;
			padding: 15px;
			margin-left: 300px;
			margin-top: 10px;	
			background-color: #DADADA;			
		}
		
		.botao{
			padding-left: 33%;
		}
		.consult{
			
			background-color: white;
			height: auto;
			width: 400px;
			border: 1px solid black;
			margin-bottom: 10px;
			padding-bottom: 3px;
			padding-left: 3px;
		}
		
		.formulario{
			margin-left: 33%;
			border: 1px solid black;
			padding-left: 5px;
		}
		
		.back{
			margin-left: 200px;
		}
	 
		
		
		</style>
	
	
	
	</head>
	
	<body>
	
		<?php include('conexao.php');?>
	
	
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Realize sua consulta abaixo através dos filtros</h1></div>
			
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
			<div class='separar'>
				
				<form action='resultaConsultaFiltro.php' method='post'>
				<div id='boxEdicao' class='consult'>
					Ano/Edição do Enade:<br>
					<label>
						<select name='edicao[]'>
							<option value="0">Selecione</option>
								<?php 
									$select_edicao = "select distinct edicao from tbquestao order by edicao";
									$result_edicao = mysqli_query($conn, $select_edicao);
									while($linha_edicao = mysqli_fetch_assoc($result_edicao)){
									echo'<option value="'.$linha_edicao['edicao'].'">'.$linha_edicao['edicao'].'</option>';
									}
								?>
							
						</select>

						<button type='button' name="addEdicao" id="addEdicao">+ Edição</button>						
					</label>
					
					
				</div>
				
				<div id='boxCurso' class='consult'>
					Curso: <br>
					<select name='cursoConsult[]'>
						<label>
							<option value='0'> Selecione...</option>
								
								<?php 
									$select_curso = "select * from tbcurso order by nomeCurso";
									$result_curso = mysqli_query($conn, $select_curso);
									while($linha_curso = mysqli_fetch_assoc($result_curso)){
										echo'<option value="'.$linha_curso['codCurso'].'">'.$linha_curso['nomeCurso'].'</option>';
										}
								?>
							</select>
							<button type='button' name="addCurso" id="addCurso">+ Curso</button>
						</label>
				</div>
				
				<div id='boxDisciplina' class='consult'>
					Disciplina:<br>
					<label>
						<select name="disciConsult[]">
							<option value='0'> Selecione...</option>
								
								<?php 
									$select_disciplina = "select * from tbdisciplina order by nomeDisciplina";
									$result_disciplina = mysqli_query($conn, $select_disciplina);
									while($linha_disciplina = mysqli_fetch_assoc($result_disciplina)){
									echo'<option value="'.$linha_disciplina['codDisciplina'].'">'.$linha_disciplina['nomeDisciplina'].'</option>';
									}
								?>
							</select>
							<button type='button' name="addDisciplina" id="addDisciplina">+ Disciplina</button>			
					</label>
				</div>
				
				<div id='nivel' class='consult'>
				Nivel de dificuldade:<br>
					<input type='checkbox'	name='nivelF' value='Facil'>Facil<br>
					<input type='checkbox' name='nivelM' value='Medio'>Médio<br>
					<input type='checkbox' name='nivelD' value='Dificil'>Difícil
				</div>
				
				<div id='nivel' class='consult'>
				Tipo de questão:<br>
					<input type='checkbox'	name='alternativa' value='Alternativa'>Alternativa<br>
					<input type='checkbox' name='dissertativa' value='Dissertativa'>Dissertativa<br>
				</div>
				
				<div class='botao'>
					<button type='submit'>Consultar</button>
				</div>
				</form>
				
			
			
			</div><br>
			<a href='home.html'>
			<div class="back" bgcolor='pink'>
				<img src='./img/voltar.png' height='29px' width='29px'> 
				<div class='voltar'>Voltar</div>
			</div></a>
		</div>
			
		
		
		
	
	
	
	</div>
	</body>




			
</html>

<script type="text/javascript">
		
		//função input dinamico para o campo "edicao"
		
		$(document).ready(function(){
					var i = 1;
					$('#addEdicao').click(function(){
						i++;
						
						
						$( '#boxEdicao' ).append( '<tr id="linha'+i+'"><td><label> <select name="edicao[]"> <option> Selecione...</option><?php $select_edicao = "select distinct edicao from tbquestao order by edicao";$result_edicao = mysqli_query($conn, $select_edicao); while($linha_edicao = mysqli_fetch_assoc($result_edicao)){echo'<option value="'.$linha_edicao['edicao'].'">'.$linha_edicao['edicao'].'</option>';}
						?><td> &nbsp<button type="button" name="remove" id="'+i+'" class="btn_remove">remover</button></td></tr>' );
						});
					})
					
					$(document).on('click','.btn_remove', function(){
						var button_id = $(this).attr('id');
						$('#linha'+button_id+'').remove();
					});
		
		
		<!-- função input dinamico para o campo "curso" -->
		
			$(document).ready(function(){
					var i = 1;
					$('#addCurso').click(function(){
						i++;
						
						
						$( '#boxCurso' ).append( '<tr id="linha'+i+'"><td><label> <select name="cursoConsult[]"> <option> Selecione...</option><?php $select_curso = "select * from tbcurso order by nomeCurso";$result_curso = mysqli_query($conn, $select_curso); while($linha_curso = mysqli_fetch_assoc($result_curso)){echo'<option value="'.$linha_curso['codCurso'].'">'.$linha_curso['nomeCurso'].'</option>';}
						?><td> &nbsp<button type="button" name="remove" id="'+i+'" class="btn_remove">remover</button></td></tr>' );
						});
					})
					
					$(document).on('click','.btn_remove', function(){
						var button_id = $(this).attr('id');
						$('#linha'+button_id+'').remove();
					});
					
		<!-- função input dinamico para o campo "disciplina" -->
			
			$(document).ready(function(){
					var i = 1;
					$('#addDisciplina').click(function(){
						i++;
						
						
						$( '#boxDisciplina' ).append( '<tr id="linha'+i+'"><td><label> <select name="disciConsult[]"> <option> Selecione...</option><?php $cont = 0; $select_disciplina = "select * from tbdisciplina order by nomeDisciplina";$result_disciplina = mysqli_query($conn, $select_disciplina); while($linha_disciplina = mysqli_fetch_assoc($result_disciplina)){echo'<option value="'.$linha_disciplina['codDisciplina'].'">'.$linha_disciplina['nomeDisciplina'].'</option>'; $cont ++;}
						?><td> &nbsp<button type="button" name="remove" id="'+i+'" class="btn_remove">remover</button></td></tr>' );
						});
					})
					
					$(document).on('click','.btn_remove', function(){
						var button_id = $(this).attr('id');
						$('#linha'+button_id+'').remove();
					});
		
</script>