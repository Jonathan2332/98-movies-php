insert into perfil (nome) values('Usuário');
insert into perfil (nome) values('Administrador');

insert into endereco(cep, uf, complemento, bairro, localidade) values('72236-800', 'DF', 'Rua novo horizionte', 'Ceilândia Sul', 'Brasília');
insert into endereco(cep, uf, complemento, bairro, localidade) values('72215-058', 'DF', 'Ceilanda', 'Ceilândia Sul', 'Brasília');
insert into endereco(cep, uf, complemento, bairro, localidade) values('01001-000', 'SP', 'lado ímpar', 'Sé', 'São Paulo');

insert into usuario (idPerfil, idEndereco, nome,sobrenome,email,senha,data_nasc,telefone,sexo,celular) values (2, 1, 'Admin','Moderador','admin@gmail.com','123','2017-06-15','(00)0000-0000','M','(00)00000-0000');
insert into usuario (idPerfil, idEndereco, nome,sobrenome,email,senha,data_nasc,telefone,sexo,celular) values (1, 2, 'João','Barro','joao@gmail.com','123','1997-02-13','(61)3543-54354','M','(61)95654-4565');
insert into usuario (idPerfil, idEndereco, nome,sobrenome,email,senha,data_nasc,telefone,sexo,celular) values (1, 3, 'Maria','Fumaça','maria@gmail.com','123','1998-01-30','(62)3354-4515','F','(62)98653-6546');

INSERT INTO usuario_categoria VALUES (1,28);
INSERT INTO usuario_categoria VALUES (1,10749);
INSERT INTO usuario_categoria VALUES (1,14);
INSERT INTO usuario_categoria VALUES (2,16);
INSERT INTO usuario_categoria VALUES (2,12);
INSERT INTO usuario_categoria VALUES (2,35);
INSERT INTO usuario_categoria VALUES (3,35);
INSERT INTO usuario_categoria VALUES (3,12);
INSERT INTO usuario_categoria VALUES (3,10749);

insert into favorito(idFilme, idUsuario) values (474350, 1);
insert into favorito(idFilme, idUsuario) values (2, 1);
insert into favorito(idFilme, idUsuario) values (3, 1);
insert into favorito(idFilme, idUsuario) values (475557, 1);

SET FOREIGN_KEY_CHECKS=0;
truncate table endereco;
truncate table perfil;
truncate table usuario;
truncate table usuario_categoria;
truncate table favorito;
truncate table foto;
truncate table interesse;
truncate table favorito;
truncate table permissao;
truncate table pagina;
SET FOREIGN_KEY_CHECKS=1;