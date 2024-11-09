CREATE TABLE users(
    id VARCHAR(36) not null primary key,
    username VARCHAR(50) not null unique,
    password text not null
);

CREATE TABLE mensagens(
    id int not null auto_increment primary key,
    nome text not null,
    email text not null,
    telefone text not null,
    mensagem text not null
);

INSERT INTO users VALUES ('67924348-efd5-49fb-9693-a634a19539f5', 'admin', '$2y$10$tMKsnaRzPpCXqEtW2U/HHelbteTYGypN//47/gEuzGzglzAdYBkIi');
