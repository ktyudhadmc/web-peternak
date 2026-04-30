										<div class="d-flex flex-wrap flex-sm-nowrap mb-6">
											<div class="d-flex flex-center flex-shrink-0 bg-light rounded w-150px h-150px w-lg-150px h-lg-150px me-7 mb-4" style="height: 167px !important;width: 167px !important;">
												<img id="imgkandangdetailtop" class="mw-50px mw-lg-75px" src="<?= $this->config->item('app_url') . $datakandang->foto ?>" alt="image" />
											</div>
											<div class="flex-grow-1">
												<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
													<div class="d-flex flex-column">
														<div class="d-flex align-items-center mb-1">
															<a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3"><?= $datakandang->nama ?></a>
															<?php if ($datakandangstatus->status_kandang_activity == "AKTIF") { ?>
																<span class="badge badge-light-success me-auto"><?= $datakandangstatus->status_kandang_activity ?></span>
															<?php } else { ?>
																<span class="badge badge-light-danger me-auto"><?= $datakandangstatus->status_kandang_activity ?></span>
															<?php } ?>
														</div>
														<div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">
															Periode <?= $dataresume->periode ?> <?= $dataresume->strain ?>
														</div>
													</div>
													<div class="d-flex mb-4">

														<a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modallistuser">List User</a>
														<a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modalperiode">Select Periode</a>
														<!-- <div class="me-0">
															<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<i class="bi bi-three-dots fs-3"></i>
															</button>
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
																<div class="menu-item px-3">
																	<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
																		Payments</div>
																</div>
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Create Invoice</a>
																</div>
																<div class="menu-item px-3">
																	<a href="#" class="menu-link flex-stack px-3">Create Payment
																		<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
																</div>
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Generate Bill</a>
																</div>
																<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
																	<a href="#" class="menu-link px-3">
																		<span class="menu-title">Subscription</span>
																		<span class="menu-arrow"></span>
																	</a>
																	<div class="menu-sub menu-sub-dropdown w-175px py-4">
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Plans</a>
																		</div>
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Billing</a>
																		</div>
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Statements</a>
																		</div>
																		<div class="separator my-2"></div>
																		<div class="menu-item px-3">
																			<div class="menu-content px-3">
																				<label class="form-check form-switch form-check-custom form-check-solid">
																					<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
																					<span class="form-check-label text-muted fs-6">Recuring</span>
																				</label>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="menu-item px-3 my-1">
																	<a href="#" class="menu-link px-3">Settings</a>
																</div>
															</div>
														</div> -->
													</div>
												</div>
												<div class="d-flex flex-wrap justify-content-start">
													<?php if ($datakandangstatus->status_kandang_activity == "AKTIF") { ?>
														<div class="d-flex flex-wrap">
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= date('d M, Y', strtotime($dataresume->tanggal_chickin)) ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Tanggal Chickin</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->umur) && $dataresume->umur !== NULL ? $dataresume->umur : 0 ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Umur (Hari)</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= isset($dataresume->populasi) ? $dataresume->populasi : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Populasi (Ekor)</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->deplesi) ? $dataresume->deplesi : 0 ?> Ekor - <?= $dataresume->deplesi_persent ?> %
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Deplesi</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->ip ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Index Performance</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->act_adg) ? $dataresume->act_adg : 0; ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">ADG</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->act_fcr ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">FCR</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->rg3) ? $dataresume->rg3 : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">RG3</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->rg7) ? $dataresume->rg7 : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">RG7</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->bw !== NULL ? $dataresume->bw : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">BW</div>
															</div>
														</div>

													<?php } else { ?>
														<div class="d-flex flex-wrap">
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= date('d M, Y', strtotime($dataresume->tanggal_chickin)) ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Tanggal Chickin</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->umur_rata_panen) && $dataresume->umur_rata_panen !== NULL ? $dataresume->umur_rata_panen : 0 ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Umur Rata Panen</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= isset($dataresume->populasi_awal) ? $dataresume->populasi_awal : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Populasi Awal(Ekor)</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->deplesi) ? $dataresume->deplesi : 0 ?> Ekor - <?= $dataresume->deplesi_persent ?> %
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Deplesi</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->ip ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Index Performance</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->std_fcr) ? $dataresume->std_fcr : 0; ?>
																	</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Std FCR</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->act_fcr ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Act FCR</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->diff_fcr) ? $dataresume->diff_fcr : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Diff FCR</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder">
																		<?= isset($dataresume->panen_kg) ? $dataresume->panen_kg : 0 ?> Kg</div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">Tonase Panen</div>
															</div>
															<div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
																<div class="d-flex align-items-center">
																	<div class="fs-4 fw-bolder"><?= $dataresume->bw !== NULL ? $dataresume->bw : 0 ?></div>
																</div>
																<div class="fw-bold fs-6 text-gray-400">BW</div>
															</div>
														</div>

													<?php } ?>
													<!-- <div class="symbol-group symbol-hover mb-3">
														<?php
														$datasharing = explode(",", $datakandang->user_id_sharing);
														foreach ($datasharing as $key => $datasharings) {
															$datausers = $this->db->select('first_name,foto')->from('users')->where(['id' => $datasharings])->get()->row(); ?>
															<a href="<?= base_url("main/profile/{$datasharings}") ?>" onclick="dowaiting(this); return false;">
																<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="<?= $datausers->first_name ?>">
																	<img alt="Pic" src="<?= $this->config->item('app_url') . $datausers->foto ?>" />
																</div>
															</a>
														<?php } ?>
													</div> -->
												</div>
												<?php $this->load->view('main/_partials/modal/ternak_detail_top'); ?>
											</div>
										</div>