<?php

return [

	// Menú principal (layouts.material)
	'menu_title' => ':corp - <b>intranet</b>',
	'menu_profile' => 'Mi perfil',
	'menu_tickets' => 'Mis tickets',
	'menu_settings' => 'Ajustes',
	'menu_about' => 'Acerca de',
	'menu_iatickets' => 'Quejas internas',
	'menu_logout' => 'Cerrar sesión',
	'menu_admin' => 'Admin',

	'menu_mobile_home' => 'Página de inicio',

	// Añadir correo (layouts.material)
	'mail_title' => 'Añade tu correo',
	'mail_subtitle' => 'Debes añadir un correo electrónico <b>válido</b> a tu cuenta para continar:',
	'mail_label' =>'Correo electrónico',
	'mail_label_confirmation' =>'Repite el correo',
	'mail_save' => 'Guardar',
	'mail_saved' => 'Correo guardado correctamente.',

	// Página principal (home)
	'home_title' => 'Página principal',
	'home_tickets_waiting' => 'Tickets esperando',
	'home_tickets_waiting_content' => '1 ticket abierto|:num tickets abiertos',
	'home_tickets_open' => 'Tus tickets abiertos',
	'home_tickets_open_replies' => '<b>1</b> respuesta|<b>:num</b> respuestas',
	'home_links_title' => 'Enlaces rápidos',
	'home_posts_title' => 'Comunicados internos',
	'home_posts_viewmore' => 'ver más comunicados',
	'home_posts_new' => 'Nuevo',
	'home_tickets_open_title' => 'Tus tickets abiertos',


	// Lista de personal (users.list)
	'list_rank' => 'Rango',
	'list_name' => 'Nombre',
	'list_specialties' => 'Especialidades',
	'list_total' => ':num en total',
	'list_last_update' => 'última actualización :ago',

	// Especializaciones (specialties.list)
	'specialties_title' => 'Especializaciones',
	'specialties_admin_list' => 'Lista',

	// Especialización (specialties.view)
	'specialty_members' => 'Miembros (:num en total)',
	'specialty_last_update' => 'última edición :ago',
	'specialty_description' => 'Descripción',
	'specialty_members_message' => 'Mensaje solo para miembros',
	'specialty_classified' => 'Confidencial',
	'specialty_corp' => 'Cuerpo',
	'specialty_rank' => 'Rango',
	'specialty_name' => 'Nombre',
	'specialty_boss' => 'Mando:',
	'specialty_admin_edit' => 'Editar',

	// Frecuencias (frequencies.list)
	'frequencies_title' => 'Frecuencias',
	'frequencies_last_updated' => ':ago',
	'frequencies_last_updated_user' => 'Generado por :name',
	'frequencies_name' => 'Nombre',
	'frequencies_frequency' => 'Frecuencia',
	'frequencies_regenerate_title' => 'Regenerar frecuencias',
	'frequencies_regenerate_subtitle' => '<p>Como mando, puedes regenerar las frecuencias. A tener en cuenta:</p>
		      <ol>
		      	<li>Las frecuencias se regeneran para ambos servidores</li>
		      	<li>Para regenerar de cara a un reinicio, debe ser como mínimo menos 5.</li>
		      </ol>',
	'frequencies_regenerate_button' => 'Regenerar',
	'frequencies_regenerate_confirm' => '¿Regenerar frecuencias?',

	// Perfil (users.profile)
	'profile_member_since' => 'policía desde :ago',
	'profile_specialties_none' => 'Todavía no tiene especializaciones.',
	'profile_complaint_button' => 'Presentar queja',
	'profile_error' => 'reportar error',
	'profile_error_modal_title' => 'Reportar error',
	'profile_error_modal_description' => 'Si crees que hay un error en algún dato de esta página ponte en contacto con un Comisario, Coronel o Comisario Principal.',
	'profile_error_modal_close' => 'Cerrar',
	'profile_admin_edit' => 'Editar',

	// Nueva queja (tickets.new)
	'newticket_persons_label' => 'Personas de las que te quejas',
	'newticket_subject_label' => 'Asunto',
	'newticket_subject_placeholder' => 'Algo corto y explicativo',
	'newticket_body_label' => 'Descripción de los hechos',
	'newticket_body_placeholder' => 'Obligatorio aportar pruebas. Incluir todos los detalles posibles.',
	'newticket_tips' => '    <p>Consejos para hacer una buena queja:</p>
    <ol>
      <li>Incluye hora, fecha, servidor, y demás información circunstancial.</li>
      <li>Aporta pruebas poniendo entre (paréntesis) imágenes subidas a <a href="https://imgur.com">Imgur</a>, Vídeos de <a href="https://youtube.com">YouTube</a>, <a href="https://twitch.tv">Twitch</a>, <a href="http://plays.tv/">Plays TV</a>, etc.</li>
      <li>Añade en la lista de personas de las que te quejas a todos aquellos que creas que hicieron algo mal. Explica uno por uno su implicación.</li>
    </ol>
		<p><b>Toda queja debe estar apoyada por pruebas acordes al nivel de la acusación.</b></p>',

		// Detalle de comunicado (posts.view)
		'post_back' => '<< lista de comunicados',
		'post_footer' => 'Por <a href=":route">:name</a> :ago',
];
