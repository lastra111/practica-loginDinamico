-- 1.  creacion de la base de datos
create database if not exists sistema_roles_dinamicos character SET utf8mb4 collate utf8mb4_unicode_ci;
USE sistema_roles_dinamicos;

-- 2. creacion de la tabla de roles
Create table roles (
	id int auto_increment primary key,
    nombre varchar(30) not null unique
    
    
)engine=InnoDB default charset=utf8 auto_increment=1000;

-- 3. tabla de usuarios con llave foraneas
create table usuario (
	id int auto_increment primary key,
    usuario varchar(50) not null unique,
    password varchar(255) not null,
    rol_id int not null,
    foreign key (rol_id) references roles(id) on delete restrict on update cascade
)engine=InnoDB default charset=utf8 auto_increment=1000;

-- 4. insersion  de datos semilla
insert into roles (id,nombre) values
 (1,'Administrador'),
(2,'Supervisor'),
(3,'Cliente');

-- 5. insercion de usuarios
-- Las contraseñas de los tres usuarios creados por defecto son las siguiente: admin123, super123, cliente123
INSERT INTO usuario (usuario, password, rol_id) VALUES 
('admin_user', '$2y$10$E9K8MxgH8vM5N3uVpL1xO.XjK3bY9h7S6R5eF4wD3cBaZ1yX2wVu.', 1),
('super_user', '$2y$10$L1xO.XjK3bY9h7S6R5eF4wD3cBaZ1yX2wVu.E9K8MxgH8vM5N3uVp', 2),
('cliente_user', '$2y$10$R5eF4wD3cBaZ1yX2wVu.E9K8MxgH8vM5N3uVpL1xO.XjK3bY9h7S6', 3);

select * from sistema_roles_dinamicos.roles;

select * from sistema_roles_dinamicos.usuario;