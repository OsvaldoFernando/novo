	<div class="main-wrapper main-wrapper-1">

<!--NAVBAR-->
		<?php $this->load->view('layout/navbar');?>

<!--SIDEBAR-->
		<?php $this->load->view('layout/sidebar');?>

		<!-- Main Content -->
		<div class="main-content">
			<section class="section">
				<div class="section-body">

					<!-- DataTable -->
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
<!--									Título-->
									<?php echo "<h1>" . $titulo . "</h1>";?>

								</div>

								<div class="card-body">

									<!--Botão -->
									<a href="" class="btn btn-success float-right mb-1" >+ Novo</a><br><br><br>

									<div class="table-responsive">
										<table class="table table-striped" id="table-1">
											<thead>
												<tr>
													<th>
														#
													</th>
													<th>Nome</th>
													<th>Sobrenome</th>
													<th>Usuário</th>
													<th>E-mail (Login)</th>
													<th>Estado</th>
													<th>Perfil do usuário</th>
													<th class="text-center">Operações</th>
												</tr>
											</thead>

<!--											Trazer as informações-->
											<tbody>

											<?php foreach($usuarios as $user):?>

												<tr>

													<td>
														<?php echo $user->id;?>
													</td>

													<td>
														<?php echo $user->first_name;?>
													</td>

													<td>
														<?php echo $user->last_name;?>
													</td>

													<td>
														<?php echo $user->username;?>
													</td>

													<td>
														<?php echo $user->email;?>
													</td>

													<td>
														<?php echo ($user->active == 1 ? '<span class="badge badge-success">Sim</span>':' <span class="badge badge-danger">Não</span>');?>
													</td>

													<td>
														<?php echo ($this->ion_auth->is_admin($user->id) ? 'Administrador ': 'Atendente');?>
													</td>

													<td  class="text-center">
														<a data-toggle="tooltip" title="Editar <?php echo $this->router->fetch_class();?>" href="<?php echo base_url('usuarios/core/' . $user->id) ;?>" class="btn btn-primary mr-2"><i class="far fa-edit"></i></a>
														<a data-toggle="tooltip" title="Excluír <?php echo $this->router->fetch_class();?>" href="" class="btn btn-danger"><i class="fas fa-times"></i></a>
													</td>

												</tr>

											<?php endforeach;?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
			</section>
				</div>


<!--			SIDEBAR CONFIGURAÇOES-->
			<?php $this->load->view('layout/sidebar_configuracoes');?>

		</div>
