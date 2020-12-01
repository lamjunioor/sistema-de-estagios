<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../connection/ConnectionFactory.php");
include_once("../data_access/coordenador/listarProfessores.php");

if(isset($_POST['buscar'])) {
	include_once("../data_access/coordenador/buscarProfessor.php");
}

if(isset($_SESSION['menu_completo'])){
	?>
	<script>
		$('#menu_coord').css({"pointer-events": "auto", "opacity": "1"});
		$('#menuitem_configAcesso').css({"pointer-events": "auto", "opacity": "1"});
	</script>
	<?php
}
?>
<html>
<header>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<!--<link href="css/simple-sidebar.css" rel="stylesheet">-->
	<title>Coor. Estágio</title>
</header>

<body>

	<div style="padding-bottom: 1%">
		<h3><span><strong>Professores</strong></span></h3>
	</div>

	<hr>

	<div id="mensagem_alerta">
		<?php
		if(isset($_SESSION['sucesso_editar'])){
			?>
			<div class="alert alert-success" role="alert">
				<?php
				echo $_SESSION['sucesso_editar'];
				unset($_SESSION['sucesso_editar']);
				?>
			</div>
			<?php
		}

		if(isset($_SESSION['erro_excluir'])){
			?>
			<div class="alert alert-danger" role="alert">
				<?php
				echo $_SESSION['erro_excluir'];
				unset($_SESSION['erro_excluir']);
				?>
			</div>
			<?php
		}
		?>
	</div>

	<form action="" method="post">
		<div class="form-group" id="div_buscar" style="float:left; width:60%">
			<input type="text" name="professor" class="form-control" id="professor" placeholder="Buscar Professor">
		</div>
		<div style="float:left; padding-left: 1%; padding-top: 8px">
			<img src="img/search.png">
		</div>
		<input type="hidden" name="buscar" value="busca">
	</form>

	<div style="float:right">
		<a href="?Pagina=cadastrarProfessor" class="btn btn-success" role="button">Cadastrar Professor</a>
	</div>


</br>
</br>
<div id="tabela_professores">
	<table class="table table-sm table-hover" id="tabela_professores">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">SIAPE</th>
				<th scope="col" style="width:20%">E-mail</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php while($linha = mysqli_fetch_assoc($_SESSION['result_professores'])){ ?>
				<tr>
					<td style="padding-top:1.3%"><?php echo $linha['nome'] ?></td>
					<td style="padding-top:1.3%"><?php echo $linha['siape'] ?></td>
					<td style="padding-top:1.3%"><?php echo $linha['email'] ?></td>
					<td style="padding-top:1.5%">
						<a href="#" data-toggle="modal" data-target="#modalVisualizar<?php echo $linha['id_professor'] ?>" style="float:right;"><img src="../view/img/visualizar.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.5%;width:5%">
						<a href="#" data-toggle="modal" data-target="#modalEditar<?php echo $linha['id_professor'] ?>" style="float:right;"><img src="../view/img/editar.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.5%;width:5%">
						<a href="#" data-toggle="modal" data-target="#modalExcluir<?php echo $linha['id_professor'] ?>" style="float:right;"><img src="../view/img/excluir.png" style="width:20px;height:20px"></a>
					</td>
				</tr>

				<!-- Modal Excluir-->
				<div class="modal fade" id="modalExcluir<?php echo $linha['id_professor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Excluir Professor</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body text-center">
								<p>O professor <strong><?php echo $linha['nome_professor'] ?></strong>, SIAPE <strong><?php echo $linha['siape']?></strong> será excluído. Deseja prosseguir?</p>
								<a href="../data_access/coordenador/excluirProfessor.php?id=<?php echo $linha['id_professor'] ?>" class="btn btn-success" style="margin:2%">Sim</a>
								<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin:2%">Não</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal Excluir-->

				<!-- Modal Visualizar-->
				<div class="modal fade" id="modalVisualizar<?php echo $linha['id_professor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><?php echo $linha['nome_professor'] ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p><strong>SIAPE: </strong><?php echo $linha['siape'] ?></p>
								<p><strong>Data de nascimento: </strong><?php echo $linha['data_nascimento'] ?></p>
								<p><strong>Sexo: </strong><?php echo $linha['sexo'] ?></p>

								<hr>

								<p><strong>Endereço</strong></p>
								<p><strong>Cidade: </strong><?php echo $linha['cidade'] ?></p>
								<p><strong>Estado: </strong><?php echo $linha['estado'] ?></p>
								<p><strong>Bairro: </strong><?php echo $linha['bairro'] ?></p>
								<p><strong>Rua: </strong><?php echo $linha['rua']?></p>
								<p><strong>Nº: </strong><?php echo $linha['numero']?></p>
								<p><strong>Cep: </strong><?php echo $linha['cep'] ?></p>

								<hr>

								<p><strong>Contato</strong></p>
								<p><strong>E-mail: </strong><?php echo $linha['email'] ?></p>
								<p><strong>Telefone: </strong><?php echo $linha['telefone'] ?></p>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal Visualizar-->

				<!-- Modal Editar-->
				<div class="modal fade bd-example-modal-lg" id="modalEditar<?php echo $linha['id_professor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Editar Professor</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="../data_access/coordenador/alterarProfessor.php" method="post">
									<input type="hidden" value="<?php echo $linha['id_professor'] ?>" name="id_professor" id="id_professor">
									<input type="hidden" value="<?php echo $linha['id_endereco'] ?>" name="id_endereco" id="id_endereco">
									<input type="hidden" value="<?php echo $linha['id_acesso'] ?>" name="id_acesso" id="id_acesso">

									<div class="form-group">
										<label for="nome_professor" style="font-weight:bold;">Nome</label>
										<input type="text" name="nome_professor" class="form-control" id="nome_professor" placeholder="Nome" style="width:50%" value="<?php echo $linha['nome_professor'] ?>">
									</div>
									<div class="form-group">
										<label for="siape" style="font-weight:bold;">SIAPE</label>
										<input type="text" minlength="9" maxlength="9" name="siape" class="form-control" id="siape<?php echo $linha['id_professor']?>" placeholder="SIAPE" value="<?php echo $linha['siape'] ?>" style="width:30%">
									</div>
									<div class="form-group">
										<label for="data_nascimento" style="font-weight:bold;">Data de nascimento</label></br>
										<div class="input-group date" style="width:25%">
											<input type="text" class="form-control" name="data_nascimento<?php echo $linha['id_professor'] ?>" id="data_nascimento<?php echo $linha['id_professor'] ?>" placeholder="Data de nascimento" value="<?php echo $linha['data_nascimento'] ?>">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="sexo_professor" style="font-weight:bold;">Sexo</label></br>
										<select class="form-control" name="sexo_professor" id="sexo_professor" style="width:20%">
											<option value="" disabled selected>Sexo</option>
											<option value="Masculino" <?php if($linha['sexo']=="Masculino"){ echo "selected";} ?>>Masculino</option>
											<option value="Feminino" <?php if($linha['sexo']=="Feminino"){ echo "selected";} ?>>Feminino</option>
										</select>
									</div>

									<hr>

									<strong><span>Endereço</span></strong>

									<div class="form-group" style="padding-top:1%">
										<label for="cidade_professor" style="font-weight:bold;">Cidade</label>
										<input type="text" name="cidade_professor" class="form-control" id="cidade_professor" placeholder="Cidade" value="<?php echo $linha['cidade'] ?>" style="width:50%">
									</div>
									<div class="form-group">
										<label for="estado_professor" style="font-weight:bold;">Estado</label></br>
										<select class="form-control" name="estado_professor" id="estado_professor" style="width:20%">
											<option value="" disabled selected>Estado</option>
											<option value="AC" <?php if($linha['estado']=="AC"){ echo "selected"; } ?>>AC</option>
											<option value="AL" <?php if($linha['estado']=="AL"){ echo "selected"; } ?>>AL</option>
											<option value="AP" <?php if($linha['estado']=="AP"){ echo "selected"; } ?>>AP</option>
											<option value="AM" <?php if($linha['estado']=="AM"){ echo "selected"; } ?>>AM</option>
											<option value="BA" <?php if($linha['estado']=="BA"){ echo "selected"; } ?>>BA</option>
											<option value="CE" <?php if($linha['estado']=="CE"){ echo "selected"; } ?>>CE</option>
											<option value="DF" <?php if($linha['estado']=="DF"){ echo "selected"; } ?>>DF</option>
											<option value="ES" <?php if($linha['estado']=="ES"){ echo "selected"; } ?>>ES</option>
											<option value="GO" <?php if($linha['estado']=="GO"){ echo "selected"; } ?>>GO</option>
											<option value="MA" <?php if($linha['estado']=="MA"){ echo "selected"; } ?>>MA</option>
											<option value="MT" <?php if($linha['estado']=="MT"){ echo "selected"; } ?>>MT</option>
											<option value="MS" <?php if($linha['estado']=="MS"){ echo "selected"; } ?>>MS</option>
											<option value="MG" <?php if($linha['estado']=="MG"){ echo "selected"; } ?>>MG</option>
											<option value="PA" <?php if($linha['estado']=="PA"){ echo "selected"; } ?>>PA</option>
											<option value="PB" <?php if($linha['estado']=="PB"){ echo "selected"; } ?>>PB</option>
											<option value="PR" <?php if($linha['estado']=="PR"){ echo "selected"; } ?>>PR</option>
											<option value="PE" <?php if($linha['estado']=="PE"){ echo "selected"; } ?>>PE</option>
											<option value="PI" <?php if($linha['estado']=="PI"){ echo "selected"; } ?>>PI</option>
											<option value="RJ" <?php if($linha['estado']=="RJ"){ echo "selected"; } ?>>RJ</option>
											<option value="RN" <?php if($linha['estado']=="RN"){ echo "selected"; } ?>>RN</option>
											<option value="RS" <?php if($linha['estado']=="RS"){ echo "selected"; } ?>>RS</option>
											<option value="RO" <?php if($linha['estado']=="RO"){ echo "selected"; } ?>>RO</option>
											<option value="RR" <?php if($linha['estado']=="RR"){ echo "selected"; } ?>>RR</option>
											<option value="SC" <?php if($linha['estado']=="SC"){ echo "selected"; } ?>>SC</option>
											<option value="SP" <?php if($linha['estado']=="SP"){ echo "selected"; } ?>>SP</option>
											<option value="SE" <?php if($linha['estado']=="SE"){ echo "selected"; } ?>>SE</option>
											<option value="TO" <?php if($linha['estado']=="TO"){ echo "selected"; } ?>>TO</option>
										</select>
									</div>
									<div class="form-group">
										<label for="bairro_professor" style="font-weight:bold;">Bairro</label>
										<input type="text" name="bairro_professor" class="form-control" id="bairro_professor" placeholder="Bairro" value="<?php echo $linha['bairro'] ?>" style="width:50%">
									</div>
									<div class="form-group">
										<label for="rua_professor" style="font-weight:bold;">Rua</label>
										<input type="text" name="rua_professor" class="form-control" id="rua_professor" placeholder="Rua" value="<?php echo $linha['rua'] ?>" style="width:50%">
									</div>
									<div class="form-group">
										<label for="numero_endereco_professor" style="font-weight:bold;">Número</label>
										<input type="text" name="numero_endereco_professor" class="form-control" id="numero_endereco_professor" placeholder="Número" value="<?php echo $linha['numero'] ?>" style="width:10%">
									</div>
									<div class="form-group">
										<label for="cep_professor" style="font-weight:bold;">CEP</label>
										<input type="text" minlength="9" maxlength="9" name="cep_professor" class="form-control" id="cep_professor<?php echo $linha['id_professor']?>" placeholder="Cep" value="<?php echo $linha['cep'] ?>" style="width:20%">
									</div>

									<hr>

									<strong><span>Contato</span></strong>

									<div class="form-group" style="padding-top:1%">
										<label for="email_professor" style="font-weight:bold;">E-mail</label>
										<input type="email" name="email_professor" class="form-control" id="email_professor" placeholder="E-mail" value="<?php echo $linha['email'] ?>" style="width:50%">
									</div>
									<div class="form-group">
										<label for="telefone_professor" style="font-weight:bold;">Telefone</label>
										<input type="text" minlength="15" maxlength="16" name="telefone_professor" class="form-control" id="telefone_professor<?php echo $linha['id_professor']?>" placeholder="Telefone" value="<?php echo $linha['telefone'] ?>" style="width:30%">
									</div>

									<hr>

									<strong><span>Acesso</span></strong>

									<div class="form-group row" style="padding-top: 1%;width: 350px">
						        <div class="col">
											<label for="senha_professor" style="font-weight:bold;">Senha</label>
						          <input type="password" name="senha_professor" id="senha_professor<?php echo $linha['id_professor'] ?>" class="form-control" placeholder="Senha" value="<?php echo $linha['senha'] ?>" minlength="8" maxlength="20">
											<small id="passwordHelpBlock" class="form-text text-muted" style="float:right;">A senha deve conter 8-20 caracteres</small>
										</div>
						      </div>
									<div class="row" id="row_password<?php echo $linha['id_professor'] ?>" style="width:700px;">
						        <div class="col">
											<label for="confirmar_senha_professor" style="font-weight:bold;">Confirmar senha</label>
						          <input type="password" name="confirmar_senha_professor" id="confirmar_senha_professor<?php echo $linha['id_professor'] ?>" class="form-control" placeholder="Confirmar senha" value="<?php echo $linha['senha'] ?>" maxlength="20">
						        </div>
						        <div id="match<?php echo $linha['id_professor'] ?>" class="col" style="padding-top:6%">
						          <p id="combina<?php echo $linha['id_professor'] ?>"><img src="img/correct.png" style="width:18px;height:18px;"></p>
						        </div>
						        <div id="no_match<?php echo $linha['id_professor'] ?>" class="col" style="display:none;padding-top:6%">
						          <p id="nao_combina<?php echo $linha['id_professor'] ?>"><img src="img/wrong.png" style="width:18px;height:18px;"></p>
						        </div>
						      </div>

									<hr>

									<div style="float:right">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<input type="submit" name="salvar" id="salvar<?php echo $linha['id_professor'] ?>" class="btn btn-success" value="Salvar">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<script type="text/javascript">
				$('#data_nascimento<?php echo $linha['id_professor']?>').datepicker({
					format: 'dd/mm/yyyy',
					language: "pt-BR",
					todayHighlight: true,
					autoclose: true
				});

				$("#siape<?php echo $linha['id_professor']?>").mask("000.000-0");
			  $("#data_nascimento<?php echo $linha['id_professor']?>").mask("00/00/0000");
			  $("#cep_professor<?php echo $linha['id_professor']?>").mask("00000-000");
			  $("#telefone_professor<?php echo $linha['id_professor']?>").mask("(00) 0 0000-0000");

				$('#senha_professor<?php echo $linha['id_professor'] ?>').bind('input propertychange',function(){
				    if($('#senha_professor<?php echo $linha['id_professor'] ?>').val() == $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val()){
				      if($('#senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0 && $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0){
				        $('#row_password<?php echo $linha['id_professor'] ?>').css("width","700px");
				        $('#match<?php echo $linha['id_professor'] ?>').css("display","block");
				        $('#no_match<?php echo $linha['id_professor'] ?>').css("display","none");
				        $('#salvar<?php echo $linha['id_professor'] ?>').prop('disabled',false);
				      }
				    }else{
				      $('#row_password<?php echo $linha['id_professor'] ?>').css("width","350px");
				      $('#no_match<?php echo $linha['id_professor'] ?>').css("display","none");
				      $('#match<?php echo $linha['id_professor'] ?>').css("display","none");
				      $('#salvar<?php echo $linha['id_professor'] ?>').prop('disabled',true);
				      if($('#senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0 && $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0){
				        $('#row_password<?php echo $linha['id_professor'] ?>').css("width","700px");
				        $('#no_match<?php echo $linha['id_professor'] ?>').css("display","block");
				      }
				    }
				  });

				  $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').bind('input propertychange',function(){
				    if($('#senha_professor<?php echo $linha['id_professor'] ?>').val() == $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val()){
				      if($('#senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0 && $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0){
				        $('#row_password<?php echo $linha['id_professor'] ?>').css("width","700px");
				        $('#match<?php echo $linha['id_professor'] ?>').css("display","block");
				        $('#no_match<?php echo $linha['id_professor'] ?>').css("display","none");
				        $('#salvar<?php echo $linha['id_professor'] ?>').prop('disabled',false);
				      }
				    }else{$('#row_password<?php echo $linha['id_professor'] ?>').css("width","350px");
				      $('#no_match<?php echo $linha['id_professor'] ?>').css("display","none");
				      $('#match<?php echo $linha['id_professor'] ?>').css("display","none");
				      $('#salvar<?php echo $linha['id_professor'] ?>').prop('disabled',true);
				      if($('#senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0 && $('#confirmar_senha_professor<?php echo $linha['id_professor'] ?>').val().length > 0){
				        $('#row_password<?php echo $linha['id_professor'] ?>').css("width","700px");
				        $('#no_match<?php echo $linha['id_professor'] ?>').css("display","block");
				      }
				    }
				  });
				</script>
				<!-- Modal Editar-->
			<?php }?>
		</tbody>
	</table>
</div>
</body>

</html>
