<?php
   $server = "190.105.205.228";
   $user = "logisticaenvapla"; 
   $passwordDB = "Log1st1@2022"; 
   $db = "logisticaenvapla_ministerio"; 
   
   $conn = new mysqli($server, $user, $passwordDB, $db);
   
   if ($conn->connect_error) {
       die("Conexión fallida: " . $conn->connect_error);
   }
   
   $sql = "UPDATE pulsadores SET estado = 0";
   $conn->query($sql);
   
   $sql = "UPDATE estado SET visitas = visitas + 1";
   $conn->query($sql);
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="HidroSense es la solución líder en riego automatizable para tu jardín. Aprovecha nuestra tecnología para un riego eficiente y sostenible.">
      <meta name="keywords" content="HidroSense, riego automatizable, jardín, tecnología, riego eficiente, sostenible">
      <meta name="author" content="Di Pietro,">	
      <meta property="og:title" content="HidroSense - Aplicación de riego automatizable">
      <meta property="og:description" content="HidroSense es la solución líder en riego automatizable para tu jardín. Aprovecha nuestra tecnología para un riego eficiente y sostenible.">
      <meta property="og:image" content="images/icono.ico">
      <title>HidroSense - Aplicación de riego automatizable</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <link rel="icon" type="image/vnd.microsoft.icon" href="images/icono.ico">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	  <style>
		body {
			margin: 0;
			padding: 0;
			z-index: 0;
		}

		body::before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: 
				url('images/hoja.png') 10% 0 no-repeat,
				url('images/gota.png') 30% 0 no-repeat,
				url('images/hoja.png') 50% 0 no-repeat,
				url('images/gota.png') 70% 0 no-repeat,
				url('images/hoja.png') 90% 0 no-repeat,
				url('images/hoja.png') 15% 15% no-repeat,
				url('images/gota.png') 35% 35% no-repeat,
				url('images/hoja.png') 55% 55% no-repeat,
				url('images/gota.png') 75% 75% no-repeat,
				url('images/hoja.png') 95% 95% no-repeat;

			background-position: 
				0 0,
				0 30%,
				0 60%,
				0 90%,
				0 120%,
				15% 15%,
				35% 35%,
				55% 55%,
				75% 75%,
				95% 95%;

			background-size: 
				50px, 25px, 
				80px, 40px, 
				70px, 60px, 
				90px, 45px, 
				60px, 30px,
				40px, 20px,
				50px, 25px,
				35px, 45px;

			animation: fall 20s linear infinite;
			opacity: 1;
			z-index: -1;
		}

		@keyframes fall {
			0% {
				background-position: 
					10% -100px, 30% -50px,
					50% 0, 70% 0,
					90% 120px,
					15% 15%,
					35% 35%,
					55% 55%,
					75% 75%,
					95% 95%;
				opacity: 1;
			}
			95% {
				opacity: 1;
			}
			100% {
				background-position: 
					10% calc(100% + 100px), 30% calc(100% + 50px),
					50% 120px, 70% 120px,
					90% 240px,
					15% calc(100% + 15px),
					35% calc(100% + 35px),
					55% calc(100% + 55px),
					75% calc(100% + 75px),
					95% calc(100% + 95px);
				opacity: 0;
			}
		}

    .notificacion {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: #f8d7daed;
      color: #b31f2d;
	  border: 1px solid #b31f2d6b;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      opacity: 1;
	  z-index:9998;
      transition: opacity 2s ease-in-out;
    }

    .notif-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .notif-subtitle {
      font-size: 14px;
    }
	  </style>
 </head>
   <body>
      <div id="preloader">
         <div id="loader"></div>
      </div>
		<div id="notificacion" class="notificacion">
		  <div class="notif-title"></div>
		  <div class="notif-subtitle"></div>
		</div>      
		<div class="info-bar">
         <div class="info-bar-links">
            <a href="#" class="info-bar-link" onclick="openModal('QuienesSomos')"><i class="fas fa-users"></i>¿Quiénes Somos?</a>
            <a href="#" class="info-bar-link" onclick="openModal('QueHacemos')"> <i class="fas fa-cogs"></i>¿Qué Hacemos?</a>
            <a href="#" class="info-bar-link" onclick="openModal('Descripcion')"> <i class="fas fa-info-circle"></i>Descripción</a>
            <a href="#" class="info-bar-link" onclick="openModal('Contacto')"> <i class="fas fa-envelope"></i>Contacto</a>
            <a href="#" class="info-bar-link" onclick="openModal('Comentarios')"> <i class="fas fa-comment"></i>Comentarios</a>
         </div>
      </div>
      <header class="header">
         <h1 class="logo"><i class="fa fa-droplet fa-sm" style="color:#007bff"></i>&nbsp;HidroSense</h1>
         <div class="menu-icon" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
         </div>
		<div class="buttons">
		  <span class="alert" id="button-state-devices-on" style="margin-bottom: 0; padding: 0.407rem 0.407rem" role="alert">
		  </span>		  
		  <span class="alert" id="button-state-devices-off" style="margin-bottom: 0; padding: 0.407rem 0.407rem; margin-left: 10px;" role="alert">
		  </span>
		  <span class="btn btn-primary" style="margin-left: 10px;" id="button-state" title="Dispositivo encendido" readonly>
			<i class="fa fa-circle" style="color:#00ff00"></i>
		  </span>
		  <button class="btn btn-primary" id="reiniciar" name="reiniciar" title="Activar reinicio">
			<i class="fa fa-rotate-right"></i>
		  </button>
		</div>
         <div class="sidebar" id="sidebar" onclick="toggleSidebar()">
            <ul>
               <li><span class="btn btn-primary" id="button-state-mob" style="width: 100%; margin-bottom: 10px; " title="Dispositivo encendido" readonly><i class="fa fa-circle" style="color:#00ff00"></i></span></li>
               <li><button class="btn btn-primary" style="width: 100%; margin-bottom: 10px;" id="reiniciar-mob" name="reiniciar-mob" title="Activar reinicio"><i class="fa fa-rotate-right"></i> Reiniciar</button></li>
               <li><span class="alert" id="button-state-devices-on-mob" style="padding: 0.407rem 0.407rem; width: 100%; text-align:center; display:block" role="alert"></span></li>
               <li><span class="alert" id="button-state-devices-off-mob" style="padding: 0.407rem 0.407rem; width: 100%; text-align:center; display:block" role="alert"></span></li>
            </ul>
         </div>
      </header>
      <div class="subheader">
         <button class="btn btn-primary active" id="pulsers" onclick="showContent(1)">Pulsadores</button>
         <button class="btn btn-primary" id="statistics" onclick="showContent(2)" id="statisticsBtn">Estadísticas</button>
         <button class="btn btn-primary" id="calendary" onclick="showContent(3)" id="calendarBtn">Calendario</button>
      </div>
      <div id="showable" style="display: none;">
         <div class="content active" id="content1">
            <h2>Pulsadores rápidos</h2>
            <p>Detener el riego en curso, activarlo o posponerlo por tiempo indicado.</p>
            <div class="row align-items-center justify-content-center">
               <div class="col">
                  <div class="card-deck" id="schedule-cards">
                     <div class="card pulser-card" role="button" style="background: #ffffffba;" tabindex="0" id="button2" onclick="performAction(2, 'stop')">
                        <div class="card-body text-center">
                           <i class="fa fa-stop fa-5x mb-3" aria-hidden="true"></i>
                           <h5 class="card-title" style="color:#212529">Detener</h5>
                           <p class="card-subtitle text-muted">Frenar riego de forma inmediata</p>
                        </div>
                     </div>
                     <div class="card pulser-card" role="button" style="background: #ffffffba;" tabindex="0" id="button1" onclick="performAction(1, 'play')">
                        <div class="card-body text-center">
                           <i class="fa fa-tint fa-5x mb-3" aria-hidden="true"></i>
                           <h5 class="card-title" style="color:#212529">Regar Ahora</h5>
                           <p class="card-subtitle text-muted">Iniciar riego de forma manual</p>
                        </div>
                     </div>
                     <div class="card pulser-card timer-card" role="button" style="background: #ffffffba;" tabindex="0" id="button3" onclick="performAction(3, 'postpone')">
                        <div class="card-body text-center">
                           <i class="fa fa-hourglass-end fa-5x mb-3" aria-hidden="true"></i>
                           <h5 class="card-title" style="margin-bottom: 0;color:#212529; height: 32px">Establecer</h5>
                           <p class="card-subtitle text-muted">Posponer de forma temporal</p>
                           <div style="margin-left: 12%; margin-right: 10%;">
                              <input type="text" id="inputTime" name="input_time" class="form-control mt-3" style="width: 100%; text-align:center" value="00:00" oninput="validateTimeInput(this)">
                              <span id="endTime" style="text-transform:uppercase; font-size:11px; color:gray"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="content" id="content2">
            <h2>Estadísticas en vivo</h2>
            <p>Se muestran estadísticas de la humedad, temperatura e intensidad lumínica.</p>
       <div class="card-deck" id="statistics">
            <div class="card humidity" style="background: #ffffffba;">
                <div class="card-body">
                    <i class="fas fa-tint" style="color:#007bff"></i>
                    <h3 class="card-title">Humedad</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="humidity-bar" style="width:0%"></div>
                    </div>
                    <div class="card-text">
                        <span id="humidity-value">0%</span>
                    </div>
                </div>
            </div>

            <div class="card temperature" style="background: #ffffffba;">
                <div class="card-body">
                    <i class="fas fa-thermometer-half" style="color:#007bff"></i>
                    <h3 class="card-title">Temperatura</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="temperature-bar" style="width:0%"></div>
                    </div>
                    <div class="card-text">
                        <span id="temperature-value">0°C</span>
                    </div>
                </div>
            </div>

            <div class="card light" style="background: #ffffffba;">
                <div class="card-body">
                    <i class="fas fa-lightbulb" style="color:#007bff"></i>
                    <h3 class="card-title">Intensidad Lumínica</h3>
                    <button class="btn light-status-btn" id="light-button" disabled></button>
                    <span class="light-status-text" id="light-status"></span>
                </div>
            </div>
        </div>

		<div class="card mb-4">
			<div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
		</div>

		<div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="myBarChart" width="100%" height="50" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
			<div class="col-lg-6">
				<div class="card mb-4">
					<div class="card-body">
						<canvas id="myPieChart" width="100%" height="50"></canvas>					
					</div>					
				</div>
			</div>
		</div>

         </div>
         <div class="content" id="content3">
            <h2>Calendario programable</h2>
            <p>Elegir entre las opciones de riego programado o automatizado.</p>
            <div class="button-cards">
               <div class="button-card" style="background: #ffffffba;">
                  <label class="card-option">
                     <input type="radio" name="option" value="option1" onclick="updateDatabase('automated')" checked>
                     <div class="card-body">
                        <div class="card-title-wrapper">
                           <h3 class="card-title">Riego automatizado</h3>
                        </div>
                        <p class="card-text">Calcula a través de sensores la cantidad adecuada de agua a aplicar por día.</p>
                     </div>
                  </label>
               </div>
               <div class="button-card" style="background: #ffffffba;">
                  <label class="card-option">
                     <input type="radio" name="option" value="option2" onclick="updateDatabase('programmable')">
                     <div class="card-body">
                        <div class="card-title-wrapper">
                           <h3 class="card-title">Riego programable</h3>
                        </div>
                        <p class="card-text">Indica la cantidad de agua y si se debe regar de manera semanal.</p>
                     </div>
                  </label>
               </div>
            </div>
			<div id="automated-card" style="display: block; margin-bottom: 50px">
			   <div class="row">
				  <div class="col-md-12">
					 <div class="card" style="background: #ffffffba;">
						<div class="card-body">
						   <form action="" method="POST" id="showable-form" class="custom-form">
							  <h4 class="card-title">Configuración de riego automatizado</h4>
							  <div class="form-group">
								 <label for="automated-water-a">Elegir programa de riego </label>
								 <div class="btn-group" id="automated-water-a" role="group" aria-label="Humedad Inicial" style="width: 100%;">
									<button type="button" class="btn btn-primary program-button" data-program="1" value="1" style="width: 33.33%; margin: 0 10px 0 0; border-radius: 3px;">
										<i class="fas fa-tint"></i> Humedecido
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="2" value="2" style="width: 33.33%; margin: 0 10px 0 10px; border-radius: 3px;">
										<i class="fas fa-cloud-rain"></i> Húmedo
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="3" value="3" style="width: 33.33%; margin: 0 0 0 10px; border-radius: 3px;">
										<i class="fas fa-umbrella"></i> Super húmedo
									</button>
								 </div>
							  </div>
							  <div class="form-group">
								 <label for="hour-start-a">Hora de inicio</label>
								 <input type="time" class="form-control input-time" id="hour-start-a" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-group">
								 <label for="hour-end-1">Hora final</label>
								 <input type="time" class="form-control input-time" id="hour-end-1" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-check">
								 <label class="form-check-label" for="irrigation1">Regar</label>
								 <input class="form-check-input" type="checkbox" id="irrigation1" style="margin-left: -56.5px;">
							  </div>
							  <div class="text-left mt-4">
								 <button type="submit" name="submit-showable" id="submit-showable" class="btn btn-primary">Confirmar</button>
							  </div>
						   </form>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div id="programmable-card" style="display: none; margin-bottom:  50px">
			   <div class="row">
				  <div class="col-md-12">
					 <div class="card" style="background: #ffffffb8;">
						<div class="card-body">
						   <form action="" method="POST" id="showable-form" class="custom-form">
							  <h4 class="card-title">
								 Riego programable del
								 <select class="form-control" style="width:auto; display: inline" id="dia" name="dia">
								 <option value="1" selected>Lunes</option>
								 <option value="2">Martes</option>
								 <option value="3">Miércoles</option>
								 <option value="4">Jueves</option>
								 <option value="5">Viernes</option>
								 <option value="6">Sábado</option>
								 <option value="7">Domingo</option>
								 </select>
							  </h4>
							  <div class="form-group">
								 <label for="automated-water-c">Elegir programa de riego </label>
								 <br>
								 <div class="btn-group" id="automated-water-c" role="group" aria-label="Humedad Inicial" style="width: 100%;">
									<button type="button" class="btn btn-primary program-button" data-program="1" value="1" style="width: 33.33%; margin: 0 10px 0 0; border-radius: 3px;">
										<i class="fas fa-tint"></i> Humedecido
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="2" value="2" style="width: 33.33%; margin: 0 10px 0 10px; border-radius: 3px;">
										<i class="fas fa-cloud-rain"></i> Húmedo
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="3" value="3" style="width: 33.33%; margin: 0 0 0 10px; border-radius: 3px;">
										<i class="fas fa-umbrella"></i> Super húmedo
									</button>
								 </div>
							  </div>
							  <div class="form-group">
								 <label for="hour-start-b">Hora de inicio</label>
								 <input type="time" class="form-control input-time" id="hour-start-b" onchange="checkTimeValidity('hour-start-b', 'hour-end-2')" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-group">
								 <label for="hour-end-2">Hora final</label>
								 <input type="time" class="form-control input-time" id="hour-end-2" onchange="checkTimeValidity('hour-start-b', 'hour-end-2')" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-check">
								 <label class="form-check-label" for="irrigation2">Regar</label>
								 <input class="form-check-input" type="checkbox" id="irrigation2" style="margin-left: -56.5px; margin-top: 6px;">
							  </div>
							  <div class="text-left mt-4">
								 <button name="submit-showable-p" id="submit-showable-p" class="btn btn-primary">Confirmar</button>
							  </div>
						   </form>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
      </div>
      </div>
      <div id="no-showable" style="display: none;">
         <div class="content" id="content4">
            <h2>Estadísticas del riego</h2>
            <p id="changeable-paragraph"></p>

				<div class="card mb-4">
					<div class="card-body"><canvas id="myAreaChart-n" width="100%" height="30"></canvas></div>
				</div>

				<div class="row">
					<div class="col-lg-6">
						<div class="card mb-4">
							<div class="card-body">
								<canvas id="myBarChart-n" width="100%" height="50"></canvas>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card mb-4">
							<div class="card-body">
								<canvas id="myPieChart-n" width="100%" height="50"></canvas>
							</div>
						</div>
					</div>
				</div>
         </div>
         <div class="content" id="content5">
            <h2>Calendario Programable</h2>
            <p>Elegir entre las opciones de riego programado o automatizado.</p>
            <div class="button-cards">
               <div class="button-card" style="background: #ffffffba;">
                  <label class="card-option">
                     <input type="radio" name="option_new" value="option1" onclick="updateDatabase('automated')" checked>
                     <div class="card-body">
                        <div class="card-title-wrapper">
                           <h3 class="card-title">Riego automatizado</h3>
                        </div>
                        <p class="card-text">Calcula a través de sensores la cantidad adecuada de agua a aplicar por día.</p>
                     </div>
                  </label>
               </div>
               <div class="button-card" style="background: #ffffffba;">
                  <label class="card-option">
                     <input type="radio" name="option_new" value="option2" onclick="updateDatabase('programmable')">
                     <div class="card-body">
                        <div class="card-title-wrapper">
                           <h3 class="card-title">Riego programable</h3>
                        </div>
                        <p class="card-text">Indica la cantidad de agua y si se debe regar de manera semanal.</p>
                     </div>
                  </label>
               </div>
            </div>
			<div id="automated-card_new" style="display: block; margin-bottom: 50px">
			   <div class="row">
				  <div class="col-md-12">
					 <div class="card" style="background: #ffffffba;">
						<div class="card-body" >
						   <form action="" method="POST" id="no-showable-form" class="custom-form">
							  <h4 class="card-title">Configuración de riego automatizado</h4>
							  <div class="form-group">
								 <label for="automated-water-1" style="margin-bottom:15px">Elegir programa de riego</label>
								 <div class="btn-group" id="automated-water-1" role="group" style="width: 100%;">
									<button type="button" class="btn btn-primary program-button" data-program="1" value="1" style="width: 33.33%; margin: 0 10px 0 0; border-radius: 3px;">
										<i class="fas fa-tint"></i> Humedecido
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="2" value="2" style="width: 33.33%; margin: 0 10px 0 10px; border-radius: 3px;">
										<i class="fas fa-cloud-rain"></i> Húmedo
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="3" value="3" style="width: 33.33%; margin: 0 0 0 10px; border-radius: 3px;">
										<i class="fas fa-umbrella"></i> Super húmedo
									</button>
								 </div>
							  </div>
							  <div class="form-group">
								 <label for="hour-start-c">Hora de inicio</label>
								 <input type="time" class="form-control input-time" id="hour-start-c" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-group">
								 <label for="hour-end-3">Hora final</label>
								 <input type="time" class="form-control input-time" id="hour-end-3" placeholder="Minutos" inputmode="numeric" required>
							  </div>
							  <div class="form-check">
								 <input class="form-check-input" type="checkbox" id="irrigation3">
								 <label class="form-check-label" for="irrigation3">Regar</label>
							  </div>
							  <div class="text-left mt-4">
								 <button type="submit" name="submit-no-showable" id="submit-no-showable" class="btn btn-primary">Confirmar</button>
							  </div>
						   </form>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div id="programmable-card_new" style="display: none; margin-bottom: 50px">
			   <div class="row">
				  <div class="col-md-12">
					 <div class="card" style="background: #ffffffb8;">
						<div class="card-body">
						   <form action="" method="POST" id="no-showable-form" class="custom-form">
							  <h4 class="card-title">
								 Riego programable del
								 <select class="form-control" style="width:auto; display: inline" id="dia_new" name="dia_new">
									<option value="1" selected>Lunes</option>
									<option value="2">Martes</option>
									<option value="3">Miércoles</option>
									<option value="4">Jueves</option>
									<option value="5">Viernes</option>
									<option value="6">Sábado</option>
									<option value="7">Domingo</option>
								 </select>
							  </h4>
							  <div class="form-group">
								<label for="automated-water-3">Elegir programa de riego</label>
								<br>
								<div class="btn-group" id="automated-water-3" role="group" style="width: 100%;">
									<button type="button" class="btn btn-primary program-button" data-program="1" value="1" style="width: 33.33%; margin: 0 10px 0 0; border-radius: 3px;">
										<i class="fas fa-tint"></i> Humedecido
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="2" value="2" style="width: 33.33%; margin: 0 10px 0 10px; border-radius: 3px;">
										<i class="fas fa-cloud-rain"></i> Húmedo
									</button>
									<button type="button" class="btn btn-primary program-button" data-program="3" value="3" style="width: 33.33%; margin: 0 0 0 10px; border-radius: 3px;">
										<i class="fas fa-umbrella"></i> Super húmedo
									</button>
								</div>
							  </div>
							  <div class="form-group">
								 <label for="hour-start-d">Hora de inicio</label>
								 <input type="time" class="form-control input-time" id="hour-start-d" inputmode="numeric" onchange="checkTimeValidity('hour-start-d', 'hour-end-4')" required>
							  </div>
							  <div class="form-group">
								 <label for="hour-end-4">Hora final</label>
								 <input type="time" class="form-control input-time" id="hour-end-4" inputmode="numeric" onchange="checkTimeValidity('hour-start-d', 'hour-end-4')" required>
							  </div>
							  <div class="form-check">
								 <input class="form-check-input" type="checkbox" id="irrigation_new">
								 <label class="form-check-label" for="irrigation_new">Regar</label>
							  </div>
							  <div class="text-left mt-4">
								 <button type="submit" name="submit-no-showable-p" id="submit-no-showable-p" class="btn btn-primary">Confirmar</button>
							  </div>
						   </form>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
         </div>
      </div>      
	  <footer class="footer">
         <p style="margin-bottom:3px; font-family: system-ui; font-size: 15px;">Derechos Reservados &copy; 2023</p>
      </footer>
      <div id="modalQuienesSomos" class="modal">
         <div class="modal-content modal-dialog">
            <span class="close-button" onclick="closeModal('QuienesSomos')">&times;</span>
            <div class="modal-content-container">
               <h3 class="modal-title">¿Quiénes Somos?</h3>
               <div class="modal-body">
                  <p>Somos un grupo de estudiantes del curso 6to Informática A, estamos conformados por Di Pietro Federico, Perla Ariana, Coquette Ignacio y Monopoli Felipe. En estos meses de trabajo realizamos un proyecto que simula un sistema de riego.</p>
                  <p>Nuestra idea surgió de la necesidad de simplificar y organizar el riego, así como el cuidado y la regulación de las plantas a través de la informática. Creemos que la tecnología puede desempeñar un papel crucial en el riego eficiente y sostenible de jardines y cultivos.</p>
               </div>
               <div class="modal-image">
                  <h1 class="logo"><i class="fa fa-droplet fa-sm" style="color:#007bff"></i>&nbsp;HidroSense</h1>
               </div>
            </div>
         </div>
      </div>
	  <div id="modalQueHacemos" class="modal">
	   <div class="modal-content modal-dialog" style="max-width: 700px; height:80%">
		  <span class="close-button" onclick="closeModal('QueHacemos')">&times;</span>
		  <div class="modal-content-container">
			 <h3 class="modal-title">¿Qué Hicimos?</h3>
			 <div class="modal-body">
				<p>El principal objetivo de nuestro proyecto es que a través de nuestros sensores y sus mediciones se ejecute o no el riego. Con nuestro sistema se puede controlar cuando y de que forma, con nuestros tres distintos programas de configuración, se activará el riego ya sea automatizado o programable en base a los datos de los sensores. Además posee pulsadores que ejecutan acciones rápidas, como son el regar en el momento, frenar el riego (cancela tanto acciones de calendario como del momento) y posponer (donde se puede configurar siempre sea mayor a 5 segundos).</p>
				<p>También le brindamos al usuario información actualizable conforme a la medición de los sensores, lo hacemos con tres distintos gráficos los cuáles indican el consumo en mA de cada componente, la cantidad de luz medida y los datos aproximados de la temperatura y humedad. Los contenidos se muestran en base a si esta conectado o no a corriente el proyecto y esto se refleja de forma inmediata en el sitio, brindando también la opción de reinicio. Todo lo anterior entra en la programación de nuestro proyecto, lo último pero no menos importante fué armar y conectar todos nuestros componentes de la siguiente forma:</p>
			 </div>
			 <div class="modal-video" style="margin-bottom:30px">
				<iframe width="100%" height="315" src="images/video.mp4" frameborder="0" allowfullscreen="true" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" mute></iframe>
			 </div>			 
			 <div class="modal-image">
				<h1 class="logo"><i class="fa fa-droplet fa-sm" style="color:#007bff"></i>&nbsp;HidroSense</h1>
			 </div>
		  </div>
	   </div>
	</div>
      <div id="modalDescripcion" class="modal">
         <div class="modal-content modal-dialog" style="max-width: 900px !important">
            <span class="close-button" onclick="closeModal('Descripcion')">&times;</span>
            <div class="modal-content-container">
               <h3 class="modal-title">Descripción del Proyecto</h3>
		<div class="modal-body">
  		 <p>Nuestro proyecto se centra en el desarrollo de un sistema de riego automatizado que brinda una amplia gama de funcionalidades para satisfacer las 	necesidades del usuario que lo use. Algunas de las características clave incluyen:</p>
		   <ul style="list-style:none">
 		     <li><b>Conexiones en la protoboard</b>: Detallamos cuidadosamente las conexiones en la protoboard de los sensores, buzzer y ESP8266, asegurando una configuración precisa y eficiente.</li>
		      <li><b>Conexión en tiempo real al sitio web</b>: A través del ESP8266 y sus componentes, logramos una conexión en tiempo real al sitio web, proporcionando a los usuarios datos actualizados de manera instantánea.</li>
 		     <li><b>Control de humedad, luz y temperatura</b>: Nuestro sistema ofrece un control preciso de la humedad, luz y temperatura del entorno, permitiendo a los usuarios ajustar estos parámetros según sus necesidades.</li>
  		    <li><b>Calendario automatizado o programable</b>: Implementamos un calendario que se puede configurar de forma automatizada o programable, permitiendo a los usuarios indicar por medio de programas de temperatura y humedad los porcentajes en los cuales debe realizarse el riego.</li>
  		    <li><b>Pulsadores rápidos</b>: Integrados en el sistema web, los pulsadores permiten acciones rápidas como regar, pausar y posponer, proporcionando un control inmediato sobre el proceso de riego.</li>
   		   <li><b>Graficos con información real actualizable</b>: Utilizamos tres distintos gráficos para mostrar información en tiempo real, incluyendo el consumo en mA de cada componente, la cantidad de luz medida y datos aproximados de temperatura y humedad.</li>
    		  <li><b>Reinicio sencillo</b>: Implementamos una opción de reinicio fácil para que los usuarios puedan restablecer el dispositivo cuando sea necesario.</li>
   		</ul>
		</div>
               <div class="modal-image">
                  <h1 class="logo"><i class="fa fa-droplet fa-sm" style="color:#007bff"></i>&nbsp;HidroSense</h1>
               </div>
            </div>
         </div>
      </div>
      <div id="modalContacto" class="modal">
         <div class="modal-content" id="modal-content-contact" style="max-height:600px;margin-top: 28px">
            <span class="close-button" onclick="closeModal('Contacto')">&times;</span>
            <h3>Contenido de Contacto</h3>
            <div class="modal-text">
               <p>Por favor, complete el siguiente formulario de contacto:</p>
               <form id="contactForm" onsubmit="return enviarMensaje()">
                  <div class="form-row">
                     <div class="form-group col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" style="text-align: center;" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" style="text-align: center;" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="asunto">Asunto:</label>
                     <input type="text" class="form-control" id="asunto" name="asunto" style="text-align: center;" required>
                  </div>
                  <div class="form-group">
                     <label for="telefono">Teléfono:</label>
                     <input type="tel" class="form-control" id="telefono" name="telefono" style="text-align: center;" required>
                     <div class="invalid-feedback">Por favor, ingrese un número de teléfono válido de 10 dígitos.</div>
                  </div>
                  <div class="form-group">
                     <label for="mensaje">Mensaje:</label>
                     <textarea class="form-control" id="mensaje" name="mensaje" style="height:130px; text-align: center;" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Enviar</button>
               </form>
            </div>
         </div>
      </div>
      <div id="modalComentarios" class="modal">
         <div class="modal-content modal-dialog" style="max-height: 500px;">
            <span class="close-button" onclick="closeModal('Comentarios')">&times;</span>
            <div class="modal-content-container">
               <h3 class="modal-title">Comentarios</h3>
               <div class="modal-body">
                  <div class="btn-group">
                     <button id="verComentarios" class="btn btn-primary active" onclick="mostrarComentarios()">Ver Comentarios</button>
                     <button id="agregarComentario" class="btn btn-primary" onclick="mostrarAgregarComentario()">Agregar Comentario</button>
                  </div>
                  <div id="comentariosContenido" style="padding-top: 20px;">
                  </div>
                  <div id="agregarComentarioContenido" style="display: none; padding-top: 20px;">
                     <h5>Agregar un Comentario</h5>
                     <form id="agregarComentarioForm">
                        <div class="form-group">
                           <label for="nombreUsuario">Nombre de Usuario:</label>
                           <input type="text" class="form-control" id="nombreUsuario" required>
                        </div>
                        <div class="form-group">
                           <label for="comentario">Comentario:</label>
                           <textarea class="form-control" id="comentario" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="js/main.js"></script>	  
	  <script> 	  
	  <?php
		$sql = "SELECT * FROM calendario WHERE flag_riega = 1 AND (id=8 OR id=9)";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()){
				$flag_tipo_riego = $row['flag_tipo_riego'];
				$flag_riega = $row['flag_riega'];
		?>
	 
		var flagTipoRiego = '<?php echo $flag_tipo_riego; ?>';
	 
		if (flagTipoRiego == '@') {
			$('input[name=option][value=option1]').prop('checked', true);
			$('input[name=option_new][value=option1]').prop('checked', true);
	 
			showAutomatedCard();
			showAutomatedCard_new();
		} else if (flagTipoRiego == '#') {
			$('input[name=option][value=option2]').prop('checked', true);
			$('input[name=option_new][value=option2]').prop('checked', true);
			showProgrammableCard();
			showProgrammableCard_new();
		}else{
			$('input[name=option][value=option1]').prop('checked', true);
			$('input[name=option_new][value=option1]').prop('checked', true);
			showAutomatedCard();
			showAutomatedCard_new();	
		}
	 
		<?php 
			}}
	  ?>
      </script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/755e6e8441.js" crossorigin="anonymous"></script>
	  <script src="js/chart-area.js"></script>
      <script src="js/chart-bar.js"></script>
      <script src="js/chart-pie.js"></script>
   </body>
</html>
<?php
   $conn->close();
   ?>