create table FormAcquisitions
(
	id int auto_increment,
	name varchar(255) not null,
	acquisition_method varchar(255) not null,
	budget int not null,
	email varchar(255) not null,
	phone varchar(50) not null,
	created_at datetime default CURRENT_TIMESTAMP not null,
	udpated_at datetime default CURRENT_TIMESTAMP not null,
	constraint FormAcquisitions_email_uindex
		unique (email),
	constraint FormAcquisitions_id_uindex
		unique (id),
	constraint FormAcquisitions_phone_uindex
		unique (phone)
)
;

alter table FormAcquisitions
	add primary key (id)
;

