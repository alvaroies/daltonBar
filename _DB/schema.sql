create table noticias(
	n_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	n_tipo varchar(25) NOT NULL default '',
	n_asunto varchar(250) NOT NULL default '',
	n_html TEXT NOT NULL,
	n_fecha datetime NOT NULL,
	n_fecha_baja datetime,
	PRIMARY KEY (n_id)
);

create table files(
  f_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  f_noticia INT UNSIGNED NOT NULL,
  f_type varchar(25) NOT NULL default '',
  f_blob mediumblob NOT NULL,
  f_blob_mini mediumblob NOT NULL,
  PRIMARY KEY (f_id)
);


create table users(
	u_name varchar(25) NOT NULL,
	u_pass varchar(25) NOT NULL,
	PRIMARY KEY (u_name)
);

insert into users(u_name, u_pass) values ('admin','laGuardiaCivil69');
insert into users(u_name, u_pass) values ('alvaro','pasapadentro');
insert into users(u_name, u_pass) values ('jacker','whisky');

