create database uniart;
use uniart;

create table nivel_acesso(
cd_nivel int primary key auto_increment,
nm_nivel varchar(15)
);
insert into nivel_acesso(nm_nivel) 
values("Usuário");
insert into nivel_acesso(nm_nivel) 
values("Administrador");

create table tipo_arquivo(
cd_tipo int primary key auto_increment,
ds_tipo varchar(50) not null
);
insert into tipo_arquivo(ds_tipo) 
values("Vídeo");
insert into tipo_arquivo(ds_tipo) 
values("Áudio");
insert into tipo_arquivo(ds_tipo) 
values("Imagem");

create table categoria_arquivo(
cd_categoria int primary key auto_increment,
ds_categoria varchar(100),
id_tipo int,
constraint fk_tp_cate foreign key (id_tipo) references tipo_arquivo(cd_tipo)
);
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Animação","1");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Clipe Musical","1");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Processo Criativo Artistico","1");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Cultura","1");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Acappela","2");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Instrumental","2");
insert into categoria_arquivo(ds_categoria,id_tipo)
values("Genero Musical","2");
insert into categoria_arquivo(ds_categoria,id_tipo) 
values("Desenho","3");
insert into categoria_arquivo(ds_categoria,id_tipo) 
values("Fotografia","3");
insert into categoria_arquivo(ds_categoria,id_tipo) 
values("Pintura","3");


create table categoria_eventos(
cd_categoria int primary key auto_increment,
ds_categoria varchar(100)
);
insert into categoria_eventos(ds_categoria) 
values("Eventos");
insert into categoria_eventos(ds_categoria) 
values("Comunicado");
insert into categoria_eventos(ds_categoria) 
values("Vestibulinho");

create table eventos(
cd_eventos int primary key auto_increment,
ds_titulo varchar(150) not null,
ds_eventos text not null,
hr_eventos time not null,
dt_eventos date not null,
tp_eventos timestamp not null,
st_local varchar(150) not null,
ds_arquivo blob not null,
id_categoria int not null,
constraint fk_eve_cate foreign key (id_categoria) references categoria_eventos(cd_categoria)
);

create table perfil(
cd_perfil int primary key auto_increment,
nm_perfil varchar (100) not null,
nr_cell varchar(11),
ds_email varchar (60) not null,
ds_login varchar (50) not null,
ds_senha varchar (25) not null,
ds_perfil text, 
ds_imagem blob,
dt_nascimento date,
dt_entrada date,
ds_esqueceu varchar(220),
id_nivel int not null,
constraint fk_per_niv foreign key (id_nivel) references nivel_acesso(cd_nivel)
);

create table post(
cd_post int primary key auto_increment,
ds_post varchar(200),
dt_post timestamp not null,
ds_arquivo varchar(250) not null,
id_categoria int,
id_perfil int not null,
constraint fk_post_per foreign key (id_perfil) references perfil(cd_perfil),
constraint fk_post_cate foreign key (id_categoria) references categoria_arquivo(cd_categoria)
);

create table comentario(
cd_comentario int primary key auto_increment,
ds_comentario varchar(200),
dt_comentario timestamp,
id_post int,
id_perfil int,
constraint fk_comp_per foreign key (id_perfil) references perfil(cd_perfil),
constraint fk_comp_post foreign key (id_post) references post(cd_post)
);